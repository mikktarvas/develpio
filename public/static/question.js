$(document).ready(function () {

    //console.log(marked);
    var $question = $("#question-content");
    $question.html(marked($question.html()));
    $question.show();

    /*var isLoggedIn = $("meta[name='is_logged_in']").attr("content") === "true";
     
     if (isLoggedIn) {
     
     var $elem = $("#question-textarea");
     var mde = new SimpleMDE({
     element: $elem[0],
     autoDownloadFontAwesome: false,
     forceSync: true,
     spellChecker: false,
     placeholder: "Sinu küsimus siia"
     });
     
     }*/
});
