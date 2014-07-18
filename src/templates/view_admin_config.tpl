<form class="form-horizontal" method="post" action="action.php?a=adminconfig">
    <fieldset>
        
    <legend>Base de données</legend>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="textinput">Hôte :</label>  
      <div class="col-md-6">
      <input id="db-host" name="db-host" type="text" placeholder="" class="form-control input-md" required="" value="{{$config.host}}">

      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="textinput">Username :</label>  
      <div class="col-md-4">
      <input id="db-username" name="db-username" type="text" placeholder="" class="form-control input-md" required="" value="{{$config.username}}">

      </div>
    </div>

    <!-- Password input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="passwordinput">Mot de passe :</label>
      <div class="col-md-4">
        <input id="db-password" name="db-password" type="password" placeholder="" class="form-control input-md" required="" value="{{$config.password}}">
      </div>
    </div>
      
    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="textinput">Nom DB :</label>  
      <div class="col-md-4">
      <input id="db-name" name="db-name" type="text" placeholder="" class="form-control input-md" required="" value="{{$config.dbName}}">

      </div>
    </div>

    <!-- Form Name -->
    <legend>Contrôle</legend>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="textinput">Threads de contrôle :</label>
      <div class="col-md-2">
          <input id="textinput" name="control-threads" type="number" placeholder="" class="form-control input-md" required="" value="{{$config.controlThreads}}">
      </div>
    </div>

    <!-- Text input-->
    <div class="form-group">
      <label class="col-md-4 control-label" for="textinput">Intervalle de contrôle (minutes) :</label>
      <div class="col-md-2">
      <input id="control-interval" name="control-interval" type="number" placeholder="" class="form-control input-md" required="" value="{{$config.controlInterval}}">
      </div>
    </div>
    
    <hr/>
    
    <!-- Button (Double) -->
    <div class="form-group">
      <label class="col-md-4 control-label" for="button1id">Double Button</label>
      <div class="col-md-8">
        <button id="button1id" name="button1id" class="btn btn-success">Confirmer</button>
        <button id="button2id" name="button2id" class="btn btn-default">Restaurer</button>
      </div>
    </div>

    </fieldset>
</form>