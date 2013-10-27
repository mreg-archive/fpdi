#!/bin/bash

# Download fpdi
wget http://www.setasign.com/supra/kon2_dl/60111/FPDI-1.4.4.zip#p-525
wget http://www.setasign.com/supra/kon2_dl/63411/FPDF_TPL-1.2.3.zip#p-525

# Untar
mkdir fpdi
unzip FPDI-1.4.4.zip -d fpdi
unzip FPDF_TPL-1.2.3.zip -d fpdi
rm *.zip

function fnMoveAndProcess {
    # Remove require and include statements
    cat fpdi/$1 | sed s/^[[:space:]]*require/#require/gI | sed s/^[[:space:]]*include/#include/gI  >  src/fpdi/$2

    # Add namespace
    # Rename constructor
    # Remove original
}

fnMoveAndProcess fpdi.php FPDI2.php

# More file specific changes?
# Validate that all files have been moved (fpdi/ is empty)
# remove fpdi/
