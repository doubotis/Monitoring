<h1 class="page-header"><span class="fa fa-bell"></span> Alertes</h1>

<h2 class="sub-header"><span class="badge" style="font-size: inherit;">{{count($alerts_data)}}</span> alertes en cours</h2>

<form method="post" action="action.php?a=markalerts">
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 80px;"></th>
                <th></th>
                <th>Date/Heure</th>
                <th>Name</th>
                
                <th>P. en charge</th>
            </tr>
        </thead>
        <tbody>
            {{foreach from=$alerts_data item=c}}
            <tr>
                <td>
                    {{if $c.type eq 1 }}
                        <span class="label label-info" style="position: relative; top: 10px;">Faible</span>
                    {{elseif $c.type eq 2}}
                        <span class="label label-warning" style="position: relative; top: 10px;">Modérée</span>
                    {{elseif $c.type eq 3}}
                        <span class="label label-danger" style="position: relative; top: 10px;">Élevée</span>
                    {{/if}}
                </td>
                <td><input type="checkbox" name="select-{{$c.id}}" value="1" /></td>
                <td>{{$c.timestamp|date_format:"%d/%m/%Y %k:%M"}}</td>
                <td>
                    <div><a href="?v=dashboard&cat=alerts&a=info&id={{$c.id}}"><strong>{{$c.name}}</strong></a></div>
                    <div style="font-size: 11px;"><i>{{$c.controller_descr}}</i></div>
                </td>
                <td>{{if isset($c.username)}}{{$c.username}}{{else}}En attente...{{/if}}</td>
            </tr>
            {{/foreach}}
            <tr colspan="4">
                <td style="background-color: white;"></td>
                <td colspan="4" style="background-color: white;">
                    <img src="images/arrow_ltr.png" />
                    <span style="font-size: 10px; margin-left: 10px; margin-right: 10px;">0 marqué(s)</span>
                    <button type="submit" name="mode" value="0" class="btn btn-sm btn-primary">Prendre en charge</button>
                    <button type="submit" name="mode" value="-1" class="btn btn-sm btn-danger">Echec résolution</button>
                    <button type="submit" name="mode" value="1" class="btn btn-sm btn-success">Marquer Résolu</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</form>
<br/><br/>

<h2 class="sub-header">Historique</h2>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 80px;"></th>
                <th>Date/Heure</th>
                <th>Name</th>
                
            </tr>
        </thead>
        <tbody>
            {{foreach from=$old_alerts_data item=c}}
            <tr>
                <td>
                    {{if $c.type eq 1 }}
                        <span class="label label-info" style="position: relative; top: 10px;">Faible</span>
                    {{elseif $c.type eq 2}}
                        <span class="label label-warning" style="position: relative; top: 10px;">Modérée</span>
                    {{elseif $c.type eq 3}}
                        <span class="label label-danger" style="position: relative; top: 10px;">Élevée</span>
                    {{/if}}
                </td>
                <td>{{$c.timestamp|date_format:"%d/%m/%Y %k:%M"}}</td>
                <td>
                    <div><a href="?v=dashboard&cat=alerts&a=info&id={{$c.id}}"><strong>{{$c.name}}</strong></a></div>
                    <div style="font-size: 11px;"><i>{{$c.controller_descr}}</i></div>
                </td>
            </tr>
            {{/foreach}}
        </tbody>
    </table>
</div>

