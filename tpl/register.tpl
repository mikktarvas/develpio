<!DOCTYPE html>
<html>
    <head>
        <title>develp.io: registreeri</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {include file='common/css.tpl'}
    </head>
    <body>
        {include file='common/menu.tpl'}
        <div class="container">

            {if $registration_completed}
                <h2>Registreerimine õnnestus!</h2>
                <p>Võite oma uue kasutajaga <a href="/login/{$email|escape:'url'}">sisse logida</a>.</p>
            {else}
                <div class="row">
                    <div class="col-sm-push-3 col-sm-pull-3 col-sm-6 col-xs-10 col-xs-push-1">
                        <form action="/register" method="POST">
                            {include file='common/csrf_input.tpl'}
                            {if !empty($errors)}
                                <div class="form-group">
                                    <div class="bs-callout bs-callout-danger">
                                        <h3><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Registreerimine ebaõnnestus</h3>
                                        <div style="padding-top:.5em;">
                                            {foreach from=$errors item=error}<p>- {$error}</p>{/foreach}
                                        </div>
                                    </div>
                                </div>
                            {/if}
                            <div class="form-group">
                                <label for="login-email">Email</label>
                                <input name="email" type="text" class="form-control" id="login-email" placeholder="Email" value="{$email}">
                            </div>
                            <div class="form-group">
                                <label for="login-password">Parool</label>
                                <input name="password" type="password" class="form-control" id="login-password" placeholder="Parool">
                            </div>
                            <div class="form-group">
                                <label for="login-password-x2">Parool uuesti</label>
                                <input name="password-confirm" type="password" class="form-control" id="login-password-x2" placeholder="Parool uuesti">
                            </div>
                            <div class="form-group text-center">
                                <p>
                                    <button type="submit" class="btn btn-default">Registreeri</button>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        {/if}

        {include file='common/js.tpl'}
    </body>
</html>
