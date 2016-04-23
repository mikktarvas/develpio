<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/home">#develp.io</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/ask">Lisa küsimus</a></li>
                <li><a href="/tags">Täägid</a></li>
                <li><a href="https://github.com/mikktarvas/develpio" target="_blank">Github repo <i class="fa fa-external-link" aria-hidden="true"></i></a>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                {if $is_logged_in}
                    <form style="display: none;" id="logout-form" method="POST" action="/logout">
                        {include file='common/csrf_input.tpl'}
                    </form>
                    <li>
                        <a href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();
                                return false;">Logi välja <i class="fa fa-sign-out" aria-hidden="true"></i></a>
                    </li>
                {elseif !$is_login_page}
                    <li><a href="/login">Logi sisse <i class="fa fa-sign-in" aria-hidden="true"></i></a></li>
                        {/if}
            </ul>
        </div>
    </div>
</nav>