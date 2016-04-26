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
            <div class="row">
                <div class="col-xs-12">
                    <h2><a>Sildid</a></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" style="padding-left:2em;padding-right:2em;">
                    <hr />
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" id="tag-list">
                    {foreach from=$tags item=tag}
                        <span class="label label-default tag"><a href="/tags/{$tag->name}">{$tag->name} [{$tag->count}]</a></span>
                    {/foreach}
                </div>
            </div>
        </div>

        {include file='common/footer.tpl'}
        {include file='common/js.tpl'}
    </body>
</html>
