<h1 class="page-header"><span class="fa fa-ticket"></span> Contrôleurs</h1>

<form class="form-horizontal form-limited" method="post" action="action.php?a={{if $action eq "add"}}addcontroller{{else}}editcontroller{{/if}}">
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
    <select id="type" name="alarm_id" class="form-control">
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
    <select id="type" name="type" class="form-control">
      <option value="0" {{if $item.control_type eq 0}}selected{{/if}}>Requête HTTP</option>
      <option value="1" {{if $item.control_type eq 1}}selected{{/if}}>Réponse HTTP</option>
      <option value="2" {{if $item.control_type eq 2}}selected{{/if}}>Réponse JSON</option>
      <option value="3" {{if $item.control_type eq 3}}selected{{/if}}>Réponse XML</option>
      <option value="4" {{if $item.control_type eq 4}}selected{{/if}}>Réponse Base de données</option>
    </select>
  </div>
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="col-md-4 control-label" for="code">Code :</label>
  <div class="col-md-6">                     
    <textarea class="form-control" id="code" name="code" style="width: 100%; height: 230px; font-family: monospace;">{{$item.control_code}}</textarea>
  </div>
</div>
    
<!-- Button (Double) -->
<div class="form-group">
  <label class="col-md-4 control-label" for="button1id"></label>
  <div class="col-md-8">
    <button id="button1id" name="button1id" type="submit" class="btn btn-success">Confirmer</button>
    <button id="Annuler" name="Annuler" type="reset" class="btn btn-default">Annuler</button>
  </div>
</div>

</fieldset>
</form>
