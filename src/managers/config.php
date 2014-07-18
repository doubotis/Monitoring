<?php
/**
 * This is the CONFIG file for Monitoring project.
 * Please set your credentials.
 * Make sure permissions is set to 0644 or 0444 and
 * forbid the access by use of .htaccess or apache configurations.
 */

// Config Monitoring
/*define('DB_HOST', 'localhost');
define('DB_AUTH_USERNAME', 'web');
define('DB_AUTH_PASSWORD', 'bU9bxtn3U4NufVWN');
define('DB_AUTH_DBNAME', 'monitoring');*/

class ConfigManager
{    
    // Variables
    var $config = array();
    var $path = "";
    
    public function __construct($p)
    {
        $this->path = $p;
    }
    
    public function loadINIFile()
    {
        $this->config = parse_ini_file(ADMIN_CONFIG_PATH, true);
    }
    
    public function setConfig($section, $id, $value)
    {
        $this->config[$section][$id] = $value;
    }
    
    public function saveINIFile()
    {
        $this->__write_ini_file($this->config, $this->path , true);
    }
    
    private function __write_ini_file($assoc_arr, $path, $has_sections=FALSE)
    { 
        $content = ""; 
        if ($has_sections) { 
            foreach ($assoc_arr as $key=>$elem) { 
                $content .= "[".$key."]\n"; 
                foreach ($elem as $key2=>$elem2) { 
                    if(is_array($elem2)) 
                    { 
                        for($i=0;$i<count($elem2);$i++) 
                        { 
                            $content .= $key2."[] = \"".$elem2[$i]."\"\n"; 
                        } 
                    } 
                    else if($elem2=="") $content .= $key2." = \n"; 
                    else $content .= $key2." = \"".$elem2."\"\n"; 
                } 
            } 
        } 
        else { 
            foreach ($assoc_arr as $key=>$elem) { 
                if(is_array($elem)) 
                { 
                    for($i=0;$i<count($elem);$i++) 
                    { 
                        $content .= $key."[] = \"".$elem[$i]."\"\n"; 
                    } 
                } 
                else if($elem=="") $content .= $key." = \n"; 
                else $content .= $key." = \"".$elem."\"\n"; 
            } 
        } 

        if (!$handle = fopen($path, 'w')) { 
            return false; 
        }

        $success = fwrite($handle, $content);
        fclose($handle); 

        return $success; 
    }
}



?>
