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

/*
 * Supporting Docs
 * http://www.pmwiki.org/wiki/PmWiki/MarkupMasterIndex
 */
class pmwiki_cF_big implements startOfLine
{
    const regular_expression = '/\[\+.*?\+\]/i'; ///(\[\+\+.*?\+\+\]|\[\+.*?\+\]|\[--.*?--\]|\[-.*?-\]|@@.*?@@)
        
    public function __construct()
    {

    }
    
    public function startOfLine($line) 
    {
        //So although were passed a line of text we might not actually need to do anything with it.
        return preg_replace_callback(pmwiki_cF_big::regular_expression,array($this,'replace_callback'),$line);
    }
    
    private function replace_callback($matches)
    {
        return '<span style="font-size:120%">' . substr($matches[0],2,-2) . '</span>';
    }
    
}

?>