<!DOCTYPE html>
<html>
    <head>
        <title>develp.io</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="filter_by_tag" content="{$tag}"/>
        {include file='common/css.tpl'}
    </head>
    <body>
        {include file='common/menu.tpl'}
        <div class="container question-list">

        </div>
        
        <div id="loader" class="text-center">
            <i class="fa fa-refresh fa-spin fa-2x fa-fw margin-bottom"></i>
        </div>
        
        {include file='common/footer.tpl'}
        {include file='common/js.tpl'}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
        <script src="/static/questions.js"></script>
    </body>
</html>
