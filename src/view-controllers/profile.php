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

class ProfileController {
    
    var $pdo = null;
    var $sm = null;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->sm = new SecurityManager();
        $this->sm->denyAll();
        $this->sm->allow(SecurityManager::SECURITY_MANAGER_MASK_LOGGED);
        $this->sm->checkSecurityAccess();
    }
    
    function buildTemplate($tpl)
    {
        if (!isset($this->pdo))
            throw new Exception("Database not connected");
        
        $sth = $this->pdo->prepare("SELECT * FROM users WHERE users.id = ?");
        $sth->execute(array($_SESSION["user_id"]));
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        $user = $res;
        
        $tpl->assign('user', $user);
        $tpl->display('controller_profile.tpl');
    }
    
}

?>