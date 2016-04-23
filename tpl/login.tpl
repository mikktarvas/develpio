<!DOCTYPE html>
<html>
    <head>
        <title>develp.io: logi sisse</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {include file='common/css.tpl'}
    </head>
    <body>
        {include file='common/menu.tpl'}
        <div class="container">
            <div class="row">
                <div class="col-sm-push-3 col-sm-pull-3 col-sm-6 col-xs-10 col-xs-push-1">
                    <form action="/login" method="POST" class="{if $login_failed}animated bounce{/if}">
                        {include file='common/csrf_input.tpl'}
                        {if $login_failed}
                            <div class="form-group">
                                <div class="bs-callout bs-callout-danger">
                                    <h3>Sisse logimine ebaõnnestus</h3>
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
                        <div class="form-group text-center">
                            <p>
                                <button type="submit" class="btn btn-default">Logi sisse</button>
                            </p>
                            <p>
                                või <a href="/register">loo uus kasutaja</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {include file='common/js.tpl'}
    </body>
</html>
