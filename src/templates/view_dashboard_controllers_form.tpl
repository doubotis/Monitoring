<h1 class="page-header"><span class="fa fa-ticket"></span> Contrôleurs</h1>

<form id="form-controller" name="form-controller" class="form-horizontal form-limited" method="post" action="action.php?a={{if $action eq "add"}}addcontroller{{else}}editcontroller{{/if}}">
    <input type="hidden" name="id" value="{{$item.id}}" />
<fieldset>

<!-- Form Name -->
<legend>Ajouter/Modifier un contrôleur</legend>

<!-- Text input-->
<div class="form-group">
    <label class="col-md-4 control-label" for="name">Nom :</label>  
    <div class="col-md-6">
        <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="Veuillez entrer un nom" value="{{$item.name}}">
    </div>
</div>
  
<!-- Textarea -->
<div class="form-group">
    <label class="col-md-4 control-label" for="descr">Description :</label>
    <div class="col-md-6">                     
        <textarea class="form-control" id="descr" name="descr" style="width: 100%; height: 230px;"
                placeholder="Entrez une courte explication concernant ce contrôle. Cette description sera affichée sur les messages d'alertes.">{{$item.descr}}</textarea>
    </div>
</div>

<!-- Multiple Checkboxes -->
<div class="form-group">
    <label class="col-md-4 control-label" for="state">Etat :</label>
    <div class="col-md-4">
        <div class="checkbox">
            <label for="state-0">
                <input type="checkbox" name="state" id="state-0" value="1" {{if $item.enabled eq 1}}checked="checked"{{/if}}>
                Activé
            </label>
        </div>
    </div>
</div>
      
<!-- Select Basic -->
<div class="form-group">
    <label class="col-md-4 control-label" for="alarm_id">Alarme :</label>
    <div class="col-md-6">
        <select id="alarm_id" name="alarm_id" class="form-control">
            {{foreach from=$alarms_data item=al}}
                <option value="{{$al.id}}" {{if $item.alarm_id eq $al.id}}selected{{/if}}>{{$al.name}}</option>
            {{/foreach}}
        </select>
    </div>
</div>

<hr/>

<!-- Select Basic -->
<div class="form-group">
    <label class="col-md-4 control-label" for="type">Type de contrôle :</label>
    <div class="col-md-6">
        <select id="type" name="type" class="form-control" onchange="changeSubForm();">
            {{foreach from=$controls_data key=k item=cl}}
                <option value="{{$k}}" {{if $item.control_type eq $k}}selected{{/if}}>{{$cl->pluginName()}}</option>
            {{/foreach}}
        </select>
    </div>
</div>

<div id="control-type-subform">
    {{$subform_html}}
</div>
  
<hr/>
    
<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <button id="button1id" name="button1id" type="submit" class="btn btn-success">Confirmer</button>
    <button id="Annuler" name="Annuler" type="reset" class="btn btn-default">Annuler</button>
    <a href="javascript:controlTest();" id="btn-test-control" data-toggle="tooltip" title="Tooltip on left" class="btn btn-primary" style="margin-left: 30px;"><img id="img-test-control" style="width: 16px; height: 16px; display: none; float: left; position: relative; top: 2px; margin-right: 5px;" src="images/ajax-loader-32-white.gif"> Tester le contrôle</a>
    <span id="label-test-control-result" class="label" style="margin-left: 20px; display: none;">Contrôle réussi</span>
  </div>
</div>

</fieldset>
</form>
        
        <script type="text/javascript">
    
    function changeSubForm()
    {
        var subForm = $("#type").val();
        $.get(
            "ajax.php?q=getForm&controlname=" + subForm, { },
            function(data)
            {
                $("#control-type-subform").html(data);
            }
        );
    }
    
    function controlTest()
    {
        var subForm = $("#type").val();
        $("#img-test-control").css("display", "block");
        $("#label-test-control-result").css("display", "none");
        var values = $("#form-controller").serialize();
        var url = "ajax.php?q=controlTest&controlname=" + subForm + "&" + values;
        $.post(
            url,
            { },
            function(data)
            {
                $("#img-test-control").css("display", "none");
                $("#label-test-control-result").css("display", "inline");
                $("#label-test-control-result").removeClass("label-success");
                $("#label-test-control-result").removeClass("label-danger");
                
                if (data == "1")
                {
                    $("#label-test-control-result").addClass("label-success");
                    $("#label-test-control-result").html("Contrôle réussi");
                }
                else
                {
                    $("#label-test-control-result").addClass("label-danger");
                    $("#label-test-control-result").html("Contrôle échoué");
                }
            });
    }
    
        </script>
