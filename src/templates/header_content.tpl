<body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <img class="thumbnail-logo" src="images/geol-logo.png" />
                <a class="navbar-brand" href="#">Monitoring</a>
                
                <ul class="nav navbar-nav navbar-left">
                    {{if $countAlerts gt 0}}
                    <li>
                        <a href="?v=dashboard&cat=alerts">
                          <span class="navbar-header-hideable" style="color: white; margin-left: 30px; font-weight: bold;">
                              <span class="label label-danger" style="position: relative; top: -1px;">{{$countAlerts}}</span> alerte(s)
                          </span>
                        </a>
                    </li>
                    {{/if}}
                </ul>
                
                
                
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li {{if $view eq "home"}} class="active" {{/if}} ><a href="?v=dashboard">Dashboard</a></li>
                    <li {{if $view eq "admin"}} class="active" {{/if}} ><a href="?v=admin">Admin</a></li>
                    <li {{if $view eq "profile"}} class="active" {{/if}} ><a href="?v=profile">Profil</a></li>
                    <li {{if $view eq "help"}} class="active" {{/if}} ><a href="?v=help">Aide</a></li>
                    <li><a href="action.php?a=logout">Déconnexion</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    {{if isset($message)}}
    <div class="alert alert-{{$message.type}} alert-dismissible alert-float" role="alert">
        <button type="button" class="close" data-dismiss="alert">
            <span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span>
        </button>
        <strong>{{$message.title}}</strong> {{$message.descr}}
    </div>
    {{/if}}

    

      