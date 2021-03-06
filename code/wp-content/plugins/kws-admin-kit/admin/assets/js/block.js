! function(t) {
    var e = {};

    function o(n) { if (e[n]) return e[n].exports; var r = e[n] = { i: n, l: !1, exports: {} }; return t[n].call(r.exports, r, r.exports, o), r.l = !0, r.exports }
    o.m = t, o.c = e, o.d = function(t, e, n) { o.o(t, e) || Object.defineProperty(t, e, { configurable: !1, enumerable: !0, get: n }) }, o.r = function(t) { Object.defineProperty(t, "__esModule", { value: !0 }) }, o.n = function(t) { var e = t && t.__esModule ? function() { return t.default } : function() { return t }; return o.d(e, "a", e), e }, o.o = function(t, e) { return Object.prototype.hasOwnProperty.call(t, e) }, o.p = "", o(o.s = 7)
}([function(t, e) {! function() { t.exports = this.wp.element }() }, function(t, e, o) {
    var n = o(8);
    t.exports = function(t, e) {
        if ("function" != typeof e && null !== e) throw new TypeError("Super expression must either be null or a function");
        t.prototype = Object.create(e && e.prototype, { constructor: { value: t, writable: !0, configurable: !0 } }), e && n(t, e)
    }
}, function(t, e) {
    function o(e) { return t.exports = o = Object.setPrototypeOf ? Object.getPrototypeOf : function(t) { return t.__proto__ || Object.getPrototypeOf(t) }, o(e) }
    t.exports = o
}, function(t, e, o) {
    var n = o(10),
        r = o(9);
    t.exports = function(t, e) { return !e || "object" !== n(e) && "function" != typeof e ? r(t) : e }
}, function(t, e) {
    function o(t, e) {
        for (var o = 0; o < e.length; o++) {
            var n = e[o];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(t, n.key, n)
        }
    }
    t.exports = function(t, e, n) { return e && o(t.prototype, e), n && o(t, n), t }
}, function(t, e) { t.exports = function(t, e) { if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function") } }, function(t, e) {! function() { t.exports = this.wp.plugins }() }, function(t, e, o) {
    "use strict";
    o.r(e);
    var n = o(6),
        r = o(5),
        i = o.n(r),
        c = o(4),
        s = o.n(c),
        u = o(3),
        l = o.n(u),
        p = o(2),
        a = o.n(p),
        f = o(1),
        y = o.n(f),
        b = o(0),
        d = wp.components,
        m = d.Button,
        w = d.Dropdown,
        _ = (d.PanelRow, wp.editPost.PluginPostStatusInfo),
        v = wp.element.Component,
        h = wp.i18n,
        g = h.sprintf,
        O = h.__,
        P = function(t) {
            function e(t) { var o; return i()(this, e), (o = l()(this, a()(e).apply(this, arguments))).state = { currentPostType: window.kwsBlockEditor.currentPostType }, o }
            return y()(e, t), s()(e, [{
                key: "render",
                value: function() {
                    var t = this;
                    return Object(b.createElement)("fieldset", { key: "post-type-switcher-selector", className: "editor-post-visibility__dialog-fieldset" }, Object(b.createElement)("legend", { className: "editor-post-visibility__dialog-legend" }, O("Post Type Changer", "post-type-changer")), window.kwsBlockEditor.availablePostTypes.map(function(e) {
                        var o = e.value,
                            n = e.label;
                        return Object(b.createElement)("div", { key: o, className: "editor-post-visibility__choice" }, Object(b.createElement)("input", {
                            type: "radio",
                            className: "editor-visibility__dialog-radio",
                            name: "editor-post-visibility__setting",
                            value: o,
                            onChange: function() {
                                var e = t.state.currentPostType;
                                t.setState({ currentPostType: o });
                                var n = g(O("Are you sure you want to change this from a '%s' to a '%s'?", "kws"), e, o);
                                window.confirm(n) ? window.location.href = window.kwsBlockEditor.changeUrl + "&kws_post_type=" + o : t.setState({ currentPostType: e })
                            },
                            checked: o === t.state.currentPostType,
                            id: "editor-post-type-changer-".concat(o)
                        }), Object(b.createElement)("label", { htmlFor: "editor-post-type-changer-".concat(o), className: "editor-post-visibility__dialog-label" }, n))
                    }))
                }
            }]), e
        }(v),
        j = function(t) {
            t.children, t.className;
            return Object(b.createElement)(_, null, Object(b.createElement)("span", null, O("Post Type")), Object(b.createElement)(w, {
                position: "bottom left",
                contentClassName: "edit-post-post-visibility__dialog",
                renderToggle: function(t) {
                    var e = t.isOpen,
                        o = t.onToggle;
                    return Object(b.createElement)(m, { type: "button", "aria-expanded": e, className: "edit-post-post-visibility__toggle", onClick: o, isLink: !0 }, window.kwsBlockEditor.currentPostTypeLabel)
                },
                renderContent: function() { return Object(b.createElement)(P, null) }
            }))
        };
    Object(n.registerPlugin)("post-type-switcher", { render: j })
}, function(t, e) {
    function o(e, n) { return t.exports = o = Object.setPrototypeOf || function(t, e) { return t.__proto__ = e, t }, o(e, n) }
    t.exports = o
}, function(t, e) { t.exports = function(t) { if (void 0 === t) throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); return t } }, function(t, e) {
    function o(t) { return (o = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) { return typeof t } : function(t) { return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t })(t) }

    function n(e) { return "function" == typeof Symbol && "symbol" === o(Symbol.iterator) ? t.exports = n = function(t) { return o(t) } : t.exports = n = function(t) { return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : o(t) }, n(e) }
    t.exports = n
}]);