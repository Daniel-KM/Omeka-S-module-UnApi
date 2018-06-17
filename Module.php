<?php
namespace UnApi;

use UnApi\Form\ConfigForm;
use Omeka\Module\AbstractModule;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Mvc\Controller\AbstractController;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;

class Module extends AbstractModule
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        parent::onBootstrap($event);
        $this->addAclRules();
    }

    public function install(ServiceLocatorInterface $serviceLocator)
    {
        $settings = $serviceLocator->get('Omeka\Settings');
        $this->manageSettings($settings, 'install');
    }

    public function uninstall(ServiceLocatorInterface $serviceLocator)
    {
        $settings = $serviceLocator->get('Omeka\Settings');
        $this->manageSettings($settings, 'uninstall');
    }

    public function upgrade($oldVersion, $newVersion, ServiceLocatorInterface $serviceLocator)
    {
        if (version_compare($oldVersion, '1.1.0', '<')) {
            $config = require __DIR__ . '/config/module.config.php';
            $defaultSettings = $config[strtolower(__NAMESPACE__)]['config'];
            $settings = $serviceLocator->get('Omeka\Settings');
            $settings->set('unapi_public_server',
                $defaultSettings['unapi_public_server']);
        }
    }

    protected function manageSettings($settings, $process, $key = 'config')
    {
        $config = require __DIR__ . '/config/module.config.php';
        $defaultSettings = $config[strtolower(__NAMESPACE__)][$key];
        foreach ($defaultSettings as $name => $value) {
            switch ($process) {
                case 'install':
                    $settings->set($name, $value);
                    break;
                case 'uninstall':
                    $settings->delete($name);
                    break;
            }
        }
    }

    protected function addAclRules()
    {
        $services = $this->getServiceLocator();
        $settings = $services->get('Omeka\Settings');
        $publicServer = $settings->get('unapi_public_server', true);
        if ($publicServer) {
            $acl = $services->get('Omeka\Acl');
            $acl->allow(null, Controller\IndexController::class, ['index']);
        }
    }

    public function attachListeners(SharedEventManagerInterface $sharedEventManager)
    {
        $settings = $this->getServiceLocator()->get('Omeka\Settings');

        if ($settings->get('unapi_public_server')) {
            $sharedEventManager->attach(
                'Omeka\Controller\Site\Item',
                'view.layout',
                [$this, 'addUnApiServerLink']
            );
            $sharedEventManager->attach(
                'Omeka\Controller\Site\Item',
                'view.browse.after',
                [$this, 'appendUnApiIds']
            );
            $sharedEventManager->attach(
                'Omeka\Controller\Site\Item',
                'view.show.after',
                [$this, 'appendUnApiId']
            );
        }

        $sharedEventManager->attach(
            'Omeka\Controller\Admin\Item',
            'view.layout',
            [$this, 'addUnApiServerLink']
        );
        $sharedEventManager->attach(
            'Omeka\Controller\Admin\Item',
            'view.browse.after',
            [$this, 'appendUnApiIds']
        );
        $sharedEventManager->attach(
            'Omeka\Controller\Admin\Item',
            'view.show.after',
            [$this, 'appendUnApiId']
        );
    }

    public function getConfigForm(PhpRenderer $renderer)
    {
        $services = $this->getServiceLocator();
        $config = $services->get('Config');
        $settings = $services->get('Omeka\Settings');
        $form = $services->get('FormElementManager')->get(ConfigForm::class);

        $data = [];
        $defaultSettings = $config[strtolower(__NAMESPACE__)]['config'];
        foreach ($defaultSettings as $name => $value) {
            $value = $settings->get($name);
            $data[$name] = $value;
        }

        $form->init();
        $form->setData($data);
        $html = $renderer->formCollection($form);
        return $html;
    }

    public function handleConfigForm(AbstractController $controller)
    {
        $services = $this->getServiceLocator();
        $config = $services->get('Config');
        $settings = $services->get('Omeka\Settings');

        $params = $controller->getRequest()->getPost();

        $form = $services->get('FormElementManager')->get(ConfigForm::class);
        $form->init();
        $form->setData($params);
        if (!$form->isValid()) {
            $controller->messenger()->addErrors($form->getMessages());
            return false;
        }

        $defaultSettings = $config[strtolower(__NAMESPACE__)]['config'];
        foreach ($params as $name => $value) {
            if (array_key_exists($name, $defaultSettings)) {
                $settings->set($name, $value);
            }
        }
    }

    public function addUnApiServerLink(Event $event)
    {
        $event->getTarget()->headLink([
            'rel' => 'unapi-server',
            'type' => 'application/xml',
            'title' => 'unAPI',
            'href' => $event->getTarget()->url('unapi'),
        ]);
    }

    public function appendUnApiIds(Event $event)
    {
        $items = $event->getTarget()->items;
        foreach ($items as $item) {
            echo sprintf('<abbr class="unapi-id" title="%s"></abbr>', $item->id());
        }
    }

    public function appendUnApiId(Event $event)
    {
        $item = $event->getTarget()->item;
        echo sprintf('<abbr class="unapi-id" title="%s"></abbr>', $item->id());
    }
}
