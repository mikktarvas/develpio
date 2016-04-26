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

            {if !$is_logged_in} 
                <div class="row">
                    <div class="col-xs-12 text-center" style="padding: 5em .5em;">
                        <h2>Tundub, et Sa ei ole sisse loginud!</h2>
                        <p>Küsimusele vastamiseks pead <a href="/login">sisse logima</a>.</p>
                    </div>
                </div>
            {else}
                <form method="POST" action="">
                    {include file='common/csrf_input.tpl'}
                    <input type="hidden" value="{$question_id}" name="question_id"/>
                    {if !empty($errors)}
                        <div class="form-group" id="answer_errors">
                            <div class="bs-callout bs-callout-danger">
                                <h3><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Postituse tegemine ebaõnnestus</h3>
                                <div style="padding-top:.5em;">
                                    {foreach from=$errors item=error}<p>- {$error}</p>{/foreach}
                                </div>
                            </div>
                        </div>
                        <script>
                            window.location.hash = '#answer_errors';
                        </script>
                    {/if}
                    <div class="row">
                        <div class="col-xs-12">
                            <textarea id="answer-textarea" name="content" style="display: none;">{$content}</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-success btn-lg" style="padding:.65em 3em;">Vasta</button>
                        </div>
                    </div>
                </form>

            {/if}

            {if empty($question->answers) && empty($errors)}
                <div class="row">
                    <div class="col-xs-12" style="padding: 1em 1.5em;">
                        <div class="bs-callout bs-callout-primary">
                            <h3>Antud küsimusel ei ole ühtegi vastust</h3>
                            <p>Ole esimene kes vastuse annab!</p>
                        </div>
                    </div>
                </div>
            {elseif !empty($question->answers)}
                <div class="row">
                    <div class="col-xs-12 text-center" style="padding: 1em 1.5em;">
                        <h2>Vastused:</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12" style="padding: 1em 1.5em;">
                        <hr />
                    </div>
                </div>
                {foreach from=$question->answers item=answer}
                    <div class="row">
                        <div class="col-xs-12" style="padding: 1em 1.5em;">
                            <div class="markdown-aware">{$answer->content}</div>
                        </div>
                    </div>

                    <div class="row" style="font-size: 80%;">
                        <div class="col-sm-12 text-right" style="padding-right: 2em;">
                            <a href="javascript:void(0);">{$answer->author}</a> <br/> {$answer->inserted|date_format:"%d.%m.%Y"}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12" style="padding: 1em 1.5em;">
                            <hr />
                        </div>
                    </div>
                {/foreach}
            {/if}

        </div>

        {include file='common/footer.tpl'}
        {include file='common/js.tpl'}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/simplemde/1.10.1/simplemde.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/marked/0.3.5/marked.min.js"></script>
        <script src="/static/question.js"></script>
    </body>
</html>
