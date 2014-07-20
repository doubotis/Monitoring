<h2 class="page-header">Modifier Utilisateur</h2>

<form class="form-horizontal form-limited" method="post" action="action.php?a=edituser">
    <input type="hidden" name="id" value="{{$user.id}}" />
    <input type="hidden" name="origin" value="/monitoring/?v=admin&tab=users" />
    <fieldset>

        <!-- Form Name -->
        <legend>Coordonnées</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="username">Identifiant :</label>  
          <div class="col-md-5">
          <input id="username" name="username" type="text" placeholder="" class="form-control input-md" required="" value="{{$user.username}}">

          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="email">E-mail :</label>  
          <div class="col-md-5">
          <input id="email" name="email" type="text" placeholder="" class="form-control input-md" value="{{$user.email}}">

          </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="email-active"></label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="checkboxes-0">
              <input type="checkbox" name="email-active" id="email-active" value="1" {{if $user.email_active eq 1}}checked="checked"{{/if}}>
              Prévenir par e-mail
            </label>
                </div>
          </div>
        </div>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="phone">N° Téléphone :</label>  
          <div class="col-md-5">
          <input id="phone" name="phone" type="text" placeholder="Préfixe complet : 00324/..." class="form-control input-md" value="{{$user.phone}}">

          </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="phone-active"></label>
          <div class="col-md-4">
          <div class="checkbox">
            <label for="checkboxes-0">
              <input type="checkbox" name="phone-active" id="phone-active" value="1" {{if $user.phone_active eq 1}}checked="checked"{{/if}}>
              Prévenir par SMS
            </label>
                </div>
          </div>
        </div>

        <hr/>

        <!-- Password input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="current-password">Mot de passe :</label>
          <div class="col-md-4">
              <a href="" class="btn btn-primary">Changer mot de passe</a>
          </div>
        </div>

        <hr/>

        <!-- Button (Double) -->
        <div class="form-group">
            <label class="col-md-4 control-label"></label>
            <div class="col-md-8">
                <button type="submit" class="btn btn-success">Confirmer</button>
                <button type="reset" class="btn btn-default">Valeurs par défaut</button>
            </div>
        </div>

    </fieldset>
</form>