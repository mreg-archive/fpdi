#!/bin/bash

# Download fpdi
wget http://www.setasign.com/supra/kon2_dl/60111/FPDI-1.4.4.zip#p-525
wget http://www.setasign.com/supra/kon2_dl/63411/FPDF_TPL-1.2.3.zip#p-525

# Untar
mkdir fpdi
unzip FPDI-1.4.4.zip -d fpdi
unzip FPDF_TPL-1.2.3.zip -d fpdi
rm *.zip

# Move filters to base dir (to make fnMoveAndProcess simpler to write)
mv fpdi/filters/* fpdi
rm -r fpdi/filters

# Perform sed manipulations of source files
function fnMoveAndProcess {
    cat fpdi/$1.php | sed \
        -e 's/^<?php/<?php namespace fpdi;/' \
        -e 's/^[[:space:]]*require/#require/I' \
        -e 's/^[[:space:]]*include/#include/I' \
        -e 's/[[:space:]]extends[[:space:]]FPDF[[:space:]]/ extends \\fpdf\\FPDF /' \
        -e 's/[[:space:]]function[[:space:]]'$1'/ function __construct/' \
        -e 's/parent::pdf_parser/parent::__construct/' > src/fpdi/$2.php
    rm fpdi/$1.php
}

# Arguments are base and target file names, without file extension
fnMoveAndProcess fpdf_tpl           FPDF/TPL
fnMoveAndProcess fpdi               FPDI
fnMoveAndProcess fpdi_pdf_parser    fpdi/pdf/parser
fnMoveAndProcess pdf_context        pdf/context
fnMoveAndProcess pdf_parser         pdf/parser
fnMoveAndProcess FilterASCII85      FilterASCII85
fnMoveAndProcess FilterASCII85_FPDI FilterASCII85/FPDI
fnMoveAndProcess FilterLZW          FilterLZW
fnMoveAndProcess FilterLZW_FPDI     FilterLZW/FPDI

# Fpdi2tcpdf is not supported
rm fpdi/fpdi2tcpdf_bridge.php

# Assert that fpdi is empty
if [ "$(ls -A fpdi)" ]; then
    echo "fpdi/ not empty. Update unsuccessful."
    exit
else
	rm -rf fpdi
fi

# Install dependencies
curl -sS https://getcomposer.org/installer | php
php composer.phar install --dev

# Run tests 
phpunit --bootstrap vendor/autoload.php tests

# Assert that tests/AA.pdf exists
if [ -f tests/AA.pdf ]; then
    echo "Update successful."
else
    echo "tests/AA.pdf not created. Update unsuccessful."
fi
