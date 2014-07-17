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

require_once('config/config.php');
require_once('include.php');

// Define controllers.
define('CONTROLLER_DASHBOARD', 'dashboard');
define('CONTROLLER_ADMIN', 'admin');
define('CONTROLLER_PROFILE', 'profile');
define('CONTROLLER_HELP', 'help');
define('CONTROLLER_LOGIN', 'login');
define('CONTROLLER_DEFAULT', '');

class Dispatcher {

  // database object
  var $pdo = null;
  // smarty template object
  var $tpl = null;
  // error messages
  var $error = null;
  
  var $connected = false;

    /**
    * class constructor
    */
    function __construct()
    {
        // instantiate the pdo object
        try
        {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_AUTH_DBNAME . "";
            $this->pdo =  new PDO($dsn,DB_AUTH_USERNAME, DB_AUTH_PASSWORD);
            
            // Check if logged.
            session_start();
            if (isset($_SESSION))
                $connected = true;
            
        } catch (PDOException $e)
        {
            print "Error!: " . $e->getMessage();
            die();
        }

        // instantiate the template object
        $this->tpl = new SmartyWebsite();
    }
  
    /** Display the requested page. */
    function displayPage($webPage)
    {
        setcookie("last-page", full_url($_SERVER));
        
        if (isset($_SESSION["message"]))
        {
            $message = $_SESSION["message"];
            $this->tpl->assign('message', $message);
            unset($_SESSION["message"]);
        }
        
        $sth = $this->pdo->prepare("SELECT COUNT(alerts.id) AS c FROM alerts WHERE resolved = 0");
        $sth->execute();
        $countAlerts = $sth->fetch(PDO::FETCH_ASSOC);
        $countAlerts = $countAlerts["c"];
        $this->tpl->assign('countAlerts', $countAlerts);
        
        try
        {
            switch ($webPage)
            {
                case CONTROLLER_DASHBOARD:
                    $c = new DashboardController($this->pdo);
                    $c->buildTemplate($this->tpl);
                    break;
                case CONTROLLER_ADMIN:
                    $c = new AdminController($this->pdo);
                    $c->buildTemplate($this->tpl);
                    break;
                case CONTROLLER_PROFILE:
                    $c = new ProfileController($this->pdo);
                    $c->buildTemplate($this->tpl);
                    break;
                case CONTROLLER_HELP:
                    $c = new HelpController($this->pdo);
                    $c->buildTemplate($this->tpl);
                    break;
                case CONTROLLER_LOGIN:
                    $c = new LoginController($this->pdo);
                    $c->buildTemplate($this->tpl);
                    break;
                case CONTROLLER_DEFAULT:
                default:
                    $this->tpl->display('controller_blank.tpl');
                    break;
            }
        } catch (SecurityAccessException $sae)
        {
            if ($this->tpl->getTemplateVars('message') == null)
            {
                $_SESSION["message"] = array("type" => "danger", "title" => "Accès interdit", "descr" => "Cette page est protégée. Veuillez vous connecter avec un compte ayant accès à cette page.");
                $this->tpl->assign('message', $_SESSION["message"]);
                unset($_SESSION["message"]);
            }
            
            // A Security Access Exception occurs when the user cannot see the asked page.
            // So in this case let's redirect to login page.
            $c = new LoginController($this->pdo);
            $c->buildTemplate($this->tpl);
            
        } catch (SecurityException $se)
        {
            // A Security Exception is more generic so display a message.
            Log::getLogger()->write(Log::LOG_ALERT, "Security Exception dropped on dispatcher", $se);
            $_SESSION["message"] = array("type" => "danger", "title" => "Erreur", "descr" => $se->getMessage());
            $this->tpl->assign('message', $_SESSION["message"]);
            unset($_SESSION["message"]);
            $this->tpl->display('controller_error.tpl');
            
        } catch (Exception $e)
        {
            Log::getLogger()->write(Log::LOG_ERROR, "Unknown Exception dropped on dispatcher", $e);
            // A very generic exception.
            $_SESSION["message"] = array("type" => "danger", "title" => "Erreur", "descr" => $e->getMessage());
                $this->tpl->assign('message', $_SESSION["message"]);
            unset($_SESSION["message"]);
            $this->tpl->display('controller_error.tpl');
        }
    }
}

?>