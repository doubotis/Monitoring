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

class indent implements startOfLine, endOfLine
{
    const regular_expression = '/^:+/i';
    private $indent = 0;
    
    public function __construct()
    {
        
    }
    
    public function startOfLine($line) 
    {
        return preg_replace_callback(indent::regular_expression,array($this,'replace_callback'),$line);
    }
    
    private function replace_callback($matches)
    {
        $i = 0;
        $this->indent = strlen($matches[0]);
        $indent_html = "";
        
        for($i = 0;$i < $this->indent;$i++)
        {
            $indent_html .= "<div class=\"indent\">";
        }

        return $indent_html;
    }
    
    public function endOfLine($line_of_text) 
    {
        $i = 0;
        $indent_html = "";
        
        for($i = 0;$i < $this->indent;$i++)
        {
            $indent_html .= "</div>";
        }

        $this->indent = 0;
        return $line_of_text . $indent_html;
    }
        
}

?>