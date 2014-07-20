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
                            <a class="btn btn-sm btn-default" href=""><span class="fa fa-signal"></span></a> 
                            <a class="btn btn-sm btn-primary" href=""><span class="fa fa-pencil-square-o"></span></a> 
                            <a class="btn btn-sm btn-danger" href=""><span class="fa fa-trash-o"></span></a>
                        </td>
                    {{/if}}
                    
                </tr>
            {{/foreach}}
        </tbody>
    </table>
</div>