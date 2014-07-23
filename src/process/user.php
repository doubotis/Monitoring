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

class UserProcess
{
    var $pdo;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        
        if (!isset($this->pdo))
            throw new Exception("Database not connected");
    }
    
    function register($username, $email, $email_active, $phone, $phone_active, $password, $new_password)
    {
        if ($username == "")
            throw new Exception("Le nom d'utilisateur ne peut pas être vide");
        
        if ($password == "" || $new_password == "")
                throw new Exception("Vous devez indiquer un nouveau mot de passe.");
            
            if ($password != $new_password)
                throw new Exception("La vérification du mot de passe a échoué. Le mot de passe de confirmation doit être le même"
                        . "que le mot de passe dans le champ \"Nouveau mot de passe\".");
            
        $sth = $this->pdo->prepare("INSERT INTO users (id, username, email, email_active, phone, phone_active, rights) VALUES (0, ?, ?, ?, ?, ?, ?)");
        $res = $sth->execute(array($username, $email, $email_active, $phone, $phone_active, ""));
        if ($res == 0)
            throw new Exception("L'enregistrement a échoué.");
        
        
        $_SESSION["message"] = array("type" => "success", "title" => "Enregistrement terminé", "descr" => "Votre compte a été crée.");
        header('Location: ' . '/monitoring/?v=dashboard');
    }
    
    function add($username, $email, $email_active, $phone, $phone_active, $password, $new_password)
    {
        if ($username == "")
            throw new Exception("Le nom d'utilisateur ne peut pas être vide");
        
        if ($password == "" || $new_password == "")
                throw new Exception("Vous devez indiquer un nouveau mot de passe.");
            
            if ($password != $new_password)
                throw new Exception("La vérification du mot de passe a échoué. Le mot de passe de confirmation doit être le même"
                        . "que le mot de passe dans le champ \"Nouveau mot de passe\".");
            
        $sth = $this->pdo->prepare("INSERT INTO users (id, username, email, email_active, phone, phone_active, rights) VALUES (0, ?, ?, ?, ?, ?, ?)");
        $res = $sth->execute(array($username, $email, $email_active, $phone, $phone_active, ""));
        if ($res == 0)
            throw new Exception("L'enregistrement a échoué.");
        
        $_SESSION["message"] = array("type" => "success", "title" => "Ajout de l'utilisateur terminé", "descr" => "L'utilisateur a été ajouté.");
        header('Location: ' . '/monitoring/?v=admin');
    }
    
    function edit($id, $username, $email, $email_active, $phone, $phone_active, $password)
    {
        $sm = new SecurityManager();
        $sm->denyAll();
        $sm->allow(SecurityManager::SECURITY_MANAGER_MASK_ADMIN);
        $sm->checkSecurity();
        
        if ($id == -1)
        {
            $sm->denyAll();
            $sm->allow(SecurityManager::SECURITY_MANAGER_SUPERADMIN);
            $sm->checkSecurity();
        }
        
        if (!isset($email_active)) $email_active = 0;
        if (!isset($phone_active)) $phone_active = 0;
        
        if (isset($this->pdo))
        {
            // Get the old version
            $sth = $this->pdo->prepare("SELECT * FROM users WHERE users.id = ? AND active = 1");
            $sth->execute(array($id));
            $res = $sth->fetch(PDO::FETCH_ASSOC);
            $user = $res;
            
            if ($user == null)
                throw new Exception("Utilisateur introuvable");

            // No need to change password, so let's go !
            $sth = $this->pdo->prepare("UPDATE users SET username = ?, email = ?, email_active = ?, phone = ?, phone_active = ? WHERE id = ?");
            $res = $sth->execute(array($username, $email, $email_active, $phone, $phone_active, $id));
            if ($res == 0)
                throw new Exception("Impossible de modifier votre profil.");

            $_SESSION["message"] = array("type" => "success", "title" => "Modification d'utilisateur terminé", "descr" => "L'utilisateur a été modifié. Le mot de passe n'a PAS été modifié.");
            if (isset($_REQUEST["origin"]))
                header('Location: ' . $_REQUEST["origin"]);
            else
                header('Location: ' . '/monitoring/?v=dashboard&cat=users');
        }
        else
        {
            // Database not connected. Only for SuperAdmin.
            if ($_SESSION["user_id"] != -1)
                throw new Exception("Database not connected");
        }
    }
    
    function remove($id)
    {
        $sm = new SecurityManager();
        $sm->denyAll();
        $sm->allow(SecurityManager::SECURITY_MANAGER_MASK_ADMIN);
        $sm->checkSecurity();
        
        if ($id == -1)
            throw new SecuritySevereException("Could not delete the SuperAdmin");
        
        $sth = $this->pdo->prepare("UPDATE users SET active = 0 WHERE id = ?");
        $res = $sth->execute(array($id));
        if ($res == 0)
            throw new Exception("Impossible de supprimer cet utilisateur.");
        
        if (isset($_REQUEST["origin"]))
            header('Location: ' . $_REQUEST["origin"]);
        else
            header('Location: ' . '/monitoring/?v=dashboard&cat=users');
        
        
    }
    
    function editprofile($username, $email, $email_active, $phone, $phone_active, $cur_password, $password, $new_password)
    {
        if (!isset($email_active)) $email_active = 0;
        if (!isset($phone_active)) $phone_active = 0;
        
        // Get the old version
        $sth = $this->pdo->prepare("SELECT * FROM users WHERE users.id = ?");
        $sth->execute(array($_SESSION["user_id"]));
        $res = $sth->fetch(PDO::FETCH_ASSOC);
        $user = $res;
        
        $id = $_SESSION["user_id"];
        
        if (isset($this->pdo))
        {
            if ($cur_password != "")
            {
                if ($password == "" || $new_password == "")
                    throw new Exception("Vous devez indiquer un nouveau mot de passe.");

                if ($password != $new_password)
                    throw new Exception("La vérification du mot de passe a échoué. Le mot de passe de confirmation doit être le même"
                            . "que le mot de passe dans le champ \"Nouveau mot de passe\".");

                // Update password and all others information.
                $sth = $this->pdo->prepare("UPDATE users SET username = ?, email = ?, email_active = ?, phone = ?, phone_active = ? WHERE id = ?");
                $res = $sth->execute(array($username, $email, $email_active, $phone, $phone_active, $id));
                if ($res == 0)
                    throw new Exception("Impossible de modifier votre profil.");
                
                if ($_SESSION["user_id"] == -1)
                {
                    // It's the root user, so let's edit the .ini file
                    $cm = new ConfigManager(ADMIN_CONFIG_PATH);
                    $cm->loadINIFile();
                    $cm->setConfig("superadmin", "ac_superadmin_username", $username);
                    $cm->setConfig("superadmin", "ac_superadmin_password", sha1($new_password));
                    $cm->setConfig("superadmin", "ac_superadmin_email", $email);
                    $cm->setConfig("superadmin", "ac_superadmin_email_active", $email_active);
                    $cm->setConfig("superadmin", "ac_superadmin_phone", $phone);
                    $cm->setConfig("superadmin", "ac_superadmin_phone_active", $phone_active);
                    $cm->saveINIFile();
                }

                $_SESSION["message"] = array("type" => "success", "title" => "Modification de votre profil terminé", "descr" => "Vos informations de profil a été modifié. Votre mot de passe a été modifié.");
                header('Location: ' . '/monitoring/?v=profile');
            }
            else
            {
                // No need to change password, so let's go !
                $sth = $this->pdo->prepare("UPDATE users SET username = ?, email = ?, email_active = ?, phone = ?, phone_active = ? WHERE id = ?");
                $res = $sth->execute(array($username, $email, $email_active, $phone, $phone_active, $id));
                if ($res == 0)
                    throw new Exception("Impossible de modifier votre profil.");
                
                if ($_SESSION["user_id"] == -1)
                {
                    // It's the root user, so let's edit the .ini file
                    $cm = new ConfigManager(ADMIN_CONFIG_PATH);
                    $cm->loadINIFile();
                    $cm->setConfig("superadmin", "ac_superadmin_username", $username);
                    $cm->setConfig("superadmin", "ac_superadmin_password", sha1($new_password));
                    $cm->setConfig("superadmin", "ac_superadmin_email", $email);
                    $cm->setConfig("superadmin", "ac_superadmin_email_active", $email_active);
                    $cm->setConfig("superadmin", "ac_superadmin_phone", $phone);
                    $cm->setConfig("superadmin", "ac_superadmin_phone_active", $phone_active);
                    $cm->saveINIFile();
                }

                $_SESSION["message"] = array("type" => "success", "title" => "Modification de votre profil terminé", "descr" => "Vos informations de profil a été modifié. Votre mot de passe n'a PAS été modifié.");
                header('Location: ' . '/monitoring/?v=profile');
            }
        }
        else
        {
            // Database not connected. Only for SuperAdmin.
            if ($_SESSION["user_id"] != -1)
                throw new Exception("Database not connected");
            
            // It's the root user, so let's edit the .ini file
            $cm = new ConfigManager();
            $cm->loadINIFile();
            $cm->setConfig("superadmin", "ac_superadmin_username", $username);
            $cm->setConfig("superadmin", "ac_superadmin_password", sha1password($new_password));
            $cm->setConfig("superadmin", "ac_superadmin_email", $email);
            $cm->setConfig("superadmin", "ac_superadmin_email_active", $email_active);
            $cm->setConfig("superadmin", "ac_superadmin_phone", $phone);
            $cm->setConfig("superadmin", "ac_superadmin_phone_active", $phone_active);
            $cm->saveINIFile();
            
            $_SESSION["message"] = array("type" => "success", "title" => "Modification d'utilisateur terminé", "descr" => "L'utilisateur a été modifié. Le mot de passe n'a PAS été modifié.");
            header('Location: ' . '/monitoring/?v=profile');
        }
    }
    
    function addrole($userid, $projid, $roleid)
    {
        $sth = $this->pdo->prepare("INSERT INTO users_roles (user_id, role_id, project_id) VALUES (?, ?, ?)");
        $res = $sth->execute(array($userid, $roleid, $projid));
        if ($res == 0)
            throw new Exception("Impossible de modifier les permissions.");
        
        $_SESSION["message"] = array("type" => "success", "title" => "Modification d'utilisateur terminé", "descr" => "Le rôle a été ajouté pour cet utilisateur.");
        header('Location: ' . '/monitoring/?v=admin&tab=users&a=perm&id=' . $userid . '&proj=' . $projid);
        exit(0);
    }
    
    function removerole($userid, $projid, $roleid)
    {
        $sth = $this->pdo->prepare("DELETE FROM users_roles WHERE user_id = ? AND role_id = ? AND project_id = ?");
        $res = $sth->execute(array($userid, $roleid, $projid));
        if ($res == 0)
            throw new Exception("Impossible de modifier les permissions.");
        
        $_SESSION["message"] = array("type" => "success", "title" => "Modification d'utilisateur terminé", "descr" => "Le rôle a été supprimé pour cet utilisateur.");
        header('Location: ' . '/monitoring/?v=admin&tab=users&a=perm&id=' . $userid . '&proj=' . $projid);
        exit(0);
    }
}
