{{include file="header_head.tpl" title="Configuration"}}
{{include file="header_content.tpl" view="help"}}

    <div class="container">
        <h1 class="page-header">Aide</h1>
        <div class="pull-right" style="position: relative; top: -65px;">
            <div class="btn-group">
                <a href="?v=help&cat=userguide" class="btn btn-default {{if $category eq 'userguide'}}active{{/if}}">Guide d'utilisation</a>
                <a href="?v=help&cat=licensing" class="btn btn-default {{if $category eq 'licensing'}}active{{/if}}">Licensing</a>
                <a href="?v=help&cat=addentum" class="btn btn-default {{if $category eq 'addentum'}}active{{/if}}">Addentum</a>
            </div>
        </div>
        
        {{$content}}
    </div>
    
{{include file="footer_content.tpl"}}