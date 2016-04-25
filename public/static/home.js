$(document).ready(function () {

    var loading = false;
    var exhausted = false;
    var offset = 0;
    var $parent = $(".question-list");
    
    //TODO: extract optional tag name from meta header

    var formatDate = function (date) {
        var day = date.getDate();
        var monthIndex = date.getMonth() + "";
        if (monthIndex.length === 1) {
            monthIndex = "0" + monthIndex;
        }
        var year = date.getFullYear();
        return day + "." + monthIndex + "." + year;
    };

    var insertQuestions = function (questions) {
        questions.forEach(function (question) {
            //super ugly manual dom building (should be XSS safe though)
            var $row = $("" +
                    "<div class=\"row\">" +
                    "   <div class=\"col-xs-12\"><h2></h2></div>" +
                    "</div>" +
                    "<div class=\"row\">" +
                    "   <div class=\"col-sm-8 tags\"></div>" +
                    "   <div class=\"col-sm-4 text-right asker\"><a href=\"javascript:void(0);\"></a>@<span class=\"date\"></span</div>" +
                    "</div>" +
                    "<div class=\"row\">" +
                    "   <div class=\"col-xs-12\"><hr/></div>" +
                    "</div>");
            $row.appendTo($parent);
            $("<a class=\"title-link\">").attr("href", "/question/" + question.id + "/" + question.slug).text(question.title).appendTo($row.find("h2"));
            $row.find(".asker a").text(question.author);
            var date = formatDate(new Date(question.inserted));
            $row.find(".date").text(date);
            var $tags = $row.find(".tags");
            question.tags.forEach(function (tag) {
                var $tag = $("<span class=\"label label-default\"></span>");
                $tag.text(tag);
                $tags.append($tag);
                $tags.append("&nbsp;");
            });
        });
    };

    var hasRoomToExpand = function () {
        //hard-coded unexplained constant ;)
        return ($parent.height() + 131 < $(document).height());
    };

    var loadMore = function () {
        if (!loading && !exhausted) {
            loading = true;

            loadQuestions({offset: offset}, function (questions) {
                offset++;
                loading = false;
                if (questions.length === 0) {
                    exhausted = true;
                    return;
                }

                insertQuestions(questions);

                if (hasRoomToExpand()) {
                    loadMore();
                }
            }, function () {
                console.error(arguments);
                loading = false;
            });

        }
    };
    loadMore();

    var onBottom = _.throttle(loadMore, 2000);

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() == $(document).height()) {
            onBottom();
        }
    });

});