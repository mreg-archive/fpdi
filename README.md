fpdi
====

Unofficial PSR-0 compliant version of the FPDI library


This is version 1.4.2 of FPDI (and version 1.2 of FPDF_TPL) with some minor changes:

* the library is namespaced in fpdi. To create instance use

    $fpdi = new \fpdi\FPDI();

* directory structure follow the PSR-0 standard with src/ as root

* constructors are renamed *__construct* instead of class name

* support for TCPDF via *fpdi2tcpdf_bridge* is removed (incompatible with PSR-0)


## Installning with composor

The package exists in the packagist repository as *itbz/fpdi*


## License

Copyright 2004-2011 Setasign - Jan Slabon

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
