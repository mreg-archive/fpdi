#!/bin/bash

# Download fpdi
wget http://www.setasign.com/supra/kon2_dl/80506/FPDI-1.5.2.zip

# Untar
mkdir fpdi
unzip FPDI-1.5.2.zip -d fpdi
rm *.zip

# Move filters to base dir (to make fnMoveAndProcess simpler to write)
mv fpdi/filters/* fpdi
rm -r fpdi/filters

# Create source tree
rm -r src/fpdi/*
mkdir src/fpdi/FPDF
mkdir src/fpdi/fpdi
mkdir src/fpdi/fpdi/pdf
mkdir src/fpdi/pdf

# Perform sed manipulations of source files
function fnMoveAndProcess {
    cat fpdi/$1.php | sed \
        -e 's/^<?php/<?php namespace fpdi; use TCPDF;/' \
        -e 's/^[[:space:]]*require/#require/I' \
        -e 's/^[[:space:]]*include/#include/I' \
        -e 's/throw new /throw new \\/I' \
        -e 's/fpdi_bridge[[:space:]]extends[[:space:]]FPDF/fpdi_bridge extends \\fpdf\\FPDF /' \
        -e 's/[[:space:]]function[[:space:]]'$1'/ function __construct/' \
        -e 's/parent::pdf_parser/parent::__construct/' > src/fpdi/$2.php
    rm fpdi/$1.php
}

# Arguments are base and target file names, without file extension
fnMoveAndProcess fpdf_tpl             FPDF/TPL
fnMoveAndProcess fpdi                 FPDI
fnMoveAndProcess fpdi_bridge          fpdi/bridge
fnMoveAndProcess fpdi_pdf_parser      fpdi/pdf/parser
fnMoveAndProcess pdf_context          pdf/context
fnMoveAndProcess pdf_parser           pdf/parser
fnMoveAndProcess FilterASCII85        FilterASCII85
fnMoveAndProcess FilterLZW            FilterLZW
fnMoveAndProcess FilterASCIIHexDecode FilterASCIIHexDecode

# Assert that fpdi is empty
if [ "$(ls -A fpdi)" ]; then
    echo "fpdi/ not empty. Update unsuccessful."
    exit
else
	rm -rf fpdi
fi

# Run testsuite
bash test
