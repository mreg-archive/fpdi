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
    class pdf_context
    {
        protected $_mode = 0;
        public $file;
        public $buffer;
        public $offset;
        public $length;
        public $stack;
        public function __construct(&$f)
        {
            $this->file =& $f;
            if (is_string($this->file)) {
                $this->_mode = 1;
            }
            $this->reset();
        }
        public function getPos()
        {
            if ($this->_mode == 0) {
                return ftell($this->file);
            } else {
                return 0;
            }
        }
        public function reset($pos = null, $l = 100)
        {
            if ($this->_mode == 0) {
                if (!is_null($pos)) {
                    fseek($this->file, $pos);
                }
                $this->buffer = $l > 0 ? fread($this->file, $l) : '';
                $this->length = strlen($this->buffer);
                if ($this->length < $l) {
                    $this->increaseLength($l - $this->length);
                }
            } else {
                $this->buffer = $this->file;
                $this->length = strlen($this->buffer);
            }
            $this->offset = 0;
            $this->stack = array();
        }
        public function ensureContent()
        {
            if ($this->offset >= $this->length - 1) {
                return $this->increaseLength();
            } else {
                return true;
            }
        }
        public function increaseLength($l = 100)
        {
            if ($this->_mode == 0 && feof($this->file)) {
                return false;
            } else {
                if ($this->_mode == 0) {
                    $totalLength = $this->length + $l;
                    do {
                        $toRead = $totalLength - $this->length;
                        if ($toRead < 1) {
                            break;
                        }
                        $this->buffer .= fread($this->file, $toRead);
                    } while (($this->length = strlen($this->buffer)) != $totalLength && !feof($this->file));
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}