# FPDI - Free PDF Document Importer

[![Packagist Version](https://img.shields.io/packagist/v/itbz/fpdi.svg?style=flat-square)](https://packagist.org/packages/itbz/fpdi)
[![Build Status](https://img.shields.io/travis/hanneskod/fpdi/master.svg?style=flat-square)](https://travis-ci.org/hanneskod/fpdi)
[![Dependency Status](https://img.shields.io/gemnasium/hanneskod/fpdi.svg?style=flat-square)](https://gemnasium.com/hanneskod/fpdi)
[![Reference Status](https://www.versioneye.com/php/itbz:fpdi/reference_badge.svg?style=flat)](https://www.versioneye.com/php/itbz:fpdi/references)

Unofficial [PSR-4](http://www.php-fig.org/psr/psr-4/) compliant version of the
[FPDI](http://www.setasign.com/products/fpdi/about/) library with some minor
changes.

The library is namespaced in fpdi. To create instance use:

```php
$fpdi = new \fpdi\FPDI();
```
> NOTE that since version 1.5.3 FPDI is officially available via composer and
> [github](https://github.com/Setasign/FPDI). However this requires some
> additional setup and is not psr-4 compliant.
>
> Since this fork is namespaced it is possible to install both the official and
> the namespaced versions in the same project.

Installing
-----------
Install using [composer](https://getcomposer.org/). For historical reasons the
package exists in packagist as `itbz/fpdi`. From project root use

    composer require itbz/fpdi:~1.0

Support for TCPDF
-----------------
To use with TCPDF version `1.5.2-patch1` or later must be used, due to a
conversion error in earlier versions.

Contributing
------------
See the [CONTRIBUTING](CONTRIBUTING.md) file.

Build from source
-----------------
Converting from setasign source is power by [phing](https://www.phing.info/).
See [build.xml](build.xml) for concrete instructions. To execute a build from
the command line use

    $ phing

Tests are run using

    $ phing test

Possibly followed by

    $ phing cleanup

License
-------
Copyright 2004-2015 Setasign - Jan Slabon

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

[http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0)

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
