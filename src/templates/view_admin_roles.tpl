<span class="table-controls" style="top: 40px;">
    <a href="?v=admin&tab=roles&a=add" class="btn btn-primary"><span class="fa fa-plus"></span> Ajouter</a>
</span>
<h2 class="page-header">Rôles</h2>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Nom du rôle</th>
            <th>Nombre de permissions</th>
            <th>Nombre d'utilisateurs</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            {{foreach from=$roles_data item=c}}
                <tr>
                    <td>{{$c.name}}</td>
                    <td>{{$c.permCount}}</td>
                    <td>{{$c.userCount}}</td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="?v=admin&tab=roles&a=edit&id={{$c.id}}"><span class="fa fa-pencil-square-o"></span></a> 
                        <a class="btn btn-sm btn-danger" href="?v=admin&tab=roles&a=delete&id={{$c.id}}"><span class="fa fa-trash-o"></span></a>
                    </td>
                </tr>
            {{/foreach}}
        </tbody>
    </table>
</div>