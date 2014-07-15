{{include file="header_head.tpl" title="Login"}}
<body class="body-signin">
    <div class="container">
        
        <div class="form-signin">
            <img src="images/geol-logo.png" class="big-logo"/>
            <h2 class="form-signin-heading">Monitoring</h2>

            {{if isset($message)}}
            <div class="alert alert-{{$message.type}}" role="alert" style="max-width: 330px; margin: 0 auto;">
                <strong>{{$message.title}}</strong> {{$message.descr}}
            </div>
            {{/if}}
        </div>

    </div>
</body>