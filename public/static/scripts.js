function clbkOrNoop(clbk) {
    return clbk || $.noop;
}

function renderMarkdown() {
    $(".markdown-aware").not(".markdown-rendered").each(function () {
        var $elem = $(this);
        $elem.html(marked($elem.html()));
        $elem.addClass("markdown-rendered");
        $elem.show();
    });
}

function loadQuestions(options, success, fail) {

    success = clbkOrNoop(success);
    fail = clbkOrNoop(fail);
    var offset = options.offset;
    var tag = options.tag || null;
    var url = "/api/questions/" + offset;
    if (tag !== null) {
        url = url + "/" + tag;
    }

    $.ajax({
        url: url,
        method: "POST",
        cache: false,
        success: function (response) {
            if (response.errors.length === 0) {
                success(response.data);
            } else {
                fail(response.errors);
            }
        },
        error: function () {
            fail.apply(fail, arguments);
        }
    });

}