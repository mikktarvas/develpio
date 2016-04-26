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

            {if $not_found}
                <div class="row">
                    <div class="col-xs-12">
                        <div class="bs-callout bs-callout-danger">
                            <h3><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 404</h3>
                            <p>Otsitud küsimust ei leitud</p>
                        </div>
                    </div>
                </div>
            {else}
                <div class="row">
                    <div class="col-xs-12">
                        <h1>{$question->title}</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12" style="padding: 1em 1.5em;">
                        <div class="markdown-aware">{$question->content}</div>
                    </div>
                </div>

                <div class="row" style="font-size: 80%;">
                    <div class="col-sm-8" style="padding-left: 2em;">
                        {foreach from=$question->tags item=tag}
                            <span class="label label-default tag"><a href="/tags/{$tag}">{$tag}</a></span>
                        {/foreach}
                    </div>
                    <div class="col-sm-4 text-right" style="padding-right: 2em;">
                        <a href="javascript:void(0);">{$question->user}</a> <br/> {$question->inserted|date_format:"%d.%m.%Y"}
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12" style="padding: 1em 1.5em;">
                        <hr />
                    </div>
                </div>
            {/if}
        </div>

        {include file='common/footer.tpl'}
        {include file='common/js.tpl'}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.10.1/simplemde.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.5/marked.min.js"></script>
        <script src="/static/question.js"></script>
    </body>
</html>
