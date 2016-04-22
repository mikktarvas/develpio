<!DOCTYPE html>
<html>
    <head>
        <title>develp.io</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {include file='common/css.tpl'}
    </head>
    <body>
        {include file='common/menu.tpl'}
        <div class="container">

            {if !$is_logged_in} 

                <h2>Tundub, et Sa ei ole sisse loginud!</h2>
                <p>Uue küsimuse lisamine nõuab <a href="/login">sisse logimist</a>.</p>

            {else}

            {/if}

        </div>

        {include file='common/js.tpl'}
    </body>
</html>
