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

class Permission
{
    // Constants
    const PERMISSION_ACCESS_ADMIN = "perm.access.admin";
    const PERMISSION_ACCESS_SUPERADMIN = "perm.access.superadmin";
    const PERMISSION_ACCESS_DASHBOARD_OVERVIEW = "perm.access.dashboard.overview";
    const PERMISSION_ACCESS_DASHBOARD_ALERTS = "perm.access.dashboard.alerts";
    const PERMISSION_ACCESS_DASHBOARD_LOGS = "perm.access.dashboard.logs";
    const PERMISSION_ACCESS_DASHBOARD_ANALYTICS = "perm.access.dashboard.analytics";
    const PERMISSION_ACCESS_DASHBOARD_PROXMOX = "perm.access.dashboard.proxmox";
    const PERMISSION_ACCESS_DASHBOARD_CONTROLLERS = "perm.access.dashboard.controllers";
    const PERMISSION_ACCESS_DASHBOARD_SHORTCUTS = "perm.access.dashboard.shortcuts";
    const PERMISSION_ACCESS_DASHBOARD_ALARMS = "perm.access.dashboard.alarms";
    const PERMISSION_ACCESS_DASHBOARD_USERS = "perm.access.dashboard.users";
    const PERMISSION_ACCESS_DASHBOARD_PERMS = "perm.access.dashboard.perms";
    const PERMISSION_ACCESS_DASHBOARD_ADVANCED = "perm.access.dashboard.advanced";
    
    const PERMISSION_PROJECT_CREATE = "perm.project.create";
    const PERMISSION_PROJECT_EDIT = "perm.project.edit";
    const PERMISSION_PROJECT_DELETE = "perm.project.delete";
    
    const PERMISSION_USERS_CREATE = "perm.users.create";
    const PERMISSION_USERS_EDIT = "perm.users.edit";
    const PERMISSION_USERS_DELETE = "perm.users.delete";
    
    // Variables
    
    function __construct()
    {
        
    }
    
    function getPermissionsArray()
    {
        $reflector = new ReflectionClass('Permission');
        return $reflector->getConstants();
    }
}