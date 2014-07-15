<h1 class="page-header">Alarmes</h1>

<form class="form-horizontal form-limited" method="post" action="action.php?a={{if $action eq "add"}}addalarm{{else}}editalarm{{/if}}">
    <input type="hidden" name="id" value="{{$item.id}}" />
<fieldset>

<!-- Form Name -->
<legend>Ajouter/Modifier une alarme</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Nom :</label>  
  <div class="col-md-6">
  <input id="name" name="name" type="text" placeholder="" class="form-control input-md" required="Veuillez entrer un nom" value="{{$item.name}}">
    
  </div>
</div>
  
<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="type">Priorité :</label>
  <div class="col-md-6">
    <select id="type" name="type" class="form-control">
      <option value="1" {{if $item.type eq 1}}selected{{/if}}>Faible</option>
      <option value="2" {{if $item.type eq 2}}selected{{/if}}>Modérée</option>
      <option value="3" {{if $item.type eq 3}}selected{{/if}}>Élevée</option>
    </select>
  </div>
</div>

<!-- Multiple Checkboxes -->
<div class="form-group">
  <label class="col-md-4 control-label" for="state">Prévenir par :</label>
  <div class="col-md-4">
  <div class="checkbox">
    <label for="state-0">
      <input type="checkbox" name="email" id="state-0" value="1" {{if $item.email eq 1}}checked="checked"{{/if}}>
      Email
    </label>
  </div>
  <div class="checkbox">
    <label for="state-1">
      <input type="checkbox" name="sms" id="state-1" value="1" {{if $item.sms eq 1}}checked="checked"{{/if}}>
      SMS
    </label>
  </div>
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
