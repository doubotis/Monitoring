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

class AdminController {
    
    var $pdo = null;
    var $sm = null;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->sm = new SecurityManager();
        $this->sm->denyAll();
        $this->sm->allow(SECURITY_MANAGER_MASK_ADMIN);
        $this->sm->checkSecurityAccess();
    }
    
    function buildTemplate($tpl)
    {
        $tab = isset($_REQUEST["tab"]) ? $_REQUEST["tab"] : "users";
        $tpl->assign('tab', $tab);
        
        switch ($tab)
        {
            case 'config':
                $this->assignTabConfig($tpl);
                $tpl->display('controller_admin.tpl');
                break;
            default:
                $tpl->assign('view', 'view_admin_' . $tab);
                $tpl->display('controller_admin.tpl');
                break;
        }
    }
    
    function assignTabConfig($tpl)
    {
        // Build an array for the config.
        $control = array(   "host" => DB_HOST,
                            "username" => DB_AUTH_USERNAME,
                            "password" => DB_AUTH_PASSWORD,
                            "dbName" => DB_AUTH_DBNAME,
                            
                            "controlThreads" => AC_CONTROL_THREADS,
                            "controlInterval" => AC_CONTROL_FREQUENCY
                        );
        
        $tpl->assign('config', $control);
        $tpl->assign('view', 'view_admin_config');
    }
    
    
    
}

?>