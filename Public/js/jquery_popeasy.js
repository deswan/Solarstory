!function(o) {
    o.fn.popeasy = function(a) {
        function e() {
            if (a.loadExternal) {
                var e = t.attr("data-path");
                t.load(e)
            }
            l = t.attr("data-video"), t.children("." + a.videoClass).attr("src", l), c.hide(), t.css({top: o(window).height() / 2 - t.outerHeight() / 2 + o(window).scrollTop(), left: o(window).width() / 2 - t.outerWidth() / 2 + o(window).scrollLeft()}), r === !1 ? (s.css({opacity: a.maskOpacity, backgroundColor: "#" + a.background}), c.css({opacity: a.modalOpacity}), s[a.animationEffect](a.animationSpeed), t.delay(a.animationSpeed)[a.animationEffect](a.animationSpeed)) : t.show(), r = !0
        }
        function i() {
            c.stop(!0).animate({top: o(window).height() / 2 - c.outerHeight() / 2 + o(window).scrollTop(), left: o(window).width() / 2 - c.outerWidth() / 2 + o(window).scrollLeft()}, a.moveModalSpeed)
        }
        function n() {
            return t.find("." + a.videoClass).attr("src", ""), r = !1, c.fadeOut(100, function() {
                "slideDown" === a.animationEffect ? s.slideUp() : "fadeIn" === a.animationEffect && s.fadeOut()
            }), !1
        }
        a = o.extend({trigger: ".popeasy", olay: "div.overlay", modals: "div.modal", loadExternal: !1, animationEffect: "fadeIn", animationSpeed: 400, moveModalSpeed: "slow", background: "000", maskOpacity: .8, modalOpacity: 1, openOnLoad: !1, docClose: !0, closeByEscape: !0, moveOnScroll: !0, resizeWindow: !0, videoClass: "video", close: ".closeBtn"}, a);
        var t, d, l, s = o(a.olay), c = o(a.modals), r = !1;
        return"fadein" === a.animationEffect && (a.animationEffect = "fadeIn"), "slidedown" === a.animationEffect && (a.animationEffect = "slideDown"), o(".modal").each(function() {
            o(this).children().hasClass(a.videoClass) && (l = o(this).find("." + a.videoClass).attr("src"), o(this).attr("data-video", l))
        }), s.css({opacity: 0}), a.openOnLoad ? (t = o(".modal").first(), e()) : (s.hide(), c.hide()), o(a.trigger).on("click", function(a) {
            a.preventDefault(), o(".popeasy").length > 1 ? (d = o(this).attr("href"), t = o(d)) : t = o(".modal"), e()
        }), a.docClose && s.bind("click", n), o(document).on("click", a.close, n), a.closeByEscape && o(window).bind("keyup", function(o) {
            27 === o.which && n()
        }), a.resizeWindow ? (o(window).bind("resize", i), a.moveOnScroll ? void o(window).bind("scroll", i) : !1) : !1
    }
}(jQuery);