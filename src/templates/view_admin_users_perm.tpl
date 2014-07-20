<h2 class="page-header">Permissions Utilisateur</h2>

<form class="form-horizontal">
    <fieldset>

    <!-- Form Name -->
    <legend>Gestion des permissions</legend>

    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="selectbasic">Ajouter un rôle :</label>
        <div class="col-md-5">
            <select id="selectbasic" name="selectbasic" class="form-control">
                <option value="1">Superviseur</option>
            </select>
        </div>
    </div>
    
    <!-- Select Basic -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="selectbasic">Projet :</label>
        <div class="col-md-5">
            <select id="selectbasic" name="selectbasic" class="form-control">
                <option value="1">Tous les projets</option>
                <option value="1">Demo</option>
            </select>
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-5">
            <div class="pull-right">
                <button id="button1id" name="button1id" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
    
    <hr/>

    <!-- Select Multiple -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="selectmultiple">Rôles actifs :</label>
        <div class="col-md-5">
            <select id="selectmultiple" name="selectmultiple" class="form-control" multiple="multiple">
                <option value="1">Superviseur</option>
            </select>
        </div>
    </div>

    <!-- Button (Double) -->
    <div class="form-group">
        <label class="col-md-4 control-label" for="button1id"></label>
        <div class="col-md-8">
            <button id="button1id" name="button1id" class="btn btn-success">Appliquer les permissions</button>
            <button id="button2id" name="button2id" class="btn btn-default">Annuler</button>
        </div>
    </div>

    </fieldset>
</form>
