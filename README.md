# FPDI [![Latest Stable Version](https://poser.pugx.org/itbz/fpdi/v/stable.png)](https://packagist.org/packages/itbz/fpdi) [![Build Status](https://travis-ci.org/hanneskod/fpdi.svg)](https://travis-ci.org/hanneskod/fpdi) [![Dependency Status](https://gemnasium.com/hanneskod/fpdi.svg)](https://gemnasium.com/hanneskod/fpdi)


Unofficial PSR-0 compliant version of the [FPDI](http://www.setasign.com/products/fpdi/about/)
library with some minor changes:

* The library is namespaced in fpdi. To create instance use:
```php
$fpdi = new \fpdi\FPDI();
```
* Directory structure follow the PSR-0 standard with `src/` as root.
* Constructors are renamed `__construct` instead of class name.
* See `update_package.sh` for a complete list of changes.


Installing
-----------
Install using [composer](https://getcomposer.org/). For historical reasons the
package exists in the packagist repository as `itbz/fpdi`.


Support for TCPDF
-----------------
To use with TCPDF version `1.5.2-patch1` or later must be used, due to a
conversion error in earlier versions.


License
-------
Copyright 2004-2013 Setasign - Jan Slabon

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

[http://www.apache.org/licenses/LICENSE-2.0](http://www.apache.org/licenses/LICENSE-2.0)

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
