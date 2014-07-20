<h2 class="page-header">Modifier Rôle</h2>

<form class="form-horizontal form-limited" method="post" action="action.php?a={{if $action eq "add"}}addrole{{else}}editrole{{/if}}">
    <input type="hidden" name="id" value="{{$role.id}}" />
    <fieldset>

        <!-- Form Name -->
        <legend>Rôle</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="name">Nom :</label>  
          <div class="col-md-5">
          <input id="username" name="name" type="text" placeholder="" class="form-control input-md" required="" value="{{$role.name}}">
          </div>
        </div>

        <hr/>

        <!-- Multiple Checkboxes -->
        {{foreach from=$perms_data item=p}}
        <div class="form-group">
            <label class="col-md-6 control-label" for="{{$p.name}}">{{$p.name}} :<br/>
                <span style="font-size: 11px; font-style: italic;">
                    {{$p.descr}}
                </span>
            </label>
            <div class="col-md-4">
                <div class="checkbox">
                    <label for="{{$p.name}}">
                        <input type="checkbox" name="{{$p.name}}" id="{{$p.name}}" value="1" {{if $p.enabled eq 1}}checked{{/if}}>
                        Activé
                    </label>
                </div>
            </div>
        </div>
        {{/foreach}}

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