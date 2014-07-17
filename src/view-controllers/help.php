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

require_once dirname(__FILE__) . '/../vendors/wiki/wikiParser.class.php';

class HelpController {
    
    var $pdo = null;
    
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    
    function buildTemplate($tpl)
    {
        $category = isset($_REQUEST["cat"]) ? $_REQUEST["cat"] : "userguide";
        
        $tpl->assign('category', $category);
        
        if ($category == "licensing")
            $this->showLicensing($tpl);
        else if ($category == "addentum")
            $this->showAddentum($tpl);
        else
            $this->showUserGuide($tpl);
        
    }
    
    private function showUserGuide($tpl)
    {
        $parser = new wikiParser();
        
        $contentWiki = file_get_contents(DOCS_DIR . 'help.wiki');
        $contentHtml = $parser->parse($contentWiki);
        
        $tpl->assign('content', $contentHtml);
        $tpl->display('controller_help.tpl');
    }
    
    private function showLicensing($tpl)
    {
        $parser = new wikiParser();
        
        $contentWiki = file_get_contents(DOCS_DIR . 'licensing.wiki');
        $contentHtml = $parser->parse($contentWiki);
        
        $tpl->assign('content', $contentHtml);
        $tpl->display('controller_help.tpl');
    }
    
    private function showAddentum($tpl)
    {
        $parser = new wikiParser();
        
        $contentWiki = file_get_contents(DOCS_DIR . 'custom.wiki');
        $contentHtml = $parser->parse($contentWiki);
        
        $tpl->assign('content', $contentHtml);
        $tpl->display('controller_help.tpl');
    }
    
}

?>
