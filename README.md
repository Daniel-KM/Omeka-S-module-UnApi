unAPI (module for Omeka S)
==========================

[unAPI] is a module for [Omeka S] that implements the [unAPI protocol] and
allows to access to a [rdf/xml] representation of each item.

From the [original description]:
> unAPI is a tiny HTTP API for the few basic operations necessary to copy
> discrete, identified content from any kind of web application.
>
> There are already many cool APIs and protocols for syndicating, searching,
> harvesting, and linking > from diverse services on the web. They're great, and
> they're widely used, but they're all different, for different reasons. unAPI
> only provides the few basic operations necessary to perform simple
> clipboard-like copy of content objects across all sites. It can be quickly
> implemented, consistently used, and easily layered over other well-known APIs.

This protocol has two main interests.

- First, it is supported by [Zotero], the leading free open source bibliographic
  application and service, so metadata that are exposed by Omeka can be
  automatically collected in it or in any compliant application.

- Second, it allows to access directly to the metadata graph of the item in the
  [rdf/xml] format, so it can be processed by any semantic tool, even if they
  don't support unAPI.

If you don't need the rdf/xml, or if you want to support more bibliographic
tools, you may install [COinS], another bibliographic protocol supported by
Zotero and many other bibliographic tools.

If you just need to share data with other cataloging applications, you may want
to install [OAI-PMH Repository].


Installation
------------

The module can be installed via the released zip, or via the source.

See general end user documentation for [Installing a module].

* From the zip

Download the last release [`UnApi.zip`] from the list of releases, and
uncompress it in the `modules` directory.

* From the source and for development

If the module was installed from the source, rename the name of the folder of
the module to `UnApi`.

* Configuration

The admin may choose to open metadata to identified users only or to public too.


Usage
-----

Simply open an item page and fetch metadata with your bibliographic application.
It works on the page `item/browse` too.

Or simply specify the id of an item as an argument to the unapi base url:
`https://example.com/unapi?id=1&format=rdf_dc`. Only the format `rdf_dc` is
supported currently.


TODO
----

- Limit rdf_dc to Dublin Core.
- Use a persistant identifier (i.e. `dcterms:identifier`) instead of an internal
  id.


Warning
-------

Use it at your own risk.

It’s always recommended to backup your files and your databases and to check
your archives regularly so you can roll back if needed.


Troubleshooting
---------------

See online issues on the [module issues] page on GitHub.


License
-------

This plugin is published under [GNU/GPL].

This program is free software; you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation; either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT
ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
details.

You should have received a copy of the GNU General Public License along with
this program; if not, write to the Free Software Foundation, Inc.,
51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.


Contact
-------

Current maintainers:

* [Roy Rosenzweig Center for History & New Media]


Copyright
---------

* Copyright Roy Rosenzweig Center for History & New Media, 2015-2017
* Copyright Daniel Berthereau, 2018 ([Daniel-KM])


[unAPI]: https://github.com/omeka-s-modules/UnApi
[Omeka S]: https://omeka.org/s
[unAPI protocol]: http://www.ariadne.ac.uk/issue48/chudnov-et-al
[original description]: https://web.archive.org/web/20150111204516/http://unapi.info
[Zotero]: https://zotero.org
[COinS]: https://github.com/biblibre/omeka-s-module-coins
[OAI-PMH Repository]: https://github.com/biblibre/omeka-s-module-OaiPmhRepository
[rdf/xml]: https://www.w3.org/TR/rdf-syntax-grammar
[Installing a module]: https://dev.omeka.org/docs/s/user-manual/modules/#installing-modules
[`UnApi.zip`]: https://github.com/omeka-s-modules/UnApi/releases
[module issues]: https://github.com/omeka-s-modules/UnApi/issues
[GNU/GPL]: https://www.gnu.org/licenses/gpl-3.0.html
[Roy Rosenzweig Center for History & New Media]: http://rrchnm.org/
[Daniel-KM]: https://github.com/Daniel-KM "Daniel Berthereau"
