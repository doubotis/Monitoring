<h2 class="page-header">Permissions de l'utilisateur {{$user.username}}</h2>

<!-- Select Basic -->
<div class="form-group">
    <label class="col-md-2 control-label" for="selectbasic">Projet :</label>
    <div class="col-md-5">
        <select id="selector-project" name="selector-project" class="form-control" onchange="switchProject();">
                <option value="all">Tous les projets</option>
            {{foreach from=$projects_data item=p}}
                <option value="{{$p.id}}" {{if $projectid eq $p.id}} selected{{/if}}>{{$p.name}}</option>
            {{/foreach}}
        </select>
    </div>
</div>
<br/>
<br/>
<hr/>

<div class="table-responsive" style="margin-top: 15px;">
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Rôle</th>
            <th style="width: 150px;">Permissions</th>
            <th style="width: 60px;"></th>
          </tr>
        </thead>
        <tbody>
            {{if count($user_roles_data) gt 0}}
                {{foreach from=$user_roles_data item=c}}
                    <tr>
                        <td>{{$c.name}}</td>
                        <td>{{$c.permCount}}</td>
                        <td></td>
                        <td> 
                            <a class="btn btn-sm btn-danger" href="action.php?a=removeuserrole&user_id={{$user.id}}&proj={{$projectid}}&role_id={{$c.id}}"><span class="fa fa-trash-o"></span></a>
                        </td>
                    </tr>
                {{/foreach}}
            {{else}}
                <tr>
                        <td style="font-style: italic;">Aucun rôle</td>
                        <td></td>
                        <td></td>
                        <td></td>
                </tr>
            {{/if}}
        </tbody>
    </table>
</div>
        
<hr/>

<form class="form-horizontal" method="POST" action="action.php?a=adduserrole&proj={{$projectid}}">
    <input type="hidden" name="userid" value="{{$user.id}}" />
    <fieldset>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="selectbasic">Ajouter un rôle :</label>
        <div class="col-md-5">
            <select id="selector-role" name="selector-role" class="form-control">
                {{foreach from=$roles_data item=r}}
                    <option value="{{$r.id}}">{{$r.name}}</option>
                {{/foreach}}

            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-5">
            <div class="pull-right">
                <button id="button1id" name="button1id" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
    
    <hr/>

    </fieldset>
</form>
                
<script type="text/javascript">
    function switchProject()
    {
        var projectID = $("#selector-project").val();
        window.location = "?v=admin&tab=users&a=perm&id=" + {{$user.id}} + "&proj=" + projectID;
    }
</script>
