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

// define our application directory
define('WEBAPP_DIR', '../src/');
// define doc directory
define('DOCS_DIR', '../docs/');
// define config directory
define('CONFIG_DIR', '../config/');
// include the setup script
include(WEBAPP_DIR . 'setup.php');

// Create the ActionScript object.
$actionScript = new ActionScript();

// Get Query.
$action = isset($_REQUEST["a"]) ? $_REQUEST["a"] : "nothing";

$actionScript->executeAction($action, $_REQUEST);

?>