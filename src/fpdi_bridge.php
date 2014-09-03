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
//  itbz\fpdi
//
//  PLEASE NOT THAT THIS FILE IS PROCESSED PROGRAMMATICALLY FOR THE itbz\fpdi RELEASE
//  BUG REPORTS AND SUGGESTED CHANGES SHOULD BE DIRECTED TO SETASIGN DIRECTLY
//  BUGS RELATED TO THIS CONVERSION CAN BE REPORTED AT
//
//  https://github.com/hanneskod/fpdi/issues
//
namespace fpdi {
    if (!class_exists('\\TCPDF', false)) {
        class fpdi_bridge extends \fpdf\FPDF
        {
        }
    } else {
        class fpdi_bridge extends \TCPDF
        {
            protected $_tpls = array();
            public $tplPrefix = '/TPL';
            protected $_currentObjId;
            protected function _getxobjectdict()
            {
                $out = parent::_getxobjectdict();
                foreach ($this->_tpls as $tplIdx => $tpl) {
                    $out .= sprintf('%s%d %d 0 R', $this->tplPrefix, $tplIdx, $tpl['n']);
                }
                return $out;
            }
            protected function _prepareValue(&$value)
            {
                switch ($value[0]) {
                    case \fpdi\pdf_parser::TYPE_STRING:
                        if ($this->encrypted) {
                            $value[1] = $this->_unescape($value[1]);
                            $value[1] = $this->_encrypt_data($this->_currentObjId, $value[1]);
                            $value[1] = \TCPDF_STATIC::_escape($value[1]);
                        }
                        break;
                    case \fpdi\pdf_parser::TYPE_STREAM:
                        if ($this->encrypted) {
                            $value[2][1] = $this->_encrypt_data($this->_currentObjId, $value[2][1]);
                            $value[1][1]['/Length'] = array(\fpdi\pdf_parser::TYPE_NUMERIC, strlen($value[2][1]));
                        }
                        break;
                    case \fpdi\pdf_parser::TYPE_HEX:
                        if ($this->encrypted) {
                            $value[1] = $this->hex2str($value[1]);
                            $value[1] = $this->_encrypt_data($this->_currentObjId, $value[1]);
                            $value[1] = $this->str2hex($value[1]);
                        }
                        break;
                }
            }
            protected function _unescape($s)
            {
                $out = '';
                for ($count = 0, $n = strlen($s); $count < $n; $count++) {
                    if ($s[$count] != '\\' || $count == $n - 1) {
                        $out .= $s[$count];
                    } else {
                        switch ($s[++$count]) {
                            case ')':
                            case '(':
                            case '\\':
                                $out .= $s[$count];
                                break;
                            case 'f':
                                $out .= chr(12);
                                break;
                            case 'b':
                                $out .= chr(8);
                                break;
                            case 't':
                                $out .= chr(9);
                                break;
                            case 'r':
                                $out .= chr(13);
                                break;
                            case 'n':
                                $out .= chr(10);
                                break;
                            case '':
                                if ($count != $n - 1 && $s[$count + 1] == '
') {
                                    $count++;
                                }
                                break;
                            case '
':
                                break;
                            default:
                                if (ord($s[$count]) >= ord('0') && ord($s[$count]) <= ord('9')) {
                                    $oct = '' . $s[$count];
                                    if (ord($s[$count + 1]) >= ord('0') && ord($s[$count + 1]) <= ord('9')) {
                                        $oct .= $s[++$count];
                                        if (ord($s[$count + 1]) >= ord('0') && ord($s[$count + 1]) <= ord('9')) {
                                            $oct .= $s[++$count];
                                        }
                                    }
                                    $out .= chr(octdec($oct));
                                } else {
                                    $out .= $s[$count];
                                }
                        }
                    }
                }
                return $out;
            }
            public function hex2str($data)
            {
                $data = preg_replace('/[^0-9A-Fa-f]/', '', rtrim($data, '>'));
                if (strlen($data) % 2 == 1) {
                    $data .= '0';
                }
                return pack('H*', $data);
            }
            public function str2hex($str)
            {
                return current(unpack('H*', $str));
            }
        }
    }
}