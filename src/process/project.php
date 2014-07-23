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

class ProjectProcess
{
    var $pdo;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        
        if (!isset($this->pdo))
            throw new Exception("Database not connected");
    }
    
    function add($name, $locked, $visible)
    {
        if (!isset($locked)) $locked = 0;
        if (!isset($visible)) $visible = 0;
        $sth = $this->pdo->prepare("INSERT INTO projects (id, name, locked, visible) VALUES (0, ?, ?, ?)");
        $res = $sth->execute(array($name, $locked, $visible));
        if ($res == 0)
            throw new Exception("Impossible d'ajouter un projet.");
        
        $_SESSION["message"] = array("type" => "success", "title" => "Ajout terminé", "descr" => "Le projet a bien été ajouté");
        header('Location: ' . '/monitoring/?v=admin&tab=projects');
    }
    
    function edit($id, $name, $locked, $visible)
    {
        if (!isset($locked)) $locked = 0;
        if (!isset($visible)) $visible = 0;
        $sth = $this->pdo->prepare("UPDATE projects SET name = ?, locked = ?, visible = ? WHERE id = ?");
        $res = $sth->execute(array($name, $locked, $visible, $id));
        if ($res == 0)
            throw new Exception("Impossible de modifier ce projet.");
        
        $_SESSION["message"] = array("type" => "success", "title" => "Modification terminée", "descr" => "Le projet a bien été modifié");
        header('Location: ' . '/monitoring/?v=admin&tab=projects');
    }
    
    function remove($id)
    {
        $sth = $this->pdo->prepare("DELETE projects WHERE id = ?");
        $res = $sth->execute(array($id));
        if ($res == 0)
            throw new Exception("Impossible de supprimer ce projet.");
        
        $_SESSION["message"] = array("type" => "success", "title" => "Modification terminée", "descr" => "Le projet a bien été supprimé");
        header('Location: ' . '/monitoring/?v=admin&tab=projects');
    }
}
