{{include file="header_head.tpl" title="Login"}}
<body class="body-signin">
    <div class="container">

        <form class="form-signin" role="form" method="post" action="action.php?a=login">
            <img src="images/geol-logo.png" class="big-logo"/>
            <h2 class="form-signin-heading">Monitoring</h2>
            <input type="hidden" name="origin" value="{{$url}}">
            <input type="email" name="u" class="form-control" placeholder="Identifiant" required="" autofocus="">
            <input type="password" name="p" class="form-control" placeholder="Mot de passe" required="">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me"> Se souvenir de moi
              </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Se connecter</button>
        </form>
        
        {{if isset($message)}}
        <div class="alert alert-{{$message.type}}" role="alert" style="max-width: 330px; margin: 0 auto;">
            <strong>{{$message.title}}</strong> {{$message.descr}}
        </div>
        {{/if}}

    </div>
</body>