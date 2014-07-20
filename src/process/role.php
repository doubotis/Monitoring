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

class RoleProcess
{
    var $pdo;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        
        if (!isset($this->pdo))
            throw new Exception("Database not connected");
    }
    
    function add($name, $perms)
    {
        $sth = $this->pdo->prepare("INSERT INTO roles (id, name) VALUES (0, ?)");
        $res = $sth->execute(array($name));
        if ($res == 0)
            throw new Exception("Impossible d'ajouter un rôle.");
        
        $id = $this->pdo->lastInsertId();
        
        for ($i=0; $i < count($perms); $i++)
        {
            $sth = $this->pdo->prepare("INSERT INTO roles_permissions (role_id, permission_name) VALUES (?, ?)");
            $res = $sth->execute(array($id, $perms[$i]));
            if ($res == 0)
                throw new Exception("Impossible d'ajouter un rôle.");
        }
        
        $_SESSION["message"] = array("type" => "success", "title" => "Ajout terminé", "descr" => "Le rôle a bien été ajouté");
        header('Location: ' . '/monitoring/?v=admin&tab=roles');
        exit(0);
    }
    
    function edit($id, $name, $perms)
    {
        $sth = $this->pdo->prepare("UPDATE roles SET name = ? WHERE id = ?");
        $res = $sth->execute(array($name, $id));
        if ($res == 0)
            throw new Exception("Impossible de modifier ce rôle.");
        
        $sth = $this->pdo->prepare("DELETE roles_permissions WHERE role_id = ?");
        $res = $sth->execute(array($id));
        if ($res == 0)
            throw new Exception("Impossible de modifier ce rôle.");
        
        for ($i=0; $i < count($perms); $i++)
        {
            $sth = $this->pdo->prepare("INSERT INTO roles_permissions (role_id, permission_name) VALUES (?, ?)");
            $res = $sth->execute(array($id, $perms[$i]));
            if ($res == 0)
                throw new Exception("Impossible de modifier ce rôle.");
        }
        
        $_SESSION["message"] = array("type" => "success", "title" => "Modification terminée", "descr" => "Le rôle a bien été modifié");
        header('Location: ' . '/monitoring/?v=admin&tab=roles');
        exit(0);
    }
    
    function remove($id, $next_role_id)
    {
        if (isset($next_role_id))
        {
            $sth = $this->pdo->prepare("UPDATE users_roles role_id = ? WHERE role_id = ?");
            $res = $sth->execute(array($next_role_id, $id));
            if ($res == 0)
                throw new Exception("Impossible de supprimer ce rôle.");
        }
        else
        {
            $sth = $this->pdo->prepare("REMOVE users_roles WHERE role_id = ?");
            $res = $sth->execute(array($id));
            if ($res == 0)
                throw new Exception("Impossible de supprimer ce rôle.");
        }
        
        $_SESSION["message"] = array("type" => "success", "title" => "Suppression terminée", "descr" => "Le rôle a bien été supprimé");
        header('Location: ' . '/monitoring/?v=admin&tab=roles');
        exit(0);
    }
}
