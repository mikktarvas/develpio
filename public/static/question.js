$(document).ready(function () {

    renderMarkdown();

    var isLoggedIn = $("meta[name='is_logged_in']").attr("content") === "true";

    if (isLoggedIn) {

        var $elem = $("#answer-textarea");
        var mde = new SimpleMDE({
            element: $elem[0],
            autoDownloadFontAwesome: false,
            forceSync: true,
            spellChecker: false,
            placeholder: "Sinu vastus siia"
        });

    }
});
