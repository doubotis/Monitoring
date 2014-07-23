<h2 class="page-header">Ajouter/Modifier Projet</h2>

<form class="form-horizontal form-limited" method="post" action="action.php?a={{if $action eq "add"}}addproject{{else}}editproject{{/if}}">
    <input type="hidden" name="id" value="{{$project.id}}" />
    <fieldset>

        <!-- Form Name -->
        <legend>Projet</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="name">Nom :</label>  
          <div class="col-md-5">
          <input id="username" name="name" type="text" placeholder="" class="form-control input-md" required="" value="{{$project.name}}">
          </div>
        </div>

        <!-- Multiple Checkboxes -->
        <div class="form-group">
            <label class="col-md-4 control-label" for="state">Statut :</label>
            <div class="col-md-4">
                <div class="checkbox">
                    <label for="state">
                        <input type="checkbox" name="locked" id="locked" value="1" {{if $project.locked eq 1}}checked="checked"{{/if}}>
                        Verrouillé
                    </label>
                    <a href="javascript:void(0)" class="btn-sm popover-dismiss" data-container="body" data-toggle="popover" title="Verouillé" data-content="Un projet verouillé ne déclenche aucune alerte et toutes les données sont verrouillées en écriture."><span class="glyphicon glyphicon-question-sign"></span> Qu'est-ce que c'est ?</a>
                </div>
                <div class="checkbox">
                    <label for="strict">
                        <input type="checkbox" name="visible" id="visible" value="1" {{if $project.visible eq 1}}checked="checked"{{/if}}>
                        Visible 
                    </label>
                </div>
            </div>
        </div>
                        
            <script type="text/javascript">

            $(document).on("ready", function()
            {
            $('.popover-dismiss').popover({
            trigger: 'click hover'
            })
            });
        </script>

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