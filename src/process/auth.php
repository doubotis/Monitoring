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

class AuthProcess
{
    var $pdo;
    var $sm;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->sm = new SecurityManager();
        $this->sm->allowAll();
        //$this->sm->checkSecurity();
    }
    
    function login($user, $password)
    {
        $sha1Password = sha1($password);
        
        if (!isset($this->pdo))
        {
            // We verify just if this is the superadmin user.
            if (AC_SUPERADMIN_USERNAME == $user && AC_SUPERADMIN_PASSWORD == $sha1Password)
            {
                $_SESSION["message"] = array("type" => "success", "title" => "Connexion terminée", "descr" => "Vous êtes maintenant connecté");
                $_SESSION["connected"] = true;
                $_SESSION["username"] = AC_SUPERADMIN_USERNAME;
                $_SESSION["user_id"] = -1;
                header('Location: ' . '/monitoring/?v=admin&tab=config');
                exit(0);
            }
            else
                throw new Exception("Lorsque la base de données est déconnectée, seul le compte SuperAdmin peut être utilisé.");
        }
        else
        {
            $sth = $this->pdo->prepare("SELECT * FROM users WHERE USERNAME LIKE ? AND password LIKE ?");
            $sth->execute(array($user, $sha1Password));
            $res = $sth->fetchAll();
            if (count($res) <= 0)
                throw new Exception("Identifiant ou mot de passe incorrect.");
            else
            {
                $_SESSION["message"] = array("type" => "success", "title" => "Connexion terminée", "descr" => "Vous êtes maintenant connecté");
                $_SESSION["connected"] = true;
                $_SESSION["username"] = $res[0]["username"];
                $_SESSION["user_id"] = $res[0]["id"];
            }
        }
        
        Log::getLogger()->write(Log::LOG_VERBOSE, "User " . $_SESSION["username"] . " is logged on");
    }
    
    function logout()
    {
        if (isset($_SESSION["username"]))
            Log::getLogger()->write(Log::LOG_VERBOSE, "User " . $_SESSION["username"] . " is logged off");
        
        unset($_SESSION["connected"]);
        unset($_SESSION["username"]);
        unset($_SESSION["user_id"]);
        session_destroy();
        
        // Redirect automatically to the Profile page.
        $_SESSION["message"] = array("type" => "success", "title" => "Déconnexion terminée", "descr" => "Vous êtes maintenant déconnecté");
        header('Location: ' . '/monitoring/?v=dashboard');
    }
}
