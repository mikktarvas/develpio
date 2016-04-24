<!DOCTYPE html>
<html>
    <head>
        <title>develp.io</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="is_logged_in" content="{if $is_logged_in}true{else}false{/if}"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.10.1/simplemde.min.css"/>
        {include file='common/css.tpl'}
    </head>
    <body>
        {include file='common/menu.tpl'}
        <div class="container">

            {if !$is_logged_in} 

                <h2>Tundub, et Sa ei ole sisse loginud!</h2>
                <p>Uue küsimuse lisamiseks pead <a href="/login">sisse logima</a>.</p>

            {else}
                <form method="POST" action="/ask">
                    {include file='common/csrf_input.tpl'}
                    <div class="form-group">
                        <input type="text" name="title" class="form-control input-lg" placeholder="Pealkiri" autocomplete="off">
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <textarea id="question-textarea" name="content" style="display: none;"></textarea>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-sm-10" style="padding-left: 25px; padding-top: 8px; margin-bottom: 10px;">
                            <input type="text" name="tags" class="form-control input-sm" placeholder="Täägid - eralda komaga" autocomplete="off">
                        </div>
                        <div class="col-sm-2 text-center">
                            <button type="submit" class="btn btn-success btn-lg" style="padding:.65em 3em;">Lisa</button>
                        </div>
                    </div>
                </form>
            {/if}

        </div>

        {include file='common/footer.tpl'}
        {include file='common/js.tpl'}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.10.1/simplemde.min.js"></script>
        <script src="/static/ask.js"></script>
    </body>
</html>
