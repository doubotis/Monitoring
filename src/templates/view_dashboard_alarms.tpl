<h1 class="page-header"><span class="fa fa-bell-o"></span> Alarmes</h1>
<p>
    Les alarmes s'identifient en plusieurs types et diffèrent selon la gravité. Lorsqu'un contrôleur échoue une vérification, l'alarme qui lui
    est attribuée se déclenche. Chaque alarme a sa propre priorité. Ainsi, certaines alarmes peuvent être très importantes, auquel cas
    un message SMS est automatiquement envoyé. Dans d'autres cas, l'alarme ne fera qu'indiquer un avertissement sur l'interface de monitoring.
</p>
<p>
    L'aperçu donne accès aux dernières alarmes qui se sont déclenchées.
</p>

<span class="table-controls">
    <a href="?v=dashboard&cat=alarms&a=add" class="btn btn-primary">Ajouter</a>
</span>
<h2 class="sub-header">Liste des alarmes</h2>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
              <tr>
                <th style="width: 100px;">#</th>
                <th>Nom</th>
                <th style="width: 300px;">Importance</th>
                <th style="width: 70px;">Email</th>
                <th style="width: 70px;">SMS</th>
              </tr>
            </thead>
            <tbody>
                {{foreach from=$alarms_data item=c}}
                    <tr>
                        <td>{{$c.id}}</td>
                        <td><a href="?v=dashboard&cat=alarms&a=edit&id={{$c.id}}">{{$c.name}}</a></td>
                        <td>
                            {{if $c.type eq 1}}
                                Faible
                            {{elseif $c.type eq 2}}
                                Modérée
                            {{elseif $c.type eq 3}}
                                Élevée
                            {{/if}}
                        </td>
                        <td>
                            {{if $c.email eq 1}}
                                <span style="color: darkgreen;" class="glyphicon glyphicon-ok-sign"></span>
                            {{else}}
                                <span style="color: darkred;" class="glyphicon glyphicon-remove-sign"></span>
                            {{/if}}
                        </td>
                        <td>
                            {{if $c.sms eq 1}}
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