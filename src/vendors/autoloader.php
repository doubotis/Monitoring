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

set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__)),
    realpath(dirname(__FILE__) . 'php-daemon/Core'),
    realpath(dirname(__FILE__) . 'php-daemon/scripts'),
    get_include_path(),
)));

function __autoload($class_name)
{
    $class_name = str_replace('\\', '/', $class_name);
    $class_name = str_replace('_', '/', $class_name);
    require_once "$class_name.php";
}

function __pathify($class_name) {
    return str_replace("_", "/", $class_name) . ".php";
}