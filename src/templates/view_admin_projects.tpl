<span class="table-controls" style="top: 40px;">
    <a href="?v=admin&tab=projects&a=add" class="btn btn-primary"><span class="fa fa-plus"></span> Ajouter</a>
</span>
<h2 class="page-header">Projets</h2>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Nom du projet</th>
            <th>Nombre d'utilisateurs</th>
            <th>Verrouillé</th>
            <th>Visible</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            {{foreach from=$projects_data item=c}}
                <tr>
                    <td>{{$c.name}}</td>
                    <td>{{$c.userCount}}</td>
                    <td>
                            {{if $c.locked eq 1}}
                                <span style="color: darkgreen;" class="glyphicon glyphicon-ok-sign"></span>
                            {{else}}
                                <span style="color: darkred;" class="glyphicon glyphicon-remove-sign"></span>
                            {{/if}}
                    </td>
                    <td>
                            {{if $c.visible eq 1}}
                                <span style="color: darkgreen;" class="glyphicon glyphicon-ok-sign"></span>
                            {{else}}
                                <span style="color: darkred;" class="glyphicon glyphicon-remove-sign"></span>
                            {{/if}}
                    </td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="?v=admin&tab=projects&a=edit&id={{$c.id}}"><span class="fa fa-pencil-square-o"></span></a> 
                        <a class="btn btn-sm btn-danger" href="?v=admin&tab=projects&a=delete&id={{$c.id}}"><span class="fa fa-trash-o"></span></a>
                    </td>
                </tr>
            {{/foreach}}
        </tbody>
    </table>
</div>