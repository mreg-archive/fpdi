<?php
namespace fpdidev;

header("Content-Type: text/plain");
error_reporting(-1);
ini_set('display_errors', '1');

include __DIR__ . "/../vendor/autoload.php";

use Symfony\Component\Finder\Finder;

$header = <<<EOF
<?php
//
//  FPDI - Version 1.5.2
//
//  Copyright 2004-2014 Setasign - Jan Slabon
//
//  Licensed under the Apache License, Version 2.0 (the "License");
//  you may not use this file except in compliance with the License.
//  You may obtain a copy of the License at
//
//  http://www.apache.org/licenses/LICENSE-2.0
//
//  Unless required by applicable law or agreed to in writing, software
//  distributed under the License is distributed on an "AS IS" BASIS,
//  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
//  See the License for the specific language governing permissions and
//  limitations under the License.
//
//  itbz\\fpdi
//
//  PLEASE NOTE THAT THIS FILE IS PROCESSED PROGRAMMATICALLY FOR THE itbz\\fpdi RELEASE
//  BUG REPORTS AND SUGGESTED CHANGES SHOULD BE DIRECTED TO SETASIGN DIRECTLY
//  BUGS RELATED TO THIS CONVERSION CAN BE REPORTED AT
//
//  https://github.com/hanneskod/fpdi/issues
//

EOF;

$converter = new Converter(
    (new Finder)->files()->in($argv[1]),
    $header
);

$converter->convert(function($fname, $content) use ($argv) {
    $fname = $argv[2] . DIRECTORY_SEPARATOR . $fname;
    echo "Converting <$fname>\n";
    file_put_contents($fname, $content);
});

echo "Conversion done!\n";
