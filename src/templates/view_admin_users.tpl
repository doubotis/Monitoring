<h2 class="page-header">Liste des utilisateurs</h2>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
          <tr>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>N° Téléphone</th>
            <th style="width: 150px;">Rôle(s)</th>
            <th style="width: 60px;"></th>
          </tr>
        </thead>
        <tbody>
            {{foreach from=$users_data item=c}}
                <tr>
                    {{if $c.id eq -1}}
                        <td style="font-style:italic;">{{$c.username}}</td>
                        <td style="font-style:italic;">{{$c.email}}</td>
                        <td style="font-style:italic;">{{$c.phone}}</td>
                        <td style="font-style:italic;">SuperAdmin</td>
                        <td style="font-style:italic;"></td>
                    {{else}}
                        <td>{{$c.username}}</td>
                        <td>{{$c.email}}</td>
                        <td>{{$c.phone}}</td>
                        <td></td>
                        <td>
                            <a class="btn btn-sm btn-default" href="?v=admin&tab=users&a=stat&id={{$c.id}}"><span class="fa fa-signal"></span></a> 
                            <a class="btn btn-sm btn-default" href="?v=admin&tab=users&a=perm&id={{$c.id}}"><span class="fa fa-lock"></span></a> 
                            <a class="btn btn-sm btn-primary" href="?v=admin&tab=users&a=edit&id={{$c.id}}"><span class="fa fa-pencil-square-o"></span></a> 
                            <a class="btn btn-sm btn-danger" href="?v=admin&tab=users&a=delete&id={{$c.id}}"><span class="fa fa-trash-o"></span></a>
                        </td>
                    {{/if}}
                    
                </tr>
            {{/foreach}}
        </tbody>
    </table>
</div>