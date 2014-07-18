<?php

/* 
 * Copyright (C) 2014 Christophe
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */



class SmartyWebsite extends Smarty
{
    function __construct() {
      parent::__construct();
      $this->setTemplateDir(WEBAPP_DIR . 'templates');
      $this->setCompileDir(WEBAPP_DIR . '../.cache/templates_c');
      $this->setConfigDir(WEBAPP_DIR . 'config');
      $this->setCacheDir(WEBAPP_DIR . '../.cache');
      $this->left_delimiter = "{{";
      $this->right_delimiter = "}}";
      
      $this->disableMagicQuotes();
      
    }
    
    function disableMagicQuotes()
    {
        if (get_magic_quotes_gpc())
        {
            $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
            while (list($key, $val) = each($process)) {
                foreach ($val as $k => $v) {
                    unset($process[$key][$k]);
                    if (is_array($v)) {
                        $process[$key][stripslashes($k)] = $v;
                        $process[] = &$process[$key][stripslashes($k)];
                    } else {
                        $process[$key][stripslashes($k)] = stripslashes($v);
                    }
                }
            }
            unset($process);
        }
    }
    
    
}