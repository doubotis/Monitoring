<h1 class="page-header"><span class="fa fa-ticket"></span> Contrôleurs</h1>
<p>
    Les contrôleurs servent le principe de base du Monitoring. Chaque contrôleur définit quelque chose à contrôler.
    Il est possible de faire des groupes de contrôleurs et de personnaliser chacun des comportements du contrôleur au cas où le
    test de celui-ci s'avèrerait erroné. Il est par exemple possible de configurer quelles alarmes se déclencheront, en fonction
    de la gravité de la panne.
</p>

<span class="table-controls">
    <a href="?v=dashboard&cat=controllers&a=add" class="btn btn-primary"><span class="fa fa-plus"></span> Ajouter</a>
</span>
<h2 class="sub-header">Liste des contrôleurs</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
              <tr>
                <th style="width: 100px;">#</th>
                <th>Nom</th>
                <th style="width: 100px;">Alerte(s)</th>
                <th style="width: 70px;">Actif</th>
              </tr>
            </thead>
            <tbody>
                {{foreach from=$controllers_data item=c}}
                    <tr>
                        <td>{{$c.id}}</td>
                        <td><a href="?v=dashboard&cat=controllers&a=edit&id={{$c.id}}">{{$c.name}}</a></td>
                        <td>{{$c.alarm_count}}</td>
                        <td>
                            {{if $c.enabled eq 1}}
                                <span style="color: darkgreen;" class="glyphicon glyphicon-ok-sign"></span>
                            {{else}}
                                <span style="color: darkred;" class="glyphicon glyphicon-remove-sign"></span>
                            {{/if}}
                        </td>
                    </tr>
                {{/foreach}}
            </tbody>
        </table>
    </div>