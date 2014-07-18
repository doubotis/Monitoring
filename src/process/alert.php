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

class AlertProcess
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
    
    function intervention($id, $mode, $user_id)
    {
        // We must know all subjacents information to handle this call.
        $sth = $this->pdo->prepare("SELECT * FROM alerts WHERE id = ?");
        $sth->execute(array($id));
        $alert_data = $sth->fetch(PDO::FETCH_ASSOC);
        
        $now = date( 'Y-m-d H:i:s', time() );
        
        // Now let's handle the call.
        // If resolved, any action is forbidden.
        if ($alert_data["resolved"] == 1)
            throw new Exception("Cette alerte est résolue. Aucune intervention ne peut être appliquée.");
        
        // What is the mode ? 1 = charge / 2 = fail / 3 = solved
        if ($mode == 3)
        {
            // Set as solved. 2 steps. Define the alert then define the intervention.
            $res = $this->pdo->beginTransaction();
            if ($res == 0)
                throw new Exception("Impossible d'effectuer cette action");
            
            try
            {
                $sth = $this->pdo->prepare("UPDATE alerts SET resolved = 1, last_interv = ? WHERE id = ?");
                $res = $sth->execute(array($now, $id));
                if ($res == 0)
                    throw new Exception("Impossible d'effectuer cette action");

                // An old intervention ?
                $sth = $this->pdo->prepare("SELECT * FROM interventions WHERE alert_id = ? AND user_id = ? AND end_timestamp IS NULL");
                $sth->execute(array($id, $user_id));
                if ($sth->rowCount() > 0)
                {
                    // And old intervention exists, edit it.
                    $interv = $sth->fetch(PDO::FETCH_ASSOC);
                    
                    $sth = $this->pdo->prepare("UPDATE interventions SET end_timestamp = ? WHERE id = ?");
                    $res = $sth->execute(array($now, $interv["id"]));
                    if ($res == 0)
                        throw new Exception("Impossible d'effectuer cette action");
                }
                else
                {
                    // No older intervention. Create it.
                    $sth = $this->pdo->prepare("INSERT INTO interventions (id, alert_id, user_id, start_timestamp, end_timestamp) VALUES(0, ?, ?, ?, ?)");
                    $res = $sth->execute(array($id, $user_id, $now, $now));
                    if ($res == 0)
                        throw new Exception("Impossible d'effectuer cette action");
                }
                
                $res = $this->pdo->commit();
                if ($res == 0)
                    throw new Exception("Impossible d'effectuer cette action");
                
            } catch (Exception $e)
            {
                $this->pdo->rollBack();
                throw new Exception($e->getMessage());
            }
        }
        else if ($mode == 1)
        {
            // Set as in charge.
            $res = $this->pdo->beginTransaction();
            if ($res == 0)
                throw new Exception("Impossible d'effectuer cette action: beginTransaction");
            
            try
            {
                $sth = $this->pdo->prepare("UPDATE alerts SET last_interv = ? WHERE id = ?");
                $res = $sth->execute(array($now, $id));
                if ($res == 0)
                    throw new Exception("Impossible d'effectuer cette action: update alerts");

                // An old intervention ?
                $sth = $this->pdo->prepare("SELECT * FROM interventions WHERE alert_id = ? AND user_id = ? AND end_timestamp IS NULL");
                $sth->execute(array($id, $user_id));
                if ($sth->rowCount() > 0)
                {
                    // Already in charge.
                    throw new Exception("Vous êtes déjà en intervention sur cette alerte.");
                }
                else
                {
                    // No older intervention. Create it.
                    $sth = $this->pdo->prepare("INSERT INTO interventions (id, alert_id, user_id, start_timestamp) VALUES(0, ?, ?, ?)");
                    $err = $this->pdo->errorInfo();
                    $res = $sth->execute(array($id, $user_id, $now));
                    if ($res == 0)
                        throw new Exception("Impossible d'effectuer cette action: insert intervention " . print_r($err, true));
                }
                
                $res = $this->pdo->commit();
                if ($res == 0)
                    throw new Exception("Impossible d'effectuer cette action: commit");
                
            } catch (Exception $e)
            {
                $this->pdo->rollBack();
                throw new Exception($e->getMessage());
            }
        }
        else if ($mode == 2)
        {
            // Set as in fail.
            $res = $this->pdo->beginTransaction();
            if ($res == 0)
                throw new Exception("Impossible d'effectuer cette action");
            
            try
            {
                $sth = $this->pdo->prepare("UPDATE alerts SET last_interv = ? WHERE id = ?");
                $res = $sth->execute(array($now, $id));
                if ($res == 0)
                    throw new Exception("Impossible d'effectuer cette action");

                // An old intervention ?
                $sth = $this->pdo->prepare("SELECT * FROM interventions WHERE alert_id = ? AND user_id = ? AND end_timestamp IS NULL");
                $sth->execute(array($id, $user_id));
                if ($sth->rowCount() > 0)
                {
                    // And old intervention exists, edit it.
                    $interv = $sth->fetch(PDO::FETCH_ASSOC);
                    
                    $sth = $this->pdo->prepare("UPDATE interventions SET end_timestamp = ? WHERE id = ?");
                    $res = $sth->execute(array($now, $interv["id"]));
                    if ($res == 0)
                        throw new Exception("Impossible d'effectuer cette action");
                }
                else
                {
                    // No older intervention. Create it.
                    throw new Exception("Vous devez avoir une intervention en cour sur cette alerte.");
                }
                
                $res = $this->pdo->commit();
                if ($res == 0)
                    throw new Exception("Impossible d'effectuer cette action");
                
            } catch (Exception $e)
            {
                $this->pdo->rollBack();
                throw new Exception($e->getMessage());
            }
            
        }
        
        $_SESSION["message"] = array("type" => "success", "title" => "Modification terminée", "descr" => "Intervention modifiée avec succès");
        header('Location: ' . '/monitoring/?v=dashboard&cat=alerts&a=info&id=' . $id);
    }
}
