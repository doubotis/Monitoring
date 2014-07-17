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

require_once('view-controllers/dashboard.php');
require_once('view-controllers/admin.php');
require_once('view-controllers/profile.php');
require_once('view-controllers/help.php');
require_once('view-controllers/login.php');

require_once('managers/security.php');
require_once('managers/plugin.php');

require_once('extern/abstract-plugin-descriptor.php');
require_once('extern/abstract-plugin-control-descriptor.php');
require_once('extern/field-form-helper.php');

require_once('log/log.php');

require_once('exceptions/security.php');

require_once('action-script.php');
require_once('process/auth.php');
require_once('process/controller.php');
require_once('process/alarm.php');
require_once('process/alert.php');
require_once('process/user.php');

require_once('data/historic.php');

require_once('utils/utils-security.php');
require_once('utils/utils-sessions.php');
require_once('utils/utils-http.php');
require_once('utils/utils-string.php');

?>
