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

            <form action="/api/login" method="POST">
                <input type="hidden" name="csrf_token" value="{$csrf_token}"/>
                <div class="form-group">
                    <label for="login-email">Email</label>
                    <input name="email" type="email" class="form-control" id="login-email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="login-password">Parool</label>
                    <input name="password" type="password" class="form-control" id="login-password" placeholder="Parool">
                </div>
                <button type="submit" class="btn btn-default">Logi sisse</button>
            </form>

        </div>

        {include file='common/js.tpl'}
    </body>
</html>
