! function(a) {
    a.fn.SuperBox = function() {
        var b = a('<div class="superbox-show"></div>'),
            c = a('<img src="" class="superbox-current-img"><div id="imgInfoBox" class="superbox-imageinfo inline-block"><span></span></div>'),
            d = a('<div class="superbox-close txt-color-white"><i class="fa fa-times fa-lg"></i></div>');
        b.append(c).append(d);
        a(".superbox-imageinfo");
        return this.each(function() {
            a(".superbox-list").click(function() {
                $this = a(this);
                var d = $this.find(".superbox-img"),
                    e = d.data("img"),
                    f = d.attr("alt") || "No description",
                    g = e,
                    h = d.attr("title") || "No Title",
										title = d.attr('title');
										description = d.data('description');
										photo_id = d.data('photoid');
										
									$('#cms-editPhoto').appendTo('#imgInfoBox');
									$('#cms-editPhoto input[name="title"]').val(title);
									$('#cms-editPhoto textarea[name="description"]').val(description);
									$('#cms-editPhoto input[name="photo_id"]').val(photo_id);
									
                c.attr("src", e), a(".superbox-list").removeClass("active"), $this.addClass("active"), 0 == a(".superbox-current-img").css("opacity") && a(".superbox-current-img").animate({
                    opacity: 1
                }), a(this).next().hasClass("superbox-show") ? (a(".superbox-list").removeClass("active"), b.toggle()) : (b.insertAfter(this).css("display", "block"), $this.addClass("active")), a("html, body").animate({
                    scrollTop: b.position().top - d.width()
                }, "medium")
            }), a(".superbox").on("click", ".superbox-close", function() {
                a(".superbox-list").removeClass("active"), a(".superbox-current-img").animate({
                    opacity: 0
                }, 200, function() {
                    a(".superbox-show").slideUp()
                })
            })
        })
    }
}(jQuery);