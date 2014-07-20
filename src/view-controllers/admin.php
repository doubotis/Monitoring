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
        $this->sm->allow(SecurityManager::SECURITY_MANAGER_MASK_ADMIN);
        $this->sm->checkSecurityAccess();
    }
    
    function buildTemplate($tpl)
    {
        $tab = isset($_REQUEST["tab"]) ? $_REQUEST["tab"] : "users";
        $tpl->assign('tab', $tab);
        
        if (!isset($this->pdo))
            throw new Exception("Database not connected");
        
        switch ($tab)
        {
            case 'users':
                $this->__assignTabUsers($tpl);
                $tpl->display('controller_admin.tpl');
                break;
            case 'roles':
                $this->__assignTabRoles($tpl);
                $tpl->display('controller_admin.tpl');
                break;
            case 'config':
                $this->__assignTabConfig($tpl);
                $tpl->display('controller_admin.tpl');
                break;
            default:
                $tpl->assign('view', 'view_admin_' . $tab);
                $tpl->display('controller_admin.tpl');
                break;
        }
    }
    
    private function __assignTabUsers($tpl)
    {
        $action = isset($_REQUEST["a"]) ? $_REQUEST["a"] : "list";
        
        if ($action == "list")
        {
            $sth = $this->pdo->prepare("SELECT * FROM users WHERE active = 1 ORDER BY id ASC");
            $sth->execute();
            $res = $sth->fetchAll();

            $tpl->assign('users_data', $res);
            $tpl->assign('view', 'view_admin_users');
        }
        else if ($action == "stat")
        {
            $sth = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $sth->execute(array($_REQUEST["id"]));
            $res = $sth->fetch(PDO::FETCH_ASSOC);

            $tpl->assign('user', $res);
            $tpl->assign('view', 'view_admin_users_stat');
        }
        else if ($action == "perm")
        {
            $sth = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $sth->execute(array($_REQUEST["id"]));
            $res = $sth->fetch(PDO::FETCH_ASSOC);

            $tpl->assign('user', $res);
            $tpl->assign('view', 'view_admin_users_perm');
        }
        else
        {
            $sth = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $sth->execute(array($_REQUEST["id"]));
            $res = $sth->fetch(PDO::FETCH_ASSOC);

            $tpl->assign('user', $res);
            $tpl->assign('view', 'view_admin_users_form');
        }
    }
    
    private function __assignTabRoles($tpl)
    {
        $action = isset($_REQUEST["a"]) ? $_REQUEST["a"] : "list";
        $tpl->assign('action', $action);
        
        if ($action == "list")
        {
            $sth = $this->pdo->prepare("SELECT *, (SELECT COUNT(*) FROM roles_permissions b WHERE roles.id = b.role_id) AS permCount, (SELECT COUNT(*) FROM users_roles c WHERE roles.id = c.role_id) AS userCount FROM roles ORDER BY id ASC");
            $sth->execute();
            $res = $sth->fetchAll();

            $tpl->assign('roles_data', $res);
            $tpl->assign('view', 'view_admin_roles');
        }
        else if ($action == "edit")
        {
            $sth = $this->pdo->prepare("SELECT * FROM roles WHERE id = ?");
            $sth->execute(array($_REQUEST["id"]));
            $res = $sth->fetch(PDO::FETCH_ASSOC);
            $role = $res;
            
            $perm = new Permission();
            $perms_data = $perm->getPermissionsArray();
            
            $sth = $this->pdo->prepare("SELECT * FROM roles_permissions WHERE role_id = ?");
            $sth->execute(array($_REQUEST["id"]));
            $res = $sth->fetchAll();
            
            for ($i=0; $i < count($perms_data); $i++)
            {
                $el = $perms_data[$i];
                for ($j=0; $j < count($res); $j++)
                {
                    if ($res[$j]["permission_name"] == $el["name"])
                    {
                        $perms_data[$i]["enabled"] = 1;
                    }
                }
            }            
            
            $tpl->assign('role', $role);
            $tpl->assign('perms_data', $perms_data);
            $tpl->assign('view', 'view_admin_roles_form');
        }
        else if ($action == "add")
        {
            $role = array("id" => 0, "name" => "");
            
            $perm = new Permission();
            $perms_data = $perm->getPermissionsArray();
            
            $tpl->assign('role', $role);
            $tpl->assign('perms_data', $perms_data);
            $tpl->assign('view', 'view_admin_roles_form');
        }
        
    }
    
    private function __assignTabConfig($tpl)
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