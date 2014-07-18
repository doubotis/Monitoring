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

require_once('include.php');
require(SMARTY_DIR . 'Smarty.class.php');
require_once(WEBAPP_DIR . 'smarty.php');
require_once(WEBAPP_DIR . 'dispatcher.php');
require_once(WEBAPP_DIR . 'action-script.php');
require_once(WEBAPP_DIR . 'ajax-script.php');


set_error_handler('__error_handler');

function __error_handler($error, $error_string, $filename, $line, $symbols)
{    
    $string = "$error_string occured in file $filename line $line";
    
    Log::getLogger()->write(Log::LOG_DEBUG, $string, $error);
}

?>