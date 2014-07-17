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

class section implements startOfLine
{
    const regular_expression = '/(={1,6})(.*?)(={1,6})|(\[.*((={1,6})(.*?)(={1,6})).*\])|^[\|\!\{](.*)(={1,6})(.*?)(={1,6})(.*)/i';
    private $sections = null;
        
    public function __construct()
    {
        $this->sections = array();
    }
    
    public function startOfLine($line) 
    {
        //So although were passed a line of text we might not actually need to do anything with it.
        return preg_replace_callback(section::regular_expression,array($this,'replace_callback'),$line);
    }
    
    private function replace_callback($matches)
    {
        if(count($matches) == 4)
        {
            return '<h' . strlen($matches[1]) . '>' . $matches[2] . '</h' . strlen($matches[1]) . '>';
        }
        else
        {
            return $matches[0];
        }
    }
    
}

?>