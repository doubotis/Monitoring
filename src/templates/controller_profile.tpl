{{include file="header_head.tpl" title="Configuration"}}
{{include file="header_content.tpl" view="profile"}}

    <div class="container">
        <h1 class="page-header">Profil Utilisateur</h1>
        
        <form class="form-horizontal form-limited" method="post" action="action.php?a=editprofile">
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
            
            <div class="alert alert-info" role="alert"><strong>Changer le mot de passe :</strong> Laissez ces champs vides sauf si vous souhaitez modifier
            votre mot de passe.</div>

            <!-- Password input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="current-password">Mot de passe actuel :</label>
              <div class="col-md-4">
                <input id="current-password" name="current-password" type="password" placeholder="" class="form-control input-md">

              </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
                <label class="col-md-4 control-label" for="new-password">Nouveau mot de passe :</label>
                <div class="col-md-4">
                    <input id="new-password" name="new-password" type="password" placeholder="" class="form-control input-md">

                </div>
            </div>

            <!-- Password input-->
            <div class="form-group">
              <label class="col-md-4 control-label" for="retape-password">Retapez mot de passe :</label>
                <div class="col-md-4">
                    <input id="retape-password" name="retape-password" type="password" placeholder="" class="form-control input-md">

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

    </div>
    
{{include file="footer_content.tpl"}}