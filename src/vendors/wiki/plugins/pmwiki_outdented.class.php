<?php
/* 
 * @package     PHP5 Wiki Parser
 * @author      Dan Goldsmith
 * @copyright   Dan Goldsmith 2012
 * @link        http://d2g.org.uk/
 * @version     {SUBVERSION_BUILD_NUMBER}
 * 
 * @licence     MPL 2.0
 * 
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/. 
 */
require_once(dirname(__FILE__) . '/../interface/startOfLine.interface.php');
require_once(dirname(__FILE__) . '/../interface/endOfLine.interface.php');

class pmwiki_outdented implements startOfLine, endOfLine
{
    const regular_expression = '/^-\</i';
    private $enabled = false;
    
    public function __construct()
    {
        
    }
    
    public function startOfLine($line) 
    {
        return preg_replace_callback(pmwiki_outdented::regular_expression,array($this,'replace_callback'),$line);
    }
    
    private function replace_callback($matches)
    {
        $this->enabled = true;
        return "<div class=\"outdent\">" . substr($matches[0],2);
    }
    
    public function endOfLine($line_of_text) 
    {
        if($this->enabled)
        {
            $this->enabled = false;
            return $line_of_text . "</div>";
        }
        else
        {
            return $line_of_text;
        }
    }
        
}

?>