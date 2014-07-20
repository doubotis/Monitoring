{{include file="header_head.tpl" title="Configuration"}}
{{include file="header_content.tpl" view="admin"}}

    <div class="container">
        <h1 class="page-header">Administration</h1>
        
        <ul class="nav nav-tabs" role="tablist">
            <li {{if $tab eq 'users'}}class="active"{{/if}}><a href="?v=admin&tab=users">Utilisateurs</a></li>
            <li {{if $tab eq 'roles'}}class="active"{{/if}}><a href="?v=admin&tab=roles">Rôles</a></li>
            <li {{if $tab eq 'projects'}}class="active"{{/if}}><a href="?v=admin&tab=projects">Projets</a></li>
            <li {{if $tab eq 'config'}}class="active"{{/if}}><a href="?v=admin&tab=config">Configuration</a></li>
            <li {{if $tab eq 'alerts'}}class="active"{{/if}}><a href="?v=admin&tab=alerts">Alertes</a></li>
        </ul>
        <div class="tab-content" style="border-left: 1px solid #ddd; border-right: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 25px;">
            {{include file="$view.tpl"}}
        </div>
    </div>
    
{{include file="footer_content.tpl"}}