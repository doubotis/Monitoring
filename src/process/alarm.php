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

class AlarmProcess
{
    var $pdo;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        
        if (!isset($this->pdo))
            throw new Exception("Database not connected");
    }
    
    function add($name, $type, $code, $mail, $sms)
    {
        if (!isset($mail)) $mail = 0;
        if (!isset($sms)) $sms = 0;
        $sth = $this->pdo->prepare("INSERT INTO alarms (id, name, type, email, sms) VALUES (0, ?, ?, ?, ?)");
        $res = $sth->execute(array($name, $type, $mail, $sms));
        if ($res == 0)
            throw new Exception("Impossible d'ajouter une alarme.");
        
        $_SESSION["message"] = array("type" => "success", "title" => "Ajout terminé", "descr" => "L'alarme a bien été ajouté");
        header('Location: ' . '/monitoring/?v=dashboard&cat=alarms');
    }
    
    function edit($id, $name, $type, $mail, $sms)
    {
        if (!isset($mail)) $mail = 0;
        if (!isset($sms)) $sms = 0;
        $sth = $this->pdo->prepare("UPDATE alarms SET name = ?, type = ?, email = ?, sms = ? WHERE id = ?");
        $res = $sth->execute(array($name, $type, $mail, $sms, $id));
        if ($res == 0)
            throw new Exception("Impossible de modifier cette alarme.");
        
        $_SESSION["message"] = array("type" => "success", "title" => "Modification terminée", "descr" => "L'alarme a bien été modifié");
        header('Location: ' . '/monitoring/?v=dashboard&cat=alarms');
    }
}
