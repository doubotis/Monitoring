<h1 class="page-header"><span class="fa fa-bell"></span> Alertes</h1>

<div class="form-limited">
    <span class="table-controls">
        {{if $item.resolved eq 1}}
            <span class="label label-success" style="font-size: inherit;">Résolu</span>
        {{else}}
            <span class="label label-warning" style="font-size: inherit;">Non résolu</span>
        {{/if}}
    </span>
    <h2 class="sub-header">Informations sur l'alerte #{{$item.id}}</h2>
    
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-4">
            <div style="padding-top: 7px; margin-bottom: 0; text-align: right; font-weight: bold;">
                Nom du contrôleur :
            </div>
        </div>
        <div class="col-md-6">
            <div style="padding-top: 7px; margin-bottom: 0;">
                <a href="?v=dashboard&cat=controllers&a=edit&id={{$item.controller_id}}">{{$item.name}}</a>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-4">
            <div style="padding-top: 7px; margin-bottom: 0; text-align: right; font-weight: bold;">
                Description :
            </div>
        </div>
        <div class="col-md-6">
            <div style="padding-top: 7px; margin-bottom: 0;">
                {{$item.controller_descr}}
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-4">
            <div style="padding-top: 7px; margin-bottom: 0; text-align: right; font-weight: bold;">
                Date de l'alerte :
            </div>
        </div>
        <div class="col-md-6">
            <div style="padding-top: 7px; margin-bottom: 0;">
                {{$item.timestamp|date_format:"%d/%m/%Y %k:%M"}}
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-4">
            <div style="padding-top: 7px; margin-bottom: 0; text-align: right; font-weight: bold;">
                Problème rencontré :
            </div>
        </div>
        <div class="col-md-6">
            <div style="padding-top: 7px; margin-bottom: 0;">
                <div class="exception-label label-info">
                    {{$item.exception|regex_replace:"/[\n]/" : "<br/>"|regex_replace:"/[\t]/" : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"}}
                </div>
            </div>
        </div>
    </div>
    
    <hr/>
    
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-4">
            <div style="padding-top: 7px; margin-bottom: 0; text-align: right; font-weight: bold;">
                Dernière intervention :
            </div>
        </div>
        <div class="col-md-6">
            <div style="padding-top: 7px; margin-bottom: 0;">
                {{$item.last_interv|date_format:"%d/%m/%Y %k:%M"}} par Système.
            </div>
        </div>
    </div>
    
    <hr/>
    <a href="action.php?a=editalert&mode=1&id={{$item.id}}" class="btn btn-primary">Prendre en charge</a>
    <a href="action.php?a=editalert&mode=2&id={{$item.id}}" class="btn btn-danger">Echec résolution</a>
    <a href="action.php?a=editalert&mode=3&id={{$item.id}}" class="btn btn-success">Marquer Résolu</a>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="" class="btn btn-default">Comment résoudre ce problème ?</a>
    
    <br/><br/>
    <h3>Historique des interventions</h3>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 200px;">Date/Heure</th>
                    <th>Action</th>
                    <th>Qui ?</th>
                </tr>
            </thead>
            <tbody>
                {{foreach from=$historic_data item=h}}
                <tr>
                    <td>{{$h.timestamp|date_format:"%d/%m/%Y %k:%M"}}</td>
                    <td>{{$h.what}}</td>
                    <td>{{$h.who}}</td>
                </tr>
                {{/foreach}}
            </tbody>
            
        </table>
    </div>
            
</div>
            
<h3>Timeline</h3>

<script type="text/javascript" src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization',
       'version':'1','packages':['timeline']}]}"></script>
<script type="text/javascript">
google.setOnLoadCallback(drawChart);

function drawChart() {
  var container = document.getElementById('example5.4');
  var chart = new google.visualization.Timeline(container);
  var dataTable = new google.visualization.DataTable();
  dataTable.addColumn({ type: 'string', id: 'Term' });
  dataTable.addColumn({ type: 'string', id: 'Name' });
  dataTable.addColumn({ type: 'date', id: 'Start' });
  dataTable.addColumn({ type: 'date', id: 'End' });
  dataTable.addRows([
    {{foreach from=$historic_timeline item=e}}
    [ '', '{{$e.label}}', new Date({{$e.start|date_format:"%Y, %m, %d, %k, %M, 0"}}), new Date({{$e.end|date_format:"%Y, %m, %d, %k, %M, 0"}}) ],
    {{/foreach}}]);

  var options = {
    colors: ['#cbb69d', '#603913', '#c69c6e'],
    timeline:
            {
                showRowLabels: false
            }
  };

  chart.draw(dataTable, options);
}

</script>

<div id="example5.4" style="width: 100%; height: 150px;"></div>