{{include file="header_head.tpl" title="Home"}}
{{include file="header_content.tpl" view="home"}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li class="nav-bar-category">Sélectionner un projet</li>
                    <li>
                        <div class="btn-group project-selector">
                            <button class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown">
                              Tous les projets <span class="caret" style="float: right; position: relative; top: 10px;"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu" style="left: 10px; right: 10px;">
                                <li><a href="?v=dashboard&proj=all">Tous les projets</a></li>
                                <li class="divider"></li>
                                {{foreach from=$projects_data item=p}}
                                    <li><a href="?v=dashboard&proj={{$p.id}}">{{$p.name}}</a></li>
                                {{/foreach}}
                            </ul>
                        </div>
                  </li>
                  <li class="nav-bar-category">Supervision</li>
                  <li {{if $category eq "overview"}} class="active" {{/if}}><a href="?v=dashboard&cat=overview"><span class="glyphicon glyphicon-home"></span> Aperçu</a></li>
                  <li {{if $category eq "alerts"}} class="active" {{/if}}><a href="?v=dashboard&cat=alerts"><span class="badge pull-right">{{$countAlerts}}</span><span class="fa fa-bell"></span> <strong>Alertes</strong></a></li>
                  <li {{if $category eq "logs"}} class="active" {{/if}}><a href="?v=dashboard&cat=logs"><span class="fa fa-bars"></span> Logs</a></li>
                </ul>
                <ul class="nav nav-sidebar">
                  <li class="nav-bar-category">Informations</li>
                  <li {{if $category eq "analytics"}} class="active" {{/if}}><a href="?v=dashboard&cat=analytics"><span class="glyphicon glyphicon-signal"></span> Analytics</a></li>
                  <li {{if $category eq "proxmox"}} class="active" {{/if}}><a href="?v=dashboard&cat=proxmox"><span class="fa fa-cubes"></span> Proxmox</a></li>
                </ul>
                <ul class="nav nav-sidebar">
                  <li class="nav-bar-category">Configuration</li>
                  <li {{if $category eq "controllers"}} class="active" {{/if}}><a href="?v=dashboard&cat=controllers"><span class="fa fa-ticket"></span> Contrôleurs</a></li>
                  <li {{if $category eq "shortcuts"}} class="active" {{/if}}><a href="?v=dashboard&cat=shortcuts"><span class="glyphicon glyphicon-th-large"></span> Raccourcis</a></li>
                  <li {{if $category eq "alarms"}} class="active" {{/if}}><a href="?v=dashboard&cat=alarms"><span class="fa fa-bell-o"></span> Alarmes</a></li>
                  <li {{if $category eq "users"}} class="active" {{/if}}><a href="?v=dashboard&cat=users"><span class="fa fa-user"></span> Utilisateurs</a></li>
                  <li {{if $category eq "perms"}} class="active" {{/if}}><a href="?v=dashboard&cat=perms"><span class="fa fa-lock"></span> Permissions</a></li>
                  <li {{if $category eq "advanced"}} class="active" {{/if}}><a href="?v=dashboard&cat=advanced"><span class="fa fa-gear"></span> Paramètres avancés</a></li>
                </ul>
            </div>
          <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" style="height: 100%;">
            {{include file="$view.tpl"}}
          </div>
        </div>
    </div>
    
{{include file="footer_content.tpl"}}