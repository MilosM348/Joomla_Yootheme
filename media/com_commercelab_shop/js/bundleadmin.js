
// OLD
// "id": 104108958,
// "token": "6afbbf2d93",

window.FontAwesomeKitConfig = {
    "asyncLoading": {
        "enabled": false
    },
    "autoA11y": {
        "enabled": true
    },
    "baseUrl": "https://ka-p.fontawesome.com",
    "baseUrlKit": "https://kit.fontawesome.com",
    "detectConflictsUntil": null,
    "iconUploads": {},
    "id": 104108958,
    "license": "free",
    "method": "js",
    "minify": {
        "enabled": true
    },
    "token": "b3d7b5b2b6",
    "uploadsUrl": "https://kit-uploads.fontawesome.com",
    "v4FontFaceShim": {
        "enabled": false
    },
    "v4shim": {
        "enabled": false
    },
    "version": "5.15.4"
};
! function(t) {
    "function" == typeof define && define.amd ? define("kit-loader", t) : t()
}((function() {
    "use strict";

    function t(e) {
        return (t = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(t) {
            return typeof t
        } : function(t) {
            return t && "function" == typeof Symbol && t.constructor === Symbol && t !== Symbol.prototype ? "symbol" : typeof t
        })(e)
    }

    function e(t, e, n) {
        return e in t ? Object.defineProperty(t, e, {
            value: n,
            enumerable: !0,
            configurable: !0,
            writable: !0
        }) : t[e] = n, t
    }

    function n(t, e) {
        var n = Object.keys(t);
        if (Object.getOwnPropertySymbols) {
            var r = Object.getOwnPropertySymbols(t);
            e && (r = r.filter((function(e) {
                return Object.getOwnPropertyDescriptor(t, e).enumerable
            }))), n.push.apply(n, r)
        }
        return n
    }

    function r(t) {
        for (var r = 1; r < arguments.length; r++) {
            var o = null != arguments[r] ? arguments[r] : {};
            r % 2 ? n(Object(o), !0).forEach((function(n) {
                e(t, n, o[n])
            })) : Object.getOwnPropertyDescriptors ? Object.defineProperties(t, Object.getOwnPropertyDescriptors(o)) : n(Object(o)).forEach((function(e) {
                Object.defineProperty(t, e, Object.getOwnPropertyDescriptor(o, e))
            }))
        }
        return t
    }

    function o(t, e) {
        return function(t) {
            if (Array.isArray(t)) return t
        }(t) || function(t, e) {
            if ("undefined" == typeof Symbol || !(Symbol.iterator in Object(t))) return;
            var n = [],
                r = !0,
                o = !1,
                i = void 0;
            try {
                for (var c, a = t[Symbol.iterator](); !(r = (c = a.next()).done) && (n.push(c.value), !e || n.length !== e); r = !0);
            } catch (t) {
                o = !0, i = t
            } finally {
                try {
                    r || null == a.return || a.return()
                } finally {
                    if (o) throw i
                }
            }
            return n
        }(t, e) || function(t, e) {
            if (!t) return;
            if ("string" == typeof t) return i(t, e);
            var n = Object.prototype.toString.call(t).slice(8, -1);
            "Object" === n && t.constructor && (n = t.constructor.name);
            if ("Map" === n || "Set" === n) return Array.from(t);
            if ("Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return i(t, e)
        }(t, e) || function() {
            throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
        }()
    }

    function i(t, e) {
        (null == e || e > t.length) && (e = t.length);
        for (var n = 0, r = new Array(e); n < e; n++) r[n] = t[n];
        return r
    }

    function c(t, e) {
        var n = e && e.addOn || "",
            r = e && e.baseFilename || t.license + n,
            o = e && e.minify ? ".min" : "",
            i = e && e.fileSuffix || t.method,
            c = e && e.subdir || t.method;
        return t.baseUrl + "/releases/" + ("latest" === t.version ? "latest" : "v".concat(t.version)) + "/" + c + "/" + r + o + "." + i
    }

    function a(t) {
        return t.baseUrlKit + "/" + t.token + "/" + t.id + "/kit-upload.css"
    }

    function u(t, e) {
        var n = e || ["fa"],
            r = "." + Array.prototype.join.call(n, ",."),
            o = t.querySelectorAll(r);
        Array.prototype.forEach.call(o, (function(e) {
            var n = e.getAttribute("title");
            e.setAttribute("aria-hidden", "true");
            var r = !e.nextElementSibling || !e.nextElementSibling.classList.contains("sr-only");
            if (n && r) {
                var o = t.createElement("span");
                o.innerHTML = n, o.classList.add("sr-only"), e.parentNode.insertBefore(o, e.nextSibling)
            }
        }))
    }
    var f, s = function() {},
        d = "undefined" != typeof global && void 0 !== global.process && "function" == typeof global.process.emit,
        l = "undefined" == typeof setImmediate ? setTimeout : setImmediate,
        h = [];

    function m() {
        for (var t = 0; t < h.length; t++) h[t][0](h[t][1]);
        h = [], f = !1
    }

    function p(t, e) {
        h.push([t, e]), f || (f = !0, l(m, 0))
    }

    function y(t) {
        var e = t.owner,
            n = e._state,
            r = e._data,
            o = t[n],
            i = t.then;
        if ("function" == typeof o) {
            n = "fulfilled";
            try {
                r = o(r)
            } catch (t) {
                w(i, t)
            }
        }
        b(i, r) || ("fulfilled" === n && v(i, r), "rejected" === n && w(i, r))
    }

    function b(e, n) {
        var r;
        try {
            if (e === n) throw new TypeError("A promises callback cannot return that same promise.");
            if (n && ("function" == typeof n || "object" === t(n))) {
                var o = n.then;
                if ("function" == typeof o) return o.call(n, (function(t) {
                    r || (r = !0, n === t ? g(e, t) : v(e, t))
                }), (function(t) {
                    r || (r = !0, w(e, t))
                })), !0
            }
        } catch (t) {
            return r || w(e, t), !0
        }
        return !1
    }

    function v(t, e) {
        t !== e && b(t, e) || g(t, e)
    }

    function g(t, e) {
        "pending" === t._state && (t._state = "settled", t._data = e, p(S, t))
    }

    function w(t, e) {
        "pending" === t._state && (t._state = "settled", t._data = e, p(O, t))
    }

    function A(t) {
        t._then = t._then.forEach(y)
    }

    function S(t) {
        t._state = "fulfilled", A(t)
    }

    function O(t) {
        t._state = "rejected", A(t), !t._handled && d && global.process.emit("unhandledRejection", t._data, t)
    }

    function j(t) {
        global.process.emit("rejectionHandled", t)
    }

    function E(t) {
        if ("function" != typeof t) throw new TypeError("Promise resolver " + t + " is not a function");
        if (this instanceof E == !1) throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.");
        this._then = [],
            function(t, e) {
                function n(t) {
                    w(e, t)
                }
                try {
                    t((function(t) {
                        v(e, t)
                    }), n)
                } catch (t) {
                    n(t)
                }
            }(t, this)
    }
    E.prototype = {
        constructor: E,
        _state: "pending",
        _then: null,
        _data: void 0,
        _handled: !1,
        then: function(t, e) {
            var n = {
                owner: this,
                then: new this.constructor(s),
                fulfilled: t,
                rejected: e
            };
            return !e && !t || this._handled || (this._handled = !0, "rejected" === this._state && d && p(j, this)), "fulfilled" === this._state || "rejected" === this._state ? p(y, n) : this._then.push(n), n.then
        },
        catch: function(t) {
            return this.then(null, t)
        }
    }, E.all = function(t) {
        if (!Array.isArray(t)) throw new TypeError("You must pass an array to Promise.all().");
        return new E((function(e, n) {
            var r = [],
                o = 0;

            function i(t) {
                return o++,
                    function(n) {
                        r[t] = n, --o || e(r)
                    }
            }
            for (var c, a = 0; a < t.length; a++)(c = t[a]) && "function" == typeof c.then ? c.then(i(a), n) : r[a] = c;
            o || e(r)
        }))
    }, E.race = function(t) {
        if (!Array.isArray(t)) throw new TypeError("You must pass an array to Promise.race().");
        return new E((function(e, n) {
            for (var r, o = 0; o < t.length; o++)(r = t[o]) && "function" == typeof r.then ? r.then(e, n) : e(r)
        }))
    }, E.resolve = function(e) {
        return e && "object" === t(e) && e.constructor === E ? e : new E((function(t) {
            t(e)
        }))
    }, E.reject = function(t) {
        return new E((function(e, n) {
            n(t)
        }))
    };
    var _ = "function" == typeof Promise ? Promise : E;

    function P(t, e) {
        var n = e.fetch,
            r = e.XMLHttpRequest,
            o = e.token,
            i = t;
        return "URLSearchParams" in window ? (i = new URL(t)).searchParams.set("token", o) : i = i + "?token=" + encodeURIComponent(o), i = i.toString(), new _((function(t, e) {
            if ("function" == typeof n) n(i, {
                mode: "cors",
                cache: "default"
            }).then((function(t) {
                if (t.ok) return t.text();
                throw new Error("")
            })).then((function(e) {
                t(e)
            })).catch(e);
            else if ("function" == typeof r) {
                var o = new r;
                o.addEventListener("loadend", (function() {
                    this.responseText ? t(this.responseText) : e(new Error(""))
                }));
                ["abort", "error", "timeout"].map((function(t) {
                    o.addEventListener(t, (function() {
                        e(new Error(""))
                    }))
                })), o.open("GET", i), o.send()
            } else {
                e(new Error(""))
            }
        }))
    }

    function C(t, e, n) {
        var r = t;
        return [
            [/(url\("?)\.\.\/\.\.\/\.\./g, function(t, n) {
                return "".concat(n).concat(e)
            }],
            [/(url\("?)\.\.\/webfonts/g, function(t, r) {
                return "".concat(r).concat(e, "/releases/v").concat(n, "/webfonts")
            }],
            [/(url\("?)https:\/\/kit-free([^.])*\.fontawesome\.com/g, function(t, n) {
                return "".concat(n).concat(e)
            }]
        ].forEach((function(t) {
            var e = o(t, 2),
                n = e[0],
                i = e[1];
            r = r.replace(n, i)
        })), r
    }

    function F(t, e) {
        var n = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : function() {},
            o = e.document || o,
            i = u.bind(u, o, ["fa", "fab", "fas", "far", "fal", "fad", "fak"]),
            f = Object.keys(t.iconUploads || {}).length > 0;
        t.autoA11y.enabled && n(i);
        var s = [{
            id: "fa-main",
            addOn: void 0
        }];
        t.v4shim.enabled && s.push({
            id: "fa-v4-shims",
            addOn: "-v4-shims"
        }), t.v4FontFaceShim.enabled && s.push({
            id: "fa-v4-font-face",
            addOn: "-v4-font-face"
        }), f && s.push({
            id: "fa-kit-upload",
            customCss: !0
        });
        var d = s.map((function(n) {
            return new _((function(o, i) {
                P(n.customCss ? a(t) : c(t, {
                    addOn: n.addOn,
                    minify: t.minify.enabled
                }), e).then((function(i) {
                    o(U(i, r(r({}, e), {}, {
                        baseUrl: t.baseUrl,
                        version: t.version,
                        id: n.id,
                        contentFilter: function(t, e) {
                            return C(t, e.baseUrl, e.version)
                        }
                    })))
                })).catch(i)
            }))
        }));
        return _.all(d)
    }

    function U(t, e) {
        var n = e.contentFilter || function(t, e) {
                return t
            },
            r = document.createElement("style"),
            o = document.createTextNode(n(t, e));
        return r.appendChild(o), r.media = "all", e.id && r.setAttribute("id", e.id), e && e.detectingConflicts && e.detectionIgnoreAttr && r.setAttributeNode(document.createAttribute(e.detectionIgnoreAttr)), r
    }

    function k(t, e) {
        e.autoA11y = t.autoA11y.enabled, "pro" === t.license && (e.autoFetchSvg = !0, e.fetchSvgFrom = t.baseUrl + "/releases/" + ("latest" === t.version ? "latest" : "v".concat(t.version)) + "/svgs", e.fetchUploadedSvgFrom = t.uploadsUrl);
        var n = [];
        return t.v4shim.enabled && n.push(new _((function(n, o) {
            P(c(t, {
                addOn: "-v4-shims",
                minify: t.minify.enabled
            }), e).then((function(t) {
                n(I(t, r(r({}, e), {}, {
                    id: "fa-v4-shims"
                })))
            })).catch(o)
        }))), n.push(new _((function(n, o) {
            P(c(t, {
                minify: t.minify.enabled
            }), e).then((function(t) {
                var o = I(t, r(r({}, e), {}, {
                    id: "fa-main"
                }));
                n(function(t, e) {
                    var n = e && void 0 !== e.autoFetchSvg ? e.autoFetchSvg : void 0,
                        r = e && void 0 !== e.autoA11y ? e.autoA11y : void 0;
                    void 0 !== r && t.setAttribute("data-auto-a11y", r ? "true" : "false");
                    n && (t.setAttributeNode(document.createAttribute("data-auto-fetch-svg")), t.setAttribute("data-fetch-svg-from", e.fetchSvgFrom), t.setAttribute("data-fetch-uploaded-svg-from", e.fetchUploadedSvgFrom));
                    return t
                }(o, e))
            })).catch(o)
        }))), _.all(n)
    }

    function I(t, e) {
        var n = document.createElement("SCRIPT"),
            r = document.createTextNode(t);
        return n.appendChild(r), n.referrerPolicy = "strict-origin", e.id && n.setAttribute("id", e.id), e && e.detectingConflicts && e.detectionIgnoreAttr && n.setAttributeNode(document.createAttribute(e.detectionIgnoreAttr)), n
    }

    function L(t) {
        var e, n = [],
            r = document,
            o = r.documentElement.doScroll,
            i = (o ? /^loaded|^c/ : /^loaded|^i|^c/).test(r.readyState);
        i || r.addEventListener("DOMContentLoaded", e = function() {
            for (r.removeEventListener("DOMContentLoaded", e), i = 1; e = n.shift();) e()
        }), i ? setTimeout(t, 0) : n.push(t)
    }

    function T(t) {
        "undefined" != typeof MutationObserver && new MutationObserver(t).observe(document, {
            childList: !0,
            subtree: !0
        })
    }
    try {
        if (window.FontAwesomeKitConfig) {
            var x = window.FontAwesomeKitConfig,
                M = {
                    detectingConflicts: x.detectConflictsUntil && new Date <= new Date(x.detectConflictsUntil),
                    detectionIgnoreAttr: "data-fa-detection-ignore",
                    fetch: window.fetch,
                    token: x.token,
                    XMLHttpRequest: window.XMLHttpRequest,
                    document: document
                },
                D = document.currentScript,
                N = D ? D.parentElement : document.head;
            (function() {
                var t = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {},
                    e = arguments.length > 1 && void 0 !== arguments[1] ? arguments[1] : {};
                return "js" === t.method ? k(t, e) : "css" === t.method ? F(t, e, (function(t) {
                    L(t), T(t)
                })) : void 0
            })(x, M).then((function(t) {
                t.map((function(t) {
                    try {
                        N.insertBefore(t, D ? D.nextSibling : null)
                    } catch (e) {
                        N.appendChild(t)
                    }
                })), M.detectingConflicts && D && L((function() {
                    D.setAttributeNode(document.createAttribute(M.detectionIgnoreAttr));
                    var t = function(t, e) {
                        var n = document.createElement("script");
                        return e && e.detectionIgnoreAttr && n.setAttributeNode(document.createAttribute(e.detectionIgnoreAttr)), n.src = c(t, {
                            baseFilename: "conflict-detection",
                            fileSuffix: "js",
                            subdir: "js",
                            minify: t.minify.enabled
                        }), n
                    }(x, M);
                    document.body.appendChild(t)
                }))
            })).catch((function(t) {
                console.error("".concat("Font Awesome Kit:", " ").concat(t))
            }))
        }
    } catch (t) {
        console.error("".concat("Font Awesome Kit:", " ").concat(t))
    }
}));


/*!
 * Chart.js v3.5.0
 * https://www.chartjs.org
 * (c) 2021 Chart.js Contributors
 * Released under the MIT License
 */
! function(t, e) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define(e) : (t = "undefined" != typeof globalThis ? globalThis : t || self).Chart = e()
}(this, (function() {
    "use strict";
    const t = "undefined" == typeof window ? function(t) {
        return t()
    } : window.requestAnimationFrame;

    function e(e, i, n) {
        const o = n || (t => Array.prototype.slice.call(t));
        let s = !1,
            a = [];
        return function(...n) {
            a = o(n), s || (s = !0, t.call(window, (() => {
                s = !1, e.apply(i, a)
            })))
        }
    }

    function i(t, e) {
        let i;
        return function() {
            return e ? (clearTimeout(i), i = setTimeout(t, e)) : t(), e
        }
    }
    const n = t => "start" === t ? "left" : "end" === t ? "right" : "center",
        o = (t, e, i) => "start" === t ? e : "end" === t ? i : (e + i) / 2,
        s = (t, e, i, n) => t === (n ? "left" : "right") ? i : "center" === t ? (e + i) / 2 : e;
    var a = new class {
        constructor() {
            this._request = null, this._charts = new Map, this._running = !1, this._lastDate = void 0
        }
        _notify(t, e, i, n) {
            const o = e.listeners[n],
                s = e.duration;
            o.forEach((n => n({
                chart: t,
                initial: e.initial,
                numSteps: s,
                currentStep: Math.min(i - e.start, s)
            })))
        }
        _refresh() {
            const e = this;
            e._request || (e._running = !0, e._request = t.call(window, (() => {
                e._update(), e._request = null, e._running && e._refresh()
            })))
        }
        _update(t = Date.now()) {
            const e = this;
            let i = 0;
            e._charts.forEach(((n, o) => {
                if (!n.running || !n.items.length) return;
                const s = n.items;
                let a, r = s.length - 1,
                    l = !1;
                for (; r >= 0; --r) a = s[r], a._active ? (a._total > n.duration && (n.duration = a._total), a.tick(t), l = !0) : (s[r] = s[s.length - 1], s.pop());
                l && (o.draw(), e._notify(o, n, t, "progress")), s.length || (n.running = !1, e._notify(o, n, t, "complete"), n.initial = !1), i += s.length
            })), e._lastDate = t, 0 === i && (e._running = !1)
        }
        _getAnims(t) {
            const e = this._charts;
            let i = e.get(t);
            return i || (i = {
                running: !1,
                initial: !0,
                items: [],
                listeners: {
                    complete: [],
                    progress: []
                }
            }, e.set(t, i)), i
        }
        listen(t, e, i) {
            this._getAnims(t).listeners[e].push(i)
        }
        add(t, e) {
            e && e.length && this._getAnims(t).items.push(...e)
        }
        has(t) {
            return this._getAnims(t).items.length > 0
        }
        start(t) {
            const e = this._charts.get(t);
            e && (e.running = !0, e.start = Date.now(), e.duration = e.items.reduce(((t, e) => Math.max(t, e._duration)), 0), this._refresh())
        }
        running(t) {
            if (!this._running) return !1;
            const e = this._charts.get(t);
            return !!(e && e.running && e.items.length)
        }
        stop(t) {
            const e = this._charts.get(t);
            if (!e || !e.items.length) return;
            const i = e.items;
            let n = i.length - 1;
            for (; n >= 0; --n) i[n].cancel();
            e.items = [], this._notify(t, e, Date.now(), "complete")
        }
        remove(t) {
            return this._charts.delete(t)
        }
    };
    /*!
     * @kurkle/color v0.1.9
     * https://github.com/kurkle/color#readme
     * (c) 2020 Jukka Kurkela
     * Released under the MIT License
     */
    const r = {
            0: 0,
            1: 1,
            2: 2,
            3: 3,
            4: 4,
            5: 5,
            6: 6,
            7: 7,
            8: 8,
            9: 9,
            A: 10,
            B: 11,
            C: 12,
            D: 13,
            E: 14,
            F: 15,
            a: 10,
            b: 11,
            c: 12,
            d: 13,
            e: 14,
            f: 15
        },
        l = "0123456789ABCDEF",
        c = t => l[15 & t],
        h = t => l[(240 & t) >> 4] + l[15 & t],
        d = t => (240 & t) >> 4 == (15 & t);

    function u(t) {
        var e = function(t) {
            return d(t.r) && d(t.g) && d(t.b) && d(t.a)
        }(t) ? c : h;
        return t ? "#" + e(t.r) + e(t.g) + e(t.b) + (t.a < 255 ? e(t.a) : "") : t
    }

    function f(t) {
        return t + .5 | 0
    }
    const g = (t, e, i) => Math.max(Math.min(t, i), e);

    function p(t) {
        return g(f(2.55 * t), 0, 255)
    }

    function m(t) {
        return g(f(255 * t), 0, 255)
    }

    function x(t) {
        return g(f(t / 2.55) / 100, 0, 1)
    }

    function b(t) {
        return g(f(100 * t), 0, 100)
    }
    const _ = /^rgba?\(\s*([-+.\d]+)(%)?[\s,]+([-+.e\d]+)(%)?[\s,]+([-+.e\d]+)(%)?(?:[\s,/]+([-+.e\d]+)(%)?)?\s*\)$/;
    const y = /^(hsla?|hwb|hsv)\(\s*([-+.e\d]+)(?:deg)?[\s,]+([-+.e\d]+)%[\s,]+([-+.e\d]+)%(?:[\s,]+([-+.e\d]+)(%)?)?\s*\)$/;

    function v(t, e, i) {
        const n = e * Math.min(i, 1 - i),
            o = (e, o = (e + t / 30) % 12) => i - n * Math.max(Math.min(o - 3, 9 - o, 1), -1);
        return [o(0), o(8), o(4)]
    }

    function w(t, e, i) {
        const n = (n, o = (n + t / 60) % 6) => i - i * e * Math.max(Math.min(o, 4 - o, 1), 0);
        return [n(5), n(3), n(1)]
    }

    function M(t, e, i) {
        const n = v(t, 1, .5);
        let o;
        for (e + i > 1 && (o = 1 / (e + i), e *= o, i *= o), o = 0; o < 3; o++) n[o] *= 1 - e - i, n[o] += e;
        return n
    }

    function k(t) {
        const e = t.r / 255,
            i = t.g / 255,
            n = t.b / 255,
            o = Math.max(e, i, n),
            s = Math.min(e, i, n),
            a = (o + s) / 2;
        let r, l, c;
        return o !== s && (c = o - s, l = a > .5 ? c / (2 - o - s) : c / (o + s), r = o === e ? (i - n) / c + (i < n ? 6 : 0) : o === i ? (n - e) / c + 2 : (e - i) / c + 4, r = 60 * r + .5), [0 | r, l || 0, a]
    }

    function S(t, e, i, n) {
        return (Array.isArray(e) ? t(e[0], e[1], e[2]) : t(e, i, n)).map(m)
    }

    function P(t, e, i) {
        return S(v, t, e, i)
    }

    function D(t) {
        return (t % 360 + 360) % 360
    }

    function C(t) {
        const e = y.exec(t);
        let i, n = 255;
        if (!e) return;
        e[5] !== i && (n = e[6] ? p(+e[5]) : m(+e[5]));
        const o = D(+e[2]),
            s = +e[3] / 100,
            a = +e[4] / 100;
        return i = "hwb" === e[1] ? function(t, e, i) {
            return S(M, t, e, i)
        }(o, s, a) : "hsv" === e[1] ? function(t, e, i) {
            return S(w, t, e, i)
        }(o, s, a) : P(o, s, a), {
            r: i[0],
            g: i[1],
            b: i[2],
            a: n
        }
    }
    const O = {
            x: "dark",
            Z: "light",
            Y: "re",
            X: "blu",
            W: "gr",
            V: "medium",
            U: "slate",
            A: "ee",
            T: "ol",
            S: "or",
            B: "ra",
            C: "lateg",
            D: "ights",
            R: "in",
            Q: "turquois",
            E: "hi",
            P: "ro",
            O: "al",
            N: "le",
            M: "de",
            L: "yello",
            F: "en",
            K: "ch",
            G: "arks",
            H: "ea",
            I: "ightg",
            J: "wh"
        },
        T = {
            OiceXe: "f0f8ff",
            antiquewEte: "faebd7",
            aqua: "ffff",
            aquamarRe: "7fffd4",
            azuY: "f0ffff",
            beige: "f5f5dc",
            bisque: "ffe4c4",
            black: "0",
            blanKedOmond: "ffebcd",
            Xe: "ff",
            XeviTet: "8a2be2",
            bPwn: "a52a2a",
            burlywood: "deb887",
            caMtXe: "5f9ea0",
            KartYuse: "7fff00",
            KocTate: "d2691e",
            cSO: "ff7f50",
            cSnflowerXe: "6495ed",
            cSnsilk: "fff8dc",
            crimson: "dc143c",
            cyan: "ffff",
            xXe: "8b",
            xcyan: "8b8b",
            xgTMnPd: "b8860b",
            xWay: "a9a9a9",
            xgYF: "6400",
            xgYy: "a9a9a9",
            xkhaki: "bdb76b",
            xmagFta: "8b008b",
            xTivegYF: "556b2f",
            xSange: "ff8c00",
            xScEd: "9932cc",
            xYd: "8b0000",
            xsOmon: "e9967a",
            xsHgYF: "8fbc8f",
            xUXe: "483d8b",
            xUWay: "2f4f4f",
            xUgYy: "2f4f4f",
            xQe: "ced1",
            xviTet: "9400d3",
            dAppRk: "ff1493",
            dApskyXe: "bfff",
            dimWay: "696969",
            dimgYy: "696969",
            dodgerXe: "1e90ff",
            fiYbrick: "b22222",
            flSOwEte: "fffaf0",
            foYstWAn: "228b22",
            fuKsia: "ff00ff",
            gaRsbSo: "dcdcdc",
            ghostwEte: "f8f8ff",
            gTd: "ffd700",
            gTMnPd: "daa520",
            Way: "808080",
            gYF: "8000",
            gYFLw: "adff2f",
            gYy: "808080",
            honeyMw: "f0fff0",
            hotpRk: "ff69b4",
            RdianYd: "cd5c5c",
            Rdigo: "4b0082",
            ivSy: "fffff0",
            khaki: "f0e68c",
            lavFMr: "e6e6fa",
            lavFMrXsh: "fff0f5",
            lawngYF: "7cfc00",
            NmoncEffon: "fffacd",
            ZXe: "add8e6",
            ZcSO: "f08080",
            Zcyan: "e0ffff",
            ZgTMnPdLw: "fafad2",
            ZWay: "d3d3d3",
            ZgYF: "90ee90",
            ZgYy: "d3d3d3",
            ZpRk: "ffb6c1",
            ZsOmon: "ffa07a",
            ZsHgYF: "20b2aa",
            ZskyXe: "87cefa",
            ZUWay: "778899",
            ZUgYy: "778899",
            ZstAlXe: "b0c4de",
            ZLw: "ffffe0",
            lime: "ff00",
            limegYF: "32cd32",
            lRF: "faf0e6",
            magFta: "ff00ff",
            maPon: "800000",
            VaquamarRe: "66cdaa",
            VXe: "cd",
            VScEd: "ba55d3",
            VpurpN: "9370db",
            VsHgYF: "3cb371",
            VUXe: "7b68ee",
            VsprRggYF: "fa9a",
            VQe: "48d1cc",
            VviTetYd: "c71585",
            midnightXe: "191970",
            mRtcYam: "f5fffa",
            mistyPse: "ffe4e1",
            moccasR: "ffe4b5",
            navajowEte: "ffdead",
            navy: "80",
            Tdlace: "fdf5e6",
            Tive: "808000",
            TivedBb: "6b8e23",
            Sange: "ffa500",
            SangeYd: "ff4500",
            ScEd: "da70d6",
            pOegTMnPd: "eee8aa",
            pOegYF: "98fb98",
            pOeQe: "afeeee",
            pOeviTetYd: "db7093",
            papayawEp: "ffefd5",
            pHKpuff: "ffdab9",
            peru: "cd853f",
            pRk: "ffc0cb",
            plum: "dda0dd",
            powMrXe: "b0e0e6",
            purpN: "800080",
            YbeccapurpN: "663399",
            Yd: "ff0000",
            Psybrown: "bc8f8f",
            PyOXe: "4169e1",
            saddNbPwn: "8b4513",
            sOmon: "fa8072",
            sandybPwn: "f4a460",
            sHgYF: "2e8b57",
            sHshell: "fff5ee",
            siFna: "a0522d",
            silver: "c0c0c0",
            skyXe: "87ceeb",
            UXe: "6a5acd",
            UWay: "708090",
            UgYy: "708090",
            snow: "fffafa",
            sprRggYF: "ff7f",
            stAlXe: "4682b4",
            tan: "d2b48c",
            teO: "8080",
            tEstN: "d8bfd8",
            tomato: "ff6347",
            Qe: "40e0d0",
            viTet: "ee82ee",
            JHt: "f5deb3",
            wEte: "ffffff",
            wEtesmoke: "f5f5f5",
            Lw: "ffff00",
            LwgYF: "9acd32"
        };
    let A;

    function L(t) {
        A || (A = function() {
            const t = {},
                e = Object.keys(T),
                i = Object.keys(O);
            let n, o, s, a, r;
            for (n = 0; n < e.length; n++) {
                for (a = r = e[n], o = 0; o < i.length; o++) s = i[o], r = r.replace(s, O[s]);
                s = parseInt(T[a], 16), t[r] = [s >> 16 & 255, s >> 8 & 255, 255 & s]
            }
            return t
        }(), A.transparent = [0, 0, 0, 0]);
        const e = A[t.toLowerCase()];
        return e && {
            r: e[0],
            g: e[1],
            b: e[2],
            a: 4 === e.length ? e[3] : 255
        }
    }

    function R(t, e, i) {
        if (t) {
            let n = k(t);
            n[e] = Math.max(0, Math.min(n[e] + n[e] * i, 0 === e ? 360 : 1)), n = P(n), t.r = n[0], t.g = n[1], t.b = n[2]
        }
    }

    function E(t, e) {
        return t ? Object.assign(e || {}, t) : t
    }

    function I(t) {
        var e = {
            r: 0,
            g: 0,
            b: 0,
            a: 255
        };
        return Array.isArray(t) ? t.length >= 3 && (e = {
            r: t[0],
            g: t[1],
            b: t[2],
            a: 255
        }, t.length > 3 && (e.a = m(t[3]))) : (e = E(t, {
            r: 0,
            g: 0,
            b: 0,
            a: 1
        })).a = m(e.a), e
    }

    function z(t) {
        return "r" === t.charAt(0) ? function(t) {
            const e = _.exec(t);
            let i, n, o, s = 255;
            if (e) {
                if (e[7] !== i) {
                    const t = +e[7];
                    s = 255 & (e[8] ? p(t) : 255 * t)
                }
                return i = +e[1], n = +e[3], o = +e[5], i = 255 & (e[2] ? p(i) : i), n = 255 & (e[4] ? p(n) : n), o = 255 & (e[6] ? p(o) : o), {
                    r: i,
                    g: n,
                    b: o,
                    a: s
                }
            }
        }(t) : C(t)
    }
    class F {
        constructor(t) {
            if (t instanceof F) return t;
            const e = typeof t;
            let i;
            var n, o, s;
            "object" === e ? i = I(t) : "string" === e && (s = (n = t).length, "#" === n[0] && (4 === s || 5 === s ? o = {
                r: 255 & 17 * r[n[1]],
                g: 255 & 17 * r[n[2]],
                b: 255 & 17 * r[n[3]],
                a: 5 === s ? 17 * r[n[4]] : 255
            } : 7 !== s && 9 !== s || (o = {
                r: r[n[1]] << 4 | r[n[2]],
                g: r[n[3]] << 4 | r[n[4]],
                b: r[n[5]] << 4 | r[n[6]],
                a: 9 === s ? r[n[7]] << 4 | r[n[8]] : 255
            })), i = o || L(t) || z(t)), this._rgb = i, this._valid = !!i
        }
        get valid() {
            return this._valid
        }
        get rgb() {
            var t = E(this._rgb);
            return t && (t.a = x(t.a)), t
        }
        set rgb(t) {
            this._rgb = I(t)
        }
        rgbString() {
            return this._valid ? (t = this._rgb) && (t.a < 255 ? `rgba(${t.r}, ${t.g}, ${t.b}, ${x(t.a)})` : `rgb(${t.r}, ${t.g}, ${t.b})`) : this._rgb;
            var t
        }
        hexString() {
            return this._valid ? u(this._rgb) : this._rgb
        }
        hslString() {
            return this._valid ? function(t) {
                if (!t) return;
                const e = k(t),
                    i = e[0],
                    n = b(e[1]),
                    o = b(e[2]);
                return t.a < 255 ? `hsla(${i}, ${n}%, ${o}%, ${x(t.a)})` : `hsl(${i}, ${n}%, ${o}%)`
            }(this._rgb) : this._rgb
        }
        mix(t, e) {
            const i = this;
            if (t) {
                const n = i.rgb,
                    o = t.rgb;
                let s;
                const a = e === s ? .5 : e,
                    r = 2 * a - 1,
                    l = n.a - o.a,
                    c = ((r * l == -1 ? r : (r + l) / (1 + r * l)) + 1) / 2;
                s = 1 - c, n.r = 255 & c * n.r + s * o.r + .5, n.g = 255 & c * n.g + s * o.g + .5, n.b = 255 & c * n.b + s * o.b + .5, n.a = a * n.a + (1 - a) * o.a, i.rgb = n
            }
            return i
        }
        clone() {
            return new F(this.rgb)
        }
        alpha(t) {
            return this._rgb.a = m(t), this
        }
        clearer(t) {
            return this._rgb.a *= 1 - t, this
        }
        greyscale() {
            const t = this._rgb,
                e = f(.3 * t.r + .59 * t.g + .11 * t.b);
            return t.r = t.g = t.b = e, this
        }
        opaquer(t) {
            return this._rgb.a *= 1 + t, this
        }
        negate() {
            const t = this._rgb;
            return t.r = 255 - t.r, t.g = 255 - t.g, t.b = 255 - t.b, this
        }
        lighten(t) {
            return R(this._rgb, 2, t), this
        }
        darken(t) {
            return R(this._rgb, 2, -t), this
        }
        saturate(t) {
            return R(this._rgb, 1, t), this
        }
        desaturate(t) {
            return R(this._rgb, 1, -t), this
        }
        rotate(t) {
            return function(t, e) {
                var i = k(t);
                i[0] = D(i[0] + e), i = P(i), t.r = i[0], t.g = i[1], t.b = i[2]
            }(this._rgb, t), this
        }
    }

    function B(t) {
        return new F(t)
    }
    const V = t => t instanceof CanvasGradient || t instanceof CanvasPattern;

    function W(t) {
        return V(t) ? t : B(t)
    }

    function N(t) {
        return V(t) ? t : B(t).saturate(.5).darken(.1).hexString()
    }

    function H() {}
    const j = function() {
        let t = 0;
        return function() {
            return t++
        }
    }();

    function $(t) {
        return null == t
    }

    function Y(t) {
        if (Array.isArray && Array.isArray(t)) return !0;
        const e = Object.prototype.toString.call(t);
        return "[object" === e.substr(0, 7) && "Array]" === e.substr(-6)
    }

    function U(t) {
        return null !== t && "[object Object]" === Object.prototype.toString.call(t)
    }
    const X = t => ("number" == typeof t || t instanceof Number) && isFinite(+t);

    function q(t, e) {
        return X(t) ? t : e
    }

    function K(t, e) {
        return void 0 === t ? e : t
    }
    const G = (t, e) => "string" == typeof t && t.endsWith("%") ? parseFloat(t) / 100 : t / e,
        Z = (t, e) => "string" == typeof t && t.endsWith("%") ? parseFloat(t) / 100 * e : +t;

    function Q(t, e, i) {
        if (t && "function" == typeof t.call) return t.apply(i, e)
    }

    function J(t, e, i, n) {
        let o, s, a;
        if (Y(t))
            if (s = t.length, n)
                for (o = s - 1; o >= 0; o--) e.call(i, t[o], o);
            else
                for (o = 0; o < s; o++) e.call(i, t[o], o);
        else if (U(t))
            for (a = Object.keys(t), s = a.length, o = 0; o < s; o++) e.call(i, t[a[o]], a[o])
    }

    function tt(t, e) {
        let i, n, o, s;
        if (!t || !e || t.length !== e.length) return !1;
        for (i = 0, n = t.length; i < n; ++i)
            if (o = t[i], s = e[i], o.datasetIndex !== s.datasetIndex || o.index !== s.index) return !1;
        return !0
    }

    function et(t) {
        if (Y(t)) return t.map(et);
        if (U(t)) {
            const e = Object.create(null),
                i = Object.keys(t),
                n = i.length;
            let o = 0;
            for (; o < n; ++o) e[i[o]] = et(t[i[o]]);
            return e
        }
        return t
    }

    function it(t) {
        return -1 === ["__proto__", "prototype", "constructor"].indexOf(t)
    }

    function nt(t, e, i, n) {
        if (!it(t)) return;
        const o = e[t],
            s = i[t];
        U(o) && U(s) ? ot(o, s, n) : e[t] = et(s)
    }

    function ot(t, e, i) {
        const n = Y(e) ? e : [e],
            o = n.length;
        if (!U(t)) return t;
        const s = (i = i || {}).merger || nt;
        for (let a = 0; a < o; ++a) {
            if (!U(e = n[a])) continue;
            const o = Object.keys(e);
            for (let n = 0, a = o.length; n < a; ++n) s(o[n], t, e, i)
        }
        return t
    }

    function st(t, e) {
        return ot(t, e, {
            merger: at
        })
    }

    function at(t, e, i) {
        if (!it(t)) return;
        const n = e[t],
            o = i[t];
        U(n) && U(o) ? st(n, o) : Object.prototype.hasOwnProperty.call(e, t) || (e[t] = et(o))
    }

    function rt(t, e) {
        const i = t.indexOf(".", e);
        return -1 === i ? t.length : i
    }

    function lt(t, e) {
        if ("" === e) return t;
        let i = 0,
            n = rt(e, i);
        for (; t && n > i;) t = t[e.substr(i, n - i)], i = n + 1, n = rt(e, i);
        return t
    }

    function ct(t) {
        return t.charAt(0).toUpperCase() + t.slice(1)
    }
    const ht = t => void 0 !== t,
        dt = t => "function" == typeof t,
        ut = (t, e) => {
            if (t.size !== e.size) return !1;
            for (const i of t)
                if (!e.has(i)) return !1;
            return !0
        },
        ft = Object.create(null),
        gt = Object.create(null);

    function pt(t, e) {
        if (!e) return t;
        const i = e.split(".");
        for (let e = 0, n = i.length; e < n; ++e) {
            const n = i[e];
            t = t[n] || (t[n] = Object.create(null))
        }
        return t
    }

    function mt(t, e, i) {
        return "string" == typeof e ? ot(pt(t, e), i) : ot(pt(t, ""), e)
    }
    var xt = new class {
        constructor(t) {
            this.animation = void 0, this.backgroundColor = "rgba(0,0,0,0.1)", this.borderColor = "rgba(0,0,0,0.1)", this.color = "#666", this.datasets = {}, this.devicePixelRatio = t => t.chart.platform.getDevicePixelRatio(), this.elements = {}, this.events = ["mousemove", "mouseout", "click", "touchstart", "touchmove"], this.font = {
                family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                size: 12,
                style: "normal",
                lineHeight: 1.2,
                weight: null
            }, this.hover = {}, this.hoverBackgroundColor = (t, e) => N(e.backgroundColor), this.hoverBorderColor = (t, e) => N(e.borderColor), this.hoverColor = (t, e) => N(e.color), this.indexAxis = "x", this.interaction = {
                mode: "nearest",
                intersect: !0
            }, this.maintainAspectRatio = !0, this.onHover = null, this.onClick = null, this.parsing = !0, this.plugins = {}, this.responsive = !0, this.scale = void 0, this.scales = {}, this.showLine = !0, this.describe(t)
        }
        set(t, e) {
            return mt(this, t, e)
        }
        get(t) {
            return pt(this, t)
        }
        describe(t, e) {
            return mt(gt, t, e)
        }
        override(t, e) {
            return mt(ft, t, e)
        }
        route(t, e, i, n) {
            const o = pt(this, t),
                s = pt(this, i),
                a = "_" + e;
            Object.defineProperties(o, {
                [a]: {
                    value: o[e],
                    writable: !0
                },
                [e]: {
                    enumerable: !0,
                    get() {
                        const t = this[a],
                            e = s[n];
                        return U(t) ? Object.assign({}, e, t) : K(t, e)
                    },
                    set(t) {
                        this[a] = t
                    }
                }
            })
        }
    }({
        _scriptable: t => !t.startsWith("on"),
        _indexable: t => "events" !== t,
        hover: {
            _fallback: "interaction"
        },
        interaction: {
            _scriptable: !1,
            _indexable: !1
        }
    });
    const bt = Math.PI,
        _t = 2 * bt,
        yt = _t + bt,
        vt = Number.POSITIVE_INFINITY,
        wt = bt / 180,
        Mt = bt / 2,
        kt = bt / 4,
        St = 2 * bt / 3,
        Pt = Math.log10,
        Dt = Math.sign;

    function Ct(t) {
        const e = Math.round(t);
        t = At(t, e, t / 1e3) ? e : t;
        const i = Math.pow(10, Math.floor(Pt(t))),
            n = t / i;
        return (n <= 1 ? 1 : n <= 2 ? 2 : n <= 5 ? 5 : 10) * i
    }

    function Ot(t) {
        const e = [],
            i = Math.sqrt(t);
        let n;
        for (n = 1; n < i; n++) t % n == 0 && (e.push(n), e.push(t / n));
        return i === (0 | i) && e.push(i), e.sort(((t, e) => t - e)).pop(), e
    }

    function Tt(t) {
        return !isNaN(parseFloat(t)) && isFinite(t)
    }

    function At(t, e, i) {
        return Math.abs(t - e) < i
    }

    function Lt(t, e) {
        const i = Math.round(t);
        return i - e <= t && i + e >= t
    }

    function Rt(t, e, i) {
        let n, o, s;
        for (n = 0, o = t.length; n < o; n++) s = t[n][i], isNaN(s) || (e.min = Math.min(e.min, s), e.max = Math.max(e.max, s))
    }

    function Et(t) {
        return t * (bt / 180)
    }

    function It(t) {
        return t * (180 / bt)
    }

    function zt(t) {
        if (!X(t)) return;
        let e = 1,
            i = 0;
        for (; Math.round(t * e) / e !== t;) e *= 10, i++;
        return i
    }

    function Ft(t, e) {
        const i = e.x - t.x,
            n = e.y - t.y,
            o = Math.sqrt(i * i + n * n);
        let s = Math.atan2(n, i);
        return s < -.5 * bt && (s += _t), {
            angle: s,
            distance: o
        }
    }

    function Bt(t, e) {
        return Math.sqrt(Math.pow(e.x - t.x, 2) + Math.pow(e.y - t.y, 2))
    }

    function Vt(t, e) {
        return (t - e + yt) % _t - bt
    }

    function Wt(t) {
        return (t % _t + _t) % _t
    }

    function Nt(t, e, i, n) {
        const o = Wt(t),
            s = Wt(e),
            a = Wt(i),
            r = Wt(s - o),
            l = Wt(a - o),
            c = Wt(o - s),
            h = Wt(o - a);
        return o === s || o === a || n && s === a || r > l && c < h
    }

    function Ht(t, e, i) {
        return Math.max(e, Math.min(i, t))
    }

    function jt(t) {
        return Ht(t, -32768, 32767)
    }

    function $t(t) {
        return !t || $(t.size) || $(t.family) ? null : (t.style ? t.style + " " : "") + (t.weight ? t.weight + " " : "") + t.size + "px " + t.family
    }

    function Yt(t, e, i, n, o) {
        let s = e[o];
        return s || (s = e[o] = t.measureText(o).width, i.push(o)), s > n && (n = s), n
    }

    function Ut(t, e, i, n) {
        let o = (n = n || {}).data = n.data || {},
            s = n.garbageCollect = n.garbageCollect || [];
        n.font !== e && (o = n.data = {}, s = n.garbageCollect = [], n.font = e), t.save(), t.font = e;
        let a = 0;
        const r = i.length;
        let l, c, h, d, u;
        for (l = 0; l < r; l++)
            if (d = i[l], null != d && !0 !== Y(d)) a = Yt(t, o, s, a, d);
            else if (Y(d))
            for (c = 0, h = d.length; c < h; c++) u = d[c], null == u || Y(u) || (a = Yt(t, o, s, a, u));
        t.restore();
        const f = s.length / 2;
        if (f > i.length) {
            for (l = 0; l < f; l++) delete o[s[l]];
            s.splice(0, f)
        }
        return a
    }

    function Xt(t, e, i) {
        const n = t.currentDevicePixelRatio,
            o = 0 !== i ? Math.max(i / 2, .5) : 0;
        return Math.round((e - o) * n) / n + o
    }

    function qt(t, e) {
        (e = e || t.getContext("2d")).save(), e.resetTransform(), e.clearRect(0, 0, t.width, t.height), e.restore()
    }

    function Kt(t, e, i, n) {
        let o, s, a, r, l;
        const c = e.pointStyle,
            h = e.rotation,
            d = e.radius;
        let u = (h || 0) * wt;
        if (c && "object" == typeof c && (o = c.toString(), "[object HTMLImageElement]" === o || "[object HTMLCanvasElement]" === o)) return t.save(), t.translate(i, n), t.rotate(u), t.drawImage(c, -c.width / 2, -c.height / 2, c.width, c.height), void t.restore();
        if (!(isNaN(d) || d <= 0)) {
            switch (t.beginPath(), c) {
                default:
                    t.arc(i, n, d, 0, _t), t.closePath();
                    break;
                case "triangle":
                    t.moveTo(i + Math.sin(u) * d, n - Math.cos(u) * d), u += St, t.lineTo(i + Math.sin(u) * d, n - Math.cos(u) * d), u += St, t.lineTo(i + Math.sin(u) * d, n - Math.cos(u) * d), t.closePath();
                    break;
                case "rectRounded":
                    l = .516 * d, r = d - l, s = Math.cos(u + kt) * r, a = Math.sin(u + kt) * r, t.arc(i - s, n - a, l, u - bt, u - Mt), t.arc(i + a, n - s, l, u - Mt, u), t.arc(i + s, n + a, l, u, u + Mt), t.arc(i - a, n + s, l, u + Mt, u + bt), t.closePath();
                    break;
                case "rect":
                    if (!h) {
                        r = Math.SQRT1_2 * d, t.rect(i - r, n - r, 2 * r, 2 * r);
                        break
                    }
                    u += kt;
                case "rectRot":
                    s = Math.cos(u) * d, a = Math.sin(u) * d, t.moveTo(i - s, n - a), t.lineTo(i + a, n - s), t.lineTo(i + s, n + a), t.lineTo(i - a, n + s), t.closePath();
                    break;
                case "crossRot":
                    u += kt;
                case "cross":
                    s = Math.cos(u) * d, a = Math.sin(u) * d, t.moveTo(i - s, n - a), t.lineTo(i + s, n + a), t.moveTo(i + a, n - s), t.lineTo(i - a, n + s);
                    break;
                case "star":
                    s = Math.cos(u) * d, a = Math.sin(u) * d, t.moveTo(i - s, n - a), t.lineTo(i + s, n + a), t.moveTo(i + a, n - s), t.lineTo(i - a, n + s), u += kt, s = Math.cos(u) * d, a = Math.sin(u) * d, t.moveTo(i - s, n - a), t.lineTo(i + s, n + a), t.moveTo(i + a, n - s), t.lineTo(i - a, n + s);
                    break;
                case "line":
                    s = Math.cos(u) * d, a = Math.sin(u) * d, t.moveTo(i - s, n - a), t.lineTo(i + s, n + a);
                    break;
                case "dash":
                    t.moveTo(i, n), t.lineTo(i + Math.cos(u) * d, n + Math.sin(u) * d)
            }
            t.fill(), e.borderWidth > 0 && t.stroke()
        }
    }

    function Gt(t, e, i) {
        return i = i || .5, t && e && t.x > e.left - i && t.x < e.right + i && t.y > e.top - i && t.y < e.bottom + i
    }

    function Zt(t, e) {
        t.save(), t.beginPath(), t.rect(e.left, e.top, e.right - e.left, e.bottom - e.top), t.clip()
    }

    function Qt(t) {
        t.restore()
    }

    function Jt(t, e, i, n, o) {
        if (!e) return t.lineTo(i.x, i.y);
        if ("middle" === o) {
            const n = (e.x + i.x) / 2;
            t.lineTo(n, e.y), t.lineTo(n, i.y)
        } else "after" === o != !!n ? t.lineTo(e.x, i.y) : t.lineTo(i.x, e.y);
        t.lineTo(i.x, i.y)
    }

    function te(t, e, i, n) {
        if (!e) return t.lineTo(i.x, i.y);
        t.bezierCurveTo(n ? e.cp1x : e.cp2x, n ? e.cp1y : e.cp2y, n ? i.cp2x : i.cp1x, n ? i.cp2y : i.cp1y, i.x, i.y)
    }

    function ee(t, e, i, n, o, s = {}) {
        const a = Y(e) ? e : [e],
            r = s.strokeWidth > 0 && "" !== s.strokeColor;
        let l, c;
        for (t.save(), t.font = o.string, function(t, e) {
                e.translation && t.translate(e.translation[0], e.translation[1]);
                $(e.rotation) || t.rotate(e.rotation);
                e.color && (t.fillStyle = e.color);
                e.textAlign && (t.textAlign = e.textAlign);
                e.textBaseline && (t.textBaseline = e.textBaseline)
            }(t, s), l = 0; l < a.length; ++l) c = a[l], r && (s.strokeColor && (t.strokeStyle = s.strokeColor), $(s.strokeWidth) || (t.lineWidth = s.strokeWidth), t.strokeText(c, i, n, s.maxWidth)), t.fillText(c, i, n, s.maxWidth), ie(t, i, n, c, s), n += o.lineHeight;
        t.restore()
    }

    function ie(t, e, i, n, o) {
        if (o.strikethrough || o.underline) {
            const s = t.measureText(n),
                a = e - s.actualBoundingBoxLeft,
                r = e + s.actualBoundingBoxRight,
                l = i - s.actualBoundingBoxAscent,
                c = i + s.actualBoundingBoxDescent,
                h = o.strikethrough ? (l + c) / 2 : c;
            t.strokeStyle = t.fillStyle, t.beginPath(), t.lineWidth = o.decorationWidth || 2, t.moveTo(a, h), t.lineTo(r, h), t.stroke()
        }
    }

    function ne(t, e) {
        const {
            x: i,
            y: n,
            w: o,
            h: s,
            radius: a
        } = e;
        t.arc(i + a.topLeft, n + a.topLeft, a.topLeft, -Mt, bt, !0), t.lineTo(i, n + s - a.bottomLeft), t.arc(i + a.bottomLeft, n + s - a.bottomLeft, a.bottomLeft, bt, Mt, !0), t.lineTo(i + o - a.bottomRight, n + s), t.arc(i + o - a.bottomRight, n + s - a.bottomRight, a.bottomRight, Mt, 0, !0), t.lineTo(i + o, n + a.topRight), t.arc(i + o - a.topRight, n + a.topRight, a.topRight, 0, -Mt, !0), t.lineTo(i + a.topLeft, n)
    }

    function oe(t, e, i) {
        i = i || (i => t[i] < e);
        let n, o = t.length - 1,
            s = 0;
        for (; o - s > 1;) n = s + o >> 1, i(n) ? s = n : o = n;
        return {
            lo: s,
            hi: o
        }
    }
    const se = (t, e, i) => oe(t, i, (n => t[n][e] < i)),
        ae = (t, e, i) => oe(t, i, (n => t[n][e] >= i));

    function re(t, e, i) {
        let n = 0,
            o = t.length;
        for (; n < o && t[n] < e;) n++;
        for (; o > n && t[o - 1] > i;) o--;
        return n > 0 || o < t.length ? t.slice(n, o) : t
    }
    const le = ["push", "pop", "shift", "splice", "unshift"];

    function ce(t, e) {
        t._chartjs ? t._chartjs.listeners.push(e) : (Object.defineProperty(t, "_chartjs", {
            configurable: !0,
            enumerable: !1,
            value: {
                listeners: [e]
            }
        }), le.forEach((e => {
            const i = "_onData" + ct(e),
                n = t[e];
            Object.defineProperty(t, e, {
                configurable: !0,
                enumerable: !1,
                value(...e) {
                    const o = n.apply(this, e);
                    return t._chartjs.listeners.forEach((t => {
                        "function" == typeof t[i] && t[i](...e)
                    })), o
                }
            })
        })))
    }

    function he(t, e) {
        const i = t._chartjs;
        if (!i) return;
        const n = i.listeners,
            o = n.indexOf(e); - 1 !== o && n.splice(o, 1), n.length > 0 || (le.forEach((e => {
            delete t[e]
        })), delete t._chartjs)
    }

    function de(t) {
        const e = new Set;
        let i, n;
        for (i = 0, n = t.length; i < n; ++i) e.add(t[i]);
        return e.size === n ? t : Array.from(e)
    }

    function ue() {
        return "undefined" != typeof window && "undefined" != typeof document
    }

    function fe(t) {
        let e = t.parentNode;
        return e && "[object ShadowRoot]" === e.toString() && (e = e.host), e
    }

    function ge(t, e, i) {
        let n;
        return "string" == typeof t ? (n = parseInt(t, 10), -1 !== t.indexOf("%") && (n = n / 100 * e.parentNode[i])) : n = t, n
    }
    const pe = t => window.getComputedStyle(t, null);

    function me(t, e) {
        return pe(t).getPropertyValue(e)
    }
    const xe = ["top", "right", "bottom", "left"];

    function be(t, e, i) {
        const n = {};
        i = i ? "-" + i : "";
        for (let o = 0; o < 4; o++) {
            const s = xe[o];
            n[s] = parseFloat(t[e + "-" + s + i]) || 0
        }
        return n.width = n.left + n.right, n.height = n.top + n.bottom, n
    }

    function _e(t, e) {
        const {
            canvas: i,
            currentDevicePixelRatio: n
        } = e, o = pe(i), s = "border-box" === o.boxSizing, a = be(o, "padding"), r = be(o, "border", "width"), {
            x: l,
            y: c,
            box: h
        } = function(t, e) {
            const i = t.native || t,
                n = i.touches,
                o = n && n.length ? n[0] : i,
                {
                    offsetX: s,
                    offsetY: a
                } = o;
            let r, l, c = !1;
            if (((t, e, i) => (t > 0 || e > 0) && (!i || !i.shadowRoot))(s, a, i.target)) r = s, l = a;
            else {
                const t = e.getBoundingClientRect();
                r = o.clientX - t.left, l = o.clientY - t.top, c = !0
            }
            return {
                x: r,
                y: l,
                box: c
            }
        }(t, i), d = a.left + (h && r.left), u = a.top + (h && r.top);
        let {
            width: f,
            height: g
        } = e;
        return s && (f -= a.width + r.width, g -= a.height + r.height), {
            x: Math.round((l - d) / f * i.width / n),
            y: Math.round((c - u) / g * i.height / n)
        }
    }
    const ye = t => Math.round(10 * t) / 10;

    function ve(t, e, i, n) {
        const o = pe(t),
            s = be(o, "margin"),
            a = ge(o.maxWidth, t, "clientWidth") || vt,
            r = ge(o.maxHeight, t, "clientHeight") || vt,
            l = function(t, e, i) {
                let n, o;
                if (void 0 === e || void 0 === i) {
                    const s = fe(t);
                    if (s) {
                        const t = s.getBoundingClientRect(),
                            a = pe(s),
                            r = be(a, "border", "width"),
                            l = be(a, "padding");
                        e = t.width - l.width - r.width, i = t.height - l.height - r.height, n = ge(a.maxWidth, s, "clientWidth"), o = ge(a.maxHeight, s, "clientHeight")
                    } else e = t.clientWidth, i = t.clientHeight
                }
                return {
                    width: e,
                    height: i,
                    maxWidth: n || vt,
                    maxHeight: o || vt
                }
            }(t, e, i);
        let {
            width: c,
            height: h
        } = l;
        if ("content-box" === o.boxSizing) {
            const t = be(o, "border", "width"),
                e = be(o, "padding");
            c -= e.width + t.width, h -= e.height + t.height
        }
        return c = Math.max(0, c - s.width), h = Math.max(0, n ? Math.floor(c / n) : h - s.height), c = ye(Math.min(c, a, l.maxWidth)), h = ye(Math.min(h, r, l.maxHeight)), c && !h && (h = ye(c / 2)), {
            width: c,
            height: h
        }
    }

    function we(t, e, i) {
        const n = e || 1,
            o = Math.floor(t.height * n),
            s = Math.floor(t.width * n);
        t.height = o / n, t.width = s / n;
        const a = t.canvas;
        return a.style && (i || !a.style.height && !a.style.width) && (a.style.height = `${t.height}px`, a.style.width = `${t.width}px`), (t.currentDevicePixelRatio !== n || a.height !== o || a.width !== s) && (t.currentDevicePixelRatio = n, a.height = o, a.width = s, t.ctx.setTransform(n, 0, 0, n, 0, 0), !0)
    }
    const Me = function() {
        let t = !1;
        try {
            const e = {
                get passive() {
                    return t = !0, !1
                }
            };
            window.addEventListener("test", null, e), window.removeEventListener("test", null, e)
        } catch (t) {}
        return t
    }();

    function ke(t, e) {
        const i = me(t, e),
            n = i && i.match(/^(\d+)(\.\d+)?px$/);
        return n ? +n[1] : void 0
    }

    function Se(t, e) {
        return "native" in t ? {
            x: t.x,
            y: t.y
        } : _e(t, e)
    }

    function Pe(t, e, i, n) {
        const {
            controller: o,
            data: s,
            _sorted: a
        } = t, r = o._cachedMeta.iScale;
        if (r && e === r.axis && a && s.length) {
            const t = r._reversePixels ? ae : se;
            if (!n) return t(s, e, i);
            if (o._sharedOptions) {
                const n = s[0],
                    o = "function" == typeof n.getRange && n.getRange(e);
                if (o) {
                    const n = t(s, e, i - o),
                        a = t(s, e, i + o);
                    return {
                        lo: n.lo,
                        hi: a.hi
                    }
                }
            }
        }
        return {
            lo: 0,
            hi: s.length - 1
        }
    }

    function De(t, e, i, n, o) {
        const s = t.getSortedVisibleDatasetMetas(),
            a = i[e];
        for (let t = 0, i = s.length; t < i; ++t) {
            const {
                index: i,
                data: r
            } = s[t], {
                lo: l,
                hi: c
            } = Pe(s[t], e, a, o);
            for (let t = l; t <= c; ++t) {
                const e = r[t];
                e.skip || n(e, i, t)
            }
        }
    }

    function Ce(t, e, i, n) {
        const o = [];
        if (!Gt(e, t.chartArea, t._minPadding)) return o;
        return De(t, i, e, (function(t, i, s) {
            t.inRange(e.x, e.y, n) && o.push({
                element: t,
                datasetIndex: i,
                index: s
            })
        }), !0), o
    }

    function Oe(t, e, i, n, o) {
        const s = function(t) {
            const e = -1 !== t.indexOf("x"),
                i = -1 !== t.indexOf("y");
            return function(t, n) {
                const o = e ? Math.abs(t.x - n.x) : 0,
                    s = i ? Math.abs(t.y - n.y) : 0;
                return Math.sqrt(Math.pow(o, 2) + Math.pow(s, 2))
            }
        }(i);
        let a = Number.POSITIVE_INFINITY,
            r = [];
        if (!Gt(e, t.chartArea, t._minPadding)) return r;
        return De(t, i, e, (function(i, l, c) {
            if (n && !i.inRange(e.x, e.y, o)) return;
            const h = i.getCenterPoint(o);
            if (!Gt(h, t.chartArea, t._minPadding) && !i.inRange(e.x, e.y, o)) return;
            const d = s(e, h);
            d < a ? (r = [{
                element: i,
                datasetIndex: l,
                index: c
            }], a = d) : d === a && r.push({
                element: i,
                datasetIndex: l,
                index: c
            })
        })), r
    }

    function Te(t, e, i, n) {
        const o = Se(e, t),
            s = [],
            a = i.axis,
            r = "x" === a ? "inXRange" : "inYRange";
        let l = !1;
        return function(t, e) {
            const i = t.getSortedVisibleDatasetMetas();
            let n, o, s;
            for (let t = 0, a = i.length; t < a; ++t) {
                ({
                    index: n,
                    data: o
                } = i[t]);
                for (let t = 0, i = o.length; t < i; ++t) s = o[t], s.skip || e(s, n, t)
            }
        }(t, ((t, e, i) => {
            t[r](o[a], n) && s.push({
                element: t,
                datasetIndex: e,
                index: i
            }), t.inRange(o.x, o.y, n) && (l = !0)
        })), i.intersect && !l ? [] : s
    }
    var Ae = {
        modes: {
            index(t, e, i, n) {
                const o = Se(e, t),
                    s = i.axis || "x",
                    a = i.intersect ? Ce(t, o, s, n) : Oe(t, o, s, !1, n),
                    r = [];
                return a.length ? (t.getSortedVisibleDatasetMetas().forEach((t => {
                    const e = a[0].index,
                        i = t.data[e];
                    i && !i.skip && r.push({
                        element: i,
                        datasetIndex: t.index,
                        index: e
                    })
                })), r) : []
            },
            dataset(t, e, i, n) {
                const o = Se(e, t),
                    s = i.axis || "xy";
                let a = i.intersect ? Ce(t, o, s, n) : Oe(t, o, s, !1, n);
                if (a.length > 0) {
                    const e = a[0].datasetIndex,
                        i = t.getDatasetMeta(e).data;
                    a = [];
                    for (let t = 0; t < i.length; ++t) a.push({
                        element: i[t],
                        datasetIndex: e,
                        index: t
                    })
                }
                return a
            },
            point: (t, e, i, n) => Ce(t, Se(e, t), i.axis || "xy", n),
            nearest: (t, e, i, n) => Oe(t, Se(e, t), i.axis || "xy", i.intersect, n),
            x: (t, e, i, n) => (i.axis = "x", Te(t, e, i, n)),
            y: (t, e, i, n) => (i.axis = "y", Te(t, e, i, n))
        }
    };
    const Le = new RegExp(/^(normal|(\d+(?:\.\d+)?)(px|em|%)?)$/),
        Re = new RegExp(/^(normal|italic|initial|inherit|unset|(oblique( -?[0-9]?[0-9]deg)?))$/);

    function Ee(t, e) {
        const i = ("" + t).match(Le);
        if (!i || "normal" === i[1]) return 1.2 * e;
        switch (t = +i[2], i[3]) {
            case "px":
                return t;
            case "%":
                t /= 100
        }
        return e * t
    }

    function Ie(t, e) {
        const i = {},
            n = U(e),
            o = n ? Object.keys(e) : e,
            s = U(t) ? n ? i => K(t[i], t[e[i]]) : e => t[e] : () => t;
        for (const t of o) i[t] = +s(t) || 0;
        return i
    }

    function ze(t) {
        return Ie(t, {
            top: "y",
            right: "x",
            bottom: "y",
            left: "x"
        })
    }

    function Fe(t) {
        return Ie(t, ["topLeft", "topRight", "bottomLeft", "bottomRight"])
    }

    function Be(t) {
        const e = ze(t);
        return e.width = e.left + e.right, e.height = e.top + e.bottom, e
    }

    function Ve(t, e) {
        t = t || {}, e = e || xt.font;
        let i = K(t.size, e.size);
        "string" == typeof i && (i = parseInt(i, 10));
        let n = K(t.style, e.style);
        n && !("" + n).match(Re) && (console.warn('Invalid font style specified: "' + n + '"'), n = "");
        const o = {
            family: K(t.family, e.family),
            lineHeight: Ee(K(t.lineHeight, e.lineHeight), i),
            size: i,
            style: n,
            weight: K(t.weight, e.weight),
            string: ""
        };
        return o.string = $t(o), o
    }

    function We(t, e, i, n) {
        let o, s, a, r = !0;
        for (o = 0, s = t.length; o < s; ++o)
            if (a = t[o], void 0 !== a && (void 0 !== e && "function" == typeof a && (a = a(e), r = !1), void 0 !== i && Y(a) && (a = a[i % a.length], r = !1), void 0 !== a)) return n && !r && (n.cacheable = !1), a
    }

    function Ne(t, e) {
        const {
            min: i,
            max: n
        } = t;
        return {
            min: i - Math.abs(Z(e, i)),
            max: n + Z(e, n)
        }
    }
    const He = ["left", "top", "right", "bottom"];

    function je(t, e) {
        return t.filter((t => t.pos === e))
    }

    function $e(t, e) {
        return t.filter((t => -1 === He.indexOf(t.pos) && t.box.axis === e))
    }

    function Ye(t, e) {
        return t.sort(((t, i) => {
            const n = e ? i : t,
                o = e ? t : i;
            return n.weight === o.weight ? n.index - o.index : n.weight - o.weight
        }))
    }

    function Ue(t, e) {
        const i = function(t) {
                const e = {};
                for (const i of t) {
                    const {
                        stack: t,
                        pos: n,
                        stackWeight: o
                    } = i;
                    if (!t || !He.includes(n)) continue;
                    const s = e[t] || (e[t] = {
                        count: 0,
                        placed: 0,
                        weight: 0,
                        size: 0
                    });
                    s.count++, s.weight += o
                }
                return e
            }(t),
            {
                vBoxMaxWidth: n,
                hBoxMaxHeight: o
            } = e;
        let s, a, r;
        for (s = 0, a = t.length; s < a; ++s) {
            r = t[s];
            const {
                fullSize: a
            } = r.box, l = i[r.stack], c = l && r.stackWeight / l.weight;
            r.horizontal ? (r.width = c ? c * n : a && e.availableWidth, r.height = o) : (r.width = n, r.height = c ? c * o : a && e.availableHeight)
        }
        return i
    }

    function Xe(t, e, i, n) {
        return Math.max(t[i], e[i]) + Math.max(t[n], e[n])
    }

    function qe(t, e) {
        t.top = Math.max(t.top, e.top), t.left = Math.max(t.left, e.left), t.bottom = Math.max(t.bottom, e.bottom), t.right = Math.max(t.right, e.right)
    }

    function Ke(t, e, i, n) {
        const {
            pos: o,
            box: s
        } = i, a = t.maxPadding;
        if (!U(o)) {
            i.size && (t[o] -= i.size);
            const e = n[i.stack] || {
                size: 0,
                count: 1
            };
            e.size = Math.max(e.size, i.horizontal ? s.height : s.width), i.size = e.size / e.count, t[o] += i.size
        }
        s.getPadding && qe(a, s.getPadding());
        const r = Math.max(0, e.outerWidth - Xe(a, t, "left", "right")),
            l = Math.max(0, e.outerHeight - Xe(a, t, "top", "bottom")),
            c = r !== t.w,
            h = l !== t.h;
        return t.w = r, t.h = l, i.horizontal ? {
            same: c,
            other: h
        } : {
            same: h,
            other: c
        }
    }

    function Ge(t, e) {
        const i = e.maxPadding;

        function n(t) {
            const n = {
                left: 0,
                top: 0,
                right: 0,
                bottom: 0
            };
            return t.forEach((t => {
                n[t] = Math.max(e[t], i[t])
            })), n
        }
        return n(t ? ["left", "right"] : ["top", "bottom"])
    }

    function Ze(t, e, i, n) {
        const o = [];
        let s, a, r, l, c, h;
        for (s = 0, a = t.length, c = 0; s < a; ++s) {
            r = t[s], l = r.box, l.update(r.width || e.w, r.height || e.h, Ge(r.horizontal, e));
            const {
                same: a,
                other: d
            } = Ke(e, i, r, n);
            c |= a && o.length, h = h || d, l.fullSize || o.push(r)
        }
        return c && Ze(o, e, i, n) || h
    }

    function Qe(t, e, i, n, o) {
        t.top = i, t.left = e, t.right = e + n, t.bottom = i + o, t.width = n, t.height = o
    }

    function Je(t, e, i, n) {
        const o = i.padding;
        let {
            x: s,
            y: a
        } = e;
        for (const r of t) {
            const t = r.box,
                l = n[r.stack] || {
                    count: 1,
                    placed: 0,
                    weight: 1
                },
                c = r.stackWeight / l.weight || 1;
            if (r.horizontal) {
                const n = e.w * c,
                    s = l.size || t.height;
                ht(l.start) && (a = l.start), t.fullSize ? Qe(t, o.left, a, i.outerWidth - o.right - o.left, s) : Qe(t, e.left + l.placed, a, n, s), l.start = a, l.placed += n, a = t.bottom
            } else {
                const n = e.h * c,
                    a = l.size || t.width;
                ht(l.start) && (s = l.start), t.fullSize ? Qe(t, s, o.top, a, i.outerHeight - o.bottom - o.top) : Qe(t, s, e.top + l.placed, a, n), l.start = s, l.placed += n, s = t.right
            }
        }
        e.x = s, e.y = a
    }
    xt.set("layout", {
        padding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0
        }
    });
    var ti = {
        addBox(t, e) {
            t.boxes || (t.boxes = []), e.fullSize = e.fullSize || !1, e.position = e.position || "top", e.weight = e.weight || 0, e._layers = e._layers || function() {
                return [{
                    z: 0,
                    draw(t) {
                        e.draw(t)
                    }
                }]
            }, t.boxes.push(e)
        },
        removeBox(t, e) {
            const i = t.boxes ? t.boxes.indexOf(e) : -1; - 1 !== i && t.boxes.splice(i, 1)
        },
        configure(t, e, i) {
            e.fullSize = i.fullSize, e.position = i.position, e.weight = i.weight
        },
        update(t, e, i, n) {
            if (!t) return;
            const o = Be(t.options.layout.padding),
                s = Math.max(e - o.width, 0),
                a = Math.max(i - o.height, 0),
                r = function(t) {
                    const e = function(t) {
                            const e = [];
                            let i, n, o, s, a, r;
                            for (i = 0, n = (t || []).length; i < n; ++i) o = t[i], ({
                                position: s,
                                options: {
                                    stack: a,
                                    stackWeight: r = 1
                                }
                            } = o), e.push({
                                index: i,
                                box: o,
                                pos: s,
                                horizontal: o.isHorizontal(),
                                weight: o.weight,
                                stack: a && s + a,
                                stackWeight: r
                            });
                            return e
                        }(t),
                        i = Ye(e.filter((t => t.box.fullSize)), !0),
                        n = Ye(je(e, "left"), !0),
                        o = Ye(je(e, "right")),
                        s = Ye(je(e, "top"), !0),
                        a = Ye(je(e, "bottom")),
                        r = $e(e, "x"),
                        l = $e(e, "y");
                    return {
                        fullSize: i,
                        leftAndTop: n.concat(s),
                        rightAndBottom: o.concat(l).concat(a).concat(r),
                        chartArea: je(e, "chartArea"),
                        vertical: n.concat(o).concat(l),
                        horizontal: s.concat(a).concat(r)
                    }
                }(t.boxes),
                l = r.vertical,
                c = r.horizontal;
            J(t.boxes, (t => {
                "function" == typeof t.beforeLayout && t.beforeLayout()
            }));
            const h = l.reduce(((t, e) => e.box.options && !1 === e.box.options.display ? t : t + 1), 0) || 1,
                d = Object.freeze({
                    outerWidth: e,
                    outerHeight: i,
                    padding: o,
                    availableWidth: s,
                    availableHeight: a,
                    vBoxMaxWidth: s / 2 / h,
                    hBoxMaxHeight: a / 2
                }),
                u = Object.assign({}, o);
            qe(u, Be(n));
            const f = Object.assign({
                    maxPadding: u,
                    w: s,
                    h: a,
                    x: o.left,
                    y: o.top
                }, o),
                g = Ue(l.concat(c), d);
            Ze(r.fullSize, f, d, g), Ze(l, f, d, g), Ze(c, f, d, g) && Ze(l, f, d, g),
                function(t) {
                    const e = t.maxPadding;

                    function i(i) {
                        const n = Math.max(e[i] - t[i], 0);
                        return t[i] += n, n
                    }
                    t.y += i("top"), t.x += i("left"), i("right"), i("bottom")
                }(f), Je(r.leftAndTop, f, d, g), f.x += f.w, f.y += f.h, Je(r.rightAndBottom, f, d, g), t.chartArea = {
                    left: f.left,
                    top: f.top,
                    right: f.left + f.w,
                    bottom: f.top + f.h,
                    height: f.h,
                    width: f.w
                }, J(r.chartArea, (e => {
                    const i = e.box;
                    Object.assign(i, t.chartArea), i.update(f.w, f.h)
                }))
        }
    };

    function ei(t, e = [""], i = t, n, o = (() => t[0])) {
        ht(n) || (n = ui("_fallback", t));
        const s = {
            [Symbol.toStringTag]: "Object",
            _cacheable: !0,
            _scopes: t,
            _rootScopes: i,
            _fallback: n,
            _getTarget: o,
            override: o => ei([o, ...t], e, i, n)
        };
        return new Proxy(s, {
            deleteProperty: (e, i) => (delete e[i], delete e._keys, delete t[0][i], !0),
            get: (i, n) => ai(i, n, (() => function(t, e, i, n) {
                let o;
                for (const s of e)
                    if (o = ui(oi(s, t), i), ht(o)) return si(t, o) ? hi(i, n, t, o) : o
            }(n, e, t, i))),
            getOwnPropertyDescriptor: (t, e) => Reflect.getOwnPropertyDescriptor(t._scopes[0], e),
            getPrototypeOf: () => Reflect.getPrototypeOf(t[0]),
            has: (t, e) => fi(t).includes(e),
            ownKeys: t => fi(t),
            set: (t, e, i) => ((t._storage || (t._storage = o()))[e] = i, delete t[e], delete t._keys, !0)
        })
    }

    function ii(t, e, i, n) {
        const o = {
            _cacheable: !1,
            _proxy: t,
            _context: e,
            _subProxy: i,
            _stack: new Set,
            _descriptors: ni(t, n),
            setContext: e => ii(t, e, i, n),
            override: o => ii(t.override(o), e, i, n)
        };
        return new Proxy(o, {
            deleteProperty: (e, i) => (delete e[i], delete t[i], !0),
            get: (t, e, i) => ai(t, e, (() => function(t, e, i) {
                const {
                    _proxy: n,
                    _context: o,
                    _subProxy: s,
                    _descriptors: a
                } = t;
                let r = n[e];
                dt(r) && a.isScriptable(e) && (r = function(t, e, i, n) {
                    const {
                        _proxy: o,
                        _context: s,
                        _subProxy: a,
                        _stack: r
                    } = i;
                    if (r.has(t)) throw new Error("Recursion detected: " + Array.from(r).join("->") + "->" + t);
                    r.add(t), e = e(s, a || n), r.delete(t), U(e) && (e = hi(o._scopes, o, t, e));
                    return e
                }(e, r, t, i));
                Y(r) && r.length && (r = function(t, e, i, n) {
                    const {
                        _proxy: o,
                        _context: s,
                        _subProxy: a,
                        _descriptors: r
                    } = i;
                    if (ht(s.index) && n(t)) e = e[s.index % e.length];
                    else if (U(e[0])) {
                        const i = e,
                            n = o._scopes.filter((t => t !== i));
                        e = [];
                        for (const l of i) {
                            const i = hi(n, o, t, l);
                            e.push(ii(i, s, a && a[t], r))
                        }
                    }
                    return e
                }(e, r, t, a.isIndexable));
                si(e, r) && (r = ii(r, o, s && s[e], a));
                return r
            }(t, e, i))),
            getOwnPropertyDescriptor: (e, i) => e._descriptors.allKeys ? Reflect.has(t, i) ? {
                enumerable: !0,
                configurable: !0
            } : void 0 : Reflect.getOwnPropertyDescriptor(t, i),
            getPrototypeOf: () => Reflect.getPrototypeOf(t),
            has: (e, i) => Reflect.has(t, i),
            ownKeys: () => Reflect.ownKeys(t),
            set: (e, i, n) => (t[i] = n, delete e[i], !0)
        })
    }

    function ni(t, e = {
        scriptable: !0,
        indexable: !0
    }) {
        const {
            _scriptable: i = e.scriptable,
            _indexable: n = e.indexable,
            _allKeys: o = e.allKeys
        } = t;
        return {
            allKeys: o,
            scriptable: i,
            indexable: n,
            isScriptable: dt(i) ? i : () => i,
            isIndexable: dt(n) ? n : () => n
        }
    }
    const oi = (t, e) => t ? t + ct(e) : e,
        si = (t, e) => U(e) && "adapters" !== t;

    function ai(t, e, i) {
        let n = t[e];
        return ht(n) || (n = i(), ht(n) && (t[e] = n)), n
    }

    function ri(t, e, i) {
        return dt(t) ? t(e, i) : t
    }
    const li = (t, e) => !0 === t ? e : "string" == typeof t ? lt(e, t) : void 0;

    function ci(t, e, i, n) {
        for (const o of e) {
            const e = li(i, o);
            if (e) {
                t.add(e);
                const o = ri(e._fallback, i, e);
                if (ht(o) && o !== i && o !== n) return o
            } else if (!1 === e && ht(n) && i !== n) return null
        }
        return !1
    }

    function hi(t, e, i, n) {
        const o = e._rootScopes,
            s = ri(e._fallback, i, n),
            a = [...t, ...o],
            r = new Set;
        r.add(n);
        let l = di(r, a, i, s || i);
        return null !== l && ((!ht(s) || s === i || (l = di(r, a, s, l), null !== l)) && ei(Array.from(r), [""], o, s, (() => function(t, e, i) {
            const n = t._getTarget();
            e in n || (n[e] = {});
            const o = n[e];
            if (Y(o) && U(i)) return i;
            return o
        }(e, i, n))))
    }

    function di(t, e, i, n) {
        for (; i;) i = ci(t, e, i, n);
        return i
    }

    function ui(t, e) {
        for (const i of e) {
            if (!i) continue;
            const e = i[t];
            if (ht(e)) return e
        }
    }

    function fi(t) {
        let e = t._keys;
        return e || (e = t._keys = function(t) {
            const e = new Set;
            for (const i of t)
                for (const t of Object.keys(i).filter((t => !t.startsWith("_")))) e.add(t);
            return Array.from(e)
        }(t._scopes)), e
    }
    const gi = Number.EPSILON || 1e-14,
        pi = (t, e) => e < t.length && !t[e].skip && t[e],
        mi = t => "x" === t ? "y" : "x";

    function xi(t, e, i, n) {
        const o = t.skip ? e : t,
            s = e,
            a = i.skip ? e : i,
            r = Bt(s, o),
            l = Bt(a, s);
        let c = r / (r + l),
            h = l / (r + l);
        c = isNaN(c) ? 0 : c, h = isNaN(h) ? 0 : h;
        const d = n * c,
            u = n * h;
        return {
            previous: {
                x: s.x - d * (a.x - o.x),
                y: s.y - d * (a.y - o.y)
            },
            next: {
                x: s.x + u * (a.x - o.x),
                y: s.y + u * (a.y - o.y)
            }
        }
    }

    function bi(t, e = "x") {
        const i = mi(e),
            n = t.length,
            o = Array(n).fill(0),
            s = Array(n);
        let a, r, l, c = pi(t, 0);
        for (a = 0; a < n; ++a)
            if (r = l, l = c, c = pi(t, a + 1), l) {
                if (c) {
                    const t = c[e] - l[e];
                    o[a] = 0 !== t ? (c[i] - l[i]) / t : 0
                }
                s[a] = r ? c ? Dt(o[a - 1]) !== Dt(o[a]) ? 0 : (o[a - 1] + o[a]) / 2 : o[a - 1] : o[a]
            }!
        function(t, e, i) {
            const n = t.length;
            let o, s, a, r, l, c = pi(t, 0);
            for (let h = 0; h < n - 1; ++h) l = c, c = pi(t, h + 1), l && c && (At(e[h], 0, gi) ? i[h] = i[h + 1] = 0 : (o = i[h] / e[h], s = i[h + 1] / e[h], r = Math.pow(o, 2) + Math.pow(s, 2), r <= 9 || (a = 3 / Math.sqrt(r), i[h] = o * a * e[h], i[h + 1] = s * a * e[h])))
        }(t, o, s),
        function(t, e, i = "x") {
            const n = mi(i),
                o = t.length;
            let s, a, r, l = pi(t, 0);
            for (let c = 0; c < o; ++c) {
                if (a = r, r = l, l = pi(t, c + 1), !r) continue;
                const o = r[i],
                    h = r[n];
                a && (s = (o - a[i]) / 3, r[`cp1${i}`] = o - s, r[`cp1${n}`] = h - s * e[c]), l && (s = (l[i] - o) / 3, r[`cp2${i}`] = o + s, r[`cp2${n}`] = h + s * e[c])
            }
        }(t, s, e)
    }

    function _i(t, e, i) {
        return Math.max(Math.min(t, i), e)
    }

    function yi(t, e, i, n, o) {
        let s, a, r, l;
        if (e.spanGaps && (t = t.filter((t => !t.skip))), "monotone" === e.cubicInterpolationMode) bi(t, o);
        else {
            let i = n ? t[t.length - 1] : t[0];
            for (s = 0, a = t.length; s < a; ++s) r = t[s], l = xi(i, r, t[Math.min(s + 1, a - (n ? 0 : 1)) % a], e.tension), r.cp1x = l.previous.x, r.cp1y = l.previous.y, r.cp2x = l.next.x, r.cp2y = l.next.y, i = r
        }
        e.capBezierPoints && function(t, e) {
            let i, n, o, s, a, r = Gt(t[0], e);
            for (i = 0, n = t.length; i < n; ++i) a = s, s = r, r = i < n - 1 && Gt(t[i + 1], e), s && (o = t[i], a && (o.cp1x = _i(o.cp1x, e.left, e.right), o.cp1y = _i(o.cp1y, e.top, e.bottom)), r && (o.cp2x = _i(o.cp2x, e.left, e.right), o.cp2y = _i(o.cp2y, e.top, e.bottom)))
        }(t, i)
    }
    const vi = t => 0 === t || 1 === t,
        wi = (t, e, i) => -Math.pow(2, 10 * (t -= 1)) * Math.sin((t - e) * _t / i),
        Mi = (t, e, i) => Math.pow(2, -10 * t) * Math.sin((t - e) * _t / i) + 1,
        ki = {
            linear: t => t,
            easeInQuad: t => t * t,
            easeOutQuad: t => -t * (t - 2),
            easeInOutQuad: t => (t /= .5) < 1 ? .5 * t * t : -.5 * (--t * (t - 2) - 1),
            easeInCubic: t => t * t * t,
            easeOutCubic: t => (t -= 1) * t * t + 1,
            easeInOutCubic: t => (t /= .5) < 1 ? .5 * t * t * t : .5 * ((t -= 2) * t * t + 2),
            easeInQuart: t => t * t * t * t,
            easeOutQuart: t => -((t -= 1) * t * t * t - 1),
            easeInOutQuart: t => (t /= .5) < 1 ? .5 * t * t * t * t : -.5 * ((t -= 2) * t * t * t - 2),
            easeInQuint: t => t * t * t * t * t,
            easeOutQuint: t => (t -= 1) * t * t * t * t + 1,
            easeInOutQuint: t => (t /= .5) < 1 ? .5 * t * t * t * t * t : .5 * ((t -= 2) * t * t * t * t + 2),
            easeInSine: t => 1 - Math.cos(t * Mt),
            easeOutSine: t => Math.sin(t * Mt),
            easeInOutSine: t => -.5 * (Math.cos(bt * t) - 1),
            easeInExpo: t => 0 === t ? 0 : Math.pow(2, 10 * (t - 1)),
            easeOutExpo: t => 1 === t ? 1 : 1 - Math.pow(2, -10 * t),
            easeInOutExpo: t => vi(t) ? t : t < .5 ? .5 * Math.pow(2, 10 * (2 * t - 1)) : .5 * (2 - Math.pow(2, -10 * (2 * t - 1))),
            easeInCirc: t => t >= 1 ? t : -(Math.sqrt(1 - t * t) - 1),
            easeOutCirc: t => Math.sqrt(1 - (t -= 1) * t),
            easeInOutCirc: t => (t /= .5) < 1 ? -.5 * (Math.sqrt(1 - t * t) - 1) : .5 * (Math.sqrt(1 - (t -= 2) * t) + 1),
            easeInElastic: t => vi(t) ? t : wi(t, .075, .3),
            easeOutElastic: t => vi(t) ? t : Mi(t, .075, .3),
            easeInOutElastic(t) {
                const e = .1125;
                return vi(t) ? t : t < .5 ? .5 * wi(2 * t, e, .45) : .5 + .5 * Mi(2 * t - 1, e, .45)
            },
            easeInBack(t) {
                const e = 1.70158;
                return t * t * ((e + 1) * t - e)
            },
            easeOutBack(t) {
                const e = 1.70158;
                return (t -= 1) * t * ((e + 1) * t + e) + 1
            },
            easeInOutBack(t) {
                let e = 1.70158;
                return (t /= .5) < 1 ? t * t * ((1 + (e *= 1.525)) * t - e) * .5 : .5 * ((t -= 2) * t * ((1 + (e *= 1.525)) * t + e) + 2)
            },
            easeInBounce: t => 1 - ki.easeOutBounce(1 - t),
            easeOutBounce(t) {
                const e = 7.5625,
                    i = 2.75;
                return t < 1 / i ? e * t * t : t < 2 / i ? e * (t -= 1.5 / i) * t + .75 : t < 2.5 / i ? e * (t -= 2.25 / i) * t + .9375 : e * (t -= 2.625 / i) * t + .984375
            },
            easeInOutBounce: t => t < .5 ? .5 * ki.easeInBounce(2 * t) : .5 * ki.easeOutBounce(2 * t - 1) + .5
        };

    function Si(t, e, i, n) {
        return {
            x: t.x + i * (e.x - t.x),
            y: t.y + i * (e.y - t.y)
        }
    }

    function Pi(t, e, i, n) {
        return {
            x: t.x + i * (e.x - t.x),
            y: "middle" === n ? i < .5 ? t.y : e.y : "after" === n ? i < 1 ? t.y : e.y : i > 0 ? e.y : t.y
        }
    }

    function Di(t, e, i, n) {
        const o = {
                x: t.cp2x,
                y: t.cp2y
            },
            s = {
                x: e.cp1x,
                y: e.cp1y
            },
            a = Si(t, o, i),
            r = Si(o, s, i),
            l = Si(s, e, i),
            c = Si(a, r, i),
            h = Si(r, l, i);
        return Si(c, h, i)
    }
    const Ci = new Map;

    function Oi(t, e, i) {
        return function(t, e) {
            e = e || {};
            const i = t + JSON.stringify(e);
            let n = Ci.get(i);
            return n || (n = new Intl.NumberFormat(t, e), Ci.set(i, n)), n
        }(e, i).format(t)
    }

    function Ti(t, e, i) {
        return t ? function(t, e) {
            return {
                x: i => t + t + e - i,
                setWidth(t) {
                    e = t
                },
                textAlign: t => "center" === t ? t : "right" === t ? "left" : "right",
                xPlus: (t, e) => t - e,
                leftForLtr: (t, e) => t - e
            }
        }(e, i) : {
            x: t => t,
            setWidth(t) {},
            textAlign: t => t,
            xPlus: (t, e) => t + e,
            leftForLtr: (t, e) => t
        }
    }

    function Ai(t, e) {
        let i, n;
        "ltr" !== e && "rtl" !== e || (i = t.canvas.style, n = [i.getPropertyValue("direction"), i.getPropertyPriority("direction")], i.setProperty("direction", e, "important"), t.prevTextDirection = n)
    }

    function Li(t, e) {
        void 0 !== e && (delete t.prevTextDirection, t.canvas.style.setProperty("direction", e[0], e[1]))
    }

    function Ri(t) {
        return "angle" === t ? {
            between: Nt,
            compare: Vt,
            normalize: Wt
        } : {
            between: (t, e, i) => t >= Math.min(e, i) && t <= Math.max(i, e),
            compare: (t, e) => t - e,
            normalize: t => t
        }
    }

    function Ei({
        start: t,
        end: e,
        count: i,
        loop: n,
        style: o
    }) {
        return {
            start: t % i,
            end: e % i,
            loop: n && (e - t + 1) % i == 0,
            style: o
        }
    }

    function Ii(t, e, i) {
        if (!i) return [t];
        const {
            property: n,
            start: o,
            end: s
        } = i, a = e.length, {
            compare: r,
            between: l,
            normalize: c
        } = Ri(n), {
            start: h,
            end: d,
            loop: u,
            style: f
        } = function(t, e, i) {
            const {
                property: n,
                start: o,
                end: s
            } = i, {
                between: a,
                normalize: r
            } = Ri(n), l = e.length;
            let c, h, {
                start: d,
                end: u,
                loop: f
            } = t;
            if (f) {
                for (d += l, u += l, c = 0, h = l; c < h && a(r(e[d % l][n]), o, s); ++c) d--, u--;
                d %= l, u %= l
            }
            return u < d && (u += l), {
                start: d,
                end: u,
                loop: f,
                style: t.style
            }
        }(t, e, i), g = [];
        let p, m, x, b = !1,
            _ = null;
        const y = () => b || l(o, x, p) && 0 !== r(o, x),
            v = () => !b || 0 === r(s, p) || l(s, x, p);
        for (let t = h, i = h; t <= d; ++t) m = e[t % a], m.skip || (p = c(m[n]), p !== x && (b = l(p, o, s), null === _ && y() && (_ = 0 === r(p, o) ? t : i), null !== _ && v() && (g.push(Ei({
            start: _,
            end: t,
            loop: u,
            count: a,
            style: f
        })), _ = null), i = t, x = p));
        return null !== _ && g.push(Ei({
            start: _,
            end: d,
            loop: u,
            count: a,
            style: f
        })), g
    }

    function zi(t, e) {
        const i = [],
            n = t.segments;
        for (let o = 0; o < n.length; o++) {
            const s = Ii(n[o], t.points, e);
            s.length && i.push(...s)
        }
        return i
    }

    function Fi(t, e) {
        const i = t.points,
            n = t.options.spanGaps,
            o = i.length;
        if (!o) return [];
        const s = !!t._loop,
            {
                start: a,
                end: r
            } = function(t, e, i, n) {
                let o = 0,
                    s = e - 1;
                if (i && !n)
                    for (; o < e && !t[o].skip;) o++;
                for (; o < e && t[o].skip;) o++;
                for (o %= e, i && (s += o); s > o && t[s % e].skip;) s--;
                return s %= e, {
                    start: o,
                    end: s
                }
            }(i, o, s, n);
        if (!0 === n) return Bi(t, [{
            start: a,
            end: r,
            loop: s
        }], i, e);
        return Bi(t, function(t, e, i, n) {
            const o = t.length,
                s = [];
            let a, r = e,
                l = t[e];
            for (a = e + 1; a <= i; ++a) {
                const i = t[a % o];
                i.skip || i.stop ? l.skip || (n = !1, s.push({
                    start: e % o,
                    end: (a - 1) % o,
                    loop: n
                }), e = r = i.stop ? a : null) : (r = a, l.skip && (e = a)), l = i
            }
            return null !== r && s.push({
                start: e % o,
                end: r % o,
                loop: n
            }), s
        }(i, a, r < a ? r + o : r, !!t._fullLoop && 0 === a && r === o - 1), i, e)
    }

    function Bi(t, e, i, n) {
        return n && n.setContext && i ? function(t, e, i, n) {
            const o = Vi(t.options),
                s = i.length,
                a = [];
            let r = e[0].start,
                l = r;
            for (const c of e) {
                let e, h = o,
                    d = i[r % s];
                for (l = r + 1; l <= c.end; l++) {
                    const o = i[l % s];
                    e = Vi(n.setContext({
                        type: "segment",
                        p0: d,
                        p1: o,
                        p0DataIndex: (l - 1) % s,
                        p1DataIndex: l % s,
                        datasetIndex: t._datasetIndex
                    })), Wi(e, h) && (a.push({
                        start: r,
                        end: l - 1,
                        loop: c.loop,
                        style: h
                    }), h = e, r = l - 1), d = o, h = e
                }
                r < l - 1 && (a.push({
                    start: r,
                    end: l - 1,
                    loop: c.loop,
                    style: e
                }), r = l - 1)
            }
            return a
        }(t, e, i, n) : e
    }

    function Vi(t) {
        return {
            backgroundColor: t.backgroundColor,
            borderCapStyle: t.borderCapStyle,
            borderDash: t.borderDash,
            borderDashOffset: t.borderDashOffset,
            borderJoinStyle: t.borderJoinStyle,
            borderWidth: t.borderWidth,
            borderColor: t.borderColor
        }
    }

    function Wi(t, e) {
        return e && JSON.stringify(t) !== JSON.stringify(e)
    }
    var Ni = Object.freeze({
        __proto__: null,
        easingEffects: ki,
        color: W,
        getHoverColor: N,
        noop: H,
        uid: j,
        isNullOrUndef: $,
        isArray: Y,
        isObject: U,
        isFinite: X,
        finiteOrDefault: q,
        valueOrDefault: K,
        toPercentage: G,
        toDimension: Z,
        callback: Q,
        each: J,
        _elementsEqual: tt,
        clone: et,
        _merger: nt,
        merge: ot,
        mergeIf: st,
        _mergerIf: at,
        _deprecated: function(t, e, i, n) {
            void 0 !== e && console.warn(t + ': "' + i + '" is deprecated. Please use "' + n + '" instead')
        },
        resolveObjectKey: lt,
        _capitalize: ct,
        defined: ht,
        isFunction: dt,
        setsEqual: ut,
        toFontString: $t,
        _measureText: Yt,
        _longestText: Ut,
        _alignPixel: Xt,
        clearCanvas: qt,
        drawPoint: Kt,
        _isPointInArea: Gt,
        clipArea: Zt,
        unclipArea: Qt,
        _steppedLineTo: Jt,
        _bezierCurveTo: te,
        renderText: ee,
        addRoundedRectPath: ne,
        _lookup: oe,
        _lookupByKey: se,
        _rlookupByKey: ae,
        _filterBetween: re,
        listenArrayEvents: ce,
        unlistenArrayEvents: he,
        _arrayUnique: de,
        _createResolver: ei,
        _attachContext: ii,
        _descriptors: ni,
        splineCurve: xi,
        splineCurveMonotone: bi,
        _updateBezierControlPoints: yi,
        _isDomSupported: ue,
        _getParentNode: fe,
        getStyle: me,
        getRelativePosition: _e,
        getMaximumSize: ve,
        retinaScale: we,
        supportsEventListenerOptions: Me,
        readUsedSize: ke,
        fontString: function(t, e, i) {
            return e + " " + t + "px " + i
        },
        requestAnimFrame: t,
        throttled: e,
        debounce: i,
        _toLeftRightCenter: n,
        _alignStartEnd: o,
        _textX: s,
        _pointInLine: Si,
        _steppedInterpolation: Pi,
        _bezierInterpolation: Di,
        formatNumber: Oi,
        toLineHeight: Ee,
        _readValueToProps: Ie,
        toTRBL: ze,
        toTRBLCorners: Fe,
        toPadding: Be,
        toFont: Ve,
        resolve: We,
        _addGrace: Ne,
        PI: bt,
        TAU: _t,
        PITAU: yt,
        INFINITY: vt,
        RAD_PER_DEG: wt,
        HALF_PI: Mt,
        QUARTER_PI: kt,
        TWO_THIRDS_PI: St,
        log10: Pt,
        sign: Dt,
        niceNum: Ct,
        _factorize: Ot,
        isNumber: Tt,
        almostEquals: At,
        almostWhole: Lt,
        _setMinAndMaxByKey: Rt,
        toRadians: Et,
        toDegrees: It,
        _decimalPlaces: zt,
        getAngleFromPoint: Ft,
        distanceBetweenPoints: Bt,
        _angleDiff: Vt,
        _normalizeAngle: Wt,
        _angleBetween: Nt,
        _limitValue: Ht,
        _int16Range: jt,
        getRtlAdapter: Ti,
        overrideTextDirection: Ai,
        restoreTextDirection: Li,
        _boundSegment: Ii,
        _boundSegments: zi,
        _computeSegments: Fi
    });
    class Hi {
        acquireContext(t, e) {}
        releaseContext(t) {
            return !1
        }
        addEventListener(t, e, i) {}
        removeEventListener(t, e, i) {}
        getDevicePixelRatio() {
            return 1
        }
        getMaximumSize(t, e, i, n) {
            return e = Math.max(0, e || t.width), i = i || t.height, {
                width: e,
                height: Math.max(0, n ? Math.floor(e / n) : i)
            }
        }
        isAttached(t) {
            return !0
        }
    }
    class ji extends Hi {
        acquireContext(t) {
            return t && t.getContext && t.getContext("2d") || null
        }
    }
    const $i = {
            touchstart: "mousedown",
            touchmove: "mousemove",
            touchend: "mouseup",
            pointerenter: "mouseenter",
            pointerdown: "mousedown",
            pointermove: "mousemove",
            pointerup: "mouseup",
            pointerleave: "mouseout",
            pointerout: "mouseout"
        },
        Yi = t => null === t || "" === t;
    const Ui = !!Me && {
        passive: !0
    };

    function Xi(t, e, i) {
        t.canvas.removeEventListener(e, i, Ui)
    }

    function qi(t, e, i) {
        const n = t.canvas,
            o = n && fe(n) || n,
            s = new MutationObserver((t => {
                const e = fe(o);
                t.forEach((t => {
                    for (let n = 0; n < t.addedNodes.length; n++) {
                        const s = t.addedNodes[n];
                        s !== o && s !== e || i(t.target)
                    }
                }))
            }));
        return s.observe(document, {
            childList: !0,
            subtree: !0
        }), s
    }

    function Ki(t, e, i) {
        const n = t.canvas,
            o = n && fe(n);
        if (!o) return;
        const s = new MutationObserver((t => {
            t.forEach((t => {
                for (let e = 0; e < t.removedNodes.length; e++)
                    if (t.removedNodes[e] === n) {
                        i();
                        break
                    }
            }))
        }));
        return s.observe(o, {
            childList: !0
        }), s
    }
    const Gi = new Map;
    let Zi = 0;

    function Qi() {
        const t = window.devicePixelRatio;
        t !== Zi && (Zi = t, Gi.forEach(((e, i) => {
            i.currentDevicePixelRatio !== t && e()
        })))
    }

    function Ji(t, i, n) {
        const o = t.canvas,
            s = o && fe(o);
        if (!s) return;
        const a = e(((t, e) => {
                const i = s.clientWidth;
                n(t, e), i < s.clientWidth && n()
            }), window),
            r = new ResizeObserver((t => {
                const e = t[0],
                    i = e.contentRect.width,
                    n = e.contentRect.height;
                0 === i && 0 === n || a(i, n)
            }));
        return r.observe(s),
            function(t, e) {
                Gi.size || window.addEventListener("resize", Qi), Gi.set(t, e)
            }(t, a), r
    }

    function tn(t, e, i) {
        i && i.disconnect(), "resize" === e && function(t) {
            Gi.delete(t), Gi.size || window.removeEventListener("resize", Qi)
        }(t)
    }

    function en(t, i, n) {
        const o = t.canvas,
            s = e((e => {
                null !== t.ctx && n(function(t, e) {
                    const i = $i[t.type] || t.type,
                        {
                            x: n,
                            y: o
                        } = _e(t, e);
                    return {
                        type: i,
                        chart: e,
                        native: t,
                        x: void 0 !== n ? n : null,
                        y: void 0 !== o ? o : null
                    }
                }(e, t))
            }), t, (t => {
                const e = t[0];
                return [e, e.offsetX, e.offsetY]
            }));
        return function(t, e, i) {
            t.addEventListener(e, i, Ui)
        }(o, i, s), s
    }
    class nn extends Hi {
        acquireContext(t, e) {
            const i = t && t.getContext && t.getContext("2d");
            return i && i.canvas === t ? (function(t, e) {
                const i = t.style,
                    n = t.getAttribute("height"),
                    o = t.getAttribute("width");
                if (t.$chartjs = {
                        initial: {
                            height: n,
                            width: o,
                            style: {
                                display: i.display,
                                height: i.height,
                                width: i.width
                            }
                        }
                    }, i.display = i.display || "block", i.boxSizing = i.boxSizing || "border-box", Yi(o)) {
                    const e = ke(t, "width");
                    void 0 !== e && (t.width = e)
                }
                if (Yi(n))
                    if ("" === t.style.height) t.height = t.width / (e || 2);
                    else {
                        const e = ke(t, "height");
                        void 0 !== e && (t.height = e)
                    }
            }(t, e), i) : null
        }
        releaseContext(t) {
            const e = t.canvas;
            if (!e.$chartjs) return !1;
            const i = e.$chartjs.initial;
            ["height", "width"].forEach((t => {
                const n = i[t];
                $(n) ? e.removeAttribute(t) : e.setAttribute(t, n)
            }));
            const n = i.style || {};
            return Object.keys(n).forEach((t => {
                e.style[t] = n[t]
            })), e.width = e.width, delete e.$chartjs, !0
        }
        addEventListener(t, e, i) {
            this.removeEventListener(t, e);
            const n = t.$proxies || (t.$proxies = {}),
                o = {
                    attach: qi,
                    detach: Ki,
                    resize: Ji
                } [e] || en;
            n[e] = o(t, e, i)
        }
        removeEventListener(t, e) {
            const i = t.$proxies || (t.$proxies = {}),
                n = i[e];
            if (!n) return;
            ({
                attach: tn,
                detach: tn,
                resize: tn
            } [e] || Xi)(t, e, n), i[e] = void 0
        }
        getDevicePixelRatio() {
            return window.devicePixelRatio
        }
        getMaximumSize(t, e, i, n) {
            return ve(t, e, i, n)
        }
        isAttached(t) {
            const e = fe(t);
            return !(!e || !e.isConnected)
        }
    }

    function on(t) {
        return !ue() || "undefined" != typeof OffscreenCanvas && t instanceof OffscreenCanvas ? ji : nn
    }
    var sn = Object.freeze({
        __proto__: null,
        _detectPlatform: on,
        BasePlatform: Hi,
        BasicPlatform: ji,
        DomPlatform: nn
    });
    const an = "transparent",
        rn = {
            boolean: (t, e, i) => i > .5 ? e : t,
            color(t, e, i) {
                const n = W(t || an),
                    o = n.valid && W(e || an);
                return o && o.valid ? o.mix(n, i).hexString() : e
            },
            number: (t, e, i) => t + (e - t) * i
        };
    class ln {
        constructor(t, e, i, n) {
            const o = e[i];
            n = We([t.to, n, o, t.from]);
            const s = We([t.from, o, n]);
            this._active = !0, this._fn = t.fn || rn[t.type || typeof s], this._easing = ki[t.easing] || ki.linear, this._start = Math.floor(Date.now() + (t.delay || 0)), this._duration = this._total = Math.floor(t.duration), this._loop = !!t.loop, this._target = e, this._prop = i, this._from = s, this._to = n, this._promises = void 0
        }
        active() {
            return this._active
        }
        update(t, e, i) {
            const n = this;
            if (n._active) {
                n._notify(!1);
                const o = n._target[n._prop],
                    s = i - n._start,
                    a = n._duration - s;
                n._start = i, n._duration = Math.floor(Math.max(a, t.duration)), n._total += s, n._loop = !!t.loop, n._to = We([t.to, e, o, t.from]), n._from = We([t.from, o, e])
            }
        }
        cancel() {
            const t = this;
            t._active && (t.tick(Date.now()), t._active = !1, t._notify(!1))
        }
        tick(t) {
            const e = this,
                i = t - e._start,
                n = e._duration,
                o = e._prop,
                s = e._from,
                a = e._loop,
                r = e._to;
            let l;
            if (e._active = s !== r && (a || i < n), !e._active) return e._target[o] = r, void e._notify(!0);
            i < 0 ? e._target[o] = s : (l = i / n % 2, l = a && l > 1 ? 2 - l : l, l = e._easing(Math.min(1, Math.max(0, l))), e._target[o] = e._fn(s, r, l))
        }
        wait() {
            const t = this._promises || (this._promises = []);
            return new Promise(((e, i) => {
                t.push({
                    res: e,
                    rej: i
                })
            }))
        }
        _notify(t) {
            const e = t ? "res" : "rej",
                i = this._promises || [];
            for (let t = 0; t < i.length; t++) i[t][e]()
        }
    }
    xt.set("animation", {
        delay: void 0,
        duration: 1e3,
        easing: "easeOutQuart",
        fn: void 0,
        from: void 0,
        loop: void 0,
        to: void 0,
        type: void 0
    });
    const cn = Object.keys(xt.animation);
    xt.describe("animation", {
        _fallback: !1,
        _indexable: !1,
        _scriptable: t => "onProgress" !== t && "onComplete" !== t && "fn" !== t
    }), xt.set("animations", {
        colors: {
            type: "color",
            properties: ["color", "borderColor", "backgroundColor"]
        },
        numbers: {
            type: "number",
            properties: ["x", "y", "borderWidth", "radius", "tension"]
        }
    }), xt.describe("animations", {
        _fallback: "animation"
    }), xt.set("transitions", {
        active: {
            animation: {
                duration: 400
            }
        },
        resize: {
            animation: {
                duration: 0
            }
        },
        show: {
            animations: {
                colors: {
                    from: "transparent"
                },
                visible: {
                    type: "boolean",
                    duration: 0
                }
            }
        },
        hide: {
            animations: {
                colors: {
                    to: "transparent"
                },
                visible: {
                    type: "boolean",
                    easing: "linear",
                    fn: t => 0 | t
                }
            }
        }
    });
    class hn {
        constructor(t, e) {
            this._chart = t, this._properties = new Map, this.configure(e)
        }
        configure(t) {
            if (!U(t)) return;
            const e = this._properties;
            Object.getOwnPropertyNames(t).forEach((i => {
                const n = t[i];
                if (!U(n)) return;
                const o = {};
                for (const t of cn) o[t] = n[t];
                (Y(n.properties) && n.properties || [i]).forEach((t => {
                    t !== i && e.has(t) || e.set(t, o)
                }))
            }))
        }
        _animateOptions(t, e) {
            const i = e.options,
                n = function(t, e) {
                    if (!e) return;
                    let i = t.options;
                    if (!i) return void(t.options = e);
                    i.$shared && (t.options = i = Object.assign({}, i, {
                        $shared: !1,
                        $animations: {}
                    }));
                    return i
                }(t, i);
            if (!n) return [];
            const o = this._createAnimations(n, i);
            return i.$shared && function(t, e) {
                const i = [],
                    n = Object.keys(e);
                for (let e = 0; e < n.length; e++) {
                    const o = t[n[e]];
                    o && o.active() && i.push(o.wait())
                }
                return Promise.all(i)
            }(t.options.$animations, i).then((() => {
                t.options = i
            }), (() => {})), o
        }
        _createAnimations(t, e) {
            const i = this._properties,
                n = [],
                o = t.$animations || (t.$animations = {}),
                s = Object.keys(e),
                a = Date.now();
            let r;
            for (r = s.length - 1; r >= 0; --r) {
                const l = s[r];
                if ("$" === l.charAt(0)) continue;
                if ("options" === l) {
                    n.push(...this._animateOptions(t, e));
                    continue
                }
                const c = e[l];
                let h = o[l];
                const d = i.get(l);
                if (h) {
                    if (d && h.active()) {
                        h.update(d, c, a);
                        continue
                    }
                    h.cancel()
                }
                d && d.duration ? (o[l] = h = new ln(d, t, l, c), n.push(h)) : t[l] = c
            }
            return n
        }
        update(t, e) {
            if (0 === this._properties.size) return void Object.assign(t, e);
            const i = this._createAnimations(t, e);
            return i.length ? (a.add(this._chart, i), !0) : void 0
        }
    }

    function dn(t, e) {
        const i = t && t.options || {},
            n = i.reverse,
            o = void 0 === i.min ? e : 0,
            s = void 0 === i.max ? e : 0;
        return {
            start: n ? s : o,
            end: n ? o : s
        }
    }

    function un(t, e) {
        const i = [],
            n = t._getSortedDatasetMetas(e);
        let o, s;
        for (o = 0, s = n.length; o < s; ++o) i.push(n[o].index);
        return i
    }

    function fn(t, e, i, n) {
        const o = t.keys,
            s = "single" === n.mode;
        let a, r, l, c;
        if (null !== e) {
            for (a = 0, r = o.length; a < r; ++a) {
                if (l = +o[a], l === i) {
                    if (n.all) continue;
                    break
                }
                c = t.values[l], X(c) && (s || 0 === e || Dt(e) === Dt(c)) && (e += c)
            }
            return e
        }
    }

    function gn(t, e) {
        const i = t && t.options.stacked;
        return i || void 0 === i && void 0 !== e.stack
    }

    function pn(t, e, i) {
        const n = t[e] || (t[e] = {});
        return n[i] || (n[i] = {})
    }

    function mn(t, e, i) {
        for (const n of e.getMatchingVisibleMetas("bar").reverse()) {
            const e = t[n.index];
            if (i && e > 0 || !i && e < 0) return n.index
        }
        return null
    }

    function xn(t, e) {
        const {
            chart: i,
            _cachedMeta: n
        } = t, o = i._stacks || (i._stacks = {}), {
            iScale: s,
            vScale: a,
            index: r
        } = n, l = s.axis, c = a.axis, h = function(t, e, i) {
            return `${t.id}.${e.id}.${i.stack||i.type}`
        }(s, a, n), d = e.length;
        let u;
        for (let t = 0; t < d; ++t) {
            const i = e[t],
                {
                    [l]: n,
                    [c]: s
                } = i;
            u = (i._stacks || (i._stacks = {}))[c] = pn(o, h, n), u[r] = s, u._top = mn(u, a, !0), u._bottom = mn(u, a, !1)
        }
    }

    function bn(t, e) {
        const i = t.scales;
        return Object.keys(i).filter((t => i[t].axis === e)).shift()
    }

    function _n(t, e) {
        const i = t.controller.index,
            n = t.vScale && t.vScale.axis;
        if (n) {
            e = e || t._parsed;
            for (const t of e) {
                const e = t._stacks;
                if (!e || void 0 === e[n] || void 0 === e[n][i]) return;
                delete e[n][i]
            }
        }
    }
    const yn = t => "reset" === t || "none" === t,
        vn = (t, e) => e ? t : Object.assign({}, t);
    class wn {
        constructor(t, e) {
            this.chart = t, this._ctx = t.ctx, this.index = e, this._cachedDataOpts = {}, this._cachedMeta = this.getMeta(), this._type = this._cachedMeta.type, this.options = void 0, this._parsing = !1, this._data = void 0, this._objectData = void 0, this._sharedOptions = void 0, this._drawStart = void 0, this._drawCount = void 0, this.enableOptionSharing = !1, this.$context = void 0, this._syncList = [], this.initialize()
        }
        initialize() {
            const t = this,
                e = t._cachedMeta;
            t.configure(), t.linkScales(), e._stacked = gn(e.vScale, e), t.addElements()
        }
        updateIndex(t) {
            this.index !== t && _n(this._cachedMeta), this.index = t
        }
        linkScales() {
            const t = this,
                e = t.chart,
                i = t._cachedMeta,
                n = t.getDataset(),
                o = (t, e, i, n) => "x" === t ? e : "r" === t ? n : i,
                s = i.xAxisID = K(n.xAxisID, bn(e, "x")),
                a = i.yAxisID = K(n.yAxisID, bn(e, "y")),
                r = i.rAxisID = K(n.rAxisID, bn(e, "r")),
                l = i.indexAxis,
                c = i.iAxisID = o(l, s, a, r),
                h = i.vAxisID = o(l, a, s, r);
            i.xScale = t.getScaleForId(s), i.yScale = t.getScaleForId(a), i.rScale = t.getScaleForId(r), i.iScale = t.getScaleForId(c), i.vScale = t.getScaleForId(h)
        }
        getDataset() {
            return this.chart.data.datasets[this.index]
        }
        getMeta() {
            return this.chart.getDatasetMeta(this.index)
        }
        getScaleForId(t) {
            return this.chart.scales[t]
        }
        _getOtherScale(t) {
            const e = this._cachedMeta;
            return t === e.iScale ? e.vScale : e.iScale
        }
        reset() {
            this._update("reset")
        }
        _destroy() {
            const t = this._cachedMeta;
            this._data && he(this._data, this), t._stacked && _n(t)
        }
        _dataCheck() {
            const t = this,
                e = t.getDataset(),
                i = e.data || (e.data = []),
                n = t._data;
            if (U(i)) t._data = function(t) {
                const e = Object.keys(t),
                    i = new Array(e.length);
                let n, o, s;
                for (n = 0, o = e.length; n < o; ++n) s = e[n], i[n] = {
                    x: s,
                    y: t[s]
                };
                return i
            }(i);
            else if (n !== i) {
                if (n) {
                    he(n, t);
                    const e = t._cachedMeta;
                    _n(e), e._parsed = []
                }
                i && Object.isExtensible(i) && ce(i, t), t._syncList = [], t._data = i
            }
        }
        addElements() {
            const t = this,
                e = t._cachedMeta;
            t._dataCheck(), t.datasetElementType && (e.dataset = new t.datasetElementType)
        }
        buildOrUpdateElements(t) {
            const e = this,
                i = e._cachedMeta,
                n = e.getDataset();
            let o = !1;
            e._dataCheck();
            const s = i._stacked;
            i._stacked = gn(i.vScale, i), i.stack !== n.stack && (o = !0, _n(i), i.stack = n.stack), e._resyncElements(t), (o || s !== i._stacked) && xn(e, i._parsed)
        }
        configure() {
            const t = this,
                e = t.chart.config,
                i = e.datasetScopeKeys(t._type),
                n = e.getOptionScopes(t.getDataset(), i, !0);
            t.options = e.createResolver(n, t.getContext()), t._parsing = t.options.parsing
        }
        parse(t, e) {
            const i = this,
                {
                    _cachedMeta: n,
                    _data: o
                } = i,
                {
                    iScale: s,
                    _stacked: a
                } = n,
                r = s.axis;
            let l, c, h, d = 0 === t && e === o.length || n._sorted,
                u = t > 0 && n._parsed[t - 1];
            if (!1 === i._parsing) n._parsed = o, n._sorted = !0, h = o;
            else {
                h = Y(o[t]) ? i.parseArrayData(n, o, t, e) : U(o[t]) ? i.parseObjectData(n, o, t, e) : i.parsePrimitiveData(n, o, t, e);
                const s = () => null === c[r] || u && c[r] < u[r];
                for (l = 0; l < e; ++l) n._parsed[l + t] = c = h[l], d && (s() && (d = !1), u = c);
                n._sorted = d
            }
            a && xn(i, h)
        }
        parsePrimitiveData(t, e, i, n) {
            const {
                iScale: o,
                vScale: s
            } = t, a = o.axis, r = s.axis, l = o.getLabels(), c = o === s, h = new Array(n);
            let d, u, f;
            for (d = 0, u = n; d < u; ++d) f = d + i, h[d] = {
                [a]: c || o.parse(l[f], f),
                [r]: s.parse(e[f], f)
            };
            return h
        }
        parseArrayData(t, e, i, n) {
            const {
                xScale: o,
                yScale: s
            } = t, a = new Array(n);
            let r, l, c, h;
            for (r = 0, l = n; r < l; ++r) c = r + i, h = e[c], a[r] = {
                x: o.parse(h[0], c),
                y: s.parse(h[1], c)
            };
            return a
        }
        parseObjectData(t, e, i, n) {
            const {
                xScale: o,
                yScale: s
            } = t, {
                xAxisKey: a = "x",
                yAxisKey: r = "y"
            } = this._parsing, l = new Array(n);
            let c, h, d, u;
            for (c = 0, h = n; c < h; ++c) d = c + i, u = e[d], l[c] = {
                x: o.parse(lt(u, a), d),
                y: s.parse(lt(u, r), d)
            };
            return l
        }
        getParsed(t) {
            return this._cachedMeta._parsed[t]
        }
        getDataElement(t) {
            return this._cachedMeta.data[t]
        }
        applyStack(t, e, i) {
            const n = this.chart,
                o = this._cachedMeta,
                s = e[t.axis];
            return fn({
                keys: un(n, !0),
                values: e._stacks[t.axis]
            }, s, o.index, {
                mode: i
            })
        }
        updateRangeFromParsed(t, e, i, n) {
            const o = i[e.axis];
            let s = null === o ? NaN : o;
            const a = n && i._stacks[e.axis];
            n && a && (n.values = a, t.min = Math.min(t.min, s), t.max = Math.max(t.max, s), s = fn(n, o, this._cachedMeta.index, {
                all: !0
            })), t.min = Math.min(t.min, s), t.max = Math.max(t.max, s)
        }
        getMinMax(t, e) {
            const i = this,
                n = i._cachedMeta,
                o = n._parsed,
                s = n._sorted && t === n.iScale,
                a = o.length,
                r = i._getOtherScale(t),
                l = e && n._stacked && {
                    keys: un(i.chart, !0),
                    values: null
                },
                c = {
                    min: Number.POSITIVE_INFINITY,
                    max: Number.NEGATIVE_INFINITY
                },
                {
                    min: h,
                    max: d
                } = function(t) {
                    const {
                        min: e,
                        max: i,
                        minDefined: n,
                        maxDefined: o
                    } = t.getUserBounds();
                    return {
                        min: n ? e : Number.NEGATIVE_INFINITY,
                        max: o ? i : Number.POSITIVE_INFINITY
                    }
                }(r);
            let u, f, g, p;

            function m() {
                return g = o[u], f = g[t.axis], p = g[r.axis], !X(f) || h > p || d < p
            }
            for (u = 0; u < a && (m() || (i.updateRangeFromParsed(c, t, g, l), !s)); ++u);
            if (s)
                for (u = a - 1; u >= 0; --u)
                    if (!m()) {
                        i.updateRangeFromParsed(c, t, g, l);
                        break
                    } return c
        }
        getAllParsedValues(t) {
            const e = this._cachedMeta._parsed,
                i = [];
            let n, o, s;
            for (n = 0, o = e.length; n < o; ++n) s = e[n][t.axis], X(s) && i.push(s);
            return i
        }
        getMaxOverflow() {
            return !1
        }
        getLabelAndValue(t) {
            const e = this._cachedMeta,
                i = e.iScale,
                n = e.vScale,
                o = this.getParsed(t);
            return {
                label: i ? "" + i.getLabelForValue(o[i.axis]) : "",
                value: n ? "" + n.getLabelForValue(o[n.axis]) : ""
            }
        }
        _update(t) {
            const e = this,
                i = e._cachedMeta;
            e.configure(), e._cachedDataOpts = {}, e.update(t || "default"), i._clip = function(t) {
                let e, i, n, o;
                return U(t) ? (e = t.top, i = t.right, n = t.bottom, o = t.left) : e = i = n = o = t, {
                    top: e,
                    right: i,
                    bottom: n,
                    left: o,
                    disabled: !1 === t
                }
            }(K(e.options.clip, function(t, e, i) {
                if (!1 === i) return !1;
                const n = dn(t, i),
                    o = dn(e, i);
                return {
                    top: o.end,
                    right: n.end,
                    bottom: o.start,
                    left: n.start
                }
            }(i.xScale, i.yScale, e.getMaxOverflow())))
        }
        update(t) {}
        draw() {
            const t = this,
                e = t._ctx,
                i = t.chart,
                n = t._cachedMeta,
                o = n.data || [],
                s = i.chartArea,
                a = [],
                r = t._drawStart || 0,
                l = t._drawCount || o.length - r;
            let c;
            for (n.dataset && n.dataset.draw(e, s, r, l), c = r; c < r + l; ++c) {
                const t = o[c];
                t.hidden || (t.active ? a.push(t) : t.draw(e, s))
            }
            for (c = 0; c < a.length; ++c) a[c].draw(e, s)
        }
        getStyle(t, e) {
            const i = e ? "active" : "default";
            return void 0 === t && this._cachedMeta.dataset ? this.resolveDatasetElementOptions(i) : this.resolveDataElementOptions(t || 0, i)
        }
        getContext(t, e, i) {
            const n = this,
                o = n.getDataset();
            let s;
            if (t >= 0 && t < n._cachedMeta.data.length) {
                const e = n._cachedMeta.data[t];
                s = e.$context || (e.$context = function(t, e, i) {
                    return Object.assign(Object.create(t), {
                        active: !1,
                        dataIndex: e,
                        parsed: void 0,
                        raw: void 0,
                        element: i,
                        index: e,
                        mode: "default",
                        type: "data"
                    })
                }(n.getContext(), t, e)), s.parsed = n.getParsed(t), s.raw = o.data[t], s.index = s.dataIndex = t
            } else s = n.$context || (n.$context = function(t, e) {
                return Object.assign(Object.create(t), {
                    active: !1,
                    dataset: void 0,
                    datasetIndex: e,
                    index: e,
                    mode: "default",
                    type: "dataset"
                })
            }(n.chart.getContext(), n.index)), s.dataset = o, s.index = s.datasetIndex = n.index;
            return s.active = !!e, s.mode = i, s
        }
        resolveDatasetElementOptions(t) {
            return this._resolveElementOptions(this.datasetElementType.id, t)
        }
        resolveDataElementOptions(t, e) {
            return this._resolveElementOptions(this.dataElementType.id, e, t)
        }
        _resolveElementOptions(t, e = "default", i) {
            const n = this,
                o = "active" === e,
                s = n._cachedDataOpts,
                a = t + "-" + e,
                r = s[a],
                l = n.enableOptionSharing && ht(i);
            if (r) return vn(r, l);
            const c = n.chart.config,
                h = c.datasetElementScopeKeys(n._type, t),
                d = o ? [`${t}Hover`, "hover", t, ""] : [t, ""],
                u = c.getOptionScopes(n.getDataset(), h),
                f = Object.keys(xt.elements[t]),
                g = c.resolveNamedOptions(u, f, (() => n.getContext(i, o)), d);
            return g.$shared && (g.$shared = l, s[a] = Object.freeze(vn(g, l))), g
        }
        _resolveAnimations(t, e, i) {
            const n = this,
                o = n.chart,
                s = n._cachedDataOpts,
                a = `animation-${e}`,
                r = s[a];
            if (r) return r;
            let l;
            if (!1 !== o.options.animation) {
                const o = n.chart.config,
                    s = o.datasetAnimationScopeKeys(n._type, e),
                    a = o.getOptionScopes(n.getDataset(), s);
                l = o.createResolver(a, n.getContext(t, i, e))
            }
            const c = new hn(o, l && l.animations);
            return l && l._cacheable && (s[a] = Object.freeze(c)), c
        }
        getSharedOptions(t) {
            if (t.$shared) return this._sharedOptions || (this._sharedOptions = Object.assign({}, t))
        }
        includeOptions(t, e) {
            return !e || yn(t) || this.chart._animationsDisabled
        }
        updateElement(t, e, i, n) {
            yn(n) ? Object.assign(t, i) : this._resolveAnimations(e, n).update(t, i)
        }
        updateSharedOptions(t, e, i) {
            t && !yn(e) && this._resolveAnimations(void 0, e).update(t, i)
        }
        _setStyle(t, e, i, n) {
            t.active = n;
            const o = this.getStyle(e, n);
            this._resolveAnimations(e, i, n).update(t, {
                options: !n && this.getSharedOptions(o) || o
            })
        }
        removeHoverStyle(t, e, i) {
            this._setStyle(t, i, "active", !1)
        }
        setHoverStyle(t, e, i) {
            this._setStyle(t, i, "active", !0)
        }
        _removeDatasetHoverStyle() {
            const t = this._cachedMeta.dataset;
            t && this._setStyle(t, void 0, "active", !1)
        }
        _setDatasetHoverStyle() {
            const t = this._cachedMeta.dataset;
            t && this._setStyle(t, void 0, "active", !0)
        }
        _resyncElements(t) {
            const e = this,
                i = e._data,
                n = e._cachedMeta.data;
            for (const [t, i, n] of e._syncList) e[t](i, n);
            e._syncList = [];
            const o = n.length,
                s = i.length,
                a = Math.min(s, o);
            a && e.parse(0, a), s > o ? e._insertElements(o, s - o, t) : s < o && e._removeElements(s, o - s)
        }
        _insertElements(t, e, i = !0) {
            const n = this,
                o = n._cachedMeta,
                s = o.data,
                a = t + e;
            let r;
            const l = t => {
                for (t.length += e, r = t.length - 1; r >= a; r--) t[r] = t[r - e]
            };
            for (l(s), r = t; r < a; ++r) s[r] = new n.dataElementType;
            n._parsing && l(o._parsed), n.parse(t, e), i && n.updateElements(s, t, e, "reset")
        }
        updateElements(t, e, i, n) {}
        _removeElements(t, e) {
            const i = this._cachedMeta;
            if (this._parsing) {
                const n = i._parsed.splice(t, e);
                i._stacked && _n(i, n)
            }
            i.data.splice(t, e)
        }
        _onDataPush() {
            const t = arguments.length;
            this._syncList.push(["_insertElements", this.getDataset().data.length - t, t])
        }
        _onDataPop() {
            this._syncList.push(["_removeElements", this._cachedMeta.data.length - 1, 1])
        }
        _onDataShift() {
            this._syncList.push(["_removeElements", 0, 1])
        }
        _onDataSplice(t, e) {
            this._syncList.push(["_removeElements", t, e]), this._syncList.push(["_insertElements", t, arguments.length - 2])
        }
        _onDataUnshift() {
            this._syncList.push(["_insertElements", 0, arguments.length])
        }
    }
    wn.defaults = {}, wn.prototype.datasetElementType = null, wn.prototype.dataElementType = null;
    class Mn {
        constructor() {
            this.x = void 0, this.y = void 0, this.active = !1, this.options = void 0, this.$animations = void 0
        }
        tooltipPosition(t) {
            const {
                x: e,
                y: i
            } = this.getProps(["x", "y"], t);
            return {
                x: e,
                y: i
            }
        }
        hasValue() {
            return Tt(this.x) && Tt(this.y)
        }
        getProps(t, e) {
            const i = this,
                n = this.$animations;
            if (!e || !n) return i;
            const o = {};
            return t.forEach((t => {
                o[t] = n[t] && n[t].active() ? n[t]._to : i[t]
            })), o
        }
    }
    Mn.defaults = {}, Mn.defaultRoutes = void 0;
    const kn = {
        values: t => Y(t) ? t : "" + t,
        numeric(t, e, i) {
            if (0 === t) return "0";
            const n = this.chart.options.locale;
            let o, s = t;
            if (i.length > 1) {
                const e = Math.max(Math.abs(i[0].value), Math.abs(i[i.length - 1].value));
                (e < 1e-4 || e > 1e15) && (o = "scientific"), s = function(t, e) {
                    let i = e.length > 3 ? e[2].value - e[1].value : e[1].value - e[0].value;
                    Math.abs(i) >= 1 && t !== Math.floor(t) && (i = t - Math.floor(t));
                    return i
                }(t, i)
            }
            const a = Pt(Math.abs(s)),
                r = Math.max(Math.min(-1 * Math.floor(a), 20), 0),
                l = {
                    notation: o,
                    minimumFractionDigits: r,
                    maximumFractionDigits: r
                };
            return Object.assign(l, this.options.ticks.format), Oi(t, n, l)
        },
        logarithmic(t, e, i) {
            if (0 === t) return "0";
            const n = t / Math.pow(10, Math.floor(Pt(t)));
            return 1 === n || 2 === n || 5 === n ? kn.numeric.call(this, t, e, i) : ""
        }
    };
    var Sn = {
        formatters: kn
    };

    function Pn(t, e) {
        const i = t.options.ticks,
            n = i.maxTicksLimit || function(t) {
                const e = t.options.offset,
                    i = t._tickSize(),
                    n = t._length / i + (e ? 0 : 1),
                    o = t._maxLength / i;
                return Math.floor(Math.min(n, o))
            }(t),
            o = i.major.enabled ? function(t) {
                const e = [];
                let i, n;
                for (i = 0, n = t.length; i < n; i++) t[i].major && e.push(i);
                return e
            }(e) : [],
            s = o.length,
            a = o[0],
            r = o[s - 1],
            l = [];
        if (s > n) return function(t, e, i, n) {
            let o, s = 0,
                a = i[0];
            for (n = Math.ceil(n), o = 0; o < t.length; o++) o === a && (e.push(t[o]), s++, a = i[s * n])
        }(e, l, o, s / n), l;
        const c = function(t, e, i) {
            const n = function(t) {
                    const e = t.length;
                    let i, n;
                    if (e < 2) return !1;
                    for (n = t[0], i = 1; i < e; ++i)
                        if (t[i] - t[i - 1] !== n) return !1;
                    return n
                }(t),
                o = e.length / i;
            if (!n) return Math.max(o, 1);
            const s = Ot(n);
            for (let t = 0, e = s.length - 1; t < e; t++) {
                const e = s[t];
                if (e > o) return e
            }
            return Math.max(o, 1)
        }(o, e, n);
        if (s > 0) {
            let t, i;
            const n = s > 1 ? Math.round((r - a) / (s - 1)) : null;
            for (Dn(e, l, c, $(n) ? 0 : a - n, a), t = 0, i = s - 1; t < i; t++) Dn(e, l, c, o[t], o[t + 1]);
            return Dn(e, l, c, r, $(n) ? e.length : r + n), l
        }
        return Dn(e, l, c), l
    }

    function Dn(t, e, i, n, o) {
        const s = K(n, 0),
            a = Math.min(K(o, t.length), t.length);
        let r, l, c, h = 0;
        for (i = Math.ceil(i), o && (r = o - n, i = r / Math.floor(r / i)), c = s; c < 0;) h++, c = Math.round(s + h * i);
        for (l = Math.max(s, 0); l < a; l++) l === c && (e.push(t[l]), h++, c = Math.round(s + h * i))
    }
    xt.set("scale", {
        display: !0,
        offset: !1,
        reverse: !1,
        beginAtZero: !1,
        bounds: "ticks",
        grace: 0,
        grid: {
            display: !0,
            lineWidth: 1,
            drawBorder: !0,
            drawOnChartArea: !0,
            drawTicks: !0,
            tickLength: 8,
            tickWidth: (t, e) => e.lineWidth,
            tickColor: (t, e) => e.color,
            offset: !1,
            borderDash: [],
            borderDashOffset: 0,
            borderWidth: 1
        },
        title: {
            display: !1,
            text: "",
            padding: {
                top: 4,
                bottom: 4
            }
        },
        ticks: {
            minRotation: 0,
            maxRotation: 50,
            mirror: !1,
            textStrokeWidth: 0,
            textStrokeColor: "",
            padding: 3,
            display: !0,
            autoSkip: !0,
            autoSkipPadding: 3,
            labelOffset: 0,
            callback: Sn.formatters.values,
            minor: {},
            major: {},
            align: "center",
            crossAlign: "near",
            showLabelBackdrop: !1,
            backdropColor: "rgba(255, 255, 255, 0.75)",
            backdropPadding: 2
        }
    }), xt.route("scale.ticks", "color", "", "color"), xt.route("scale.grid", "color", "", "borderColor"), xt.route("scale.grid", "borderColor", "", "borderColor"), xt.route("scale.title", "color", "", "color"), xt.describe("scale", {
        _fallback: !1,
        _scriptable: t => !t.startsWith("before") && !t.startsWith("after") && "callback" !== t && "parser" !== t,
        _indexable: t => "borderDash" !== t && "tickBorderDash" !== t
    }), xt.describe("scales", {
        _fallback: "scale"
    }), xt.describe("scale.ticks", {
        _scriptable: t => "backdropPadding" !== t && "callback" !== t,
        _indexable: t => "backdropPadding" !== t
    });
    const Cn = (t, e, i) => "top" === e || "left" === e ? t[e] + i : t[e] - i;

    function On(t, e) {
        const i = [],
            n = t.length / e,
            o = t.length;
        let s = 0;
        for (; s < o; s += n) i.push(t[Math.floor(s)]);
        return i
    }

    function Tn(t, e, i) {
        const n = t.ticks.length,
            o = Math.min(e, n - 1),
            s = t._startPixel,
            a = t._endPixel,
            r = 1e-6;
        let l, c = t.getPixelForTick(o);
        if (!(i && (l = 1 === n ? Math.max(c - s, a - c) : 0 === e ? (t.getPixelForTick(1) - c) / 2 : (c - t.getPixelForTick(o - 1)) / 2, c += o < e ? l : -l, c < s - r || c > a + r))) return c
    }

    function An(t) {
        return t.drawTicks ? t.tickLength : 0
    }

    function Ln(t, e) {
        if (!t.display) return 0;
        const i = Ve(t.font, e),
            n = Be(t.padding);
        return (Y(t.text) ? t.text.length : 1) * i.lineHeight + n.height
    }

    function Rn(t, e, i) {
        let o = n(t);
        return (i && "right" !== e || !i && "right" === e) && (o = (t => "left" === t ? "right" : "right" === t ? "left" : t)(o)), o
    }
    class En extends Mn {
        constructor(t) {
            super(), this.id = t.id, this.type = t.type, this.options = void 0, this.ctx = t.ctx, this.chart = t.chart, this.top = void 0, this.bottom = void 0, this.left = void 0, this.right = void 0, this.width = void 0, this.height = void 0, this._margins = {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }, this.maxWidth = void 0, this.maxHeight = void 0, this.paddingTop = void 0, this.paddingBottom = void 0, this.paddingLeft = void 0, this.paddingRight = void 0, this.axis = void 0, this.labelRotation = void 0, this.min = void 0, this.max = void 0, this._range = void 0, this.ticks = [], this._gridLineItems = null, this._labelItems = null, this._labelSizes = null, this._length = 0, this._maxLength = 0, this._longestTextCache = {}, this._startPixel = void 0, this._endPixel = void 0, this._reversePixels = !1, this._userMax = void 0, this._userMin = void 0, this._suggestedMax = void 0, this._suggestedMin = void 0, this._ticksLength = 0, this._borderValue = 0, this._cache = {}, this._dataLimitsCached = !1, this.$context = void 0
        }
        init(t) {
            const e = this;
            e.options = t.setContext(e.getContext()), e.axis = t.axis, e._userMin = e.parse(t.min), e._userMax = e.parse(t.max), e._suggestedMin = e.parse(t.suggestedMin), e._suggestedMax = e.parse(t.suggestedMax)
        }
        parse(t, e) {
            return t
        }
        getUserBounds() {
            let {
                _userMin: t,
                _userMax: e,
                _suggestedMin: i,
                _suggestedMax: n
            } = this;
            return t = q(t, Number.POSITIVE_INFINITY), e = q(e, Number.NEGATIVE_INFINITY), i = q(i, Number.POSITIVE_INFINITY), n = q(n, Number.NEGATIVE_INFINITY), {
                min: q(t, i),
                max: q(e, n),
                minDefined: X(t),
                maxDefined: X(e)
            }
        }
        getMinMax(t) {
            const e = this;
            let i, {
                min: n,
                max: o,
                minDefined: s,
                maxDefined: a
            } = e.getUserBounds();
            if (s && a) return {
                min: n,
                max: o
            };
            const r = e.getMatchingVisibleMetas();
            for (let l = 0, c = r.length; l < c; ++l) i = r[l].controller.getMinMax(e, t), s || (n = Math.min(n, i.min)), a || (o = Math.max(o, i.max));
            return {
                min: q(n, q(o, n)),
                max: q(o, q(n, o))
            }
        }
        getPadding() {
            const t = this;
            return {
                left: t.paddingLeft || 0,
                top: t.paddingTop || 0,
                right: t.paddingRight || 0,
                bottom: t.paddingBottom || 0
            }
        }
        getTicks() {
            return this.ticks
        }
        getLabels() {
            const t = this.chart.data;
            return this.options.labels || (this.isHorizontal() ? t.xLabels : t.yLabels) || t.labels || []
        }
        beforeLayout() {
            this._cache = {}, this._dataLimitsCached = !1
        }
        beforeUpdate() {
            Q(this.options.beforeUpdate, [this])
        }
        update(t, e, i) {
            const n = this,
                o = n.options.ticks,
                s = o.sampleSize;
            n.beforeUpdate(), n.maxWidth = t, n.maxHeight = e, n._margins = i = Object.assign({
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }, i), n.ticks = null, n._labelSizes = null, n._gridLineItems = null, n._labelItems = null, n.beforeSetDimensions(), n.setDimensions(), n.afterSetDimensions(), n._maxLength = n.isHorizontal() ? n.width + i.left + i.right : n.height + i.top + i.bottom, n._dataLimitsCached || (n.beforeDataLimits(), n.determineDataLimits(), n.afterDataLimits(), n._range = Ne(n, n.options.grace), n._dataLimitsCached = !0), n.beforeBuildTicks(), n.ticks = n.buildTicks() || [], n.afterBuildTicks();
            const a = s < n.ticks.length;
            n._convertTicksToLabels(a ? On(n.ticks, s) : n.ticks), n.configure(), n.beforeCalculateLabelRotation(), n.calculateLabelRotation(), n.afterCalculateLabelRotation(), o.display && (o.autoSkip || "auto" === o.source) && (n.ticks = Pn(n, n.ticks), n._labelSizes = null), a && n._convertTicksToLabels(n.ticks), n.beforeFit(), n.fit(), n.afterFit(), n.afterUpdate()
        }
        configure() {
            const t = this;
            let e, i, n = t.options.reverse;
            t.isHorizontal() ? (e = t.left, i = t.right) : (e = t.top, i = t.bottom, n = !n), t._startPixel = e, t._endPixel = i, t._reversePixels = n, t._length = i - e, t._alignToPixels = t.options.alignToPixels
        }
        afterUpdate() {
            Q(this.options.afterUpdate, [this])
        }
        beforeSetDimensions() {
            Q(this.options.beforeSetDimensions, [this])
        }
        setDimensions() {
            const t = this;
            t.isHorizontal() ? (t.width = t.maxWidth, t.left = 0, t.right = t.width) : (t.height = t.maxHeight, t.top = 0, t.bottom = t.height), t.paddingLeft = 0, t.paddingTop = 0, t.paddingRight = 0, t.paddingBottom = 0
        }
        afterSetDimensions() {
            Q(this.options.afterSetDimensions, [this])
        }
        _callHooks(t) {
            const e = this;
            e.chart.notifyPlugins(t, e.getContext()), Q(e.options[t], [e])
        }
        beforeDataLimits() {
            this._callHooks("beforeDataLimits")
        }
        determineDataLimits() {}
        afterDataLimits() {
            this._callHooks("afterDataLimits")
        }
        beforeBuildTicks() {
            this._callHooks("beforeBuildTicks")
        }
        buildTicks() {
            return []
        }
        afterBuildTicks() {
            this._callHooks("afterBuildTicks")
        }
        beforeTickToLabelConversion() {
            Q(this.options.beforeTickToLabelConversion, [this])
        }
        generateTickLabels(t) {
            const e = this,
                i = e.options.ticks;
            let n, o, s;
            for (n = 0, o = t.length; n < o; n++) s = t[n], s.label = Q(i.callback, [s.value, n, t], e)
        }
        afterTickToLabelConversion() {
            Q(this.options.afterTickToLabelConversion, [this])
        }
        beforeCalculateLabelRotation() {
            Q(this.options.beforeCalculateLabelRotation, [this])
        }
        calculateLabelRotation() {
            const t = this,
                e = t.options,
                i = e.ticks,
                n = t.ticks.length,
                o = i.minRotation || 0,
                s = i.maxRotation;
            let a, r, l, c = o;
            if (!t._isVisible() || !i.display || o >= s || n <= 1 || !t.isHorizontal()) return void(t.labelRotation = o);
            const h = t._getLabelSizes(),
                d = h.widest.width,
                u = h.highest.height,
                f = Ht(t.chart.width - d, 0, t.maxWidth);
            a = e.offset ? t.maxWidth / n : f / (n - 1), d + 6 > a && (a = f / (n - (e.offset ? .5 : 1)), r = t.maxHeight - An(e.grid) - i.padding - Ln(e.title, t.chart.options.font), l = Math.sqrt(d * d + u * u), c = It(Math.min(Math.asin(Ht((h.highest.height + 6) / a, -1, 1)), Math.asin(Ht(r / l, -1, 1)) - Math.asin(Ht(u / l, -1, 1)))), c = Math.max(o, Math.min(s, c))), t.labelRotation = c
        }
        afterCalculateLabelRotation() {
            Q(this.options.afterCalculateLabelRotation, [this])
        }
        beforeFit() {
            Q(this.options.beforeFit, [this])
        }
        fit() {
            const t = this,
                e = {
                    width: 0,
                    height: 0
                },
                {
                    chart: i,
                    options: {
                        ticks: n,
                        title: o,
                        grid: s
                    }
                } = t,
                a = t._isVisible(),
                r = t.isHorizontal();
            if (a) {
                const a = Ln(o, i.options.font);
                if (r ? (e.width = t.maxWidth, e.height = An(s) + a) : (e.height = t.maxHeight, e.width = An(s) + a), n.display && t.ticks.length) {
                    const {
                        first: i,
                        last: o,
                        widest: s,
                        highest: a
                    } = t._getLabelSizes(), l = 2 * n.padding, c = Et(t.labelRotation), h = Math.cos(c), d = Math.sin(c);
                    if (r) {
                        const i = n.mirror ? 0 : d * s.width + h * a.height;
                        e.height = Math.min(t.maxHeight, e.height + i + l)
                    } else {
                        const i = n.mirror ? 0 : h * s.width + d * a.height;
                        e.width = Math.min(t.maxWidth, e.width + i + l)
                    }
                    t._calculatePadding(i, o, d, h)
                }
            }
            t._handleMargins(), r ? (t.width = t._length = i.width - t._margins.left - t._margins.right, t.height = e.height) : (t.width = e.width, t.height = t._length = i.height - t._margins.top - t._margins.bottom)
        }
        _calculatePadding(t, e, i, n) {
            const o = this,
                {
                    ticks: {
                        align: s,
                        padding: a
                    },
                    position: r
                } = o.options,
                l = 0 !== o.labelRotation,
                c = "top" !== r && "x" === o.axis;
            if (o.isHorizontal()) {
                const r = o.getPixelForTick(0) - o.left,
                    h = o.right - o.getPixelForTick(o.ticks.length - 1);
                let d = 0,
                    u = 0;
                l ? c ? (d = n * t.width, u = i * e.height) : (d = i * t.height, u = n * e.width) : "start" === s ? u = e.width : "end" === s ? d = t.width : (d = t.width / 2, u = e.width / 2), o.paddingLeft = Math.max((d - r + a) * o.width / (o.width - r), 0), o.paddingRight = Math.max((u - h + a) * o.width / (o.width - h), 0)
            } else {
                let i = e.height / 2,
                    n = t.height / 2;
                "start" === s ? (i = 0, n = t.height) : "end" === s && (i = e.height, n = 0), o.paddingTop = i + a, o.paddingBottom = n + a
            }
        }
        _handleMargins() {
            const t = this;
            t._margins && (t._margins.left = Math.max(t.paddingLeft, t._margins.left), t._margins.top = Math.max(t.paddingTop, t._margins.top), t._margins.right = Math.max(t.paddingRight, t._margins.right), t._margins.bottom = Math.max(t.paddingBottom, t._margins.bottom))
        }
        afterFit() {
            Q(this.options.afterFit, [this])
        }
        isHorizontal() {
            const {
                axis: t,
                position: e
            } = this.options;
            return "top" === e || "bottom" === e || "x" === t
        }
        isFullSize() {
            return this.options.fullSize
        }
        _convertTicksToLabels(t) {
            const e = this;
            let i, n;
            for (e.beforeTickToLabelConversion(), e.generateTickLabels(t), i = 0, n = t.length; i < n; i++) $(t[i].label) && (t.splice(i, 1), n--, i--);
            e.afterTickToLabelConversion()
        }
        _getLabelSizes() {
            const t = this;
            let e = t._labelSizes;
            if (!e) {
                const i = t.options.ticks.sampleSize;
                let n = t.ticks;
                i < n.length && (n = On(n, i)), t._labelSizes = e = t._computeLabelSizes(n, n.length)
            }
            return e
        }
        _computeLabelSizes(t, e) {
            const {
                ctx: i,
                _longestTextCache: n
            } = this, o = [], s = [];
            let a, r, l, c, h, d, u, f, g, p, m, x = 0,
                b = 0;
            for (a = 0; a < e; ++a) {
                if (c = t[a].label, h = this._resolveTickFontOptions(a), i.font = d = h.string, u = n[d] = n[d] || {
                        data: {},
                        gc: []
                    }, f = h.lineHeight, g = p = 0, $(c) || Y(c)) {
                    if (Y(c))
                        for (r = 0, l = c.length; r < l; ++r) m = c[r], $(m) || Y(m) || (g = Yt(i, u.data, u.gc, g, m), p += f)
                } else g = Yt(i, u.data, u.gc, g, c), p = f;
                o.push(g), s.push(p), x = Math.max(g, x), b = Math.max(p, b)
            }! function(t, e) {
                J(t, (t => {
                    const i = t.gc,
                        n = i.length / 2;
                    let o;
                    if (n > e) {
                        for (o = 0; o < n; ++o) delete t.data[i[o]];
                        i.splice(0, n)
                    }
                }))
            }(n, e);
            const _ = o.indexOf(x),
                y = s.indexOf(b),
                v = t => ({
                    width: o[t] || 0,
                    height: s[t] || 0
                });
            return {
                first: v(0),
                last: v(e - 1),
                widest: v(_),
                highest: v(y),
                widths: o,
                heights: s
            }
        }
        getLabelForValue(t) {
            return t
        }
        getPixelForValue(t, e) {
            return NaN
        }
        getValueForPixel(t) {}
        getPixelForTick(t) {
            const e = this.ticks;
            return t < 0 || t > e.length - 1 ? null : this.getPixelForValue(e[t].value)
        }
        getPixelForDecimal(t) {
            const e = this;
            e._reversePixels && (t = 1 - t);
            const i = e._startPixel + t * e._length;
            return jt(e._alignToPixels ? Xt(e.chart, i, 0) : i)
        }
        getDecimalForPixel(t) {
            const e = (t - this._startPixel) / this._length;
            return this._reversePixels ? 1 - e : e
        }
        getBasePixel() {
            return this.getPixelForValue(this.getBaseValue())
        }
        getBaseValue() {
            const {
                min: t,
                max: e
            } = this;
            return t < 0 && e < 0 ? e : t > 0 && e > 0 ? t : 0
        }
        getContext(t) {
            const e = this,
                i = e.ticks || [];
            if (t >= 0 && t < i.length) {
                const n = i[t];
                return n.$context || (n.$context = function(t, e, i) {
                    return Object.assign(Object.create(t), {
                        tick: i,
                        index: e,
                        type: "tick"
                    })
                }(e.getContext(), t, n))
            }
            return e.$context || (e.$context = (n = e.chart.getContext(), o = e, Object.assign(Object.create(n), {
                scale: o,
                type: "scale"
            })));
            var n, o
        }
        _tickSize() {
            const t = this,
                e = t.options.ticks,
                i = Et(t.labelRotation),
                n = Math.abs(Math.cos(i)),
                o = Math.abs(Math.sin(i)),
                s = t._getLabelSizes(),
                a = e.autoSkipPadding || 0,
                r = s ? s.widest.width + a : 0,
                l = s ? s.highest.height + a : 0;
            return t.isHorizontal() ? l * n > r * o ? r / n : l / o : l * o < r * n ? l / n : r / o
        }
        _isVisible() {
            const t = this.options.display;
            return "auto" !== t ? !!t : this.getMatchingVisibleMetas().length > 0
        }
        _computeGridLineItems(t) {
            const e = this,
                i = e.axis,
                n = e.chart,
                o = e.options,
                {
                    grid: s,
                    position: a
                } = o,
                r = s.offset,
                l = e.isHorizontal(),
                c = e.ticks.length + (r ? 1 : 0),
                h = An(s),
                d = [],
                u = s.setContext(e.getContext()),
                f = u.drawBorder ? u.borderWidth : 0,
                g = f / 2,
                p = function(t) {
                    return Xt(n, t, f)
                };
            let m, x, b, _, y, v, w, M, k, S, P, D;
            if ("top" === a) m = p(e.bottom), v = e.bottom - h, M = m - g, S = p(t.top) + g, D = t.bottom;
            else if ("bottom" === a) m = p(e.top), S = t.top, D = p(t.bottom) - g, v = m + g, M = e.top + h;
            else if ("left" === a) m = p(e.right), y = e.right - h, w = m - g, k = p(t.left) + g, P = t.right;
            else if ("right" === a) m = p(e.left), k = t.left, P = p(t.right) - g, y = m + g, w = e.left + h;
            else if ("x" === i) {
                if ("center" === a) m = p((t.top + t.bottom) / 2 + .5);
                else if (U(a)) {
                    const t = Object.keys(a)[0],
                        i = a[t];
                    m = p(e.chart.scales[t].getPixelForValue(i))
                }
                S = t.top, D = t.bottom, v = m + g, M = v + h
            } else if ("y" === i) {
                if ("center" === a) m = p((t.left + t.right) / 2);
                else if (U(a)) {
                    const t = Object.keys(a)[0],
                        i = a[t];
                    m = p(e.chart.scales[t].getPixelForValue(i))
                }
                y = m - g, w = y - h, k = t.left, P = t.right
            }
            const C = K(o.ticks.maxTicksLimit, c),
                O = Math.max(1, Math.ceil(c / C));
            for (x = 0; x < c; x += O) {
                const t = s.setContext(e.getContext(x)),
                    i = t.lineWidth,
                    o = t.color,
                    a = s.borderDash || [],
                    c = t.borderDashOffset,
                    h = t.tickWidth,
                    u = t.tickColor,
                    f = t.tickBorderDash || [],
                    g = t.tickBorderDashOffset;
                b = Tn(e, x, r), void 0 !== b && (_ = Xt(n, b, i), l ? y = w = k = P = _ : v = M = S = D = _, d.push({
                    tx1: y,
                    ty1: v,
                    tx2: w,
                    ty2: M,
                    x1: k,
                    y1: S,
                    x2: P,
                    y2: D,
                    width: i,
                    color: o,
                    borderDash: a,
                    borderDashOffset: c,
                    tickWidth: h,
                    tickColor: u,
                    tickBorderDash: f,
                    tickBorderDashOffset: g
                }))
            }
            return e._ticksLength = c, e._borderValue = m, d
        }
        _computeLabelItems(t) {
            const e = this,
                i = e.axis,
                n = e.options,
                {
                    position: o,
                    ticks: s
                } = n,
                a = e.isHorizontal(),
                r = e.ticks,
                {
                    align: l,
                    crossAlign: c,
                    padding: h,
                    mirror: d
                } = s,
                u = An(n.grid),
                f = u + h,
                g = d ? -h : f,
                p = -Et(e.labelRotation),
                m = [];
            let x, b, _, y, v, w, M, k, S, P, D, C, O = "middle";
            if ("top" === o) w = e.bottom - g, M = e._getXAxisLabelAlignment();
            else if ("bottom" === o) w = e.top + g, M = e._getXAxisLabelAlignment();
            else if ("left" === o) {
                const t = e._getYAxisLabelAlignment(u);
                M = t.textAlign, v = t.x
            } else if ("right" === o) {
                const t = e._getYAxisLabelAlignment(u);
                M = t.textAlign, v = t.x
            } else if ("x" === i) {
                if ("center" === o) w = (t.top + t.bottom) / 2 + f;
                else if (U(o)) {
                    const t = Object.keys(o)[0],
                        i = o[t];
                    w = e.chart.scales[t].getPixelForValue(i) + f
                }
                M = e._getXAxisLabelAlignment()
            } else if ("y" === i) {
                if ("center" === o) v = (t.left + t.right) / 2 - f;
                else if (U(o)) {
                    const t = Object.keys(o)[0],
                        i = o[t];
                    v = e.chart.scales[t].getPixelForValue(i)
                }
                M = e._getYAxisLabelAlignment(u).textAlign
            }
            "y" === i && ("start" === l ? O = "top" : "end" === l && (O = "bottom"));
            const T = e._getLabelSizes();
            for (x = 0, b = r.length; x < b; ++x) {
                _ = r[x], y = _.label;
                const t = s.setContext(e.getContext(x));
                k = e.getPixelForTick(x) + s.labelOffset, S = e._resolveTickFontOptions(x), P = S.lineHeight, D = Y(y) ? y.length : 1;
                const i = D / 2,
                    n = t.color,
                    l = t.textStrokeColor,
                    h = t.textStrokeWidth;
                let u;
                if (a ? (v = k, C = "top" === o ? "near" === c || 0 !== p ? -D * P + P / 2 : "center" === c ? -T.highest.height / 2 - i * P + P : -T.highest.height + P / 2 : "near" === c || 0 !== p ? P / 2 : "center" === c ? T.highest.height / 2 - i * P : T.highest.height - D * P, d && (C *= -1)) : (w = k, C = (1 - D) * P / 2), t.showLabelBackdrop) {
                    const e = Be(t.backdropPadding),
                        i = T.heights[x],
                        n = T.widths[x];
                    let o = w + C - e.top,
                        s = v - e.left;
                    switch (O) {
                        case "middle":
                            o -= i / 2;
                            break;
                        case "bottom":
                            o -= i
                    }
                    switch (M) {
                        case "center":
                            s -= n / 2;
                            break;
                        case "right":
                            s -= n
                    }
                    u = {
                        left: s,
                        top: o,
                        width: n + e.width,
                        height: i + e.height,
                        color: t.backdropColor
                    }
                }
                m.push({
                    rotation: p,
                    label: y,
                    font: S,
                    color: n,
                    strokeColor: l,
                    strokeWidth: h,
                    textOffset: C,
                    textAlign: M,
                    textBaseline: O,
                    translation: [v, w],
                    backdrop: u
                })
            }
            return m
        }
        _getXAxisLabelAlignment() {
            const {
                position: t,
                ticks: e
            } = this.options;
            if (-Et(this.labelRotation)) return "top" === t ? "left" : "right";
            let i = "center";
            return "start" === e.align ? i = "left" : "end" === e.align && (i = "right"), i
        }
        _getYAxisLabelAlignment(t) {
            const e = this,
                {
                    position: i,
                    ticks: {
                        crossAlign: n,
                        mirror: o,
                        padding: s
                    }
                } = e.options,
                a = t + s,
                r = e._getLabelSizes().widest.width;
            let l, c;
            return "left" === i ? o ? (l = "left", c = e.right + s) : (c = e.right - a, "near" === n ? l = "right" : "center" === n ? (l = "center", c -= r / 2) : (l = "left", c = e.left)) : "right" === i ? o ? (l = "right", c = e.left + s) : (c = e.left + a, "near" === n ? l = "left" : "center" === n ? (l = "center", c += r / 2) : (l = "right", c = e.right)) : l = "right", {
                textAlign: l,
                x: c
            }
        }
        _computeLabelArea() {
            const t = this;
            if (t.options.ticks.mirror) return;
            const e = t.chart,
                i = t.options.position;
            return "left" === i || "right" === i ? {
                top: 0,
                left: t.left,
                bottom: e.height,
                right: t.right
            } : "top" === i || "bottom" === i ? {
                top: t.top,
                left: 0,
                bottom: t.bottom,
                right: e.width
            } : void 0
        }
        drawBackground() {
            const {
                ctx: t,
                options: {
                    backgroundColor: e
                },
                left: i,
                top: n,
                width: o,
                height: s
            } = this;
            e && (t.save(), t.fillStyle = e, t.fillRect(i, n, o, s), t.restore())
        }
        getLineWidthForValue(t) {
            const e = this,
                i = e.options.grid;
            if (!e._isVisible() || !i.display) return 0;
            const n = e.ticks.findIndex((e => e.value === t));
            if (n >= 0) {
                return i.setContext(e.getContext(n)).lineWidth
            }
            return 0
        }
        drawGrid(t) {
            const e = this,
                i = e.options.grid,
                n = e.ctx,
                o = e._gridLineItems || (e._gridLineItems = e._computeGridLineItems(t));
            let s, a;
            const r = (t, e, i) => {
                i.width && i.color && (n.save(), n.lineWidth = i.width, n.strokeStyle = i.color, n.setLineDash(i.borderDash || []), n.lineDashOffset = i.borderDashOffset, n.beginPath(), n.moveTo(t.x, t.y), n.lineTo(e.x, e.y), n.stroke(), n.restore())
            };
            if (i.display)
                for (s = 0, a = o.length; s < a; ++s) {
                    const t = o[s];
                    i.drawOnChartArea && r({
                        x: t.x1,
                        y: t.y1
                    }, {
                        x: t.x2,
                        y: t.y2
                    }, t), i.drawTicks && r({
                        x: t.tx1,
                        y: t.ty1
                    }, {
                        x: t.tx2,
                        y: t.ty2
                    }, {
                        color: t.tickColor,
                        width: t.tickWidth,
                        borderDash: t.tickBorderDash,
                        borderDashOffset: t.tickBorderDashOffset
                    })
                }
        }
        drawBorder() {
            const t = this,
                {
                    chart: e,
                    ctx: i,
                    options: {
                        grid: n
                    }
                } = t,
                o = n.setContext(t.getContext()),
                s = n.drawBorder ? o.borderWidth : 0;
            if (!s) return;
            const a = n.setContext(t.getContext(0)).lineWidth,
                r = t._borderValue;
            let l, c, h, d;
            t.isHorizontal() ? (l = Xt(e, t.left, s) - s / 2, c = Xt(e, t.right, a) + a / 2, h = d = r) : (h = Xt(e, t.top, s) - s / 2, d = Xt(e, t.bottom, a) + a / 2, l = c = r), i.save(), i.lineWidth = o.borderWidth, i.strokeStyle = o.borderColor, i.beginPath(), i.moveTo(l, h), i.lineTo(c, d), i.stroke(), i.restore()
        }
        drawLabels(t) {
            const e = this;
            if (!e.options.ticks.display) return;
            const i = e.ctx,
                n = e._computeLabelArea();
            n && Zt(i, n);
            const o = e._labelItems || (e._labelItems = e._computeLabelItems(t));
            let s, a;
            for (s = 0, a = o.length; s < a; ++s) {
                const t = o[s],
                    e = t.font,
                    n = t.label;
                t.backdrop && (i.fillStyle = t.backdrop.color, i.fillRect(t.backdrop.left, t.backdrop.top, t.backdrop.width, t.backdrop.height)), ee(i, n, 0, t.textOffset, e, t)
            }
            n && Qt(i)
        }
        drawTitle() {
            const {
                ctx: t,
                options: {
                    position: e,
                    title: i,
                    reverse: n
                }
            } = this;
            if (!i.display) return;
            const s = Ve(i.font),
                a = Be(i.padding),
                r = i.align;
            let l = s.lineHeight / 2;
            "bottom" === e || "center" === e || U(e) ? (l += a.bottom, Y(i.text) && (l += s.lineHeight * (i.text.length - 1))) : l += a.top;
            const {
                titleX: c,
                titleY: h,
                maxWidth: d,
                rotation: u
            } = function(t, e, i, n) {
                const {
                    top: s,
                    left: a,
                    bottom: r,
                    right: l,
                    chart: c
                } = t, {
                    chartArea: h,
                    scales: d
                } = c;
                let u, f, g, p = 0;
                const m = r - s,
                    x = l - a;
                if (t.isHorizontal()) {
                    if (f = o(n, a, l), U(i)) {
                        const t = Object.keys(i)[0],
                            n = i[t];
                        g = d[t].getPixelForValue(n) + m - e
                    } else g = "center" === i ? (h.bottom + h.top) / 2 + m - e : Cn(t, i, e);
                    u = l - a
                } else {
                    if (U(i)) {
                        const t = Object.keys(i)[0],
                            n = i[t];
                        f = d[t].getPixelForValue(n) - x + e
                    } else f = "center" === i ? (h.left + h.right) / 2 - x + e : Cn(t, i, e);
                    g = o(n, r, s), p = "left" === i ? -Mt : Mt
                }
                return {
                    titleX: f,
                    titleY: g,
                    maxWidth: u,
                    rotation: p
                }
            }(this, l, e, r);
            ee(t, i.text, 0, 0, s, {
                color: i.color,
                maxWidth: d,
                rotation: u,
                textAlign: Rn(r, e, n),
                textBaseline: "middle",
                translation: [c, h]
            })
        }
        draw(t) {
            const e = this;
            e._isVisible() && (e.drawBackground(), e.drawGrid(t), e.drawBorder(), e.drawTitle(), e.drawLabels(t))
        }
        _layers() {
            const t = this,
                e = t.options,
                i = e.ticks && e.ticks.z || 0,
                n = K(e.grid && e.grid.z, -1);
            return t._isVisible() && t.draw === En.prototype.draw ? [{
                z: n,
                draw(e) {
                    t.drawBackground(), t.drawGrid(e), t.drawTitle()
                }
            }, {
                z: n + 1,
                draw() {
                    t.drawBorder()
                }
            }, {
                z: i,
                draw(e) {
                    t.drawLabels(e)
                }
            }] : [{
                z: i,
                draw(e) {
                    t.draw(e)
                }
            }]
        }
        getMatchingVisibleMetas(t) {
            const e = this,
                i = e.chart.getSortedVisibleDatasetMetas(),
                n = e.axis + "AxisID",
                o = [];
            let s, a;
            for (s = 0, a = i.length; s < a; ++s) {
                const a = i[s];
                a[n] !== e.id || t && a.type !== t || o.push(a)
            }
            return o
        }
        _resolveTickFontOptions(t) {
            return Ve(this.options.ticks.setContext(this.getContext(t)).font)
        }
        _maxDigits() {
            const t = this,
                e = t._resolveTickFontOptions(0).lineHeight;
            return (t.isHorizontal() ? t.width : t.height) / e
        }
    }
    class In {
        constructor(t, e, i) {
            this.type = t, this.scope = e, this.override = i, this.items = Object.create(null)
        }
        isForType(t) {
            return Object.prototype.isPrototypeOf.call(this.type.prototype, t.prototype)
        }
        register(t) {
            const e = this,
                i = Object.getPrototypeOf(t);
            let n;
            (function(t) {
                return "id" in t && "defaults" in t
            })(i) && (n = e.register(i));
            const o = e.items,
                s = t.id,
                a = e.scope + "." + s;
            if (!s) throw new Error("class does not have id: " + t);
            return s in o || (o[s] = t, function(t, e, i) {
                const n = ot(Object.create(null), [i ? xt.get(i) : {}, xt.get(e), t.defaults]);
                xt.set(e, n), t.defaultRoutes && function(t, e) {
                    Object.keys(e).forEach((i => {
                        const n = i.split("."),
                            o = n.pop(),
                            s = [t].concat(n).join("."),
                            a = e[i].split("."),
                            r = a.pop(),
                            l = a.join(".");
                        xt.route(s, o, l, r)
                    }))
                }(e, t.defaultRoutes);
                t.descriptors && xt.describe(e, t.descriptors)
            }(t, a, n), e.override && xt.override(t.id, t.overrides)), a
        }
        get(t) {
            return this.items[t]
        }
        unregister(t) {
            const e = this.items,
                i = t.id,
                n = this.scope;
            i in e && delete e[i], n && i in xt[n] && (delete xt[n][i], this.override && delete ft[i])
        }
    }
    var zn = new class {
        constructor() {
            this.controllers = new In(wn, "datasets", !0), this.elements = new In(Mn, "elements"), this.plugins = new In(Object, "plugins"), this.scales = new In(En, "scales"), this._typedRegistries = [this.controllers, this.scales, this.elements]
        }
        add(...t) {
            this._each("register", t)
        }
        remove(...t) {
            this._each("unregister", t)
        }
        addControllers(...t) {
            this._each("register", t, this.controllers)
        }
        addElements(...t) {
            this._each("register", t, this.elements)
        }
        addPlugins(...t) {
            this._each("register", t, this.plugins)
        }
        addScales(...t) {
            this._each("register", t, this.scales)
        }
        getController(t) {
            return this._get(t, this.controllers, "controller")
        }
        getElement(t) {
            return this._get(t, this.elements, "element")
        }
        getPlugin(t) {
            return this._get(t, this.plugins, "plugin")
        }
        getScale(t) {
            return this._get(t, this.scales, "scale")
        }
        removeControllers(...t) {
            this._each("unregister", t, this.controllers)
        }
        removeElements(...t) {
            this._each("unregister", t, this.elements)
        }
        removePlugins(...t) {
            this._each("unregister", t, this.plugins)
        }
        removeScales(...t) {
            this._each("unregister", t, this.scales)
        }
        _each(t, e, i) {
            const n = this;
            [...e].forEach((e => {
                const o = i || n._getRegistryForType(e);
                i || o.isForType(e) || o === n.plugins && e.id ? n._exec(t, o, e) : J(e, (e => {
                    const o = i || n._getRegistryForType(e);
                    n._exec(t, o, e)
                }))
            }))
        }
        _exec(t, e, i) {
            const n = ct(t);
            Q(i["before" + n], [], i), e[t](i), Q(i["after" + n], [], i)
        }
        _getRegistryForType(t) {
            for (let e = 0; e < this._typedRegistries.length; e++) {
                const i = this._typedRegistries[e];
                if (i.isForType(t)) return i
            }
            return this.plugins
        }
        _get(t, e, i) {
            const n = e.get(t);
            if (void 0 === n) throw new Error('"' + t + '" is not a registered ' + i + ".");
            return n
        }
    };
    class Fn {
        constructor() {
            this._init = []
        }
        notify(t, e, i, n) {
            const o = this;
            "beforeInit" === e && (o._init = o._createDescriptors(t, !0), o._notify(o._init, t, "install"));
            const s = n ? o._descriptors(t).filter(n) : o._descriptors(t),
                a = o._notify(s, t, e, i);
            return "destroy" === e && (o._notify(s, t, "stop"), o._notify(o._init, t, "uninstall")), a
        }
        _notify(t, e, i, n) {
            n = n || {};
            for (const o of t) {
                const t = o.plugin;
                if (!1 === Q(t[i], [e, n, o.options], t) && n.cancelable) return !1
            }
            return !0
        }
        invalidate() {
            $(this._cache) || (this._oldCache = this._cache, this._cache = void 0)
        }
        _descriptors(t) {
            if (this._cache) return this._cache;
            const e = this._cache = this._createDescriptors(t);
            return this._notifyStateChanges(t), e
        }
        _createDescriptors(t, e) {
            const i = t && t.config,
                n = K(i.options && i.options.plugins, {}),
                o = function(t) {
                    const e = [],
                        i = Object.keys(zn.plugins.items);
                    for (let t = 0; t < i.length; t++) e.push(zn.getPlugin(i[t]));
                    const n = t.plugins || [];
                    for (let t = 0; t < n.length; t++) {
                        const i = n[t]; - 1 === e.indexOf(i) && e.push(i)
                    }
                    return e
                }(i);
            return !1 !== n || e ? function(t, e, i, n) {
                const o = [],
                    s = t.getContext();
                for (let a = 0; a < e.length; a++) {
                    const r = e[a],
                        l = Bn(i[r.id], n);
                    null !== l && o.push({
                        plugin: r,
                        options: Vn(t.config, r, l, s)
                    })
                }
                return o
            }(t, o, n, e) : []
        }
        _notifyStateChanges(t) {
            const e = this._oldCache || [],
                i = this._cache,
                n = (t, e) => t.filter((t => !e.some((e => t.plugin.id === e.plugin.id))));
            this._notify(n(e, i), t, "stop"), this._notify(n(i, e), t, "start")
        }
    }

    function Bn(t, e) {
        return e || !1 !== t ? !0 === t ? {} : t : null
    }

    function Vn(t, e, i, n) {
        const o = t.pluginScopeKeys(e),
            s = t.getOptionScopes(i, o);
        return t.createResolver(s, n, [""], {
            scriptable: !1,
            indexable: !1,
            allKeys: !0
        })
    }

    function Wn(t, e) {
        const i = xt.datasets[t] || {};
        return ((e.datasets || {})[t] || {}).indexAxis || e.indexAxis || i.indexAxis || "x"
    }

    function Nn(t, e) {
        return "x" === t || "y" === t ? t : e.axis || ("top" === (i = e.position) || "bottom" === i ? "x" : "left" === i || "right" === i ? "y" : void 0) || t.charAt(0).toLowerCase();
        var i
    }

    function Hn(t) {
        const e = t.options || (t.options = {});
        e.plugins = K(e.plugins, {}), e.scales = function(t, e) {
            const i = ft[t.type] || {
                    scales: {}
                },
                n = e.scales || {},
                o = Wn(t.type, e),
                s = Object.create(null),
                a = Object.create(null);
            return Object.keys(n).forEach((t => {
                const e = n[t],
                    r = Nn(t, e),
                    l = function(t, e) {
                        return t === e ? "_index_" : "_value_"
                    }(r, o),
                    c = i.scales || {};
                s[r] = s[r] || t, a[t] = st(Object.create(null), [{
                    axis: r
                }, e, c[r], c[l]])
            })), t.data.datasets.forEach((i => {
                const o = i.type || t.type,
                    r = i.indexAxis || Wn(o, e),
                    l = (ft[o] || {}).scales || {};
                Object.keys(l).forEach((t => {
                    const e = function(t, e) {
                            let i = t;
                            return "_index_" === t ? i = e : "_value_" === t && (i = "x" === e ? "y" : "x"), i
                        }(t, r),
                        o = i[e + "AxisID"] || s[e] || e;
                    a[o] = a[o] || Object.create(null), st(a[o], [{
                        axis: e
                    }, n[o], l[t]])
                }))
            })), Object.keys(a).forEach((t => {
                const e = a[t];
                st(e, [xt.scales[e.type], xt.scale])
            })), a
        }(t, e)
    }

    function jn(t) {
        return (t = t || {}).datasets = t.datasets || [], t.labels = t.labels || [], t
    }
    const $n = new Map,
        Yn = new Set;

    function Un(t, e) {
        let i = $n.get(t);
        return i || (i = e(), $n.set(t, i), Yn.add(i)), i
    }
    const Xn = (t, e, i) => {
        const n = lt(e, i);
        void 0 !== n && t.add(n)
    };
    class qn {
        constructor(t) {
            this._config = function(t) {
                return (t = t || {}).data = jn(t.data), Hn(t), t
            }(t), this._scopeCache = new Map, this._resolverCache = new Map
        }
        get platform() {
            return this._config.platform
        }
        get type() {
            return this._config.type
        }
        set type(t) {
            this._config.type = t
        }
        get data() {
            return this._config.data
        }
        set data(t) {
            this._config.data = jn(t)
        }
        get options() {
            return this._config.options
        }
        set options(t) {
            this._config.options = t
        }
        get plugins() {
            return this._config.plugins
        }
        update() {
            const t = this._config;
            this.clearCache(), Hn(t)
        }
        clearCache() {
            this._scopeCache.clear(), this._resolverCache.clear()
        }
        datasetScopeKeys(t) {
            return Un(t, (() => [
                [`datasets.${t}`, ""]
            ]))
        }
        datasetAnimationScopeKeys(t, e) {
            return Un(`${t}.transition.${e}`, (() => [
                [`datasets.${t}.transitions.${e}`, `transitions.${e}`],
                [`datasets.${t}`, ""]
            ]))
        }
        datasetElementScopeKeys(t, e) {
            return Un(`${t}-${e}`, (() => [
                [`datasets.${t}.elements.${e}`, `datasets.${t}`, `elements.${e}`, ""]
            ]))
        }
        pluginScopeKeys(t) {
            const e = t.id;
            return Un(`${this.type}-plugin-${e}`, (() => [
                [`plugins.${e}`, ...t.additionalOptionScopes || []]
            ]))
        }
        _cachedScopes(t, e) {
            const i = this._scopeCache;
            let n = i.get(t);
            return n && !e || (n = new Map, i.set(t, n)), n
        }
        getOptionScopes(t, e, i) {
            const {
                options: n,
                type: o
            } = this, s = this._cachedScopes(t, i), a = s.get(e);
            if (a) return a;
            const r = new Set;
            e.forEach((e => {
                t && (r.add(t), e.forEach((e => Xn(r, t, e)))), e.forEach((t => Xn(r, n, t))), e.forEach((t => Xn(r, ft[o] || {}, t))), e.forEach((t => Xn(r, xt, t))), e.forEach((t => Xn(r, gt, t)))
            }));
            const l = Array.from(r);
            return 0 === l.length && l.push(Object.create(null)), Yn.has(e) && s.set(e, l), l
        }
        chartOptionScopes() {
            const {
                options: t,
                type: e
            } = this;
            return [t, ft[e] || {}, xt.datasets[e] || {}, {
                type: e
            }, xt, gt]
        }
        resolveNamedOptions(t, e, i, n = [""]) {
            const o = {
                    $shared: !0
                },
                {
                    resolver: s,
                    subPrefixes: a
                } = Kn(this._resolverCache, t, n);
            let r = s;
            if (function(t, e) {
                    const {
                        isScriptable: i,
                        isIndexable: n
                    } = ni(t);
                    for (const o of e)
                        if (i(o) && dt(t[o]) || n(o) && Y(t[o])) return !0;
                    return !1
                }(s, e)) {
                o.$shared = !1;
                r = ii(s, i = dt(i) ? i() : i, this.createResolver(t, i, a))
            }
            for (const t of e) o[t] = r[t];
            return o
        }
        createResolver(t, e, i = [""], n) {
            const {
                resolver: o
            } = Kn(this._resolverCache, t, i);
            return U(e) ? ii(o, e, void 0, n) : o
        }
    }

    function Kn(t, e, i) {
        let n = t.get(e);
        n || (n = new Map, t.set(e, n));
        const o = i.join();
        let s = n.get(o);
        if (!s) {
            s = {
                resolver: ei(e, i),
                subPrefixes: i.filter((t => !t.toLowerCase().includes("hover")))
            }, n.set(o, s)
        }
        return s
    }
    const Gn = ["top", "bottom", "left", "right", "chartArea"];

    function Zn(t, e) {
        return "top" === t || "bottom" === t || -1 === Gn.indexOf(t) && "x" === e
    }

    function Qn(t, e) {
        return function(i, n) {
            return i[t] === n[t] ? i[e] - n[e] : i[t] - n[t]
        }
    }

    function Jn(t) {
        const e = t.chart,
            i = e.options.animation;
        e.notifyPlugins("afterRender"), Q(i && i.onComplete, [t], e)
    }

    function to(t) {
        const e = t.chart,
            i = e.options.animation;
        Q(i && i.onProgress, [t], e)
    }

    function eo(t) {
        return ue() && "string" == typeof t ? t = document.getElementById(t) : t && t.length && (t = t[0]), t && t.canvas && (t = t.canvas), t
    }
    const io = {},
        no = t => {
            const e = eo(t);
            return Object.values(io).filter((t => t.canvas === e)).pop()
        };
    class oo {
        constructor(t, e) {
            const n = this,
                o = this.config = new qn(e),
                s = eo(t),
                r = no(s);
            if (r) throw new Error("Canvas is already in use. Chart with ID '" + r.id + "' must be destroyed before the canvas can be reused.");
            const l = o.createResolver(o.chartOptionScopes(), n.getContext());
            this.platform = new(o.platform || on(s));
            const c = n.platform.acquireContext(s, l.aspectRatio),
                h = c && c.canvas,
                d = h && h.height,
                u = h && h.width;
            this.id = j(), this.ctx = c, this.canvas = h, this.width = u, this.height = d, this._options = l, this._aspectRatio = this.aspectRatio, this._layers = [], this._metasets = [], this._stacks = void 0, this.boxes = [], this.currentDevicePixelRatio = void 0, this.chartArea = void 0, this._active = [], this._lastEvent = void 0, this._listeners = {}, this._responsiveListeners = void 0, this._sortedMetasets = [], this.scales = {}, this.scale = void 0, this._plugins = new Fn, this.$proxies = {}, this._hiddenIndices = {}, this.attached = !1, this._animationsDisabled = void 0, this.$context = void 0, this._doResize = i((() => this.update("resize")), l.resizeDelay || 0), io[n.id] = n, c && h ? (a.listen(n, "complete", Jn), a.listen(n, "progress", to), n._initialize(), n.attached && n.update()) : console.error("Failed to create chart: can't acquire context from the given item")
        }
        get aspectRatio() {
            const {
                options: {
                    aspectRatio: t,
                    maintainAspectRatio: e
                },
                width: i,
                height: n,
                _aspectRatio: o
            } = this;
            return $(t) ? e && o ? o : n ? i / n : null : t
        }
        get data() {
            return this.config.data
        }
        set data(t) {
            this.config.data = t
        }
        get options() {
            return this._options
        }
        set options(t) {
            this.config.options = t
        }
        _initialize() {
            const t = this;
            return t.notifyPlugins("beforeInit"), t.options.responsive ? t.resize() : we(t, t.options.devicePixelRatio), t.bindEvents(), t.notifyPlugins("afterInit"), t
        }
        clear() {
            return qt(this.canvas, this.ctx), this
        }
        stop() {
            return a.stop(this), this
        }
        resize(t, e) {
            a.running(this) ? this._resizeBeforeDraw = {
                width: t,
                height: e
            } : this._resize(t, e)
        }
        _resize(t, e) {
            const i = this,
                n = i.options,
                o = i.canvas,
                s = n.maintainAspectRatio && i.aspectRatio,
                a = i.platform.getMaximumSize(o, t, e, s),
                r = n.devicePixelRatio || i.platform.getDevicePixelRatio();
            i.width = a.width, i.height = a.height, i._aspectRatio = i.aspectRatio, we(i, r, !0) && (i.notifyPlugins("resize", {
                size: a
            }), Q(n.onResize, [i, a], i), i.attached && i._doResize() && i.render())
        }
        ensureScalesHaveIDs() {
            J(this.options.scales || {}, ((t, e) => {
                t.id = e
            }))
        }
        buildOrUpdateScales() {
            const t = this,
                e = t.options,
                i = e.scales,
                n = t.scales,
                o = Object.keys(n).reduce(((t, e) => (t[e] = !1, t)), {});
            let s = [];
            i && (s = s.concat(Object.keys(i).map((t => {
                const e = i[t],
                    n = Nn(t, e),
                    o = "r" === n,
                    s = "x" === n;
                return {
                    options: e,
                    dposition: o ? "chartArea" : s ? "bottom" : "left",
                    dtype: o ? "radialLinear" : s ? "category" : "linear"
                }
            })))), J(s, (i => {
                const s = i.options,
                    a = s.id,
                    r = Nn(a, s),
                    l = K(s.type, i.dtype);
                void 0 !== s.position && Zn(s.position, r) === Zn(i.dposition) || (s.position = i.dposition), o[a] = !0;
                let c = null;
                if (a in n && n[a].type === l) c = n[a];
                else {
                    c = new(zn.getScale(l))({
                        id: a,
                        type: l,
                        ctx: t.ctx,
                        chart: t
                    }), n[c.id] = c
                }
                c.init(s, e)
            })), J(o, ((t, e) => {
                t || delete n[e]
            })), J(n, (e => {
                ti.configure(t, e, e.options), ti.addBox(t, e)
            }))
        }
        _updateMetasets() {
            const t = this,
                e = t._metasets,
                i = t.data.datasets.length,
                n = e.length;
            if (e.sort(((t, e) => t.index - e.index)), n > i) {
                for (let e = i; e < n; ++e) t._destroyDatasetMeta(e);
                e.splice(i, n - i)
            }
            t._sortedMetasets = e.slice(0).sort(Qn("order", "index"))
        }
        _removeUnreferencedMetasets() {
            const t = this,
                {
                    _metasets: e,
                    data: {
                        datasets: i
                    }
                } = t;
            e.length > i.length && delete t._stacks, e.forEach(((e, n) => {
                0 === i.filter((t => t === e._dataset)).length && t._destroyDatasetMeta(n)
            }))
        }
        buildOrUpdateControllers() {
            const t = this,
                e = [],
                i = t.data.datasets;
            let n, o;
            for (t._removeUnreferencedMetasets(), n = 0, o = i.length; n < o; n++) {
                const o = i[n];
                let s = t.getDatasetMeta(n);
                const a = o.type || t.config.type;
                if (s.type && s.type !== a && (t._destroyDatasetMeta(n), s = t.getDatasetMeta(n)), s.type = a, s.indexAxis = o.indexAxis || Wn(a, t.options), s.order = o.order || 0, s.index = n, s.label = "" + o.label, s.visible = t.isDatasetVisible(n), s.controller) s.controller.updateIndex(n), s.controller.linkScales();
                else {
                    const i = zn.getController(a),
                        {
                            datasetElementType: o,
                            dataElementType: r
                        } = xt.datasets[a];
                    Object.assign(i.prototype, {
                        dataElementType: zn.getElement(r),
                        datasetElementType: o && zn.getElement(o)
                    }), s.controller = new i(t, n), e.push(s.controller)
                }
            }
            return t._updateMetasets(), e
        }
        _resetElements() {
            const t = this;
            J(t.data.datasets, ((e, i) => {
                t.getDatasetMeta(i).controller.reset()
            }), t)
        }
        reset() {
            this._resetElements(), this.notifyPlugins("reset")
        }
        update(t) {
            const e = this,
                i = e.config;
            i.update(), e._options = i.createResolver(i.chartOptionScopes(), e.getContext()), J(e.scales, (t => {
                ti.removeBox(e, t)
            }));
            const n = e._animationsDisabled = !e.options.animation;
            e.ensureScalesHaveIDs(), e.buildOrUpdateScales();
            const o = new Set(Object.keys(e._listeners)),
                s = new Set(e.options.events);
            if (ut(o, s) && !!this._responsiveListeners === e.options.responsive || (e.unbindEvents(), e.bindEvents()), e._plugins.invalidate(), !1 === e.notifyPlugins("beforeUpdate", {
                    mode: t,
                    cancelable: !0
                })) return;
            const a = e.buildOrUpdateControllers();
            e.notifyPlugins("beforeElementsUpdate");
            let r = 0;
            for (let t = 0, i = e.data.datasets.length; t < i; t++) {
                const {
                    controller: i
                } = e.getDatasetMeta(t), o = !n && -1 === a.indexOf(i);
                i.buildOrUpdateElements(o), r = Math.max(+i.getMaxOverflow(), r)
            }
            e._minPadding = r, e._updateLayout(r), n || J(a, (t => {
                t.reset()
            })), e._updateDatasets(t), e.notifyPlugins("afterUpdate", {
                mode: t
            }), e._layers.sort(Qn("z", "_idx")), e._lastEvent && e._eventHandler(e._lastEvent, !0), e.render()
        }
        _updateLayout(t) {
            const e = this;
            if (!1 === e.notifyPlugins("beforeLayout", {
                    cancelable: !0
                })) return;
            ti.update(e, e.width, e.height, t);
            const i = e.chartArea,
                n = i.width <= 0 || i.height <= 0;
            e._layers = [], J(e.boxes, (t => {
                n && "chartArea" === t.position || (t.configure && t.configure(), e._layers.push(...t._layers()))
            }), e), e._layers.forEach(((t, e) => {
                t._idx = e
            })), e.notifyPlugins("afterLayout")
        }
        _updateDatasets(t) {
            const e = this,
                i = "function" == typeof t;
            if (!1 !== e.notifyPlugins("beforeDatasetsUpdate", {
                    mode: t,
                    cancelable: !0
                })) {
                for (let n = 0, o = e.data.datasets.length; n < o; ++n) e._updateDataset(n, i ? t({
                    datasetIndex: n
                }) : t);
                e.notifyPlugins("afterDatasetsUpdate", {
                    mode: t
                })
            }
        }
        _updateDataset(t, e) {
            const i = this,
                n = i.getDatasetMeta(t),
                o = {
                    meta: n,
                    index: t,
                    mode: e,
                    cancelable: !0
                };
            !1 !== i.notifyPlugins("beforeDatasetUpdate", o) && (n.controller._update(e), o.cancelable = !1, i.notifyPlugins("afterDatasetUpdate", o))
        }
        render() {
            const t = this;
            !1 !== t.notifyPlugins("beforeRender", {
                cancelable: !0
            }) && (a.has(t) ? t.attached && !a.running(t) && a.start(t) : (t.draw(), Jn({
                chart: t
            })))
        }
        draw() {
            const t = this;
            let e;
            if (t._resizeBeforeDraw) {
                const {
                    width: e,
                    height: i
                } = t._resizeBeforeDraw;
                t._resize(e, i), t._resizeBeforeDraw = null
            }
            if (t.clear(), t.width <= 0 || t.height <= 0) return;
            if (!1 === t.notifyPlugins("beforeDraw", {
                    cancelable: !0
                })) return;
            const i = t._layers;
            for (e = 0; e < i.length && i[e].z <= 0; ++e) i[e].draw(t.chartArea);
            for (t._drawDatasets(); e < i.length; ++e) i[e].draw(t.chartArea);
            t.notifyPlugins("afterDraw")
        }
        _getSortedDatasetMetas(t) {
            const e = this._sortedMetasets,
                i = [];
            let n, o;
            for (n = 0, o = e.length; n < o; ++n) {
                const o = e[n];
                t && !o.visible || i.push(o)
            }
            return i
        }
        getSortedVisibleDatasetMetas() {
            return this._getSortedDatasetMetas(!0)
        }
        _drawDatasets() {
            const t = this;
            if (!1 === t.notifyPlugins("beforeDatasetsDraw", {
                    cancelable: !0
                })) return;
            const e = t.getSortedVisibleDatasetMetas();
            for (let i = e.length - 1; i >= 0; --i) t._drawDataset(e[i]);
            t.notifyPlugins("afterDatasetsDraw")
        }
        _drawDataset(t) {
            const e = this,
                i = e.ctx,
                n = t._clip,
                o = !n.disabled,
                s = e.chartArea,
                a = {
                    meta: t,
                    index: t.index,
                    cancelable: !0
                };
            !1 !== e.notifyPlugins("beforeDatasetDraw", a) && (o && Zt(i, {
                left: !1 === n.left ? 0 : s.left - n.left,
                right: !1 === n.right ? e.width : s.right + n.right,
                top: !1 === n.top ? 0 : s.top - n.top,
                bottom: !1 === n.bottom ? e.height : s.bottom + n.bottom
            }), t.controller.draw(), o && Qt(i), a.cancelable = !1, e.notifyPlugins("afterDatasetDraw", a))
        }
        getElementsAtEventForMode(t, e, i, n) {
            const o = Ae.modes[e];
            return "function" == typeof o ? o(this, t, i, n) : []
        }
        getDatasetMeta(t) {
            const e = this.data.datasets[t],
                i = this._metasets;
            let n = i.filter((t => t && t._dataset === e)).pop();
            return n || (n = {
                type: null,
                data: [],
                dataset: null,
                controller: null,
                hidden: null,
                xAxisID: null,
                yAxisID: null,
                order: e && e.order || 0,
                index: t,
                _dataset: e,
                _parsed: [],
                _sorted: !1
            }, i.push(n)), n
        }
        getContext() {
            return this.$context || (this.$context = {
                chart: this,
                type: "chart"
            })
        }
        getVisibleDatasetCount() {
            return this.getSortedVisibleDatasetMetas().length
        }
        isDatasetVisible(t) {
            const e = this.data.datasets[t];
            if (!e) return !1;
            const i = this.getDatasetMeta(t);
            return "boolean" == typeof i.hidden ? !i.hidden : !e.hidden
        }
        setDatasetVisibility(t, e) {
            this.getDatasetMeta(t).hidden = !e
        }
        toggleDataVisibility(t) {
            this._hiddenIndices[t] = !this._hiddenIndices[t]
        }
        getDataVisibility(t) {
            return !this._hiddenIndices[t]
        }
        _updateVisibility(t, e, i) {
            const n = this,
                o = i ? "show" : "hide",
                s = n.getDatasetMeta(t),
                a = s.controller._resolveAnimations(void 0, o);
            ht(e) ? (s.data[e].hidden = !i, n.update()) : (n.setDatasetVisibility(t, i), a.update(s, {
                visible: i
            }), n.update((e => e.datasetIndex === t ? o : void 0)))
        }
        hide(t, e) {
            this._updateVisibility(t, e, !1)
        }
        show(t, e) {
            this._updateVisibility(t, e, !0)
        }
        _destroyDatasetMeta(t) {
            const e = this,
                i = e._metasets && e._metasets[t];
            i && i.controller && (i.controller._destroy(), delete e._metasets[t])
        }
        destroy() {
            const t = this,
                {
                    canvas: e,
                    ctx: i
                } = t;
            let n, o;
            for (t.stop(), a.remove(t), n = 0, o = t.data.datasets.length; n < o; ++n) t._destroyDatasetMeta(n);
            t.config.clearCache(), e && (t.unbindEvents(), qt(e, i), t.platform.releaseContext(i), t.canvas = null, t.ctx = null), t.notifyPlugins("destroy"), delete io[t.id]
        }
        toBase64Image(...t) {
            return this.canvas.toDataURL(...t)
        }
        bindEvents() {
            this.bindUserEvents(), this.options.responsive ? this.bindResponsiveEvents() : this.attached = !0
        }
        bindUserEvents() {
            const t = this,
                e = t._listeners,
                i = t.platform,
                n = function(e, i, n) {
                    e.offsetX = i, e.offsetY = n, t._eventHandler(e)
                };
            J(t.options.events, (o => ((n, o) => {
                i.addEventListener(t, n, o), e[n] = o
            })(o, n)))
        }
        bindResponsiveEvents() {
            const t = this;
            t._responsiveListeners || (t._responsiveListeners = {});
            const e = t._responsiveListeners,
                i = t.platform,
                n = (n, o) => {
                    i.addEventListener(t, n, o), e[n] = o
                },
                o = (n, o) => {
                    e[n] && (i.removeEventListener(t, n, o), delete e[n])
                },
                s = (e, i) => {
                    t.canvas && t.resize(e, i)
                };
            let a;
            const r = () => {
                o("attach", r), t.attached = !0, t.resize(), n("resize", s), n("detach", a)
            };
            a = () => {
                t.attached = !1, o("resize", s), n("attach", r)
            }, i.isAttached(t.canvas) ? r() : a()
        }
        unbindEvents() {
            const t = this;
            J(t._listeners, ((e, i) => {
                t.platform.removeEventListener(t, i, e)
            })), t._listeners = {}, J(t._responsiveListeners, ((e, i) => {
                t.platform.removeEventListener(t, i, e)
            })), t._responsiveListeners = void 0
        }
        updateHoverStyle(t, e, i) {
            const n = i ? "set" : "remove";
            let o, s, a, r;
            for ("dataset" === e && (o = this.getDatasetMeta(t[0].datasetIndex), o.controller["_" + n + "DatasetHoverStyle"]()), a = 0, r = t.length; a < r; ++a) {
                s = t[a];
                const e = s && this.getDatasetMeta(s.datasetIndex).controller;
                e && e[n + "HoverStyle"](s.element, s.datasetIndex, s.index)
            }
        }
        getActiveElements() {
            return this._active || []
        }
        setActiveElements(t) {
            const e = this,
                i = e._active || [],
                n = t.map((({
                    datasetIndex: t,
                    index: i
                }) => {
                    const n = e.getDatasetMeta(t);
                    if (!n) throw new Error("No dataset found at index " + t);
                    return {
                        datasetIndex: t,
                        element: n.data[i],
                        index: i
                    }
                }));
            !tt(n, i) && (e._active = n, e._updateHoverStyles(n, i))
        }
        notifyPlugins(t, e, i) {
            return this._plugins.notify(this, t, e, i)
        }
        _updateHoverStyles(t, e, i) {
            const n = this,
                o = n.options.hover,
                s = (t, e) => t.filter((t => !e.some((e => t.datasetIndex === e.datasetIndex && t.index === e.index)))),
                a = s(e, t),
                r = i ? t : s(t, e);
            a.length && n.updateHoverStyle(a, o.mode, !1), r.length && o.mode && n.updateHoverStyle(r, o.mode, !0)
        }
        _eventHandler(t, e) {
            const i = this,
                n = {
                    event: t,
                    replay: e,
                    cancelable: !0
                },
                o = e => (e.options.events || this.options.events).includes(t.type);
            if (!1 === i.notifyPlugins("beforeEvent", n, o)) return;
            const s = i._handleEvent(t, e);
            return n.cancelable = !1, i.notifyPlugins("afterEvent", n, o), (s || n.changed) && i.render(), i
        }
        _handleEvent(t, e) {
            const i = this,
                {
                    _active: n = [],
                    options: o
                } = i,
                s = o.hover,
                a = e;
            let r = [],
                l = !1,
                c = null;
            return "mouseout" !== t.type && (r = i.getElementsAtEventForMode(t, s.mode, s, a), c = "click" === t.type ? i._lastEvent : t), i._lastEvent = null, Gt(t, i.chartArea, i._minPadding) && (Q(o.onHover, [t, r, i], i), "mouseup" !== t.type && "click" !== t.type && "contextmenu" !== t.type || Q(o.onClick, [t, r, i], i)), l = !tt(r, n), (l || e) && (i._active = r, i._updateHoverStyles(r, n, e)), i._lastEvent = c, l
        }
    }
    const so = () => J(oo.instances, (t => t._plugins.invalidate())),
        ao = !0;

    function ro() {
        throw new Error("This method is not implemented: Check that a complete date adapter is provided.")
    }
    Object.defineProperties(oo, {
        defaults: {
            enumerable: ao,
            value: xt
        },
        instances: {
            enumerable: ao,
            value: io
        },
        overrides: {
            enumerable: ao,
            value: ft
        },
        registry: {
            enumerable: ao,
            value: zn
        },
        version: {
            enumerable: ao,
            value: "3.5.0"
        },
        getChart: {
            enumerable: ao,
            value: no
        },
        register: {
            enumerable: ao,
            value: (...t) => {
                zn.add(...t), so()
            }
        },
        unregister: {
            enumerable: ao,
            value: (...t) => {
                zn.remove(...t), so()
            }
        }
    });
    class lo {
        constructor(t) {
            this.options = t || {}
        }
        formats() {
            return ro()
        }
        parse(t, e) {
            return ro()
        }
        format(t, e) {
            return ro()
        }
        add(t, e, i) {
            return ro()
        }
        diff(t, e, i) {
            return ro()
        }
        startOf(t, e, i) {
            return ro()
        }
        endOf(t, e) {
            return ro()
        }
    }
    lo.override = function(t) {
        Object.assign(lo.prototype, t)
    };
    var co = {
        _date: lo
    };

    function ho(t) {
        const e = function(t) {
            if (!t._cache.$bar) {
                const e = t.getMatchingVisibleMetas("bar");
                let i = [];
                for (let n = 0, o = e.length; n < o; n++) i = i.concat(e[n].controller.getAllParsedValues(t));
                t._cache.$bar = de(i.sort(((t, e) => t - e)))
            }
            return t._cache.$bar
        }(t);
        let i, n, o, s, a = t._length;
        const r = () => {
            32767 !== o && -32768 !== o && (ht(s) && (a = Math.min(a, Math.abs(o - s) || a)), s = o)
        };
        for (i = 0, n = e.length; i < n; ++i) o = t.getPixelForValue(e[i]), r();
        for (s = void 0, i = 0, n = t.ticks.length; i < n; ++i) o = t.getPixelForTick(i), r();
        return a
    }

    function uo(t, e, i, n) {
        return Y(t) ? function(t, e, i, n) {
            const o = i.parse(t[0], n),
                s = i.parse(t[1], n),
                a = Math.min(o, s),
                r = Math.max(o, s);
            let l = a,
                c = r;
            Math.abs(a) > Math.abs(r) && (l = r, c = a), e[i.axis] = c, e._custom = {
                barStart: l,
                barEnd: c,
                start: o,
                end: s,
                min: a,
                max: r
            }
        }(t, e, i, n) : e[i.axis] = i.parse(t, n), e
    }

    function fo(t, e, i, n) {
        const o = t.iScale,
            s = t.vScale,
            a = o.getLabels(),
            r = o === s,
            l = [];
        let c, h, d, u;
        for (c = i, h = i + n; c < h; ++c) u = e[c], d = {}, d[o.axis] = r || o.parse(a[c], c), l.push(uo(u, d, s, c));
        return l
    }

    function go(t) {
        return t && void 0 !== t.barStart && void 0 !== t.barEnd
    }

    function po(t, e, i, n) {
        let o = e.borderSkipped;
        const s = {};
        if (!o) return void(t.borderSkipped = s);
        const {
            start: a,
            end: r,
            reverse: l,
            top: c,
            bottom: h
        } = function(t) {
            let e, i, n, o, s;
            return t.horizontal ? (e = t.base > t.x, i = "left", n = "right") : (e = t.base < t.y, i = "bottom", n = "top"), e ? (o = "end", s = "start") : (o = "start", s = "end"), {
                start: i,
                end: n,
                reverse: e,
                top: o,
                bottom: s
            }
        }(t);
        "middle" === o && i && (t.enableBorderRadius = !0, (i._top || 0) === n ? o = c : (i._bottom || 0) === n ? o = h : (s[mo(h, a, r, l)] = !0, o = c)), s[mo(o, a, r, l)] = !0, t.borderSkipped = s
    }

    function mo(t, e, i, n) {
        var o, s, a;
        return n ? (a = i, t = xo(t = (o = t) === (s = e) ? a : o === a ? s : o, i, e)) : t = xo(t, e, i), t
    }

    function xo(t, e, i) {
        return "start" === t ? e : "end" === t ? i : t
    }
    class bo extends wn {
        parsePrimitiveData(t, e, i, n) {
            return fo(t, e, i, n)
        }
        parseArrayData(t, e, i, n) {
            return fo(t, e, i, n)
        }
        parseObjectData(t, e, i, n) {
            const {
                iScale: o,
                vScale: s
            } = t, {
                xAxisKey: a = "x",
                yAxisKey: r = "y"
            } = this._parsing, l = "x" === o.axis ? a : r, c = "x" === s.axis ? a : r, h = [];
            let d, u, f, g;
            for (d = i, u = i + n; d < u; ++d) g = e[d], f = {}, f[o.axis] = o.parse(lt(g, l), d), h.push(uo(lt(g, c), f, s, d));
            return h
        }
        updateRangeFromParsed(t, e, i, n) {
            super.updateRangeFromParsed(t, e, i, n);
            const o = i._custom;
            o && e === this._cachedMeta.vScale && (t.min = Math.min(t.min, o.min), t.max = Math.max(t.max, o.max))
        }
        getMaxOverflow() {
            return 0
        }
        getLabelAndValue(t) {
            const e = this._cachedMeta,
                {
                    iScale: i,
                    vScale: n
                } = e,
                o = this.getParsed(t),
                s = o._custom,
                a = go(s) ? "[" + s.start + ", " + s.end + "]" : "" + n.getLabelForValue(o[n.axis]);
            return {
                label: "" + i.getLabelForValue(o[i.axis]),
                value: a
            }
        }
        initialize() {
            const t = this;
            t.enableOptionSharing = !0, super.initialize();
            t._cachedMeta.stack = t.getDataset().stack
        }
        update(t) {
            const e = this._cachedMeta;
            this.updateElements(e.data, 0, e.data.length, t)
        }
        updateElements(t, e, i, n) {
            const o = this,
                s = "reset" === n,
                {
                    index: a,
                    _cachedMeta: {
                        vScale: r
                    }
                } = o,
                l = r.getBasePixel(),
                c = r.isHorizontal(),
                h = o._getRuler(),
                d = o.resolveDataElementOptions(e, n),
                u = o.getSharedOptions(d),
                f = o.includeOptions(n, u);
            o.updateSharedOptions(u, n, d);
            for (let d = e; d < e + i; d++) {
                const e = o.getParsed(d),
                    i = s || $(e[r.axis]) ? {
                        base: l,
                        head: l
                    } : o._calculateBarValuePixels(d),
                    g = o._calculateBarIndexPixels(d, h),
                    p = (e._stacks || {})[r.axis],
                    m = {
                        horizontal: c,
                        base: i.base,
                        enableBorderRadius: !p || go(e._custom) || a === p._top || a === p._bottom,
                        x: c ? i.head : g.center,
                        y: c ? g.center : i.head,
                        height: c ? g.size : Math.abs(i.size),
                        width: c ? Math.abs(i.size) : g.size
                    };
                f && (m.options = u || o.resolveDataElementOptions(d, t[d].active ? "active" : n)), po(m, m.options || t[d].options, p, a), o.updateElement(t[d], d, m, n)
            }
        }
        _getStacks(t, e) {
            const i = this._cachedMeta.iScale,
                n = i.getMatchingVisibleMetas(this._type),
                o = i.options.stacked,
                s = n.length,
                a = [];
            let r, l;
            for (r = 0; r < s; ++r)
                if (l = n[r], l.controller.options.grouped) {
                    if (void 0 !== e) {
                        const t = l.controller.getParsed(e)[l.controller._cachedMeta.vScale.axis];
                        if ($(t) || isNaN(t)) continue
                    }
                    if ((!1 === o || -1 === a.indexOf(l.stack) || void 0 === o && void 0 === l.stack) && a.push(l.stack), l.index === t) break
                } return a.length || a.push(void 0), a
        }
        _getStackCount(t) {
            return this._getStacks(void 0, t).length
        }
        _getStackIndex(t, e, i) {
            const n = this._getStacks(t, i),
                o = void 0 !== e ? n.indexOf(e) : -1;
            return -1 === o ? n.length - 1 : o
        }
        _getRuler() {
            const t = this,
                e = t.options,
                i = t._cachedMeta,
                n = i.iScale,
                o = [];
            let s, a;
            for (s = 0, a = i.data.length; s < a; ++s) o.push(n.getPixelForValue(t.getParsed(s)[n.axis], s));
            const r = e.barThickness;
            return {
                min: r || ho(n),
                pixels: o,
                start: n._startPixel,
                end: n._endPixel,
                stackCount: t._getStackCount(),
                scale: n,
                grouped: e.grouped,
                ratio: r ? 1 : e.categoryPercentage * e.barPercentage
            }
        }
        _calculateBarValuePixels(t) {
            const e = this,
                {
                    _cachedMeta: {
                        vScale: i,
                        _stacked: n
                    },
                    options: {
                        base: o,
                        minBarLength: s
                    }
                } = e,
                a = o || 0,
                r = e.getParsed(t),
                l = r._custom,
                c = go(l);
            let h, d, u = r[i.axis],
                f = 0,
                g = n ? e.applyStack(i, r, n) : u;
            g !== u && (f = g - u, g = u), c && (u = l.barStart, g = l.barEnd - l.barStart, 0 !== u && Dt(u) !== Dt(l.barEnd) && (f = 0), f += u);
            const p = $(o) || c ? f : o;
            let m = i.getPixelForValue(p);
            if (h = e.chart.getDataVisibility(t) ? i.getPixelForValue(f + g) : m, d = h - m, Math.abs(d) < s && (d = function(t, e, i) {
                    return 0 !== t ? Dt(t) : (e.isHorizontal() ? 1 : -1) * (e.min >= i ? 1 : -1)
                }(d, i, a) * s, u === a && (m -= d / 2), h = m + d), m === i.getPixelForValue(a)) {
                const t = Dt(d) * i.getLineWidthForValue(a) / 2;
                m += t, d -= t
            }
            return {
                size: d,
                base: m,
                head: h,
                center: h + d / 2
            }
        }
        _calculateBarIndexPixels(t, e) {
            const i = this,
                n = e.scale,
                o = i.options,
                s = o.skipNull,
                a = K(o.maxBarThickness, 1 / 0);
            let r, l;
            if (e.grouped) {
                const n = s ? i._getStackCount(t) : e.stackCount,
                    c = "flex" === o.barThickness ? function(t, e, i, n) {
                        const o = e.pixels,
                            s = o[t];
                        let a = t > 0 ? o[t - 1] : null,
                            r = t < o.length - 1 ? o[t + 1] : null;
                        const l = i.categoryPercentage;
                        null === a && (a = s - (null === r ? e.end - e.start : r - s)), null === r && (r = s + s - a);
                        const c = s - (s - Math.min(a, r)) / 2 * l;
                        return {
                            chunk: Math.abs(r - a) / 2 * l / n,
                            ratio: i.barPercentage,
                            start: c
                        }
                    }(t, e, o, n) : function(t, e, i, n) {
                        const o = i.barThickness;
                        let s, a;
                        return $(o) ? (s = e.min * i.categoryPercentage, a = i.barPercentage) : (s = o * n, a = 1), {
                            chunk: s / n,
                            ratio: a,
                            start: e.pixels[t] - s / 2
                        }
                    }(t, e, o, n),
                    h = i._getStackIndex(i.index, i._cachedMeta.stack, s ? t : void 0);
                r = c.start + c.chunk * h + c.chunk / 2, l = Math.min(a, c.chunk * c.ratio)
            } else r = n.getPixelForValue(i.getParsed(t)[n.axis], t), l = Math.min(a, e.min * e.ratio);
            return {
                base: r - l / 2,
                head: r + l / 2,
                center: r,
                size: l
            }
        }
        draw() {
            const t = this,
                e = t._cachedMeta,
                i = e.vScale,
                n = e.data,
                o = n.length;
            let s = 0;
            for (; s < o; ++s) null !== t.getParsed(s)[i.axis] && n[s].draw(t._ctx)
        }
    }
    bo.id = "bar", bo.defaults = {
        datasetElementType: !1,
        dataElementType: "bar",
        categoryPercentage: .8,
        barPercentage: .9,
        grouped: !0,
        animations: {
            numbers: {
                type: "number",
                properties: ["x", "y", "base", "width", "height"]
            }
        }
    }, bo.overrides = {
        interaction: {
            mode: "index"
        },
        scales: {
            _index_: {
                type: "category",
                offset: !0,
                grid: {
                    offset: !0
                }
            },
            _value_: {
                type: "linear",
                beginAtZero: !0
            }
        }
    };
    class _o extends wn {
        initialize() {
            this.enableOptionSharing = !0, super.initialize()
        }
        parseObjectData(t, e, i, n) {
            const {
                xScale: o,
                yScale: s
            } = t, {
                xAxisKey: a = "x",
                yAxisKey: r = "y"
            } = this._parsing, l = [];
            let c, h, d;
            for (c = i, h = i + n; c < h; ++c) d = e[c], l.push({
                x: o.parse(lt(d, a), c),
                y: s.parse(lt(d, r), c),
                _custom: d && d.r && +d.r
            });
            return l
        }
        getMaxOverflow() {
            const {
                data: t,
                _parsed: e
            } = this._cachedMeta;
            let i = 0;
            for (let n = t.length - 1; n >= 0; --n) i = Math.max(i, t[n].size() / 2, e[n]._custom);
            return i > 0 && i
        }
        getLabelAndValue(t) {
            const e = this._cachedMeta,
                {
                    xScale: i,
                    yScale: n
                } = e,
                o = this.getParsed(t),
                s = i.getLabelForValue(o.x),
                a = n.getLabelForValue(o.y),
                r = o._custom;
            return {
                label: e.label,
                value: "(" + s + ", " + a + (r ? ", " + r : "") + ")"
            }
        }
        update(t) {
            const e = this._cachedMeta.data;
            this.updateElements(e, 0, e.length, t)
        }
        updateElements(t, e, i, n) {
            const o = this,
                s = "reset" === n,
                {
                    iScale: a,
                    vScale: r
                } = o._cachedMeta,
                l = o.resolveDataElementOptions(e, n),
                c = o.getSharedOptions(l),
                h = o.includeOptions(n, c),
                d = a.axis,
                u = r.axis;
            for (let l = e; l < e + i; l++) {
                const e = t[l],
                    i = !s && o.getParsed(l),
                    c = {},
                    f = c[d] = s ? a.getPixelForDecimal(.5) : a.getPixelForValue(i[d]),
                    g = c[u] = s ? r.getBasePixel() : r.getPixelForValue(i[u]);
                c.skip = isNaN(f) || isNaN(g), h && (c.options = o.resolveDataElementOptions(l, e.active ? "active" : n), s && (c.options.radius = 0)), o.updateElement(e, l, c, n)
            }
            o.updateSharedOptions(c, n, l)
        }
        resolveDataElementOptions(t, e) {
            const i = this.getParsed(t);
            let n = super.resolveDataElementOptions(t, e);
            n.$shared && (n = Object.assign({}, n, {
                $shared: !1
            }));
            const o = n.radius;
            return "active" !== e && (n.radius = 0), n.radius += K(i && i._custom, o), n
        }
    }
    _o.id = "bubble", _o.defaults = {
        datasetElementType: !1,
        dataElementType: "point",
        animations: {
            numbers: {
                type: "number",
                properties: ["x", "y", "borderWidth", "radius"]
            }
        }
    }, _o.overrides = {
        scales: {
            x: {
                type: "linear"
            },
            y: {
                type: "linear"
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: () => ""
                }
            }
        }
    };
    class yo extends wn {
        constructor(t, e) {
            super(t, e), this.enableOptionSharing = !0, this.innerRadius = void 0, this.outerRadius = void 0, this.offsetX = void 0, this.offsetY = void 0
        }
        linkScales() {}
        parse(t, e) {
            const i = this.getDataset().data,
                n = this._cachedMeta;
            let o, s;
            for (o = t, s = t + e; o < s; ++o) n._parsed[o] = +i[o]
        }
        _getRotation() {
            return Et(this.options.rotation - 90)
        }
        _getCircumference() {
            return Et(this.options.circumference)
        }
        _getRotationExtents() {
            let t = _t,
                e = -_t;
            const i = this;
            for (let n = 0; n < i.chart.data.datasets.length; ++n)
                if (i.chart.isDatasetVisible(n)) {
                    const o = i.chart.getDatasetMeta(n).controller,
                        s = o._getRotation(),
                        a = o._getCircumference();
                    t = Math.min(t, s), e = Math.max(e, s + a)
                } return {
                rotation: t,
                circumference: e - t
            }
        }
        update(t) {
            const e = this,
                i = e.chart,
                {
                    chartArea: n
                } = i,
                o = e._cachedMeta,
                s = o.data,
                a = e.getMaxBorderWidth() + e.getMaxOffset(s) + e.options.spacing,
                r = Math.max((Math.min(n.width, n.height) - a) / 2, 0),
                l = Math.min(G(e.options.cutout, r), 1),
                c = e._getRingWeight(e.index),
                {
                    circumference: h,
                    rotation: d
                } = e._getRotationExtents(),
                {
                    ratioX: u,
                    ratioY: f,
                    offsetX: g,
                    offsetY: p
                } = function(t, e, i) {
                    let n = 1,
                        o = 1,
                        s = 0,
                        a = 0;
                    if (e < _t) {
                        const r = t,
                            l = r + e,
                            c = Math.cos(r),
                            h = Math.sin(r),
                            d = Math.cos(l),
                            u = Math.sin(l),
                            f = (t, e, n) => Nt(t, r, l, !0) ? 1 : Math.max(e, e * i, n, n * i),
                            g = (t, e, n) => Nt(t, r, l, !0) ? -1 : Math.min(e, e * i, n, n * i),
                            p = f(0, c, d),
                            m = f(Mt, h, u),
                            x = g(bt, c, d),
                            b = g(bt + Mt, h, u);
                        n = (p - x) / 2, o = (m - b) / 2, s = -(p + x) / 2, a = -(m + b) / 2
                    }
                    return {
                        ratioX: n,
                        ratioY: o,
                        offsetX: s,
                        offsetY: a
                    }
                }(d, h, l),
                m = (n.width - a) / u,
                x = (n.height - a) / f,
                b = Math.max(Math.min(m, x) / 2, 0),
                _ = Z(e.options.radius, b),
                y = (_ - Math.max(_ * l, 0)) / e._getVisibleDatasetWeightTotal();
            e.offsetX = g * _, e.offsetY = p * _, o.total = e.calculateTotal(), e.outerRadius = _ - y * e._getRingWeightOffset(e.index), e.innerRadius = Math.max(e.outerRadius - y * c, 0), e.updateElements(s, 0, s.length, t)
        }
        _circumference(t, e) {
            const i = this,
                n = i.options,
                o = i._cachedMeta,
                s = i._getCircumference();
            return e && n.animation.animateRotate || !this.chart.getDataVisibility(t) || null === o._parsed[t] || o.data[t].hidden ? 0 : i.calculateCircumference(o._parsed[t] * s / _t)
        }
        updateElements(t, e, i, n) {
            const o = this,
                s = "reset" === n,
                a = o.chart,
                r = a.chartArea,
                l = a.options.animation,
                c = (r.left + r.right) / 2,
                h = (r.top + r.bottom) / 2,
                d = s && l.animateScale,
                u = d ? 0 : o.innerRadius,
                f = d ? 0 : o.outerRadius,
                g = o.resolveDataElementOptions(e, n),
                p = o.getSharedOptions(g),
                m = o.includeOptions(n, p);
            let x, b = o._getRotation();
            for (x = 0; x < e; ++x) b += o._circumference(x, s);
            for (x = e; x < e + i; ++x) {
                const e = o._circumference(x, s),
                    i = t[x],
                    a = {
                        x: c + o.offsetX,
                        y: h + o.offsetY,
                        startAngle: b,
                        endAngle: b + e,
                        circumference: e,
                        outerRadius: f,
                        innerRadius: u
                    };
                m && (a.options = p || o.resolveDataElementOptions(x, i.active ? "active" : n)), b += e, o.updateElement(i, x, a, n)
            }
            o.updateSharedOptions(p, n, g)
        }
        calculateTotal() {
            const t = this._cachedMeta,
                e = t.data;
            let i, n = 0;
            for (i = 0; i < e.length; i++) {
                const o = t._parsed[i];
                null === o || isNaN(o) || !this.chart.getDataVisibility(i) || e[i].hidden || (n += Math.abs(o))
            }
            return n
        }
        calculateCircumference(t) {
            const e = this._cachedMeta.total;
            return e > 0 && !isNaN(t) ? _t * (Math.abs(t) / e) : 0
        }
        getLabelAndValue(t) {
            const e = this._cachedMeta,
                i = this.chart,
                n = i.data.labels || [],
                o = Oi(e._parsed[t], i.options.locale);
            return {
                label: n[t] || "",
                value: o
            }
        }
        getMaxBorderWidth(t) {
            const e = this;
            let i = 0;
            const n = e.chart;
            let o, s, a, r, l;
            if (!t)
                for (o = 0, s = n.data.datasets.length; o < s; ++o)
                    if (n.isDatasetVisible(o)) {
                        a = n.getDatasetMeta(o), t = a.data, r = a.controller, r !== e && r.configure();
                        break
                    } if (!t) return 0;
            for (o = 0, s = t.length; o < s; ++o) l = r.resolveDataElementOptions(o), "inner" !== l.borderAlign && (i = Math.max(i, l.borderWidth || 0, l.hoverBorderWidth || 0));
            return i
        }
        getMaxOffset(t) {
            let e = 0;
            for (let i = 0, n = t.length; i < n; ++i) {
                const t = this.resolveDataElementOptions(i);
                e = Math.max(e, t.offset || 0, t.hoverOffset || 0)
            }
            return e
        }
        _getRingWeightOffset(t) {
            let e = 0;
            for (let i = 0; i < t; ++i) this.chart.isDatasetVisible(i) && (e += this._getRingWeight(i));
            return e
        }
        _getRingWeight(t) {
            return Math.max(K(this.chart.data.datasets[t].weight, 1), 0)
        }
        _getVisibleDatasetWeightTotal() {
            return this._getRingWeightOffset(this.chart.data.datasets.length) || 1
        }
    }
    yo.id = "doughnut", yo.defaults = {
        datasetElementType: !1,
        dataElementType: "arc",
        animation: {
            animateRotate: !0,
            animateScale: !1
        },
        animations: {
            numbers: {
                type: "number",
                properties: ["circumference", "endAngle", "innerRadius", "outerRadius", "startAngle", "x", "y", "offset", "borderWidth", "spacing"]
            }
        },
        cutout: "50%",
        rotation: 0,
        circumference: 360,
        radius: "100%",
        spacing: 0,
        indexAxis: "r"
    }, yo.descriptors = {
        _scriptable: t => "spacing" !== t,
        _indexable: t => "spacing" !== t
    }, yo.overrides = {
        aspectRatio: 1,
        plugins: {
            legend: {
                labels: {
                    generateLabels(t) {
                        const e = t.data;
                        if (e.labels.length && e.datasets.length) {
                            const {
                                labels: {
                                    pointStyle: i
                                }
                            } = t.legend.options;
                            return e.labels.map(((e, n) => {
                                const o = t.getDatasetMeta(0).controller.getStyle(n);
                                return {
                                    text: e,
                                    fillStyle: o.backgroundColor,
                                    strokeStyle: o.borderColor,
                                    lineWidth: o.borderWidth,
                                    pointStyle: i,
                                    hidden: !t.getDataVisibility(n),
                                    index: n
                                }
                            }))
                        }
                        return []
                    }
                },
                onClick(t, e, i) {
                    i.chart.toggleDataVisibility(e.index), i.chart.update()
                }
            },
            tooltip: {
                callbacks: {
                    title: () => "",
                    label(t) {
                        let e = t.label;
                        const i = ": " + t.formattedValue;
                        return Y(e) ? (e = e.slice(), e[0] += i) : e += i, e
                    }
                }
            }
        }
    };
    class vo extends wn {
        initialize() {
            this.enableOptionSharing = !0, super.initialize()
        }
        update(t) {
            const e = this,
                i = e._cachedMeta,
                {
                    dataset: n,
                    data: o = [],
                    _dataset: s
                } = i,
                a = e.chart._animationsDisabled;
            let {
                start: r,
                count: l
            } = function(t, e, i) {
                const n = e.length;
                let o = 0,
                    s = n;
                if (t._sorted) {
                    const {
                        iScale: a,
                        _parsed: r
                    } = t, l = a.axis, {
                        min: c,
                        max: h,
                        minDefined: d,
                        maxDefined: u
                    } = a.getUserBounds();
                    d && (o = Ht(Math.min(se(r, a.axis, c).lo, i ? n : se(e, l, a.getPixelForValue(c)).lo), 0, n - 1)), s = u ? Ht(Math.max(se(r, a.axis, h).hi + 1, i ? 0 : se(e, l, a.getPixelForValue(h)).hi + 1), o, n) - o : n - o
                }
                return {
                    start: o,
                    count: s
                }
            }(i, o, a);
            e._drawStart = r, e._drawCount = l,
                function(t) {
                    const {
                        xScale: e,
                        yScale: i,
                        _scaleRanges: n
                    } = t, o = {
                        xmin: e.min,
                        xmax: e.max,
                        ymin: i.min,
                        ymax: i.max
                    };
                    if (!n) return t._scaleRanges = o, !0;
                    const s = n.xmin !== e.min || n.xmax !== e.max || n.ymin !== i.min || n.ymax !== i.max;
                    return Object.assign(n, o), s
                }(i) && (r = 0, l = o.length), n._datasetIndex = e.index, n._decimated = !!s._decimated, n.points = o;
            const c = e.resolveDatasetElementOptions(t);
            e.options.showLine || (c.borderWidth = 0), c.segment = e.options.segment, e.updateElement(n, void 0, {
                animated: !a,
                options: c
            }, t), e.updateElements(o, r, l, t)
        }
        updateElements(t, e, i, n) {
            const o = this,
                s = "reset" === n,
                {
                    iScale: a,
                    vScale: r,
                    _stacked: l
                } = o._cachedMeta,
                c = o.resolveDataElementOptions(e, n),
                h = o.getSharedOptions(c),
                d = o.includeOptions(n, h),
                u = a.axis,
                f = r.axis,
                g = o.options.spanGaps,
                p = Tt(g) ? g : Number.POSITIVE_INFINITY,
                m = o.chart._animationsDisabled || s || "none" === n;
            let x = e > 0 && o.getParsed(e - 1);
            for (let c = e; c < e + i; ++c) {
                const e = t[c],
                    i = o.getParsed(c),
                    g = m ? e : {},
                    b = $(i[f]),
                    _ = g[u] = a.getPixelForValue(i[u], c),
                    y = g[f] = s || b ? r.getBasePixel() : r.getPixelForValue(l ? o.applyStack(r, i, l) : i[f], c);
                g.skip = isNaN(_) || isNaN(y) || b, g.stop = c > 0 && i[u] - x[u] > p, g.parsed = i, d && (g.options = h || o.resolveDataElementOptions(c, e.active ? "active" : n)), m || o.updateElement(e, c, g, n), x = i
            }
            o.updateSharedOptions(h, n, c)
        }
        getMaxOverflow() {
            const t = this,
                e = t._cachedMeta,
                i = e.dataset,
                n = i.options && i.options.borderWidth || 0,
                o = e.data || [];
            if (!o.length) return n;
            const s = o[0].size(t.resolveDataElementOptions(0)),
                a = o[o.length - 1].size(t.resolveDataElementOptions(o.length - 1));
            return Math.max(n, s, a) / 2
        }
        draw() {
            const t = this._cachedMeta;
            t.dataset.updateControlPoints(this.chart.chartArea, t.iScale.axis), super.draw()
        }
    }
    vo.id = "line", vo.defaults = {
        datasetElementType: "line",
        dataElementType: "point",
        showLine: !0,
        spanGaps: !1
    }, vo.overrides = {
        scales: {
            _index_: {
                type: "category"
            },
            _value_: {
                type: "linear"
            }
        }
    };
    class wo extends wn {
        constructor(t, e) {
            super(t, e), this.innerRadius = void 0, this.outerRadius = void 0
        }
        getLabelAndValue(t) {
            const e = this._cachedMeta,
                i = this.chart,
                n = i.data.labels || [],
                o = Oi(e._parsed[t].r, i.options.locale);
            return {
                label: n[t] || "",
                value: o
            }
        }
        update(t) {
            const e = this._cachedMeta.data;
            this._updateRadius(), this.updateElements(e, 0, e.length, t)
        }
        _updateRadius() {
            const t = this,
                e = t.chart,
                i = e.chartArea,
                n = e.options,
                o = Math.min(i.right - i.left, i.bottom - i.top),
                s = Math.max(o / 2, 0),
                a = (s - Math.max(n.cutoutPercentage ? s / 100 * n.cutoutPercentage : 1, 0)) / e.getVisibleDatasetCount();
            t.outerRadius = s - a * t.index, t.innerRadius = t.outerRadius - a
        }
        updateElements(t, e, i, n) {
            const o = this,
                s = "reset" === n,
                a = o.chart,
                r = o.getDataset(),
                l = a.options.animation,
                c = o._cachedMeta.rScale,
                h = c.xCenter,
                d = c.yCenter,
                u = c.getIndexAngle(0) - .5 * bt;
            let f, g = u;
            const p = 360 / o.countVisibleElements();
            for (f = 0; f < e; ++f) g += o._computeAngle(f, n, p);
            for (f = e; f < e + i; f++) {
                const e = t[f];
                let i = g,
                    m = g + o._computeAngle(f, n, p),
                    x = a.getDataVisibility(f) ? c.getDistanceFromCenterForValue(r.data[f]) : 0;
                g = m, s && (l.animateScale && (x = 0), l.animateRotate && (i = m = u));
                const b = {
                    x: h,
                    y: d,
                    innerRadius: 0,
                    outerRadius: x,
                    startAngle: i,
                    endAngle: m,
                    options: o.resolveDataElementOptions(f, e.active ? "active" : n)
                };
                o.updateElement(e, f, b, n)
            }
        }
        countVisibleElements() {
            const t = this.getDataset(),
                e = this._cachedMeta;
            let i = 0;
            return e.data.forEach(((e, n) => {
                !isNaN(t.data[n]) && this.chart.getDataVisibility(n) && i++
            })), i
        }
        _computeAngle(t, e, i) {
            return this.chart.getDataVisibility(t) ? Et(this.resolveDataElementOptions(t, e).angle || i) : 0
        }
    }
    wo.id = "polarArea", wo.defaults = {
        dataElementType: "arc",
        animation: {
            animateRotate: !0,
            animateScale: !0
        },
        animations: {
            numbers: {
                type: "number",
                properties: ["x", "y", "startAngle", "endAngle", "innerRadius", "outerRadius"]
            }
        },
        indexAxis: "r",
        startAngle: 0
    }, wo.overrides = {
        aspectRatio: 1,
        plugins: {
            legend: {
                labels: {
                    generateLabels(t) {
                        const e = t.data;
                        if (e.labels.length && e.datasets.length) {
                            const {
                                labels: {
                                    pointStyle: i
                                }
                            } = t.legend.options;
                            return e.labels.map(((e, n) => {
                                const o = t.getDatasetMeta(0).controller.getStyle(n);
                                return {
                                    text: e,
                                    fillStyle: o.backgroundColor,
                                    strokeStyle: o.borderColor,
                                    lineWidth: o.borderWidth,
                                    pointStyle: i,
                                    hidden: !t.getDataVisibility(n),
                                    index: n
                                }
                            }))
                        }
                        return []
                    }
                },
                onClick(t, e, i) {
                    i.chart.toggleDataVisibility(e.index), i.chart.update()
                }
            },
            tooltip: {
                callbacks: {
                    title: () => "",
                    label: t => t.chart.data.labels[t.dataIndex] + ": " + t.formattedValue
                }
            }
        },
        scales: {
            r: {
                type: "radialLinear",
                angleLines: {
                    display: !1
                },
                beginAtZero: !0,
                grid: {
                    circular: !0
                },
                pointLabels: {
                    display: !1
                },
                startAngle: 0
            }
        }
    };
    class Mo extends yo {}
    Mo.id = "pie", Mo.defaults = {
        cutout: 0,
        rotation: 0,
        circumference: 360,
        radius: "100%"
    };
    class ko extends wn {
        getLabelAndValue(t) {
            const e = this._cachedMeta.vScale,
                i = this.getParsed(t);
            return {
                label: e.getLabels()[t],
                value: "" + e.getLabelForValue(i[e.axis])
            }
        }
        update(t) {
            const e = this,
                i = e._cachedMeta,
                n = i.dataset,
                o = i.data || [],
                s = i.iScale.getLabels();
            if (n.points = o, "resize" !== t) {
                const i = e.resolveDatasetElementOptions(t);
                e.options.showLine || (i.borderWidth = 0);
                const a = {
                    _loop: !0,
                    _fullLoop: s.length === o.length,
                    options: i
                };
                e.updateElement(n, void 0, a, t)
            }
            e.updateElements(o, 0, o.length, t)
        }
        updateElements(t, e, i, n) {
            const o = this,
                s = o.getDataset(),
                a = o._cachedMeta.rScale,
                r = "reset" === n;
            for (let l = e; l < e + i; l++) {
                const e = t[l],
                    i = o.resolveDataElementOptions(l, e.active ? "active" : n),
                    c = a.getPointPositionForValue(l, s.data[l]),
                    h = r ? a.xCenter : c.x,
                    d = r ? a.yCenter : c.y,
                    u = {
                        x: h,
                        y: d,
                        angle: c.angle,
                        skip: isNaN(h) || isNaN(d),
                        options: i
                    };
                o.updateElement(e, l, u, n)
            }
        }
    }
    ko.id = "radar", ko.defaults = {
        datasetElementType: "line",
        dataElementType: "point",
        indexAxis: "r",
        showLine: !0,
        elements: {
            line: {
                fill: "start"
            }
        }
    }, ko.overrides = {
        aspectRatio: 1,
        scales: {
            r: {
                type: "radialLinear"
            }
        }
    };
    class So extends vo {}
    So.id = "scatter", So.defaults = {
        showLine: !1,
        fill: !1
    }, So.overrides = {
        interaction: {
            mode: "point"
        },
        plugins: {
            tooltip: {
                callbacks: {
                    title: () => "",
                    label: t => "(" + t.label + ", " + t.formattedValue + ")"
                }
            }
        },
        scales: {
            x: {
                type: "linear"
            },
            y: {
                type: "linear"
            }
        }
    };
    var Po = Object.freeze({
        __proto__: null,
        BarController: bo,
        BubbleController: _o,
        DoughnutController: yo,
        LineController: vo,
        PolarAreaController: wo,
        PieController: Mo,
        RadarController: ko,
        ScatterController: So
    });

    function Do(t, e, i) {
        const {
            startAngle: n,
            pixelMargin: o,
            x: s,
            y: a,
            outerRadius: r,
            innerRadius: l
        } = e;
        let c = o / r;
        t.beginPath(), t.arc(s, a, r, n - c, i + c), l > o ? (c = o / l, t.arc(s, a, l, i + c, n - c, !0)) : t.arc(s, a, o, i + Mt, n - Mt), t.closePath(), t.clip()
    }

    function Co(t, e, i, n) {
        const o = Ie(t.options.borderRadius, ["outerStart", "outerEnd", "innerStart", "innerEnd"]);
        const s = (i - e) / 2,
            a = Math.min(s, n * e / 2),
            r = t => {
                const e = (i - Math.min(s, t)) * n / 2;
                return Ht(t, 0, Math.min(s, e))
            };
        return {
            outerStart: r(o.outerStart),
            outerEnd: r(o.outerEnd),
            innerStart: Ht(o.innerStart, 0, a),
            innerEnd: Ht(o.innerEnd, 0, a)
        }
    }

    function Oo(t, e, i, n) {
        return {
            x: i + t * Math.cos(e),
            y: n + t * Math.sin(e)
        }
    }

    function To(t, e, i, n, o) {
        const {
            x: s,
            y: a,
            startAngle: r,
            pixelMargin: l,
            innerRadius: c
        } = e, h = Math.max(e.outerRadius + n + i - l, 0), d = c > 0 ? c + n + i + l : 0;
        let u = 0;
        const f = o - r;
        if (n) {
            const t = ((c > 0 ? c - n : 0) + (h > 0 ? h - n : 0)) / 2;
            u = (f - (0 !== t ? f * t / (t + n) : f)) / 2
        }
        const g = (f - Math.max(.001, f * h - i / bt) / h) / 2,
            p = r + g + u,
            m = o - g - u,
            {
                outerStart: x,
                outerEnd: b,
                innerStart: _,
                innerEnd: y
            } = Co(e, d, h, m - p),
            v = h - x,
            w = h - b,
            M = p + x / v,
            k = m - b / w,
            S = d + _,
            P = d + y,
            D = p + _ / S,
            C = m - y / P;
        if (t.beginPath(), t.arc(s, a, h, M, k), b > 0) {
            const e = Oo(w, k, s, a);
            t.arc(e.x, e.y, b, k, m + Mt)
        }
        const O = Oo(P, m, s, a);
        if (t.lineTo(O.x, O.y), y > 0) {
            const e = Oo(P, C, s, a);
            t.arc(e.x, e.y, y, m + Mt, C + Math.PI)
        }
        if (t.arc(s, a, d, m - y / d, p + _ / d, !0), _ > 0) {
            const e = Oo(S, D, s, a);
            t.arc(e.x, e.y, _, D + Math.PI, p - Mt)
        }
        const T = Oo(v, p, s, a);
        if (t.lineTo(T.x, T.y), x > 0) {
            const e = Oo(v, M, s, a);
            t.arc(e.x, e.y, x, p - Mt, M)
        }
        t.closePath()
    }

    function Ao(t, e, i, n, o) {
        const {
            options: s
        } = e, a = "inner" === s.borderAlign;
        s.borderWidth && (a ? (t.lineWidth = 2 * s.borderWidth, t.lineJoin = "round") : (t.lineWidth = s.borderWidth, t.lineJoin = "bevel"), e.fullCircles && function(t, e, i) {
            const {
                x: n,
                y: o,
                startAngle: s,
                pixelMargin: a,
                fullCircles: r
            } = e, l = Math.max(e.outerRadius - a, 0), c = e.innerRadius + a;
            let h;
            for (i && Do(t, e, s + _t), t.beginPath(), t.arc(n, o, c, s + _t, s, !0), h = 0; h < r; ++h) t.stroke();
            for (t.beginPath(), t.arc(n, o, l, s, s + _t), h = 0; h < r; ++h) t.stroke()
        }(t, e, a), a && Do(t, e, o), To(t, e, i, n, o), t.stroke())
    }
    class Lo extends Mn {
        constructor(t) {
            super(), this.options = void 0, this.circumference = void 0, this.startAngle = void 0, this.endAngle = void 0, this.innerRadius = void 0, this.outerRadius = void 0, this.pixelMargin = 0, this.fullCircles = 0, t && Object.assign(this, t)
        }
        inRange(t, e, i) {
            const n = this.getProps(["x", "y"], i),
                {
                    angle: o,
                    distance: s
                } = Ft(n, {
                    x: t,
                    y: e
                }),
                {
                    startAngle: a,
                    endAngle: r,
                    innerRadius: l,
                    outerRadius: c,
                    circumference: h
                } = this.getProps(["startAngle", "endAngle", "innerRadius", "outerRadius", "circumference"], i),
                d = this.options.spacing / 2;
            return (h >= _t || Nt(o, a, r)) && (s >= l + d && s <= c + d)
        }
        getCenterPoint(t) {
            const {
                x: e,
                y: i,
                startAngle: n,
                endAngle: o,
                innerRadius: s,
                outerRadius: a
            } = this.getProps(["x", "y", "startAngle", "endAngle", "innerRadius", "outerRadius", "circumference"], t), {
                offset: r,
                spacing: l
            } = this.options, c = (n + o) / 2, h = (s + a + l + r) / 2;
            return {
                x: e + Math.cos(c) * h,
                y: i + Math.sin(c) * h
            }
        }
        tooltipPosition(t) {
            return this.getCenterPoint(t)
        }
        draw(t) {
            const e = this,
                {
                    options: i,
                    circumference: n
                } = e,
                o = (i.offset || 0) / 2,
                s = (i.spacing || 0) / 2;
            if (e.pixelMargin = "inner" === i.borderAlign ? .33 : 0, e.fullCircles = n > _t ? Math.floor(n / _t) : 0, 0 === n || e.innerRadius < 0 || e.outerRadius < 0) return;
            t.save();
            let a = 0;
            if (o) {
                a = o / 2;
                const i = (e.startAngle + e.endAngle) / 2;
                t.translate(Math.cos(i) * a, Math.sin(i) * a), e.circumference >= bt && (a = o)
            }
            t.fillStyle = i.backgroundColor, t.strokeStyle = i.borderColor;
            const r = function(t, e, i, n) {
                const {
                    fullCircles: o,
                    startAngle: s,
                    circumference: a
                } = e;
                let r = e.endAngle;
                if (o) {
                    To(t, e, i, n, s + _t);
                    for (let e = 0; e < o; ++e) t.fill();
                    isNaN(a) || (r = s + a % _t, a % _t == 0 && (r += _t))
                }
                return To(t, e, i, n, r), t.fill(), r
            }(t, e, a, s);
            Ao(t, e, a, s, r), t.restore()
        }
    }

    function Ro(t, e, i = e) {
        t.lineCap = K(i.borderCapStyle, e.borderCapStyle), t.setLineDash(K(i.borderDash, e.borderDash)), t.lineDashOffset = K(i.borderDashOffset, e.borderDashOffset), t.lineJoin = K(i.borderJoinStyle, e.borderJoinStyle), t.lineWidth = K(i.borderWidth, e.borderWidth), t.strokeStyle = K(i.borderColor, e.borderColor)
    }

    function Eo(t, e, i) {
        t.lineTo(i.x, i.y)
    }

    function Io(t, e, i = {}) {
        const n = t.length,
            {
                start: o = 0,
                end: s = n - 1
            } = i,
            {
                start: a,
                end: r
            } = e,
            l = Math.max(o, a),
            c = Math.min(s, r),
            h = o < a && s < a || o > r && s > r;
        return {
            count: n,
            start: l,
            loop: e.loop,
            ilen: c < l && !h ? n + c - l : c - l
        }
    }

    function zo(t, e, i, n) {
        const {
            points: o,
            options: s
        } = e, {
            count: a,
            start: r,
            loop: l,
            ilen: c
        } = Io(o, i, n), h = function(t) {
            return t.stepped ? Jt : t.tension || "monotone" === t.cubicInterpolationMode ? te : Eo
        }(s);
        let d, u, f, {
            move: g = !0,
            reverse: p
        } = n || {};
        for (d = 0; d <= c; ++d) u = o[(r + (p ? c - d : d)) % a], u.skip || (g ? (t.moveTo(u.x, u.y), g = !1) : h(t, f, u, p, s.stepped), f = u);
        return l && (u = o[(r + (p ? c : 0)) % a], h(t, f, u, p, s.stepped)), !!l
    }

    function Fo(t, e, i, n) {
        const o = e.points,
            {
                count: s,
                start: a,
                ilen: r
            } = Io(o, i, n),
            {
                move: l = !0,
                reverse: c
            } = n || {};
        let h, d, u, f, g, p, m = 0,
            x = 0;
        const b = t => (a + (c ? r - t : t)) % s,
            _ = () => {
                f !== g && (t.lineTo(m, g), t.lineTo(m, f), t.lineTo(m, p))
            };
        for (l && (d = o[b(0)], t.moveTo(d.x, d.y)), h = 0; h <= r; ++h) {
            if (d = o[b(h)], d.skip) continue;
            const e = d.x,
                i = d.y,
                n = 0 | e;
            n === u ? (i < f ? f = i : i > g && (g = i), m = (x * m + e) / ++x) : (_(), t.lineTo(e, i), u = n, x = 0, f = g = i), p = i
        }
        _()
    }

    function Bo(t) {
        const e = t.options,
            i = e.borderDash && e.borderDash.length;
        return !(t._decimated || t._loop || e.tension || "monotone" === e.cubicInterpolationMode || e.stepped || i) ? Fo : zo
    }
    Lo.id = "arc", Lo.defaults = {
        borderAlign: "center",
        borderColor: "#fff",
        borderRadius: 0,
        borderWidth: 2,
        offset: 0,
        spacing: 0,
        angle: void 0
    }, Lo.defaultRoutes = {
        backgroundColor: "backgroundColor"
    };
    const Vo = "function" == typeof Path2D;

    function Wo(t, e, i, n) {
        Vo && 1 === e.segments.length ? function(t, e, i, n) {
            let o = e._path;
            o || (o = e._path = new Path2D, e.path(o, i, n) && o.closePath()), Ro(t, e.options), t.stroke(o)
        }(t, e, i, n) : function(t, e, i, n) {
            const {
                segments: o,
                options: s
            } = e, a = Bo(e);
            for (const r of o) Ro(t, s, r.style), t.beginPath(), a(t, e, r, {
                start: i,
                end: i + n - 1
            }) && t.closePath(), t.stroke()
        }(t, e, i, n)
    }
    class No extends Mn {
        constructor(t) {
            super(), this.animated = !0, this.options = void 0, this._loop = void 0, this._fullLoop = void 0, this._path = void 0, this._points = void 0, this._segments = void 0, this._decimated = !1, this._pointsUpdated = !1, this._datasetIndex = void 0, t && Object.assign(this, t)
        }
        updateControlPoints(t, e) {
            const i = this,
                n = i.options;
            if ((n.tension || "monotone" === n.cubicInterpolationMode) && !n.stepped && !i._pointsUpdated) {
                const o = n.spanGaps ? i._loop : i._fullLoop;
                yi(i._points, n, t, o, e), i._pointsUpdated = !0
            }
        }
        set points(t) {
            const e = this;
            e._points = t, delete e._segments, delete e._path, e._pointsUpdated = !1
        }
        get points() {
            return this._points
        }
        get segments() {
            return this._segments || (this._segments = Fi(this, this.options.segment))
        }
        first() {
            const t = this.segments,
                e = this.points;
            return t.length && e[t[0].start]
        }
        last() {
            const t = this.segments,
                e = this.points,
                i = t.length;
            return i && e[t[i - 1].end]
        }
        interpolate(t, e) {
            const i = this,
                n = i.options,
                o = t[e],
                s = i.points,
                a = zi(i, {
                    property: e,
                    start: o,
                    end: o
                });
            if (!a.length) return;
            const r = [],
                l = function(t) {
                    return t.stepped ? Pi : t.tension || "monotone" === t.cubicInterpolationMode ? Di : Si
                }(n);
            let c, h;
            for (c = 0, h = a.length; c < h; ++c) {
                const {
                    start: i,
                    end: h
                } = a[c], d = s[i], u = s[h];
                if (d === u) {
                    r.push(d);
                    continue
                }
                const f = l(d, u, Math.abs((o - d[e]) / (u[e] - d[e])), n.stepped);
                f[e] = t[e], r.push(f)
            }
            return 1 === r.length ? r[0] : r
        }
        pathSegment(t, e, i) {
            return Bo(this)(t, this, e, i)
        }
        path(t, e, i) {
            const n = this,
                o = n.segments,
                s = Bo(n);
            let a = n._loop;
            e = e || 0, i = i || n.points.length - e;
            for (const r of o) a &= s(t, n, r, {
                start: e,
                end: e + i - 1
            });
            return !!a
        }
        draw(t, e, i, n) {
            const o = this,
                s = o.options || {};
            (o.points || []).length && s.borderWidth && (t.save(), Wo(t, o, i, n), t.restore(), o.animated && (o._pointsUpdated = !1, o._path = void 0))
        }
    }

    function Ho(t, e, i, n) {
        const o = t.options,
            {
                [i]: s
            } = t.getProps([i], n);
        return Math.abs(e - s) < o.radius + o.hitRadius
    }
    No.id = "line", No.defaults = {
        borderCapStyle: "butt",
        borderDash: [],
        borderDashOffset: 0,
        borderJoinStyle: "miter",
        borderWidth: 3,
        capBezierPoints: !0,
        cubicInterpolationMode: "default",
        fill: !1,
        spanGaps: !1,
        stepped: !1,
        tension: 0
    }, No.defaultRoutes = {
        backgroundColor: "backgroundColor",
        borderColor: "borderColor"
    }, No.descriptors = {
        _scriptable: !0,
        _indexable: t => "borderDash" !== t && "fill" !== t
    };
    class jo extends Mn {
        constructor(t) {
            super(), this.options = void 0, this.parsed = void 0, this.skip = void 0, this.stop = void 0, t && Object.assign(this, t)
        }
        inRange(t, e, i) {
            const n = this.options,
                {
                    x: o,
                    y: s
                } = this.getProps(["x", "y"], i);
            return Math.pow(t - o, 2) + Math.pow(e - s, 2) < Math.pow(n.hitRadius + n.radius, 2)
        }
        inXRange(t, e) {
            return Ho(this, t, "x", e)
        }
        inYRange(t, e) {
            return Ho(this, t, "y", e)
        }
        getCenterPoint(t) {
            const {
                x: e,
                y: i
            } = this.getProps(["x", "y"], t);
            return {
                x: e,
                y: i
            }
        }
        size(t) {
            let e = (t = t || this.options || {}).radius || 0;
            e = Math.max(e, e && t.hoverRadius || 0);
            return 2 * (e + (e && t.borderWidth || 0))
        }
        draw(t, e) {
            const i = this,
                n = i.options;
            i.skip || n.radius < .1 || !Gt(i, e, i.size(n) / 2) || (t.strokeStyle = n.borderColor, t.lineWidth = n.borderWidth, t.fillStyle = n.backgroundColor, Kt(t, n, i.x, i.y))
        }
        getRange() {
            const t = this.options || {};
            return t.radius + t.hitRadius
        }
    }

    function $o(t, e) {
        const {
            x: i,
            y: n,
            base: o,
            width: s,
            height: a
        } = t.getProps(["x", "y", "base", "width", "height"], e);
        let r, l, c, h, d;
        return t.horizontal ? (d = a / 2, r = Math.min(i, o), l = Math.max(i, o), c = n - d, h = n + d) : (d = s / 2, r = i - d, l = i + d, c = Math.min(n, o), h = Math.max(n, o)), {
            left: r,
            top: c,
            right: l,
            bottom: h
        }
    }

    function Yo(t, e, i, n) {
        return t ? 0 : Ht(e, i, n)
    }

    function Uo(t) {
        const e = $o(t),
            i = e.right - e.left,
            n = e.bottom - e.top,
            o = function(t, e, i) {
                const n = t.options.borderWidth,
                    o = t.borderSkipped,
                    s = ze(n);
                return {
                    t: Yo(o.top, s.top, 0, i),
                    r: Yo(o.right, s.right, 0, e),
                    b: Yo(o.bottom, s.bottom, 0, i),
                    l: Yo(o.left, s.left, 0, e)
                }
            }(t, i / 2, n / 2),
            s = function(t, e, i) {
                const {
                    enableBorderRadius: n
                } = t.getProps(["enableBorderRadius"]), o = t.options.borderRadius, s = Fe(o), a = Math.min(e, i), r = t.borderSkipped, l = n || U(o);
                return {
                    topLeft: Yo(!l || r.top || r.left, s.topLeft, 0, a),
                    topRight: Yo(!l || r.top || r.right, s.topRight, 0, a),
                    bottomLeft: Yo(!l || r.bottom || r.left, s.bottomLeft, 0, a),
                    bottomRight: Yo(!l || r.bottom || r.right, s.bottomRight, 0, a)
                }
            }(t, i / 2, n / 2);
        return {
            outer: {
                x: e.left,
                y: e.top,
                w: i,
                h: n,
                radius: s
            },
            inner: {
                x: e.left + o.l,
                y: e.top + o.t,
                w: i - o.l - o.r,
                h: n - o.t - o.b,
                radius: {
                    topLeft: Math.max(0, s.topLeft - Math.max(o.t, o.l)),
                    topRight: Math.max(0, s.topRight - Math.max(o.t, o.r)),
                    bottomLeft: Math.max(0, s.bottomLeft - Math.max(o.b, o.l)),
                    bottomRight: Math.max(0, s.bottomRight - Math.max(o.b, o.r))
                }
            }
        }
    }

    function Xo(t, e, i, n) {
        const o = null === e,
            s = null === i,
            a = t && !(o && s) && $o(t, n);
        return a && (o || e >= a.left && e <= a.right) && (s || i >= a.top && i <= a.bottom)
    }

    function qo(t, e) {
        t.rect(e.x, e.y, e.w, e.h)
    }

    function Ko(t, e, i = {}) {
        const n = t.x !== i.x ? -e : 0,
            o = t.y !== i.y ? -e : 0,
            s = (t.x + t.w !== i.x + i.w ? e : 0) - n,
            a = (t.y + t.h !== i.y + i.h ? e : 0) - o;
        return {
            x: t.x + n,
            y: t.y + o,
            w: t.w + s,
            h: t.h + a,
            radius: t.radius
        }
    }
    jo.id = "point", jo.defaults = {
        borderWidth: 1,
        hitRadius: 1,
        hoverBorderWidth: 1,
        hoverRadius: 4,
        pointStyle: "circle",
        radius: 3,
        rotation: 0
    }, jo.defaultRoutes = {
        backgroundColor: "backgroundColor",
        borderColor: "borderColor"
    };
    class Go extends Mn {
        constructor(t) {
            super(), this.options = void 0, this.horizontal = void 0, this.base = void 0, this.width = void 0, this.height = void 0, t && Object.assign(this, t)
        }
        draw(t) {
            const e = this.options,
                {
                    inner: i,
                    outer: n
                } = Uo(this),
                o = (s = n.radius).topLeft || s.topRight || s.bottomLeft || s.bottomRight ? ne : qo;
            var s;
            const a = .33;
            t.save(), n.w === i.w && n.h === i.h || (t.beginPath(), o(t, Ko(n, a, i)), t.clip(), o(t, Ko(i, -.33, n)), t.fillStyle = e.borderColor, t.fill("evenodd")), t.beginPath(), o(t, Ko(i, a, n)), t.fillStyle = e.backgroundColor, t.fill(), t.restore()
        }
        inRange(t, e, i) {
            return Xo(this, t, e, i)
        }
        inXRange(t, e) {
            return Xo(this, t, null, e)
        }
        inYRange(t, e) {
            return Xo(this, null, t, e)
        }
        getCenterPoint(t) {
            const {
                x: e,
                y: i,
                base: n,
                horizontal: o
            } = this.getProps(["x", "y", "base", "horizontal"], t);
            return {
                x: o ? (e + n) / 2 : e,
                y: o ? i : (i + n) / 2
            }
        }
        getRange(t) {
            return "x" === t ? this.width / 2 : this.height / 2
        }
    }
    Go.id = "bar", Go.defaults = {
        borderSkipped: "start",
        borderWidth: 0,
        borderRadius: 0,
        enableBorderRadius: !0,
        pointStyle: void 0
    }, Go.defaultRoutes = {
        backgroundColor: "backgroundColor",
        borderColor: "borderColor"
    };
    var Zo = Object.freeze({
        __proto__: null,
        ArcElement: Lo,
        LineElement: No,
        PointElement: jo,
        BarElement: Go
    });

    function Qo(t) {
        if (t._decimated) {
            const e = t._data;
            delete t._decimated, delete t._data, Object.defineProperty(t, "data", {
                value: e
            })
        }
    }

    function Jo(t) {
        t.data.datasets.forEach((t => {
            Qo(t)
        }))
    }
    var ts = {
        id: "decimation",
        defaults: {
            algorithm: "min-max",
            enabled: !1
        },
        beforeElementsUpdate: (t, e, i) => {
            if (!i.enabled) return void Jo(t);
            const n = t.width;
            t.data.datasets.forEach(((e, o) => {
                const {
                    _data: s,
                    indexAxis: a
                } = e, r = t.getDatasetMeta(o), l = s || e.data;
                if ("y" === We([a, t.options.indexAxis])) return;
                if ("line" !== r.type) return;
                const c = t.scales[r.xAxisID];
                if ("linear" !== c.type && "time" !== c.type) return;
                if (t.options.parsing) return;
                let {
                    start: h,
                    count: d
                } = function(t, e) {
                    const i = e.length;
                    let n, o = 0;
                    const {
                        iScale: s
                    } = t, {
                        min: a,
                        max: r,
                        minDefined: l,
                        maxDefined: c
                    } = s.getUserBounds();
                    return l && (o = Ht(se(e, s.axis, a).lo, 0, i - 1)), n = c ? Ht(se(e, s.axis, r).hi + 1, o, i) - o : i - o, {
                        start: o,
                        count: n
                    }
                }(r, l);
                if (d <= (i.threshold || 4 * n)) return void Qo(e);
                let u;
                switch ($(s) && (e._data = l, delete e.data, Object.defineProperty(e, "data", {
                        configurable: !0,
                        enumerable: !0,
                        get: function() {
                            return this._decimated
                        },
                        set: function(t) {
                            this._data = t
                        }
                    })), i.algorithm) {
                    case "lttb":
                        u = function(t, e, i, n, o) {
                            const s = o.samples || n;
                            if (s >= i) return t.slice(e, e + i);
                            const a = [],
                                r = (i - 2) / (s - 2);
                            let l = 0;
                            const c = e + i - 1;
                            let h, d, u, f, g, p = e;
                            for (a[l++] = t[p], h = 0; h < s - 2; h++) {
                                let n, o = 0,
                                    s = 0;
                                const c = Math.floor((h + 1) * r) + 1 + e,
                                    m = Math.min(Math.floor((h + 2) * r) + 1, i) + e,
                                    x = m - c;
                                for (n = c; n < m; n++) o += t[n].x, s += t[n].y;
                                o /= x, s /= x;
                                const b = Math.floor(h * r) + 1 + e,
                                    _ = Math.min(Math.floor((h + 1) * r) + 1, i) + e,
                                    {
                                        x: y,
                                        y: v
                                    } = t[p];
                                for (u = f = -1, n = b; n < _; n++) f = .5 * Math.abs((y - o) * (t[n].y - v) - (y - t[n].x) * (s - v)), f > u && (u = f, d = t[n], g = n);
                                a[l++] = d, p = g
                            }
                            return a[l++] = t[c], a
                        }(l, h, d, n, i);
                        break;
                    case "min-max":
                        u = function(t, e, i, n) {
                            let o, s, a, r, l, c, h, d, u, f, g = 0,
                                p = 0;
                            const m = [],
                                x = e + i - 1,
                                b = t[e].x,
                                _ = t[x].x - b;
                            for (o = e; o < e + i; ++o) {
                                s = t[o], a = (s.x - b) / _ * n, r = s.y;
                                const e = 0 | a;
                                if (e === l) r < u ? (u = r, c = o) : r > f && (f = r, h = o), g = (p * g + s.x) / ++p;
                                else {
                                    const i = o - 1;
                                    if (!$(c) && !$(h)) {
                                        const e = Math.min(c, h),
                                            n = Math.max(c, h);
                                        e !== d && e !== i && m.push({
                                            ...t[e],
                                            x: g
                                        }), n !== d && n !== i && m.push({
                                            ...t[n],
                                            x: g
                                        })
                                    }
                                    o > 0 && i !== d && m.push(t[i]), m.push(s), l = e, p = 0, u = f = r, c = h = d = o
                                }
                            }
                            return m
                        }(l, h, d, n);
                        break;
                    default:
                        throw new Error(`Unsupported decimation algorithm '${i.algorithm}'`)
                }
                e._decimated = u
            }))
        },
        destroy(t) {
            Jo(t)
        }
    };

    function es(t, e, i) {
        const n = function(t) {
            const e = t.options,
                i = e.fill;
            let n = K(i && i.target, i);
            return void 0 === n && (n = !!e.backgroundColor), !1 !== n && null !== n && (!0 === n ? "origin" : n)
        }(t);
        if (U(n)) return !isNaN(n.value) && n;
        let o = parseFloat(n);
        return X(o) && Math.floor(o) === o ? ("-" !== n[0] && "+" !== n[0] || (o = e + o), !(o === e || o < 0 || o >= i) && o) : ["origin", "start", "end", "stack", "shape"].indexOf(n) >= 0 && n
    }
    class is {
        constructor(t) {
            this.x = t.x, this.y = t.y, this.radius = t.radius
        }
        pathSegment(t, e, i) {
            const {
                x: n,
                y: o,
                radius: s
            } = this;
            return e = e || {
                start: 0,
                end: _t
            }, t.arc(n, o, s, e.end, e.start, !0), !i.bounds
        }
        interpolate(t) {
            const {
                x: e,
                y: i,
                radius: n
            } = this, o = t.angle;
            return {
                x: e + Math.cos(o) * n,
                y: i + Math.sin(o) * n,
                angle: o
            }
        }
    }

    function ns(t) {
        return (t.scale || {}).getPointPositionForValue ? function(t) {
            const {
                scale: e,
                fill: i
            } = t, n = e.options, o = e.getLabels().length, s = [], a = n.reverse ? e.max : e.min, r = n.reverse ? e.min : e.max;
            let l, c, h;
            if (h = "start" === i ? a : "end" === i ? r : U(i) ? i.value : e.getBaseValue(), n.grid.circular) return c = e.getPointPositionForValue(0, a), new is({
                x: c.x,
                y: c.y,
                radius: e.getDistanceFromCenterForValue(h)
            });
            for (l = 0; l < o; ++l) s.push(e.getPointPositionForValue(l, h));
            return s
        }(t) : function(t) {
            const {
                scale: e = {},
                fill: i
            } = t;
            let n, o = null;
            return "start" === i ? o = e.bottom : "end" === i ? o = e.top : U(i) ? o = e.getPixelForValue(i.value) : e.getBasePixel && (o = e.getBasePixel()), X(o) ? (n = e.isHorizontal(), {
                x: n ? o : null,
                y: n ? null : o
            }) : null
        }(t)
    }

    function os(t, e, i) {
        for (; e > t; e--) {
            const t = i[e];
            if (!isNaN(t.x) && !isNaN(t.y)) break
        }
        return e
    }

    function ss(t) {
        const {
            chart: e,
            scale: i,
            index: n,
            line: o
        } = t, s = [], a = o.segments, r = o.points, l = function(t, e) {
            const i = [],
                n = t.getSortedVisibleDatasetMetas();
            for (let t = 0; t < n.length; t++) {
                const o = n[t];
                if (o.index === e) break;
                as(o) && i.unshift(o.dataset)
            }
            return i
        }(e, n);
        l.push(cs({
            x: null,
            y: i.bottom
        }, o));
        for (let t = 0; t < a.length; t++) {
            const e = a[t];
            for (let t = e.start; t <= e.end; t++) rs(s, r[t], l)
        }
        return new No({
            points: s,
            options: {}
        })
    }
    const as = t => "line" === t.type && !t.hidden;

    function rs(t, e, i) {
        const n = [];
        for (let o = 0; o < i.length; o++) {
            const s = i[o],
                {
                    first: a,
                    last: r,
                    point: l
                } = ls(s, e, "x");
            if (!(!l || a && r))
                if (a) n.unshift(l);
                else if (t.push(l), !r) break
        }
        t.push(...n)
    }

    function ls(t, e, i) {
        const n = t.interpolate(e, i);
        if (!n) return {};
        const o = n[i],
            s = t.segments,
            a = t.points;
        let r = !1,
            l = !1;
        for (let t = 0; t < s.length; t++) {
            const e = s[t],
                n = a[e.start][i],
                c = a[e.end][i];
            if (o >= n && o <= c) {
                r = o === n, l = o === c;
                break
            }
        }
        return {
            first: r,
            last: l,
            point: n
        }
    }

    function cs(t, e) {
        let i = [],
            n = !1;
        return Y(t) ? (n = !0, i = t) : i = function(t, e) {
            const {
                x: i = null,
                y: n = null
            } = t || {}, o = e.points, s = [];
            return e.segments.forEach((({
                start: t,
                end: e
            }) => {
                e = os(t, e, o);
                const a = o[t],
                    r = o[e];
                null !== n ? (s.push({
                    x: a.x,
                    y: n
                }), s.push({
                    x: r.x,
                    y: n
                })) : null !== i && (s.push({
                    x: i,
                    y: a.y
                }), s.push({
                    x: i,
                    y: r.y
                }))
            })), s
        }(t, e), i.length ? new No({
            points: i,
            options: {
                tension: 0
            },
            _loop: n,
            _fullLoop: n
        }) : null
    }

    function hs(t, e, i) {
        let n = t[e].fill;
        const o = [e];
        let s;
        if (!i) return n;
        for (; !1 !== n && -1 === o.indexOf(n);) {
            if (!X(n)) return n;
            if (s = t[n], !s) return !1;
            if (s.visible) return n;
            o.push(n), n = s.fill
        }
        return !1
    }

    function ds(t, e, i) {
        t.beginPath(), e.path(t), t.lineTo(e.last().x, i), t.lineTo(e.first().x, i), t.closePath(), t.clip()
    }

    function us(t, e, i, n) {
        if (n) return;
        let o = e[t],
            s = i[t];
        return "angle" === t && (o = Wt(o), s = Wt(s)), {
            property: t,
            start: o,
            end: s
        }
    }

    function fs(t, e, i, n) {
        return t && e ? n(t[i], e[i]) : t ? t[i] : e ? e[i] : 0
    }

    function gs(t, e, i) {
        const {
            top: n,
            bottom: o
        } = e.chart.chartArea, {
            property: s,
            start: a,
            end: r
        } = i || {};
        "x" === s && (t.beginPath(), t.rect(a, n, r - a, o - n), t.clip())
    }

    function ps(t, e, i, n) {
        const o = e.interpolate(i, n);
        o && t.lineTo(o.x, o.y)
    }

    function ms(t, e) {
        const {
            line: i,
            target: n,
            property: o,
            color: s,
            scale: a
        } = e, r = function(t, e, i) {
            const n = t.segments,
                o = t.points,
                s = e.points,
                a = [];
            for (const t of n) {
                let {
                    start: n,
                    end: r
                } = t;
                r = os(n, r, o);
                const l = us(i, o[n], o[r], t.loop);
                if (!e.segments) {
                    a.push({
                        source: t,
                        target: l,
                        start: o[n],
                        end: o[r]
                    });
                    continue
                }
                const c = zi(e, l);
                for (const e of c) {
                    const n = us(i, s[e.start], s[e.end], e.loop),
                        r = Ii(t, o, n);
                    for (const t of r) a.push({
                        source: t,
                        target: e,
                        start: {
                            [i]: fs(l, n, "start", Math.max)
                        },
                        end: {
                            [i]: fs(l, n, "end", Math.min)
                        }
                    })
                }
            }
            return a
        }(i, n, o);
        for (const {
                source: e,
                target: l,
                start: c,
                end: h
            } of r) {
            const {
                style: {
                    backgroundColor: r = s
                } = {}
            } = e, d = !0 !== n;
            t.save(), t.fillStyle = r, gs(t, a, d && us(o, c, h)), t.beginPath();
            const u = !!i.pathSegment(t, e);
            let f;
            if (d) {
                u ? t.closePath() : ps(t, n, h, o);
                const e = !!n.pathSegment(t, l, {
                    move: u,
                    reverse: !0
                });
                f = u && e, f || ps(t, n, c, o)
            }
            t.closePath(), t.fill(f ? "evenodd" : "nonzero"), t.restore()
        }
    }

    function xs(t, e, i) {
        const n = function(t) {
                const {
                    chart: e,
                    fill: i,
                    line: n
                } = t;
                if (X(i)) return function(t, e) {
                    const i = t.getDatasetMeta(e);
                    return i && t.isDatasetVisible(e) ? i.dataset : null
                }(e, i);
                if ("stack" === i) return ss(t);
                if ("shape" === i) return !0;
                const o = ns(t);
                return o instanceof is ? o : cs(o, n)
            }(e),
            {
                line: o,
                scale: s,
                axis: a
            } = e,
            r = o.options,
            l = r.fill,
            c = r.backgroundColor,
            {
                above: h = c,
                below: d = c
            } = l || {};
        n && o.points.length && (Zt(t, i), function(t, e) {
            const {
                line: i,
                target: n,
                above: o,
                below: s,
                area: a,
                scale: r
            } = e, l = i._loop ? "angle" : e.axis;
            t.save(), "x" === l && s !== o && (ds(t, n, a.top), ms(t, {
                line: i,
                target: n,
                color: o,
                scale: r,
                property: l
            }), t.restore(), t.save(), ds(t, n, a.bottom)), ms(t, {
                line: i,
                target: n,
                color: s,
                scale: r,
                property: l
            }), t.restore()
        }(t, {
            line: o,
            target: n,
            above: h,
            below: d,
            area: i,
            scale: s,
            axis: a
        }), Qt(t))
    }
    var bs = {
        id: "filler",
        afterDatasetsUpdate(t, e, i) {
            const n = (t.data.datasets || []).length,
                o = [];
            let s, a, r, l;
            for (a = 0; a < n; ++a) s = t.getDatasetMeta(a), r = s.dataset, l = null, r && r.options && r instanceof No && (l = {
                visible: t.isDatasetVisible(a),
                index: a,
                fill: es(r, a, n),
                chart: t,
                axis: s.controller.options.indexAxis,
                scale: s.vScale,
                line: r
            }), s.$filler = l, o.push(l);
            for (a = 0; a < n; ++a) l = o[a], l && !1 !== l.fill && (l.fill = hs(o, a, i.propagate))
        },
        beforeDraw(t, e, i) {
            const n = "beforeDraw" === i.drawTime,
                o = t.getSortedVisibleDatasetMetas(),
                s = t.chartArea;
            for (let e = o.length - 1; e >= 0; --e) {
                const i = o[e].$filler;
                i && (i.line.updateControlPoints(s, i.axis), n && xs(t.ctx, i, s))
            }
        },
        beforeDatasetsDraw(t, e, i) {
            if ("beforeDatasetsDraw" !== i.drawTime) return;
            const n = t.getSortedVisibleDatasetMetas();
            for (let e = n.length - 1; e >= 0; --e) {
                const i = n[e].$filler;
                i && xs(t.ctx, i, t.chartArea)
            }
        },
        beforeDatasetDraw(t, e, i) {
            const n = e.meta.$filler;
            n && !1 !== n.fill && "beforeDatasetDraw" === i.drawTime && xs(t.ctx, n, t.chartArea)
        },
        defaults: {
            propagate: !0,
            drawTime: "beforeDatasetDraw"
        }
    };
    const _s = (t, e) => {
        let {
            boxHeight: i = e,
            boxWidth: n = e
        } = t;
        return t.usePointStyle && (i = Math.min(i, e), n = Math.min(n, e)), {
            boxWidth: n,
            boxHeight: i,
            itemHeight: Math.max(e, i)
        }
    };
    class ys extends Mn {
        constructor(t) {
            super(), this._added = !1, this.legendHitBoxes = [], this._hoveredItem = null, this.doughnutMode = !1, this.chart = t.chart, this.options = t.options, this.ctx = t.ctx, this.legendItems = void 0, this.columnSizes = void 0, this.lineWidths = void 0, this.maxHeight = void 0, this.maxWidth = void 0, this.top = void 0, this.bottom = void 0, this.left = void 0, this.right = void 0, this.height = void 0, this.width = void 0, this._margins = void 0, this.position = void 0, this.weight = void 0, this.fullSize = void 0
        }
        update(t, e, i) {
            const n = this;
            n.maxWidth = t, n.maxHeight = e, n._margins = i, n.setDimensions(), n.buildLabels(), n.fit()
        }
        setDimensions() {
            const t = this;
            t.isHorizontal() ? (t.width = t.maxWidth, t.left = t._margins.left, t.right = t.width) : (t.height = t.maxHeight, t.top = t._margins.top, t.bottom = t.height)
        }
        buildLabels() {
            const t = this,
                e = t.options.labels || {};
            let i = Q(e.generateLabels, [t.chart], t) || [];
            e.filter && (i = i.filter((i => e.filter(i, t.chart.data)))), e.sort && (i = i.sort(((i, n) => e.sort(i, n, t.chart.data)))), t.options.reverse && i.reverse(), t.legendItems = i
        }
        fit() {
            const t = this,
                {
                    options: e,
                    ctx: i
                } = t;
            if (!e.display) return void(t.width = t.height = 0);
            const n = e.labels,
                o = Ve(n.font),
                s = o.size,
                a = t._computeTitleHeight(),
                {
                    boxWidth: r,
                    itemHeight: l
                } = _s(n, s);
            let c, h;
            i.font = o.string, t.isHorizontal() ? (c = t.maxWidth, h = t._fitRows(a, s, r, l) + 10) : (h = t.maxHeight, c = t._fitCols(a, s, r, l) + 10), t.width = Math.min(c, e.maxWidth || t.maxWidth), t.height = Math.min(h, e.maxHeight || t.maxHeight)
        }
        _fitRows(t, e, i, n) {
            const o = this,
                {
                    ctx: s,
                    maxWidth: a,
                    options: {
                        labels: {
                            padding: r
                        }
                    }
                } = o,
                l = o.legendHitBoxes = [],
                c = o.lineWidths = [0],
                h = n + r;
            let d = t;
            s.textAlign = "left", s.textBaseline = "middle";
            let u = -1,
                f = -h;
            return o.legendItems.forEach(((t, o) => {
                const g = i + e / 2 + s.measureText(t.text).width;
                (0 === o || c[c.length - 1] + g + 2 * r > a) && (d += h, c[c.length - (o > 0 ? 0 : 1)] = 0, f += h, u++), l[o] = {
                    left: 0,
                    top: f,
                    row: u,
                    width: g,
                    height: n
                }, c[c.length - 1] += g + r
            })), d
        }
        _fitCols(t, e, i, n) {
            const o = this,
                {
                    ctx: s,
                    maxHeight: a,
                    options: {
                        labels: {
                            padding: r
                        }
                    }
                } = o,
                l = o.legendHitBoxes = [],
                c = o.columnSizes = [],
                h = a - t;
            let d = r,
                u = 0,
                f = 0,
                g = 0,
                p = 0;
            return o.legendItems.forEach(((t, o) => {
                const a = i + e / 2 + s.measureText(t.text).width;
                o > 0 && f + n + 2 * r > h && (d += u + r, c.push({
                    width: u,
                    height: f
                }), g += u + r, p++, u = f = 0), l[o] = {
                    left: g,
                    top: f,
                    col: p,
                    width: a,
                    height: n
                }, u = Math.max(u, a), f += n + r
            })), d += u, c.push({
                width: u,
                height: f
            }), d
        }
        adjustHitBoxes() {
            const t = this;
            if (!t.options.display) return;
            const e = t._computeTitleHeight(),
                {
                    legendHitBoxes: i,
                    options: {
                        align: n,
                        labels: {
                            padding: s
                        },
                        rtl: a
                    }
                } = t,
                r = Ti(a, t.left, t.width);
            if (this.isHorizontal()) {
                let a = 0,
                    l = o(n, t.left + s, t.right - t.lineWidths[a]);
                for (const c of i) a !== c.row && (a = c.row, l = o(n, t.left + s, t.right - t.lineWidths[a])), c.top += t.top + e + s, c.left = r.leftForLtr(r.x(l), c.width), l += c.width + s
            } else {
                let a = 0,
                    l = o(n, t.top + e + s, t.bottom - t.columnSizes[a].height);
                for (const c of i) c.col !== a && (a = c.col, l = o(n, t.top + e + s, t.bottom - t.columnSizes[a].height)), c.top = l, c.left += t.left + s, c.left = r.leftForLtr(r.x(c.left), c.width), l += c.height + s
            }
        }
        isHorizontal() {
            return "top" === this.options.position || "bottom" === this.options.position
        }
        draw() {
            const t = this;
            if (t.options.display) {
                const e = t.ctx;
                Zt(e, t), t._draw(), Qt(e)
            }
        }
        _draw() {
            const t = this,
                {
                    options: e,
                    columnSizes: i,
                    lineWidths: n,
                    ctx: a
                } = t,
                {
                    align: r,
                    labels: l
                } = e,
                c = xt.color,
                h = Ti(e.rtl, t.left, t.width),
                d = Ve(l.font),
                {
                    color: u,
                    padding: f
                } = l,
                g = d.size,
                p = g / 2;
            let m;
            t.drawTitle(), a.textAlign = h.textAlign("left"), a.textBaseline = "middle", a.lineWidth = .5, a.font = d.string;
            const {
                boxWidth: x,
                boxHeight: b,
                itemHeight: _
            } = _s(l, g), y = t.isHorizontal(), v = this._computeTitleHeight();
            m = y ? {
                x: o(r, t.left + f, t.right - n[0]),
                y: t.top + f + v,
                line: 0
            } : {
                x: t.left + f,
                y: o(r, t.top + v + f, t.bottom - i[0].height),
                line: 0
            }, Ai(t.ctx, e.textDirection);
            const w = _ + f;
            t.legendItems.forEach(((M, k) => {
                a.strokeStyle = M.fontColor || u, a.fillStyle = M.fontColor || u;
                const S = a.measureText(M.text).width,
                    P = h.textAlign(M.textAlign || (M.textAlign = l.textAlign)),
                    D = x + p + S;
                let C = m.x,
                    O = m.y;
                h.setWidth(t.width), y ? k > 0 && C + D + f > t.right && (O = m.y += w, m.line++, C = m.x = o(r, t.left + f, t.right - n[m.line])) : k > 0 && O + w > t.bottom && (C = m.x = C + i[m.line].width + f, m.line++, O = m.y = o(r, t.top + v + f, t.bottom - i[m.line].height));
                ! function(t, e, i) {
                    if (isNaN(x) || x <= 0 || isNaN(b) || b < 0) return;
                    a.save();
                    const n = K(i.lineWidth, 1);
                    if (a.fillStyle = K(i.fillStyle, c), a.lineCap = K(i.lineCap, "butt"), a.lineDashOffset = K(i.lineDashOffset, 0), a.lineJoin = K(i.lineJoin, "miter"), a.lineWidth = n, a.strokeStyle = K(i.strokeStyle, c), a.setLineDash(K(i.lineDash, [])), l.usePointStyle) {
                        const o = {
                                radius: x * Math.SQRT2 / 2,
                                pointStyle: i.pointStyle,
                                rotation: i.rotation,
                                borderWidth: n
                            },
                            s = h.xPlus(t, x / 2);
                        Kt(a, o, s, e + p)
                    } else {
                        const o = e + Math.max((g - b) / 2, 0),
                            s = h.leftForLtr(t, x),
                            r = Fe(i.borderRadius);
                        a.beginPath(), Object.values(r).some((t => 0 !== t)) ? ne(a, {
                            x: s,
                            y: o,
                            w: x,
                            h: b,
                            radius: r
                        }) : a.rect(s, o, x, b), a.fill(), 0 !== n && a.stroke()
                    }
                    a.restore()
                }(h.x(C), O, M), C = s(P, C + x + p, y ? C + D : t.right, e.rtl),
                    function(t, e, i) {
                        ee(a, i.text, t, e + _ / 2, d, {
                            strikethrough: i.hidden,
                            textAlign: h.textAlign(i.textAlign)
                        })
                    }(h.x(C), O, M), y ? m.x += D + f : m.y += w
            })), Li(t.ctx, e.textDirection)
        }
        drawTitle() {
            const t = this,
                e = t.options,
                i = e.title,
                s = Ve(i.font),
                a = Be(i.padding);
            if (!i.display) return;
            const r = Ti(e.rtl, t.left, t.width),
                l = t.ctx,
                c = i.position,
                h = s.size / 2,
                d = a.top + h;
            let u, f = t.left,
                g = t.width;
            if (this.isHorizontal()) g = Math.max(...t.lineWidths), u = t.top + d, f = o(e.align, f, t.right - g);
            else {
                const i = t.columnSizes.reduce(((t, e) => Math.max(t, e.height)), 0);
                u = d + o(e.align, t.top, t.bottom - i - e.labels.padding - t._computeTitleHeight())
            }
            const p = o(c, f, f + g);
            l.textAlign = r.textAlign(n(c)), l.textBaseline = "middle", l.strokeStyle = i.color, l.fillStyle = i.color, l.font = s.string, ee(l, i.text, p, u, s)
        }
        _computeTitleHeight() {
            const t = this.options.title,
                e = Ve(t.font),
                i = Be(t.padding);
            return t.display ? e.lineHeight + i.height : 0
        }
        _getLegendItemAt(t, e) {
            const i = this;
            let n, o, s;
            if (t >= i.left && t <= i.right && e >= i.top && e <= i.bottom)
                for (s = i.legendHitBoxes, n = 0; n < s.length; ++n)
                    if (o = s[n], t >= o.left && t <= o.left + o.width && e >= o.top && e <= o.top + o.height) return i.legendItems[n];
            return null
        }
        handleEvent(t) {
            const e = this,
                i = e.options;
            if (! function(t, e) {
                    if ("mousemove" === t && (e.onHover || e.onLeave)) return !0;
                    if (e.onClick && ("click" === t || "mouseup" === t)) return !0;
                    return !1
                }(t.type, i)) return;
            const n = e._getLegendItemAt(t.x, t.y);
            if ("mousemove" === t.type) {
                const a = e._hoveredItem,
                    r = (s = n, null !== (o = a) && null !== s && o.datasetIndex === s.datasetIndex && o.index === s.index);
                a && !r && Q(i.onLeave, [t, a, e], e), e._hoveredItem = n, n && !r && Q(i.onHover, [t, n, e], e)
            } else n && Q(i.onClick, [t, n, e], e);
            var o, s
        }
    }
    var vs = {
        id: "legend",
        _element: ys,
        start(t, e, i) {
            const n = t.legend = new ys({
                ctx: t.ctx,
                options: i,
                chart: t
            });
            ti.configure(t, n, i), ti.addBox(t, n)
        },
        stop(t) {
            ti.removeBox(t, t.legend), delete t.legend
        },
        beforeUpdate(t, e, i) {
            const n = t.legend;
            ti.configure(t, n, i), n.options = i
        },
        afterUpdate(t) {
            const e = t.legend;
            e.buildLabels(), e.adjustHitBoxes()
        },
        afterEvent(t, e) {
            e.replay || t.legend.handleEvent(e.event)
        },
        defaults: {
            display: !0,
            position: "top",
            align: "center",
            fullSize: !0,
            reverse: !1,
            weight: 1e3,
            onClick(t, e, i) {
                const n = e.datasetIndex,
                    o = i.chart;
                o.isDatasetVisible(n) ? (o.hide(n), e.hidden = !0) : (o.show(n), e.hidden = !1)
            },
            onHover: null,
            onLeave: null,
            labels: {
                color: t => t.chart.options.color,
                boxWidth: 40,
                padding: 10,
                generateLabels(t) {
                    const e = t.data.datasets,
                        {
                            labels: {
                                usePointStyle: i,
                                pointStyle: n,
                                textAlign: o,
                                color: s
                            }
                        } = t.legend.options;
                    return t._getSortedDatasetMetas().map((t => {
                        const a = t.controller.getStyle(i ? 0 : void 0),
                            r = Be(a.borderWidth);
                        return {
                            text: e[t.index].label,
                            fillStyle: a.backgroundColor,
                            fontColor: s,
                            hidden: !t.visible,
                            lineCap: a.borderCapStyle,
                            lineDash: a.borderDash,
                            lineDashOffset: a.borderDashOffset,
                            lineJoin: a.borderJoinStyle,
                            lineWidth: (r.width + r.height) / 4,
                            strokeStyle: a.borderColor,
                            pointStyle: n || a.pointStyle,
                            rotation: a.rotation,
                            textAlign: o || a.textAlign,
                            borderRadius: 0,
                            datasetIndex: t.index
                        }
                    }), this)
                }
            },
            title: {
                color: t => t.chart.options.color,
                display: !1,
                position: "center",
                text: ""
            }
        },
        descriptors: {
            _scriptable: t => !t.startsWith("on"),
            labels: {
                _scriptable: t => !["generateLabels", "filter", "sort"].includes(t)
            }
        }
    };
    class ws extends Mn {
        constructor(t) {
            super(), this.chart = t.chart, this.options = t.options, this.ctx = t.ctx, this._padding = void 0, this.top = void 0, this.bottom = void 0, this.left = void 0, this.right = void 0, this.width = void 0, this.height = void 0, this.position = void 0, this.weight = void 0, this.fullSize = void 0
        }
        update(t, e) {
            const i = this,
                n = i.options;
            if (i.left = 0, i.top = 0, !n.display) return void(i.width = i.height = i.right = i.bottom = 0);
            i.width = i.right = t, i.height = i.bottom = e;
            const o = Y(n.text) ? n.text.length : 1;
            i._padding = Be(n.padding);
            const s = o * Ve(n.font).lineHeight + i._padding.height;
            i.isHorizontal() ? i.height = s : i.width = s
        }
        isHorizontal() {
            const t = this.options.position;
            return "top" === t || "bottom" === t
        }
        _drawArgs(t) {
            const {
                top: e,
                left: i,
                bottom: n,
                right: s,
                options: a
            } = this, r = a.align;
            let l, c, h, d = 0;
            return this.isHorizontal() ? (c = o(r, i, s), h = e + t, l = s - i) : ("left" === a.position ? (c = i + t, h = o(r, n, e), d = -.5 * bt) : (c = s - t, h = o(r, e, n), d = .5 * bt), l = n - e), {
                titleX: c,
                titleY: h,
                maxWidth: l,
                rotation: d
            }
        }
        draw() {
            const t = this,
                e = t.ctx,
                i = t.options;
            if (!i.display) return;
            const o = Ve(i.font),
                s = o.lineHeight / 2 + t._padding.top,
                {
                    titleX: a,
                    titleY: r,
                    maxWidth: l,
                    rotation: c
                } = t._drawArgs(s);
            ee(e, i.text, 0, 0, o, {
                color: i.color,
                maxWidth: l,
                rotation: c,
                textAlign: n(i.align),
                textBaseline: "middle",
                translation: [a, r]
            })
        }
    }
    var Ms = {
        id: "title",
        _element: ws,
        start(t, e, i) {
            ! function(t, e) {
                const i = new ws({
                    ctx: t.ctx,
                    options: e,
                    chart: t
                });
                ti.configure(t, i, e), ti.addBox(t, i), t.titleBlock = i
            }(t, i)
        },
        stop(t) {
            const e = t.titleBlock;
            ti.removeBox(t, e), delete t.titleBlock
        },
        beforeUpdate(t, e, i) {
            const n = t.titleBlock;
            ti.configure(t, n, i), n.options = i
        },
        defaults: {
            align: "center",
            display: !1,
            font: {
                weight: "bold"
            },
            fullSize: !0,
            padding: 10,
            position: "top",
            text: "",
            weight: 2e3
        },
        defaultRoutes: {
            color: "color"
        },
        descriptors: {
            _scriptable: !0,
            _indexable: !1
        }
    };
    const ks = new WeakMap;
    var Ss = {
        id: "subtitle",
        start(t, e, i) {
            const n = new ws({
                ctx: t.ctx,
                options: i,
                chart: t
            });
            ti.configure(t, n, i), ti.addBox(t, n), ks.set(t, n)
        },
        stop(t) {
            ti.removeBox(t, ks.get(t)), ks.delete(t)
        },
        beforeUpdate(t, e, i) {
            const n = ks.get(t);
            ti.configure(t, n, i), n.options = i
        },
        defaults: {
            align: "center",
            display: !1,
            font: {
                weight: "normal"
            },
            fullSize: !0,
            padding: 0,
            position: "top",
            text: "",
            weight: 1500
        },
        defaultRoutes: {
            color: "color"
        },
        descriptors: {
            _scriptable: !0,
            _indexable: !1
        }
    };
    const Ps = {
        average(t) {
            if (!t.length) return !1;
            let e, i, n = 0,
                o = 0,
                s = 0;
            for (e = 0, i = t.length; e < i; ++e) {
                const i = t[e].element;
                if (i && i.hasValue()) {
                    const t = i.tooltipPosition();
                    n += t.x, o += t.y, ++s
                }
            }
            return {
                x: n / s,
                y: o / s
            }
        },
        nearest(t, e) {
            if (!t.length) return !1;
            let i, n, o, s = e.x,
                a = e.y,
                r = Number.POSITIVE_INFINITY;
            for (i = 0, n = t.length; i < n; ++i) {
                const n = t[i].element;
                if (n && n.hasValue()) {
                    const t = Bt(e, n.getCenterPoint());
                    t < r && (r = t, o = n)
                }
            }
            if (o) {
                const t = o.tooltipPosition();
                s = t.x, a = t.y
            }
            return {
                x: s,
                y: a
            }
        }
    };

    function Ds(t, e) {
        return e && (Y(e) ? Array.prototype.push.apply(t, e) : t.push(e)), t
    }

    function Cs(t) {
        return ("string" == typeof t || t instanceof String) && t.indexOf("\n") > -1 ? t.split("\n") : t
    }

    function Os(t, e) {
        const {
            element: i,
            datasetIndex: n,
            index: o
        } = e, s = t.getDatasetMeta(n).controller, {
            label: a,
            value: r
        } = s.getLabelAndValue(o);
        return {
            chart: t,
            label: a,
            parsed: s.getParsed(o),
            raw: t.data.datasets[n].data[o],
            formattedValue: r,
            dataset: s.getDataset(),
            dataIndex: o,
            datasetIndex: n,
            element: i
        }
    }

    function Ts(t, e) {
        const i = t._chart.ctx,
            {
                body: n,
                footer: o,
                title: s
            } = t,
            {
                boxWidth: a,
                boxHeight: r
            } = e,
            l = Ve(e.bodyFont),
            c = Ve(e.titleFont),
            h = Ve(e.footerFont),
            d = s.length,
            u = o.length,
            f = n.length,
            g = Be(e.padding);
        let p = g.height,
            m = 0,
            x = n.reduce(((t, e) => t + e.before.length + e.lines.length + e.after.length), 0);
        if (x += t.beforeBody.length + t.afterBody.length, d && (p += d * c.lineHeight + (d - 1) * e.titleSpacing + e.titleMarginBottom), x) {
            p += f * (e.displayColors ? Math.max(r, l.lineHeight) : l.lineHeight) + (x - f) * l.lineHeight + (x - 1) * e.bodySpacing
        }
        u && (p += e.footerMarginTop + u * h.lineHeight + (u - 1) * e.footerSpacing);
        let b = 0;
        const _ = function(t) {
            m = Math.max(m, i.measureText(t).width + b)
        };
        return i.save(), i.font = c.string, J(t.title, _), i.font = l.string, J(t.beforeBody.concat(t.afterBody), _), b = e.displayColors ? a + 2 : 0, J(n, (t => {
            J(t.before, _), J(t.lines, _), J(t.after, _)
        })), b = 0, i.font = h.string, J(t.footer, _), i.restore(), m += g.width, {
            width: m,
            height: p
        }
    }

    function As(t, e, i, n) {
        const {
            x: o,
            width: s
        } = i, {
            width: a,
            chartArea: {
                left: r,
                right: l
            }
        } = t;
        let c = "center";
        return "center" === n ? c = o <= (r + l) / 2 ? "left" : "right" : o <= s / 2 ? c = "left" : o >= a - s / 2 && (c = "right"),
            function(t, e, i, n) {
                const {
                    x: o,
                    width: s
                } = n, a = i.caretSize + i.caretPadding;
                return "left" === t && o + s + a > e.width || "right" === t && o - s - a < 0 || void 0
            }(c, t, e, i) && (c = "center"), c
    }

    function Ls(t, e, i) {
        const n = e.yAlign || function(t, e) {
            const {
                y: i,
                height: n
            } = e;
            return i < n / 2 ? "top" : i > t.height - n / 2 ? "bottom" : "center"
        }(t, i);
        return {
            xAlign: e.xAlign || As(t, e, i, n),
            yAlign: n
        }
    }

    function Rs(t, e, i, n) {
        const {
            caretSize: o,
            caretPadding: s,
            cornerRadius: a
        } = t, {
            xAlign: r,
            yAlign: l
        } = i, c = o + s, h = a + s;
        let d = function(t, e) {
            let {
                x: i,
                width: n
            } = t;
            return "right" === e ? i -= n : "center" === e && (i -= n / 2), i
        }(e, r);
        const u = function(t, e, i) {
            let {
                y: n,
                height: o
            } = t;
            return "top" === e ? n += i : n -= "bottom" === e ? o + i : o / 2, n
        }(e, l, c);
        return "center" === l ? "left" === r ? d += c : "right" === r && (d -= c) : "left" === r ? d -= h : "right" === r && (d += h), {
            x: Ht(d, 0, n.width - e.width),
            y: Ht(u, 0, n.height - e.height)
        }
    }

    function Es(t, e, i) {
        const n = Be(i.padding);
        return "center" === e ? t.x + t.width / 2 : "right" === e ? t.x + t.width - n.right : t.x + n.left
    }

    function Is(t) {
        return Ds([], Cs(t))
    }

    function zs(t, e) {
        const i = e && e.dataset && e.dataset.tooltip && e.dataset.tooltip.callbacks;
        return i ? t.override(i) : t
    }
    class Fs extends Mn {
        constructor(t) {
            super(), this.opacity = 0, this._active = [], this._chart = t._chart, this._eventPosition = void 0, this._size = void 0, this._cachedAnimations = void 0, this._tooltipItems = [], this.$animations = void 0, this.$context = void 0, this.options = t.options, this.dataPoints = void 0, this.title = void 0, this.beforeBody = void 0, this.body = void 0, this.afterBody = void 0, this.footer = void 0, this.xAlign = void 0, this.yAlign = void 0, this.x = void 0, this.y = void 0, this.height = void 0, this.width = void 0, this.caretX = void 0, this.caretY = void 0, this.labelColors = void 0, this.labelPointStyles = void 0, this.labelTextColors = void 0
        }
        initialize(t) {
            this.options = t, this._cachedAnimations = void 0, this.$context = void 0
        }
        _resolveAnimations() {
            const t = this,
                e = t._cachedAnimations;
            if (e) return e;
            const i = t._chart,
                n = t.options.setContext(t.getContext()),
                o = n.enabled && i.options.animation && n.animations,
                s = new hn(t._chart, o);
            return o._cacheable && (t._cachedAnimations = Object.freeze(s)), s
        }
        getContext() {
            const t = this;
            return t.$context || (t.$context = (e = t._chart.getContext(), i = t, n = t._tooltipItems, Object.assign(Object.create(e), {
                tooltip: i,
                tooltipItems: n,
                type: "tooltip"
            })));
            var e, i, n
        }
        getTitle(t, e) {
            const i = this,
                {
                    callbacks: n
                } = e,
                o = n.beforeTitle.apply(i, [t]),
                s = n.title.apply(i, [t]),
                a = n.afterTitle.apply(i, [t]);
            let r = [];
            return r = Ds(r, Cs(o)), r = Ds(r, Cs(s)), r = Ds(r, Cs(a)), r
        }
        getBeforeBody(t, e) {
            return Is(e.callbacks.beforeBody.apply(this, [t]))
        }
        getBody(t, e) {
            const i = this,
                {
                    callbacks: n
                } = e,
                o = [];
            return J(t, (t => {
                const e = {
                        before: [],
                        lines: [],
                        after: []
                    },
                    s = zs(n, t);
                Ds(e.before, Cs(s.beforeLabel.call(i, t))), Ds(e.lines, s.label.call(i, t)), Ds(e.after, Cs(s.afterLabel.call(i, t))), o.push(e)
            })), o
        }
        getAfterBody(t, e) {
            return Is(e.callbacks.afterBody.apply(this, [t]))
        }
        getFooter(t, e) {
            const i = this,
                {
                    callbacks: n
                } = e,
                o = n.beforeFooter.apply(i, [t]),
                s = n.footer.apply(i, [t]),
                a = n.afterFooter.apply(i, [t]);
            let r = [];
            return r = Ds(r, Cs(o)), r = Ds(r, Cs(s)), r = Ds(r, Cs(a)), r
        }
        _createItems(t) {
            const e = this,
                i = e._active,
                n = e._chart.data,
                o = [],
                s = [],
                a = [];
            let r, l, c = [];
            for (r = 0, l = i.length; r < l; ++r) c.push(Os(e._chart, i[r]));
            return t.filter && (c = c.filter(((e, i, o) => t.filter(e, i, o, n)))), t.itemSort && (c = c.sort(((e, i) => t.itemSort(e, i, n)))), J(c, (i => {
                const n = zs(t.callbacks, i);
                o.push(n.labelColor.call(e, i)), s.push(n.labelPointStyle.call(e, i)), a.push(n.labelTextColor.call(e, i))
            })), e.labelColors = o, e.labelPointStyles = s, e.labelTextColors = a, e.dataPoints = c, c
        }
        update(t, e) {
            const i = this,
                n = i.options.setContext(i.getContext()),
                o = i._active;
            let s, a = [];
            if (o.length) {
                const t = Ps[n.position].call(i, o, i._eventPosition);
                a = i._createItems(n), i.title = i.getTitle(a, n), i.beforeBody = i.getBeforeBody(a, n), i.body = i.getBody(a, n), i.afterBody = i.getAfterBody(a, n), i.footer = i.getFooter(a, n);
                const e = i._size = Ts(i, n),
                    r = Object.assign({}, t, e),
                    l = Ls(i._chart, n, r),
                    c = Rs(n, r, l, i._chart);
                i.xAlign = l.xAlign, i.yAlign = l.yAlign, s = {
                    opacity: 1,
                    x: c.x,
                    y: c.y,
                    width: e.width,
                    height: e.height,
                    caretX: t.x,
                    caretY: t.y
                }
            } else 0 !== i.opacity && (s = {
                opacity: 0
            });
            i._tooltipItems = a, i.$context = void 0, s && i._resolveAnimations().update(i, s), t && n.external && n.external.call(i, {
                chart: i._chart,
                tooltip: i,
                replay: e
            })
        }
        drawCaret(t, e, i, n) {
            const o = this.getCaretPosition(t, i, n);
            e.lineTo(o.x1, o.y1), e.lineTo(o.x2, o.y2), e.lineTo(o.x3, o.y3)
        }
        getCaretPosition(t, e, i) {
            const {
                xAlign: n,
                yAlign: o
            } = this, {
                cornerRadius: s,
                caretSize: a
            } = i, {
                x: r,
                y: l
            } = t, {
                width: c,
                height: h
            } = e;
            let d, u, f, g, p, m;
            return "center" === o ? (p = l + h / 2, "left" === n ? (d = r, u = d - a, g = p + a, m = p - a) : (d = r + c, u = d + a, g = p - a, m = p + a), f = d) : (u = "left" === n ? r + s + a : "right" === n ? r + c - s - a : this.caretX, "top" === o ? (g = l, p = g - a, d = u - a, f = u + a) : (g = l + h, p = g + a, d = u + a, f = u - a), m = g), {
                x1: d,
                x2: u,
                x3: f,
                y1: g,
                y2: p,
                y3: m
            }
        }
        drawTitle(t, e, i) {
            const n = this,
                o = n.title,
                s = o.length;
            let a, r, l;
            if (s) {
                const c = Ti(i.rtl, n.x, n.width);
                for (t.x = Es(n, i.titleAlign, i), e.textAlign = c.textAlign(i.titleAlign), e.textBaseline = "middle", a = Ve(i.titleFont), r = i.titleSpacing, e.fillStyle = i.titleColor, e.font = a.string, l = 0; l < s; ++l) e.fillText(o[l], c.x(t.x), t.y + a.lineHeight / 2), t.y += a.lineHeight + r, l + 1 === s && (t.y += i.titleMarginBottom - r)
            }
        }
        _drawColorBox(t, e, i, n, o) {
            const s = this,
                a = s.labelColors[i],
                r = s.labelPointStyles[i],
                {
                    boxHeight: l,
                    boxWidth: c
                } = o,
                h = Ve(o.bodyFont),
                d = Es(s, "left", o),
                u = n.x(d),
                f = l < h.lineHeight ? (h.lineHeight - l) / 2 : 0,
                g = e.y + f;
            if (o.usePointStyle) {
                const e = {
                        radius: Math.min(c, l) / 2,
                        pointStyle: r.pointStyle,
                        rotation: r.rotation,
                        borderWidth: 1
                    },
                    i = n.leftForLtr(u, c) + c / 2,
                    s = g + l / 2;
                t.strokeStyle = o.multiKeyBackground, t.fillStyle = o.multiKeyBackground, Kt(t, e, i, s), t.strokeStyle = a.borderColor, t.fillStyle = a.backgroundColor, Kt(t, e, i, s)
            } else {
                t.lineWidth = a.borderWidth || 1, t.strokeStyle = a.borderColor, t.setLineDash(a.borderDash || []), t.lineDashOffset = a.borderDashOffset || 0;
                const e = n.leftForLtr(u, c),
                    i = n.leftForLtr(n.xPlus(u, 1), c - 2),
                    s = Fe(a.borderRadius);
                Object.values(s).some((t => 0 !== t)) ? (t.beginPath(), t.fillStyle = o.multiKeyBackground, ne(t, {
                    x: e,
                    y: g,
                    w: c,
                    h: l,
                    radius: s
                }), t.fill(), t.stroke(), t.fillStyle = a.backgroundColor, t.beginPath(), ne(t, {
                    x: i,
                    y: g + 1,
                    w: c - 2,
                    h: l - 2,
                    radius: s
                }), t.fill()) : (t.fillStyle = o.multiKeyBackground, t.fillRect(e, g, c, l), t.strokeRect(e, g, c, l), t.fillStyle = a.backgroundColor, t.fillRect(i, g + 1, c - 2, l - 2))
            }
            t.fillStyle = s.labelTextColors[i]
        }
        drawBody(t, e, i) {
            const n = this,
                {
                    body: o
                } = n,
                {
                    bodySpacing: s,
                    bodyAlign: a,
                    displayColors: r,
                    boxHeight: l,
                    boxWidth: c
                } = i,
                h = Ve(i.bodyFont);
            let d = h.lineHeight,
                u = 0;
            const f = Ti(i.rtl, n.x, n.width),
                g = function(i) {
                    e.fillText(i, f.x(t.x + u), t.y + d / 2), t.y += d + s
                },
                p = f.textAlign(a);
            let m, x, b, _, y, v, w;
            for (e.textAlign = a, e.textBaseline = "middle", e.font = h.string, t.x = Es(n, p, i), e.fillStyle = i.bodyColor, J(n.beforeBody, g), u = r && "right" !== p ? "center" === a ? c / 2 + 1 : c + 2 : 0, _ = 0, v = o.length; _ < v; ++_) {
                for (m = o[_], x = n.labelTextColors[_], e.fillStyle = x, J(m.before, g), b = m.lines, r && b.length && (n._drawColorBox(e, t, _, f, i), d = Math.max(h.lineHeight, l)), y = 0, w = b.length; y < w; ++y) g(b[y]), d = h.lineHeight;
                J(m.after, g)
            }
            u = 0, d = h.lineHeight, J(n.afterBody, g), t.y -= s
        }
        drawFooter(t, e, i) {
            const n = this,
                o = n.footer,
                s = o.length;
            let a, r;
            if (s) {
                const l = Ti(i.rtl, n.x, n.width);
                for (t.x = Es(n, i.footerAlign, i), t.y += i.footerMarginTop, e.textAlign = l.textAlign(i.footerAlign), e.textBaseline = "middle", a = Ve(i.footerFont), e.fillStyle = i.footerColor, e.font = a.string, r = 0; r < s; ++r) e.fillText(o[r], l.x(t.x), t.y + a.lineHeight / 2), t.y += a.lineHeight + i.footerSpacing
            }
        }
        drawBackground(t, e, i, n) {
            const {
                xAlign: o,
                yAlign: s
            } = this, {
                x: a,
                y: r
            } = t, {
                width: l,
                height: c
            } = i, h = n.cornerRadius;
            e.fillStyle = n.backgroundColor, e.strokeStyle = n.borderColor, e.lineWidth = n.borderWidth, e.beginPath(), e.moveTo(a + h, r), "top" === s && this.drawCaret(t, e, i, n), e.lineTo(a + l - h, r), e.quadraticCurveTo(a + l, r, a + l, r + h), "center" === s && "right" === o && this.drawCaret(t, e, i, n), e.lineTo(a + l, r + c - h), e.quadraticCurveTo(a + l, r + c, a + l - h, r + c), "bottom" === s && this.drawCaret(t, e, i, n), e.lineTo(a + h, r + c), e.quadraticCurveTo(a, r + c, a, r + c - h), "center" === s && "left" === o && this.drawCaret(t, e, i, n), e.lineTo(a, r + h), e.quadraticCurveTo(a, r, a + h, r), e.closePath(), e.fill(), n.borderWidth > 0 && e.stroke()
        }
        _updateAnimationTarget(t) {
            const e = this,
                i = e._chart,
                n = e.$animations,
                o = n && n.x,
                s = n && n.y;
            if (o || s) {
                const n = Ps[t.position].call(e, e._active, e._eventPosition);
                if (!n) return;
                const a = e._size = Ts(e, t),
                    r = Object.assign({}, n, e._size),
                    l = Ls(i, t, r),
                    c = Rs(t, r, l, i);
                o._to === c.x && s._to === c.y || (e.xAlign = l.xAlign, e.yAlign = l.yAlign, e.width = a.width, e.height = a.height, e.caretX = n.x, e.caretY = n.y, e._resolveAnimations().update(e, c))
            }
        }
        draw(t) {
            const e = this,
                i = e.options.setContext(e.getContext());
            let n = e.opacity;
            if (!n) return;
            e._updateAnimationTarget(i);
            const o = {
                    width: e.width,
                    height: e.height
                },
                s = {
                    x: e.x,
                    y: e.y
                };
            n = Math.abs(n) < .001 ? 0 : n;
            const a = Be(i.padding),
                r = e.title.length || e.beforeBody.length || e.body.length || e.afterBody.length || e.footer.length;
            i.enabled && r && (t.save(), t.globalAlpha = n, e.drawBackground(s, t, o, i), Ai(t, i.textDirection), s.y += a.top, e.drawTitle(s, t, i), e.drawBody(s, t, i), e.drawFooter(s, t, i), Li(t, i.textDirection), t.restore())
        }
        getActiveElements() {
            return this._active || []
        }
        setActiveElements(t, e) {
            const i = this,
                n = i._active,
                o = t.map((({
                    datasetIndex: t,
                    index: e
                }) => {
                    const n = i._chart.getDatasetMeta(t);
                    if (!n) throw new Error("Cannot find a dataset at index " + t);
                    return {
                        datasetIndex: t,
                        element: n.data[e],
                        index: e
                    }
                })),
                s = !tt(n, o),
                a = i._positionChanged(o, e);
            (s || a) && (i._active = o, i._eventPosition = e, i.update(!0))
        }
        handleEvent(t, e) {
            const i = this,
                n = i.options,
                o = i._active || [];
            let s = !1,
                a = [];
            "mouseout" !== t.type && (a = i._chart.getElementsAtEventForMode(t, n.mode, n, e), n.reverse && a.reverse());
            const r = i._positionChanged(a, t);
            return s = e || !tt(a, o) || r, s && (i._active = a, (n.enabled || n.external) && (i._eventPosition = {
                x: t.x,
                y: t.y
            }, i.update(!0, e))), s
        }
        _positionChanged(t, e) {
            const {
                caretX: i,
                caretY: n,
                options: o
            } = this, s = Ps[o.position].call(this, t, e);
            return !1 !== s && (i !== s.x || n !== s.y)
        }
    }
    Fs.positioners = Ps;
    var Bs = {
            id: "tooltip",
            _element: Fs,
            positioners: Ps,
            afterInit(t, e, i) {
                i && (t.tooltip = new Fs({
                    _chart: t,
                    options: i
                }))
            },
            beforeUpdate(t, e, i) {
                t.tooltip && t.tooltip.initialize(i)
            },
            reset(t, e, i) {
                t.tooltip && t.tooltip.initialize(i)
            },
            afterDraw(t) {
                const e = t.tooltip,
                    i = {
                        tooltip: e
                    };
                !1 !== t.notifyPlugins("beforeTooltipDraw", i) && (e && e.draw(t.ctx), t.notifyPlugins("afterTooltipDraw", i))
            },
            afterEvent(t, e) {
                if (t.tooltip) {
                    const i = e.replay;
                    t.tooltip.handleEvent(e.event, i) && (e.changed = !0)
                }
            },
            defaults: {
                enabled: !0,
                external: null,
                position: "average",
                backgroundColor: "rgba(0,0,0,0.8)",
                titleColor: "#fff",
                titleFont: {
                    weight: "bold"
                },
                titleSpacing: 2,
                titleMarginBottom: 6,
                titleAlign: "left",
                bodyColor: "#fff",
                bodySpacing: 2,
                bodyFont: {},
                bodyAlign: "left",
                footerColor: "#fff",
                footerSpacing: 2,
                footerMarginTop: 6,
                footerFont: {
                    weight: "bold"
                },
                footerAlign: "left",
                padding: 6,
                caretPadding: 2,
                caretSize: 5,
                cornerRadius: 6,
                boxHeight: (t, e) => e.bodyFont.size,
                boxWidth: (t, e) => e.bodyFont.size,
                multiKeyBackground: "#fff",
                displayColors: !0,
                borderColor: "rgba(0,0,0,0)",
                borderWidth: 0,
                animation: {
                    duration: 400,
                    easing: "easeOutQuart"
                },
                animations: {
                    numbers: {
                        type: "number",
                        properties: ["x", "y", "width", "height", "caretX", "caretY"]
                    },
                    opacity: {
                        easing: "linear",
                        duration: 200
                    }
                },
                callbacks: {
                    beforeTitle: H,
                    title(t) {
                        if (t.length > 0) {
                            const e = t[0],
                                i = e.chart.data.labels,
                                n = i ? i.length : 0;
                            if (this && this.options && "dataset" === this.options.mode) return e.dataset.label || "";
                            if (e.label) return e.label;
                            if (n > 0 && e.dataIndex < n) return i[e.dataIndex]
                        }
                        return ""
                    },
                    afterTitle: H,
                    beforeBody: H,
                    beforeLabel: H,
                    label(t) {
                        if (this && this.options && "dataset" === this.options.mode) return t.label + ": " + t.formattedValue || t.formattedValue;
                        let e = t.dataset.label || "";
                        e && (e += ": ");
                        const i = t.formattedValue;
                        return $(i) || (e += i), e
                    },
                    labelColor(t) {
                        const e = t.chart.getDatasetMeta(t.datasetIndex).controller.getStyle(t.dataIndex);
                        return {
                            borderColor: e.borderColor,
                            backgroundColor: e.backgroundColor,
                            borderWidth: e.borderWidth,
                            borderDash: e.borderDash,
                            borderDashOffset: e.borderDashOffset,
                            borderRadius: 0
                        }
                    },
                    labelTextColor() {
                        return this.options.bodyColor
                    },
                    labelPointStyle(t) {
                        const e = t.chart.getDatasetMeta(t.datasetIndex).controller.getStyle(t.dataIndex);
                        return {
                            pointStyle: e.pointStyle,
                            rotation: e.rotation
                        }
                    },
                    afterLabel: H,
                    afterBody: H,
                    beforeFooter: H,
                    footer: H,
                    afterFooter: H
                }
            },
            defaultRoutes: {
                bodyFont: "font",
                footerFont: "font",
                titleFont: "font"
            },
            descriptors: {
                _scriptable: t => "filter" !== t && "itemSort" !== t && "external" !== t,
                _indexable: !1,
                callbacks: {
                    _scriptable: !1,
                    _indexable: !1
                },
                animation: {
                    _fallback: !1
                },
                animations: {
                    _fallback: "animation"
                }
            },
            additionalOptionScopes: ["interaction"]
        },
        Vs = Object.freeze({
            __proto__: null,
            Decimation: ts,
            Filler: bs,
            Legend: vs,
            SubTitle: Ss,
            Title: Ms,
            Tooltip: Bs
        });

    function Ws(t, e, i) {
        const n = t.indexOf(e);
        if (-1 === n) return ((t, e, i) => "string" == typeof e ? t.push(e) - 1 : isNaN(e) ? null : i)(t, e, i);
        return n !== t.lastIndexOf(e) ? i : n
    }
    class Ns extends En {
        constructor(t) {
            super(t), this._startValue = void 0, this._valueRange = 0
        }
        parse(t, e) {
            if ($(t)) return null;
            const i = this.getLabels();
            return ((t, e) => null === t ? null : Ht(Math.round(t), 0, e))(e = isFinite(e) && i[e] === t ? e : Ws(i, t, K(e, t)), i.length - 1)
        }
        determineDataLimits() {
            const t = this,
                {
                    minDefined: e,
                    maxDefined: i
                } = t.getUserBounds();
            let {
                min: n,
                max: o
            } = t.getMinMax(!0);
            "ticks" === t.options.bounds && (e || (n = 0), i || (o = t.getLabels().length - 1)), t.min = n, t.max = o
        }
        buildTicks() {
            const t = this,
                e = t.min,
                i = t.max,
                n = t.options.offset,
                o = [];
            let s = t.getLabels();
            s = 0 === e && i === s.length - 1 ? s : s.slice(e, i + 1), t._valueRange = Math.max(s.length - (n ? 0 : 1), 1), t._startValue = t.min - (n ? .5 : 0);
            for (let t = e; t <= i; t++) o.push({
                value: t
            });
            return o
        }
        getLabelForValue(t) {
            const e = this.getLabels();
            return t >= 0 && t < e.length ? e[t] : t
        }
        configure() {
            const t = this;
            super.configure(), t.isHorizontal() || (t._reversePixels = !t._reversePixels)
        }
        getPixelForValue(t) {
            const e = this;
            return "number" != typeof t && (t = e.parse(t)), null === t ? NaN : e.getPixelForDecimal((t - e._startValue) / e._valueRange)
        }
        getPixelForTick(t) {
            const e = this.ticks;
            return t < 0 || t > e.length - 1 ? null : this.getPixelForValue(e[t].value)
        }
        getValueForPixel(t) {
            const e = this;
            return Math.round(e._startValue + e.getDecimalForPixel(t) * e._valueRange)
        }
        getBasePixel() {
            return this.bottom
        }
    }

    function Hs(t, e, {
        horizontal: i,
        minRotation: n
    }) {
        const o = Et(n),
            s = (i ? Math.sin(o) : Math.cos(o)) || .001,
            a = .75 * e * ("" + t).length;
        return Math.min(e / s, a)
    }
    Ns.id = "category", Ns.defaults = {
        ticks: {
            callback: Ns.prototype.getLabelForValue
        }
    };
    class js extends En {
        constructor(t) {
            super(t), this.start = void 0, this.end = void 0, this._startValue = void 0, this._endValue = void 0, this._valueRange = 0
        }
        parse(t, e) {
            return $(t) || ("number" == typeof t || t instanceof Number) && !isFinite(+t) ? null : +t
        }
        handleTickRangeOptions() {
            const t = this,
                {
                    beginAtZero: e
                } = t.options,
                {
                    minDefined: i,
                    maxDefined: n
                } = t.getUserBounds();
            let {
                min: o,
                max: s
            } = t;
            const a = t => o = i ? o : t,
                r = t => s = n ? s : t;
            if (e) {
                const t = Dt(o),
                    e = Dt(s);
                t < 0 && e < 0 ? r(0) : t > 0 && e > 0 && a(0)
            }
            if (o === s) {
                let t = 1;
                (s >= Number.MAX_SAFE_INTEGER || o <= Number.MIN_SAFE_INTEGER) && (t = Math.abs(.05 * s)), r(s + t), e || a(o - t)
            }
            t.min = o, t.max = s
        }
        getTickLimit() {
            const t = this,
                e = t.options.ticks;
            let i, {
                maxTicksLimit: n,
                stepSize: o
            } = e;
            return o ? i = Math.ceil(t.max / o) - Math.floor(t.min / o) + 1 : (i = t.computeTickLimit(), n = n || 11), n && (i = Math.min(n, i)), i
        }
        computeTickLimit() {
            return Number.POSITIVE_INFINITY
        }
        buildTicks() {
            const t = this,
                e = t.options,
                i = e.ticks;
            let n = t.getTickLimit();
            n = Math.max(2, n);
            const o = function(t, e) {
                const i = [],
                    {
                        bounds: n,
                        step: o,
                        min: s,
                        max: a,
                        precision: r,
                        count: l,
                        maxTicks: c,
                        maxDigits: h,
                        includeBounds: d
                    } = t,
                    u = o || 1,
                    f = c - 1,
                    {
                        min: g,
                        max: p
                    } = e,
                    m = !$(s),
                    x = !$(a),
                    b = !$(l),
                    _ = (p - g) / (h + 1);
                let y, v, w, M, k = Ct((p - g) / f / u) * u;
                if (k < 1e-14 && !m && !x) return [{
                    value: g
                }, {
                    value: p
                }];
                M = Math.ceil(p / k) - Math.floor(g / k), M > f && (k = Ct(M * k / f / u) * u), $(r) || (y = Math.pow(10, r), k = Math.ceil(k * y) / y), "ticks" === n ? (v = Math.floor(g / k) * k, w = Math.ceil(p / k) * k) : (v = g, w = p), m && x && o && Lt((a - s) / o, k / 1e3) ? (M = Math.round(Math.min((a - s) / k, c)), k = (a - s) / M, v = s, w = a) : b ? (v = m ? s : v, w = x ? a : w, M = l - 1, k = (w - v) / M) : (M = (w - v) / k, M = At(M, Math.round(M), k / 1e3) ? Math.round(M) : Math.ceil(M));
                const S = Math.max(zt(k), zt(v));
                y = Math.pow(10, $(r) ? S : r), v = Math.round(v * y) / y, w = Math.round(w * y) / y;
                let P = 0;
                for (m && (d && v !== s ? (i.push({
                        value: s
                    }), v < s && P++, At(Math.round((v + P * k) * y) / y, s, Hs(s, _, t)) && P++) : v < s && P++); P < M; ++P) i.push({
                    value: Math.round((v + P * k) * y) / y
                });
                return x && d && w !== a ? At(i[i.length - 1].value, a, Hs(a, _, t)) ? i[i.length - 1].value = a : i.push({
                    value: a
                }) : x && w !== a || i.push({
                    value: w
                }), i
            }({
                maxTicks: n,
                bounds: e.bounds,
                min: e.min,
                max: e.max,
                precision: i.precision,
                step: i.stepSize,
                count: i.count,
                maxDigits: t._maxDigits(),
                horizontal: t.isHorizontal(),
                minRotation: i.minRotation || 0,
                includeBounds: !1 !== i.includeBounds
            }, t._range || t);
            return "ticks" === e.bounds && Rt(o, t, "value"), e.reverse ? (o.reverse(), t.start = t.max, t.end = t.min) : (t.start = t.min, t.end = t.max), o
        }
        configure() {
            const t = this,
                e = t.ticks;
            let i = t.min,
                n = t.max;
            if (super.configure(), t.options.offset && e.length) {
                const t = (n - i) / Math.max(e.length - 1, 1) / 2;
                i -= t, n += t
            }
            t._startValue = i, t._endValue = n, t._valueRange = n - i
        }
        getLabelForValue(t) {
            return Oi(t, this.chart.options.locale)
        }
    }
    class $s extends js {
        determineDataLimits() {
            const t = this,
                {
                    min: e,
                    max: i
                } = t.getMinMax(!0);
            t.min = X(e) ? e : 0, t.max = X(i) ? i : 1, t.handleTickRangeOptions()
        }
        computeTickLimit() {
            const t = this,
                e = t.isHorizontal(),
                i = e ? t.width : t.height,
                n = Et(t.options.ticks.minRotation),
                o = (e ? Math.sin(n) : Math.cos(n)) || .001,
                s = t._resolveTickFontOptions(0);
            return Math.ceil(i / Math.min(40, s.lineHeight / o))
        }
        getPixelForValue(t) {
            return null === t ? NaN : this.getPixelForDecimal((t - this._startValue) / this._valueRange)
        }
        getValueForPixel(t) {
            return this._startValue + this.getDecimalForPixel(t) * this._valueRange
        }
    }

    function Ys(t) {
        return 1 === t / Math.pow(10, Math.floor(Pt(t)))
    }
    $s.id = "linear", $s.defaults = {
        ticks: {
            callback: Sn.formatters.numeric
        }
    };
    class Us extends En {
        constructor(t) {
            super(t), this.start = void 0, this.end = void 0, this._startValue = void 0, this._valueRange = 0
        }
        parse(t, e) {
            const i = js.prototype.parse.apply(this, [t, e]);
            if (0 !== i) return X(i) && i > 0 ? i : null;
            this._zero = !0
        }
        determineDataLimits() {
            const t = this,
                {
                    min: e,
                    max: i
                } = t.getMinMax(!0);
            t.min = X(e) ? Math.max(0, e) : null, t.max = X(i) ? Math.max(0, i) : null, t.options.beginAtZero && (t._zero = !0), t.handleTickRangeOptions()
        }
        handleTickRangeOptions() {
            const t = this,
                {
                    minDefined: e,
                    maxDefined: i
                } = t.getUserBounds();
            let n = t.min,
                o = t.max;
            const s = t => n = e ? n : t,
                a = t => o = i ? o : t,
                r = (t, e) => Math.pow(10, Math.floor(Pt(t)) + e);
            n === o && (n <= 0 ? (s(1), a(10)) : (s(r(n, -1)), a(r(o, 1)))), n <= 0 && s(r(o, -1)), o <= 0 && a(r(n, 1)), t._zero && t.min !== t._suggestedMin && n === r(t.min, 0) && s(r(n, -1)), t.min = n, t.max = o
        }
        buildTicks() {
            const t = this,
                e = t.options,
                i = function(t, e) {
                    const i = Math.floor(Pt(e.max)),
                        n = Math.ceil(e.max / Math.pow(10, i)),
                        o = [];
                    let s = q(t.min, Math.pow(10, Math.floor(Pt(e.min)))),
                        a = Math.floor(Pt(s)),
                        r = Math.floor(s / Math.pow(10, a)),
                        l = a < 0 ? Math.pow(10, Math.abs(a)) : 1;
                    do {
                        o.push({
                            value: s,
                            major: Ys(s)
                        }), ++r, 10 === r && (r = 1, ++a, l = a >= 0 ? 1 : l), s = Math.round(r * Math.pow(10, a) * l) / l
                    } while (a < i || a === i && r < n);
                    const c = q(t.max, s);
                    return o.push({
                        value: c,
                        major: Ys(s)
                    }), o
                }({
                    min: t._userMin,
                    max: t._userMax
                }, t);
            return "ticks" === e.bounds && Rt(i, t, "value"), e.reverse ? (i.reverse(), t.start = t.max, t.end = t.min) : (t.start = t.min, t.end = t.max), i
        }
        getLabelForValue(t) {
            return void 0 === t ? "0" : Oi(t, this.chart.options.locale)
        }
        configure() {
            const t = this,
                e = t.min;
            super.configure(), t._startValue = Pt(e), t._valueRange = Pt(t.max) - Pt(e)
        }
        getPixelForValue(t) {
            const e = this;
            return void 0 !== t && 0 !== t || (t = e.min), null === t || isNaN(t) ? NaN : e.getPixelForDecimal(t === e.min ? 0 : (Pt(t) - e._startValue) / e._valueRange)
        }
        getValueForPixel(t) {
            const e = this,
                i = e.getDecimalForPixel(t);
            return Math.pow(10, e._startValue + i * e._valueRange)
        }
    }

    function Xs(t) {
        const e = t.ticks;
        if (e.display && t.display) {
            const t = Be(e.backdropPadding);
            return K(e.font && e.font.size, xt.font.size) + t.height
        }
        return 0
    }

    function qs(t, e, i, n, o) {
        return t === n || t === o ? {
            start: e - i / 2,
            end: e + i / 2
        } : t < n || t > o ? {
            start: e - i,
            end: e
        } : {
            start: e,
            end: e + i
        }
    }

    function Ks(t) {
        const e = {
                l: 0,
                r: t.width,
                t: 0,
                b: t.height - t.paddingTop
            },
            i = {},
            n = [],
            o = [],
            s = t.getLabels().length;
        for (let c = 0; c < s; c++) {
            const s = t.options.pointLabels.setContext(t.getPointLabelContext(c));
            o[c] = s.padding;
            const h = t.getPointPosition(c, t.drawingArea + o[c]),
                d = Ve(s.font),
                u = (a = t.ctx, r = d, l = Y(l = t._pointLabels[c]) ? l : [l], {
                    w: Ut(a, r.string, l),
                    h: l.length * r.lineHeight
                });
            n[c] = u;
            const f = t.getIndexAngle(c),
                g = It(f),
                p = qs(g, h.x, u.w, 0, 180),
                m = qs(g, h.y, u.h, 90, 270);
            p.start < e.l && (e.l = p.start, i.l = f), p.end > e.r && (e.r = p.end, i.r = f), m.start < e.t && (e.t = m.start, i.t = f), m.end > e.b && (e.b = m.end, i.b = f)
        }
        var a, r, l;
        t._setReductions(t.drawingArea, e, i), t._pointLabelItems = function(t, e, i) {
            const n = [],
                o = t.getLabels().length,
                s = t.options,
                a = Xs(s),
                r = t.getDistanceFromCenterForValue(s.ticks.reverse ? t.min : t.max);
            for (let s = 0; s < o; s++) {
                const o = 0 === s ? a / 2 : 0,
                    l = t.getPointPosition(s, r + o + i[s]),
                    c = It(t.getIndexAngle(s)),
                    h = e[s],
                    d = Qs(l.y, h.h, c),
                    u = Gs(c),
                    f = Zs(l.x, h.w, u);
                n.push({
                    x: l.x,
                    y: d,
                    textAlign: u,
                    left: f,
                    top: d,
                    right: f + h.w,
                    bottom: d + h.h
                })
            }
            return n
        }(t, n, o)
    }

    function Gs(t) {
        return 0 === t || 180 === t ? "center" : t < 180 ? "left" : "right"
    }

    function Zs(t, e, i) {
        return "right" === i ? t -= e : "center" === i && (t -= e / 2), t
    }

    function Qs(t, e, i) {
        return 90 === i || 270 === i ? t -= e / 2 : (i > 270 || i < 90) && (t -= e), t
    }

    function Js(t, e, i, n) {
        const {
            ctx: o
        } = t;
        if (i) o.arc(t.xCenter, t.yCenter, e, 0, _t);
        else {
            let i = t.getPointPosition(0, e);
            o.moveTo(i.x, i.y);
            for (let s = 1; s < n; s++) i = t.getPointPosition(s, e), o.lineTo(i.x, i.y)
        }
    }

    function ta(t) {
        return Tt(t) ? t : 0
    }
    Us.id = "logarithmic", Us.defaults = {
        ticks: {
            callback: Sn.formatters.logarithmic,
            major: {
                enabled: !0
            }
        }
    };
    class ea extends js {
        constructor(t) {
            super(t), this.xCenter = void 0, this.yCenter = void 0, this.drawingArea = void 0, this._pointLabels = [], this._pointLabelItems = []
        }
        setDimensions() {
            const t = this;
            t.width = t.maxWidth, t.height = t.maxHeight, t.paddingTop = Xs(t.options) / 2, t.xCenter = Math.floor(t.width / 2), t.yCenter = Math.floor((t.height - t.paddingTop) / 2), t.drawingArea = Math.min(t.height - t.paddingTop, t.width) / 2
        }
        determineDataLimits() {
            const t = this,
                {
                    min: e,
                    max: i
                } = t.getMinMax(!1);
            t.min = X(e) && !isNaN(e) ? e : 0, t.max = X(i) && !isNaN(i) ? i : 0, t.handleTickRangeOptions()
        }
        computeTickLimit() {
            return Math.ceil(this.drawingArea / Xs(this.options))
        }
        generateTickLabels(t) {
            const e = this;
            js.prototype.generateTickLabels.call(e, t), e._pointLabels = e.getLabels().map(((t, i) => {
                const n = Q(e.options.pointLabels.callback, [t, i], e);
                return n || 0 === n ? n : ""
            }))
        }
        fit() {
            const t = this,
                e = t.options;
            e.display && e.pointLabels.display ? Ks(t) : t.setCenterPoint(0, 0, 0, 0)
        }
        _setReductions(t, e, i) {
            const n = this;
            let o = e.l / Math.sin(i.l),
                s = Math.max(e.r - n.width, 0) / Math.sin(i.r),
                a = -e.t / Math.cos(i.t),
                r = -Math.max(e.b - (n.height - n.paddingTop), 0) / Math.cos(i.b);
            o = ta(o), s = ta(s), a = ta(a), r = ta(r), n.drawingArea = Math.max(t / 2, Math.min(Math.floor(t - (o + s) / 2), Math.floor(t - (a + r) / 2))), n.setCenterPoint(o, s, a, r)
        }
        setCenterPoint(t, e, i, n) {
            const o = this,
                s = o.width - e - o.drawingArea,
                a = t + o.drawingArea,
                r = i + o.drawingArea,
                l = o.height - o.paddingTop - n - o.drawingArea;
            o.xCenter = Math.floor((a + s) / 2 + o.left), o.yCenter = Math.floor((r + l) / 2 + o.top + o.paddingTop)
        }
        getIndexAngle(t) {
            return Wt(t * (_t / this.getLabels().length) + Et(this.options.startAngle || 0))
        }
        getDistanceFromCenterForValue(t) {
            const e = this;
            if ($(t)) return NaN;
            const i = e.drawingArea / (e.max - e.min);
            return e.options.reverse ? (e.max - t) * i : (t - e.min) * i
        }
        getValueForDistanceFromCenter(t) {
            if ($(t)) return NaN;
            const e = this,
                i = t / (e.drawingArea / (e.max - e.min));
            return e.options.reverse ? e.max - i : e.min + i
        }
        getPointLabelContext(t) {
            const e = this,
                i = e._pointLabels || [];
            if (t >= 0 && t < i.length) {
                const n = i[t];
                return function(t, e, i) {
                    return Object.assign(Object.create(t), {
                        label: i,
                        index: e,
                        type: "pointLabel"
                    })
                }(e.getContext(), t, n)
            }
        }
        getPointPosition(t, e) {
            const i = this,
                n = i.getIndexAngle(t) - Mt;
            return {
                x: Math.cos(n) * e + i.xCenter,
                y: Math.sin(n) * e + i.yCenter,
                angle: n
            }
        }
        getPointPositionForValue(t, e) {
            return this.getPointPosition(t, this.getDistanceFromCenterForValue(e))
        }
        getBasePosition(t) {
            return this.getPointPositionForValue(t || 0, this.getBaseValue())
        }
        getPointLabelPosition(t) {
            const {
                left: e,
                top: i,
                right: n,
                bottom: o
            } = this._pointLabelItems[t];
            return {
                left: e,
                top: i,
                right: n,
                bottom: o
            }
        }
        drawBackground() {
            const t = this,
                {
                    backgroundColor: e,
                    grid: {
                        circular: i
                    }
                } = t.options;
            if (e) {
                const n = t.ctx;
                n.save(), n.beginPath(), Js(t, t.getDistanceFromCenterForValue(t._endValue), i, t.getLabels().length), n.closePath(), n.fillStyle = e, n.fill(), n.restore()
            }
        }
        drawGrid() {
            const t = this,
                e = t.ctx,
                i = t.options,
                {
                    angleLines: n,
                    grid: o
                } = i,
                s = t.getLabels().length;
            let a, r, l;
            if (i.pointLabels.display && function(t, e) {
                    const {
                        ctx: i,
                        options: {
                            pointLabels: n
                        }
                    } = t;
                    for (let o = e - 1; o >= 0; o--) {
                        const e = n.setContext(t.getPointLabelContext(o)),
                            s = Ve(e.font),
                            {
                                x: a,
                                y: r,
                                textAlign: l,
                                left: c,
                                top: h,
                                right: d,
                                bottom: u
                            } = t._pointLabelItems[o],
                            {
                                backdropColor: f
                            } = e;
                        if (!$(f)) {
                            const t = Be(e.backdropPadding);
                            i.fillStyle = f, i.fillRect(c - t.left, h - t.top, d - c + t.width, u - h + t.height)
                        }
                        ee(i, t._pointLabels[o], a, r + s.lineHeight / 2, s, {
                            color: e.color,
                            textAlign: l,
                            textBaseline: "middle"
                        })
                    }
                }(t, s), o.display && t.ticks.forEach(((e, i) => {
                    if (0 !== i) {
                        r = t.getDistanceFromCenterForValue(e.value);
                        const n = o.setContext(t.getContext(i - 1));
                        ! function(t, e, i, n) {
                            const o = t.ctx,
                                s = e.circular,
                                {
                                    color: a,
                                    lineWidth: r
                                } = e;
                            !s && !n || !a || !r || i < 0 || (o.save(), o.strokeStyle = a, o.lineWidth = r, o.setLineDash(e.borderDash), o.lineDashOffset = e.borderDashOffset, o.beginPath(), Js(t, i, s, n), o.closePath(), o.stroke(), o.restore())
                        }(t, n, r, s)
                    }
                })), n.display) {
                for (e.save(), a = t.getLabels().length - 1; a >= 0; a--) {
                    const o = n.setContext(t.getPointLabelContext(a)),
                        {
                            color: s,
                            lineWidth: c
                        } = o;
                    c && s && (e.lineWidth = c, e.strokeStyle = s, e.setLineDash(o.borderDash), e.lineDashOffset = o.borderDashOffset, r = t.getDistanceFromCenterForValue(i.ticks.reverse ? t.min : t.max), l = t.getPointPosition(a, r), e.beginPath(), e.moveTo(t.xCenter, t.yCenter), e.lineTo(l.x, l.y), e.stroke())
                }
                e.restore()
            }
        }
        drawBorder() {}
        drawLabels() {
            const t = this,
                e = t.ctx,
                i = t.options,
                n = i.ticks;
            if (!n.display) return;
            const o = t.getIndexAngle(0);
            let s, a;
            e.save(), e.translate(t.xCenter, t.yCenter), e.rotate(o), e.textAlign = "center", e.textBaseline = "middle", t.ticks.forEach(((o, r) => {
                if (0 === r && !i.reverse) return;
                const l = n.setContext(t.getContext(r)),
                    c = Ve(l.font);
                if (s = t.getDistanceFromCenterForValue(t.ticks[r].value), l.showLabelBackdrop) {
                    e.font = c.string, a = e.measureText(o.label).width, e.fillStyle = l.backdropColor;
                    const t = Be(l.backdropPadding);
                    e.fillRect(-a / 2 - t.left, -s - c.size / 2 - t.top, a + t.width, c.size + t.height)
                }
                ee(e, o.label, 0, -s, c, {
                    color: l.color
                })
            })), e.restore()
        }
        drawTitle() {}
    }
    ea.id = "radialLinear", ea.defaults = {
        display: !0,
        animate: !0,
        position: "chartArea",
        angleLines: {
            display: !0,
            lineWidth: 1,
            borderDash: [],
            borderDashOffset: 0
        },
        grid: {
            circular: !1
        },
        startAngle: 0,
        ticks: {
            showLabelBackdrop: !0,
            callback: Sn.formatters.numeric
        },
        pointLabels: {
            backdropColor: void 0,
            backdropPadding: 2,
            display: !0,
            font: {
                size: 10
            },
            callback: t => t,
            padding: 5
        }
    }, ea.defaultRoutes = {
        "angleLines.color": "borderColor",
        "pointLabels.color": "color",
        "ticks.color": "color"
    }, ea.descriptors = {
        angleLines: {
            _fallback: "grid"
        }
    };
    const ia = {
            millisecond: {
                common: !0,
                size: 1,
                steps: 1e3
            },
            second: {
                common: !0,
                size: 1e3,
                steps: 60
            },
            minute: {
                common: !0,
                size: 6e4,
                steps: 60
            },
            hour: {
                common: !0,
                size: 36e5,
                steps: 24
            },
            day: {
                common: !0,
                size: 864e5,
                steps: 30
            },
            week: {
                common: !1,
                size: 6048e5,
                steps: 4
            },
            month: {
                common: !0,
                size: 2628e6,
                steps: 12
            },
            quarter: {
                common: !1,
                size: 7884e6,
                steps: 4
            },
            year: {
                common: !0,
                size: 3154e7
            }
        },
        na = Object.keys(ia);

    function oa(t, e) {
        return t - e
    }

    function sa(t, e) {
        if ($(e)) return null;
        const i = t._adapter,
            {
                parser: n,
                round: o,
                isoWeekday: s
            } = t._parseOpts;
        let a = e;
        return "function" == typeof n && (a = n(a)), X(a) || (a = "string" == typeof n ? i.parse(a, n) : i.parse(a)), null === a ? null : (o && (a = "week" !== o || !Tt(s) && !0 !== s ? i.startOf(a, o) : i.startOf(a, "isoWeek", s)), +a)
    }

    function aa(t, e, i, n) {
        const o = na.length;
        for (let s = na.indexOf(t); s < o - 1; ++s) {
            const t = ia[na[s]],
                o = t.steps ? t.steps : Number.MAX_SAFE_INTEGER;
            if (t.common && Math.ceil((i - e) / (o * t.size)) <= n) return na[s]
        }
        return na[o - 1]
    }

    function ra(t, e, i) {
        if (i) {
            if (i.length) {
                const {
                    lo: n,
                    hi: o
                } = oe(i, e);
                t[i[n] >= e ? i[n] : i[o]] = !0
            }
        } else t[e] = !0
    }

    function la(t, e, i) {
        const n = [],
            o = {},
            s = e.length;
        let a, r;
        for (a = 0; a < s; ++a) r = e[a], o[r] = a, n.push({
            value: r,
            major: !1
        });
        return 0 !== s && i ? function(t, e, i, n) {
            const o = t._adapter,
                s = +o.startOf(e[0].value, n),
                a = e[e.length - 1].value;
            let r, l;
            for (r = s; r <= a; r = +o.add(r, 1, n)) l = i[r], l >= 0 && (e[l].major = !0);
            return e
        }(t, n, o, i) : n
    }
    class ca extends En {
        constructor(t) {
            super(t), this._cache = {
                data: [],
                labels: [],
                all: []
            }, this._unit = "day", this._majorUnit = void 0, this._offsets = {}, this._normalized = !1, this._parseOpts = void 0
        }
        init(t, e) {
            const i = t.time || (t.time = {}),
                n = this._adapter = new co._date(t.adapters.date);
            st(i.displayFormats, n.formats()), this._parseOpts = {
                parser: i.parser,
                round: i.round,
                isoWeekday: i.isoWeekday
            }, super.init(t), this._normalized = e.normalized
        }
        parse(t, e) {
            return void 0 === t ? null : sa(this, t)
        }
        beforeLayout() {
            super.beforeLayout(), this._cache = {
                data: [],
                labels: [],
                all: []
            }
        }
        determineDataLimits() {
            const t = this,
                e = t.options,
                i = t._adapter,
                n = e.time.unit || "day";
            let {
                min: o,
                max: s,
                minDefined: a,
                maxDefined: r
            } = t.getUserBounds();

            function l(t) {
                a || isNaN(t.min) || (o = Math.min(o, t.min)), r || isNaN(t.max) || (s = Math.max(s, t.max))
            }
            a && r || (l(t._getLabelBounds()), "ticks" === e.bounds && "labels" === e.ticks.source || l(t.getMinMax(!1))), o = X(o) && !isNaN(o) ? o : +i.startOf(Date.now(), n), s = X(s) && !isNaN(s) ? s : +i.endOf(Date.now(), n) + 1, t.min = Math.min(o, s - 1), t.max = Math.max(o + 1, s)
        }
        _getLabelBounds() {
            const t = this.getLabelTimestamps();
            let e = Number.POSITIVE_INFINITY,
                i = Number.NEGATIVE_INFINITY;
            return t.length && (e = t[0], i = t[t.length - 1]), {
                min: e,
                max: i
            }
        }
        buildTicks() {
            const t = this,
                e = t.options,
                i = e.time,
                n = e.ticks,
                o = "labels" === n.source ? t.getLabelTimestamps() : t._generate();
            "ticks" === e.bounds && o.length && (t.min = t._userMin || o[0], t.max = t._userMax || o[o.length - 1]);
            const s = t.min,
                a = re(o, s, t.max);
            return t._unit = i.unit || (n.autoSkip ? aa(i.minUnit, t.min, t.max, t._getLabelCapacity(s)) : function(t, e, i, n, o) {
                for (let s = na.length - 1; s >= na.indexOf(i); s--) {
                    const i = na[s];
                    if (ia[i].common && t._adapter.diff(o, n, i) >= e - 1) return i
                }
                return na[i ? na.indexOf(i) : 0]
            }(t, a.length, i.minUnit, t.min, t.max)), t._majorUnit = n.major.enabled && "year" !== t._unit ? function(t) {
                for (let e = na.indexOf(t) + 1, i = na.length; e < i; ++e)
                    if (ia[na[e]].common) return na[e]
            }(t._unit) : void 0, t.initOffsets(o), e.reverse && a.reverse(), la(t, a, t._majorUnit)
        }
        initOffsets(t) {
            const e = this;
            let i, n, o = 0,
                s = 0;
            e.options.offset && t.length && (i = e.getDecimalForValue(t[0]), o = 1 === t.length ? 1 - i : (e.getDecimalForValue(t[1]) - i) / 2, n = e.getDecimalForValue(t[t.length - 1]), s = 1 === t.length ? n : (n - e.getDecimalForValue(t[t.length - 2])) / 2);
            const a = t.length < 3 ? .5 : .25;
            o = Ht(o, 0, a), s = Ht(s, 0, a), e._offsets = {
                start: o,
                end: s,
                factor: 1 / (o + 1 + s)
            }
        }
        _generate() {
            const t = this,
                e = t._adapter,
                i = t.min,
                n = t.max,
                o = t.options,
                s = o.time,
                a = s.unit || aa(s.minUnit, i, n, t._getLabelCapacity(i)),
                r = K(s.stepSize, 1),
                l = "week" === a && s.isoWeekday,
                c = Tt(l) || !0 === l,
                h = {};
            let d, u, f = i;
            if (c && (f = +e.startOf(f, "isoWeek", l)), f = +e.startOf(f, c ? "day" : a), e.diff(n, i, a) > 1e5 * r) throw new Error(i + " and " + n + " are too far apart with stepSize of " + r + " " + a);
            const g = "data" === o.ticks.source && t.getDataTimestamps();
            for (d = f, u = 0; d < n; d = +e.add(d, r, a), u++) ra(h, d, g);
            return d !== n && "ticks" !== o.bounds && 1 !== u || ra(h, d, g), Object.keys(h).sort(((t, e) => t - e)).map((t => +t))
        }
        getLabelForValue(t) {
            const e = this._adapter,
                i = this.options.time;
            return i.tooltipFormat ? e.format(t, i.tooltipFormat) : e.format(t, i.displayFormats.datetime)
        }
        _tickFormatFunction(t, e, i, n) {
            const o = this,
                s = o.options,
                a = s.time.displayFormats,
                r = o._unit,
                l = o._majorUnit,
                c = r && a[r],
                h = l && a[l],
                d = i[e],
                u = l && h && d && d.major,
                f = o._adapter.format(t, n || (u ? h : c)),
                g = s.ticks.callback;
            return g ? Q(g, [f, e, i], o) : f
        }
        generateTickLabels(t) {
            let e, i, n;
            for (e = 0, i = t.length; e < i; ++e) n = t[e], n.label = this._tickFormatFunction(n.value, e, t)
        }
        getDecimalForValue(t) {
            const e = this;
            return null === t ? NaN : (t - e.min) / (e.max - e.min)
        }
        getPixelForValue(t) {
            const e = this,
                i = e._offsets,
                n = e.getDecimalForValue(t);
            return e.getPixelForDecimal((i.start + n) * i.factor)
        }
        getValueForPixel(t) {
            const e = this,
                i = e._offsets,
                n = e.getDecimalForPixel(t) / i.factor - i.end;
            return e.min + n * (e.max - e.min)
        }
        _getLabelSize(t) {
            const e = this,
                i = e.options.ticks,
                n = e.ctx.measureText(t).width,
                o = Et(e.isHorizontal() ? i.maxRotation : i.minRotation),
                s = Math.cos(o),
                a = Math.sin(o),
                r = e._resolveTickFontOptions(0).size;
            return {
                w: n * s + r * a,
                h: n * a + r * s
            }
        }
        _getLabelCapacity(t) {
            const e = this,
                i = e.options.time,
                n = i.displayFormats,
                o = n[i.unit] || n.millisecond,
                s = e._tickFormatFunction(t, 0, la(e, [t], e._majorUnit), o),
                a = e._getLabelSize(s),
                r = Math.floor(e.isHorizontal() ? e.width / a.w : e.height / a.h) - 1;
            return r > 0 ? r : 1
        }
        getDataTimestamps() {
            const t = this;
            let e, i, n = t._cache.data || [];
            if (n.length) return n;
            const o = t.getMatchingVisibleMetas();
            if (t._normalized && o.length) return t._cache.data = o[0].controller.getAllParsedValues(t);
            for (e = 0, i = o.length; e < i; ++e) n = n.concat(o[e].controller.getAllParsedValues(t));
            return t._cache.data = t.normalize(n)
        }
        getLabelTimestamps() {
            const t = this,
                e = t._cache.labels || [];
            let i, n;
            if (e.length) return e;
            const o = t.getLabels();
            for (i = 0, n = o.length; i < n; ++i) e.push(sa(t, o[i]));
            return t._cache.labels = t._normalized ? e : t.normalize(e)
        }
        normalize(t) {
            return de(t.sort(oa))
        }
    }

    function ha(t, e, i) {
        let n, o, s, a, r = 0,
            l = t.length - 1;
        i ? (e >= t[r].pos && e <= t[l].pos && ({
            lo: r,
            hi: l
        } = se(t, "pos", e)), ({
            pos: n,
            time: s
        } = t[r]), ({
            pos: o,
            time: a
        } = t[l])) : (e >= t[r].time && e <= t[l].time && ({
            lo: r,
            hi: l
        } = se(t, "time", e)), ({
            time: n,
            pos: s
        } = t[r]), ({
            time: o,
            pos: a
        } = t[l]));
        const c = o - n;
        return c ? s + (a - s) * (e - n) / c : s
    }
    ca.id = "time", ca.defaults = {
        bounds: "data",
        adapters: {},
        time: {
            parser: !1,
            unit: !1,
            round: !1,
            isoWeekday: !1,
            minUnit: "millisecond",
            displayFormats: {}
        },
        ticks: {
            source: "auto",
            major: {
                enabled: !1
            }
        }
    };
    class da extends ca {
        constructor(t) {
            super(t), this._table = [], this._minPos = void 0, this._tableRange = void 0
        }
        initOffsets() {
            const t = this,
                e = t._getTimestampsForTable(),
                i = t._table = t.buildLookupTable(e);
            t._minPos = ha(i, t.min), t._tableRange = ha(i, t.max) - t._minPos, super.initOffsets(e)
        }
        buildLookupTable(t) {
            const {
                min: e,
                max: i
            } = this, n = [], o = [];
            let s, a, r, l, c;
            for (s = 0, a = t.length; s < a; ++s) l = t[s], l >= e && l <= i && n.push(l);
            if (n.length < 2) return [{
                time: e,
                pos: 0
            }, {
                time: i,
                pos: 1
            }];
            for (s = 0, a = n.length; s < a; ++s) c = n[s + 1], r = n[s - 1], l = n[s], Math.round((c + r) / 2) !== l && o.push({
                time: l,
                pos: s / (a - 1)
            });
            return o
        }
        _getTimestampsForTable() {
            const t = this;
            let e = t._cache.all || [];
            if (e.length) return e;
            const i = t.getDataTimestamps(),
                n = t.getLabelTimestamps();
            return e = i.length && n.length ? t.normalize(i.concat(n)) : i.length ? i : n, e = t._cache.all = e, e
        }
        getDecimalForValue(t) {
            return (ha(this._table, t) - this._minPos) / this._tableRange
        }
        getValueForPixel(t) {
            const e = this,
                i = e._offsets,
                n = e.getDecimalForPixel(t) / i.factor - i.end;
            return ha(e._table, n * e._tableRange + e._minPos, !0)
        }
    }
    da.id = "timeseries", da.defaults = ca.defaults;
    var ua = Object.freeze({
        __proto__: null,
        CategoryScale: Ns,
        LinearScale: $s,
        LogarithmicScale: Us,
        RadialLinearScale: ea,
        TimeScale: ca,
        TimeSeriesScale: da
    });
    return oo.register(Po, ua, Zo, Vs), oo.helpers = {
        ...Ni
    }, oo._adapters = co, oo.Animation = ln, oo.Animations = hn, oo.animator = a, oo.controllers = zn.controllers.items, oo.DatasetController = wn, oo.Element = Mn, oo.elements = Zo, oo.Interaction = Ae, oo.layouts = ti, oo.platforms = sn, oo.Scale = En, oo.Ticks = Sn, Object.assign(oo, Po, ua, Zo, Vs, sn), oo.Chart = oo, "undefined" != typeof window && (window.Chart = oo), oo
}));


var Vue = function(e) {
    "use strict";

    function t(e, t) {
        const n = Object.create(null),
            o = e.split(",");
        for (let r = 0; r < o.length; r++) n[o[r]] = !0;
        return t ? e => !!n[e.toLowerCase()] : e => !!n[e]
    }
    const n = t("Infinity,undefined,NaN,isFinite,isNaN,parseFloat,parseInt,decodeURI,decodeURIComponent,encodeURI,encodeURIComponent,Math,Number,Date,Array,Object,Boolean,String,RegExp,Map,Set,JSON,Intl,BigInt"),
        o = t("itemscope,allowfullscreen,formnovalidate,ismap,nomodule,novalidate,readonly");

    function r(e) {
        return !!e || "" === e
    }

    function s(e) {
        if (N(e)) {
            const t = {};
            for (let n = 0; n < e.length; n++) {
                const o = e[n],
                    r = A(o) ? c(o) : s(o);
                if (r)
                    for (const e in r) t[e] = r[e]
            }
            return t
        }
        return A(e) || M(e) ? e : void 0
    }
    const i = /;(?![^(]*\))/g,
        l = /:(.+)/;

    function c(e) {
        const t = {};
        return e.split(i).forEach((e => {
            if (e) {
                const n = e.split(l);
                n.length > 1 && (t[n[0].trim()] = n[1].trim())
            }
        })), t
    }

    function a(e) {
        let t = "";
        if (A(e)) t = e;
        else if (N(e))
            for (let n = 0; n < e.length; n++) {
                const o = a(e[n]);
                o && (t += o + " ")
            } else if (M(e))
                for (const n in e) e[n] && (t += n + " ");
        return t.trim()
    }
    const u = t("html,body,base,head,link,meta,style,title,address,article,aside,footer,header,h1,h2,h3,h4,h5,h6,nav,section,div,dd,dl,dt,figcaption,figure,picture,hr,img,li,main,ol,p,pre,ul,a,b,abbr,bdi,bdo,br,cite,code,data,dfn,em,i,kbd,mark,q,rp,rt,ruby,s,samp,small,span,strong,sub,sup,time,u,var,wbr,area,audio,map,track,video,embed,object,param,source,canvas,script,noscript,del,ins,caption,col,colgroup,table,thead,tbody,td,th,tr,button,datalist,fieldset,form,input,label,legend,meter,optgroup,option,output,progress,select,textarea,details,dialog,menu,summary,template,blockquote,iframe,tfoot"),
        p = t("svg,animate,animateMotion,animateTransform,circle,clipPath,color-profile,defs,desc,discard,ellipse,feBlend,feColorMatrix,feComponentTransfer,feComposite,feConvolveMatrix,feDiffuseLighting,feDisplacementMap,feDistanceLight,feDropShadow,feFlood,feFuncA,feFuncB,feFuncG,feFuncR,feGaussianBlur,feImage,feMerge,feMergeNode,feMorphology,feOffset,fePointLight,feSpecularLighting,feSpotLight,feTile,feTurbulence,filter,foreignObject,g,hatch,hatchpath,image,line,linearGradient,marker,mask,mesh,meshgradient,meshpatch,meshrow,metadata,mpath,path,pattern,polygon,polyline,radialGradient,rect,set,solidcolor,stop,switch,symbol,text,textPath,title,tspan,unknown,use,view"),
        f = t("area,base,br,col,embed,hr,img,input,link,meta,param,source,track,wbr");

    function d(e, t) {
        if (e === t) return !0;
        let n = O(e),
            o = O(t);
        if (n || o) return !(!n || !o) && e.getTime() === t.getTime();
        if (n = N(e), o = N(t), n || o) return !(!n || !o) && function(e, t) {
            if (e.length !== t.length) return !1;
            let n = !0;
            for (let o = 0; n && o < e.length; o++) n = d(e[o], t[o]);
            return n
        }(e, t);
        if (n = M(e), o = M(t), n || o) {
            if (!n || !o) return !1;
            if (Object.keys(e).length !== Object.keys(t).length) return !1;
            for (const n in e) {
                const o = e.hasOwnProperty(n),
                    r = t.hasOwnProperty(n);
                if (o && !r || !o && r || !d(e[n], t[n])) return !1
            }
        }
        return String(e) === String(t)
    }

    function h(e, t) {
        return e.findIndex((e => d(e, t)))
    }
    const m = (e, t) => t && t.__v_isRef ? m(e, t.value) : E(t) ? {
            [`Map(${t.size})`]: [...t.entries()].reduce(((e, [t, n]) => (e[`${t} =>`] = n, e)), {})
        } : $(t) ? {
            [`Set(${t.size})`]: [...t.values()]
        } : !M(t) || N(t) || B(t) ? t : String(t),
        g = {},
        v = [],
        y = () => {},
        b = () => !1,
        _ = /^on[^a-z]/,
        S = e => _.test(e),
        x = e => e.startsWith("onUpdate:"),
        C = Object.assign,
        w = (e, t) => {
            const n = e.indexOf(t);
            n > -1 && e.splice(n, 1)
        },
        k = Object.prototype.hasOwnProperty,
        T = (e, t) => k.call(e, t),
        N = Array.isArray,
        E = e => "[object Map]" === I(e),
        $ = e => "[object Set]" === I(e),
        O = e => e instanceof Date,
        R = e => "function" == typeof e,
        A = e => "string" == typeof e,
        F = e => "symbol" == typeof e,
        M = e => null !== e && "object" == typeof e,
        P = e => M(e) && R(e.then) && R(e.catch),
        V = Object.prototype.toString,
        I = e => V.call(e),
        B = e => "[object Object]" === I(e),
        L = e => A(e) && "NaN" !== e && "-" !== e[0] && "" + parseInt(e, 10) === e,
        j = t(",key,ref,onVnodeBeforeMount,onVnodeMounted,onVnodeBeforeUpdate,onVnodeUpdated,onVnodeBeforeUnmount,onVnodeUnmounted"),
        U = e => {
            const t = Object.create(null);
            return n => t[n] || (t[n] = e(n))
        },
        H = /-(\w)/g,
        D = U((e => e.replace(H, ((e, t) => t ? t.toUpperCase() : "")))),
        W = /\B([A-Z])/g,
        z = U((e => e.replace(W, "-$1").toLowerCase())),
        K = U((e => e.charAt(0).toUpperCase() + e.slice(1))),
        G = U((e => e ? `on${K(e)}` : "")),
        q = (e, t) => !Object.is(e, t),
        J = (e, t) => {
            for (let n = 0; n < e.length; n++) e[n](t)
        },
        Y = (e, t, n) => {
            Object.defineProperty(e, t, {
                configurable: !0,
                enumerable: !1,
                value: n
            })
        },
        Z = e => {
            const t = parseFloat(e);
            return isNaN(t) ? e : t
        };
    let Q;
    let X;
    const ee = [];
    class te {
        constructor(e = !1) {
            this.active = !0, this.effects = [], this.cleanups = [], !e && X && (this.parent = X, this.index = (X.scopes || (X.scopes = [])).push(this) - 1)
        }
        run(e) {
            if (this.active) try {
                return this.on(), e()
            } finally {
                this.off()
            }
        }
        on() {
            this.active && (ee.push(this), X = this)
        }
        off() {
            this.active && (ee.pop(), X = ee[ee.length - 1])
        }
        stop(e) {
            if (this.active) {
                if (this.effects.forEach((e => e.stop())), this.cleanups.forEach((e => e())), this.scopes && this.scopes.forEach((e => e.stop(!0))), this.parent && !e) {
                    const e = this.parent.scopes.pop();
                    e && e !== this && (this.parent.scopes[this.index] = e, e.index = this.index)
                }
                this.active = !1
            }
        }
    }

    function ne(e, t) {
        (t = t || X) && t.active && t.effects.push(e)
    }
    const oe = e => {
            const t = new Set(e);
            return t.w = 0, t.n = 0, t
        },
        re = e => (e.w & ce) > 0,
        se = e => (e.n & ce) > 0,
        ie = new WeakMap;
    let le = 0,
        ce = 1;
    const ae = [];
    let ue;
    const pe = Symbol(""),
        fe = Symbol("");
    class de {
        constructor(e, t = null, n) {
            this.fn = e, this.scheduler = t, this.active = !0, this.deps = [], ne(this, n)
        }
        run() {
            if (!this.active) return this.fn();
            if (!ae.includes(this)) try {
                return ae.push(ue = this), ge.push(me), me = !0, ce = 1 << ++le, le <= 30 ? (({
                    deps: e
                }) => {
                    if (e.length)
                        for (let t = 0; t < e.length; t++) e[t].w |= ce
                })(this) : he(this), this.fn()
            } finally {
                le <= 30 && (e => {
                    const {
                        deps: t
                    } = e;
                    if (t.length) {
                        let n = 0;
                        for (let o = 0; o < t.length; o++) {
                            const r = t[o];
                            re(r) && !se(r) ? r.delete(e) : t[n++] = r, r.w &= ~ce, r.n &= ~ce
                        }
                        t.length = n
                    }
                })(this), ce = 1 << --le, ye(), ae.pop();
                const e = ae.length;
                ue = e > 0 ? ae[e - 1] : void 0
            }
        }
        stop() {
            this.active && (he(this), this.onStop && this.onStop(), this.active = !1)
        }
    }

    function he(e) {
        const {
            deps: t
        } = e;
        if (t.length) {
            for (let n = 0; n < t.length; n++) t[n].delete(e);
            t.length = 0
        }
    }
    let me = !0;
    const ge = [];

    function ve() {
        ge.push(me), me = !1
    }

    function ye() {
        const e = ge.pop();
        me = void 0 === e || e
    }

    function be(e, t, n) {
        if (!_e()) return;
        let o = ie.get(e);
        o || ie.set(e, o = new Map);
        let r = o.get(n);
        r || o.set(n, r = oe()), Se(r)
    }

    function _e() {
        return me && void 0 !== ue
    }

    function Se(e, t) {
        let n = !1;
        le <= 30 ? se(e) || (e.n |= ce, n = !re(e)) : n = !e.has(ue), n && (e.add(ue), ue.deps.push(e))
    }

    function xe(e, t, n, o, r, s) {
        const i = ie.get(e);
        if (!i) return;
        let l = [];
        if ("clear" === t) l = [...i.values()];
        else if ("length" === n && N(e)) i.forEach(((e, t) => {
            ("length" === t || t >= o) && l.push(e)
        }));
        else switch (void 0 !== n && l.push(i.get(n)), t) {
            case "add":
                N(e) ? L(n) && l.push(i.get("length")) : (l.push(i.get(pe)), E(e) && l.push(i.get(fe)));
                break;
            case "delete":
                N(e) || (l.push(i.get(pe)), E(e) && l.push(i.get(fe)));
                break;
            case "set":
                E(e) && l.push(i.get(pe))
        }
        if (1 === l.length) l[0] && Ce(l[0]);
        else {
            const e = [];
            for (const t of l) t && e.push(...t);
            Ce(oe(e))
        }
    }

    function Ce(e, t) {
        for (const n of N(e) ? e : [...e])(n !== ue || n.allowRecurse) && (n.scheduler ? n.scheduler() : n.run())
    }
    const we = t("__proto__,__v_isRef,__isVue"),
        ke = new Set(Object.getOwnPropertyNames(Symbol).map((e => Symbol[e])).filter(F)),
        Te = Ae(),
        Ne = Ae(!1, !0),
        Ee = Ae(!0),
        $e = Ae(!0, !0),
        Oe = Re();

    function Re() {
        const e = {};
        return ["includes", "indexOf", "lastIndexOf"].forEach((t => {
            e[t] = function(...e) {
                const n = yt(this);
                for (let t = 0, r = this.length; t < r; t++) be(n, 0, t + "");
                const o = n[t](...e);
                return -1 === o || !1 === o ? n[t](...e.map(yt)) : o
            }
        })), ["push", "pop", "shift", "unshift", "splice"].forEach((t => {
            e[t] = function(...e) {
                ve();
                const n = yt(this)[t].apply(this, e);
                return ye(), n
            }
        })), e
    }

    function Ae(e = !1, t = !1) {
        return function(n, o, r) {
            if ("__v_isReactive" === o) return !e;
            if ("__v_isReadonly" === o) return e;
            if ("__v_raw" === o && r === (e ? t ? at : ct : t ? lt : it).get(n)) return n;
            const s = N(n);
            if (!e && s && T(Oe, o)) return Reflect.get(Oe, o, r);
            const i = Reflect.get(n, o, r);
            if (F(o) ? ke.has(o) : we(o)) return i;
            if (e || be(n, 0, o), t) return i;
            if (wt(i)) {
                return !s || !L(o) ? i.value : i
            }
            return M(i) ? e ? dt(i) : pt(i) : i
        }
    }

    function Fe(e = !1) {
        return function(t, n, o, r) {
            let s = t[n];
            if (!e && (o = yt(o), s = yt(s), !N(t) && wt(s) && !wt(o))) return s.value = o, !0;
            const i = N(t) && L(n) ? Number(n) < t.length : T(t, n),
                l = Reflect.set(t, n, o, r);
            return t === yt(r) && (i ? q(o, s) && xe(t, "set", n, o) : xe(t, "add", n, o)), l
        }
    }
    const Me = {
            get: Te,
            set: Fe(),
            deleteProperty: function(e, t) {
                const n = T(e, t),
                    o = Reflect.deleteProperty(e, t);
                return o && n && xe(e, "delete", t, void 0), o
            },
            has: function(e, t) {
                const n = Reflect.has(e, t);
                return F(t) && ke.has(t) || be(e, 0, t), n
            },
            ownKeys: function(e) {
                return be(e, 0, N(e) ? "length" : pe), Reflect.ownKeys(e)
            }
        },
        Pe = {
            get: Ee,
            set: (e, t) => !0,
            deleteProperty: (e, t) => !0
        },
        Ve = C({}, Me, {
            get: Ne,
            set: Fe(!0)
        }),
        Ie = C({}, Pe, {
            get: $e
        }),
        Be = e => e,
        Le = e => Reflect.getPrototypeOf(e);

    function je(e, t, n = !1, o = !1) {
        const r = yt(e = e.__v_raw),
            s = yt(t);
        t !== s && !n && be(r, 0, t), !n && be(r, 0, s);
        const {
            has: i
        } = Le(r), l = o ? Be : n ? St : _t;
        return i.call(r, t) ? l(e.get(t)) : i.call(r, s) ? l(e.get(s)) : void(e !== r && e.get(t))
    }

    function Ue(e, t = !1) {
        const n = this.__v_raw,
            o = yt(n),
            r = yt(e);
        return e !== r && !t && be(o, 0, e), !t && be(o, 0, r), e === r ? n.has(e) : n.has(e) || n.has(r)
    }

    function He(e, t = !1) {
        return e = e.__v_raw, !t && be(yt(e), 0, pe), Reflect.get(e, "size", e)
    }

    function De(e) {
        e = yt(e);
        const t = yt(this);
        return Le(t).has.call(t, e) || (t.add(e), xe(t, "add", e, e)), this
    }

    function We(e, t) {
        t = yt(t);
        const n = yt(this),
            {
                has: o,
                get: r
            } = Le(n);
        let s = o.call(n, e);
        s || (e = yt(e), s = o.call(n, e));
        const i = r.call(n, e);
        return n.set(e, t), s ? q(t, i) && xe(n, "set", e, t) : xe(n, "add", e, t), this
    }

    function ze(e) {
        const t = yt(this),
            {
                has: n,
                get: o
            } = Le(t);
        let r = n.call(t, e);
        r || (e = yt(e), r = n.call(t, e)), o && o.call(t, e);
        const s = t.delete(e);
        return r && xe(t, "delete", e, void 0), s
    }

    function Ke() {
        const e = yt(this),
            t = 0 !== e.size,
            n = e.clear();
        return t && xe(e, "clear", void 0, void 0), n
    }

    function Ge(e, t) {
        return function(n, o) {
            const r = this,
                s = r.__v_raw,
                i = yt(s),
                l = t ? Be : e ? St : _t;
            return !e && be(i, 0, pe), s.forEach(((e, t) => n.call(o, l(e), l(t), r)))
        }
    }

    function qe(e, t, n) {
        return function(...o) {
            const r = this.__v_raw,
                s = yt(r),
                i = E(s),
                l = "entries" === e || e === Symbol.iterator && i,
                c = "keys" === e && i,
                a = r[e](...o),
                u = n ? Be : t ? St : _t;
            return !t && be(s, 0, c ? fe : pe), {
                next() {
                    const {
                        value: e,
                        done: t
                    } = a.next();
                    return t ? {
                        value: e,
                        done: t
                    } : {
                        value: l ? [u(e[0]), u(e[1])] : u(e),
                        done: t
                    }
                },
                [Symbol.iterator]() {
                    return this
                }
            }
        }
    }

    function Je(e) {
        return function(...t) {
            return "delete" !== e && this
        }
    }

    function Ye() {
        const e = {
                get(e) {
                    return je(this, e)
                },
                get size() {
                    return He(this)
                },
                has: Ue,
                add: De,
                set: We,
                delete: ze,
                clear: Ke,
                forEach: Ge(!1, !1)
            },
            t = {
                get(e) {
                    return je(this, e, !1, !0)
                },
                get size() {
                    return He(this)
                },
                has: Ue,
                add: De,
                set: We,
                delete: ze,
                clear: Ke,
                forEach: Ge(!1, !0)
            },
            n = {
                get(e) {
                    return je(this, e, !0)
                },
                get size() {
                    return He(this, !0)
                },
                has(e) {
                    return Ue.call(this, e, !0)
                },
                add: Je("add"),
                set: Je("set"),
                delete: Je("delete"),
                clear: Je("clear"),
                forEach: Ge(!0, !1)
            },
            o = {
                get(e) {
                    return je(this, e, !0, !0)
                },
                get size() {
                    return He(this, !0)
                },
                has(e) {
                    return Ue.call(this, e, !0)
                },
                add: Je("add"),
                set: Je("set"),
                delete: Je("delete"),
                clear: Je("clear"),
                forEach: Ge(!0, !0)
            };
        return ["keys", "values", "entries", Symbol.iterator].forEach((r => {
            e[r] = qe(r, !1, !1), n[r] = qe(r, !0, !1), t[r] = qe(r, !1, !0), o[r] = qe(r, !0, !0)
        })), [e, n, t, o]
    }
    const [Ze, Qe, Xe, et] = Ye();

    function tt(e, t) {
        const n = t ? e ? et : Xe : e ? Qe : Ze;
        return (t, o, r) => "__v_isReactive" === o ? !e : "__v_isReadonly" === o ? e : "__v_raw" === o ? t : Reflect.get(T(n, o) && o in t ? n : t, o, r)
    }
    const nt = {
            get: tt(!1, !1)
        },
        ot = {
            get: tt(!1, !0)
        },
        rt = {
            get: tt(!0, !1)
        },
        st = {
            get: tt(!0, !0)
        },
        it = new WeakMap,
        lt = new WeakMap,
        ct = new WeakMap,
        at = new WeakMap;

    function ut(e) {
        return e.__v_skip || !Object.isExtensible(e) ? 0 : function(e) {
            switch (e) {
                case "Object":
                case "Array":
                    return 1;
                case "Map":
                case "Set":
                case "WeakMap":
                case "WeakSet":
                    return 2;
                default:
                    return 0
            }
        }((e => I(e).slice(8, -1))(e))
    }

    function pt(e) {
        return e && e.__v_isReadonly ? e : ht(e, !1, Me, nt, it)
    }

    function ft(e) {
        return ht(e, !1, Ve, ot, lt)
    }

    function dt(e) {
        return ht(e, !0, Pe, rt, ct)
    }

    function ht(e, t, n, o, r) {
        if (!M(e)) return e;
        if (e.__v_raw && (!t || !e.__v_isReactive)) return e;
        const s = r.get(e);
        if (s) return s;
        const i = ut(e);
        if (0 === i) return e;
        const l = new Proxy(e, 2 === i ? o : n);
        return r.set(e, l), l
    }

    function mt(e) {
        return gt(e) ? mt(e.__v_raw) : !(!e || !e.__v_isReactive)
    }

    function gt(e) {
        return !(!e || !e.__v_isReadonly)
    }

    function vt(e) {
        return mt(e) || gt(e)
    }

    function yt(e) {
        const t = e && e.__v_raw;
        return t ? yt(t) : e
    }

    function bt(e) {
        return Y(e, "__v_skip", !0), e
    }
    const _t = e => M(e) ? pt(e) : e,
        St = e => M(e) ? dt(e) : e;

    function xt(e) {
        _e() && ((e = yt(e)).dep || (e.dep = oe()), Se(e.dep))
    }

    function Ct(e, t) {
        (e = yt(e)).dep && Ce(e.dep)
    }

    function wt(e) {
        return Boolean(e && !0 === e.__v_isRef)
    }

    function kt(e) {
        return Tt(e, !1)
    }

    function Tt(e, t) {
        return wt(e) ? e : new Nt(e, t)
    }
    class Nt {
        constructor(e, t) {
            this._shallow = t, this.dep = void 0, this.__v_isRef = !0, this._rawValue = t ? e : yt(e), this._value = t ? e : _t(e)
        }
        get value() {
            return xt(this), this._value
        }
        set value(e) {
            e = this._shallow ? e : yt(e), q(e, this._rawValue) && (this._rawValue = e, this._value = this._shallow ? e : _t(e), Ct(this))
        }
    }

    function Et(e) {
        return wt(e) ? e.value : e
    }
    const $t = {
        get: (e, t, n) => Et(Reflect.get(e, t, n)),
        set: (e, t, n, o) => {
            const r = e[t];
            return wt(r) && !wt(n) ? (r.value = n, !0) : Reflect.set(e, t, n, o)
        }
    };

    function Ot(e) {
        return mt(e) ? e : new Proxy(e, $t)
    }
    class Rt {
        constructor(e) {
            this.dep = void 0, this.__v_isRef = !0;
            const {
                get: t,
                set: n
            } = e((() => xt(this)), (() => Ct(this)));
            this._get = t, this._set = n
        }
        get value() {
            return this._get()
        }
        set value(e) {
            this._set(e)
        }
    }
    class At {
        constructor(e, t) {
            this._object = e, this._key = t, this.__v_isRef = !0
        }
        get value() {
            return this._object[this._key]
        }
        set value(e) {
            this._object[this._key] = e
        }
    }

    function Ft(e, t) {
        const n = e[t];
        return wt(n) ? n : new At(e, t)
    }
    class Mt {
        constructor(e, t, n) {
            this._setter = t, this.dep = void 0, this._dirty = !0, this.__v_isRef = !0, this.effect = new de(e, (() => {
                this._dirty || (this._dirty = !0, Ct(this))
            })), this.__v_isReadonly = n
        }
        get value() {
            const e = yt(this);
            return xt(e), e._dirty && (e._dirty = !1, e._value = e.effect.run()), e._value
        }
        set value(e) {
            this._setter(e)
        }
    }

    function Pt(e, t) {
        let n, o;
        const r = R(e);
        r ? (n = e, o = y) : (n = e.get, o = e.set);
        return new Mt(n, o, r || !o)
    }
    let Vt = [];

    function It(e, t, ...n) {
        const o = e.vnode.props || g;
        let r = n;
        const s = t.startsWith("update:"),
            i = s && t.slice(7);
        if (i && i in o) {
            const e = `${"modelValue"===i?"model":i}Modifiers`,
                {
                    number: t,
                    trim: s
                } = o[e] || g;
            s ? r = n.map((e => e.trim())) : t && (r = n.map(Z))
        }
        let l, c = o[l = G(t)] || o[l = G(D(t))];
        !c && s && (c = o[l = G(z(t))]), c && Or(c, e, 6, r);
        const a = o[l + "Once"];
        if (a) {
            if (e.emitted) {
                if (e.emitted[l]) return
            } else e.emitted = {};
            e.emitted[l] = !0, Or(a, e, 6, r)
        }
    }

    function Bt(e, t, n = !1) {
        const o = t.emitsCache,
            r = o.get(e);
        if (void 0 !== r) return r;
        const s = e.emits;
        let i = {},
            l = !1;
        if (!R(e)) {
            const o = e => {
                const n = Bt(e, t, !0);
                n && (l = !0, C(i, n))
            };
            !n && t.mixins.length && t.mixins.forEach(o), e.extends && o(e.extends), e.mixins && e.mixins.forEach(o)
        }
        return s || l ? (N(s) ? s.forEach((e => i[e] = null)) : C(i, s), o.set(e, i), i) : (o.set(e, null), null)
    }

    function Lt(e, t) {
        return !(!e || !S(t)) && (t = t.slice(2).replace(/Once$/, ""), T(e, t[0].toLowerCase() + t.slice(1)) || T(e, z(t)) || T(e, t))
    }
    let jt = null,
        Ut = null;

    function Ht(e) {
        const t = jt;
        return jt = e, Ut = e && e.type.__scopeId || null, t
    }

    function Dt(e, t = jt, n) {
        if (!t) return e;
        if (e._n) return e;
        const o = (...n) => {
            o._d && jo(-1);
            const r = Ht(t),
                s = e(...n);
            return Ht(r), o._d && jo(1), s
        };
        return o._n = !0, o._c = !0, o._d = !0, o
    }

    function Wt(e) {
        const {
            type: t,
            vnode: n,
            proxy: o,
            withProxy: r,
            props: s,
            propsOptions: [i],
            slots: l,
            attrs: c,
            emit: a,
            render: u,
            renderCache: p,
            data: f,
            setupState: d,
            ctx: h,
            inheritAttrs: m
        } = e;
        let g, v;
        const y = Ht(e);
        try {
            if (4 & n.shapeFlag) {
                const e = r || o;
                g = Xo(u.call(e, e, p, s, d, f, h)), v = c
            } else {
                const e = t;
                0, g = Xo(e(s, e.length > 1 ? {
                    attrs: c,
                    slots: l,
                    emit: a
                } : null)), v = t.props ? c : zt(c)
            }
        } catch (_) {
            Po.length = 0, Rr(_, e, 1), g = Jo(Fo)
        }
        let b = g;
        if (v && !1 !== m) {
            const e = Object.keys(v),
                {
                    shapeFlag: t
                } = b;
            e.length && 7 & t && (i && e.some(x) && (v = Kt(v, i)), b = Zo(b, v))
        }
        return n.dirs && (b.dirs = b.dirs ? b.dirs.concat(n.dirs) : n.dirs), n.transition && (b.transition = n.transition), g = b, Ht(y), g
    }
    const zt = e => {
            let t;
            for (const n in e)("class" === n || "style" === n || S(n)) && ((t || (t = {}))[n] = e[n]);
            return t
        },
        Kt = (e, t) => {
            const n = {};
            for (const o in e) x(o) && o.slice(9) in t || (n[o] = e[o]);
            return n
        };

    function Gt(e, t, n) {
        const o = Object.keys(t);
        if (o.length !== Object.keys(e).length) return !0;
        for (let r = 0; r < o.length; r++) {
            const s = o[r];
            if (t[s] !== e[s] && !Lt(n, s)) return !0
        }
        return !1
    }

    function qt({
        vnode: e,
        parent: t
    }, n) {
        for (; t && t.subTree === e;)(e = t.vnode).el = n, t = t.parent
    }
    const Jt = {
        name: "Suspense",
        __isSuspense: !0,
        process(e, t, n, o, r, s, i, l, c, a) {
            null == e ? function(e, t, n, o, r, s, i, l, c) {
                const {
                    p: a,
                    o: {
                        createElement: u
                    }
                } = c, p = u("div"), f = e.suspense = Zt(e, r, o, t, p, n, s, i, l, c);
                a(null, f.pendingBranch = e.ssContent, p, null, o, f, s, i), f.deps > 0 ? (Yt(e, "onPending"), Yt(e, "onFallback"), a(null, e.ssFallback, t, n, o, null, s, i), en(f, e.ssFallback)) : f.resolve()
            }(t, n, o, r, s, i, l, c, a) : function(e, t, n, o, r, s, i, l, {
                p: c,
                um: a,
                o: {
                    createElement: u
                }
            }) {
                const p = t.suspense = e.suspense;
                p.vnode = t, t.el = e.el;
                const f = t.ssContent,
                    d = t.ssFallback,
                    {
                        activeBranch: h,
                        pendingBranch: m,
                        isInFallback: g,
                        isHydrating: v
                    } = p;
                if (m) p.pendingBranch = f, Wo(f, m) ? (c(m, f, p.hiddenContainer, null, r, p, s, i, l), p.deps <= 0 ? p.resolve() : g && (c(h, d, n, o, r, null, s, i, l), en(p, d))) : (p.pendingId++, v ? (p.isHydrating = !1, p.activeBranch = m) : a(m, r, p), p.deps = 0, p.effects.length = 0, p.hiddenContainer = u("div"), g ? (c(null, f, p.hiddenContainer, null, r, p, s, i, l), p.deps <= 0 ? p.resolve() : (c(h, d, n, o, r, null, s, i, l), en(p, d))) : h && Wo(f, h) ? (c(h, f, n, o, r, p, s, i, l), p.resolve(!0)) : (c(null, f, p.hiddenContainer, null, r, p, s, i, l), p.deps <= 0 && p.resolve()));
                else if (h && Wo(f, h)) c(h, f, n, o, r, p, s, i, l), en(p, f);
                else if (Yt(t, "onPending"), p.pendingBranch = f, p.pendingId++, c(null, f, p.hiddenContainer, null, r, p, s, i, l), p.deps <= 0) p.resolve();
                else {
                    const {
                        timeout: e,
                        pendingId: t
                    } = p;
                    e > 0 ? setTimeout((() => {
                        p.pendingId === t && p.fallback(d)
                    }), e) : 0 === e && p.fallback(d)
                }
            }(e, t, n, o, r, i, l, c, a)
        },
        hydrate: function(e, t, n, o, r, s, i, l, c) {
            const a = t.suspense = Zt(t, o, n, e.parentNode, document.createElement("div"), null, r, s, i, l, !0),
                u = c(e, a.pendingBranch = t.ssContent, n, a, s, i);
            0 === a.deps && a.resolve();
            return u
        },
        create: Zt,
        normalize: function(e) {
            const {
                shapeFlag: t,
                children: n
            } = e, o = 32 & t;
            e.ssContent = Qt(o ? n.default : n), e.ssFallback = o ? Qt(n.fallback) : Jo(Fo)
        }
    };

    function Yt(e, t) {
        const n = e.props && e.props[t];
        R(n) && n()
    }

    function Zt(e, t, n, o, r, s, i, l, c, a, u = !1) {
        const {
            p: p,
            m: f,
            um: d,
            n: h,
            o: {
                parentNode: m,
                remove: g
            }
        } = a, v = Z(e.props && e.props.timeout), y = {
            vnode: e,
            parent: t,
            parentComponent: n,
            isSVG: i,
            container: o,
            hiddenContainer: r,
            anchor: s,
            deps: 0,
            pendingId: 0,
            timeout: "number" == typeof v ? v : -1,
            activeBranch: null,
            pendingBranch: null,
            isInFallback: !0,
            isHydrating: u,
            isUnmounted: !1,
            effects: [],
            resolve(e = !1) {
                const {
                    vnode: t,
                    activeBranch: n,
                    pendingBranch: o,
                    pendingId: r,
                    effects: s,
                    parentComponent: i,
                    container: l
                } = y;
                if (y.isHydrating) y.isHydrating = !1;
                else if (!e) {
                    const e = n && o.transition && "out-in" === o.transition.mode;
                    e && (n.transition.afterLeave = () => {
                        r === y.pendingId && f(o, l, t, 0)
                    });
                    let {
                        anchor: t
                    } = y;
                    n && (t = h(n), d(n, i, y, !0)), e || f(o, l, t, 0)
                }
                en(y, o), y.pendingBranch = null, y.isInFallback = !1;
                let c = y.parent,
                    a = !1;
                for (; c;) {
                    if (c.pendingBranch) {
                        c.effects.push(...s), a = !0;
                        break
                    }
                    c = c.parent
                }
                a || Jr(s), y.effects = [], Yt(t, "onResolve")
            },
            fallback(e) {
                if (!y.pendingBranch) return;
                const {
                    vnode: t,
                    activeBranch: n,
                    parentComponent: o,
                    container: r,
                    isSVG: s
                } = y;
                Yt(t, "onFallback");
                const i = h(n),
                    a = () => {
                        y.isInFallback && (p(null, e, r, i, o, null, s, l, c), en(y, e))
                    },
                    u = e.transition && "out-in" === e.transition.mode;
                u && (n.transition.afterLeave = a), y.isInFallback = !0, d(n, o, null, !0), u || a()
            },
            move(e, t, n) {
                y.activeBranch && f(y.activeBranch, e, t, n), y.container = e
            },
            next: () => y.activeBranch && h(y.activeBranch),
            registerDep(e, t) {
                const n = !!y.pendingBranch;
                n && y.deps++;
                const o = e.vnode.el;
                e.asyncDep.catch((t => {
                    Rr(t, e, 0)
                })).then((r => {
                    if (e.isUnmounted || y.isUnmounted || y.pendingId !== e.suspenseId) return;
                    e.asyncResolved = !0;
                    const {
                        vnode: s
                    } = e;
                    yr(e, r, !1), o && (s.el = o);
                    const l = !o && e.subTree.el;
                    t(e, s, m(o || e.subTree.el), o ? null : h(e.subTree), y, i, c), l && g(l), qt(e, s.el), n && 0 == --y.deps && y.resolve()
                }))
            },
            unmount(e, t) {
                y.isUnmounted = !0, y.activeBranch && d(y.activeBranch, n, e, t), y.pendingBranch && d(y.pendingBranch, n, e, t)
            }
        };
        return y
    }

    function Qt(e) {
        let t;
        if (R(e)) {
            const n = Lo && e._c;
            n && (e._d = !1, Io()), e = e(), n && (e._d = !0, t = Vo, Bo())
        }
        if (N(e)) {
            const t = function(e) {
                let t;
                for (let n = 0; n < e.length; n++) {
                    const o = e[n];
                    if (!Do(o)) return;
                    if (o.type !== Fo || "v-if" === o.children) {
                        if (t) return;
                        t = o
                    }
                }
                return t
            }(e);
            e = t
        }
        return e = Xo(e), t && !e.dynamicChildren && (e.dynamicChildren = t.filter((t => t !== e))), e
    }

    function Xt(e, t) {
        t && t.pendingBranch ? N(e) ? t.effects.push(...e) : t.effects.push(e) : Jr(e)
    }

    function en(e, t) {
        e.activeBranch = t;
        const {
            vnode: n,
            parentComponent: o
        } = e, r = n.el = t.el;
        o && o.subTree === n && (o.vnode.el = r, qt(o, r))
    }

    function tn(e, t) {
        if (ur) {
            let n = ur.provides;
            const o = ur.parent && ur.parent.provides;
            o === n && (n = ur.provides = Object.create(o)), n[e] = t
        } else;
    }

    function nn(e, t, n = !1) {
        const o = ur || jt;
        if (o) {
            const r = null == o.parent ? o.vnode.appContext && o.vnode.appContext.provides : o.parent.provides;
            if (r && e in r) return r[e];
            if (arguments.length > 1) return n && R(t) ? t.call(o.proxy) : t
        }
    }

    function on() {
        const e = {
            isMounted: !1,
            isLeaving: !1,
            isUnmounting: !1,
            leavingVNodes: new Map
        };
        return En((() => {
            e.isMounted = !0
        })), Rn((() => {
            e.isUnmounting = !0
        })), e
    }
    const rn = [Function, Array],
        sn = {
            name: "BaseTransition",
            props: {
                mode: String,
                appear: Boolean,
                persisted: Boolean,
                onBeforeEnter: rn,
                onEnter: rn,
                onAfterEnter: rn,
                onEnterCancelled: rn,
                onBeforeLeave: rn,
                onLeave: rn,
                onAfterLeave: rn,
                onLeaveCancelled: rn,
                onBeforeAppear: rn,
                onAppear: rn,
                onAfterAppear: rn,
                onAppearCancelled: rn
            },
            setup(e, {
                slots: t
            }) {
                const n = pr(),
                    o = on();
                let r;
                return () => {
                    const s = t.default && fn(t.default(), !0);
                    if (!s || !s.length) return;
                    const i = yt(e),
                        {
                            mode: l
                        } = i,
                        c = s[0];
                    if (o.isLeaving) return an(c);
                    const a = un(c);
                    if (!a) return an(c);
                    const u = cn(a, i, o, n);
                    pn(a, u);
                    const p = n.subTree,
                        f = p && un(p);
                    let d = !1;
                    const {
                        getTransitionKey: h
                    } = a.type;
                    if (h) {
                        const e = h();
                        void 0 === r ? r = e : e !== r && (r = e, d = !0)
                    }
                    if (f && f.type !== Fo && (!Wo(a, f) || d)) {
                        const e = cn(f, i, o, n);
                        if (pn(f, e), "out-in" === l) return o.isLeaving = !0, e.afterLeave = () => {
                            o.isLeaving = !1, n.update()
                        }, an(c);
                        "in-out" === l && a.type !== Fo && (e.delayLeave = (e, t, n) => {
                            ln(o, f)[String(f.key)] = f, e._leaveCb = () => {
                                t(), e._leaveCb = void 0, delete u.delayedLeave
                            }, u.delayedLeave = n
                        })
                    }
                    return c
                }
            }
        };

    function ln(e, t) {
        const {
            leavingVNodes: n
        } = e;
        let o = n.get(t.type);
        return o || (o = Object.create(null), n.set(t.type, o)), o
    }

    function cn(e, t, n, o) {
        const {
            appear: r,
            mode: s,
            persisted: i = !1,
            onBeforeEnter: l,
            onEnter: c,
            onAfterEnter: a,
            onEnterCancelled: u,
            onBeforeLeave: p,
            onLeave: f,
            onAfterLeave: d,
            onLeaveCancelled: h,
            onBeforeAppear: m,
            onAppear: g,
            onAfterAppear: v,
            onAppearCancelled: y
        } = t, b = String(e.key), _ = ln(n, e), S = (e, t) => {
            e && Or(e, o, 9, t)
        }, x = {
            mode: s,
            persisted: i,
            beforeEnter(t) {
                let o = l;
                if (!n.isMounted) {
                    if (!r) return;
                    o = m || l
                }
                t._leaveCb && t._leaveCb(!0);
                const s = _[b];
                s && Wo(e, s) && s.el._leaveCb && s.el._leaveCb(), S(o, [t])
            },
            enter(e) {
                let t = c,
                    o = a,
                    s = u;
                if (!n.isMounted) {
                    if (!r) return;
                    t = g || c, o = v || a, s = y || u
                }
                let i = !1;
                const l = e._enterCb = t => {
                    i || (i = !0, S(t ? s : o, [e]), x.delayedLeave && x.delayedLeave(), e._enterCb = void 0)
                };
                t ? (t(e, l), t.length <= 1 && l()) : l()
            },
            leave(t, o) {
                const r = String(e.key);
                if (t._enterCb && t._enterCb(!0), n.isUnmounting) return o();
                S(p, [t]);
                let s = !1;
                const i = t._leaveCb = n => {
                    s || (s = !0, o(), S(n ? h : d, [t]), t._leaveCb = void 0, _[r] === e && delete _[r])
                };
                _[r] = e, f ? (f(t, i), f.length <= 1 && i()) : i()
            },
            clone: e => cn(e, t, n, o)
        };
        return x
    }

    function an(e) {
        if (gn(e)) return (e = Zo(e)).children = null, e
    }

    function un(e) {
        return gn(e) ? e.children ? e.children[0] : void 0 : e
    }

    function pn(e, t) {
        6 & e.shapeFlag && e.component ? pn(e.component.subTree, t) : 128 & e.shapeFlag ? (e.ssContent.transition = t.clone(e.ssContent), e.ssFallback.transition = t.clone(e.ssFallback)) : e.transition = t
    }

    function fn(e, t = !1) {
        let n = [],
            o = 0;
        for (let r = 0; r < e.length; r++) {
            const s = e[r];
            s.type === Ro ? (128 & s.patchFlag && o++, n = n.concat(fn(s.children, t))) : (t || s.type !== Fo) && n.push(s)
        }
        if (o > 1)
            for (let r = 0; r < n.length; r++) n[r].patchFlag = -2;
        return n
    }

    function dn(e) {
        return R(e) ? {
            setup: e,
            name: e.name
        } : e
    }
    const hn = e => !!e.type.__asyncLoader;

    function mn(e, {
        vnode: {
            ref: t,
            props: n,
            children: o
        }
    }) {
        const r = Jo(e, n, o);
        return r.ref = t, r
    }
    const gn = e => e.type.__isKeepAlive,
        vn = {
            name: "KeepAlive",
            __isKeepAlive: !0,
            props: {
                include: [String, RegExp, Array],
                exclude: [String, RegExp, Array],
                max: [String, Number]
            },
            setup(e, {
                slots: t
            }) {
                const n = pr(),
                    o = n.ctx;
                if (!o.renderer) return t.default;
                const r = new Map,
                    s = new Set;
                let i = null;
                const l = n.suspense,
                    {
                        renderer: {
                            p: c,
                            m: a,
                            um: u,
                            o: {
                                createElement: p
                            }
                        }
                    } = o,
                    f = p("div");

                function d(e) {
                    Cn(e), u(e, n, l)
                }

                function h(e) {
                    r.forEach(((t, n) => {
                        const o = wr(t.type);
                        !o || e && e(o) || m(n)
                    }))
                }

                function m(e) {
                    const t = r.get(e);
                    i && t.type === i.type ? i && Cn(i) : d(t), r.delete(e), s.delete(e)
                }
                o.activate = (e, t, n, o, r) => {
                    const s = e.component;
                    a(e, t, n, 0, l), c(s.vnode, e, t, n, s, l, o, e.slotScopeIds, r), mo((() => {
                        s.isDeactivated = !1, s.a && J(s.a);
                        const t = e.props && e.props.onVnodeMounted;
                        t && _o(t, s.parent, e)
                    }), l)
                }, o.deactivate = e => {
                    const t = e.component;
                    a(e, f, null, 1, l), mo((() => {
                        t.da && J(t.da);
                        const n = e.props && e.props.onVnodeUnmounted;
                        n && _o(n, t.parent, e), t.isDeactivated = !0
                    }), l)
                }, ns((() => [e.include, e.exclude]), (([e, t]) => {
                    e && h((t => yn(e, t))), t && h((e => !yn(t, e)))
                }), {
                    flush: "post",
                    deep: !0
                });
                let g = null;
                const v = () => {
                    null != g && r.set(g, wn(n.subTree))
                };
                return En(v), On(v), Rn((() => {
                    r.forEach((e => {
                        const {
                            subTree: t,
                            suspense: o
                        } = n, r = wn(t);
                        if (e.type !== r.type) d(e);
                        else {
                            Cn(r);
                            const e = r.component.da;
                            e && mo(e, o)
                        }
                    }))
                })), () => {
                    if (g = null, !t.default) return null;
                    const n = t.default(),
                        o = n[0];
                    if (n.length > 1) return i = null, n;
                    if (!(Do(o) && (4 & o.shapeFlag || 128 & o.shapeFlag))) return i = null, o;
                    let l = wn(o);
                    const c = l.type,
                        a = wr(hn(l) ? l.type.__asyncResolved || {} : c),
                        {
                            include: u,
                            exclude: p,
                            max: f
                        } = e;
                    if (u && (!a || !yn(u, a)) || p && a && yn(p, a)) return i = l, o;
                    const d = null == l.key ? c : l.key,
                        h = r.get(d);
                    return l.el && (l = Zo(l), 128 & o.shapeFlag && (o.ssContent = l)), g = d, h ? (l.el = h.el, l.component = h.component, l.transition && pn(l, l.transition), l.shapeFlag |= 512, s.delete(d), s.add(d)) : (s.add(d), f && s.size > parseInt(f, 10) && m(s.values().next().value)), l.shapeFlag |= 256, i = l, o
                }
            }
        };

    function yn(e, t) {
        return N(e) ? e.some((e => yn(e, t))) : A(e) ? e.split(",").indexOf(t) > -1 : !!e.test && e.test(t)
    }

    function bn(e, t) {
        Sn(e, "a", t)
    }

    function _n(e, t) {
        Sn(e, "da", t)
    }

    function Sn(e, t, n = ur) {
        const o = e.__wdc || (e.__wdc = () => {
            let t = n;
            for (; t;) {
                if (t.isDeactivated) return;
                t = t.parent
            }
            e()
        });
        if (kn(t, o, n), n) {
            let e = n.parent;
            for (; e && e.parent;) gn(e.parent.vnode) && xn(o, t, n, e), e = e.parent
        }
    }

    function xn(e, t, n, o) {
        const r = kn(t, e, o, !0);
        An((() => {
            w(o[t], r)
        }), n)
    }

    function Cn(e) {
        let t = e.shapeFlag;
        256 & t && (t -= 256), 512 & t && (t -= 512), e.shapeFlag = t
    }

    function wn(e) {
        return 128 & e.shapeFlag ? e.ssContent : e
    }

    function kn(e, t, n = ur, o = !1) {
        if (n) {
            const r = n[e] || (n[e] = []),
                s = t.__weh || (t.__weh = (...o) => {
                    if (n.isUnmounted) return;
                    ve(), fr(n);
                    const r = Or(t, n, e, o);
                    return dr(), ye(), r
                });
            return o ? r.unshift(s) : r.push(s), s
        }
    }
    const Tn = e => (t, n = ur) => (!vr || "sp" === e) && kn(e, t, n),
        Nn = Tn("bm"),
        En = Tn("m"),
        $n = Tn("bu"),
        On = Tn("u"),
        Rn = Tn("bum"),
        An = Tn("um"),
        Fn = Tn("sp"),
        Mn = Tn("rtg"),
        Pn = Tn("rtc");

    function Vn(e, t = ur) {
        kn("ec", e, t)
    }
    let In = !0;

    function Bn(e) {
        const t = Un(e),
            n = e.proxy,
            o = e.ctx;
        In = !1, t.beforeCreate && Ln(t.beforeCreate, e, "bc");
        const {
            data: r,
            computed: s,
            methods: i,
            watch: l,
            provide: c,
            inject: a,
            created: u,
            beforeMount: p,
            mounted: f,
            beforeUpdate: d,
            updated: h,
            activated: m,
            deactivated: g,
            beforeUnmount: v,
            unmounted: b,
            render: _,
            renderTracked: S,
            renderTriggered: x,
            errorCaptured: C,
            serverPrefetch: w,
            expose: k,
            inheritAttrs: T,
            components: E,
            directives: $
        } = t;
        if (a && function(e, t, n = y, o = !1) {
                N(e) && (e = zn(e));
                for (const r in e) {
                    const n = e[r];
                    let s;
                    s = M(n) ? "default" in n ? nn(n.from || r, n.default, !0) : nn(n.from || r) : nn(n), wt(s) && o ? Object.defineProperty(t, r, {
                        enumerable: !0,
                        configurable: !0,
                        get: () => s.value,
                        set: e => s.value = e
                    }) : t[r] = s
                }
            }(a, o, null, e.appContext.config.unwrapInjectedRef), i)
            for (const y in i) {
                const e = i[y];
                R(e) && (o[y] = e.bind(n))
            }
        if (r) {
            const t = r.call(n, n);
            M(t) && (e.data = pt(t))
        }
        if (In = !0, s)
            for (const N in s) {
                const e = s[N],
                    t = Pt({
                        get: R(e) ? e.bind(n, n) : R(e.get) ? e.get.bind(n, n) : y,
                        set: !R(e) && R(e.set) ? e.set.bind(n) : y
                    });
                Object.defineProperty(o, N, {
                    enumerable: !0,
                    configurable: !0,
                    get: () => t.value,
                    set: e => t.value = e
                })
            }
        if (l)
            for (const y in l) jn(l[y], o, n, y);
        if (c) {
            const e = R(c) ? c.call(n) : c;
            Reflect.ownKeys(e).forEach((t => {
                tn(t, e[t])
            }))
        }

        function O(e, t) {
            N(t) ? t.forEach((t => e(t.bind(n)))) : t && e(t.bind(n))
        }
        if (u && Ln(u, e, "c"), O(Nn, p), O(En, f), O($n, d), O(On, h), O(bn, m), O(_n, g), O(Vn, C), O(Pn, S), O(Mn, x), O(Rn, v), O(An, b), O(Fn, w), N(k))
            if (k.length) {
                const t = e.exposed || (e.exposed = {});
                k.forEach((e => {
                    Object.defineProperty(t, e, {
                        get: () => n[e],
                        set: t => n[e] = t
                    })
                }))
            } else e.exposed || (e.exposed = {});
        _ && e.render === y && (e.render = _), null != T && (e.inheritAttrs = T), E && (e.components = E), $ && (e.directives = $)
    }

    function Ln(e, t, n) {
        Or(N(e) ? e.map((e => e.bind(t.proxy))) : e.bind(t.proxy), t, n)
    }

    function jn(e, t, n, o) {
        const r = o.includes(".") ? ss(n, o) : () => n[o];
        if (A(e)) {
            const n = t[e];
            R(n) && ns(r, n)
        } else if (R(e)) ns(r, e.bind(n));
        else if (M(e))
            if (N(e)) e.forEach((e => jn(e, t, n, o)));
            else {
                const o = R(e.handler) ? e.handler.bind(n) : t[e.handler];
                R(o) && ns(r, o, e)
            }
    }

    function Un(e) {
        const t = e.type,
            {
                mixins: n,
                extends: o
            } = t,
            {
                mixins: r,
                optionsCache: s,
                config: {
                    optionMergeStrategies: i
                }
            } = e.appContext,
            l = s.get(t);
        let c;
        return l ? c = l : r.length || n || o ? (c = {}, r.length && r.forEach((e => Hn(c, e, i, !0))), Hn(c, t, i)) : c = t, s.set(t, c), c
    }

    function Hn(e, t, n, o = !1) {
        const {
            mixins: r,
            extends: s
        } = t;
        s && Hn(e, s, n, !0), r && r.forEach((t => Hn(e, t, n, !0)));
        for (const i in t)
            if (o && "expose" === i);
            else {
                const o = Dn[i] || n && n[i];
                e[i] = o ? o(e[i], t[i]) : t[i]
            } return e
    }
    const Dn = {
        data: Wn,
        props: Gn,
        emits: Gn,
        methods: Gn,
        computed: Gn,
        beforeCreate: Kn,
        created: Kn,
        beforeMount: Kn,
        mounted: Kn,
        beforeUpdate: Kn,
        updated: Kn,
        beforeDestroy: Kn,
        beforeUnmount: Kn,
        destroyed: Kn,
        unmounted: Kn,
        activated: Kn,
        deactivated: Kn,
        errorCaptured: Kn,
        serverPrefetch: Kn,
        components: Gn,
        directives: Gn,
        watch: function(e, t) {
            if (!e) return t;
            if (!t) return e;
            const n = C(Object.create(null), e);
            for (const o in t) n[o] = Kn(e[o], t[o]);
            return n
        },
        provide: Wn,
        inject: function(e, t) {
            return Gn(zn(e), zn(t))
        }
    };

    function Wn(e, t) {
        return t ? e ? function() {
            return C(R(e) ? e.call(this, this) : e, R(t) ? t.call(this, this) : t)
        } : t : e
    }

    function zn(e) {
        if (N(e)) {
            const t = {};
            for (let n = 0; n < e.length; n++) t[e[n]] = e[n];
            return t
        }
        return e
    }

    function Kn(e, t) {
        return e ? [...new Set([].concat(e, t))] : t
    }

    function Gn(e, t) {
        return e ? C(C(Object.create(null), e), t) : t
    }

    function qn(e, t, n, o) {
        const [r, s] = e.propsOptions;
        let i, l = !1;
        if (t)
            for (let c in t) {
                if (j(c)) continue;
                const a = t[c];
                let u;
                r && T(r, u = D(c)) ? s && s.includes(u) ? (i || (i = {}))[u] = a : n[u] = a : Lt(e.emitsOptions, c) || a !== o[c] && (o[c] = a, l = !0)
            }
        if (s) {
            const t = yt(n),
                o = i || g;
            for (let i = 0; i < s.length; i++) {
                const l = s[i];
                n[l] = Jn(r, t, l, o[l], e, !T(o, l))
            }
        }
        return l
    }

    function Jn(e, t, n, o, r, s) {
        const i = e[n];
        if (null != i) {
            const e = T(i, "default");
            if (e && void 0 === o) {
                const e = i.default;
                if (i.type !== Function && R(e)) {
                    const {
                        propsDefaults: s
                    } = r;
                    n in s ? o = s[n] : (fr(r), o = s[n] = e.call(null, t), dr())
                } else o = e
            }
            i[0] && (s && !e ? o = !1 : !i[1] || "" !== o && o !== z(n) || (o = !0))
        }
        return o
    }

    function Yn(e, t, n = !1) {
        const o = t.propsCache,
            r = o.get(e);
        if (r) return r;
        const s = e.props,
            i = {},
            l = [];
        let c = !1;
        if (!R(e)) {
            const o = e => {
                c = !0;
                const [n, o] = Yn(e, t, !0);
                C(i, n), o && l.push(...o)
            };
            !n && t.mixins.length && t.mixins.forEach(o), e.extends && o(e.extends), e.mixins && e.mixins.forEach(o)
        }
        if (!s && !c) return o.set(e, v), v;
        if (N(s))
            for (let u = 0; u < s.length; u++) {
                const e = D(s[u]);
                Zn(e) && (i[e] = g)
            } else if (s)
                for (const u in s) {
                    const e = D(u);
                    if (Zn(e)) {
                        const t = s[u],
                            n = i[e] = N(t) || R(t) ? {
                                type: t
                            } : t;
                        if (n) {
                            const t = eo(Boolean, n.type),
                                o = eo(String, n.type);
                            n[0] = t > -1, n[1] = o < 0 || t < o, (t > -1 || T(n, "default")) && l.push(e)
                        }
                    }
                }
        const a = [i, l];
        return o.set(e, a), a
    }

    function Zn(e) {
        return "$" !== e[0]
    }

    function Qn(e) {
        const t = e && e.toString().match(/^\s*function (\w+)/);
        return t ? t[1] : null === e ? "null" : ""
    }

    function Xn(e, t) {
        return Qn(e) === Qn(t)
    }

    function eo(e, t) {
        return N(t) ? t.findIndex((t => Xn(t, e))) : R(t) && Xn(t, e) ? 0 : -1
    }
    const to = e => "_" === e[0] || "$stable" === e,
        no = e => N(e) ? e.map(Xo) : [Xo(e)],
        oo = (e, t, n) => {
            const o = Dt(((...e) => no(t(...e))), n);
            return o._c = !1, o
        },
        ro = (e, t, n) => {
            const o = e._ctx;
            for (const r in e) {
                if (to(r)) continue;
                const n = e[r];
                if (R(n)) t[r] = oo(0, n, o);
                else if (null != n) {
                    const e = no(n);
                    t[r] = () => e
                }
            }
        },
        so = (e, t) => {
            const n = no(t);
            e.slots.default = () => n
        };

    function io(e, t, n, o) {
        const r = e.dirs,
            s = t && t.dirs;
        for (let i = 0; i < r.length; i++) {
            const l = r[i];
            s && (l.oldValue = s[i].value);
            let c = l.dir[o];
            c && (ve(), Or(c, n, 8, [e.el, l, e, t]), ye())
        }
    }

    function lo() {
        return {
            app: null,
            config: {
                isNativeTag: b,
                performance: !1,
                globalProperties: {},
                optionMergeStrategies: {},
                errorHandler: void 0,
                warnHandler: void 0,
                compilerOptions: {}
            },
            mixins: [],
            components: {},
            directives: {},
            provides: Object.create(null),
            optionsCache: new WeakMap,
            propsCache: new WeakMap,
            emitsCache: new WeakMap
        }
    }
    let co = 0;

    function ao(e, t) {
        return function(n, o = null) {
            null == o || M(o) || (o = null);
            const r = lo(),
                s = new Set;
            let i = !1;
            const l = r.app = {
                _uid: co++,
                _component: n,
                _props: o,
                _container: null,
                _context: r,
                _instance: null,
                version: ps,
                get config() {
                    return r.config
                },
                set config(e) {},
                use: (e, ...t) => (s.has(e) || (e && R(e.install) ? (s.add(e), e.install(l, ...t)) : R(e) && (s.add(e), e(l, ...t))), l),
                mixin: e => (r.mixins.includes(e) || r.mixins.push(e), l),
                component: (e, t) => t ? (r.components[e] = t, l) : r.components[e],
                directive: (e, t) => t ? (r.directives[e] = t, l) : r.directives[e],
                mount(s, c, a) {
                    if (!i) {
                        const u = Jo(n, o);
                        return u.appContext = r, c && t ? t(u, s) : e(u, s, a), i = !0, l._container = s, s.__vue_app__ = l, xr(u.component) || u.component.proxy
                    }
                },
                unmount() {
                    i && (e(null, l._container), delete l._container.__vue_app__)
                },
                provide: (e, t) => (r.provides[e] = t, l)
            };
            return l
        }
    }
    let uo = !1;
    const po = e => /svg/.test(e.namespaceURI) && "foreignObject" !== e.tagName,
        fo = e => 8 === e.nodeType;

    function ho(e) {
        const {
            mt: t,
            p: n,
            o: {
                patchProp: o,
                nextSibling: r,
                parentNode: s,
                remove: i,
                insert: l,
                createComment: c
            }
        } = e, a = (n, o, i, l, c, m = !1) => {
            const g = fo(n) && "[" === n.data,
                v = () => d(n, o, i, l, c, g),
                {
                    type: y,
                    ref: b,
                    shapeFlag: _
                } = o,
                S = n.nodeType;
            o.el = n;
            let x = null;
            switch (y) {
                case Ao:
                    3 !== S ? x = v() : (n.data !== o.children && (uo = !0, n.data = o.children), x = r(n));
                    break;
                case Fo:
                    x = 8 !== S || g ? v() : r(n);
                    break;
                case Mo:
                    if (1 === S) {
                        x = n;
                        const e = !o.children.length;
                        for (let t = 0; t < o.staticCount; t++) e && (o.children += x.outerHTML), t === o.staticCount - 1 && (o.anchor = x), x = r(x);
                        return x
                    }
                    x = v();
                    break;
                case Ro:
                    x = g ? f(n, o, i, l, c, m) : v();
                    break;
                default:
                    if (1 & _) x = 1 !== S || o.type.toLowerCase() !== n.tagName.toLowerCase() ? v() : u(n, o, i, l, c, m);
                    else if (6 & _) {
                        o.slotScopeIds = c;
                        const e = s(n);
                        if (t(o, e, null, i, l, po(e), m), x = g ? h(n) : r(n), hn(o)) {
                            let t;
                            g ? (t = Jo(Ro), t.anchor = x ? x.previousSibling : e.lastChild) : t = 3 === n.nodeType ? Qo("") : Jo("div"), t.el = n, o.component.subTree = t
                        }
                    } else 64 & _ ? x = 8 !== S ? v() : o.type.hydrate(n, o, i, l, c, m, e, p) : 128 & _ && (x = o.type.hydrate(n, o, i, l, po(s(n)), c, m, e, a))
            }
            return null != b && bo(b, null, l, o), x
        }, u = (e, t, n, r, s, l) => {
            l = l || !!t.dynamicChildren;
            const {
                type: c,
                props: a,
                patchFlag: u,
                shapeFlag: f,
                dirs: d
            } = t, h = "input" === c && d || "option" === c;
            if (h || -1 !== u) {
                if (d && io(t, null, n, "created"), a)
                    if (h || !l || 48 & u)
                        for (const t in a)(h && t.endsWith("value") || S(t) && !j(t)) && o(e, t, null, a[t], !1, void 0, n);
                    else a.onClick && o(e, "onClick", null, a.onClick, !1, void 0, n);
                let c;
                if ((c = a && a.onVnodeBeforeMount) && _o(c, n, t), d && io(t, null, n, "beforeMount"), ((c = a && a.onVnodeMounted) || d) && Xt((() => {
                        c && _o(c, n, t), d && io(t, null, n, "mounted")
                    }), r), 16 & f && (!a || !a.innerHTML && !a.textContent)) {
                    let o = p(e.firstChild, t, e, n, r, s, l);
                    for (; o;) {
                        uo = !0;
                        const e = o;
                        o = o.nextSibling, i(e)
                    }
                } else 8 & f && e.textContent !== t.children && (uo = !0, e.textContent = t.children)
            }
            return e.nextSibling
        }, p = (e, t, o, r, s, i, l) => {
            l = l || !!t.dynamicChildren;
            const c = t.children,
                u = c.length;
            for (let p = 0; p < u; p++) {
                const t = l ? c[p] : c[p] = Xo(c[p]);
                if (e) e = a(e, t, r, s, i, l);
                else {
                    if (t.type === Ao && !t.children) continue;
                    uo = !0, n(null, t, o, null, r, s, po(o), i)
                }
            }
            return e
        }, f = (e, t, n, o, i, a) => {
            const {
                slotScopeIds: u
            } = t;
            u && (i = i ? i.concat(u) : u);
            const f = s(e),
                d = p(r(e), t, f, n, o, i, a);
            return d && fo(d) && "]" === d.data ? r(t.anchor = d) : (uo = !0, l(t.anchor = c("]"), f, d), d)
        }, d = (e, t, o, l, c, a) => {
            if (uo = !0, t.el = null, a) {
                const t = h(e);
                for (;;) {
                    const n = r(e);
                    if (!n || n === t) break;
                    i(n)
                }
            }
            const u = r(e),
                p = s(e);
            return i(e), n(null, t, p, u, o, l, po(p), c), u
        }, h = e => {
            let t = 0;
            for (; e;)
                if ((e = r(e)) && fo(e) && ("[" === e.data && t++, "]" === e.data)) {
                    if (0 === t) return r(e);
                    t--
                } return e
        };
        return [(e, t) => {
            if (!t.hasChildNodes()) return n(null, e, t), void Zr();
            uo = !1, a(t.firstChild, e, null, null, null), Zr(), uo && console.error("Hydration completed but contains mismatches.")
        }, a]
    }
    const mo = Xt;

    function go(e) {
        return yo(e)
    }

    function vo(e) {
        return yo(e, ho)
    }

    function yo(e, t) {
        (Q || (Q = "undefined" != typeof globalThis ? globalThis : "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})).__VUE__ = !0;
        const {
            insert: n,
            remove: o,
            patchProp: r,
            createElement: s,
            createText: i,
            createComment: l,
            setText: c,
            setElementText: a,
            parentNode: u,
            nextSibling: p,
            setScopeId: f = y,
            cloneNode: d,
            insertStaticContent: h
        } = e, m = (e, t, n, o = null, r = null, s = null, i = !1, l = null, c = !!t.dynamicChildren) => {
            if (e === t) return;
            e && !Wo(e, t) && (o = X(e), W(e, r, s, !0), e = null), -2 === t.patchFlag && (c = !1, t.dynamicChildren = null);
            const {
                type: a,
                ref: u,
                shapeFlag: p
            } = t;
            switch (a) {
                case Ao:
                    b(e, t, n, o);
                    break;
                case Fo:
                    _(e, t, n, o);
                    break;
                case Mo:
                    null == e && S(t, n, o, i);
                    break;
                case Ro:
                    R(e, t, n, o, r, s, i, l, c);
                    break;
                default:
                    1 & p ? x(e, t, n, o, r, s, i, l, c) : 6 & p ? A(e, t, n, o, r, s, i, l, c) : (64 & p || 128 & p) && a.process(e, t, n, o, r, s, i, l, c, ne)
            }
            null != u && r && bo(u, e && e.ref, s, t || e, !t)
        }, b = (e, t, o, r) => {
            if (null == e) n(t.el = i(t.children), o, r);
            else {
                const n = t.el = e.el;
                t.children !== e.children && c(n, t.children)
            }
        }, _ = (e, t, o, r) => {
            null == e ? n(t.el = l(t.children || ""), o, r) : t.el = e.el
        }, S = (e, t, n, o) => {
            [e.el, e.anchor] = h(e.children, t, n, o)
        }, x = (e, t, n, o, r, s, i, l, c) => {
            i = i || "svg" === t.type, null == e ? w(t, n, o, r, s, i, l, c) : E(e, t, r, s, i, l, c)
        }, w = (e, t, o, i, l, c, u, p) => {
            let f, h;
            const {
                type: m,
                props: g,
                shapeFlag: v,
                transition: y,
                patchFlag: b,
                dirs: _
            } = e;
            if (e.el && void 0 !== d && -1 === b) f = e.el = d(e.el);
            else {
                if (f = e.el = s(e.type, c, g && g.is, g), 8 & v ? a(f, e.children) : 16 & v && N(e.children, f, null, i, l, c && "foreignObject" !== m, u, p), _ && io(e, null, i, "created"), g) {
                    for (const t in g) "value" === t || j(t) || r(f, t, null, g[t], c, e.children, i, l, Z);
                    "value" in g && r(f, "value", null, g.value), (h = g.onVnodeBeforeMount) && _o(h, i, e)
                }
                k(f, e, e.scopeId, u, i)
            }
            _ && io(e, null, i, "beforeMount");
            const S = (!l || l && !l.pendingBranch) && y && !y.persisted;
            S && y.beforeEnter(f), n(f, t, o), ((h = g && g.onVnodeMounted) || S || _) && mo((() => {
                h && _o(h, i, e), S && y.enter(f), _ && io(e, null, i, "mounted")
            }), l)
        }, k = (e, t, n, o, r) => {
            if (n && f(e, n), o)
                for (let s = 0; s < o.length; s++) f(e, o[s]);
            if (r) {
                if (t === r.subTree) {
                    const t = r.vnode;
                    k(e, t, t.scopeId, t.slotScopeIds, r.parent)
                }
            }
        }, N = (e, t, n, o, r, s, i, l, c = 0) => {
            for (let a = c; a < e.length; a++) {
                const c = e[a] = l ? er(e[a]) : Xo(e[a]);
                m(null, c, t, n, o, r, s, i, l)
            }
        }, E = (e, t, n, o, s, i, l) => {
            const c = t.el = e.el;
            let {
                patchFlag: u,
                dynamicChildren: p,
                dirs: f
            } = t;
            u |= 16 & e.patchFlag;
            const d = e.props || g,
                h = t.props || g;
            let m;
            (m = h.onVnodeBeforeUpdate) && _o(m, n, t, e), f && io(t, e, n, "beforeUpdate");
            const v = s && "foreignObject" !== t.type;
            if (p ? $(e.dynamicChildren, p, c, n, o, v, i) : l || B(e, t, c, null, n, o, v, i, !1), u > 0) {
                if (16 & u) O(c, t, d, h, n, o, s);
                else if (2 & u && d.class !== h.class && r(c, "class", null, h.class, s), 4 & u && r(c, "style", d.style, h.style, s), 8 & u) {
                    const i = t.dynamicProps;
                    for (let t = 0; t < i.length; t++) {
                        const l = i[t],
                            a = d[l],
                            u = h[l];
                        u === a && "value" !== l || r(c, l, a, u, s, e.children, n, o, Z)
                    }
                }
                1 & u && e.children !== t.children && a(c, t.children)
            } else l || null != p || O(c, t, d, h, n, o, s);
            ((m = h.onVnodeUpdated) || f) && mo((() => {
                m && _o(m, n, t, e), f && io(t, e, n, "updated")
            }), o)
        }, $ = (e, t, n, o, r, s, i) => {
            for (let l = 0; l < t.length; l++) {
                const c = e[l],
                    a = t[l],
                    p = c.el && (c.type === Ro || !Wo(c, a) || 70 & c.shapeFlag) ? u(c.el) : n;
                m(c, a, p, null, o, r, s, i, !0)
            }
        }, O = (e, t, n, o, s, i, l) => {
            if (n !== o) {
                for (const c in o) {
                    if (j(c)) continue;
                    const a = o[c],
                        u = n[c];
                    a !== u && "value" !== c && r(e, c, u, a, l, t.children, s, i, Z)
                }
                if (n !== g)
                    for (const c in n) j(c) || c in o || r(e, c, n[c], null, l, t.children, s, i, Z);
                "value" in o && r(e, "value", n.value, o.value)
            }
        }, R = (e, t, o, r, s, l, c, a, u) => {
            const p = t.el = e ? e.el : i(""),
                f = t.anchor = e ? e.anchor : i("");
            let {
                patchFlag: d,
                dynamicChildren: h,
                slotScopeIds: m
            } = t;
            m && (a = a ? a.concat(m) : m), null == e ? (n(p, o, r), n(f, o, r), N(t.children, o, f, s, l, c, a, u)) : d > 0 && 64 & d && h && e.dynamicChildren ? ($(e.dynamicChildren, h, o, s, l, c, a), (null != t.key || s && t === s.subTree) && So(e, t, !0)) : B(e, t, o, f, s, l, c, a, u)
        }, A = (e, t, n, o, r, s, i, l, c) => {
            t.slotScopeIds = l, null == e ? 512 & t.shapeFlag ? r.ctx.activate(t, n, o, i, c) : F(t, n, o, r, s, i, c) : M(e, t, c)
        }, F = (e, t, n, o, r, s, i) => {
            const l = e.component = function(e, t, n) {
                const o = e.type,
                    r = (t ? t.appContext : e.appContext) || cr,
                    s = {
                        uid: ar++,
                        vnode: e,
                        type: o,
                        parent: t,
                        appContext: r,
                        root: null,
                        next: null,
                        subTree: null,
                        update: null,
                        scope: new te(!0),
                        render: null,
                        proxy: null,
                        exposed: null,
                        exposeProxy: null,
                        withProxy: null,
                        provides: t ? t.provides : Object.create(r.provides),
                        accessCache: null,
                        renderCache: [],
                        components: null,
                        directives: null,
                        propsOptions: Yn(o, r),
                        emitsOptions: Bt(o, r),
                        emit: null,
                        emitted: null,
                        propsDefaults: g,
                        inheritAttrs: o.inheritAttrs,
                        ctx: g,
                        data: g,
                        props: g,
                        attrs: g,
                        slots: g,
                        refs: g,
                        setupState: g,
                        setupContext: null,
                        suspense: n,
                        suspenseId: n ? n.pendingId : 0,
                        asyncDep: null,
                        asyncResolved: !1,
                        isMounted: !1,
                        isUnmounted: !1,
                        isDeactivated: !1,
                        bc: null,
                        c: null,
                        bm: null,
                        m: null,
                        bu: null,
                        u: null,
                        um: null,
                        bum: null,
                        da: null,
                        a: null,
                        rtg: null,
                        rtc: null,
                        ec: null,
                        sp: null
                    };
                s.ctx = {
                    _: s
                }, s.root = t ? t.root : s, s.emit = It.bind(null, s), e.ce && e.ce(s);
                return s
            }(e, o, r);
            if (gn(e) && (l.ctx.renderer = ne), function(e, t = !1) {
                    vr = t;
                    const {
                        props: n,
                        children: o
                    } = e.vnode, r = hr(e);
                    (function(e, t, n, o = !1) {
                        const r = {},
                            s = {};
                        Y(s, zo, 1), e.propsDefaults = Object.create(null), qn(e, t, r, s);
                        for (const i in e.propsOptions[0]) i in r || (r[i] = void 0);
                        e.props = n ? o ? r : ft(r) : e.type.props ? r : s, e.attrs = s
                    })(e, n, r, t), ((e, t) => {
                        if (32 & e.vnode.shapeFlag) {
                            const n = t._;
                            n ? (e.slots = yt(t), Y(t, "_", n)) : ro(t, e.slots = {})
                        } else e.slots = {}, t && so(e, t);
                        Y(e.slots, zo, 1)
                    })(e, o);
                    const s = r ? function(e, t) {
                        const n = e.type;
                        e.accessCache = Object.create(null), e.proxy = bt(new Proxy(e.ctx, ir));
                        const {
                            setup: o
                        } = n;
                        if (o) {
                            const n = e.setupContext = o.length > 1 ? Sr(e) : null;
                            fr(e), ve();
                            const r = $r(o, e, 0, [e.props, n]);
                            if (ye(), dr(), P(r)) {
                                if (r.then(dr, dr), t) return r.then((n => {
                                    yr(e, n, t)
                                })).catch((t => {
                                    Rr(t, e, 0)
                                }));
                                e.asyncDep = r
                            } else yr(e, r, t)
                        } else _r(e, t)
                    }(e, t) : void 0;
                    vr = !1
                }(l), l.asyncDep) {
                if (r && r.registerDep(l, V), !e.el) {
                    const e = l.subTree = Jo(Fo);
                    _(null, e, t, n)
                }
            } else V(l, e, t, n, r, s, i)
        }, M = (e, t, n) => {
            const o = t.component = e.component;
            if (function(e, t, n) {
                    const {
                        props: o,
                        children: r,
                        component: s
                    } = e, {
                        props: i,
                        children: l,
                        patchFlag: c
                    } = t, a = s.emitsOptions;
                    if (t.dirs || t.transition) return !0;
                    if (!(n && c >= 0)) return !(!r && !l || l && l.$stable) || o !== i && (o ? !i || Gt(o, i, a) : !!i);
                    if (1024 & c) return !0;
                    if (16 & c) return o ? Gt(o, i, a) : !!i;
                    if (8 & c) {
                        const e = t.dynamicProps;
                        for (let t = 0; t < e.length; t++) {
                            const n = e[t];
                            if (i[n] !== o[n] && !Lt(a, n)) return !0
                        }
                    }
                    return !1
                }(e, t, n)) {
                if (o.asyncDep && !o.asyncResolved) return void I(o, t, n);
                o.next = t,
                    function(e) {
                        const t = Mr.indexOf(e);
                        t > Pr && Mr.splice(t, 1)
                    }(o.update), o.update()
            } else t.component = e.component, t.el = e.el, o.vnode = t
        }, V = (e, t, n, o, r, s, i) => {
            const l = new de((() => {
                    if (e.isMounted) {
                        let t, {
                                next: n,
                                bu: o,
                                u: c,
                                parent: a,
                                vnode: p
                            } = e,
                            f = n;
                        l.allowRecurse = !1, n ? (n.el = p.el, I(e, n, i)) : n = p, o && J(o), (t = n.props && n.props.onVnodeBeforeUpdate) && _o(t, a, n, p), l.allowRecurse = !0;
                        const d = Wt(e),
                            h = e.subTree;
                        e.subTree = d, m(h, d, u(h.el), X(h), e, r, s), n.el = d.el, null === f && qt(e, d.el), c && mo(c, r), (t = n.props && n.props.onVnodeUpdated) && mo((() => _o(t, a, n, p)), r)
                    } else {
                        let i;
                        const {
                            el: c,
                            props: a
                        } = t, {
                            bm: u,
                            m: p,
                            parent: f
                        } = e, d = hn(t);
                        if (l.allowRecurse = !1, u && J(u), !d && (i = a && a.onVnodeBeforeMount) && _o(i, f, t), l.allowRecurse = !0, c && re) {
                            const n = () => {
                                e.subTree = Wt(e), re(c, e.subTree, e, r, null)
                            };
                            d ? t.type.__asyncLoader().then((() => !e.isUnmounted && n())) : n()
                        } else {
                            const i = e.subTree = Wt(e);
                            m(null, i, n, o, e, r, s), t.el = i.el
                        }
                        if (p && mo(p, r), !d && (i = a && a.onVnodeMounted)) {
                            const e = t;
                            mo((() => _o(i, f, e)), r)
                        }
                        256 & t.shapeFlag && e.a && mo(e.a, r), e.isMounted = !0, t = n = o = null
                    }
                }), (() => Kr(e.update)), e.scope),
                c = e.update = l.run.bind(l);
            c.id = e.uid, l.allowRecurse = c.allowRecurse = !0, c()
        }, I = (e, t, n) => {
            t.component = e;
            const o = e.vnode.props;
            e.vnode = t, e.next = null,
                function(e, t, n, o) {
                    const {
                        props: r,
                        attrs: s,
                        vnode: {
                            patchFlag: i
                        }
                    } = e, l = yt(r), [c] = e.propsOptions;
                    let a = !1;
                    if (!(o || i > 0) || 16 & i) {
                        let o;
                        qn(e, t, r, s) && (a = !0);
                        for (const s in l) t && (T(t, s) || (o = z(s)) !== s && T(t, o)) || (c ? !n || void 0 === n[s] && void 0 === n[o] || (r[s] = Jn(c, l, s, void 0, e, !0)) : delete r[s]);
                        if (s !== l)
                            for (const e in s) t && T(t, e) || (delete s[e], a = !0)
                    } else if (8 & i) {
                        const n = e.vnode.dynamicProps;
                        for (let o = 0; o < n.length; o++) {
                            let i = n[o];
                            const u = t[i];
                            if (c)
                                if (T(s, i)) u !== s[i] && (s[i] = u, a = !0);
                                else {
                                    const t = D(i);
                                    r[t] = Jn(c, l, t, u, e, !1)
                                }
                            else u !== s[i] && (s[i] = u, a = !0)
                        }
                    }
                    a && xe(e, "set", "$attrs")
                }(e, t.props, o, n), ((e, t, n) => {
                    const {
                        vnode: o,
                        slots: r
                    } = e;
                    let s = !0,
                        i = g;
                    if (32 & o.shapeFlag) {
                        const e = t._;
                        e ? n && 1 === e ? s = !1 : (C(r, t), n || 1 !== e || delete r._) : (s = !t.$stable, ro(t, r)), i = t
                    } else t && (so(e, t), i = {
                        default: 1
                    });
                    if (s)
                        for (const l in r) to(l) || l in i || delete r[l]
                })(e, t.children, n), ve(), Yr(void 0, e.update), ye()
        }, B = (e, t, n, o, r, s, i, l, c = !1) => {
            const u = e && e.children,
                p = e ? e.shapeFlag : 0,
                f = t.children,
                {
                    patchFlag: d,
                    shapeFlag: h
                } = t;
            if (d > 0) {
                if (128 & d) return void U(u, f, n, o, r, s, i, l, c);
                if (256 & d) return void L(u, f, n, o, r, s, i, l, c)
            }
            8 & h ? (16 & p && Z(u, r, s), f !== u && a(n, f)) : 16 & p ? 16 & h ? U(u, f, n, o, r, s, i, l, c) : Z(u, r, s, !0) : (8 & p && a(n, ""), 16 & h && N(f, n, o, r, s, i, l, c))
        }, L = (e, t, n, o, r, s, i, l, c) => {
            const a = (e = e || v).length,
                u = (t = t || v).length,
                p = Math.min(a, u);
            let f;
            for (f = 0; f < p; f++) {
                const o = t[f] = c ? er(t[f]) : Xo(t[f]);
                m(e[f], o, n, null, r, s, i, l, c)
            }
            a > u ? Z(e, r, s, !0, !1, p) : N(t, n, o, r, s, i, l, c, p)
        }, U = (e, t, n, o, r, s, i, l, c) => {
            let a = 0;
            const u = t.length;
            let p = e.length - 1,
                f = u - 1;
            for (; a <= p && a <= f;) {
                const o = e[a],
                    u = t[a] = c ? er(t[a]) : Xo(t[a]);
                if (!Wo(o, u)) break;
                m(o, u, n, null, r, s, i, l, c), a++
            }
            for (; a <= p && a <= f;) {
                const o = e[p],
                    a = t[f] = c ? er(t[f]) : Xo(t[f]);
                if (!Wo(o, a)) break;
                m(o, a, n, null, r, s, i, l, c), p--, f--
            }
            if (a > p) {
                if (a <= f) {
                    const e = f + 1,
                        p = e < u ? t[e].el : o;
                    for (; a <= f;) m(null, t[a] = c ? er(t[a]) : Xo(t[a]), n, p, r, s, i, l, c), a++
                }
            } else if (a > f)
                for (; a <= p;) W(e[a], r, s, !0), a++;
            else {
                const d = a,
                    h = a,
                    g = new Map;
                for (a = h; a <= f; a++) {
                    const e = t[a] = c ? er(t[a]) : Xo(t[a]);
                    null != e.key && g.set(e.key, a)
                }
                let y, b = 0;
                const _ = f - h + 1;
                let S = !1,
                    x = 0;
                const C = new Array(_);
                for (a = 0; a < _; a++) C[a] = 0;
                for (a = d; a <= p; a++) {
                    const o = e[a];
                    if (b >= _) {
                        W(o, r, s, !0);
                        continue
                    }
                    let u;
                    if (null != o.key) u = g.get(o.key);
                    else
                        for (y = h; y <= f; y++)
                            if (0 === C[y - h] && Wo(o, t[y])) {
                                u = y;
                                break
                            } void 0 === u ? W(o, r, s, !0) : (C[u - h] = a + 1, u >= x ? x = u : S = !0, m(o, t[u], n, null, r, s, i, l, c), b++)
                }
                const w = S ? function(e) {
                    const t = e.slice(),
                        n = [0];
                    let o, r, s, i, l;
                    const c = e.length;
                    for (o = 0; o < c; o++) {
                        const c = e[o];
                        if (0 !== c) {
                            if (r = n[n.length - 1], e[r] < c) {
                                t[o] = r, n.push(o);
                                continue
                            }
                            for (s = 0, i = n.length - 1; s < i;) l = s + i >> 1, e[n[l]] < c ? s = l + 1 : i = l;
                            c < e[n[s]] && (s > 0 && (t[o] = n[s - 1]), n[s] = o)
                        }
                    }
                    s = n.length, i = n[s - 1];
                    for (; s-- > 0;) n[s] = i, i = t[i];
                    return n
                }(C) : v;
                for (y = w.length - 1, a = _ - 1; a >= 0; a--) {
                    const e = h + a,
                        p = t[e],
                        f = e + 1 < u ? t[e + 1].el : o;
                    0 === C[a] ? m(null, p, n, f, r, s, i, l, c) : S && (y < 0 || a !== w[y] ? H(p, n, f, 2) : y--)
                }
            }
        }, H = (e, t, o, r, s = null) => {
            const {
                el: i,
                type: l,
                transition: c,
                children: a,
                shapeFlag: u
            } = e;
            if (6 & u) return void H(e.component.subTree, t, o, r);
            if (128 & u) return void e.suspense.move(t, o, r);
            if (64 & u) return void l.move(e, t, o, ne);
            if (l === Ro) {
                n(i, t, o);
                for (let e = 0; e < a.length; e++) H(a[e], t, o, r);
                return void n(e.anchor, t, o)
            }
            if (l === Mo) return void(({
                el: e,
                anchor: t
            }, o, r) => {
                let s;
                for (; e && e !== t;) s = p(e), n(e, o, r), e = s;
                n(t, o, r)
            })(e, t, o);
            if (2 !== r && 1 & u && c)
                if (0 === r) c.beforeEnter(i), n(i, t, o), mo((() => c.enter(i)), s);
                else {
                    const {
                        leave: e,
                        delayLeave: r,
                        afterLeave: s
                    } = c, l = () => n(i, t, o), a = () => {
                        e(i, (() => {
                            l(), s && s()
                        }))
                    };
                    r ? r(i, l, a) : a()
                }
            else n(i, t, o)
        }, W = (e, t, n, o = !1, r = !1) => {
            const {
                type: s,
                props: i,
                ref: l,
                children: c,
                dynamicChildren: a,
                shapeFlag: u,
                patchFlag: p,
                dirs: f
            } = e;
            if (null != l && bo(l, null, n, e, !0), 256 & u) return void t.ctx.deactivate(e);
            const d = 1 & u && f,
                h = !hn(e);
            let m;
            if (h && (m = i && i.onVnodeBeforeUnmount) && _o(m, t, e), 6 & u) q(e.component, n, o);
            else {
                if (128 & u) return void e.suspense.unmount(n, o);
                d && io(e, null, t, "beforeUnmount"), 64 & u ? e.type.remove(e, t, n, r, ne, o) : a && (s !== Ro || p > 0 && 64 & p) ? Z(a, t, n, !1, !0) : (s === Ro && 384 & p || !r && 16 & u) && Z(c, t, n), o && K(e)
            }(h && (m = i && i.onVnodeUnmounted) || d) && mo((() => {
                m && _o(m, t, e), d && io(e, null, t, "unmounted")
            }), n)
        }, K = e => {
            const {
                type: t,
                el: n,
                anchor: r,
                transition: s
            } = e;
            if (t === Ro) return void G(n, r);
            if (t === Mo) return void(({
                el: e,
                anchor: t
            }) => {
                let n;
                for (; e && e !== t;) n = p(e), o(e), e = n;
                o(t)
            })(e);
            const i = () => {
                o(n), s && !s.persisted && s.afterLeave && s.afterLeave()
            };
            if (1 & e.shapeFlag && s && !s.persisted) {
                const {
                    leave: t,
                    delayLeave: o
                } = s, r = () => t(n, i);
                o ? o(e.el, i, r) : r()
            } else i()
        }, G = (e, t) => {
            let n;
            for (; e !== t;) n = p(e), o(e), e = n;
            o(t)
        }, q = (e, t, n) => {
            const {
                bum: o,
                scope: r,
                update: s,
                subTree: i,
                um: l
            } = e;
            o && J(o), r.stop(), s && (s.active = !1, W(i, e, t, n)), l && mo(l, t), mo((() => {
                e.isUnmounted = !0
            }), t), t && t.pendingBranch && !t.isUnmounted && e.asyncDep && !e.asyncResolved && e.suspenseId === t.pendingId && (t.deps--, 0 === t.deps && t.resolve())
        }, Z = (e, t, n, o = !1, r = !1, s = 0) => {
            for (let i = s; i < e.length; i++) W(e[i], t, n, o, r)
        }, X = e => 6 & e.shapeFlag ? X(e.component.subTree) : 128 & e.shapeFlag ? e.suspense.next() : p(e.anchor || e.el), ee = (e, t, n) => {
            null == e ? t._vnode && W(t._vnode, null, null, !0) : m(t._vnode || null, e, t, null, null, null, n), Zr(), t._vnode = e
        }, ne = {
            p: m,
            um: W,
            m: H,
            r: K,
            mt: F,
            mc: N,
            pc: B,
            pbc: $,
            n: X,
            o: e
        };
        let oe, re;
        return t && ([oe, re] = t(ne)), {
            render: ee,
            hydrate: oe,
            createApp: ao(ee, oe)
        }
    }

    function bo(e, t, n, o, r = !1) {
        if (N(e)) return void e.forEach(((e, s) => bo(e, t && (N(t) ? t[s] : t), n, o, r)));
        if (hn(o) && !r) return;
        const s = 4 & o.shapeFlag ? xr(o.component) || o.component.proxy : o.el,
            i = r ? null : s,
            {
                i: l,
                r: c
            } = e,
            a = t && t.r,
            u = l.refs === g ? l.refs = {} : l.refs,
            p = l.setupState;
        if (null != a && a !== c && (A(a) ? (u[a] = null, T(p, a) && (p[a] = null)) : wt(a) && (a.value = null)), A(c)) {
            const e = () => {
                u[c] = i, T(p, c) && (p[c] = i)
            };
            i ? (e.id = -1, mo(e, n)) : e()
        } else if (wt(c)) {
            const e = () => {
                c.value = i
            };
            i ? (e.id = -1, mo(e, n)) : e()
        } else R(c) && $r(c, l, 12, [i, u])
    }

    function _o(e, t, n, o = null) {
        Or(e, t, 7, [n, o])
    }

    function So(e, t, n = !1) {
        const o = e.children,
            r = t.children;
        if (N(o) && N(r))
            for (let s = 0; s < o.length; s++) {
                const e = o[s];
                let t = r[s];
                1 & t.shapeFlag && !t.dynamicChildren && ((t.patchFlag <= 0 || 32 === t.patchFlag) && (t = r[s] = er(r[s]), t.el = e.el), n || So(e, t))
            }
    }
    const xo = e => e && (e.disabled || "" === e.disabled),
        Co = e => "undefined" != typeof SVGElement && e instanceof SVGElement,
        wo = (e, t) => {
            const n = e && e.to;
            if (A(n)) {
                if (t) {
                    return t(n)
                }
                return null
            }
            return n
        };

    function ko(e, t, n, {
        o: {
            insert: o
        },
        m: r
    }, s = 2) {
        0 === s && o(e.targetAnchor, t, n);
        const {
            el: i,
            anchor: l,
            shapeFlag: c,
            children: a,
            props: u
        } = e, p = 2 === s;
        if (p && o(i, t, n), (!p || xo(u)) && 16 & c)
            for (let f = 0; f < a.length; f++) r(a[f], t, n, 2);
        p && o(l, t, n)
    }
    const To = {
            __isTeleport: !0,
            process(e, t, n, o, r, s, i, l, c, a) {
                const {
                    mc: u,
                    pc: p,
                    pbc: f,
                    o: {
                        insert: d,
                        querySelector: h,
                        createText: m
                    }
                } = a, g = xo(t.props);
                let {
                    shapeFlag: v,
                    children: y,
                    dynamicChildren: b
                } = t;
                if (null == e) {
                    const e = t.el = m(""),
                        a = t.anchor = m("");
                    d(e, n, o), d(a, n, o);
                    const p = t.target = wo(t.props, h),
                        f = t.targetAnchor = m("");
                    p && (d(f, p), i = i || Co(p));
                    const b = (e, t) => {
                        16 & v && u(y, e, t, r, s, i, l, c)
                    };
                    g ? b(n, a) : p && b(p, f)
                } else {
                    t.el = e.el;
                    const o = t.anchor = e.anchor,
                        u = t.target = e.target,
                        d = t.targetAnchor = e.targetAnchor,
                        m = xo(e.props),
                        v = m ? n : u,
                        y = m ? o : d;
                    if (i = i || Co(u), b ? (f(e.dynamicChildren, b, v, r, s, i, l), So(e, t, !0)) : c || p(e, t, v, y, r, s, i, l, !1), g) m || ko(t, n, o, a, 1);
                    else if ((t.props && t.props.to) !== (e.props && e.props.to)) {
                        const e = t.target = wo(t.props, h);
                        e && ko(t, e, null, a, 0)
                    } else m && ko(t, u, d, a, 1)
                }
            },
            remove(e, t, n, o, {
                um: r,
                o: {
                    remove: s
                }
            }, i) {
                const {
                    shapeFlag: l,
                    children: c,
                    anchor: a,
                    targetAnchor: u,
                    target: p,
                    props: f
                } = e;
                if (p && s(u), (i || !xo(f)) && (s(a), 16 & l))
                    for (let d = 0; d < c.length; d++) {
                        const e = c[d];
                        r(e, t, n, !0, !!e.dynamicChildren)
                    }
            },
            move: ko,
            hydrate: function(e, t, n, o, r, s, {
                o: {
                    nextSibling: i,
                    parentNode: l,
                    querySelector: c
                }
            }, a) {
                const u = t.target = wo(t.props, c);
                if (u) {
                    const c = u._lpa || u.firstChild;
                    16 & t.shapeFlag && (xo(t.props) ? (t.anchor = a(i(e), t, l(e), n, o, r, s), t.targetAnchor = c) : (t.anchor = i(e), t.targetAnchor = a(c, t, u, n, o, r, s)), u._lpa = t.targetAnchor && i(t.targetAnchor))
                }
                return t.anchor && i(t.anchor)
            }
        },
        No = "components";
    const Eo = Symbol();

    function $o(e, t, n = !0, o = !1) {
        const r = jt || ur;
        if (r) {
            const n = r.type;
            if (e === No) {
                const e = wr(n);
                if (e && (e === t || e === D(t) || e === K(D(t)))) return n
            }
            const s = Oo(r[e] || n[e], t) || Oo(r.appContext[e], t);
            return !s && o ? n : s
        }
    }

    function Oo(e, t) {
        return e && (e[t] || e[D(t)] || e[K(D(t))])
    }
    const Ro = Symbol(void 0),
        Ao = Symbol(void 0),
        Fo = Symbol(void 0),
        Mo = Symbol(void 0),
        Po = [];
    let Vo = null;

    function Io(e = !1) {
        Po.push(Vo = e ? null : [])
    }

    function Bo() {
        Po.pop(), Vo = Po[Po.length - 1] || null
    }
    let Lo = 1;

    function jo(e) {
        Lo += e
    }

    function Uo(e) {
        return e.dynamicChildren = Lo > 0 ? Vo || v : null, Bo(), Lo > 0 && Vo && Vo.push(e), e
    }

    function Ho(e, t, n, o, r) {
        return Uo(Jo(e, t, n, o, r, !0))
    }

    function Do(e) {
        return !!e && !0 === e.__v_isVNode
    }

    function Wo(e, t) {
        return e.type === t.type && e.key === t.key
    }
    const zo = "__vInternal",
        Ko = ({
            key: e
        }) => null != e ? e : null,
        Go = ({
            ref: e
        }) => null != e ? A(e) || wt(e) || R(e) ? {
            i: jt,
            r: e
        } : e : null;

    function qo(e, t = null, n = null, o = 0, r = null, s = (e === Ro ? 0 : 1), i = !1, l = !1) {
        const c = {
            __v_isVNode: !0,
            __v_skip: !0,
            type: e,
            props: t,
            key: t && Ko(t),
            ref: t && Go(t),
            scopeId: Ut,
            slotScopeIds: null,
            children: n,
            component: null,
            suspense: null,
            ssContent: null,
            ssFallback: null,
            dirs: null,
            transition: null,
            el: null,
            anchor: null,
            target: null,
            targetAnchor: null,
            staticCount: 0,
            shapeFlag: s,
            patchFlag: o,
            dynamicProps: r,
            dynamicChildren: null,
            appContext: null
        };
        return l ? (tr(c, n), 128 & s && e.normalize(c)) : n && (c.shapeFlag |= A(n) ? 8 : 16), Lo > 0 && !i && Vo && (c.patchFlag > 0 || 6 & s) && 32 !== c.patchFlag && Vo.push(c), c
    }
    const Jo = function(e, t = null, n = null, o = 0, r = null, i = !1) {
        e && e !== Eo || (e = Fo);
        if (Do(e)) {
            const o = Zo(e, t, !0);
            return n && tr(o, n), o
        }
        l = e, R(l) && "__vccOpts" in l && (e = e.__vccOpts);
        var l;
        if (t) {
            t = Yo(t);
            let {
                class: e,
                style: n
            } = t;
            e && !A(e) && (t.class = a(e)), M(n) && (vt(n) && !N(n) && (n = C({}, n)), t.style = s(n))
        }
        const c = A(e) ? 1 : (e => e.__isSuspense)(e) ? 128 : (e => e.__isTeleport)(e) ? 64 : M(e) ? 4 : R(e) ? 2 : 0;
        return qo(e, t, n, o, r, c, i, !0)
    };

    function Yo(e) {
        return e ? vt(e) || zo in e ? C({}, e) : e : null
    }

    function Zo(e, t, n = !1) {
        const {
            props: o,
            ref: r,
            patchFlag: s,
            children: i
        } = e, l = t ? nr(o || {}, t) : o;
        return {
            __v_isVNode: !0,
            __v_skip: !0,
            type: e.type,
            props: l,
            key: l && Ko(l),
            ref: t && t.ref ? n && r ? N(r) ? r.concat(Go(t)) : [r, Go(t)] : Go(t) : r,
            scopeId: e.scopeId,
            slotScopeIds: e.slotScopeIds,
            children: i,
            target: e.target,
            targetAnchor: e.targetAnchor,
            staticCount: e.staticCount,
            shapeFlag: e.shapeFlag,
            patchFlag: t && e.type !== Ro ? -1 === s ? 16 : 16 | s : s,
            dynamicProps: e.dynamicProps,
            dynamicChildren: e.dynamicChildren,
            appContext: e.appContext,
            dirs: e.dirs,
            transition: e.transition,
            component: e.component,
            suspense: e.suspense,
            ssContent: e.ssContent && Zo(e.ssContent),
            ssFallback: e.ssFallback && Zo(e.ssFallback),
            el: e.el,
            anchor: e.anchor
        }
    }

    function Qo(e = " ", t = 0) {
        return Jo(Ao, null, e, t)
    }

    function Xo(e) {
        return null == e || "boolean" == typeof e ? Jo(Fo) : N(e) ? Jo(Ro, null, e.slice()) : "object" == typeof e ? er(e) : Jo(Ao, null, String(e))
    }

    function er(e) {
        return null === e.el || e.memo ? e : Zo(e)
    }

    function tr(e, t) {
        let n = 0;
        const {
            shapeFlag: o
        } = e;
        if (null == t) t = null;
        else if (N(t)) n = 16;
        else if ("object" == typeof t) {
            if (65 & o) {
                const n = t.default;
                return void(n && (n._c && (n._d = !1), tr(e, n()), n._c && (n._d = !0)))
            } {
                n = 32;
                const o = t._;
                o || zo in t ? 3 === o && jt && (1 === jt.slots._ ? t._ = 1 : (t._ = 2, e.patchFlag |= 1024)) : t._ctx = jt
            }
        } else R(t) ? (t = {
            default: t,
            _ctx: jt
        }, n = 32) : (t = String(t), 64 & o ? (n = 16, t = [Qo(t)]) : n = 8);
        e.children = t, e.shapeFlag |= n
    }

    function nr(...e) {
        const t = {};
        for (let n = 0; n < e.length; n++) {
            const o = e[n];
            for (const e in o)
                if ("class" === e) t.class !== o.class && (t.class = a([t.class, o.class]));
                else if ("style" === e) t.style = s([t.style, o.style]);
            else if (S(e)) {
                const n = t[e],
                    r = o[e];
                n === r || N(n) && n.includes(r) || (t[e] = n ? [].concat(n, r) : r)
            } else "" !== e && (t[e] = o[e])
        }
        return t
    }

    function or(e) {
        return e.some((e => !Do(e) || e.type !== Fo && !(e.type === Ro && !or(e.children)))) ? e : null
    }
    const rr = e => e ? hr(e) ? xr(e) || e.proxy : rr(e.parent) : null,
        sr = C(Object.create(null), {
            $: e => e,
            $el: e => e.vnode.el,
            $data: e => e.data,
            $props: e => e.props,
            $attrs: e => e.attrs,
            $slots: e => e.slots,
            $refs: e => e.refs,
            $parent: e => rr(e.parent),
            $root: e => rr(e.root),
            $emit: e => e.emit,
            $options: e => Un(e),
            $forceUpdate: e => () => Kr(e.update),
            $nextTick: e => zr.bind(e.proxy),
            $watch: e => rs.bind(e)
        }),
        ir = {
            get({
                _: e
            }, t) {
                const {
                    ctx: n,
                    setupState: o,
                    data: r,
                    props: s,
                    accessCache: i,
                    type: l,
                    appContext: c
                } = e;
                let a;
                if ("$" !== t[0]) {
                    const l = i[t];
                    if (void 0 !== l) switch (l) {
                        case 0:
                            return o[t];
                        case 1:
                            return r[t];
                        case 3:
                            return n[t];
                        case 2:
                            return s[t]
                    } else {
                        if (o !== g && T(o, t)) return i[t] = 0, o[t];
                        if (r !== g && T(r, t)) return i[t] = 1, r[t];
                        if ((a = e.propsOptions[0]) && T(a, t)) return i[t] = 2, s[t];
                        if (n !== g && T(n, t)) return i[t] = 3, n[t];
                        In && (i[t] = 4)
                    }
                }
                const u = sr[t];
                let p, f;
                return u ? ("$attrs" === t && be(e, 0, t), u(e)) : (p = l.__cssModules) && (p = p[t]) ? p : n !== g && T(n, t) ? (i[t] = 3, n[t]) : (f = c.config.globalProperties, T(f, t) ? f[t] : void 0)
            },
            set({
                _: e
            }, t, n) {
                const {
                    data: o,
                    setupState: r,
                    ctx: s
                } = e;
                if (r !== g && T(r, t)) r[t] = n;
                else if (o !== g && T(o, t)) o[t] = n;
                else if (T(e.props, t)) return !1;
                return ("$" !== t[0] || !(t.slice(1) in e)) && (s[t] = n, !0)
            },
            has({
                _: {
                    data: e,
                    setupState: t,
                    accessCache: n,
                    ctx: o,
                    appContext: r,
                    propsOptions: s
                }
            }, i) {
                let l;
                return void 0 !== n[i] || e !== g && T(e, i) || t !== g && T(t, i) || (l = s[0]) && T(l, i) || T(o, i) || T(sr, i) || T(r.config.globalProperties, i)
            }
        },
        lr = C({}, ir, {
            get(e, t) {
                if (t !== Symbol.unscopables) return ir.get(e, t, e)
            },
            has: (e, t) => "_" !== t[0] && !n(t)
        }),
        cr = lo();
    let ar = 0;
    let ur = null;
    const pr = () => ur || jt,
        fr = e => {
            ur = e, e.scope.on()
        },
        dr = () => {
            ur && ur.scope.off(), ur = null
        };

    function hr(e) {
        return 4 & e.vnode.shapeFlag
    }
    let mr, gr, vr = !1;

    function yr(e, t, n) {
        R(t) ? e.render = t : M(t) && (e.setupState = Ot(t)), _r(e, n)
    }

    function br(e) {
        mr = e, gr = e => {
            e.render._rc && (e.withProxy = new Proxy(e.ctx, lr))
        }
    }

    function _r(e, t, n) {
        const o = e.type;
        if (!e.render) {
            if (!t && mr && !o.render) {
                const t = o.template;
                if (t) {
                    const {
                        isCustomElement: n,
                        compilerOptions: r
                    } = e.appContext.config, {
                        delimiters: s,
                        compilerOptions: i
                    } = o, l = C(C({
                        isCustomElement: n,
                        delimiters: s
                    }, r), i);
                    o.render = mr(t, l)
                }
            }
            e.render = o.render || y, gr && gr(e)
        }
        fr(e), ve(), Bn(e), ye(), dr()
    }

    function Sr(e) {
        const t = t => {
            e.exposed = t || {}
        };
        let n;
        return {
            get attrs() {
                return n || (n = function(e) {
                    return new Proxy(e.attrs, {
                        get: (t, n) => (be(e, 0, "$attrs"), t[n])
                    })
                }(e))
            },
            slots: e.slots,
            emit: e.emit,
            expose: t
        }
    }

    function xr(e) {
        if (e.exposed) return e.exposeProxy || (e.exposeProxy = new Proxy(Ot(bt(e.exposed)), {
            get: (t, n) => n in t ? t[n] : n in sr ? sr[n](e) : void 0
        }))
    }
    const Cr = /(?:^|[-_])(\w)/g;

    function wr(e) {
        return R(e) && e.displayName || e.name
    }

    function kr(e, t, n = !1) {
        let o = wr(t);
        if (!o && t.__file) {
            const e = t.__file.match(/([^/\\]+)\.\w+$/);
            e && (o = e[1])
        }
        if (!o && e && e.parent) {
            const n = e => {
                for (const n in e)
                    if (e[n] === t) return n
            };
            o = n(e.components || e.parent.type.components) || n(e.appContext.components)
        }
        return o ? o.replace(Cr, (e => e.toUpperCase())).replace(/[-_]/g, "") : n ? "App" : "Anonymous"
    }
    const Tr = [];

    function Nr(e) {
        const t = [],
            n = Object.keys(e);
        return n.slice(0, 3).forEach((n => {
            t.push(...Er(n, e[n]))
        })), n.length > 3 && t.push(" ..."), t
    }

    function Er(e, t, n) {
        return A(t) ? (t = JSON.stringify(t), n ? t : [`${e}=${t}`]) : "number" == typeof t || "boolean" == typeof t || null == t ? n ? t : [`${e}=${t}`] : wt(t) ? (t = Er(e, yt(t.value), !0), n ? t : [`${e}=Ref<`, t, ">"]) : R(t) ? [`${e}=fn${t.name?`<${t.name}>`:""}`] : (t = yt(t), n ? t : [`${e}=`, t])
    }

    function $r(e, t, n, o) {
        let r;
        try {
            r = o ? e(...o) : e()
        } catch (s) {
            Rr(s, t, n)
        }
        return r
    }

    function Or(e, t, n, o) {
        if (R(e)) {
            const r = $r(e, t, n, o);
            return r && P(r) && r.catch((e => {
                Rr(e, t, n)
            })), r
        }
        const r = [];
        for (let s = 0; s < e.length; s++) r.push(Or(e[s], t, n, o));
        return r
    }

    function Rr(e, t, n, o = !0) {
        if (t) {
            let o = t.parent;
            const r = t.proxy,
                s = n;
            for (; o;) {
                const t = o.ec;
                if (t)
                    for (let n = 0; n < t.length; n++)
                        if (!1 === t[n](e, r, s)) return;
                o = o.parent
            }
            const i = t.appContext.config.errorHandler;
            if (i) return void $r(i, null, 10, [e, r, s])
        }! function(e, t, n, o = !0) {
            console.error(e)
        }(e, 0, 0, o)
    }
    let Ar = !1,
        Fr = !1;
    const Mr = [];
    let Pr = 0;
    const Vr = [];
    let Ir = null,
        Br = 0;
    const Lr = [];
    let jr = null,
        Ur = 0;
    const Hr = Promise.resolve();
    let Dr = null,
        Wr = null;

    function zr(e) {
        const t = Dr || Hr;
        return e ? t.then(this ? e.bind(this) : e) : t
    }

    function Kr(e) {
        Mr.length && Mr.includes(e, Ar && e.allowRecurse ? Pr + 1 : Pr) || e === Wr || (null == e.id ? Mr.push(e) : Mr.splice(function(e) {
            let t = Pr + 1,
                n = Mr.length;
            for (; t < n;) {
                const o = t + n >>> 1;
                Qr(Mr[o]) < e ? t = o + 1 : n = o
            }
            return t
        }(e.id), 0, e), Gr())
    }

    function Gr() {
        Ar || Fr || (Fr = !0, Dr = Hr.then(Xr))
    }

    function qr(e, t, n, o) {
        N(e) ? n.push(...e) : t && t.includes(e, e.allowRecurse ? o + 1 : o) || n.push(e), Gr()
    }

    function Jr(e) {
        qr(e, jr, Lr, Ur)
    }

    function Yr(e, t = null) {
        if (Vr.length) {
            for (Wr = t, Ir = [...new Set(Vr)], Vr.length = 0, Br = 0; Br < Ir.length; Br++) Ir[Br]();
            Ir = null, Br = 0, Wr = null, Yr(e, t)
        }
    }

    function Zr(e) {
        if (Lr.length) {
            const e = [...new Set(Lr)];
            if (Lr.length = 0, jr) return void jr.push(...e);
            for (jr = e, jr.sort(((e, t) => Qr(e) - Qr(t))), Ur = 0; Ur < jr.length; Ur++) jr[Ur]();
            jr = null, Ur = 0
        }
    }
    const Qr = e => null == e.id ? 1 / 0 : e.id;

    function Xr(e) {
        Fr = !1, Ar = !0, Yr(e), Mr.sort(((e, t) => Qr(e) - Qr(t)));
        try {
            for (Pr = 0; Pr < Mr.length; Pr++) {
                const e = Mr[Pr];
                e && !1 !== e.active && $r(e, null, 14)
            }
        } finally {
            Pr = 0, Mr.length = 0, Zr(), Ar = !1, Dr = null, (Mr.length || Vr.length || Lr.length) && Xr(e)
        }
    }

    function es(e, t) {
        return os(e, null, {
            flush: "post"
        })
    }
    const ts = {};

    function ns(e, t, n) {
        return os(e, t, n)
    }

    function os(e, t, {
        immediate: n,
        deep: o,
        flush: r
    } = g) {
        const s = ur;
        let i, l, c = !1,
            a = !1;
        if (wt(e) ? (i = () => e.value, c = !!e._shallow) : mt(e) ? (i = () => e, o = !0) : N(e) ? (a = !0, c = e.some(mt), i = () => e.map((e => wt(e) ? e.value : mt(e) ? is(e) : R(e) ? $r(e, s, 2) : void 0))) : i = R(e) ? t ? () => $r(e, s, 2) : () => {
                if (!s || !s.isUnmounted) return l && l(), Or(e, s, 3, [u])
            } : y, t && o) {
            const e = i;
            i = () => is(e())
        }
        let u = e => {
                l = h.onStop = () => {
                    $r(e, s, 4)
                }
            },
            p = a ? [] : ts;
        const f = () => {
            if (h.active)
                if (t) {
                    const e = h.run();
                    (o || c || (a ? e.some(((e, t) => q(e, p[t]))) : q(e, p))) && (l && l(), Or(t, s, 3, [e, p === ts ? void 0 : p, u]), p = e)
                } else h.run()
        };
        let d;
        f.allowRecurse = !!t, d = "sync" === r ? f : "post" === r ? () => mo(f, s && s.suspense) : () => {
            !s || s.isMounted ? function(e) {
                qr(e, Ir, Vr, Br)
            }(f) : f()
        };
        const h = new de(i, d);
        return t ? n ? f() : p = h.run() : "post" === r ? mo(h.run.bind(h), s && s.suspense) : h.run(), () => {
            h.stop(), s && s.scope && w(s.scope.effects, h)
        }
    }

    function rs(e, t, n) {
        const o = this.proxy,
            r = A(e) ? e.includes(".") ? ss(o, e) : () => o[e] : e.bind(o, o);
        let s;
        R(t) ? s = t : (s = t.handler, n = t);
        const i = ur;
        fr(this);
        const l = os(r, s.bind(o), n);
        return i ? fr(i) : dr(), l
    }

    function ss(e, t) {
        const n = t.split(".");
        return () => {
            let t = e;
            for (let e = 0; e < n.length && t; e++) t = t[n[e]];
            return t
        }
    }

    function is(e, t) {
        if (!M(e) || e.__v_skip) return e;
        if ((t = t || new Set).has(e)) return e;
        if (t.add(e), wt(e)) is(e.value, t);
        else if (N(e))
            for (let n = 0; n < e.length; n++) is(e[n], t);
        else if ($(e) || E(e)) e.forEach((e => {
            is(e, t)
        }));
        else if (B(e))
            for (const n in e) is(e[n], t);
        return e
    }

    function ls() {
        const e = pr();
        return e.setupContext || (e.setupContext = Sr(e))
    }

    function cs(e, t, n) {
        const o = arguments.length;
        return 2 === o ? M(t) && !N(t) ? Do(t) ? Jo(e, null, [t]) : Jo(e, t) : Jo(e, null, t) : (o > 3 ? n = Array.prototype.slice.call(arguments, 2) : 3 === o && Do(n) && (n = [n]), Jo(e, t, n))
    }
    const as = Symbol("");

    function us(e, t) {
        const n = e.memo;
        if (n.length != t.length) return !1;
        for (let o = 0; o < n.length; o++)
            if (n[o] !== t[o]) return !1;
        return Lo > 0 && Vo && Vo.push(e), !0
    }
    const ps = "3.2.22",
        fs = "undefined" != typeof document ? document : null,
        ds = new Map,
        hs = {
            insert: (e, t, n) => {
                t.insertBefore(e, n || null)
            },
            remove: e => {
                const t = e.parentNode;
                t && t.removeChild(e)
            },
            createElement: (e, t, n, o) => {
                const r = t ? fs.createElementNS("http://www.w3.org/2000/svg", e) : fs.createElement(e, n ? {
                    is: n
                } : void 0);
                return "select" === e && o && null != o.multiple && r.setAttribute("multiple", o.multiple), r
            },
            createText: e => fs.createTextNode(e),
            createComment: e => fs.createComment(e),
            setText: (e, t) => {
                e.nodeValue = t
            },
            setElementText: (e, t) => {
                e.textContent = t
            },
            parentNode: e => e.parentNode,
            nextSibling: e => e.nextSibling,
            querySelector: e => fs.querySelector(e),
            setScopeId(e, t) {
                e.setAttribute(t, "")
            },
            cloneNode(e) {
                const t = e.cloneNode(!0);
                return "_value" in e && (t._value = e._value), t
            },
            insertStaticContent(e, t, n, o) {
                const r = n ? n.previousSibling : t.lastChild;
                let s = ds.get(e);
                if (!s) {
                    const t = fs.createElement("template");
                    if (t.innerHTML = o ? `<svg>${e}</svg>` : e, s = t.content, o) {
                        const e = s.firstChild;
                        for (; e.firstChild;) s.appendChild(e.firstChild);
                        s.removeChild(e)
                    }
                    ds.set(e, s)
                }
                return t.insertBefore(s.cloneNode(!0), n), [r ? r.nextSibling : t.firstChild, n ? n.previousSibling : t.lastChild]
            }
        };
    const ms = /\s*!important$/;

    function gs(e, t, n) {
        if (N(n)) n.forEach((n => gs(e, t, n)));
        else if (t.startsWith("--")) e.setProperty(t, n);
        else {
            const o = function(e, t) {
                const n = ys[t];
                if (n) return n;
                let o = D(t);
                if ("filter" !== o && o in e) return ys[t] = o;
                o = K(o);
                for (let r = 0; r < vs.length; r++) {
                    const n = vs[r] + o;
                    if (n in e) return ys[t] = n
                }
                return t
            }(e, t);
            ms.test(n) ? e.setProperty(z(o), n.replace(ms, ""), "important") : e[o] = n
        }
    }
    const vs = ["Webkit", "Moz", "ms"],
        ys = {};
    const bs = "http://www.w3.org/1999/xlink";
    let _s = Date.now,
        Ss = !1;
    if ("undefined" != typeof window) {
        _s() > document.createEvent("Event").timeStamp && (_s = () => performance.now());
        const e = navigator.userAgent.match(/firefox\/(\d+)/i);
        Ss = !!(e && Number(e[1]) <= 53)
    }
    let xs = 0;
    const Cs = Promise.resolve(),
        ws = () => {
            xs = 0
        };

    function ks(e, t, n, o) {
        e.addEventListener(t, n, o)
    }

    function Ts(e, t, n, o, r = null) {
        const s = e._vei || (e._vei = {}),
            i = s[t];
        if (o && i) i.value = o;
        else {
            const [n, l] = function(e) {
                let t;
                if (Ns.test(e)) {
                    let n;
                    for (t = {}; n = e.match(Ns);) e = e.slice(0, e.length - n[0].length), t[n[0].toLowerCase()] = !0
                }
                return [z(e.slice(2)), t]
            }(t);
            if (o) {
                const i = s[t] = function(e, t) {
                    const n = e => {
                        const o = e.timeStamp || _s();
                        (Ss || o >= n.attached - 1) && Or(function(e, t) {
                            if (N(t)) {
                                const n = e.stopImmediatePropagation;
                                return e.stopImmediatePropagation = () => {
                                    n.call(e), e._stopped = !0
                                }, t.map((e => t => !t._stopped && e(t)))
                            }
                            return t
                        }(e, n.value), t, 5, [e])
                    };
                    return n.value = e, n.attached = (() => xs || (Cs.then(ws), xs = _s()))(), n
                }(o, r);
                ks(e, n, i, l)
            } else i && (! function(e, t, n, o) {
                e.removeEventListener(t, n, o)
            }(e, n, i, l), s[t] = void 0)
        }
    }
    const Ns = /(?:Once|Passive|Capture)$/;
    const Es = /^on[a-z]/;

    function $s(e, t) {
        const n = dn(e);
        class o extends Rs {
            constructor(e) {
                super(n, e, t)
            }
        }
        return o.def = n, o
    }
    const Os = "undefined" != typeof HTMLElement ? HTMLElement : class {};
    class Rs extends Os {
        constructor(e, t = {}, n) {
            super(), this._def = e, this._props = t, this._instance = null, this._connected = !1, this._resolved = !1, this._numberProps = null, this.shadowRoot && n ? n(this._createVNode(), this.shadowRoot) : this.attachShadow({
                mode: "open"
            })
        }
        connectedCallback() {
            this._connected = !0, this._instance || this._resolveDef()
        }
        disconnectedCallback() {
            this._connected = !1, zr((() => {
                this._connected || (Ni(null, this.shadowRoot), this._instance = null)
            }))
        }
        _resolveDef() {
            if (this._resolved) return;
            this._resolved = !0;
            for (let n = 0; n < this.attributes.length; n++) this._setAttr(this.attributes[n].name);
            new MutationObserver((e => {
                for (const t of e) this._setAttr(t.attributeName)
            })).observe(this, {
                attributes: !0
            });
            const e = e => {
                    const {
                        props: t,
                        styles: n
                    } = e, o = !N(t), r = t ? o ? Object.keys(t) : t : [];
                    let s;
                    if (o)
                        for (const i in this._props) {
                            const e = t[i];
                            (e === Number || e && e.type === Number) && (this._props[i] = Z(this._props[i]), (s || (s = Object.create(null)))[i] = !0)
                        }
                    this._numberProps = s;
                    for (const i of Object.keys(this)) "_" !== i[0] && this._setProp(i, this[i], !0, !1);
                    for (const i of r.map(D)) Object.defineProperty(this, i, {
                        get() {
                            return this._getProp(i)
                        },
                        set(e) {
                            this._setProp(i, e)
                        }
                    });
                    this._applyStyles(n), this._update()
                },
                t = this._def.__asyncLoader;
            t ? t().then(e) : e(this._def)
        }
        _setAttr(e) {
            let t = this.getAttribute(e);
            this._numberProps && this._numberProps[e] && (t = Z(t)), this._setProp(D(e), t, !1)
        }
        _getProp(e) {
            return this._props[e]
        }
        _setProp(e, t, n = !0, o = !0) {
            t !== this._props[e] && (this._props[e] = t, o && this._instance && this._update(), n && (!0 === t ? this.setAttribute(z(e), "") : "string" == typeof t || "number" == typeof t ? this.setAttribute(z(e), t + "") : t || this.removeAttribute(z(e))))
        }
        _update() {
            Ni(this._createVNode(), this.shadowRoot)
        }
        _createVNode() {
            const e = Jo(this._def, C({}, this._props));
            return this._instance || (e.ce = e => {
                this._instance = e, e.isCE = !0, e.emit = (e, ...t) => {
                    this.dispatchEvent(new CustomEvent(e, {
                        detail: t
                    }))
                };
                let t = this;
                for (; t = t && (t.parentNode || t.host);)
                    if (t instanceof Rs) {
                        e.parent = t._instance;
                        break
                    }
            }), e
        }
        _applyStyles(e) {
            e && e.forEach((e => {
                const t = document.createElement("style");
                t.textContent = e, this.shadowRoot.appendChild(t)
            }))
        }
    }

    function As(e, t) {
        if (128 & e.shapeFlag) {
            const n = e.suspense;
            e = n.activeBranch, n.pendingBranch && !n.isHydrating && n.effects.push((() => {
                As(n.activeBranch, t)
            }))
        }
        for (; e.component;) e = e.component.subTree;
        if (1 & e.shapeFlag && e.el) Fs(e.el, t);
        else if (e.type === Ro) e.children.forEach((e => As(e, t)));
        else if (e.type === Mo) {
            let {
                el: n,
                anchor: o
            } = e;
            for (; n && (Fs(n, t), n !== o);) n = n.nextSibling
        }
    }

    function Fs(e, t) {
        if (1 === e.nodeType) {
            const n = e.style;
            for (const e in t) n.setProperty(`--${e}`, t[e])
        }
    }
    const Ms = "transition",
        Ps = "animation",
        Vs = (e, {
            slots: t
        }) => cs(sn, Us(e), t);
    Vs.displayName = "Transition";
    const Is = {
            name: String,
            type: String,
            css: {
                type: Boolean,
                default: !0
            },
            duration: [String, Number, Object],
            enterFromClass: String,
            enterActiveClass: String,
            enterToClass: String,
            appearFromClass: String,
            appearActiveClass: String,
            appearToClass: String,
            leaveFromClass: String,
            leaveActiveClass: String,
            leaveToClass: String
        },
        Bs = Vs.props = C({}, sn.props, Is),
        Ls = (e, t = []) => {
            N(e) ? e.forEach((e => e(...t))) : e && e(...t)
        },
        js = e => !!e && (N(e) ? e.some((e => e.length > 1)) : e.length > 1);

    function Us(e) {
        const t = {};
        for (const C in e) C in Is || (t[C] = e[C]);
        if (!1 === e.css) return t;
        const {
            name: n = "v",
            type: o,
            duration: r,
            enterFromClass: s = `${n}-enter-from`,
            enterActiveClass: i = `${n}-enter-active`,
            enterToClass: l = `${n}-enter-to`,
            appearFromClass: c = s,
            appearActiveClass: a = i,
            appearToClass: u = l,
            leaveFromClass: p = `${n}-leave-from`,
            leaveActiveClass: f = `${n}-leave-active`,
            leaveToClass: d = `${n}-leave-to`
        } = e, h = function(e) {
            if (null == e) return null;
            if (M(e)) return [Hs(e.enter), Hs(e.leave)]; {
                const t = Hs(e);
                return [t, t]
            }
        }(r), m = h && h[0], g = h && h[1], {
            onBeforeEnter: v,
            onEnter: y,
            onEnterCancelled: b,
            onLeave: _,
            onLeaveCancelled: S,
            onBeforeAppear: x = v,
            onAppear: w = y,
            onAppearCancelled: k = b
        } = t, T = (e, t, n) => {
            Ws(e, t ? u : l), Ws(e, t ? a : i), n && n()
        }, N = (e, t) => {
            Ws(e, d), Ws(e, f), t && t()
        }, E = e => (t, n) => {
            const r = e ? w : y,
                i = () => T(t, e, n);
            Ls(r, [t, i]), zs((() => {
                Ws(t, e ? c : s), Ds(t, e ? u : l), js(r) || Gs(t, o, m, i)
            }))
        };
        return C(t, {
            onBeforeEnter(e) {
                Ls(v, [e]), Ds(e, s), Ds(e, i)
            },
            onBeforeAppear(e) {
                Ls(x, [e]), Ds(e, c), Ds(e, a)
            },
            onEnter: E(!1),
            onAppear: E(!0),
            onLeave(e, t) {
                const n = () => N(e, t);
                Ds(e, p), Zs(), Ds(e, f), zs((() => {
                    Ws(e, p), Ds(e, d), js(_) || Gs(e, o, g, n)
                })), Ls(_, [e, n])
            },
            onEnterCancelled(e) {
                T(e, !1), Ls(b, [e])
            },
            onAppearCancelled(e) {
                T(e, !0), Ls(k, [e])
            },
            onLeaveCancelled(e) {
                N(e), Ls(S, [e])
            }
        })
    }

    function Hs(e) {
        return Z(e)
    }

    function Ds(e, t) {
        t.split(/\s+/).forEach((t => t && e.classList.add(t))), (e._vtc || (e._vtc = new Set)).add(t)
    }

    function Ws(e, t) {
        t.split(/\s+/).forEach((t => t && e.classList.remove(t)));
        const {
            _vtc: n
        } = e;
        n && (n.delete(t), n.size || (e._vtc = void 0))
    }

    function zs(e) {
        requestAnimationFrame((() => {
            requestAnimationFrame(e)
        }))
    }
    let Ks = 0;

    function Gs(e, t, n, o) {
        const r = e._endId = ++Ks,
            s = () => {
                r === e._endId && o()
            };
        if (n) return setTimeout(s, n);
        const {
            type: i,
            timeout: l,
            propCount: c
        } = qs(e, t);
        if (!i) return o();
        const a = i + "end";
        let u = 0;
        const p = () => {
                e.removeEventListener(a, f), s()
            },
            f = t => {
                t.target === e && ++u >= c && p()
            };
        setTimeout((() => {
            u < c && p()
        }), l + 1), e.addEventListener(a, f)
    }

    function qs(e, t) {
        const n = window.getComputedStyle(e),
            o = e => (n[e] || "").split(", "),
            r = o("transitionDelay"),
            s = o("transitionDuration"),
            i = Js(r, s),
            l = o("animationDelay"),
            c = o("animationDuration"),
            a = Js(l, c);
        let u = null,
            p = 0,
            f = 0;
        t === Ms ? i > 0 && (u = Ms, p = i, f = s.length) : t === Ps ? a > 0 && (u = Ps, p = a, f = c.length) : (p = Math.max(i, a), u = p > 0 ? i > a ? Ms : Ps : null, f = u ? u === Ms ? s.length : c.length : 0);
        return {
            type: u,
            timeout: p,
            propCount: f,
            hasTransform: u === Ms && /\b(transform|all)(,|$)/.test(n.transitionProperty)
        }
    }

    function Js(e, t) {
        for (; e.length < t.length;) e = e.concat(e);
        return Math.max(...t.map(((t, n) => Ys(t) + Ys(e[n]))))
    }

    function Ys(e) {
        return 1e3 * Number(e.slice(0, -1).replace(",", "."))
    }

    function Zs() {
        return document.body.offsetHeight
    }
    const Qs = new WeakMap,
        Xs = new WeakMap,
        ei = {
            name: "TransitionGroup",
            props: C({}, Bs, {
                tag: String,
                moveClass: String
            }),
            setup(e, {
                slots: t
            }) {
                const n = pr(),
                    o = on();
                let r, s;
                return On((() => {
                    if (!r.length) return;
                    const t = e.moveClass || `${e.name||"v"}-move`;
                    if (! function(e, t, n) {
                            const o = e.cloneNode();
                            e._vtc && e._vtc.forEach((e => {
                                e.split(/\s+/).forEach((e => e && o.classList.remove(e)))
                            }));
                            n.split(/\s+/).forEach((e => e && o.classList.add(e))), o.style.display = "none";
                            const r = 1 === t.nodeType ? t : t.parentNode;
                            r.appendChild(o);
                            const {
                                hasTransform: s
                            } = qs(o);
                            return r.removeChild(o), s
                        }(r[0].el, n.vnode.el, t)) return;
                    r.forEach(ti), r.forEach(ni);
                    const o = r.filter(oi);
                    Zs(), o.forEach((e => {
                        const n = e.el,
                            o = n.style;
                        Ds(n, t), o.transform = o.webkitTransform = o.transitionDuration = "";
                        const r = n._moveCb = e => {
                            e && e.target !== n || e && !/transform$/.test(e.propertyName) || (n.removeEventListener("transitionend", r), n._moveCb = null, Ws(n, t))
                        };
                        n.addEventListener("transitionend", r)
                    }))
                })), () => {
                    const i = yt(e),
                        l = Us(i);
                    let c = i.tag || Ro;
                    r = s, s = t.default ? fn(t.default()) : [];
                    for (let e = 0; e < s.length; e++) {
                        const t = s[e];
                        null != t.key && pn(t, cn(t, l, o, n))
                    }
                    if (r)
                        for (let e = 0; e < r.length; e++) {
                            const t = r[e];
                            pn(t, cn(t, l, o, n)), Qs.set(t, t.el.getBoundingClientRect())
                        }
                    return Jo(c, null, s)
                }
            }
        };

    function ti(e) {
        const t = e.el;
        t._moveCb && t._moveCb(), t._enterCb && t._enterCb()
    }

    function ni(e) {
        Xs.set(e, e.el.getBoundingClientRect())
    }

    function oi(e) {
        const t = Qs.get(e),
            n = Xs.get(e),
            o = t.left - n.left,
            r = t.top - n.top;
        if (o || r) {
            const t = e.el.style;
            return t.transform = t.webkitTransform = `translate(${o}px,${r}px)`, t.transitionDuration = "0s", e
        }
    }
    const ri = e => {
        const t = e.props["onUpdate:modelValue"];
        return N(t) ? e => J(t, e) : t
    };

    function si(e) {
        e.target.composing = !0
    }

    function ii(e) {
        const t = e.target;
        t.composing && (t.composing = !1, function(e, t) {
            const n = document.createEvent("HTMLEvents");
            n.initEvent(t, !0, !0), e.dispatchEvent(n)
        }(t, "input"))
    }
    const li = {
            created(e, {
                modifiers: {
                    lazy: t,
                    trim: n,
                    number: o
                }
            }, r) {
                e._assign = ri(r);
                const s = o || r.props && "number" === r.props.type;
                ks(e, t ? "change" : "input", (t => {
                    if (t.target.composing) return;
                    let o = e.value;
                    n ? o = o.trim() : s && (o = Z(o)), e._assign(o)
                })), n && ks(e, "change", (() => {
                    e.value = e.value.trim()
                })), t || (ks(e, "compositionstart", si), ks(e, "compositionend", ii), ks(e, "change", ii))
            },
            mounted(e, {
                value: t
            }) {
                e.value = null == t ? "" : t
            },
            beforeUpdate(e, {
                value: t,
                modifiers: {
                    lazy: n,
                    trim: o,
                    number: r
                }
            }, s) {
                if (e._assign = ri(s), e.composing) return;
                if (document.activeElement === e) {
                    if (n) return;
                    if (o && e.value.trim() === t) return;
                    if ((r || "number" === e.type) && Z(e.value) === t) return
                }
                const i = null == t ? "" : t;
                e.value !== i && (e.value = i)
            }
        },
        ci = {
            deep: !0,
            created(e, t, n) {
                e._assign = ri(n), ks(e, "change", (() => {
                    const t = e._modelValue,
                        n = di(e),
                        o = e.checked,
                        r = e._assign;
                    if (N(t)) {
                        const e = h(t, n),
                            s = -1 !== e;
                        if (o && !s) r(t.concat(n));
                        else if (!o && s) {
                            const n = [...t];
                            n.splice(e, 1), r(n)
                        }
                    } else if ($(t)) {
                        const e = new Set(t);
                        o ? e.add(n) : e.delete(n), r(e)
                    } else r(hi(e, o))
                }))
            },
            mounted: ai,
            beforeUpdate(e, t, n) {
                e._assign = ri(n), ai(e, t, n)
            }
        };

    function ai(e, {
        value: t,
        oldValue: n
    }, o) {
        e._modelValue = t, N(t) ? e.checked = h(t, o.props.value) > -1 : $(t) ? e.checked = t.has(o.props.value) : t !== n && (e.checked = d(t, hi(e, !0)))
    }
    const ui = {
            created(e, {
                value: t
            }, n) {
                e.checked = d(t, n.props.value), e._assign = ri(n), ks(e, "change", (() => {
                    e._assign(di(e))
                }))
            },
            beforeUpdate(e, {
                value: t,
                oldValue: n
            }, o) {
                e._assign = ri(o), t !== n && (e.checked = d(t, o.props.value))
            }
        },
        pi = {
            deep: !0,
            created(e, {
                value: t,
                modifiers: {
                    number: n
                }
            }, o) {
                const r = $(t);
                ks(e, "change", (() => {
                    const t = Array.prototype.filter.call(e.options, (e => e.selected)).map((e => n ? Z(di(e)) : di(e)));
                    e._assign(e.multiple ? r ? new Set(t) : t : t[0])
                })), e._assign = ri(o)
            },
            mounted(e, {
                value: t
            }) {
                fi(e, t)
            },
            beforeUpdate(e, t, n) {
                e._assign = ri(n)
            },
            updated(e, {
                value: t
            }) {
                fi(e, t)
            }
        };

    function fi(e, t) {
        const n = e.multiple;
        if (!n || N(t) || $(t)) {
            for (let o = 0, r = e.options.length; o < r; o++) {
                const r = e.options[o],
                    s = di(r);
                if (n) r.selected = N(t) ? h(t, s) > -1 : t.has(s);
                else if (d(di(r), t)) return void(e.selectedIndex !== o && (e.selectedIndex = o))
            }
            n || -1 === e.selectedIndex || (e.selectedIndex = -1)
        }
    }

    function di(e) {
        return "_value" in e ? e._value : e.value
    }

    function hi(e, t) {
        const n = t ? "_trueValue" : "_falseValue";
        return n in e ? e[n] : t
    }
    const mi = {
        created(e, t, n) {
            gi(e, t, n, null, "created")
        },
        mounted(e, t, n) {
            gi(e, t, n, null, "mounted")
        },
        beforeUpdate(e, t, n, o) {
            gi(e, t, n, o, "beforeUpdate")
        },
        updated(e, t, n, o) {
            gi(e, t, n, o, "updated")
        }
    };

    function gi(e, t, n, o, r) {
        let s;
        switch (e.tagName) {
            case "SELECT":
                s = pi;
                break;
            case "TEXTAREA":
                s = li;
                break;
            default:
                switch (n.props && n.props.type) {
                    case "checkbox":
                        s = ci;
                        break;
                    case "radio":
                        s = ui;
                        break;
                    default:
                        s = li
                }
        }
        const i = s[r];
        i && i(e, t, n, o)
    }
    const vi = ["ctrl", "shift", "alt", "meta"],
        yi = {
            stop: e => e.stopPropagation(),
            prevent: e => e.preventDefault(),
            self: e => e.target !== e.currentTarget,
            ctrl: e => !e.ctrlKey,
            shift: e => !e.shiftKey,
            alt: e => !e.altKey,
            meta: e => !e.metaKey,
            left: e => "button" in e && 0 !== e.button,
            middle: e => "button" in e && 1 !== e.button,
            right: e => "button" in e && 2 !== e.button,
            exact: (e, t) => vi.some((n => e[`${n}Key`] && !t.includes(n)))
        },
        bi = {
            esc: "escape",
            space: " ",
            up: "arrow-up",
            left: "arrow-left",
            right: "arrow-right",
            down: "arrow-down",
            delete: "backspace"
        },
        _i = {
            beforeMount(e, {
                value: t
            }, {
                transition: n
            }) {
                e._vod = "none" === e.style.display ? "" : e.style.display, n && t ? n.beforeEnter(e) : Si(e, t)
            },
            mounted(e, {
                value: t
            }, {
                transition: n
            }) {
                n && t && n.enter(e)
            },
            updated(e, {
                value: t,
                oldValue: n
            }, {
                transition: o
            }) {
                !t != !n && (o ? t ? (o.beforeEnter(e), Si(e, !0), o.enter(e)) : o.leave(e, (() => {
                    Si(e, !1)
                })) : Si(e, t))
            },
            beforeUnmount(e, {
                value: t
            }) {
                Si(e, t)
            }
        };

    function Si(e, t) {
        e.style.display = t ? e._vod : "none"
    }
    const xi = C({
        patchProp: (e, t, n, s, i = !1, l, c, a, u) => {
            "class" === t ? function(e, t, n) {
                const o = e._vtc;
                o && (t = (t ? [t, ...o] : [...o]).join(" ")), null == t ? e.removeAttribute("class") : n ? e.setAttribute("class", t) : e.className = t
            }(e, s, i) : "style" === t ? function(e, t, n) {
                const o = e.style,
                    r = A(n);
                if (n && !r) {
                    for (const e in n) gs(o, e, n[e]);
                    if (t && !A(t))
                        for (const e in t) null == n[e] && gs(o, e, "")
                } else {
                    const s = o.display;
                    r ? t !== n && (o.cssText = n) : t && e.removeAttribute("style"), "_vod" in e && (o.display = s)
                }
            }(e, n, s) : S(t) ? x(t) || Ts(e, t, 0, s, c) : ("." === t[0] ? (t = t.slice(1), 1) : "^" === t[0] ? (t = t.slice(1), 0) : function(e, t, n, o) {
                if (o) return "innerHTML" === t || "textContent" === t || !!(t in e && Es.test(t) && R(n));
                if ("spellcheck" === t || "draggable" === t) return !1;
                if ("form" === t) return !1;
                if ("list" === t && "INPUT" === e.tagName) return !1;
                if ("type" === t && "TEXTAREA" === e.tagName) return !1;
                if (Es.test(t) && A(n)) return !1;
                return t in e
            }(e, t, s, i)) ? function(e, t, n, o, s, i, l) {
                if ("innerHTML" === t || "textContent" === t) return o && l(o, s, i), void(e[t] = null == n ? "" : n);
                if ("value" === t && "PROGRESS" !== e.tagName) {
                    e._value = n;
                    const o = null == n ? "" : n;
                    return e.value !== o && (e.value = o), void(null == n && e.removeAttribute(t))
                }
                if ("" === n || null == n) {
                    const o = typeof e[t];
                    if ("boolean" === o) return void(e[t] = r(n));
                    if (null == n && "string" === o) return e[t] = "", void e.removeAttribute(t);
                    if ("number" === o) {
                        try {
                            e[t] = 0
                        } catch (c) {}
                        return void e.removeAttribute(t)
                    }
                }
                try {
                    e[t] = n
                } catch (a) {}
            }(e, t, s, l, c, a, u) : ("true-value" === t ? e._trueValue = s : "false-value" === t && (e._falseValue = s), function(e, t, n, s, i) {
                if (s && t.startsWith("xlink:")) null == n ? e.removeAttributeNS(bs, t.slice(6, t.length)) : e.setAttributeNS(bs, t, n);
                else {
                    const s = o(t);
                    null == n || s && !r(n) ? e.removeAttribute(t) : e.setAttribute(t, s ? "" : n)
                }
            }(e, t, s, i))
        }
    }, hs);
    let Ci, wi = !1;

    function ki() {
        return Ci || (Ci = go(xi))
    }

    function Ti() {
        return Ci = wi ? Ci : vo(xi), wi = !0, Ci
    }
    const Ni = (...e) => {
            ki().render(...e)
        },
        Ei = (...e) => {
            Ti().hydrate(...e)
        };

    function $i(e) {
        if (A(e)) {
            return document.querySelector(e)
        }
        return e
    }
    const Oi = y;

    function Ri(e) {
        throw e
    }

    function Ai(e) {}

    function Fi(e, t, n, o) {
        const r = new SyntaxError(String(e));
        return r.code = e, r.loc = t, r
    }
    const Mi = Symbol(""),
        Pi = Symbol(""),
        Vi = Symbol(""),
        Ii = Symbol(""),
        Bi = Symbol(""),
        Li = Symbol(""),
        ji = Symbol(""),
        Ui = Symbol(""),
        Hi = Symbol(""),
        Di = Symbol(""),
        Wi = Symbol(""),
        zi = Symbol(""),
        Ki = Symbol(""),
        Gi = Symbol(""),
        qi = Symbol(""),
        Ji = Symbol(""),
        Yi = Symbol(""),
        Zi = Symbol(""),
        Qi = Symbol(""),
        Xi = Symbol(""),
        el = Symbol(""),
        tl = Symbol(""),
        nl = Symbol(""),
        ol = Symbol(""),
        rl = Symbol(""),
        sl = Symbol(""),
        il = Symbol(""),
        ll = Symbol(""),
        cl = Symbol(""),
        al = Symbol(""),
        ul = Symbol(""),
        pl = Symbol(""),
        fl = Symbol(""),
        dl = Symbol(""),
        hl = Symbol(""),
        ml = Symbol(""),
        gl = Symbol(""),
        vl = Symbol(""),
        yl = Symbol(""),
        bl = {
            [Mi]: "Fragment",
            [Pi]: "Teleport",
            [Vi]: "Suspense",
            [Ii]: "KeepAlive",
            [Bi]: "BaseTransition",
            [Li]: "openBlock",
            [ji]: "createBlock",
            [Ui]: "createElementBlock",
            [Hi]: "createVNode",
            [Di]: "createElementVNode",
            [Wi]: "createCommentVNode",
            [zi]: "createTextVNode",
            [Ki]: "createStaticVNode",
            [Gi]: "resolveComponent",
            [qi]: "resolveDynamicComponent",
            [Ji]: "resolveDirective",
            [Yi]: "resolveFilter",
            [Zi]: "withDirectives",
            [Qi]: "renderList",
            [Xi]: "renderSlot",
            [el]: "createSlots",
            [tl]: "toDisplayString",
            [nl]: "mergeProps",
            [ol]: "normalizeClass",
            [rl]: "normalizeStyle",
            [sl]: "normalizeProps",
            [il]: "guardReactiveProps",
            [ll]: "toHandlers",
            [cl]: "camelize",
            [al]: "capitalize",
            [ul]: "toHandlerKey",
            [pl]: "setBlockTracking",
            [fl]: "pushScopeId",
            [dl]: "popScopeId",
            [hl]: "withCtx",
            [ml]: "unref",
            [gl]: "isRef",
            [vl]: "withMemo",
            [yl]: "isMemoSame"
        };
    const _l = {
        source: "",
        start: {
            line: 1,
            column: 1,
            offset: 0
        },
        end: {
            line: 1,
            column: 1,
            offset: 0
        }
    };

    function Sl(e, t, n, o, r, s, i, l = !1, c = !1, a = !1, u = _l) {
        return e && (l ? (e.helper(Li), e.helper(Yl(e.inSSR, a))) : e.helper(Jl(e.inSSR, a)), i && e.helper(Zi)), {
            type: 13,
            tag: t,
            props: n,
            children: o,
            patchFlag: r,
            dynamicProps: s,
            directives: i,
            isBlock: l,
            disableTracking: c,
            isComponent: a,
            loc: u
        }
    }

    function xl(e, t = _l) {
        return {
            type: 17,
            loc: t,
            elements: e
        }
    }

    function Cl(e, t = _l) {
        return {
            type: 15,
            loc: t,
            properties: e
        }
    }

    function wl(e, t) {
        return {
            type: 16,
            loc: _l,
            key: A(e) ? kl(e, !0) : e,
            value: t
        }
    }

    function kl(e, t = !1, n = _l, o = 0) {
        return {
            type: 4,
            loc: n,
            content: e,
            isStatic: t,
            constType: t ? 3 : o
        }
    }

    function Tl(e, t = _l) {
        return {
            type: 8,
            loc: t,
            children: e
        }
    }

    function Nl(e, t = [], n = _l) {
        return {
            type: 14,
            loc: n,
            callee: e,
            arguments: t
        }
    }

    function El(e, t, n = !1, o = !1, r = _l) {
        return {
            type: 18,
            params: e,
            returns: t,
            newline: n,
            isSlot: o,
            loc: r
        }
    }

    function $l(e, t, n, o = !0) {
        return {
            type: 19,
            test: e,
            consequent: t,
            alternate: n,
            newline: o,
            loc: _l
        }
    }
    const Ol = e => 4 === e.type && e.isStatic,
        Rl = (e, t) => e === t || e === z(t);

    function Al(e) {
        return Rl(e, "Teleport") ? Pi : Rl(e, "Suspense") ? Vi : Rl(e, "KeepAlive") ? Ii : Rl(e, "BaseTransition") ? Bi : void 0
    }
    const Fl = /^\d|[^\$\w]/,
        Ml = e => !Fl.test(e),
        Pl = /[A-Za-z_$\xA0-\uFFFF]/,
        Vl = /[\.\?\w$\xA0-\uFFFF]/,
        Il = /\s+[.[]\s*|\s*[.[]\s+/g,
        Bl = e => {
            e = e.trim().replace(Il, (e => e.trim()));
            let t = 0,
                n = [],
                o = 0,
                r = 0,
                s = null;
            for (let i = 0; i < e.length; i++) {
                const l = e.charAt(i);
                switch (t) {
                    case 0:
                        if ("[" === l) n.push(t), t = 1, o++;
                        else if ("(" === l) n.push(t), t = 2, r++;
                        else if (!(0 === i ? Pl : Vl).test(l)) return !1;
                        break;
                    case 1:
                        "'" === l || '"' === l || "`" === l ? (n.push(t), t = 3, s = l) : "[" === l ? o++ : "]" === l && (--o || (t = n.pop()));
                        break;
                    case 2:
                        if ("'" === l || '"' === l || "`" === l) n.push(t), t = 3, s = l;
                        else if ("(" === l) r++;
                        else if (")" === l) {
                            if (i === e.length - 1) return !1;
                            --r || (t = n.pop())
                        }
                        break;
                    case 3:
                        l === s && (t = n.pop(), s = null)
                }
            }
            return !o && !r
        };

    function Ll(e, t, n) {
        const o = {
            source: e.source.slice(t, t + n),
            start: jl(e.start, e.source, t),
            end: e.end
        };
        return null != n && (o.end = jl(e.start, e.source, t + n)), o
    }

    function jl(e, t, n = t.length) {
        return Ul(C({}, e), t, n)
    }

    function Ul(e, t, n = t.length) {
        let o = 0,
            r = -1;
        for (let s = 0; s < n; s++) 10 === t.charCodeAt(s) && (o++, r = s);
        return e.offset += n, e.line += o, e.column = -1 === r ? e.column + n : n - r, e
    }

    function Hl(e, t, n = !1) {
        for (let o = 0; o < e.props.length; o++) {
            const r = e.props[o];
            if (7 === r.type && (n || r.exp) && (A(t) ? r.name === t : t.test(r.name))) return r
        }
    }

    function Dl(e, t, n = !1, o = !1) {
        for (let r = 0; r < e.props.length; r++) {
            const s = e.props[r];
            if (6 === s.type) {
                if (n) continue;
                if (s.name === t && (s.value || o)) return s
            } else if ("bind" === s.name && (s.exp || o) && Wl(s.arg, t)) return s
        }
    }

    function Wl(e, t) {
        return !(!e || !Ol(e) || e.content !== t)
    }

    function zl(e) {
        return 5 === e.type || 2 === e.type
    }

    function Kl(e) {
        return 7 === e.type && "slot" === e.name
    }

    function Gl(e) {
        return 1 === e.type && 3 === e.tagType
    }

    function ql(e) {
        return 1 === e.type && 2 === e.tagType
    }

    function Jl(e, t) {
        return e || t ? Hi : Di
    }

    function Yl(e, t) {
        return e || t ? ji : Ui
    }
    const Zl = new Set([sl, il]);

    function Ql(e, t = []) {
        if (e && !A(e) && 14 === e.type) {
            const n = e.callee;
            if (!A(n) && Zl.has(n)) return Ql(e.arguments[0], t.concat(e))
        }
        return [e, t]
    }

    function Xl(e, t, n) {
        let o;
        let r, s = 13 === e.type ? e.props : e.arguments[2],
            i = [];
        if (s && !A(s) && 14 === s.type) {
            const e = Ql(s);
            s = e[0], i = e[1], r = i[i.length - 1]
        }
        if (null == s || A(s)) o = Cl([t]);
        else if (14 === s.type) {
            const e = s.arguments[0];
            A(e) || 15 !== e.type ? s.callee === ll ? o = Nl(n.helper(nl), [Cl([t]), s]) : s.arguments.unshift(Cl([t])) : e.properties.unshift(t), !o && (o = s)
        } else if (15 === s.type) {
            let e = !1;
            if (4 === t.key.type) {
                const n = t.key.content;
                e = s.properties.some((e => 4 === e.key.type && e.key.content === n))
            }
            e || s.properties.unshift(t), o = s
        } else o = Nl(n.helper(nl), [Cl([t]), s]), r && r.callee === il && (r = i[i.length - 2]);
        13 === e.type ? r ? r.arguments[0] = o : e.props = o : r ? r.arguments[0] = o : e.arguments[2] = o
    }

    function ec(e, t) {
        return `_${t}_${e.replace(/[^\w]/g,((t,n)=>"-"===t?"_":e.charCodeAt(n).toString()))}`
    }

    function tc(e, {
        helper: t,
        removeHelper: n,
        inSSR: o
    }) {
        e.isBlock || (e.isBlock = !0, n(Jl(o, e.isComponent)), t(Li), t(Yl(o, e.isComponent)))
    }
    const nc = /&(gt|lt|amp|apos|quot);/g,
        oc = {
            gt: ">",
            lt: "<",
            amp: "&",
            apos: "'",
            quot: '"'
        },
        rc = {
            delimiters: ["{{", "}}"],
            getNamespace: () => 0,
            getTextMode: () => 0,
            isVoidTag: b,
            isPreTag: b,
            isCustomElement: b,
            decodeEntities: e => e.replace(nc, ((e, t) => oc[t])),
            onError: Ri,
            onWarn: Ai,
            comments: !1
        };

    function sc(e, t = {}) {
        const n = function(e, t) {
                const n = C({}, rc);
                let o;
                for (o in t) n[o] = void 0 === t[o] ? rc[o] : t[o];
                return {
                    options: n,
                    column: 1,
                    line: 1,
                    offset: 0,
                    originalSource: e,
                    source: e,
                    inPre: !1,
                    inVPre: !1,
                    onWarn: n.onWarn
                }
            }(e, t),
            o = bc(n);
        return function(e, t = _l) {
            return {
                type: 0,
                children: e,
                helpers: [],
                components: [],
                directives: [],
                hoists: [],
                imports: [],
                cached: 0,
                temps: 0,
                codegenNode: void 0,
                loc: t
            }
        }(ic(n, 0, []), _c(n, o))
    }

    function ic(e, t, n) {
        const o = Sc(n),
            r = o ? o.ns : 0,
            s = [];
        for (; !Tc(e, t, n);) {
            const i = e.source;
            let l;
            if (0 === t || 1 === t)
                if (!e.inVPre && xc(i, e.options.delimiters[0])) l = gc(e, t);
                else if (0 === t && "<" === i[0])
                if (1 === i.length);
                else if ("!" === i[1]) l = xc(i, "\x3c!--") ? ac(e) : xc(i, "<!DOCTYPE") ? uc(e) : xc(i, "<![CDATA[") && 0 !== r ? cc(e, n) : uc(e);
            else if ("/" === i[1])
                if (2 === i.length);
                else {
                    if (">" === i[2]) {
                        Cc(e, 3);
                        continue
                    }
                    if (/[a-z]/i.test(i[2])) {
                        dc(e, 1, o);
                        continue
                    }
                    l = uc(e)
                }
            else /[a-z]/i.test(i[1]) ? l = pc(e, n) : "?" === i[1] && (l = uc(e));
            if (l || (l = vc(e, t)), N(l))
                for (let e = 0; e < l.length; e++) lc(s, l[e]);
            else lc(s, l)
        }
        let i = !1;
        if (2 !== t && 1 !== t) {
            const t = "preserve" !== e.options.whitespace;
            for (let n = 0; n < s.length; n++) {
                const o = s[n];
                if (e.inPre || 2 !== o.type) 3 !== o.type || e.options.comments || (i = !0, s[n] = null);
                else if (/[^\t\r\n\f ]/.test(o.content)) t && (o.content = o.content.replace(/[\t\r\n\f ]+/g, " "));
                else {
                    const e = s[n - 1],
                        r = s[n + 1];
                    !e || !r || t && (3 === e.type || 3 === r.type || 1 === e.type && 1 === r.type && /[\r\n]/.test(o.content)) ? (i = !0, s[n] = null) : o.content = " "
                }
            }
            if (e.inPre && o && e.options.isPreTag(o.tag)) {
                const e = s[0];
                e && 2 === e.type && (e.content = e.content.replace(/^\r?\n/, ""))
            }
        }
        return i ? s.filter(Boolean) : s
    }

    function lc(e, t) {
        if (2 === t.type) {
            const n = Sc(e);
            if (n && 2 === n.type && n.loc.end.offset === t.loc.start.offset) return n.content += t.content, n.loc.end = t.loc.end, void(n.loc.source += t.loc.source)
        }
        e.push(t)
    }

    function cc(e, t) {
        Cc(e, 9);
        const n = ic(e, 3, t);
        return 0 === e.source.length || Cc(e, 3), n
    }

    function ac(e) {
        const t = bc(e);
        let n;
        const o = /--(\!)?>/.exec(e.source);
        if (o) {
            n = e.source.slice(4, o.index);
            const t = e.source.slice(0, o.index);
            let r = 1,
                s = 0;
            for (; - 1 !== (s = t.indexOf("\x3c!--", r));) Cc(e, s - r + 1), r = s + 1;
            Cc(e, o.index + o[0].length - r + 1)
        } else n = e.source.slice(4), Cc(e, e.source.length);
        return {
            type: 3,
            content: n,
            loc: _c(e, t)
        }
    }

    function uc(e) {
        const t = bc(e),
            n = "?" === e.source[1] ? 1 : 2;
        let o;
        const r = e.source.indexOf(">");
        return -1 === r ? (o = e.source.slice(n), Cc(e, e.source.length)) : (o = e.source.slice(n, r), Cc(e, r + 1)), {
            type: 3,
            content: o,
            loc: _c(e, t)
        }
    }

    function pc(e, t) {
        const n = e.inPre,
            o = e.inVPre,
            r = Sc(t),
            s = dc(e, 0, r),
            i = e.inPre && !n,
            l = e.inVPre && !o;
        if (s.isSelfClosing || e.options.isVoidTag(s.tag)) return i && (e.inPre = !1), l && (e.inVPre = !1), s;
        t.push(s);
        const c = e.options.getTextMode(s, r),
            a = ic(e, c, t);
        if (t.pop(), s.children = a, Nc(e.source, s.tag)) dc(e, 1, r);
        else if (0 === e.source.length && "script" === s.tag.toLowerCase()) {
            const e = a[0];
            e && xc(e.loc.source, "\x3c!--")
        }
        return s.loc = _c(e, s.loc.start), i && (e.inPre = !1), l && (e.inVPre = !1), s
    }
    const fc = t("if,else,else-if,for,slot");

    function dc(e, t, n) {
        const o = bc(e),
            r = /^<\/?([a-z][^\t\r\n\f />]*)/i.exec(e.source),
            s = r[1],
            i = e.options.getNamespace(s, n);
        Cc(e, r[0].length), wc(e);
        const l = bc(e),
            c = e.source;
        e.options.isPreTag(s) && (e.inPre = !0);
        let a = hc(e, t);
        0 === t && !e.inVPre && a.some((e => 7 === e.type && "pre" === e.name)) && (e.inVPre = !0, C(e, l), e.source = c, a = hc(e, t).filter((e => "v-pre" !== e.name)));
        let u = !1;
        if (0 === e.source.length || (u = xc(e.source, "/>"), Cc(e, u ? 2 : 1)), 1 === t) return;
        let p = 0;
        return e.inVPre || ("slot" === s ? p = 2 : "template" === s ? a.some((e => 7 === e.type && fc(e.name))) && (p = 3) : function(e, t, n) {
            const o = n.options;
            if (o.isCustomElement(e)) return !1;
            if ("component" === e || /^[A-Z]/.test(e) || Al(e) || o.isBuiltInComponent && o.isBuiltInComponent(e) || o.isNativeTag && !o.isNativeTag(e)) return !0;
            for (let r = 0; r < t.length; r++) {
                const e = t[r];
                if (6 === e.type) {
                    if ("is" === e.name && e.value && e.value.content.startsWith("vue:")) return !0
                } else {
                    if ("is" === e.name) return !0;
                    "bind" === e.name && Wl(e.arg, "is")
                }
            }
        }(s, a, e) && (p = 1)), {
            type: 1,
            ns: i,
            tag: s,
            tagType: p,
            props: a,
            isSelfClosing: u,
            children: [],
            loc: _c(e, o),
            codegenNode: void 0
        }
    }

    function hc(e, t) {
        const n = [],
            o = new Set;
        for (; e.source.length > 0 && !xc(e.source, ">") && !xc(e.source, "/>");) {
            if (xc(e.source, "/")) {
                Cc(e, 1), wc(e);
                continue
            }
            const r = mc(e, o);
            6 === r.type && r.value && "class" === r.name && (r.value.content = r.value.content.replace(/\s+/g, " ").trim()), 0 === t && n.push(r), /^[^\t\r\n\f />]/.test(e.source), wc(e)
        }
        return n
    }

    function mc(e, t) {
        const n = bc(e),
            o = /^[^\t\r\n\f />][^\t\r\n\f />=]*/.exec(e.source)[0];
        t.has(o), t.add(o); {
            const e = /["'<]/g;
            let t;
            for (; t = e.exec(o););
        }
        let r;
        Cc(e, o.length), /^[\t\r\n\f ]*=/.test(e.source) && (wc(e), Cc(e, 1), wc(e), r = function(e) {
            const t = bc(e);
            let n;
            const o = e.source[0],
                r = '"' === o || "'" === o;
            if (r) {
                Cc(e, 1);
                const t = e.source.indexOf(o); - 1 === t ? n = yc(e, e.source.length, 4) : (n = yc(e, t, 4), Cc(e, 1))
            } else {
                const t = /^[^\t\r\n\f >]+/.exec(e.source);
                if (!t) return;
                const o = /["'<=`]/g;
                let r;
                for (; r = o.exec(t[0]););
                n = yc(e, t[0].length, 4)
            }
            return {
                content: n,
                isQuoted: r,
                loc: _c(e, t)
            }
        }(e));
        const s = _c(e, n);
        if (!e.inVPre && /^(v-[A-Za-z0-9-]|:|\.|@|#)/.test(o)) {
            const t = /(?:^v-([a-z0-9-]+))?(?:(?::|^\.|^@|^#)(\[[^\]]+\]|[^\.]+))?(.+)?$/i.exec(o);
            let i, l = xc(o, "."),
                c = t[1] || (l || xc(o, ":") ? "bind" : xc(o, "@") ? "on" : "slot");
            if (t[2]) {
                const r = "slot" === c,
                    s = o.lastIndexOf(t[2]),
                    l = _c(e, kc(e, n, s), kc(e, n, s + t[2].length + (r && t[3] || "").length));
                let a = t[2],
                    u = !0;
                a.startsWith("[") ? (u = !1, a = a.endsWith("]") ? a.slice(1, a.length - 1) : a.slice(1)) : r && (a += t[3] || ""), i = {
                    type: 4,
                    content: a,
                    isStatic: u,
                    constType: u ? 3 : 0,
                    loc: l
                }
            }
            if (r && r.isQuoted) {
                const e = r.loc;
                e.start.offset++, e.start.column++, e.end = jl(e.start, r.content), e.source = e.source.slice(1, -1)
            }
            const a = t[3] ? t[3].slice(1).split(".") : [];
            return l && a.push("prop"), {
                type: 7,
                name: c,
                exp: r && {
                    type: 4,
                    content: r.content,
                    isStatic: !1,
                    constType: 0,
                    loc: r.loc
                },
                arg: i,
                modifiers: a,
                loc: s
            }
        }
        return !e.inVPre && xc(o, "v-"), {
            type: 6,
            name: o,
            value: r && {
                type: 2,
                content: r.content,
                loc: r.loc
            },
            loc: s
        }
    }

    function gc(e, t) {
        const [n, o] = e.options.delimiters, r = e.source.indexOf(o, n.length);
        if (-1 === r) return;
        const s = bc(e);
        Cc(e, n.length);
        const i = bc(e),
            l = bc(e),
            c = r - n.length,
            a = e.source.slice(0, c),
            u = yc(e, c, t),
            p = u.trim(),
            f = u.indexOf(p);
        f > 0 && Ul(i, a, f);
        return Ul(l, a, c - (u.length - p.length - f)), Cc(e, o.length), {
            type: 5,
            content: {
                type: 4,
                isStatic: !1,
                constType: 0,
                content: p,
                loc: _c(e, i, l)
            },
            loc: _c(e, s)
        }
    }

    function vc(e, t) {
        const n = 3 === t ? ["]]>"] : ["<", e.options.delimiters[0]];
        let o = e.source.length;
        for (let s = 0; s < n.length; s++) {
            const t = e.source.indexOf(n[s], 1); - 1 !== t && o > t && (o = t)
        }
        const r = bc(e);
        return {
            type: 2,
            content: yc(e, o, t),
            loc: _c(e, r)
        }
    }

    function yc(e, t, n) {
        const o = e.source.slice(0, t);
        return Cc(e, t), 2 === n || 3 === n || -1 === o.indexOf("&") ? o : e.options.decodeEntities(o, 4 === n)
    }

    function bc(e) {
        const {
            column: t,
            line: n,
            offset: o
        } = e;
        return {
            column: t,
            line: n,
            offset: o
        }
    }

    function _c(e, t, n) {
        return {
            start: t,
            end: n = n || bc(e),
            source: e.originalSource.slice(t.offset, n.offset)
        }
    }

    function Sc(e) {
        return e[e.length - 1]
    }

    function xc(e, t) {
        return e.startsWith(t)
    }

    function Cc(e, t) {
        const {
            source: n
        } = e;
        Ul(e, n, t), e.source = n.slice(t)
    }

    function wc(e) {
        const t = /^[\t\r\n\f ]+/.exec(e.source);
        t && Cc(e, t[0].length)
    }

    function kc(e, t, n) {
        return jl(t, e.originalSource.slice(t.offset, n), n)
    }

    function Tc(e, t, n) {
        const o = e.source;
        switch (t) {
            case 0:
                if (xc(o, "</"))
                    for (let e = n.length - 1; e >= 0; --e)
                        if (Nc(o, n[e].tag)) return !0;
                break;
            case 1:
            case 2: {
                const e = Sc(n);
                if (e && Nc(o, e.tag)) return !0;
                break
            }
            case 3:
                if (xc(o, "]]>")) return !0
        }
        return !o
    }

    function Nc(e, t) {
        return xc(e, "</") && e.slice(2, 2 + t.length).toLowerCase() === t.toLowerCase() && /[\t\r\n\f />]/.test(e[2 + t.length] || ">")
    }

    function Ec(e, t) {
        Oc(e, t, $c(e, e.children[0]))
    }

    function $c(e, t) {
        const {
            children: n
        } = e;
        return 1 === n.length && 1 === t.type && !ql(t)
    }

    function Oc(e, t, n = !1) {
        let o = !0;
        const {
            children: r
        } = e, s = r.length;
        let i = 0;
        for (let l = 0; l < r.length; l++) {
            const e = r[l];
            if (1 === e.type && 0 === e.tagType) {
                const r = n ? 0 : Rc(e, t);
                if (r > 0) {
                    if (r < 3 && (o = !1), r >= 2) {
                        e.codegenNode.patchFlag = "-1", e.codegenNode = t.hoist(e.codegenNode), i++;
                        continue
                    }
                } else {
                    const n = e.codegenNode;
                    if (13 === n.type) {
                        const o = Vc(n);
                        if ((!o || 512 === o || 1 === o) && Mc(e, t) >= 2) {
                            const o = Pc(e);
                            o && (n.props = t.hoist(o))
                        }
                        n.dynamicProps && (n.dynamicProps = t.hoist(n.dynamicProps))
                    }
                }
            } else if (12 === e.type) {
                const n = Rc(e.content, t);
                n > 0 && (n < 3 && (o = !1), n >= 2 && (e.codegenNode = t.hoist(e.codegenNode), i++))
            }
            if (1 === e.type) {
                const n = 1 === e.tagType;
                n && t.scopes.vSlot++, Oc(e, t), n && t.scopes.vSlot--
            } else if (11 === e.type) Oc(e, t, 1 === e.children.length);
            else if (9 === e.type)
                for (let n = 0; n < e.branches.length; n++) Oc(e.branches[n], t, 1 === e.branches[n].children.length)
        }
        o && i && t.transformHoist && t.transformHoist(r, t, e), i && i === s && 1 === e.type && 0 === e.tagType && e.codegenNode && 13 === e.codegenNode.type && N(e.codegenNode.children) && (e.codegenNode.children = t.hoist(xl(e.codegenNode.children)))
    }

    function Rc(e, t) {
        const {
            constantCache: n
        } = t;
        switch (e.type) {
            case 1:
                if (0 !== e.tagType) return 0;
                const o = n.get(e);
                if (void 0 !== o) return o;
                const r = e.codegenNode;
                if (13 !== r.type) return 0;
                if (Vc(r)) return n.set(e, 0), 0; {
                    let o = 3;
                    const s = Mc(e, t);
                    if (0 === s) return n.set(e, 0), 0;
                    s < o && (o = s);
                    for (let r = 0; r < e.children.length; r++) {
                        const s = Rc(e.children[r], t);
                        if (0 === s) return n.set(e, 0), 0;
                        s < o && (o = s)
                    }
                    if (o > 1)
                        for (let r = 0; r < e.props.length; r++) {
                            const s = e.props[r];
                            if (7 === s.type && "bind" === s.name && s.exp) {
                                const r = Rc(s.exp, t);
                                if (0 === r) return n.set(e, 0), 0;
                                r < o && (o = r)
                            }
                        }
                    return r.isBlock && (t.removeHelper(Li), t.removeHelper(Yl(t.inSSR, r.isComponent)), r.isBlock = !1, t.helper(Jl(t.inSSR, r.isComponent))), n.set(e, o), o
                }
            case 2:
            case 3:
                return 3;
            default:
                return 0;
            case 5:
            case 12:
                return Rc(e.content, t);
            case 4:
                return e.constType;
            case 8:
                let s = 3;
                for (let n = 0; n < e.children.length; n++) {
                    const o = e.children[n];
                    if (A(o) || F(o)) continue;
                    const r = Rc(o, t);
                    if (0 === r) return 0;
                    r < s && (s = r)
                }
                return s
        }
    }
    const Ac = new Set([ol, rl, sl, il]);

    function Fc(e, t) {
        if (14 === e.type && !A(e.callee) && Ac.has(e.callee)) {
            const n = e.arguments[0];
            if (4 === n.type) return Rc(n, t);
            if (14 === n.type) return Fc(n, t)
        }
        return 0
    }

    function Mc(e, t) {
        let n = 3;
        const o = Pc(e);
        if (o && 15 === o.type) {
            const {
                properties: e
            } = o;
            for (let o = 0; o < e.length; o++) {
                const {
                    key: r,
                    value: s
                } = e[o], i = Rc(r, t);
                if (0 === i) return i;
                let l;
                if (i < n && (n = i), l = 4 === s.type ? Rc(s, t) : 14 === s.type ? Fc(s, t) : 0, 0 === l) return l;
                l < n && (n = l)
            }
        }
        return n
    }

    function Pc(e) {
        const t = e.codegenNode;
        if (13 === t.type) return t.props
    }

    function Vc(e) {
        const t = e.patchFlag;
        return t ? parseInt(t, 10) : void 0
    }

    function Ic(e, {
        filename: t = "",
        prefixIdentifiers: n = !1,
        hoistStatic: o = !1,
        cacheHandlers: r = !1,
        nodeTransforms: s = [],
        directiveTransforms: i = {},
        transformHoist: l = null,
        isBuiltInComponent: c = y,
        isCustomElement: a = y,
        expressionPlugins: u = [],
        scopeId: p = null,
        slotted: f = !0,
        ssr: d = !1,
        inSSR: h = !1,
        ssrCssVars: m = "",
        bindingMetadata: v = g,
        inline: b = !1,
        isTS: _ = !1,
        onError: S = Ri,
        onWarn: x = Ai,
        compatConfig: C
    }) {
        const w = t.replace(/\?.*$/, "").match(/([^/\\]+)\.\w+$/),
            k = {
                selfName: w && K(D(w[1])),
                prefixIdentifiers: n,
                hoistStatic: o,
                cacheHandlers: r,
                nodeTransforms: s,
                directiveTransforms: i,
                transformHoist: l,
                isBuiltInComponent: c,
                isCustomElement: a,
                expressionPlugins: u,
                scopeId: p,
                slotted: f,
                ssr: d,
                inSSR: h,
                ssrCssVars: m,
                bindingMetadata: v,
                inline: b,
                isTS: _,
                onError: S,
                onWarn: x,
                compatConfig: C,
                root: e,
                helpers: new Map,
                components: new Set,
                directives: new Set,
                hoists: [],
                imports: [],
                constantCache: new Map,
                temps: 0,
                cached: 0,
                identifiers: Object.create(null),
                scopes: {
                    vFor: 0,
                    vSlot: 0,
                    vPre: 0,
                    vOnce: 0
                },
                parent: null,
                currentNode: e,
                childIndex: 0,
                inVOnce: !1,
                helper(e) {
                    const t = k.helpers.get(e) || 0;
                    return k.helpers.set(e, t + 1), e
                },
                removeHelper(e) {
                    const t = k.helpers.get(e);
                    if (t) {
                        const n = t - 1;
                        n ? k.helpers.set(e, n) : k.helpers.delete(e)
                    }
                },
                helperString: e => `_${bl[k.helper(e)]}`,
                replaceNode(e) {
                    k.parent.children[k.childIndex] = k.currentNode = e
                },
                removeNode(e) {
                    const t = e ? k.parent.children.indexOf(e) : k.currentNode ? k.childIndex : -1;
                    e && e !== k.currentNode ? k.childIndex > t && (k.childIndex--, k.onNodeRemoved()) : (k.currentNode = null, k.onNodeRemoved()), k.parent.children.splice(t, 1)
                },
                onNodeRemoved: () => {},
                addIdentifiers(e) {},
                removeIdentifiers(e) {},
                hoist(e) {
                    A(e) && (e = kl(e)), k.hoists.push(e);
                    const t = kl(`_hoisted_${k.hoists.length}`, !1, e.loc, 2);
                    return t.hoisted = e, t
                },
                cache: (e, t = !1) => function(e, t, n = !1) {
                    return {
                        type: 20,
                        index: e,
                        value: t,
                        isVNode: n,
                        loc: _l
                    }
                }(k.cached++, e, t)
            };
        return k
    }

    function Bc(e, t) {
        const n = Ic(e, t);
        Lc(e, n), t.hoistStatic && Ec(e, n), t.ssr || function(e, t) {
            const {
                helper: n
            } = t, {
                children: o
            } = e;
            if (1 === o.length) {
                const n = o[0];
                if ($c(e, n) && n.codegenNode) {
                    const o = n.codegenNode;
                    13 === o.type && tc(o, t), e.codegenNode = o
                } else e.codegenNode = n
            } else if (o.length > 1) {
                let o = 64;
                e.codegenNode = Sl(t, n(Mi), void 0, e.children, o + "", void 0, void 0, !0, void 0, !1)
            }
        }(e, n), e.helpers = [...n.helpers.keys()], e.components = [...n.components], e.directives = [...n.directives], e.imports = n.imports, e.hoists = n.hoists, e.temps = n.temps, e.cached = n.cached
    }

    function Lc(e, t) {
        t.currentNode = e;
        const {
            nodeTransforms: n
        } = t, o = [];
        for (let s = 0; s < n.length; s++) {
            const r = n[s](e, t);
            if (r && (N(r) ? o.push(...r) : o.push(r)), !t.currentNode) return;
            e = t.currentNode
        }
        switch (e.type) {
            case 3:
                t.ssr || t.helper(Wi);
                break;
            case 5:
                t.ssr || t.helper(tl);
                break;
            case 9:
                for (let n = 0; n < e.branches.length; n++) Lc(e.branches[n], t);
                break;
            case 10:
            case 11:
            case 1:
            case 0:
                ! function(e, t) {
                    let n = 0;
                    const o = () => {
                        n--
                    };
                    for (; n < e.children.length; n++) {
                        const r = e.children[n];
                        A(r) || (t.parent = e, t.childIndex = n, t.onNodeRemoved = o, Lc(r, t))
                    }
                }(e, t)
        }
        t.currentNode = e;
        let r = o.length;
        for (; r--;) o[r]()
    }

    function jc(e, t) {
        const n = A(e) ? t => t === e : t => e.test(t);
        return (e, o) => {
            if (1 === e.type) {
                const {
                    props: r
                } = e;
                if (3 === e.tagType && r.some(Kl)) return;
                const s = [];
                for (let i = 0; i < r.length; i++) {
                    const l = r[i];
                    if (7 === l.type && n(l.name)) {
                        r.splice(i, 1), i--;
                        const n = t(e, l, o);
                        n && s.push(n)
                    }
                }
                return s
            }
        }
    }
    const Uc = "/*#__PURE__*/";

    function Hc(e, t = {}) {
        const n = function(e, {
            mode: t = "function",
            prefixIdentifiers: n = "module" === t,
            sourceMap: o = !1,
            filename: r = "template.vue.html",
            scopeId: s = null,
            optimizeImports: i = !1,
            runtimeGlobalName: l = "Vue",
            runtimeModuleName: c = "vue",
            ssrRuntimeModuleName: a = "vue/server-renderer",
            ssr: u = !1,
            isTS: p = !1,
            inSSR: f = !1
        }) {
            const d = {
                mode: t,
                prefixIdentifiers: n,
                sourceMap: o,
                filename: r,
                scopeId: s,
                optimizeImports: i,
                runtimeGlobalName: l,
                runtimeModuleName: c,
                ssrRuntimeModuleName: a,
                ssr: u,
                isTS: p,
                inSSR: f,
                source: e.loc.source,
                code: "",
                column: 1,
                line: 1,
                offset: 0,
                indentLevel: 0,
                pure: !1,
                map: void 0,
                helper: e => `_${bl[e]}`,
                push(e, t) {
                    d.code += e
                },
                indent() {
                    h(++d.indentLevel)
                },
                deindent(e = !1) {
                    e ? --d.indentLevel : h(--d.indentLevel)
                },
                newline() {
                    h(d.indentLevel)
                }
            };

            function h(e) {
                d.push("\n" + "  ".repeat(e))
            }
            return d
        }(e, t);
        t.onContextCreated && t.onContextCreated(n);
        const {
            mode: o,
            push: r,
            prefixIdentifiers: s,
            indent: i,
            deindent: l,
            newline: c,
            ssr: a
        } = n, u = e.helpers.length > 0, p = !s && "module" !== o;
        ! function(e, t) {
            const {
                push: n,
                newline: o,
                runtimeGlobalName: r
            } = t, s = r, i = e => `${bl[e]}: _${bl[e]}`;
            if (e.helpers.length > 0 && (n(`const _Vue = ${s}\n`), e.hoists.length)) {
                n(`const { ${[Hi,Di,Wi,zi,Ki].filter((t=>e.helpers.includes(t))).map(i).join(", ")} } = _Vue\n`)
            }(function(e, t) {
                if (!e.length) return;
                t.pure = !0;
                const {
                    push: n,
                    newline: o
                } = t;
                o();
                for (let r = 0; r < e.length; r++) {
                    const s = e[r];
                    s && (n(`const _hoisted_${r+1} = `), Kc(s, t), o())
                }
                t.pure = !1
            })(e.hoists, t), o(), n("return ")
        }(e, n);
        if (r(`function ${a?"ssrRender":"render"}(${(a?["_ctx","_push","_parent","_attrs"]:["_ctx","_cache"]).join(", ")}) {`), i(), p && (r("with (_ctx) {"), i(), u && (r(`const { ${e.helpers.map((e=>`${bl[e]}: _${bl[e]}`)).join(", ")} } = _Vue`), r("\n"), c())), e.components.length && (Dc(e.components, "component", n), (e.directives.length || e.temps > 0) && c()), e.directives.length && (Dc(e.directives, "directive", n), e.temps > 0 && c()), e.temps > 0) {
            r("let ");
            for (let t = 0; t < e.temps; t++) r(`${t>0?", ":""}_temp${t}`)
        }
        return (e.components.length || e.directives.length || e.temps) && (r("\n"), c()), a || r("return "), e.codegenNode ? Kc(e.codegenNode, n) : r("null"), p && (l(), r("}")), l(), r("}"), {
            ast: e,
            code: n.code,
            preamble: "",
            map: n.map ? n.map.toJSON() : void 0
        }
    }

    function Dc(e, t, {
        helper: n,
        push: o,
        newline: r,
        isTS: s
    }) {
        const i = n("component" === t ? Gi : Ji);
        for (let l = 0; l < e.length; l++) {
            let n = e[l];
            const c = n.endsWith("__self");
            c && (n = n.slice(0, -6)), o(`const ${ec(n,t)} = ${i}(${JSON.stringify(n)}${c?", true":""})${s?"!":""}`), l < e.length - 1 && r()
        }
    }

    function Wc(e, t) {
        const n = e.length > 3 || !1;
        t.push("["), n && t.indent(), zc(e, t, n), n && t.deindent(), t.push("]")
    }

    function zc(e, t, n = !1, o = !0) {
        const {
            push: r,
            newline: s
        } = t;
        for (let i = 0; i < e.length; i++) {
            const l = e[i];
            A(l) ? r(l) : N(l) ? Wc(l, t) : Kc(l, t), i < e.length - 1 && (n ? (o && r(","), s()) : o && r(", "))
        }
    }

    function Kc(e, t) {
        if (A(e)) t.push(e);
        else if (F(e)) t.push(t.helper(e));
        else switch (e.type) {
            case 1:
            case 9:
            case 11:
            case 12:
                Kc(e.codegenNode, t);
                break;
            case 2:
                ! function(e, t) {
                    t.push(JSON.stringify(e.content), e)
                }(e, t);
                break;
            case 4:
                Gc(e, t);
                break;
            case 5:
                ! function(e, t) {
                    const {
                        push: n,
                        helper: o,
                        pure: r
                    } = t;
                    r && n(Uc);
                    n(`${o(tl)}(`), Kc(e.content, t), n(")")
                }(e, t);
                break;
            case 8:
                qc(e, t);
                break;
            case 3:
                ! function(e, t) {
                    const {
                        push: n,
                        helper: o,
                        pure: r
                    } = t;
                    r && n(Uc);
                    n(`${o(Wi)}(${JSON.stringify(e.content)})`, e)
                }(e, t);
                break;
            case 13:
                ! function(e, t) {
                    const {
                        push: n,
                        helper: o,
                        pure: r
                    } = t, {
                        tag: s,
                        props: i,
                        children: l,
                        patchFlag: c,
                        dynamicProps: a,
                        directives: u,
                        isBlock: p,
                        disableTracking: f,
                        isComponent: d
                    } = e;
                    u && n(o(Zi) + "(");
                    p && n(`(${o(Li)}(${f?"true":""}), `);
                    r && n(Uc);
                    const h = p ? Yl(t.inSSR, d) : Jl(t.inSSR, d);
                    n(o(h) + "(", e), zc(function(e) {
                        let t = e.length;
                        for (; t-- && null == e[t];);
                        return e.slice(0, t + 1).map((e => e || "null"))
                    }([s, i, l, c, a]), t), n(")"), p && n(")");
                    u && (n(", "), Kc(u, t), n(")"))
                }(e, t);
                break;
            case 14:
                ! function(e, t) {
                    const {
                        push: n,
                        helper: o,
                        pure: r
                    } = t, s = A(e.callee) ? e.callee : o(e.callee);
                    r && n(Uc);
                    n(s + "(", e), zc(e.arguments, t), n(")")
                }(e, t);
                break;
            case 15:
                ! function(e, t) {
                    const {
                        push: n,
                        indent: o,
                        deindent: r,
                        newline: s
                    } = t, {
                        properties: i
                    } = e;
                    if (!i.length) return void n("{}", e);
                    const l = i.length > 1 || !1;
                    n(l ? "{" : "{ "), l && o();
                    for (let c = 0; c < i.length; c++) {
                        const {
                            key: e,
                            value: o
                        } = i[c];
                        Jc(e, t), n(": "), Kc(o, t), c < i.length - 1 && (n(","), s())
                    }
                    l && r(), n(l ? "}" : " }")
                }(e, t);
                break;
            case 17:
                ! function(e, t) {
                    Wc(e.elements, t)
                }(e, t);
                break;
            case 18:
                ! function(e, t) {
                    const {
                        push: n,
                        indent: o,
                        deindent: r
                    } = t, {
                        params: s,
                        returns: i,
                        body: l,
                        newline: c,
                        isSlot: a
                    } = e;
                    a && n(`_${bl[hl]}(`);
                    n("(", e), N(s) ? zc(s, t) : s && Kc(s, t);
                    n(") => "), (c || l) && (n("{"), o());
                    i ? (c && n("return "), N(i) ? Wc(i, t) : Kc(i, t)) : l && Kc(l, t);
                    (c || l) && (r(), n("}"));
                    a && n(")")
                }(e, t);
                break;
            case 19:
                ! function(e, t) {
                    const {
                        test: n,
                        consequent: o,
                        alternate: r,
                        newline: s
                    } = e, {
                        push: i,
                        indent: l,
                        deindent: c,
                        newline: a
                    } = t;
                    if (4 === n.type) {
                        const e = !Ml(n.content);
                        e && i("("), Gc(n, t), e && i(")")
                    } else i("("), Kc(n, t), i(")");
                    s && l(), t.indentLevel++, s || i(" "), i("? "), Kc(o, t), t.indentLevel--, s && a(), s || i(" "), i(": ");
                    const u = 19 === r.type;
                    u || t.indentLevel++;
                    Kc(r, t), u || t.indentLevel--;
                    s && c(!0)
                }(e, t);
                break;
            case 20:
                ! function(e, t) {
                    const {
                        push: n,
                        helper: o,
                        indent: r,
                        deindent: s,
                        newline: i
                    } = t;
                    n(`_cache[${e.index}] || (`), e.isVNode && (r(), n(`${o(pl)}(-1),`), i());
                    n(`_cache[${e.index}] = `), Kc(e.value, t), e.isVNode && (n(","), i(), n(`${o(pl)}(1),`), i(), n(`_cache[${e.index}]`), s());
                    n(")")
                }(e, t);
                break;
            case 21:
                zc(e.body, t, !0, !1)
        }
    }

    function Gc(e, t) {
        const {
            content: n,
            isStatic: o
        } = e;
        t.push(o ? JSON.stringify(n) : n, e)
    }

    function qc(e, t) {
        for (let n = 0; n < e.children.length; n++) {
            const o = e.children[n];
            A(o) ? t.push(o) : Kc(o, t)
        }
    }

    function Jc(e, t) {
        const {
            push: n
        } = t;
        if (8 === e.type) n("["), qc(e, t), n("]");
        else if (e.isStatic) {
            n(Ml(e.content) ? e.content : JSON.stringify(e.content), e)
        } else n(`[${e.content}]`, e)
    }
    const Yc = jc(/^(if|else|else-if)$/, ((e, t, n) => function(e, t, n, o) {
        if (!("else" === t.name || t.exp && t.exp.content.trim())) {
            t.exp = kl("true", !1, t.exp ? t.exp.loc : e.loc)
        }
        if ("if" === t.name) {
            const r = Zc(e, t),
                s = {
                    type: 9,
                    loc: e.loc,
                    branches: [r]
                };
            if (n.replaceNode(s), o) return o(s, r, !0)
        } else {
            const r = n.parent.children;
            let s = r.indexOf(e);
            for (; s-- >= -1;) {
                const i = r[s];
                if (!i || 2 !== i.type || i.content.trim().length) {
                    if (i && 9 === i.type) {
                        n.removeNode();
                        const r = Zc(e, t);
                        i.branches.push(r);
                        const s = o && o(i, r, !1);
                        Lc(r, n), s && s(), n.currentNode = null
                    }
                    break
                }
                n.removeNode(i)
            }
        }
    }(e, t, n, ((e, t, o) => {
        const r = n.parent.children;
        let s = r.indexOf(e),
            i = 0;
        for (; s-- >= 0;) {
            const e = r[s];
            e && 9 === e.type && (i += e.branches.length)
        }
        return () => {
            if (o) e.codegenNode = Qc(t, i, n);
            else {
                const o = function(e) {
                    for (;;)
                        if (19 === e.type) {
                            if (19 !== e.alternate.type) return e;
                            e = e.alternate
                        } else 20 === e.type && (e = e.value)
                }(e.codegenNode);
                o.alternate = Qc(t, i + e.branches.length - 1, n)
            }
        }
    }))));

    function Zc(e, t) {
        return {
            type: 10,
            loc: e.loc,
            condition: "else" === t.name ? void 0 : t.exp,
            children: 3 !== e.tagType || Hl(e, "for") ? [e] : e.children,
            userKey: Dl(e, "key")
        }
    }

    function Qc(e, t, n) {
        return e.condition ? $l(e.condition, Xc(e, t, n), Nl(n.helper(Wi), ['""', "true"])) : Xc(e, t, n)
    }

    function Xc(e, t, n) {
        const {
            helper: o
        } = n, r = wl("key", kl(`${t}`, !1, _l, 2)), {
            children: s
        } = e, i = s[0];
        if (1 !== s.length || 1 !== i.type) {
            if (1 === s.length && 11 === i.type) {
                const e = i.codegenNode;
                return Xl(e, r, n), e
            } {
                let t = 64;
                return Sl(n, o(Mi), Cl([r]), s, t + "", void 0, void 0, !0, !1, !1, e.loc)
            }
        } {
            const e = i.codegenNode,
                t = 14 === (l = e).type && l.callee === vl ? l.arguments[1].returns : l;
            return 13 === t.type && tc(t, n), Xl(t, r, n), e
        }
        var l
    }
    const ea = jc("for", ((e, t, n) => {
        const {
            helper: o,
            removeHelper: r
        } = n;
        return function(e, t, n, o) {
            if (!t.exp) return;
            const r = ra(t.exp);
            if (!r) return;
            const {
                scopes: s
            } = n, {
                source: i,
                value: l,
                key: c,
                index: a
            } = r, u = {
                type: 11,
                loc: t.loc,
                source: i,
                valueAlias: l,
                keyAlias: c,
                objectIndexAlias: a,
                parseResult: r,
                children: Gl(e) ? e.children : [e]
            };
            n.replaceNode(u), s.vFor++;
            const p = o && o(u);
            return () => {
                s.vFor--, p && p()
            }
        }(e, t, n, (t => {
            const s = Nl(o(Qi), [t.source]),
                i = Hl(e, "memo"),
                l = Dl(e, "key"),
                c = l && (6 === l.type ? kl(l.value.content, !0) : l.exp),
                a = l ? wl("key", c) : null,
                u = 4 === t.source.type && t.source.constType > 0,
                p = u ? 64 : l ? 128 : 256;
            return t.codegenNode = Sl(n, o(Mi), void 0, s, p + "", void 0, void 0, !0, !u, !1, e.loc), () => {
                let l;
                const p = Gl(e),
                    {
                        children: f
                    } = t,
                    d = 1 !== f.length || 1 !== f[0].type,
                    h = ql(e) ? e : p && 1 === e.children.length && ql(e.children[0]) ? e.children[0] : null;
                if (h ? (l = h.codegenNode, p && a && Xl(l, a, n)) : d ? l = Sl(n, o(Mi), a ? Cl([a]) : void 0, e.children, "64", void 0, void 0, !0, void 0, !1) : (l = f[0].codegenNode, p && a && Xl(l, a, n), l.isBlock !== !u && (l.isBlock ? (r(Li), r(Yl(n.inSSR, l.isComponent))) : r(Jl(n.inSSR, l.isComponent))), l.isBlock = !u, l.isBlock ? (o(Li), o(Yl(n.inSSR, l.isComponent))) : o(Jl(n.inSSR, l.isComponent))), i) {
                    const e = El(ia(t.parseResult, [kl("_cached")]));
                    e.body = {
                        type: 21,
                        body: [Tl(["const _memo = (", i.exp, ")"]), Tl(["if (_cached", ...c ? [" && _cached.key === ", c] : [], ` && ${n.helperString(yl)}(_cached, _memo)) return _cached`]), Tl(["const _item = ", l]), kl("_item.memo = _memo"), kl("return _item")],
                        loc: _l
                    }, s.arguments.push(e, kl("_cache"), kl(String(n.cached++)))
                } else s.arguments.push(El(ia(t.parseResult), l, !0))
            }
        }))
    }));
    const ta = /([\s\S]*?)\s+(?:in|of)\s+([\s\S]*)/,
        na = /,([^,\}\]]*)(?:,([^,\}\]]*))?$/,
        oa = /^\(|\)$/g;

    function ra(e, t) {
        const n = e.loc,
            o = e.content,
            r = o.match(ta);
        if (!r) return;
        const [, s, i] = r, l = {
            source: sa(n, i.trim(), o.indexOf(i, s.length)),
            value: void 0,
            key: void 0,
            index: void 0
        };
        let c = s.trim().replace(oa, "").trim();
        const a = s.indexOf(c),
            u = c.match(na);
        if (u) {
            c = c.replace(na, "").trim();
            const e = u[1].trim();
            let t;
            if (e && (t = o.indexOf(e, a + c.length), l.key = sa(n, e, t)), u[2]) {
                const r = u[2].trim();
                r && (l.index = sa(n, r, o.indexOf(r, l.key ? t + e.length : a + c.length)))
            }
        }
        return c && (l.value = sa(n, c, a)), l
    }

    function sa(e, t, n) {
        return kl(t, !1, Ll(e, n, t.length))
    }

    function ia({
        value: e,
        key: t,
        index: n
    }, o = []) {
        return function(e) {
            let t = e.length;
            for (; t-- && !e[t];);
            return e.slice(0, t + 1).map(((e, t) => e || kl("_".repeat(t + 1), !1)))
        }([e, t, n, ...o])
    }
    const la = kl("undefined", !1),
        ca = (e, t) => {
            if (1 === e.type && (1 === e.tagType || 3 === e.tagType)) {
                const n = Hl(e, "slot");
                if (n) return t.scopes.vSlot++, () => {
                    t.scopes.vSlot--
                }
            }
        },
        aa = (e, t, n) => El(e, t, !1, !0, t.length ? t[0].loc : n);

    function ua(e, t, n = aa) {
        t.helper(hl);
        const {
            children: o,
            loc: r
        } = e, s = [], i = [];
        let l = t.scopes.vSlot > 0 || t.scopes.vFor > 0;
        const c = Hl(e, "slot", !0);
        if (c) {
            const {
                arg: e,
                exp: t
            } = c;
            e && !Ol(e) && (l = !0), s.push(wl(e || kl("default", !0), n(t, o, r)))
        }
        let a = !1,
            u = !1;
        const p = [],
            f = new Set;
        for (let m = 0; m < o.length; m++) {
            const e = o[m];
            let r;
            if (!Gl(e) || !(r = Hl(e, "slot", !0))) {
                3 !== e.type && p.push(e);
                continue
            }
            if (c) break;
            a = !0;
            const {
                children: d,
                loc: h
            } = e, {
                arg: g = kl("default", !0),
                exp: v
            } = r;
            let y;
            Ol(g) ? y = g ? g.content : "default" : l = !0;
            const b = n(v, d, h);
            let _, S, x;
            if (_ = Hl(e, "if")) l = !0, i.push($l(_.exp, pa(g, b), la));
            else if (S = Hl(e, /^else(-if)?$/, !0)) {
                let e, t = m;
                for (; t-- && (e = o[t], 3 === e.type););
                if (e && Gl(e) && Hl(e, "if")) {
                    o.splice(m, 1), m--;
                    let e = i[i.length - 1];
                    for (; 19 === e.alternate.type;) e = e.alternate;
                    e.alternate = S.exp ? $l(S.exp, pa(g, b), la) : pa(g, b)
                }
            } else if (x = Hl(e, "for")) {
                l = !0;
                const e = x.parseResult || ra(x.exp);
                e && i.push(Nl(t.helper(Qi), [e.source, El(ia(e), pa(g, b), !0)]))
            } else {
                if (y) {
                    if (f.has(y)) continue;
                    f.add(y), "default" === y && (u = !0)
                }
                s.push(wl(g, b))
            }
        }
        if (!c) {
            const e = (e, t) => wl("default", n(e, t, r));
            a ? p.length && p.some((e => da(e))) && (u || s.push(e(void 0, p))) : s.push(e(void 0, o))
        }
        const d = l ? 2 : fa(e.children) ? 3 : 1;
        let h = Cl(s.concat(wl("_", kl(d + "", !1))), r);
        return i.length && (h = Nl(t.helper(el), [h, xl(i)])), {
            slots: h,
            hasDynamicSlots: l
        }
    }

    function pa(e, t) {
        return Cl([wl("name", e), wl("fn", t)])
    }

    function fa(e) {
        for (let t = 0; t < e.length; t++) {
            const n = e[t];
            switch (n.type) {
                case 1:
                    if (2 === n.tagType || fa(n.children)) return !0;
                    break;
                case 9:
                    if (fa(n.branches)) return !0;
                    break;
                case 10:
                case 11:
                    if (fa(n.children)) return !0
            }
        }
        return !1
    }

    function da(e) {
        return 2 !== e.type && 12 !== e.type || (2 === e.type ? !!e.content.trim() : da(e.content))
    }
    const ha = new WeakMap,
        ma = (e, t) => function() {
            if (1 !== (e = t.currentNode).type || 0 !== e.tagType && 1 !== e.tagType) return;
            const {
                tag: n,
                props: o
            } = e, r = 1 === e.tagType;
            let s = r ? function(e, t, n = !1) {
                let {
                    tag: o
                } = e;
                const r = ba(o),
                    s = Dl(e, "is");
                if (s)
                    if (r) {
                        const e = 6 === s.type ? s.value && kl(s.value.content, !0) : s.exp;
                        if (e) return Nl(t.helper(qi), [e])
                    } else 6 === s.type && s.value.content.startsWith("vue:") && (o = s.value.content.slice(4));
                const i = !r && Hl(e, "is");
                if (i && i.exp) return Nl(t.helper(qi), [i.exp]);
                const l = Al(o) || t.isBuiltInComponent(o);
                if (l) return n || t.helper(l), l;
                return t.helper(Gi), t.components.add(o), ec(o, "component")
            }(e, t) : `"${n}"`;
            let i, l, c, a, u, p, f = 0,
                d = M(s) && s.callee === qi || s === Pi || s === Vi || !r && ("svg" === n || "foreignObject" === n || Dl(e, "key", !0));
            if (o.length > 0) {
                const n = ga(e, t);
                i = n.props, f = n.patchFlag, u = n.dynamicPropNames;
                const o = n.directives;
                p = o && o.length ? xl(o.map((e => function(e, t) {
                    const n = [],
                        o = ha.get(e);
                    o ? n.push(t.helperString(o)) : (t.helper(Ji), t.directives.add(e.name), n.push(ec(e.name, "directive")));
                    const {
                        loc: r
                    } = e;
                    e.exp && n.push(e.exp);
                    e.arg && (e.exp || n.push("void 0"), n.push(e.arg));
                    if (Object.keys(e.modifiers).length) {
                        e.arg || (e.exp || n.push("void 0"), n.push("void 0"));
                        const t = kl("true", !1, r);
                        n.push(Cl(e.modifiers.map((e => wl(e, t))), r))
                    }
                    return xl(n, e.loc)
                }(e, t)))) : void 0
            }
            if (e.children.length > 0) {
                s === Ii && (d = !0, f |= 1024);
                if (r && s !== Pi && s !== Ii) {
                    const {
                        slots: n,
                        hasDynamicSlots: o
                    } = ua(e, t);
                    l = n, o && (f |= 1024)
                } else if (1 === e.children.length && s !== Pi) {
                    const n = e.children[0],
                        o = n.type,
                        r = 5 === o || 8 === o;
                    r && 0 === Rc(n, t) && (f |= 1), l = r || 2 === o ? n : e.children
                } else l = e.children
            }
            0 !== f && (c = String(f), u && u.length && (a = function(e) {
                let t = "[";
                for (let n = 0, o = e.length; n < o; n++) t += JSON.stringify(e[n]), n < o - 1 && (t += ", ");
                return t + "]"
            }(u))), e.codegenNode = Sl(t, s, i, l, c, a, p, !!d, !1, r, e.loc)
        };

    function ga(e, t, n = e.props, o = !1) {
        const {
            tag: r,
            loc: s
        } = e, i = 1 === e.tagType;
        let l = [];
        const c = [],
            a = [];
        let u = 0,
            p = !1,
            f = !1,
            d = !1,
            h = !1,
            m = !1,
            g = !1;
        const v = [],
            y = ({
                key: e,
                value: n
            }) => {
                if (Ol(e)) {
                    const o = e.content,
                        r = S(o);
                    if (i || !r || "onclick" === o.toLowerCase() || "onUpdate:modelValue" === o || j(o) || (h = !0), r && j(o) && (g = !0), 20 === n.type || (4 === n.type || 8 === n.type) && Rc(n, t) > 0) return;
                    "ref" === o ? p = !0 : "class" === o ? f = !0 : "style" === o ? d = !0 : "key" === o || v.includes(o) || v.push(o), !i || "class" !== o && "style" !== o || v.includes(o) || v.push(o)
                } else m = !0
            };
        for (let _ = 0; _ < n.length; _++) {
            const i = n[_];
            if (6 === i.type) {
                const {
                    loc: e,
                    name: t,
                    value: n
                } = i;
                let o = kl(n ? n.content : "", !0, n ? n.loc : e);
                if ("ref" === t && (p = !0), "is" === t && (ba(r) || n && n.content.startsWith("vue:"))) continue;
                l.push(wl(kl(t, !0, Ll(e, 0, t.length)), o))
            } else {
                const {
                    name: n,
                    arg: u,
                    exp: p,
                    loc: f
                } = i, d = "bind" === n, h = "on" === n;
                if ("slot" === n) continue;
                if ("once" === n || "memo" === n) continue;
                if ("is" === n || d && Wl(u, "is") && ba(r)) continue;
                if (h && o) continue;
                if (!u && (d || h)) {
                    m = !0, p && (l.length && (c.push(Cl(va(l), s)), l = []), c.push(d ? p : {
                        type: 14,
                        loc: f,
                        callee: t.helper(ll),
                        arguments: [p]
                    }));
                    continue
                }
                const g = t.directiveTransforms[n];
                if (g) {
                    const {
                        props: n,
                        needRuntime: r
                    } = g(i, e, t);
                    !o && n.forEach(y), l.push(...n), r && (a.push(i), F(r) && ha.set(i, r))
                } else a.push(i)
            }
        }
        let b;
        if (c.length ? (l.length && c.push(Cl(va(l), s)), b = c.length > 1 ? Nl(t.helper(nl), c, s) : c[0]) : l.length && (b = Cl(va(l), s)), m ? u |= 16 : (f && !i && (u |= 2), d && !i && (u |= 4), v.length && (u |= 8), h && (u |= 32)), 0 !== u && 32 !== u || !(p || g || a.length > 0) || (u |= 512), !t.inSSR && b) switch (b.type) {
            case 15:
                let e = -1,
                    n = -1,
                    o = !1;
                for (let t = 0; t < b.properties.length; t++) {
                    const r = b.properties[t].key;
                    Ol(r) ? "class" === r.content ? e = t : "style" === r.content && (n = t) : r.isHandlerKey || (o = !0)
                }
                const r = b.properties[e],
                    s = b.properties[n];
                o ? b = Nl(t.helper(sl), [b]) : (r && !Ol(r.value) && (r.value = Nl(t.helper(ol), [r.value])), !s || Ol(s.value) || !d && 17 !== s.value.type || (s.value = Nl(t.helper(rl), [s.value])));
                break;
            case 14:
                break;
            default:
                b = Nl(t.helper(sl), [Nl(t.helper(il), [b])])
        }
        return {
            props: b,
            directives: a,
            patchFlag: u,
            dynamicPropNames: v
        }
    }

    function va(e) {
        const t = new Map,
            n = [];
        for (let o = 0; o < e.length; o++) {
            const r = e[o];
            if (8 === r.key.type || !r.key.isStatic) {
                n.push(r);
                continue
            }
            const s = r.key.content,
                i = t.get(s);
            i ? ("style" === s || "class" === s || S(s)) && ya(i, r) : (t.set(s, r), n.push(r))
        }
        return n
    }

    function ya(e, t) {
        17 === e.value.type ? e.value.elements.push(t.value) : e.value = xl([e.value, t.value], e.loc)
    }

    function ba(e) {
        return "component" === e || "Component" === e
    }
    const _a = (e, t) => {
        if (ql(e)) {
            const {
                children: n,
                loc: o
            } = e, {
                slotName: r,
                slotProps: s
            } = function(e, t) {
                let n, o = '"default"';
                const r = [];
                for (let s = 0; s < e.props.length; s++) {
                    const t = e.props[s];
                    6 === t.type ? t.value && ("name" === t.name ? o = JSON.stringify(t.value.content) : (t.name = D(t.name), r.push(t))) : "bind" === t.name && Wl(t.arg, "name") ? t.exp && (o = t.exp) : ("bind" === t.name && t.arg && Ol(t.arg) && (t.arg.content = D(t.arg.content)), r.push(t))
                }
                if (r.length > 0) {
                    const {
                        props: o,
                        directives: s
                    } = ga(e, t, r);
                    n = o
                }
                return {
                    slotName: o,
                    slotProps: n
                }
            }(e, t), i = [t.prefixIdentifiers ? "_ctx.$slots" : "$slots", r, "{}", "undefined", "true"];
            let l = 2;
            s && (i[2] = s, l = 3), n.length && (i[3] = El([], n, !1, !1, o), l = 4), t.scopeId && !t.slotted && (l = 5), i.splice(l), e.codegenNode = Nl(t.helper(Xi), i, o)
        }
    };
    const Sa = /^\s*([\w$_]+|(async\s*)?\([^)]*?\))\s*=>|^\s*(async\s+)?function(?:\s+[\w$]+)?\s*\(/,
        xa = (e, t, n, o) => {
            const {
                loc: r,
                modifiers: s,
                arg: i
            } = e;
            let l;
            if (4 === i.type)
                if (i.isStatic) {
                    l = kl(G(D(i.content)), !0, i.loc)
                } else l = Tl([`${n.helperString(ul)}(`, i, ")"]);
            else l = i, l.children.unshift(`${n.helperString(ul)}(`), l.children.push(")");
            let c = e.exp;
            c && !c.content.trim() && (c = void 0);
            let a = n.cacheHandlers && !c && !n.inVOnce;
            if (c) {
                const e = Bl(c.content),
                    t = !(e || Sa.test(c.content)),
                    n = c.content.includes(";");
                (t || a && e) && (c = Tl([`${t?"$event":"(...args)"} => ${n?"{":"("}`, c, n ? "}" : ")"]))
            }
            let u = {
                props: [wl(l, c || kl("() => {}", !1, r))]
            };
            return o && (u = o(u)), a && (u.props[0].value = n.cache(u.props[0].value)), u.props.forEach((e => e.key.isHandlerKey = !0)), u
        },
        Ca = (e, t, n) => {
            const {
                exp: o,
                modifiers: r,
                loc: s
            } = e, i = e.arg;
            return 4 !== i.type ? (i.children.unshift("("), i.children.push(') || ""')) : i.isStatic || (i.content = `${i.content} || ""`), r.includes("camel") && (4 === i.type ? i.content = i.isStatic ? D(i.content) : `${n.helperString(cl)}(${i.content})` : (i.children.unshift(`${n.helperString(cl)}(`), i.children.push(")"))), n.inSSR || (r.includes("prop") && wa(i, "."), r.includes("attr") && wa(i, "^")), !o || 4 === o.type && !o.content.trim() ? {
                props: [wl(i, kl("", !0, s))]
            } : {
                props: [wl(i, o)]
            }
        },
        wa = (e, t) => {
            4 === e.type ? e.content = e.isStatic ? t + e.content : `\`${t}\${${e.content}}\`` : (e.children.unshift(`'${t}' + (`), e.children.push(")"))
        },
        ka = (e, t) => {
            if (0 === e.type || 1 === e.type || 11 === e.type || 10 === e.type) return () => {
                const n = e.children;
                let o, r = !1;
                for (let e = 0; e < n.length; e++) {
                    const t = n[e];
                    if (zl(t)) {
                        r = !0;
                        for (let r = e + 1; r < n.length; r++) {
                            const s = n[r];
                            if (!zl(s)) {
                                o = void 0;
                                break
                            }
                            o || (o = n[e] = {
                                type: 8,
                                loc: t.loc,
                                children: [t]
                            }), o.children.push(" + ", s), n.splice(r, 1), r--
                        }
                    }
                }
                if (r && (1 !== n.length || 0 !== e.type && (1 !== e.type || 0 !== e.tagType || e.props.find((e => 7 === e.type && !t.directiveTransforms[e.name])))))
                    for (let e = 0; e < n.length; e++) {
                        const o = n[e];
                        if (zl(o) || 8 === o.type) {
                            const r = [];
                            2 === o.type && " " === o.content || r.push(o), t.ssr || 0 !== Rc(o, t) || r.push("1"), n[e] = {
                                type: 12,
                                content: o,
                                loc: o.loc,
                                codegenNode: Nl(t.helper(zi), r)
                            }
                        }
                    }
            }
        },
        Ta = new WeakSet,
        Na = (e, t) => {
            if (1 === e.type && Hl(e, "once", !0)) {
                if (Ta.has(e) || t.inVOnce) return;
                return Ta.add(e), t.inVOnce = !0, t.helper(pl), () => {
                    t.inVOnce = !1;
                    const e = t.currentNode;
                    e.codegenNode && (e.codegenNode = t.cache(e.codegenNode, !0))
                }
            }
        },
        Ea = (e, t, n) => {
            const {
                exp: o,
                arg: r
            } = e;
            if (!o) return $a();
            const s = o.loc.source,
                i = 4 === o.type ? o.content : s;
            if (!i.trim() || !Bl(i)) return $a();
            const l = r || kl("modelValue", !0),
                c = r ? Ol(r) ? `onUpdate:${r.content}` : Tl(['"onUpdate:" + ', r]) : "onUpdate:modelValue";
            let a;
            a = Tl([`${n.isTS?"($event: any)":"$event"} => ((`, o, ") = $event)"]);
            const u = [wl(l, e.exp), wl(c, a)];
            if (e.modifiers.length && 1 === t.tagType) {
                const t = e.modifiers.map((e => (Ml(e) ? e : JSON.stringify(e)) + ": true")).join(", "),
                    n = r ? Ol(r) ? `${r.content}Modifiers` : Tl([r, ' + "Modifiers"']) : "modelModifiers";
                u.push(wl(n, kl(`{ ${t} }`, !1, e.loc, 2)))
            }
            return $a(u)
        };

    function $a(e = []) {
        return {
            props: e
        }
    }
    const Oa = new WeakSet,
        Ra = (e, t) => {
            if (1 === e.type) {
                const n = Hl(e, "memo");
                if (!n || Oa.has(e)) return;
                return Oa.add(e), () => {
                    const o = e.codegenNode || t.currentNode.codegenNode;
                    o && 13 === o.type && (1 !== e.tagType && tc(o, t), e.codegenNode = Nl(t.helper(vl), [n.exp, El(void 0, o), "_cache", String(t.cached++)]))
                }
            }
        };

    function Aa(e, t = {}) {
        const n = t.onError || Ri,
            o = "module" === t.mode;
        !0 === t.prefixIdentifiers ? n(Fi(46)) : o && n(Fi(47));
        t.cacheHandlers && n(Fi(48)), t.scopeId && !o && n(Fi(49));
        const r = A(e) ? sc(e, t) : e,
            [s, i] = [
                [Na, Yc, Ra, ea, _a, ma, ca, ka], {
                    on: xa,
                    bind: Ca,
                    model: Ea
                }
            ];
        return Bc(r, C({}, t, {
            prefixIdentifiers: false,
            nodeTransforms: [...s, ...t.nodeTransforms || []],
            directiveTransforms: C({}, i, t.directiveTransforms || {})
        })), Hc(r, C({}, t, {
            prefixIdentifiers: false
        }))
    }
    const Fa = Symbol(""),
        Ma = Symbol(""),
        Pa = Symbol(""),
        Va = Symbol(""),
        Ia = Symbol(""),
        Ba = Symbol(""),
        La = Symbol(""),
        ja = Symbol(""),
        Ua = Symbol(""),
        Ha = Symbol("");
    var Da;
    let Wa;
    Da = {
        [Fa]: "vModelRadio",
        [Ma]: "vModelCheckbox",
        [Pa]: "vModelText",
        [Va]: "vModelSelect",
        [Ia]: "vModelDynamic",
        [Ba]: "withModifiers",
        [La]: "withKeys",
        [ja]: "vShow",
        [Ua]: "Transition",
        [Ha]: "TransitionGroup"
    }, Object.getOwnPropertySymbols(Da).forEach((e => {
        bl[e] = Da[e]
    }));
    const za = t("style,iframe,script,noscript", !0),
        Ka = {
            isVoidTag: f,
            isNativeTag: e => u(e) || p(e),
            isPreTag: e => "pre" === e,
            decodeEntities: function(e, t = !1) {
                return Wa || (Wa = document.createElement("div")), t ? (Wa.innerHTML = `<div foo="${e.replace(/"/g,"&quot;")}">`, Wa.children[0].getAttribute("foo")) : (Wa.innerHTML = e, Wa.textContent)
            },
            isBuiltInComponent: e => Rl(e, "Transition") ? Ua : Rl(e, "TransitionGroup") ? Ha : void 0,
            getNamespace(e, t) {
                let n = t ? t.ns : 0;
                if (t && 2 === n)
                    if ("annotation-xml" === t.tag) {
                        if ("svg" === e) return 1;
                        t.props.some((e => 6 === e.type && "encoding" === e.name && null != e.value && ("text/html" === e.value.content || "application/xhtml+xml" === e.value.content))) && (n = 0)
                    } else /^m(?:[ions]|text)$/.test(t.tag) && "mglyph" !== e && "malignmark" !== e && (n = 0);
                else t && 1 === n && ("foreignObject" !== t.tag && "desc" !== t.tag && "title" !== t.tag || (n = 0));
                if (0 === n) {
                    if ("svg" === e) return 1;
                    if ("math" === e) return 2
                }
                return n
            },
            getTextMode({
                tag: e,
                ns: t
            }) {
                if (0 === t) {
                    if ("textarea" === e || "title" === e) return 1;
                    if (za(e)) return 2
                }
                return 0
            }
        },
        Ga = (e, t) => {
            const n = c(e);
            return kl(JSON.stringify(n), !1, t, 3)
        };
    const qa = t("passive,once,capture"),
        Ja = t("stop,prevent,self,ctrl,shift,alt,meta,exact,middle"),
        Ya = t("left,right"),
        Za = t("onkeyup,onkeydown,onkeypress", !0),
        Qa = (e, t) => Ol(e) && "onclick" === e.content.toLowerCase() ? kl(t, !0) : 4 !== e.type ? Tl(["(", e, `) === "onClick" ? "${t}" : (`, e, ")"]) : e,
        Xa = (e, t) => {
            1 !== e.type || 0 !== e.tagType || "script" !== e.tag && "style" !== e.tag || t.removeNode()
        },
        eu = [e => {
            1 === e.type && e.props.forEach(((t, n) => {
                6 === t.type && "style" === t.name && t.value && (e.props[n] = {
                    type: 7,
                    name: "bind",
                    arg: kl("style", !0, t.loc),
                    exp: Ga(t.value.content, t.loc),
                    modifiers: [],
                    loc: t.loc
                })
            }))
        }],
        tu = {
            cloak: () => ({
                props: []
            }),
            html: (e, t, n) => {
                const {
                    exp: o,
                    loc: r
                } = e;
                return t.children.length && (t.children.length = 0), {
                    props: [wl(kl("innerHTML", !0, r), o || kl("", !0))]
                }
            },
            text: (e, t, n) => {
                const {
                    exp: o,
                    loc: r
                } = e;
                return t.children.length && (t.children.length = 0), {
                    props: [wl(kl("textContent", !0), o ? Nl(n.helperString(tl), [o], r) : kl("", !0))]
                }
            },
            model: (e, t, n) => {
                const o = Ea(e, t, n);
                if (!o.props.length || 1 === t.tagType) return o;
                const {
                    tag: r
                } = t, s = n.isCustomElement(r);
                if ("input" === r || "textarea" === r || "select" === r || s) {
                    let e = Pa,
                        i = !1;
                    if ("input" === r || s) {
                        const n = Dl(t, "type");
                        if (n) {
                            if (7 === n.type) e = Ia;
                            else if (n.value) switch (n.value.content) {
                                case "radio":
                                    e = Fa;
                                    break;
                                case "checkbox":
                                    e = Ma;
                                    break;
                                case "file":
                                    i = !0
                            }
                        } else(function(e) {
                            return e.props.some((e => !(7 !== e.type || "bind" !== e.name || e.arg && 4 === e.arg.type && e.arg.isStatic)))
                        })(t) && (e = Ia)
                    } else "select" === r && (e = Va);
                    i || (o.needRuntime = n.helper(e))
                }
                return o.props = o.props.filter((e => !(4 === e.key.type && "modelValue" === e.key.content))), o
            },
            on: (e, t, n) => xa(e, 0, n, (t => {
                const {
                    modifiers: o
                } = e;
                if (!o.length) return t;
                let {
                    key: r,
                    value: s
                } = t.props[0];
                const {
                    keyModifiers: i,
                    nonKeyModifiers: l,
                    eventOptionModifiers: c
                } = ((e, t, n, o) => {
                    const r = [],
                        s = [],
                        i = [];
                    for (let l = 0; l < t.length; l++) {
                        const n = t[l];
                        qa(n) ? i.push(n) : Ya(n) ? Ol(e) ? Za(e.content) ? r.push(n) : s.push(n) : (r.push(n), s.push(n)) : Ja(n) ? s.push(n) : r.push(n)
                    }
                    return {
                        keyModifiers: r,
                        nonKeyModifiers: s,
                        eventOptionModifiers: i
                    }
                })(r, o);
                if (l.includes("right") && (r = Qa(r, "onContextmenu")), l.includes("middle") && (r = Qa(r, "onMouseup")), l.length && (s = Nl(n.helper(Ba), [s, JSON.stringify(l)])), !i.length || Ol(r) && !Za(r.content) || (s = Nl(n.helper(La), [s, JSON.stringify(i)])), c.length) {
                    const e = c.map(K).join("");
                    r = Ol(r) ? kl(`${r.content}${e}`, !0) : Tl(["(", r, `) + "${e}"`])
                }
                return {
                    props: [wl(r, s)]
                }
            })),
            show: (e, t, n) => ({
                props: [],
                needRuntime: n.helper(ja)
            })
        };
    const nu = Object.create(null);

    function ou(e, t) {
        if (!A(e)) {
            if (!e.nodeType) return y;
            e = e.innerHTML
        }
        const n = e,
            o = nu[n];
        if (o) return o;
        if ("#" === e[0]) {
            const t = document.querySelector(e);
            e = t ? t.innerHTML : ""
        }
        const {
            code: r
        } = function(e, t = {}) {
            return Aa(e, C({}, Ka, t, {
                nodeTransforms: [Xa, ...eu, ...t.nodeTransforms || []],
                directiveTransforms: C({}, tu, t.directiveTransforms || {}),
                transformHoist: null
            }))
        }(e, C({
            hoistStatic: !0,
            onError: void 0,
            onWarn: y
        }, t)), s = new Function(r)();
        return s._rc = !0, nu[n] = s
    }
    return br(ou), e.BaseTransition = sn, e.Comment = Fo, e.EffectScope = te, e.Fragment = Ro, e.KeepAlive = vn, e.ReactiveEffect = de, e.Static = Mo, e.Suspense = Jt, e.Teleport = To, e.Text = Ao, e.Transition = Vs, e.TransitionGroup = ei, e.VueElement = Rs, e.callWithAsyncErrorHandling = Or, e.callWithErrorHandling = $r, e.camelize = D, e.capitalize = K, e.cloneVNode = Zo, e.compatUtils = null, e.compile = ou, e.computed = Pt, e.createApp = (...e) => {
        const t = ki().createApp(...e),
            {
                mount: n
            } = t;
        return t.mount = e => {
            const o = $i(e);
            if (!o) return;
            const r = t._component;
            R(r) || r.render || r.template || (r.template = o.innerHTML), o.innerHTML = "";
            const s = n(o, !1, o instanceof SVGElement);
            return o instanceof Element && (o.removeAttribute("v-cloak"), o.setAttribute("data-v-app", "")), s
        }, t
    }, e.createBlock = Ho, e.createCommentVNode = function(e = "", t = !1) {
        return t ? (Io(), Ho(Fo, null, e)) : Jo(Fo, null, e)
    }, e.createElementBlock = function(e, t, n, o, r, s) {
        return Uo(qo(e, t, n, o, r, s, !0))
    }, e.createElementVNode = qo, e.createHydrationRenderer = vo, e.createPropsRestProxy = function(e, t) {
        const n = {};
        for (const o in e) t.includes(o) || Object.defineProperty(n, o, {
            enumerable: !0,
            get: () => e[o]
        });
        return n
    }, e.createRenderer = go, e.createSSRApp = (...e) => {
        const t = Ti().createApp(...e),
            {
                mount: n
            } = t;
        return t.mount = e => {
            const t = $i(e);
            if (t) return n(t, !0, t instanceof SVGElement)
        }, t
    }, e.createSlots = function(e, t) {
        for (let n = 0; n < t.length; n++) {
            const o = t[n];
            if (N(o))
                for (let t = 0; t < o.length; t++) e[o[t].name] = o[t].fn;
            else o && (e[o.name] = o.fn)
        }
        return e
    }, e.createStaticVNode = function(e, t) {
        const n = Jo(Mo, null, e);
        return n.staticCount = t, n
    }, e.createTextVNode = Qo, e.createVNode = Jo, e.customRef = function(e) {
        return new Rt(e)
    }, e.defineAsyncComponent = function(e) {
        R(e) && (e = {
            loader: e
        });
        const {
            loader: t,
            loadingComponent: n,
            errorComponent: o,
            delay: r = 200,
            timeout: s,
            suspensible: i = !0,
            onError: l
        } = e;
        let c, a = null,
            u = 0;
        const p = () => {
            let e;
            return a || (e = a = t().catch((e => {
                if (e = e instanceof Error ? e : new Error(String(e)), l) return new Promise(((t, n) => {
                    l(e, (() => t((u++, a = null, p()))), (() => n(e)), u + 1)
                }));
                throw e
            })).then((t => e !== a && a ? a : (t && (t.__esModule || "Module" === t[Symbol.toStringTag]) && (t = t.default), c = t, t))))
        };
        return dn({
            name: "AsyncComponentWrapper",
            __asyncLoader: p,
            get __asyncResolved() {
                return c
            },
            setup() {
                const e = ur;
                if (c) return () => mn(c, e);
                const t = t => {
                    a = null, Rr(t, e, 13, !o)
                };
                if (i && e.suspense) return p().then((t => () => mn(t, e))).catch((e => (t(e), () => o ? Jo(o, {
                    error: e
                }) : null)));
                const l = kt(!1),
                    u = kt(),
                    f = kt(!!r);
                return r && setTimeout((() => {
                    f.value = !1
                }), r), null != s && setTimeout((() => {
                    if (!l.value && !u.value) {
                        const e = new Error(`Async component timed out after ${s}ms.`);
                        t(e), u.value = e
                    }
                }), s), p().then((() => {
                    l.value = !0, e.parent && gn(e.parent.vnode) && Kr(e.parent.update)
                })).catch((e => {
                    t(e), u.value = e
                })), () => l.value && c ? mn(c, e) : u.value && o ? Jo(o, {
                    error: u.value
                }) : n && !f.value ? Jo(n) : void 0
            }
        })
    }, e.defineComponent = dn, e.defineCustomElement = $s, e.defineEmits = function() {
        return null
    }, e.defineExpose = function(e) {}, e.defineProps = function() {
        return null
    }, e.defineSSRCustomElement = e => $s(e, Ei), e.effect = function(e, t) {
        e.effect && (e = e.effect.fn);
        const n = new de(e);
        t && (C(n, t), t.scope && ne(n, t.scope)), t && t.lazy || n.run();
        const o = n.run.bind(n);
        return o.effect = n, o
    }, e.effectScope = function(e) {
        return new te(e)
    }, e.getCurrentInstance = pr, e.getCurrentScope = function() {
        return X
    }, e.getTransitionRawChildren = fn, e.guardReactiveProps = Yo, e.h = cs, e.handleError = Rr, e.hydrate = Ei, e.initCustomFormatter = function() {}, e.initDirectivesForSSR = Oi, e.inject = nn, e.isMemoSame = us, e.isProxy = vt, e.isReactive = mt, e.isReadonly = gt, e.isRef = wt, e.isRuntimeOnly = () => !mr, e.isVNode = Do, e.markRaw = bt, e.mergeDefaults = function(e, t) {
        const n = N(e) ? e.reduce(((e, t) => (e[t] = {}, e)), {}) : e;
        for (const o in t) {
            const e = n[o];
            e ? N(e) || R(e) ? n[o] = {
                type: e,
                default: t[o]
            } : e.default = t[o] : null === e && (n[o] = {
                default: t[o]
            })
        }
        return n
    }, e.mergeProps = nr, e.nextTick = zr, e.normalizeClass = a, e.normalizeProps = function(e) {
        if (!e) return null;
        let {
            class: t,
            style: n
        } = e;
        return t && !A(t) && (e.class = a(t)), n && (e.style = s(n)), e
    }, e.normalizeStyle = s, e.onActivated = bn, e.onBeforeMount = Nn, e.onBeforeUnmount = Rn, e.onBeforeUpdate = $n, e.onDeactivated = _n, e.onErrorCaptured = Vn, e.onMounted = En, e.onRenderTracked = Pn, e.onRenderTriggered = Mn, e.onScopeDispose = function(e) {
        X && X.cleanups.push(e)
    }, e.onServerPrefetch = Fn, e.onUnmounted = An, e.onUpdated = On, e.openBlock = Io, e.popScopeId = function() {
        Ut = null
    }, e.provide = tn, e.proxyRefs = Ot, e.pushScopeId = function(e) {
        Ut = e
    }, e.queuePostFlushCb = Jr, e.reactive = pt, e.readonly = dt, e.ref = kt, e.registerRuntimeCompiler = br, e.render = Ni, e.renderList = function(e, t, n, o) {
        let r;
        const s = n && n[o];
        if (N(e) || A(e)) {
            r = new Array(e.length);
            for (let n = 0, o = e.length; n < o; n++) r[n] = t(e[n], n, void 0, s && s[n])
        } else if ("number" == typeof e) {
            r = new Array(e);
            for (let n = 0; n < e; n++) r[n] = t(n + 1, n, void 0, s && s[n])
        } else if (M(e))
            if (e[Symbol.iterator]) r = Array.from(e, ((e, n) => t(e, n, void 0, s && s[n])));
            else {
                const n = Object.keys(e);
                r = new Array(n.length);
                for (let o = 0, i = n.length; o < i; o++) {
                    const i = n[o];
                    r[o] = t(e[i], i, o, s && s[o])
                }
            }
        else r = [];
        return n && (n[o] = r), r
    }, e.renderSlot = function(e, t, n = {}, o, r) {
        if (jt.isCE) return Jo("slot", "default" === t ? null : {
            name: t
        }, o && o());
        let s = e[t];
        s && s._c && (s._d = !1), Io();
        const i = s && or(s(n)),
            l = Ho(Ro, {
                key: n.key || `_${t}`
            }, i || (o ? o() : []), i && 1 === e._ ? 64 : -2);
        return !r && l.scopeId && (l.slotScopeIds = [l.scopeId + "-s"]), s && s._c && (s._d = !0), l
    }, e.resolveComponent = function(e, t) {
        return $o(No, e, !0, t) || e
    }, e.resolveDirective = function(e) {
        return $o("directives", e)
    }, e.resolveDynamicComponent = function(e) {
        return A(e) ? $o(No, e, !1) || e : e || Eo
    }, e.resolveFilter = null, e.resolveTransitionHooks = cn, e.setBlockTracking = jo, e.setDevtoolsHook = function t(n, o) {
        var r, s;
        if (e.devtools = n, e.devtools) e.devtools.enabled = !0, Vt.forEach((({
            event: t,
            args: n
        }) => e.devtools.emit(t, ...n))), Vt = [];
        else if ("undefined" != typeof window && window.HTMLElement && !(null === (s = null === (r = window.navigator) || void 0 === r ? void 0 : r.userAgent) || void 0 === s ? void 0 : s.includes("jsdom"))) {
            (o.__VUE_DEVTOOLS_HOOK_REPLAY__ = o.__VUE_DEVTOOLS_HOOK_REPLAY__ || []).push((e => {
                t(e, o)
            })), setTimeout((() => {
                e.devtools || (o.__VUE_DEVTOOLS_HOOK_REPLAY__ = null, Vt = [])
            }), 3e3)
        } else Vt = []
    }, e.setTransitionHooks = pn, e.shallowReactive = ft, e.shallowReadonly = function(e) {
        return ht(e, !0, Ie, st, at)
    }, e.shallowRef = function(e) {
        return Tt(e, !0)
    }, e.ssrContextKey = as, e.ssrUtils = null, e.stop = function(e) {
        e.effect.stop()
    }, e.toDisplayString = e => null == e ? "" : N(e) || M(e) && (e.toString === V || !R(e.toString)) ? JSON.stringify(e, m, 2) : String(e), e.toHandlerKey = G, e.toHandlers = function(e) {
        const t = {};
        for (const n in e) t[G(n)] = e[n];
        return t
    }, e.toRaw = yt, e.toRef = Ft, e.toRefs = function(e) {
        const t = N(e) ? new Array(e.length) : {};
        for (const n in e) t[n] = Ft(e, n);
        return t
    }, e.transformVNodeArgs = function(e) {}, e.triggerRef = function(e) {
        Ct(e)
    }, e.unref = Et, e.useAttrs = function() {
        return ls().attrs
    }, e.useCssModule = function(e = "$style") {
        return g
    }, e.useCssVars = function(e) {
        const t = pr();
        if (!t) return;
        const n = () => As(t.subTree, e(t.proxy));
        es(n), En((() => {
            const e = new MutationObserver(n);
            e.observe(t.subTree.el.parentNode, {
                childList: !0
            }), An((() => e.disconnect()))
        }))
    }, e.useSSRContext = () => {}, e.useSlots = function() {
        return ls().slots
    }, e.useTransitionState = on, e.vModelCheckbox = ci, e.vModelDynamic = mi, e.vModelRadio = ui, e.vModelSelect = pi, e.vModelText = li, e.vShow = _i, e.version = ps, e.warn = function(e, ...t) {
        ve();
        const n = Tr.length ? Tr[Tr.length - 1].component : null,
            o = n && n.appContext.config.warnHandler,
            r = function() {
                let e = Tr[Tr.length - 1];
                if (!e) return [];
                const t = [];
                for (; e;) {
                    const n = t[0];
                    n && n.vnode === e ? n.recurseCount++ : t.push({
                        vnode: e,
                        recurseCount: 0
                    });
                    const o = e.component && e.component.parent;
                    e = o && o.vnode
                }
                return t
            }();
        if (o) $r(o, n, 11, [e + t.join(""), n && n.proxy, r.map((({
            vnode: e
        }) => `at <${kr(n,e.type)}>`)).join("\n"), r]);
        else {
            const n = [`[Vue warn]: ${e}`, ...t];
            r.length && n.push("\n", ... function(e) {
                const t = [];
                return e.forEach(((e, n) => {
                    t.push(...0 === n ? [] : ["\n"], ... function({
                        vnode: e,
                        recurseCount: t
                    }) {
                        const n = t > 0 ? `... (${t} recursive calls)` : "",
                            o = ` at <${kr(e.component,e.type,!!e.component&&null==e.component.parent)}`,
                            r = ">" + n;
                        return e.props ? [o, ...Nr(e.props), r] : [o + r]
                    }(e))
                })), t
            }(r)), console.warn(...n)
        }
        ye()
    }, e.watch = ns, e.watchEffect = function(e, t) {
        return os(e, null, t)
    }, e.watchPostEffect = es, e.watchSyncEffect = function(e, t) {
        return os(e, null, {
            flush: "sync"
        })
    }, e.withAsyncContext = function(e) {
        const t = pr();
        let n = e();
        return dr(), P(n) && (n = n.catch((e => {
            throw fr(t), e
        }))), [n, () => fr(t)]
    }, e.withCtx = Dt, e.withDefaults = function(e, t) {
        return null
    }, e.withDirectives = function(e, t) {
        if (null === jt) return e;
        const n = jt.proxy,
            o = e.dirs || (e.dirs = []);
        for (let r = 0; r < t.length; r++) {
            let [e, s, i, l = g] = t[r];
            R(e) && (e = {
                mounted: e,
                updated: e
            }), e.deep && is(s), o.push({
                dir: e,
                instance: n,
                value: s,
                oldValue: void 0,
                arg: i,
                modifiers: l
            })
        }
        return e
    }, e.withKeys = (e, t) => n => {
        if (!("key" in n)) return;
        const o = z(n.key);
        return t.some((e => e === o || bi[e] === o)) ? e(n) : void 0
    }, e.withMemo = function(e, t, n, o) {
        const r = n[o];
        if (r && us(r, e)) return r;
        const s = t();
        return s.memo = e.slice(), n[o] = s
    }, e.withModifiers = (e, t) => (n, ...o) => {
        for (let e = 0; e < t.length; e++) {
            const o = yi[t[e]];
            if (o && o(n, t)) return
        }
        return e(n, ...o)
    }, e.withScopeId = e => Dt, Object.defineProperty(e, "__esModule", {
        value: !0
    }), e
}({});

! function(e, n) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = n() : "function" == typeof define && define.amd ? define(n) : (e = e || self).mitt = n()
}(this, function() {
    return function(e) {
        return {
            all: e = e || new Map,
            on: function(n, t) {
                var f = e.get(n);
                f ? f.push(t) : e.set(n, [t])
            },
            off: function(n, t) {
                var f = e.get(n);
                f && (t ? f.splice(f.indexOf(t) >>> 0, 1) : e.set(n, []))
            },
            emit: function(n, t) {
                var f = e.get(n);
                f && f.slice().map(function(e) {
                    e(t)
                }), (f = e.get("*")) && f.slice().map(function(e) {
                    e(n, t)
                })
            }
        }
    }
});

const emitter = mitt();



this.primevue = this.primevue || {}, this.primevue.utils = function(e) {
    "use strict";
    var t = {
        innerWidth(e) {
            let t = e.offsetWidth,
                l = getComputedStyle(e);
            return t += parseFloat(l.paddingLeft) + parseFloat(l.paddingRight), t
        },
        width(e) {
            let t = e.offsetWidth,
                l = getComputedStyle(e);
            return t -= parseFloat(l.paddingLeft) + parseFloat(l.paddingRight), t
        },
        getWindowScrollTop() {
            let e = document.documentElement;
            return (window.pageYOffset || e.scrollTop) - (e.clientTop || 0)
        },
        getWindowScrollLeft() {
            let e = document.documentElement;
            return (window.pageXOffset || e.scrollLeft) - (e.clientLeft || 0)
        },
        getOuterWidth(e, t) {
            if (e) {
                let l = e.offsetWidth;
                if (t) {
                    let t = getComputedStyle(e);
                    l += parseFloat(t.marginLeft) + parseFloat(t.marginRight)
                }
                return l
            }
            return 0
        },
        getOuterHeight(e, t) {
            if (e) {
                let l = e.offsetHeight;
                if (t) {
                    let t = getComputedStyle(e);
                    l += parseFloat(t.marginTop) + parseFloat(t.marginBottom)
                }
                return l
            }
            return 0
        },
        getClientHeight(e, t) {
            if (e) {
                let l = e.clientHeight;
                if (t) {
                    let t = getComputedStyle(e);
                    l += parseFloat(t.marginTop) + parseFloat(t.marginBottom)
                }
                return l
            }
            return 0
        },
        getViewport() {
            let e = window,
                t = document,
                l = t.documentElement,
                n = t.getElementsByTagName("body")[0];
            return {
                width: e.innerWidth || l.clientWidth || n.clientWidth,
                height: e.innerHeight || l.clientHeight || n.clientHeight
            }
        },
        getOffset(e) {
            var t = e.getBoundingClientRect();
            return {
                top: t.top + (window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop || 0),
                left: t.left + (window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft || 0)
            }
        },
        index(e) {
            let t = e.parentNode.childNodes,
                l = 0;
            for (var n = 0; n < t.length; n++) {
                if (t[n] === e) return l;
                1 === t[n].nodeType && l++
            }
            return -1
        },
        addMultipleClasses(e, t) {
            if (e.classList) {
                let l = t.split(" ");
                for (let t = 0; t < l.length; t++) e.classList.add(l[t])
            } else {
                let l = t.split(" ");
                for (let t = 0; t < l.length; t++) e.className += " " + l[t]
            }
        },
        addClass(e, t) {
            e.classList ? e.classList.add(t) : e.className += " " + t
        },
        removeClass(e, t) {
            e.classList ? e.classList.remove(t) : e.className = e.className.replace(new RegExp("(^|\\b)" + t.split(" ").join("|") + "(\\b|$)", "gi"), " ")
        },
        hasClass: (e, t) => !!e && (e.classList ? e.classList.contains(t) : new RegExp("(^| )" + t + "( |$)", "gi").test(e.className)),
        find: (e, t) => e.querySelectorAll(t),
        findSingle: (e, t) => e.querySelector(t),
        getHeight(e) {
            let t = e.offsetHeight,
                l = getComputedStyle(e);
            return t -= parseFloat(l.paddingTop) + parseFloat(l.paddingBottom) + parseFloat(l.borderTopWidth) + parseFloat(l.borderBottomWidth), t
        },
        getWidth(e) {
            let t = e.offsetWidth,
                l = getComputedStyle(e);
            return t -= parseFloat(l.paddingLeft) + parseFloat(l.paddingRight) + parseFloat(l.borderLeftWidth) + parseFloat(l.borderRightWidth), t
        },
        absolutePosition(e, t) {
            let l, n, i = e.offsetParent ? {
                    width: e.offsetWidth,
                    height: e.offsetHeight
                } : this.getHiddenElementDimensions(e),
                r = i.height,
                o = i.width,
                s = t.offsetHeight,
                a = t.offsetWidth,
                d = t.getBoundingClientRect(),
                p = this.getWindowScrollTop(),
                c = this.getWindowScrollLeft(),
                h = this.getViewport();
            d.top + s + r > h.height ? (l = d.top + p - r, e.style.transformOrigin = "bottom", l < 0 && (l = p)) : (l = s + d.top + p, e.style.transformOrigin = "top"), n = d.left + o > h.width ? Math.max(0, d.left + c + a - o) : d.left + c, e.style.top = l + "px", e.style.left = n + "px"
        },
        relativePosition(e, t) {
            let l = e.offsetParent ? {
                width: e.offsetWidth,
                height: e.offsetHeight
            } : this.getHiddenElementDimensions(e);
            const n = t.offsetHeight,
                i = t.getBoundingClientRect(),
                r = this.getViewport();
            let o, s;
            i.top + n + l.height > r.height ? (o = -1 * l.height, e.style.transformOrigin = "bottom", i.top + o < 0 && (o = -1 * i.top)) : (o = n, e.style.transformOrigin = "top"), s = l.width > r.width ? -1 * i.left : i.left + l.width > r.width ? -1 * (i.left + l.width - r.width) : 0, e.style.top = o + "px", e.style.left = s + "px"
        },
        getParents(e, t = []) {
            return null === e.parentNode ? t : this.getParents(e.parentNode, t.concat([e.parentNode]))
        },
        getScrollableParents(e) {
            let t = [];
            if (e) {
                let l = this.getParents(e);
                const n = /(auto|scroll)/,
                    i = e => {
                        let t = window.getComputedStyle(e, null);
                        return n.test(t.getPropertyValue("overflow")) || n.test(t.getPropertyValue("overflowX")) || n.test(t.getPropertyValue("overflowY"))
                    };
                for (let e of l) {
                    let l = 1 === e.nodeType && e.dataset.scrollselectors;
                    if (l) {
                        let n = l.split(",");
                        for (let l of n) {
                            let n = this.findSingle(e, l);
                            n && i(n) && t.push(n)
                        }
                    }
                    9 !== e.nodeType && i(e) && t.push(e)
                }
            }
            return t
        },
        getHiddenElementOuterHeight(e) {
            e.style.visibility = "hidden", e.style.display = "block";
            let t = e.offsetHeight;
            return e.style.display = "none", e.style.visibility = "visible", t
        },
        getHiddenElementOuterWidth(e) {
            e.style.visibility = "hidden", e.style.display = "block";
            let t = e.offsetWidth;
            return e.style.display = "none", e.style.visibility = "visible", t
        },
        getHiddenElementDimensions(e) {
            var t = {};
            return e.style.visibility = "hidden", e.style.display = "block", t.width = e.offsetWidth, t.height = e.offsetHeight, e.style.display = "none", e.style.visibility = "visible", t
        },
        fadeIn(e, t) {
            e.style.opacity = 0;
            var l = +new Date,
                n = 0,
                i = function() {
                    n = +e.style.opacity + ((new Date).getTime() - l) / t, e.style.opacity = n, l = +new Date, +n < 1 && (window.requestAnimationFrame && requestAnimationFrame(i) || setTimeout(i, 16))
                };
            i()
        },
        fadeOut(e, t) {
            var l = 1,
                n = 50 / t;
            let i = setInterval((() => {
                (l -= n) <= 0 && (l = 0, clearInterval(i)), e.style.opacity = l
            }), 50)
        },
        getUserAgent: () => navigator.userAgent,
        appendChild(e, t) {
            if (this.isElement(t)) t.appendChild(e);
            else {
                if (!t.el || !t.elElement) throw new Error("Cannot append " + t + " to " + e);
                t.elElement.appendChild(e)
            }
        },
        scrollInView(e, t) {
            let l = getComputedStyle(e).getPropertyValue("borderTopWidth"),
                n = l ? parseFloat(l) : 0,
                i = getComputedStyle(e).getPropertyValue("paddingTop"),
                r = i ? parseFloat(i) : 0,
                o = e.getBoundingClientRect(),
                s = t.getBoundingClientRect().top + document.body.scrollTop - (o.top + document.body.scrollTop) - n - r,
                a = e.scrollTop,
                d = e.clientHeight,
                p = this.getOuterHeight(t);
            s < 0 ? e.scrollTop = a + s : s + p > d && (e.scrollTop = a + s - d + p)
        },
        clearSelection() {
            if (window.getSelection) window.getSelection().empty ? window.getSelection().empty() : window.getSelection().removeAllRanges && window.getSelection().rangeCount > 0 && window.getSelection().getRangeAt(0).getClientRects().length > 0 && window.getSelection().removeAllRanges();
            else if (document.selection && document.selection.empty) try {
                document.selection.empty()
            } catch (e) {}
        },
        calculateScrollbarWidth() {
            if (null != this.calculatedScrollbarWidth) return this.calculatedScrollbarWidth;
            let e = document.createElement("div");
            e.className = "p-scrollbar-measure", document.body.appendChild(e);
            let t = e.offsetWidth - e.clientWidth;
            return document.body.removeChild(e), this.calculatedScrollbarWidth = t, t
        },
        getBrowser() {
            if (!this.browser) {
                let e = this.resolveUserAgent();
                this.browser = {}, e.browser && (this.browser[e.browser] = !0, this.browser.version = e.version), this.browser.chrome ? this.browser.webkit = !0 : this.browser.webkit && (this.browser.safari = !0)
            }
            return this.browser
        },
        resolveUserAgent() {
            let e = navigator.userAgent.toLowerCase(),
                t = /(chrome)[ ]([\w.]+)/.exec(e) || /(webkit)[ ]([\w.]+)/.exec(e) || /(opera)(?:.*version|)[ ]([\w.]+)/.exec(e) || /(msie) ([\w.]+)/.exec(e) || e.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(e) || [];
            return {
                browser: t[1] || "",
                version: t[2] || "0"
            }
        },
        isVisible: e => null != e.offsetParent,
        invokeElementMethod(e, t, l) {
            e[t].apply(e, l)
        },
        getFocusableElements(e) {
            let t = this.find(e, 'button:not([tabindex = "-1"]):not([disabled]):not([style*="display:none"]):not([hidden]),\n                [href][clientHeight][clientWidth]:not([tabindex = "-1"]):not([disabled]):not([style*="display:none"]):not([hidden]),\n                input:not([tabindex = "-1"]):not([disabled]):not([style*="display:none"]):not([hidden]), select:not([tabindex = "-1"]):not([disabled]):not([style*="display:none"]):not([hidden]),\n                textarea:not([tabindex = "-1"]):not([disabled]):not([style*="display:none"]):not([hidden]), [tabIndex]:not([tabIndex = "-1"]):not([disabled]):not([style*="display:none"]):not([hidden]),\n                [contenteditable]:not([tabIndex = "-1"]):not([disabled]):not([style*="display:none"]):not([hidden])'),
                l = [];
            for (let e of t) "none" != getComputedStyle(e).display && "hidden" != getComputedStyle(e).visibility && l.push(e);
            return l
        },
        getFirstFocusableElement(e) {
            const t = this.getFocusableElements(e);
            return t.length > 0 ? t[0] : null
        },
        isClickable(e) {
            const t = e.nodeName,
                l = e.parentElement && e.parentElement.nodeName;
            return "INPUT" == t || "BUTTON" == t || "A" == t || "INPUT" == l || "BUTTON" == l || "A" == l || this.hasClass(e, "p-button") || this.hasClass(e.parentElement, "p-button") || this.hasClass(e.parentElement, "p-checkbox") || this.hasClass(e.parentElement, "p-radiobutton")
        },
        applyStyle(e, t) {
            if ("string" == typeof t) e.style.cssText = this.style;
            else
                for (let l in this.style) e.style[l] = t[l]
        },
        isIOS: () => /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream,
        isAndroid: () => /(android)/i.test(navigator.userAgent),
        isTouchDevice: () => "ontouchstart" in window || navigator.maxTouchPoints > 0 || navigator.msMaxTouchPoints > 0
    };
    var l = {
        equals(e, t, l) {
            return l ? this.resolveFieldData(e, l) === this.resolveFieldData(t, l) : this.deepEquals(e, t)
        },
        deepEquals(e, t) {
            if (e === t) return !0;
            if (e && t && "object" == typeof e && "object" == typeof t) {
                var l, n, i, r = Array.isArray(e),
                    o = Array.isArray(t);
                if (r && o) {
                    if ((n = e.length) != t.length) return !1;
                    for (l = n; 0 != l--;)
                        if (!this.deepEquals(e[l], t[l])) return !1;
                    return !0
                }
                if (r != o) return !1;
                var s = e instanceof Date,
                    a = t instanceof Date;
                if (s != a) return !1;
                if (s && a) return e.getTime() == t.getTime();
                var d = e instanceof RegExp,
                    p = t instanceof RegExp;
                if (d != p) return !1;
                if (d && p) return e.toString() == t.toString();
                var c = Object.keys(e);
                if ((n = c.length) !== Object.keys(t).length) return !1;
                for (l = n; 0 != l--;)
                    if (!Object.prototype.hasOwnProperty.call(t, c[l])) return !1;
                for (l = n; 0 != l--;)
                    if (i = c[l], !this.deepEquals(e[i], t[i])) return !1;
                return !0
            }
            return e != e && t != t
        },
        resolveFieldData(e, t) {
            if (e && Object.keys(e).length && t) {
                if (this.isFunction(t)) return t(e);
                if (-1 === t.indexOf(".")) return e[t]; {
                    let i = t.split("."),
                        r = e;
                    for (var l = 0, n = i.length; l < n; ++l) {
                        if (null == r) return null;
                        r = r[i[l]]
                    }
                    return r
                }
            }
            return null
        },
        isFunction: e => !!(e && e.constructor && e.call && e.apply),
        filter(e, t, l) {
            var n = [];
            if (e)
                for (let i of e)
                    for (let e of t)
                        if (String(this.resolveFieldData(i, e)).toLowerCase().indexOf(l.toLowerCase()) > -1) {
                            n.push(i);
                            break
                        } return n
        },
        reorderArray(e, t, l) {
            let n;
            if (e && t !== l) {
                if (l >= e.length)
                    for (n = l - e.length; 1 + n--;) e.push(void 0);
                e.splice(l, 0, e.splice(t, 1)[0])
            }
        },
        findIndexInList(e, t) {
            let l = -1;
            if (t)
                for (let n = 0; n < t.length; n++)
                    if (t[n] === e) {
                        l = n;
                        break
                    } return l
        },
        contains(e, t) {
            if (null != e && t && t.length)
                for (let l of t)
                    if (this.equals(e, l)) return !0;
            return !1
        },
        insertIntoOrderedArray(e, t, l, n) {
            if (l.length > 0) {
                let i = !1;
                for (let r = 0; r < l.length; r++) {
                    if (this.findIndexInList(l[r], n) > t) {
                        l.splice(r, 0, e), i = !0;
                        break
                    }
                }
                i || l.push(e)
            } else l.push(e)
        },
        removeAccents: e => (e && e.search(/[\xC0-\xFF]/g) > -1 && (e = e.replace(/[\xC0-\xC5]/g, "A").replace(/[\xC6]/g, "AE").replace(/[\xC7]/g, "C").replace(/[\xC8-\xCB]/g, "E").replace(/[\xCC-\xCF]/g, "I").replace(/[\xD0]/g, "D").replace(/[\xD1]/g, "N").replace(/[\xD2-\xD6\xD8]/g, "O").replace(/[\xD9-\xDC]/g, "U").replace(/[\xDD]/g, "Y").replace(/[\xDE]/g, "P").replace(/[\xE0-\xE5]/g, "a").replace(/[\xE6]/g, "ae").replace(/[\xE7]/g, "c").replace(/[\xE8-\xEB]/g, "e").replace(/[\xEC-\xEF]/g, "i").replace(/[\xF1]/g, "n").replace(/[\xF2-\xF6\xF8]/g, "o").replace(/[\xF9-\xFC]/g, "u").replace(/[\xFE]/g, "p").replace(/[\xFD\xFF]/g, "y")), e),
        getVNodeProp(e, t) {
            let l = e.props;
            if (l) {
                let n = t.replace(/([a-z])([A-Z])/g, "$1-$2").toLowerCase(),
                    i = Object.prototype.hasOwnProperty.call(l, n) ? n : t;
                return e.type.props[t].type === Boolean && "" === l[i] || l[i]
            }
            return null
        }
    };
    var n = function() {
            let e = [];
            const t = e => e && parseInt(e.style.zIndex, 10) || 0;
            return {
                get: t,
                set: (t, l, n) => {
                    l && (l.style.zIndex = String(((t, l) => {
                        let n = e.length > 0 ? e[e.length - 1] : {
                                key: t,
                                value: l
                            },
                            i = n.value + (n.key === t ? 0 : l) + 1;
                        return e.push({
                            key: t,
                            value: i
                        }), i
                    })(t, n)))
                },
                clear: l => {
                    var n;
                    l && (n = t(l), e = e.filter((e => e.value !== n)), l.style.zIndex = "")
                },
                getCurrent: () => e.length > 0 ? e[e.length - 1].value : 0
            }
        }(),
        i = 0;
    return e.ConnectedOverlayScrollHandler = class {
        constructor(e, t = (() => {})) {
            this.element = e, this.listener = t
        }
        bindScrollListener() {
            this.scrollableParents = t.getScrollableParents(this.element);
            for (let e = 0; e < this.scrollableParents.length; e++) this.scrollableParents[e].addEventListener("scroll", this.listener)
        }
        unbindScrollListener() {
            if (this.scrollableParents)
                for (let e = 0; e < this.scrollableParents.length; e++) this.scrollableParents[e].removeEventListener("scroll", this.listener)
        }
        destroy() {
            this.unbindScrollListener(), this.element = null, this.listener = null, this.scrollableParents = null
        }
    }, e.DomHandler = t, e.EventBus = function() {
        const e = new Map;
        return {
            on(t, l) {
                let n = e.get(t);
                n ? n.push(l) : n = [l], e.set(t, n)
            },
            off(t, l) {
                let n = e.get(t);
                n && n.splice(n.indexOf(l) >>> 0, 1)
            },
            emit(t, l) {
                let n = e.get(t);
                n && n.slice().map((e => {
                    e(l)
                }))
            }
        }
    }, e.ObjectUtils = l, e.UniqueComponentId = function(e = "pv_id_") {
        return `${e}${++i}`
    }, e.ZIndexUtils = n, Object.defineProperty(e, "__esModule", {
        value: !0
    }), e
}({});

this.primevue = this.primevue || {}, this.primevue.api = function(i, p) {
    "use strict";
    const e = {
        filter(i, e, t, r, l) {
            let o = [];
            if (i)
                for (let n of i)
                    for (let i of e) {
                        let e = p.ObjectUtils.resolveFieldData(n, i);
                        if (this.filters[r](e, t, l)) {
                            o.push(n);
                            break
                        }
                    }
            return o
        },
        filters: {
            startsWith(i, e, t) {
                if (null == e || "" === e.trim()) return !0;
                if (null == i) return !1;
                let r = p.ObjectUtils.removeAccents(e.toString()).toLocaleLowerCase(t);
                return p.ObjectUtils.removeAccents(i.toString()).toLocaleLowerCase(t).slice(0, r.length) === r
            },
            contains(i, e, t) {
                if (null == e || "string" == typeof e && "" === e.trim()) return !0;
                if (null == i) return !1;
                let r = p.ObjectUtils.removeAccents(e.toString()).toLocaleLowerCase(t);
                return -1 !== p.ObjectUtils.removeAccents(i.toString()).toLocaleLowerCase(t).indexOf(r)
            },
            notContains(i, e, t) {
                if (null == e || "string" == typeof e && "" === e.trim()) return !0;
                if (null == i) return !1;
                let r = p.ObjectUtils.removeAccents(e.toString()).toLocaleLowerCase(t);
                return -1 === p.ObjectUtils.removeAccents(i.toString()).toLocaleLowerCase(t).indexOf(r)
            },
            endsWith(i, e, t) {
                if (null == e || "" === e.trim()) return !0;
                if (null == i) return !1;
                let r = p.ObjectUtils.removeAccents(e.toString()).toLocaleLowerCase(t),
                    l = p.ObjectUtils.removeAccents(i.toString()).toLocaleLowerCase(t);
                return -1 !== l.indexOf(r, l.length - r.length)
            },
            equals: (i, e, t) => null == e || "string" == typeof e && "" === e.trim() || null != i && (i.getTime && e.getTime ? i.getTime() === e.getTime() : p.ObjectUtils.removeAccents(i.toString()).toLocaleLowerCase(t) == p.ObjectUtils.removeAccents(e.toString()).toLocaleLowerCase(t)),
            notEquals: (i, e, t) => null != e && ("string" != typeof e || "" !== e.trim()) && (null == i || (i.getTime && e.getTime ? i.getTime() !== e.getTime() : p.ObjectUtils.removeAccents(i.toString()).toLocaleLowerCase(t) != p.ObjectUtils.removeAccents(e.toString()).toLocaleLowerCase(t))),
            in (i, e) {
                if (null == e || 0 === e.length) return !0;
                for (let t = 0; t < e.length; t++)
                    if (p.ObjectUtils.equals(i, e[t])) return !0;
                return !1
            },
            between: (i, p) => null == p || null == p[0] || null == p[1] || null != i && (i.getTime ? p[0].getTime() <= i.getTime() && i.getTime() <= p[1].getTime() : p[0] <= i && i <= p[1]),
            lt: (i, p) => null == p || null != i && (i.getTime && p.getTime ? i.getTime() < p.getTime() : i < p),
            lte: (i, p) => null == p || null != i && (i.getTime && p.getTime ? i.getTime() <= p.getTime() : i <= p),
            gt: (i, p) => null == p || null != i && (i.getTime && p.getTime ? i.getTime() > p.getTime() : i > p),
            gte: (i, p) => null == p || null != i && (i.getTime && p.getTime ? i.getTime() >= p.getTime() : i >= p),
            dateIs: (i, p) => null == p || null != i && i.toDateString() === p.toDateString(),
            dateIsNot: (i, p) => null == p || null != i && i.toDateString() !== p.toDateString(),
            dateBefore: (i, p) => null == p || null != i && i.getTime() < p.getTime(),
            dateAfter: (i, p) => null == p || null != i && i.getTime() > p.getTime()
        },
        register(i, p) {
            this.filters[i] = p
        }
    };
    return i.FilterMatchMode = {
        STARTS_WITH: "startsWith",
        CONTAINS: "contains",
        NOT_CONTAINS: "notContains",
        ENDS_WITH: "endsWith",
        EQUALS: "equals",
        NOT_EQUALS: "notEquals",
        IN: "in",
        LESS_THAN: "lt",
        LESS_THAN_OR_EQUAL_TO: "lte",
        GREATER_THAN: "gt",
        GREATER_THAN_OR_EQUAL_TO: "gte",
        BETWEEN: "between",
        DATE_IS: "dateIs",
        DATE_IS_NOT: "dateIsNot",
        DATE_BEFORE: "dateBefore",
        DATE_AFTER: "dateAfter"
    }, i.FilterOperator = {
        AND: "and",
        OR: "or"
    }, i.FilterService = e, i.PrimeIcons = {
        ALIGN_CENTER: "pi pi-align-center",
        ALIGN_JUSTIFY: "pi pi-align-justify",
        ALIGN_LEFT: "pi pi-align-left",
        ALIGN_RIGHT: "pi pi-align-right",
        AMAZON: "pi pi-amazon",
        ANDROID: "pi pi-android",
        ANGLE_DOUBLE_DOWN: "pi pi-angle-double-down",
        ANGLE_DOUBLE_LEFT: "pi pi-angle-double-left",
        ANGLE_DOUBLE_RIGHT: "pi pi-angle-double-right",
        ANGLE_DOUBLE_UP: "pi pi-angle-double-up",
        ANGLE_DOWN: "pi pi-angle-down",
        ANGLE_LEFT: "pi pi-angle-left",
        ANGLE_RIGHT: "pi pi-angle-right",
        ANGLE_UP: "pi pi-angle-up",
        APPLE: "pi pi-apple",
        ARROW_CIRCLE_DOWN: "pi pi-arrow-circle-down",
        ARROW_CIRCLE_LEFT: "pi pi-arrow-circle-left",
        ARROW_CIRCLE_RIGHT: "pi pi-arrow-circle-right",
        ARROW_CIRCLE_UP: "pi pi-arrow-circle-up",
        ARROW_DOWN: "pi pi-arrow-down",
        ARROW_LEFT: "pi pi-arrow-left",
        ARROW_RIGHT: "pi pi-arrow-right",
        ARROW_UP: "pi pi-arrow-up",
        BACKWARD: "pi pi-backward",
        BAN: "pi pi-ban",
        BARS: "pi pi-bars",
        BELL: "pi pi-bell",
        BOOK: "pi pi-book",
        BOOKMARK: "pi pi-bookmark",
        BRIEFCASE: "pi pi-briefcase",
        CALENDAR_MINUS: "pi pi-calendar-minus",
        CALENDAR_PLUS: "pi pi-calendar-plus",
        CALENDAR_TIMES: "pi pi-calendar-times",
        CALENDAR: "pi pi-calendar",
        CAMERA: "pi pi-camera",
        CARET_DOWN: "pi pi-caret-down",
        CARET_LEFT: "pi pi-caret-left",
        CARET_RIGHT: "pi pi-caret-right",
        CARET_UP: "pi pi-caret-up",
        CHART_BAR: "pi pi-chart-bar",
        CHART_LINE: "pi pi-chart-line",
        CHECK_CIRCLE: "pi pi-check-circle",
        CHECK_SQUARE: "pi pi-check-square",
        CHECK: "pi pi-check",
        CHEVRON_CIRCLE_DOWN: "pi pi-chevron-circle-down",
        CHEVRON_CIRCLE_LEFT: "pi pi-chevron-circle-left",
        CHEVRON_CIRCLE_RIGHT: "pi pi-chevron-circle-right",
        CHEVRON_CIRCLE_UP: "pi pi-chevron-circle-up",
        CHEVRON_DOWN: "pi pi-chevron-down",
        CHEVRON_LEFT: "pi pi-chevron-left",
        CHEVRON_RIGHT: "pi pi-chevron-right",
        CHEVRON_UP: "pi pi-chevron-up",
        CLOCK: "pi pi-clock",
        CLONE: "pi pi-clone",
        CLOUD_DOWNLOAD: "pi pi-cloud-download",
        CLOUD_UPLOAD: "pi pi-cloud-upload",
        CLOUD: "pi pi-cloud",
        COG: "pi pi-cog",
        COMMENT: "pi pi-comment",
        COMMENTS: "pi pi-comments",
        COMPASS: "pi pi-compass",
        COPY: "pi pi-copy",
        CREDIT_CARD: "pi pi-credit-card",
        DESKTOP: "pi pi-desktop",
        DISCORD: "pi pi-discord",
        DIRECTIONS_ALT: "pi pi-directions-alt",
        DIRECTIONS: "pi pi-directions",
        DOLLAR: "pi pi-dollar",
        DOWNLOAD: "pi pi-download",
        EJECT: "pi pi-eject",
        ELLIPSIS_H: "pi pi-ellipsis-h",
        ELLIPSIS_V: "pi pi-ellipsis-v",
        ENVELOPE: "pi pi-envelope",
        EXCLAMATION_CIRCLE: "pi pi-exclamation-circle",
        EXCLAMATION_TRIANGLE: "pi pi-exclamation-triangle ",
        EXTERNAL_LINK: "pi pi-external-link",
        EYE_SLASH: "pi pi-eye-slash",
        EYE: "pi pi-eye",
        FACEBOOK: "pi pi-facebook",
        FAST_BACKWARD: "pi pi-fast-backward",
        FAST_FORWARD: "pi pi-fast-forward",
        FILE_EXCEL: "pi pi-file-excel",
        FILE_O: "pi pi-file-o",
        FILE_PDF: "pi pi-file-pdf",
        FILE: "pi pi-file",
        FILTER: "pi pi-filter",
        FILTER_SLASH: "pi pi-filter-slash",
        FLAG: "pi pi-flag",
        FOLDER_OPEN: "pi pi-folder-open",
        FOLDER: "pi pi-folder",
        FORWARD: "pi pi-forward",
        GITHUB: "pi pi-github",
        GLOBE: "pi pi-globe",
        GOOGLE: "pi pi-google",
        HEART: "pi pi-heart",
        HOME: "pi pi-home",
        ID_CARD: "pi pi-id-card",
        IMAGE: "pi pi-image",
        IMAGES: "pi pi-images",
        INBOX: "pi pi-inbox",
        INFO_CIRCLE: "pi pi-info-circle",
        INFO: "pi pi-info",
        KEY: "pi pi-key",
        LINK: "pi pi-link",
        LIST: "pi pi-list",
        LOCK_OPEN: "pi pi-lock-open",
        LOCK: "pi pi-lock",
        MAP: "pi pi-map",
        MAP_MARKER: "pi pi-map-marker",
        MICROSOFT: "pi pi-microsoft",
        MINUS_CIRCLE: "pi pi-minus-circle",
        MINUS: "pi pi-minus",
        MOBILE: "pi pi-mobile",
        MONEY_BILL: "pi pi-money-bill",
        MOON: "pi pi-moon",
        PALETTE: "pi pi-palette",
        PAPERCLIP: "pi pi-paperclip",
        PAUSE: "pi pi-pause",
        PAYPAL: "pi pi-paypal",
        PENCIL: "pi pi-pencil",
        PERCENTAGE: "pi pi-percentage",
        PHONE: "pi pi-phone",
        PLAY: "pi pi-play",
        PLUS_CIRCLE: "pi pi-plus-circle",
        PLUS: "pi pi-plus",
        POWER_OFF: "pi pi-power-off",
        PRINT: "pi pi-print",
        QUESTION_CIRCLE: "pi pi-question-circle",
        QUESTION: "pi pi-question",
        RADIO_OFF: "pi pi-radio-off",
        RADIO_ON: "pi pi-radio-on",
        REFRESH: "pi pi-refresh",
        REPLAY: "pi pi-replay",
        REPLY: "pi pi-reply",
        SAVE: "pi pi-save",
        SEARCH_MINUS: "pi pi-search-minus",
        SEARCH_PLUS: "pi pi-search-plus",
        SEARCH: "pi pi-search",
        SEND: "pi pi-send",
        SHARE_ALT: "pi pi-share-alt",
        SHIELD: "pi pi-shield",
        SHOPPING_CART: "pi pi-shopping-cart",
        SIGN_IN: "pi pi-sign-in",
        SIGN_OUT: "pi pi-sign-out",
        SITEMAP: "pi pi-sitemap",
        SLACK: "pi pi-slack",
        SLIDERS_H: "pi pi-sliders-h",
        SLIDERS_V: "pi pi-sliders-v",
        SORT_ALPHA_ALT_DOWN: "pi pi-sort-alpha-alt-down",
        SORT_ALPHA_ALT_UP: "pi pi-sort-alpha-alt-up",
        SORT_ALPHA_DOWN: "pi pi-sort-alpha-down",
        SORT_ALPHA_UP: "pi pi-sort-alpha-up",
        SORT_ALT: "pi pi-sort-alt",
        SORT_AMOUNT_DOWN_ALT: "pi pi-sort-amount-down-alt",
        SORT_AMOUNT_DOWN: "pi pi-sort-amount-down",
        SORT_AMOUNT_UP_ALT: "pi pi-sort-amount-up-alt",
        SORT_AMOUNT_UP: "pi pi-sort-amount-up",
        SORT_DOWN: "pi pi-sort-down",
        SORT_NUMERIC_ALT_DOWN: "pi pi-sort-numeric-alt-down",
        SORT_NUMERIC_ALT_UP: "pi pi-sort-numeric-alt-up",
        SORT_NUMERIC_DOWN: "pi pi-sort-numeric-down",
        SORT_NUMERIC_UP: "pi pi-sort-numeric-up",
        SORT_UP: "pi pi-sort-up",
        SORT: "pi pi-sort",
        SPINNER: "pi pi-spinner",
        STAR_O: "pi pi-star-o",
        STAR: "pi pi-star",
        STEP_BACKWARD_ALT: "pi pi-step-backward-alt",
        STEP_BACKWARD: "pi pi-step-backward",
        STEP_FORWARD_ALT: "pi pi-step-forward-alt",
        STEP_FORWARD: "pi pi-step-forward",
        SUN: "pi pi-sun",
        TABLE: "pi pi-table",
        TABLET: "pi pi-tablet",
        TAG: "pi pi-tag",
        TAGS: "pi pi-tags",
        TH_LARGE: "pi pi-th-large",
        THUMBS_DOWN: "pi pi-thumbs-down",
        THUMBS_UP: "pi pi-thumbs-up",
        TICKET: "pi pi-ticket",
        TIMES_CIRCLE: "pi pi-times-circle",
        TIMES: "pi pi-times",
        TRASH: "pi pi-trash",
        TWITTER: "pi pi-twitter",
        UNDO: "pi pi-undo",
        UNLOCK: "pi pi-unlock",
        UPLOAD: "pi pi-upload",
        USER_EDIT: "pi pi-user-edit",
        USER_MINUS: "pi pi-user-minus",
        USER_PLUS: "pi pi-user-plus",
        USER: "pi pi-user",
        USERS: "pi pi-users",
        VIDEO: "pi pi-video",
        VIMEO: "pi pi-vimeo",
        VOLUME_DOWN: "pi pi-volume-down",
        VOLUME_OFF: "pi pi-volume-off",
        VOLUME_UP: "pi pi-volume-up",
        YOUTUBE: "pi pi-youtube",
        WALLET: "pi pi-wallet",
        WIFI: "pi pi-wifi",
        WINDOW_MAXIMIZE: "pi pi-window-maximize",
        WINDOW_MINIMIZE: "pi pi-window-minimize"
    }, i.ToastSeverity = {
        INFO: "info",
        WARN: "warn",
        ERROR: "error",
        SUCCESS: "success"
    }, Object.defineProperty(i, "__esModule", {
        value: !0
    }), i
}({}, primevue.utils);

this.primevue = this.primevue || {}, this.primevue.config = function(e, t, a) {
    "use strict";
    const o = {
            ripple: !1,
            inputStyle: "outlined",
            locale: {
                startsWith: "Starts with",
                contains: "Contains",
                notContains: "Not contains",
                endsWith: "Ends with",
                equals: "Equals",
                notEquals: "Not equals",
                noFilter: "No Filter",
                lt: "Less than",
                lte: "Less than or equal to",
                gt: "Greater than",
                gte: "Greater than or equal to",
                dateIs: "Date is",
                dateIsNot: "Date is not",
                dateBefore: "Date is before",
                dateAfter: "Date is after",
                clear: "Clear",
                apply: "Apply",
                matchAll: "Match All",
                matchAny: "Match Any",
                addRule: "Add Rule",
                removeRule: "Remove Rule",
                accept: "Yes",
                reject: "No",
                choose: "Choose",
                upload: "Upload",
                cancel: "Cancel",
                dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                dayNamesMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                today: "Today",
                weekHeader: "Wk",
                firstDayOfWeek: 0,
                dateFormat: "mm/dd/yy",
                weak: "Weak",
                medium: "Medium",
                strong: "Strong",
                passwordPrompt: "Enter a password",
                emptyFilterMessage: "No results found",
                emptyMessage: "No available options"
            },
            filterMatchModeOptions: {
                text: [a.FilterMatchMode.STARTS_WITH, a.FilterMatchMode.CONTAINS, a.FilterMatchMode.NOT_CONTAINS, a.FilterMatchMode.ENDS_WITH, a.FilterMatchMode.EQUALS, a.FilterMatchMode.NOT_EQUALS],
                numeric: [a.FilterMatchMode.EQUALS, a.FilterMatchMode.NOT_EQUALS, a.FilterMatchMode.LESS_THAN, a.FilterMatchMode.LESS_THAN_OR_EQUAL_TO, a.FilterMatchMode.GREATER_THAN, a.FilterMatchMode.GREATER_THAN_OR_EQUAL_TO],
                date: [a.FilterMatchMode.DATE_IS, a.FilterMatchMode.DATE_IS_NOT, a.FilterMatchMode.DATE_BEFORE, a.FilterMatchMode.DATE_AFTER]
            },
            zIndex: {
                modal: 1100,
                overlay: 1e3,
                menu: 1e3,
                tooltip: 1100
            }
        },
        r = Symbol();
    var i = {
        install: (e, a) => {
            let i = a ? {
                ...o,
                ...a
            } : {
                ...o
            };
            const l = {
                config: t.reactive(i)
            };
            e.config.globalProperties.$primevue = l, e.provide(r, l)
        }
    };
    return e.default = i, e.usePrimeVue = function() {
        const e = t.inject(r);
        if (!e) throw new Error("PrimeVue is not installed!");
        return e
    }, Object.defineProperty(e, "__esModule", {
        value: !0
    }), e
}({}, Vue, primevue.api);

this.primevue = this.primevue || {}, this.primevue.ripple = function(e) {
    "use strict";

    function t(e) {
        let t = r(e);
        t && (! function(e) {
            e.removeEventListener("mousedown", n)
        }(e), t.removeEventListener("animationend", i), t.remove())
    }

    function n(t) {
        let n = t.currentTarget,
            i = r(n);
        if (!i || "none" === getComputedStyle(i, null).display) return;
        if (e.DomHandler.removeClass(i, "p-ink-active"), !e.DomHandler.getHeight(i) && !e.DomHandler.getWidth(i)) {
            let t = Math.max(e.DomHandler.getOuterWidth(n), e.DomHandler.getOuterHeight(n));
            i.style.height = t + "px", i.style.width = t + "px"
        }
        let l = e.DomHandler.getOffset(n),
            o = t.pageX - l.left + document.body.scrollTop - e.DomHandler.getWidth(i) / 2,
            a = t.pageY - l.top + document.body.scrollLeft - e.DomHandler.getHeight(i) / 2;
        i.style.top = a + "px", i.style.left = o + "px", e.DomHandler.addClass(i, "p-ink-active")
    }

    function i(t) {
        e.DomHandler.removeClass(t.currentTarget, "p-ink-active")
    }

    function r(e) {
        for (let t = 0; t < e.children.length; t++)
            if ("string" == typeof e.children[t].className && -1 !== e.children[t].className.indexOf("p-ink")) return e.children[t];
        return null
    }
    return {
        mounted(e, t) {
            t.instance.$primevue && t.instance.$primevue.config && t.instance.$primevue.config.ripple && (function(e) {
                let t = document.createElement("span");
                t.className = "p-ink", e.appendChild(t), t.addEventListener("animationend", i)
            }(e), function(e) {
                e.addEventListener("mousedown", n)
            }(e))
        },
        unmounted(e) {
            t(e)
        }
    }
}(primevue.utils);

this.primevue = this.primevue || {}, this.primevue.virtualscroller = function(t) {
    "use strict";
    var s = {
        name: "VirtualScroller",
        emits: ["update:numToleratedItems", "scroll-index-change", "lazy-load"],
        props: {
            items: {
                type: Array,
                default: null
            },
            itemSize: {
                type: [Number, Array],
                default: null
            },
            scrollHeight: null,
            scrollWidth: null,
            orientation: {
                type: String,
                default: "vertical"
            },
            numToleratedItems: {
                type: Number,
                default: null
            },
            delay: {
                type: Number,
                default: 0
            },
            lazy: {
                type: Boolean,
                default: !1
            },
            showLoader: {
                type: Boolean,
                default: !1
            },
            loading: {
                type: Boolean,
                default: !1
            },
            style: null,
            class: null,
            disabled: {
                type: Boolean,
                default: !1
            }
        },
        data() {
            return {
                first: this.isBoth() ? {
                    rows: 0,
                    cols: 0
                } : 0,
                last: this.isBoth() ? {
                    rows: 0,
                    cols: 0
                } : 0,
                numItemsInViewport: this.isBoth() ? {
                    rows: 0,
                    cols: 0
                } : 0,
                lastScrollPos: this.isBoth() ? {
                    top: 0,
                    left: 0
                } : 0,
                d_numToleratedItems: this.numToleratedItems,
                d_loading: this.loading,
                loaderArr: null
            }
        },
        element: null,
        content: null,
        spacer: null,
        scrollTimeout: null,
        mounted() {
            this.init()
        },
        watch: {
            numToleratedItems(t) {
                this.d_numToleratedItems = t
            },
            loading(t) {
                this.d_loading = t
            },
            items(t, s) {
                s && s.length === (t || []).length || this.init()
            }
        },
        methods: {
            init() {
                this.disabled || (this.setSize(), this.calculateOptions(), this.setSpacerSize())
            },
            getLast(t, s) {
                return this.items ? Math.min(s ? this.items[0].length : this.items.length, t) : 0
            },
            calculateOptions() {
                const t = this.isBoth(),
                    s = this.isHorizontal(),
                    e = this.first,
                    i = this.itemSize,
                    o = this.getContentPadding(),
                    l = this.element ? this.element.offsetWidth - o.left : 0,
                    n = this.element ? this.element.offsetHeight - o.top : 0,
                    r = (t, s) => Math.ceil(t / (s || t)),
                    a = t ? {
                        rows: r(n, i[0]),
                        cols: r(l, i[1])
                    } : r(s ? l : n, i);
                let h = this.d_numToleratedItems || Math.ceil((t ? a.rows : a) / 2);
                const c = (t, s, e) => this.getLast(t + s + (t < h ? 2 : 3) * h, e),
                    d = t ? {
                        rows: c(e.rows, a.rows),
                        cols: c(e.cols, a.cols, !0)
                    } : c(e, a);
                this.d_numToleratedItems = h, this.$emit("update:numToleratedItems", this.d_numToleratedItems), this.last = d, this.numItemsInViewport = a, this.showLoader && (this.$slots && this.$slots.loader ? this.loaderArr = Array.from({
                    length: t ? a.rows : a
                }) : this.loaderArr = Array.from({
                    length: 1
                })), this.lazy && this.$emit("lazy-load", {
                    first: e,
                    last: d
                })
            },
            getContentPadding() {
                if (this.content) {
                    const t = getComputedStyle(this.content),
                        s = parseInt(parseFloat(t.paddingLeft.slice(0, -2)), 10),
                        e = parseInt(parseFloat(t.paddingRight.slice(0, -2)), 10),
                        i = parseInt(parseFloat(t.paddingTop.slice(0, -2)), 10),
                        o = parseInt(parseFloat(t.paddingBottom.slice(0, -2)), 10);
                    return {
                        left: s,
                        right: e,
                        top: i,
                        bottom: o,
                        x: s + e,
                        y: i + o
                    }
                }
                return {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0,
                    x: 0,
                    y: 0
                }
            },
            setSize() {
                if (this.element) {
                    const t = this.isBoth(),
                        s = this.isHorizontal(),
                        e = this.element.parentElement,
                        i = this.scrollWidth || `${this.element.offsetWidth||e.offsetWidth}px`,
                        o = this.scrollHeight || `${this.element.offsetHeight||e.offsetHeight}px`,
                        l = (t, s) => this.element.style[t] = s;
                    t ? (l("height", o), l("width", i)) : s ? l("width", i) : l("height", o)
                }
            },
            setSpacerSize() {
                const t = this.items;
                if (this.spacer && t) {
                    const s = this.isBoth(),
                        e = this.isHorizontal(),
                        i = this.itemSize,
                        o = this.getContentPadding(),
                        l = (t, s, e, i = 0) => this.spacer.style[t] = (s || []).length * e + i + "px";
                    s ? (l("height", t[0], i[0], o.y), l("width", t[1], i[1], o.x)) : e ? l("width", t, i, o.x) : l("height", t, i, o.y)
                }
            },
            setContentPosition(t) {
                if (this.content) {
                    const s = this.isBoth(),
                        e = this.isHorizontal(),
                        i = this.content,
                        o = t ? t.first : this.first,
                        l = this.itemSize,
                        n = (t, s) => t * s,
                        r = (t = 0, s = 0) => i.style.transform = `translate3d(${t}px, ${s}px, 0)`;
                    if (s) r(n(o.cols, l[1]), n(o.rows, l[0]));
                    else {
                        const t = n(o, l);
                        e ? r(t, 0) : r(0, t)
                    }
                }
            },
            onScrollPositionChange(t) {
                const s = t.target,
                    e = this.isBoth(),
                    i = this.isHorizontal(),
                    o = this.itemSize,
                    l = this.getContentPadding(),
                    n = (t, s) => t ? t > s ? t - s : t : 0,
                    r = (t, s) => Math.floor(t / (s || t)),
                    a = (t, s, e, i, o) => t <= this.d_numToleratedItems ? this.d_numToleratedItems : o ? e - i - this.d_numToleratedItems : s + this.d_numToleratedItems - 1,
                    h = (t, s, e, i, o, l) => t <= this.d_numToleratedItems ? 0 : l ? t < s ? e : t - this.d_numToleratedItems : t > s ? e : t - 2 * this.d_numToleratedItems,
                    c = (t, s, e, i, o) => {
                        let l = s + i + 2 * this.d_numToleratedItems;
                        return t >= this.d_numToleratedItems && (l += this.d_numToleratedItems + 1), this.getLast(l, o)
                    },
                    d = n(s.scrollTop, l.top),
                    m = n(s.scrollLeft, l.left);
                let f = 0,
                    p = this.last,
                    u = !1;
                if (e) {
                    const t = this.lastScrollPos.top <= d,
                        s = this.lastScrollPos.left <= m,
                        e = {
                            rows: r(d, o[0]),
                            cols: r(m, o[1])
                        },
                        i = {
                            rows: a(e.rows, this.first.rows, this.last.rows, this.numItemsInViewport.rows, t),
                            cols: a(e.cols, this.first.cols, this.last.cols, this.numItemsInViewport.cols, s)
                        };
                    f = {
                        rows: h(e.rows, i.rows, this.first.rows, this.last.rows, this.numItemsInViewport.rows, t),
                        cols: h(e.cols, i.cols, this.first.cols, this.last.cols, this.numItemsInViewport.cols, s)
                    }, p = {
                        rows: c(e.rows, f.rows, this.last.rows, this.numItemsInViewport.rows),
                        cols: c(e.cols, f.cols, this.last.cols, this.numItemsInViewport.cols, !0)
                    }, u = f.rows !== this.first.rows || f.cols !== this.first.cols || p.rows !== this.last.rows || p.cols !== this.last.cols, this.lastScrollPos = {
                        top: d,
                        left: m
                    }
                } else {
                    const t = i ? m : d,
                        s = this.lastScrollPos <= t,
                        e = r(t, o);
                    f = h(e, a(e, this.first, this.last, this.numItemsInViewport, s), this.first, this.last, this.numItemsInViewport, s), p = c(e, f, this.last, this.numItemsInViewport), u = f !== this.first || p !== this.last, this.lastScrollPos = t
                }
                return {
                    first: f,
                    last: p,
                    isRangeChanged: u
                }
            },
            onScrollChange(t) {
                const {
                    first: s,
                    last: e,
                    isRangeChanged: i
                } = this.onScrollPositionChange(t);
                if (i) {
                    const t = {
                        first: s,
                        last: e
                    };
                    this.setContentPosition(t), this.lazy && this.$emit("lazy-load", {
                        first: s,
                        last: e
                    }), this.first = s, this.last = e, this.$emit("scroll-index-change", {
                        first: s,
                        last: e
                    })
                }
            },
            onScroll(t) {
                if (this.delay && !this.lazy) {
                    if (this.scrollTimeout && clearTimeout(this.scrollTimeout), !this.d_loading && this.showLoader) {
                        const {
                            isRangeChanged: s
                        } = this.onScrollPositionChange(t);
                        s && (this.d_loading = !0)
                    }
                    this.scrollTimeout = setTimeout((() => {
                        this.onScrollChange(t), this.d_loading && this.showLoader && !this.lazy && (this.d_loading = !1)
                    }), this.delay)
                } else this.onScrollChange(t)
            },
            getOptions(t) {
                let s = this.items.length,
                    e = this.isBoth() ? this.first.rows + t : this.first + t;
                return {
                    index: e,
                    count: s,
                    first: 0 === e,
                    last: e === s - 1,
                    even: e % 2 == 0,
                    odd: e % 2 != 0
                }
            },
            getLoaderOptions(t) {
                let s = this.loaderArr.length;
                return {
                    loading: this.d_loading,
                    first: 0 === t,
                    last: t === s - 1,
                    even: t % 2 == 0,
                    odd: t % 2 != 0
                }
            },
            isHorizontal() {
                return "horizontal" === this.orientation
            },
            isBoth() {
                return "both" === this.orientation
            },
            scrollTo(t) {
                this.element && this.element.scrollTo(t)
            },
            scrollToIndex(t, s = "auto") {
                const e = this.isBoth(),
                    i = this.isHorizontal(),
                    o = this.itemSize,
                    l = this.getContentPadding(),
                    n = (t = 0) => t <= this.d_numToleratedItems ? 0 : t,
                    r = (t, s, e) => t * s + e,
                    a = (t = 0, e = 0) => this.scrollTo({
                        left: t,
                        top: e,
                        behavior: s
                    });
                if (e) {
                    const s = {
                        rows: n(t[0]),
                        cols: n(t[1])
                    };
                    s.rows === this.first.rows && s.cols === this.first.cols || a(r(s.cols, o[1], l.left), r(s.rows, o[0], l.top))
                } else {
                    const s = n(t);
                    s !== this.first && (i ? a(r(s, o, l.left), 0) : a(0, r(s, o, l.top))), this.first = s
                }
            },
            scrollInView(t, s, e = "auto") {
                if (s) {
                    const i = this.isBoth(),
                        o = this.isHorizontal(),
                        {
                            first: l,
                            viewport: n
                        } = this.getRenderedRange(),
                        r = this.itemSize,
                        a = (t = 0, s = 0) => this.scrollTo({
                            left: t,
                            top: s,
                            behavior: e
                        }),
                        h = "to-end" === s;
                    if ("to-start" === s) {
                        if (i) n.first.rows - l.rows > t[0] ? a(n.first.cols * r[1], (n.first.rows - 1) * r[0]) : n.first.cols - l.cols > t[1] && a((n.first.cols - 1) * r[1], n.first.rows * r[0]);
                        else if (n.first - l > t) {
                            const t = (n.first - 1) * r;
                            o ? a(t, 0) : a(0, t)
                        }
                    } else if (h)
                        if (i) n.last.rows - l.rows <= t[0] + 1 ? a(n.first.cols * r[1], (n.first.rows + 1) * r[0]) : n.last.cols - l.cols <= t[1] + 1 && a((n.first.cols + 1) * r[1], n.first.rows * r[0]);
                        else if (n.last - l <= t + 1) {
                        const t = (n.first + 1) * r;
                        o ? a(t, 0) : a(0, t)
                    }
                } else this.scrollToIndex(t, e)
            },
            getRenderedRange() {
                const t = this.isBoth(),
                    s = this.isHorizontal(),
                    e = this.itemSize,
                    i = (t, s) => Math.floor(t / (s || t));
                let o = this.first,
                    l = 0;
                if (this.element) {
                    const n = this.element.scrollTop,
                        r = this.element.scrollLeft;
                    if (t) o = {
                        rows: i(n, e[0]),
                        cols: i(r, e[1])
                    }, l = {
                        rows: o.rows + this.numItemsInViewport.rows,
                        cols: o.cols + this.numItemsInViewport.cols
                    };
                    else {
                        o = i(s ? r : n, e), l = o + this.numItemsInViewport
                    }
                }
                return {
                    first: this.first,
                    last: this.last,
                    viewport: {
                        first: o,
                        last: l
                    }
                }
            },
            elementRef(t) {
                this.element = t
            },
            contentRef(t) {
                this.content = t
            },
            spacerRef(t) {
                this.spacer = t
            }
        },
        computed: {
            containerClass() {
                return ["p-virtualscroller", {
                    "p-both-scroll": this.isBoth(),
                    "p-horizontal-scroll": this.isHorizontal()
                }, this.class]
            },
            loaderClass() {
                return ["p-virtualscroller-loader", {
                    "p-component-overlay": !this.$slots.loader
                }]
            },
            loadedItems() {
                const t = this.items;
                if (t && !this.d_loading) {
                    return this.isBoth() ? t.slice(this.first.rows, this.last.rows).map((t => t.slice(this.first.cols, this.last.cols))) : t.slice(this.first, this.last).map((t => t))
                }
                return []
            }
        }
    };
    const e = t.createVNode("i", {
        class: "p-virtualscroller-loading-icon pi pi-spinner pi-spin"
    }, null, -1);
    return function(t, s) {
        void 0 === s && (s = {});
        var e = s.insertAt;
        if (t && "undefined" != typeof document) {
            var i = document.head || document.getElementsByTagName("head")[0],
                o = document.createElement("style");
            o.type = "text/css", "top" === e && i.firstChild ? i.insertBefore(o, i.firstChild) : i.appendChild(o), o.styleSheet ? o.styleSheet.cssText = t : o.appendChild(document.createTextNode(t))
        }
    }("\n.p-virtualscroller {\n    position: relative;\n    overflow: auto;\n    contain: strict;\n    -webkit-transform: translateZ(0);\n            transform: translateZ(0);\n    will-change: scroll-position;\n}\n.p-virtualscroller-content {\n    position: absolute;\n    top: 0;\n    left: 0;\n    contain: content;\n    min-height: 100%;\n    min-width: 100%;\n    will-change: transform;\n}\n.p-virtualscroller-spacer {\n    position: absolute;\n    top: 0;\n    left: 0;\n    height: 1px;\n    width: 1px;\n    -webkit-transform-origin: 0 0;\n            transform-origin: 0 0;\n    pointer-events: none;\n}\n.p-virtualscroller .p-virtualscroller-loader {\n    position: sticky;\n    top: 0;\n    left: 0;\n    width: 100%;\n    height: 100%;\n}\n.p-virtualscroller-loader.p-component-overlay {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n}\n"), s.render = function(s, i, o, l, n, r) {
        return o.disabled ? (t.openBlock(), t.createBlock(t.Fragment, {
            key: 1
        }, [t.renderSlot(s.$slots, "default"), t.renderSlot(s.$slots, "content", {
            items: o.items
        })], 64)) : (t.openBlock(), t.createBlock("div", {
            key: 0,
            ref: r.elementRef,
            class: r.containerClass,
            style: o.style,
            onScroll: i[1] || (i[1] = (...t) => r.onScroll && r.onScroll(...t))
        }, [t.renderSlot(s.$slots, "content", {
            styleClass: "p-virtualscroller-content",
            contentRef: r.contentRef,
            items: r.loadedItems,
            getItemOptions: r.getOptions
        }, (() => [t.createVNode("div", {
            ref: r.contentRef,
            class: "p-virtualscroller-content"
        }, [(t.openBlock(!0), t.createBlock(t.Fragment, null, t.renderList(r.loadedItems, ((e, i) => t.renderSlot(s.$slots, "item", {
            key: i,
            item: e,
            options: r.getOptions(i)
        }))), 128))], 512)])), t.createVNode("div", {
            ref: r.spacerRef,
            class: "p-virtualscroller-spacer"
        }, null, 512), n.d_loading ? (t.openBlock(), t.createBlock("div", {
            key: 0,
            class: r.loaderClass
        }, [(t.openBlock(!0), t.createBlock(t.Fragment, null, t.renderList(n.loaderArr, ((i, o) => t.renderSlot(s.$slots, "loader", {
            key: o,
            options: r.getLoaderOptions(o)
        }, (() => [e])))), 128))], 2)) : t.createCommentVNode("", !0)], 38))
    }, s
}(Vue);

this.primevue = this.primevue || {}, this.primevue.confirmationeventbus = function(e) {
    "use strict";
    return primevue.utils.EventBus()
}();

this.primevue = this.primevue || {}, this.primevue.toasteventbus = function(e) {
    "use strict";
    return primevue.utils.EventBus()
}();

this.primevue = this.primevue || {}, this.primevue.overlayeventbus = function(e) {
    "use strict";
    return primevue.utils.EventBus()
}();

this.primevue = this.primevue || {}, this.primevue.terminalservice = function(e) {
    "use strict";
    return primevue.utils.EventBus()
}();

this.primevue = this.primevue || {}, this.primevue.useconfirm = function(e, r) {
    "use strict";
    const i = Symbol();
    return e.PrimeVueConfirmSymbol = i, e.useConfirm = function() {
        const e = r.inject(i);
        if (!e) throw new Error("No PrimeVue Confirmation provided!");
        return e
    }, Object.defineProperty(e, "__esModule", {
        value: !0
    }), e
}({}, Vue);

this.primevue = this.primevue || {}, this.primevue.usetoast = function(e, t) {
    "use strict";
    const r = Symbol();
    return e.PrimeVueToastSymbol = r, e.useToast = function() {
        const e = t.inject(r);
        if (!e) throw new Error("No PrimeVue Toast provided!");
        return e
    }, Object.defineProperty(e, "__esModule", {
        value: !0
    }), e
}({}, Vue);

this.primevue = this.primevue || {}, this.primevue.button = function(t, e) {
    "use strict";

    function o(t) {
        return t && "object" == typeof t && "default" in t ? t : {
            default: t
        }
    }
    var i = {
        name: "Button",
        props: {
            label: {
                type: String
            },
            icon: {
                type: String
            },
            iconPos: {
                type: String,
                default: "left"
            },
            badge: {
                type: String
            },
            badgeClass: {
                type: String,
                default: null
            },
            loading: {
                type: Boolean,
                default: !1
            },
            loadingIcon: {
                type: String,
                default: "pi pi-spinner pi-spin"
            }
        },
        computed: {
            buttonClass() {
                return {
                    "p-button p-component": !0,
                    "p-button-icon-only": this.icon && !this.label,
                    "p-button-vertical": ("top" === this.iconPos || "bottom" === this.iconPos) && this.label,
                    "p-disabled": this.$attrs.disabled || this.loading,
                    "p-button-loading": this.loading,
                    "p-button-loading-label-only": this.loading && !this.icon && this.label
                }
            },
            iconClass() {
                return [this.loading ? "p-button-loading-icon " + this.loadingIcon : this.icon, "p-button-icon", {
                    "p-button-icon-left": "left" === this.iconPos && this.label,
                    "p-button-icon-right": "right" === this.iconPos && this.label,
                    "p-button-icon-top": "top" === this.iconPos && this.label,
                    "p-button-icon-bottom": "bottom" === this.iconPos && this.label
                }]
            },
            badgeStyleClass() {
                return ["p-badge p-component", this.badgeClass, {
                    "p-badge-no-gutter": this.badge && 1 === String(this.badge).length
                }]
            },
            disabled() {
                return this.$attrs.disabled || this.loading
            }
        },
        directives: {
            ripple: o(t).default
        }
    };
    const n = {
        class: "p-button-label"
    };
    return i.render = function(t, o, i, l, s, a) {
        const c = e.resolveDirective("ripple");
        return e.withDirectives((e.openBlock(), e.createBlock("button", {
            class: a.buttonClass,
            type: "button",
            disabled: a.disabled
        }, [e.renderSlot(t.$slots, "default", {}, (() => [i.loading && !i.icon ? (e.openBlock(), e.createBlock("span", {
            key: 0,
            class: a.iconClass
        }, null, 2)) : e.createCommentVNode("", !0), i.icon ? (e.openBlock(), e.createBlock("span", {
            key: 1,
            class: a.iconClass
        }, null, 2)) : e.createCommentVNode("", !0), e.createVNode("span", n, e.toDisplayString(i.label || " "), 1), i.badge ? (e.openBlock(), e.createBlock("span", {
            key: 2,
            class: a.badgeStyleClass
        }, e.toDisplayString(i.badge), 3)) : e.createCommentVNode("", !0)]))], 10, ["disabled"])), [
            [c]
        ])
    }, i
}(primevue.ripple, Vue);

this.primevue = this.primevue || {}, this.primevue.inputtext = function(e) {
    "use strict";
    var t = {
        name: "InputText",
        emits: ["update:modelValue"],
        props: {
            modelValue: null
        },
        methods: {
            onInput(e) {
                this.$emit("update:modelValue", e.target.value)
            }
        },
        computed: {
            filled() {
                return null != this.modelValue && this.modelValue.toString().length > 0
            }
        }
    };
    return t.render = function(t, u, l, n, i, o) {
        return e.openBlock(), e.createBlock("input", {
            class: ["p-inputtext p-component", {
                "p-filled": o.filled
            }],
            value: l.modelValue,
            onInput: u[1] || (u[1] = (...e) => o.onInput && o.onInput(...e))
        }, null, 42, ["value"])
    }, t
}(Vue);

this.primevue = this.primevue || {}, this.primevue.inputnumber = function(e, t, n) {
    "use strict";

    function i(e) {
        return e && "object" == typeof e && "default" in e ? e : {
            default: e
        }
    }
    var s = i(e),
        r = i(t),
        u = {
            name: "InputNumber",
            inheritAttrs: !1,
            emits: ["update:modelValue", "input"],
            props: {
                modelValue: {
                    type: Number,
                    default: null
                },
                format: {
                    type: Boolean,
                    default: !0
                },
                showButtons: {
                    type: Boolean,
                    default: !1
                },
                buttonLayout: {
                    type: String,
                    default: "stacked"
                },
                incrementButtonClass: {
                    type: String,
                    default: null
                },
                decrementButtonClass: {
                    type: String,
                    default: null
                },
                incrementButtonIcon: {
                    type: String,
                    default: "pi pi-angle-up"
                },
                decrementButtonIcon: {
                    type: String,
                    default: "pi pi-angle-down"
                },
                locale: {
                    type: String,
                    default: void 0
                },
                localeMatcher: {
                    type: String,
                    default: void 0
                },
                mode: {
                    type: String,
                    default: "decimal"
                },
                prefix: {
                    type: String,
                    default: null
                },
                suffix: {
                    type: String,
                    default: null
                },
                currency: {
                    type: String,
                    default: void 0
                },
                currencyDisplay: {
                    type: String,
                    default: void 0
                },
                useGrouping: {
                    type: Boolean,
                    default: !0
                },
                minFractionDigits: {
                    type: Number,
                    default: void 0
                },
                maxFractionDigits: {
                    type: Number,
                    default: void 0
                },
                min: {
                    type: Number,
                    default: null
                },
                max: {
                    type: Number,
                    default: null
                },
                step: {
                    type: Number,
                    default: 1
                },
                allowEmpty: {
                    type: Boolean,
                    default: !0
                },
                style: null,
                class: null,
                inputStyle: null,
                inputClass: null
            },
            numberFormat: null,
            _numeral: null,
            _decimal: null,
            _group: null,
            _minusSign: null,
            _currency: null,
            _suffix: null,
            _prefix: null,
            _index: null,
            groupChar: "",
            isSpecialChar: null,
            prefixChar: null,
            suffixChar: null,
            timer: null,
            data: () => ({
                focused: !1
            }),
            watch: {
                locale(e, t) {
                    this.updateConstructParser(e, t)
                },
                localeMatcher(e, t) {
                    this.updateConstructParser(e, t)
                },
                mode(e, t) {
                    this.updateConstructParser(e, t)
                },
                currency(e, t) {
                    this.updateConstructParser(e, t)
                },
                currencyDisplay(e, t) {
                    this.updateConstructParser(e, t)
                },
                useGrouping(e, t) {
                    this.updateConstructParser(e, t)
                },
                minFractionDigits(e, t) {
                    this.updateConstructParser(e, t)
                },
                maxFractionDigits(e, t) {
                    this.updateConstructParser(e, t)
                },
                suffix(e, t) {
                    this.updateConstructParser(e, t)
                },
                prefix(e, t) {
                    this.updateConstructParser(e, t)
                }
            },
            created() {
                this.constructParser();
            },
            methods: {
                getOptions() {
                    const options = {
                        localeMatcher: this.localeMatcher,
                        style: this.mode,
                        currency: this.currency,
                        currencyDisplay: this.currencyDisplay,
                        useGrouping: this.useGrouping,
                        minimumFractionDigits: this.minFractionDigits,
                        maximumFractionDigits: this.maxFractionDigits
                    };
                    return options;
                },
                constructParser() {
                    this.numberFormat = new Intl.NumberFormat(this.locale, this.getOptions());
                    const e = [...new Intl.NumberFormat(this.locale, {
                            useGrouping: !1
                        }).format(9876543210)].reverse(),
                        t = new Map(e.map(((e, t) => [e, t])));
                    this._numeral = new RegExp(`[${e.join("")}]`, "g"), this._group = this.getGroupingExpression(), this._minusSign = this.getMinusSignExpression(), this._currency = this.getCurrencyExpression(), this._decimal = this.getDecimalExpression(), this._suffix = this.getSuffixExpression(), this._prefix = this.getPrefixExpression(), this._index = e => t.get(e)
                },
                updateConstructParser(e, t) {
                    e !== t && this.constructParser()
                },
                escapeRegExp: e => e.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&"),
                getDecimalExpression() {
                    const e = new Intl.NumberFormat(this.locale, {
                        ...this.getOptions(),
                        useGrouping: !1
                    });
                    return new RegExp(`[${e.format(1.1).replace(this._currency,"").trim().replace(this._numeral,"")}]`, "g")
                },
                getGroupingExpression() {
                    const e = new Intl.NumberFormat(this.locale, {
                        useGrouping: !0
                    });
                    return this.groupChar = e.format(1e6).trim().replace(this._numeral, "").charAt(0), new RegExp(`[${this.groupChar}]`, "g")
                },
                getMinusSignExpression() {
                    const e = new Intl.NumberFormat(this.locale, {
                        useGrouping: !1
                    });
                    return new RegExp(`[${e.format(-1).trim().replace(this._numeral,"")}]`, "g")
                },
                getCurrencyExpression() {
                    if (this.currency) {
                        console.log('this', this);
                        console.log('getOptions', this.getOptions());
                        const e = new Intl.NumberFormat(this.locale, {
                            style: "currency",
                            currency: this.currency,
                            currencyDisplay: this.currencyDisplay,
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                        return new RegExp(`[${e.format(1).replace(/\s/g,"").replace(this._numeral,"").replace(this._group,"")}]`, "g")
                    }
                    return new RegExp("[]", "g")
                },
                getPrefixExpression() {
                    if (this.prefix) this.prefixChar = this.prefix;
                    else {
                        const e = new Intl.NumberFormat(this.locale, {
                            style: this.mode,
                            currency: this.currency,
                            currencyDisplay: this.currencyDisplay
                        });
                        this.prefixChar = e.format(1).split("1")[0]
                    }
                    return new RegExp(`${this.escapeRegExp(this.prefixChar||"")}`, "g")
                },
                getSuffixExpression() {
                    if (this.suffix) this.suffixChar = this.suffix;
                    else {
                        const e = new Intl.NumberFormat(this.locale, {
                            style: this.mode,
                            currency: this.currency,
                            currencyDisplay: this.currencyDisplay,
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                        this.suffixChar = e.format(1).split("1")[1]
                    }
                    return new RegExp(`${this.escapeRegExp(this.suffixChar||"")}`, "g")
                },
                formatValue(e) {
                    if (null != e) {
                        if ("-" === e) return e;
                        if (this.format) {
                            console.log('formatValue e', e);
                            console.log('formatValue', this.getOptions());
                            let t = new Intl.NumberFormat(this.locale, this.getOptions()).format(e);
                            return this.prefix && (t = this.prefix + t), this.suffix && (t += this.suffix), t
                        }
                        return e.toString()
                    }
                    return ""
                },
                parseValue(e) {
                    let t = e.replace(this._suffix, "").replace(this._prefix, "").trim().replace(/\s/g, "").replace(this._currency, "").replace(this._group, "").replace(this._minusSign, "-").replace(this._decimal, ".").replace(this._numeral, this._index);
                    if (t) {
                        if ("-" === t) return t;
                        let e = +t;
                        return isNaN(e) ? null : e
                    }
                    return null
                },
                repeat(e, t, n) {
                    let i = t || 500;
                    this.clearTimer(), this.timer = setTimeout((() => {
                        this.repeat(e, 40, n)
                    }), i), this.spin(e, n)
                },
                spin(e, t) {
                    if (this.$refs.input) {
                        let n = this.step * t,
                            i = this.parseValue(this.$refs.input.$el.value) || 0,
                            s = this.validateValue(i + n);
                        this.updateInput(s, null, "spin"), this.updateModel(e, s), this.handleOnInput(e, i, s)
                    }
                },
                onUpButtonMouseDown(e) {
                    this.$attrs.disabled || (this.$refs.input.$el.focus(), this.repeat(e, null, 1), e.preventDefault())
                },
                onUpButtonMouseUp() {
                    this.$attrs.disabled || this.clearTimer()
                },
                onUpButtonMouseLeave() {
                    this.$attrs.disabled || this.clearTimer()
                },
                onUpButtonKeyUp() {
                    this.$attrs.disabled || this.clearTimer()
                },
                onUpButtonKeyDown(e) {
                    32 !== e.keyCode && 13 !== e.keyCode || this.repeat(e, null, 1)
                },
                onDownButtonMouseDown(e) {
                    this.$attrs.disabled || (this.$refs.input.$el.focus(), this.repeat(e, null, -1), e.preventDefault())
                },
                onDownButtonMouseUp() {
                    this.$attrs.disabled || this.clearTimer()
                },
                onDownButtonMouseLeave() {
                    this.$attrs.disabled || this.clearTimer()
                },
                onDownButtonKeyUp() {
                    this.$attrs.disabled || this.clearTimer()
                },
                onDownButtonKeyDown(e) {
                    32 !== e.keyCode && 13 !== e.keyCode || this.repeat(e, null, -1)
                },
                onUserInput() {
                    this.isSpecialChar && (this.$refs.input.$el.value = this.lastValue), this.isSpecialChar = !1
                },
                onInputKeyDown(e) {
                    if (this.lastValue = e.target.value, e.shiftKey || e.altKey) return void(this.isSpecialChar = !0);
                    let t = e.target.selectionStart,
                        n = e.target.selectionEnd,
                        i = e.target.value,
                        s = null;
                    switch (e.altKey && e.preventDefault(), e.which) {
                        case 38:
                            this.spin(e, 1), e.preventDefault();
                            break;
                        case 40:
                            this.spin(e, -1), e.preventDefault();
                            break;
                        case 37:
                            this.isNumeralChar(i.charAt(t - 1)) || e.preventDefault();
                            break;
                        case 39:
                            this.isNumeralChar(i.charAt(t)) || e.preventDefault();
                            break;
                        case 13:
                            s = this.validateValue(this.parseValue(i)), this.$refs.input.$el.value = this.formatValue(s), this.$refs.input.$el.setAttribute("aria-valuenow", s), this.updateModel(e, s);
                            break;
                        case 8:
                            if (e.preventDefault(), t === n) {
                                const n = i.charAt(t - 1),
                                    {
                                        decimalCharIndex: r,
                                        decimalCharIndexWithoutPrefix: u
                                    } = this.getDecimalCharIndexes(i);
                                if (this.isNumeralChar(n)) {
                                    const e = this.getDecimalLength(i);
                                    if (this._group.test(n)) this._group.lastIndex = 0, s = i.slice(0, t - 2) + i.slice(t - 1);
                                    else if (this._decimal.test(n)) this._decimal.lastIndex = 0, e ? this.$refs.input.$el.setSelectionRange(t - 1, t - 1) : s = i.slice(0, t - 1) + i.slice(t);
                                    else if (r > 0 && t > r) {
                                        const n = this.isDecimalMode() && (this.minFractionDigits || 0) < e ? "" : "0";
                                        s = i.slice(0, t - 1) + n + i.slice(t)
                                    } else 1 === u ? (s = i.slice(0, t - 1) + "0" + i.slice(t), s = this.parseValue(s) > 0 ? s : "") : s = i.slice(0, t - 1) + i.slice(t)
                                }
                                this.updateValue(e, s, null, "delete-single")
                            } else s = this.deleteRange(i, t, n), this.updateValue(e, s, null, "delete-range");
                            break;
                        case 46:
                            if (e.preventDefault(), t === n) {
                                const n = i.charAt(t),
                                    {
                                        decimalCharIndex: r,
                                        decimalCharIndexWithoutPrefix: u
                                    } = this.getDecimalCharIndexes(i);
                                if (this.isNumeralChar(n)) {
                                    const e = this.getDecimalLength(i);
                                    if (this._group.test(n)) this._group.lastIndex = 0, s = i.slice(0, t) + i.slice(t + 2);
                                    else if (this._decimal.test(n)) this._decimal.lastIndex = 0, e ? this.$refs.input.$el.setSelectionRange(t + 1, t + 1) : s = i.slice(0, t) + i.slice(t + 1);
                                    else if (r > 0 && t > r) {
                                        const n = this.isDecimalMode() && (this.minFractionDigits || 0) < e ? "" : "0";
                                        s = i.slice(0, t) + n + i.slice(t + 1)
                                    } else 1 === u ? (s = i.slice(0, t) + "0" + i.slice(t + 1), s = this.parseValue(s) > 0 ? s : "") : s = i.slice(0, t) + i.slice(t + 1)
                                }
                                this.updateValue(e, s, null, "delete-back-single")
                            } else s = this.deleteRange(i, t, n), this.updateValue(e, s, null, "delete-range")
                    }
                },
                onInputKeyPress(e) {
                    e.preventDefault();
                    let t = e.which || e.keyCode,
                        n = String.fromCharCode(t);
                    const i = this.isDecimalSign(n),
                        s = this.isMinusSign(n);
                    (48 <= t && t <= 57 || s || i) && this.insert(e, n, {
                        isDecimalSign: i,
                        isMinusSign: s
                    })
                },
                onPaste(e) {
                    e.preventDefault();
                    let t = (e.clipboardData || window.clipboardData).getData("Text");
                    if (t) {
                        let n = this.parseValue(t);
                        null != n && this.insert(e, n.toString())
                    }
                },
                allowMinusSign() {
                    return null === this.min || this.min < 0
                },
                isMinusSign(e) {
                    return !(!this._minusSign.test(e) && "-" !== e) && (this._minusSign.lastIndex = 0, !0)
                },
                isDecimalSign(e) {
                    return !!this._decimal.test(e) && (this._decimal.lastIndex = 0, !0)
                },
                isDecimalMode() {
                    return "decimal" === this.mode
                },
                getDecimalCharIndexes(e) {
                    let t = e.search(this._decimal);
                    this._decimal.lastIndex = 0;
                    const n = e.replace(this._prefix, "").trim().replace(/\s/g, "").replace(this._currency, "").search(this._decimal);
                    return this._decimal.lastIndex = 0, {
                        decimalCharIndex: t,
                        decimalCharIndexWithoutPrefix: n
                    }
                },
                getCharIndexes(e) {
                    const t = e.search(this._decimal);
                    this._decimal.lastIndex = 0;
                    const n = e.search(this._minusSign);
                    this._minusSign.lastIndex = 0;
                    const i = e.search(this._suffix);
                    this._suffix.lastIndex = 0;
                    const s = e.search(this._currency);
                    return this._currency.lastIndex = 0, {
                        decimalCharIndex: t,
                        minusCharIndex: n,
                        suffixCharIndex: i,
                        currencyCharIndex: s
                    }
                },
                insert(e, t, n = {
                    isDecimalSign: !1,
                    isMinusSign: !1
                }) {
                    const i = t.search(this._minusSign);
                    if (this._minusSign.lastIndex = 0, !this.allowMinusSign() && -1 !== i) return;
                    const s = this.$refs.input.$el.selectionStart,
                        r = this.$refs.input.$el.selectionEnd;
                    let u = this.$refs.input.$el.value.trim();
                    const {
                        decimalCharIndex: l,
                        minusCharIndex: a,
                        suffixCharIndex: o,
                        currencyCharIndex: p
                    } = this.getCharIndexes(u);
                    let c;
                    if (n.isMinusSign) 0 === s && (c = u, -1 !== a && 0 === r || (c = this.insertText(u, t, 0, r)), this.updateValue(e, c, t, "insert"));
                    else if (n.isDecimalSign) l > 0 && s === l ? this.updateValue(e, u, t, "insert") : (l > s && l < r || -1 === l && this.maxFractionDigits) && (c = this.insertText(u, t, s, r), this.updateValue(e, c, t, "insert"));
                    else {
                        const n = this.numberFormat.resolvedOptions().maximumFractionDigits,
                            i = s !== r ? "range-insert" : "insert";
                        if (l > 0 && s > l) {
                            if (s + t.length - (l + 1) <= n) {
                                const n = p >= s ? p - 1 : o >= s ? o : u.length;
                                c = u.slice(0, s) + t + u.slice(s + t.length, n) + u.slice(n), this.updateValue(e, c, t, i)
                            }
                        } else c = this.insertText(u, t, s, r), this.updateValue(e, c, t, i)
                    }
                },
                insertText(e, t, n, i) {
                    if (2 === ("." === t ? t : t.split(".")).length) {
                        const s = e.slice(n, i).search(this._decimal);
                        return this._decimal.lastIndex = 0, s > 0 ? e.slice(0, n) + this.formatValue(t) + e.slice(i) : e || this.formatValue(t)
                    }
                    return i - n === e.length ? this.formatValue(t) : 0 === n ? t + e.slice(i) : i === e.length ? e.slice(0, n) + t : e.slice(0, n) + t + e.slice(i)
                },
                deleteRange(e, t, n) {
                    let i;
                    return i = n - t === e.length ? "" : 0 === t ? e.slice(n) : n === e.length ? e.slice(0, t) : e.slice(0, t) + e.slice(n), i
                },
                initCursor() {
                    let e = this.$refs.input.$el.selectionStart,
                        t = this.$refs.input.$el.value,
                        n = t.length,
                        i = null,
                        s = (this.prefixChar || "").length;
                    t = t.replace(this._prefix, ""), e -= s;
                    let r = t.charAt(e);
                    if (this.isNumeralChar(r)) return e + s;
                    let u = e - 1;
                    for (; u >= 0;) {
                        if (r = t.charAt(u), this.isNumeralChar(r)) {
                            i = u + s;
                            break
                        }
                        u--
                    }
                    if (null !== i) this.$refs.input.$el.setSelectionRange(i + 1, i + 1);
                    else {
                        for (u = e; u < n;) {
                            if (r = t.charAt(u), this.isNumeralChar(r)) {
                                i = u + s;
                                break
                            }
                            u++
                        }
                        null !== i && this.$refs.input.$el.setSelectionRange(i, i)
                    }
                    return i || 0
                },
                onInputClick() {
                    this.initCursor()
                },
                isNumeralChar(e) {
                    return !(1 !== e.length || !(this._numeral.test(e) || this._decimal.test(e) || this._group.test(e) || this._minusSign.test(e))) && (this.resetRegex(), !0)
                },
                resetRegex() {
                    this._numeral.lastIndex = 0, this._decimal.lastIndex = 0, this._group.lastIndex = 0, this._minusSign.lastIndex = 0
                },
                updateValue(e, t, n, i) {
                    let s = this.$refs.input.$el.value,
                        r = null;
                    null != t && (r = this.parseValue(t), r = r || this.allowEmpty ? r : 0, this.updateInput(r, n, i, t), this.handleOnInput(e, s, r))
                },
                handleOnInput(e, t, n) {
                    this.isValueChanged(t, n) && this.$emit("input", {
                        originalEvent: e,
                        value: n
                    })
                },
                isValueChanged(e, t) {
                    if (null === t && null !== e) return !0;
                    if (null != t) {
                        return t !== ("string" == typeof e ? this.parseValue(e) : e)
                    }
                    return !1
                },
                validateValue(e) {
                    return "-" === e || null == e ? null : null != this.min && e < this.min ? this.min : null != this.max && e > this.max ? this.max : e
                },
                updateInput(e, t, n, i) {
                    t = t || "";
                    let s = this.$refs.input.$el.value,
                        r = this.formatValue(e),
                        u = s.length;
                    if (r !== i && (r = this.concatValues(r, i)), 0 === u) {
                        this.$refs.input.$el.value = r, this.$refs.input.$el.setSelectionRange(0, 0);
                        const e = this.initCursor() + t.length;
                        this.$refs.input.$el.setSelectionRange(e, e)
                    } else {
                        let e = this.$refs.input.$el.selectionStart,
                            i = this.$refs.input.$el.selectionEnd;
                        this.$refs.input.$el.value = r;
                        let l = r.length;
                        if ("range-insert" === n) {
                            const n = this.parseValue((s || "").slice(0, e)),
                                u = (null !== n ? n.toString() : "").split("").join(`(${this.groupChar})?`),
                                l = new RegExp(u, "g");
                            l.test(r);
                            const a = t.split("").join(`(${this.groupChar})?`),
                                o = new RegExp(a, "g");
                            o.test(r.slice(l.lastIndex)), i = l.lastIndex + o.lastIndex, this.$refs.input.$el.setSelectionRange(i, i)
                        } else if (l === u) "insert" === n || "delete-back-single" === n ? this.$refs.input.$el.setSelectionRange(i + 1, i + 1) : "delete-single" === n ? this.$refs.input.$el.setSelectionRange(i - 1, i - 1) : "delete-range" !== n && "spin" !== n || this.$refs.input.$el.setSelectionRange(i, i);
                        else if ("delete-back-single" === n) {
                            let e = s.charAt(i - 1),
                                t = s.charAt(i),
                                n = u - l,
                                r = this._group.test(t);
                            r && 1 === n ? i += 1 : !r && this.isNumeralChar(e) && (i += -1 * n + 1), this._group.lastIndex = 0, this.$refs.input.$el.setSelectionRange(i, i)
                        } else if ("-" === s && "insert" === n) {
                            this.$refs.input.$el.setSelectionRange(0, 0);
                            const e = this.initCursor() + t.length + 1;
                            this.$refs.input.$el.setSelectionRange(e, e)
                        } else i += l - u, this.$refs.input.$el.setSelectionRange(i, i)
                    }
                    this.$refs.input.$el.setAttribute("aria-valuenow", e)
                },
                concatValues(e, t) {
                    if (e && t) {
                        let n = t.search(this._decimal);
                        return this._decimal.lastIndex = 0, -1 !== n ? e.split(this._decimal)[0] + t.slice(n) : e
                    }
                    return e
                },
                getDecimalLength(e) {
                    if (e) {
                        const t = e.split(this._decimal);
                        if (2 === t.length) return t[1].replace(this._suffix, "").trim().replace(/\s/g, "").replace(this._currency, "").length
                    }
                    return 0
                },
                updateModel(e, t) {
                    this.$emit("update:modelValue", t)
                },
                onInputFocus() {
                    this.focused = !0
                },
                onInputBlur(e) {
                    this.focused = !1;
                    let t = e.target,
                        n = this.validateValue(this.parseValue(t.value));
                    t.value = this.formatValue(n), t.setAttribute("aria-valuenow", n), this.updateModel(e, n)
                },
                clearTimer() {
                    this.timer && clearInterval(this.timer)
                }
            },
            computed: {
                containerClass() {
                    return ["p-inputnumber p-component p-inputwrapper", this.class, {
                        "p-inputwrapper-filled": this.filled,
                        "p-inputwrapper-focus": this.focused,
                        "p-inputnumber-buttons-stacked": this.showButtons && "stacked" === this.buttonLayout,
                        "p-inputnumber-buttons-horizontal": this.showButtons && "horizontal" === this.buttonLayout,
                        "p-inputnumber-buttons-vertical": this.showButtons && "vertical" === this.buttonLayout
                    }]
                },
                upButtonClass() {
                    return ["p-inputnumber-button p-inputnumber-button-up", this.incrementButtonClass]
                },
                downButtonClass() {
                    return ["p-inputnumber-button p-inputnumber-button-down", this.decrementButtonClass]
                },
                filled() {
                    return null != this.modelValue && this.modelValue.toString().length > 0
                },
                upButtonListeners() {
                    return {
                        mousedown: e => this.onUpButtonMouseDown(e),
                        mouseup: e => this.onUpButtonMouseUp(e),
                        mouseleave: e => this.onUpButtonMouseLeave(e),
                        keydown: e => this.onUpButtonKeyDown(e),
                        keyup: e => this.onUpButtonKeyUp(e)
                    }
                },
                downButtonListeners() {
                    return {
                        mousedown: e => this.onDownButtonMouseDown(e),
                        mouseup: e => this.onDownButtonMouseUp(e),
                        mouseleave: e => this.onDownButtonMouseLeave(e),
                        keydown: e => this.onDownButtonKeyDown(e),
                        keyup: e => this.onDownButtonKeyUp(e)
                    }
                },
                formattedValue() {
                    const e = this.modelValue || this.allowEmpty ? this.modelValue : 0;
                    return this.formatValue(e)
                },
                getFormatter() {
                    return this.numberFormat
                }
            },
            components: {
                INInputText: s.default,
                INButton: r.default
            }
        };
    const l = {
        key: 0,
        class: "p-inputnumber-button-group"
    };
    return function(e, t) {
        void 0 === t && (t = {});
        var n = t.insertAt;
        if (e && "undefined" != typeof document) {
            var i = document.head || document.getElementsByTagName("head")[0],
                s = document.createElement("style");
            s.type = "text/css", "top" === n && i.firstChild ? i.insertBefore(s, i.firstChild) : i.appendChild(s), s.styleSheet ? s.styleSheet.cssText = e : s.appendChild(document.createTextNode(e))
        }
    }("\n.p-inputnumber {\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n}\n.p-inputnumber-button {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    -webkit-box-flex: 0;\n        -ms-flex: 0 0 auto;\n            flex: 0 0 auto;\n}\n.p-inputnumber-buttons-stacked .p-button.p-inputnumber-button .p-button-label,\n.p-inputnumber-buttons-horizontal .p-button.p-inputnumber-button .p-button-label {\n    display: none;\n}\n.p-inputnumber-buttons-stacked .p-button.p-inputnumber-button-up {\n    border-top-left-radius: 0;\n    border-bottom-left-radius: 0;\n    border-bottom-right-radius: 0;\n    padding: 0;\n}\n.p-inputnumber-buttons-stacked .p-inputnumber-input {\n    border-top-right-radius: 0;\n    border-bottom-right-radius: 0;\n}\n.p-inputnumber-buttons-stacked .p-button.p-inputnumber-button-down {\n    border-top-left-radius: 0;\n    border-top-right-radius: 0;\n    border-bottom-left-radius: 0;\n    padding: 0;\n}\n.p-inputnumber-buttons-stacked .p-inputnumber-button-group {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.p-inputnumber-buttons-stacked .p-inputnumber-button-group .p-button.p-inputnumber-button {\n    -webkit-box-flex: 1;\n        -ms-flex: 1 1 auto;\n            flex: 1 1 auto;\n}\n.p-inputnumber-buttons-horizontal .p-button.p-inputnumber-button-up {\n    -webkit-box-ordinal-group: 4;\n        -ms-flex-order: 3;\n            order: 3;\n    border-top-left-radius: 0;\n    border-bottom-left-radius: 0;\n}\n.p-inputnumber-buttons-horizontal .p-inputnumber-input {\n    -webkit-box-ordinal-group: 3;\n        -ms-flex-order: 2;\n            order: 2;\n    border-radius: 0;\n}\n.p-inputnumber-buttons-horizontal .p-button.p-inputnumber-button-down {\n    -webkit-box-ordinal-group: 2;\n        -ms-flex-order: 1;\n            order: 1;\n    border-top-right-radius: 0;\n    border-bottom-right-radius: 0;\n}\n.p-inputnumber-buttons-vertical {\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.p-inputnumber-buttons-vertical .p-button.p-inputnumber-button-up {\n    -webkit-box-ordinal-group: 2;\n        -ms-flex-order: 1;\n            order: 1;\n    border-bottom-left-radius: 0;\n    border-bottom-right-radius: 0;\n    width: 100%;\n}\n.p-inputnumber-buttons-vertical .p-inputnumber-input {\n    -webkit-box-ordinal-group: 3;\n        -ms-flex-order: 2;\n            order: 2;\n    border-radius: 0;\n    text-align: center;\n}\n.p-inputnumber-buttons-vertical .p-button.p-inputnumber-button-down {\n    -webkit-box-ordinal-group: 4;\n        -ms-flex-order: 3;\n            order: 3;\n    border-top-left-radius: 0;\n    border-top-right-radius: 0;\n    width: 100%;\n}\n.p-inputnumber-input {\n    -webkit-box-flex: 1;\n        -ms-flex: 1 1 auto;\n            flex: 1 1 auto;\n}\n.p-fluid .p-inputnumber {\n    width: 100%;\n}\n.p-fluid .p-inputnumber .p-inputnumber-input {\n    width: 1%;\n}\n.p-fluid .p-inputnumber-buttons-vertical .p-inputnumber-input {\n    width: 100%;\n}\n"), u.render = function(e, t, i, s, r, u) {
        const a = n.resolveComponent("INInputText"),
            o = n.resolveComponent("INButton");
        return n.openBlock(), n.createBlock("span", {
            class: u.containerClass,
            style: i.style
        }, [n.createVNode(a, n.mergeProps({
            ref: "input",
            class: ["p-inputnumber-input", i.inputClass],
            style: i.inputStyle,
            value: u.formattedValue
        }, e.$attrs, {
            "aria-valumin": i.min,
            "aria-valuemax": i.max,
            onInput: u.onUserInput,
            onKeydown: u.onInputKeyDown,
            onKeypress: u.onInputKeyPress,
            onPaste: u.onPaste,
            onClick: u.onInputClick,
            onFocus: u.onInputFocus,
            onBlur: u.onInputBlur
        }), null, 16, ["class", "style", "value", "aria-valumin", "aria-valuemax", "onInput", "onKeydown", "onKeypress", "onPaste", "onClick", "onFocus", "onBlur"]), i.showButtons && "stacked" === i.buttonLayout ? (n.openBlock(), n.createBlock("span", l, [n.createVNode(o, n.mergeProps({
            class: u.upButtonClass,
            icon: i.incrementButtonIcon
        }, n.toHandlers(u.upButtonListeners), {
            disabled: e.$attrs.disabled
        }), null, 16, ["class", "icon", "disabled"]), n.createVNode(o, n.mergeProps({
            class: u.downButtonClass,
            icon: i.decrementButtonIcon
        }, n.toHandlers(u.downButtonListeners), {
            disabled: e.$attrs.disabled
        }), null, 16, ["class", "icon", "disabled"])])) : n.createCommentVNode("", !0), i.showButtons && "stacked" !== i.buttonLayout ? (n.openBlock(), n.createBlock(o, n.mergeProps({
            key: 1,
            class: u.upButtonClass,
            icon: i.incrementButtonIcon
        }, n.toHandlers(u.upButtonListeners), {
            disabled: e.$attrs.disabled
        }), null, 16, ["class", "icon", "disabled"])) : n.createCommentVNode("", !0), i.showButtons && "stacked" !== i.buttonLayout ? (n.openBlock(), n.createBlock(o, n.mergeProps({
            key: 2,
            class: u.downButtonClass,
            icon: i.decrementButtonIcon
        }, n.toHandlers(u.downButtonListeners), {
            disabled: e.$attrs.disabled
        }), null, 16, ["class", "icon", "disabled"])) : n.createCommentVNode("", !0)], 6)
    }, u
}(primevue.inputtext, primevue.button, Vue);

this.primevue = this.primevue || {}, this.primevue.message = function(e, t) {
    "use strict";

    function s(e) {
        return e && "object" == typeof e && "default" in e ? e : {
            default: e
        }
    }
    var i = {
        name: "Message",
        emits: ["close"],
        props: {
            severity: {
                type: String,
                default: "info"
            },
            closable: {
                type: Boolean,
                default: !0
            },
            sticky: {
                type: Boolean,
                default: !0
            },
            life: {
                type: Number,
                default: 3e3
            }
        },
        timeout: null,
        data: () => ({
            visible: !0
        }),
        mounted() {
            this.sticky || setTimeout((() => {
                this.visible = !1
            }), this.life)
        },
        methods: {
            close(e) {
                this.visible = !1, this.$emit("close", e)
            }
        },
        computed: {
            containerClass() {
                return "p-message p-component p-message-" + this.severity
            },
            iconClass() {
                return ["p-message-icon pi", {
                    "pi-info-circle": "info" === this.severity,
                    "pi-check": "success" === this.severity,
                    "pi-exclamation-triangle": "warn" === this.severity,
                    "pi-times-circle": "error" === this.severity
                }]
            }
        },
        directives: {
            ripple: s(e).default
        }
    };
    const n = {
            class: "p-message-wrapper"
        },
        a = {
            class: "p-message-text"
        },
        o = t.createVNode("i", {
            class: "p-message-close-icon pi pi-times"
        }, null, -1);
    return function(e, t) {
        void 0 === t && (t = {});
        var s = t.insertAt;
        if (e && "undefined" != typeof document) {
            var i = document.head || document.getElementsByTagName("head")[0],
                n = document.createElement("style");
            n.type = "text/css", "top" === s && i.firstChild ? i.insertBefore(n, i.firstChild) : i.appendChild(n), n.styleSheet ? n.styleSheet.cssText = e : n.appendChild(document.createTextNode(e))
        }
    }("\n.p-message-wrapper {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n}\n.p-message-close {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n}\n.p-message-close.p-link {\n    margin-left: auto;\n    overflow: hidden;\n    position: relative;\n}\n.p-message-enter-from {\n    opacity: 0;\n}\n.p-message-enter-active {\n    -webkit-transition: opacity .3s;\n    transition: opacity .3s;\n}\n.p-message.p-message-leave-from {\n    max-height: 1000px;\n}\n.p-message.p-message-leave-to {\n    max-height: 0;\n    opacity: 0;\n    margin: 0 !important;\n}\n.p-message-leave-active {\n    overflow: hidden;\n    -webkit-transition: max-height .3s cubic-bezier(0, 1, 0, 1), opacity .3s, margin .15s;\n    transition: max-height .3s cubic-bezier(0, 1, 0, 1), opacity .3s, margin .15s;\n}\n.p-message-leave-active .p-message-close {\n    display: none;\n}\n"), i.render = function(e, s, i, l, r, c) {
        const p = t.resolveDirective("ripple");
        return t.openBlock(), t.createBlock(t.Transition, {
            name: "p-message",
            appear: ""
        }, {
            default: t.withCtx((() => [t.withDirectives(t.createVNode("div", {
                class: c.containerClass,
                role: "alert"
            }, [t.createVNode("div", n, [t.createVNode("span", {
                class: c.iconClass
            }, null, 2), t.createVNode("div", a, [t.renderSlot(e.$slots, "default")]), i.closable ? t.withDirectives((t.openBlock(), t.createBlock("button", {
                key: 0,
                class: "p-message-close p-link",
                onClick: s[1] || (s[1] = e => c.close(e)),
                type: "button"
            }, [o], 512)), [
                [p]
            ]) : t.createCommentVNode("", !0)])], 2), [
                [t.vShow, r.visible]
            ])])),
            _: 3
        })
    }, i
}(primevue.ripple, Vue);

this.primevue = this.primevue || {}, this.primevue.progressbar = function(e) {
    "use strict";
    var n = {
        name: "ProgressBar",
        props: {
            value: {
                type: Number,
                default: null
            },
            mode: {
                type: String,
                default: "determinate"
            },
            showValue: {
                type: Boolean,
                default: !0
            }
        },
        computed: {
            containerClass() {
                return ["p-progressbar p-component", {
                    "p-progressbar-determinate": this.determinate,
                    "p-progressbar-indeterminate": this.indeterminate
                }]
            },
            progressStyle() {
                return {
                    width: this.value + "%",
                    display: "block"
                }
            },
            indeterminate() {
                return "indeterminate" === this.mode
            },
            determinate() {
                return "determinate" === this.mode
            }
        }
    };
    const t = {
            key: 1,
            class: "p-progressbar-label"
        },
        r = {
            key: 2,
            class: "p-progressbar-indeterminate-container"
        },
        i = e.createVNode("div", {
            class: "p-progressbar-value p-progressbar-value-animate"
        }, null, -1);
    return function(e, n) {
        void 0 === n && (n = {});
        var t = n.insertAt;
        if (e && "undefined" != typeof document) {
            var r = document.head || document.getElementsByTagName("head")[0],
                i = document.createElement("style");
            i.type = "text/css", "top" === t && r.firstChild ? r.insertBefore(i, r.firstChild) : r.appendChild(i), i.styleSheet ? i.styleSheet.cssText = e : i.appendChild(document.createTextNode(e))
        }
    }("\n.p-progressbar {\n    position: relative;\n    overflow: hidden;\n}\n.p-progressbar-determinate .p-progressbar-value {\n    height: 100%;\n    width: 0%;\n    position: absolute;\n    display: none;\n    border: 0 none;\n}\n.p-progressbar-determinate .p-progressbar-value-animate {\n    -webkit-transition: width 1s ease-in-out;\n    transition: width 1s ease-in-out;\n}\n.p-progressbar-determinate .p-progressbar-label {\n    text-align: center;\n    height: 100%;\n    width: 100%;\n    position: absolute;\n    font-weight: bold;\n}\n.p-progressbar-indeterminate .p-progressbar-value::before {\n      content: '';\n      position: absolute;\n      background-color: inherit;\n      top: 0;\n      left: 0;\n      bottom: 0;\n      will-change: left, right;\n      -webkit-animation: p-progressbar-indeterminate-anim 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;\n              animation: p-progressbar-indeterminate-anim 2.1s cubic-bezier(0.65, 0.815, 0.735, 0.395) infinite;\n}\n.p-progressbar-indeterminate .p-progressbar-value::after {\n    content: '';\n    position: absolute;\n    background-color: inherit;\n    top: 0;\n    left: 0;\n    bottom: 0;\n    will-change: left, right;\n    -webkit-animation: p-progressbar-indeterminate-anim-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;\n            animation: p-progressbar-indeterminate-anim-short 2.1s cubic-bezier(0.165, 0.84, 0.44, 1) infinite;\n    -webkit-animation-delay: 1.15s;\n            animation-delay: 1.15s;\n}\n@-webkit-keyframes p-progressbar-indeterminate-anim {\n0% {\n    left: -35%;\n    right: 100%;\n}\n60% {\n    left: 100%;\n    right: -90%;\n}\n100% {\n    left: 100%;\n    right: -90%;\n}\n}\n@keyframes p-progressbar-indeterminate-anim {\n0% {\n    left: -35%;\n    right: 100%;\n}\n60% {\n    left: 100%;\n    right: -90%;\n}\n100% {\n    left: 100%;\n    right: -90%;\n}\n}\n@-webkit-keyframes p-progressbar-indeterminate-anim-short {\n0% {\n    left: -200%;\n    right: 100%;\n}\n60% {\n    left: 107%;\n    right: -8%;\n}\n100% {\n    left: 107%;\n    right: -8%;\n}\n}\n@keyframes p-progressbar-indeterminate-anim-short {\n0% {\n    left: -200%;\n    right: 100%;\n}\n60% {\n    left: 107%;\n    right: -8%;\n}\n100% {\n    left: 107%;\n    right: -8%;\n}\n}\n"), n.render = function(n, a, s, o, l, p) {
        return e.openBlock(), e.createBlock("div", {
            role: "progressbar",
            class: p.containerClass,
            "aria-valuemin": "0",
            "aria-valuenow": s.value,
            "aria-valuemax": "100"
        }, [p.determinate ? (e.openBlock(), e.createBlock("div", {
            key: 0,
            class: "p-progressbar-value p-progressbar-value-animate",
            style: p.progressStyle
        }, null, 4)) : e.createCommentVNode("", !0), p.determinate && null !== s.value && s.showValue ? (e.openBlock(), e.createBlock("div", t, [e.renderSlot(n.$slots, "default", {}, (() => [e.createTextVNode(e.toDisplayString(s.value + "%"), 1)]))])) : e.createCommentVNode("", !0), p.indeterminate ? (e.openBlock(), e.createBlock("div", r, [i])) : e.createCommentVNode("", !0)], 10, ["aria-valuenow"])
    }, n
}(Vue);

this.primevue = this.primevue || {}, this.primevue.dropdown = function(e, t, i, l, n, o) {
    "use strict";

    function r(e) {
        return e && "object" == typeof e && "default" in e ? e : {
            default: e
        }
    }
    var s = r(t),
        a = r(l),
        p = r(n),
        d = {
            name: "Dropdown",
            emits: ["update:modelValue", "before-show", "before-hide", "show", "hide", "change", "filter", "focus", "blur"],
            props: {
                modelValue: null,
                options: Array,
                optionLabel: null,
                optionValue: null,
                optionDisabled: null,
                optionGroupLabel: null,
                optionGroupChildren: null,
                scrollHeight: {
                    type: String,
                    default: "200px"
                },
                filter: Boolean,
                filterPlaceholder: String,
                filterLocale: String,
                filterMatchMode: {
                    type: String,
                    default: "contains"
                },
                filterFields: {
                    type: Array,
                    default: null
                },
                editable: Boolean,
                placeholder: String,
                disabled: Boolean,
                dataKey: null,
                showClear: Boolean,
                inputId: String,
                tabindex: String,
                ariaLabelledBy: null,
                appendTo: {
                    type: String,
                    default: "body"
                },
                emptyFilterMessage: {
                    type: String,
                    default: null
                },
                emptyMessage: {
                    type: String,
                    default: null
                },
                panelClass: null,
                loading: {
                    type: Boolean,
                    default: !1
                },
                loadingIcon: {
                    type: String,
                    default: "pi pi-spinner pi-spin"
                },
                virtualScrollerOptions: {
                    type: Object,
                    default: null
                }
            },
            data: () => ({
                focused: !1,
                filterValue: null,
                overlayVisible: !1
            }),
            watch: {
                modelValue() {
                    this.isModelValueChanged = !0
                }
            },
            outsideClickListener: null,
            scrollHandler: null,
            resizeListener: null,
            searchTimeout: null,
            currentSearchChar: null,
            previousSearchChar: null,
            searchValue: null,
            overlay: null,
            itemsWrapper: null,
            virtualScroller: null,
            isModelValueChanged: !1,
            updated() {
                this.overlayVisible && this.isModelValueChanged && this.scrollValueInView(), this.isModelValueChanged = !1
            },
            beforeUnmount() {
                this.unbindOutsideClickListener(), this.unbindResizeListener(), this.scrollHandler && (this.scrollHandler.destroy(), this.scrollHandler = null), this.itemsWrapper = null, this.overlay && (e.ZIndexUtils.clear(this.overlay), this.overlay = null)
            },
            methods: {
                getOptionIndex(e, t) {
                    return this.virtualScrollerDisabled ? e : t && t(e).index
                },
                getOptionLabel(t) {
                    return this.optionLabel ? e.ObjectUtils.resolveFieldData(t, this.optionLabel) : t
                },
                getOptionValue(t) {
                    return this.optionValue ? e.ObjectUtils.resolveFieldData(t, this.optionValue) : t
                },
                getOptionRenderKey(t) {
                    return this.dataKey ? e.ObjectUtils.resolveFieldData(t, this.dataKey) : this.getOptionLabel(t)
                },
                isOptionDisabled(t) {
                    return !!this.optionDisabled && e.ObjectUtils.resolveFieldData(t, this.optionDisabled)
                },
                getOptionGroupRenderKey(t) {
                    return e.ObjectUtils.resolveFieldData(t, this.optionGroupLabel)
                },
                getOptionGroupLabel(t) {
                    return e.ObjectUtils.resolveFieldData(t, this.optionGroupLabel)
                },
                getOptionGroupChildren(t) {
                    return e.ObjectUtils.resolveFieldData(t, this.optionGroupChildren)
                },
                getSelectedOption() {
                    let e = this.getSelectedOptionIndex();
                    return -1 !== e ? this.optionGroupLabel ? this.getOptionGroupChildren(this.visibleOptions[e.group])[e.option] : this.visibleOptions[e] : null
                },
                getSelectedOptionIndex() {
                    if (null != this.modelValue && this.visibleOptions) {
                        if (!this.optionGroupLabel) return this.findOptionIndexInList(this.modelValue, this.visibleOptions);
                        for (let e = 0; e < this.visibleOptions.length; e++) {
                            let t = this.findOptionIndexInList(this.modelValue, this.getOptionGroupChildren(this.visibleOptions[e]));
                            if (-1 !== t) return {
                                group: e,
                                option: t
                            }
                        }
                    }
                    return -1
                },
                findOptionIndexInList(t, i) {
                    for (let l = 0; l < i.length; l++)
                        if (e.ObjectUtils.equals(t, this.getOptionValue(i[l]), this.equalityKey)) return l;
                    return -1
                },
                isSelected(t) {
                    return e.ObjectUtils.equals(this.modelValue, this.getOptionValue(t), this.equalityKey)
                },
                show() {
                    this.$emit("before-show"), this.overlayVisible = !0
                },
                hide() {
                    this.$emit("before-hide"), this.overlayVisible = !1
                },
                onFocus(e) {
                    this.focused = !0, this.$emit("focus", e)
                },
                onBlur(e) {
                    this.focused = !1, this.$emit("blur", e)
                },
                onKeyDown(e) {
                    switch (e.which) {
                        case 40:
                            this.onDownKey(e);
                            break;
                        case 38:
                            this.onUpKey(e);
                            break;
                        case 32:
                            this.overlayVisible || (this.show(), e.preventDefault());
                            break;
                        case 13:
                        case 27:
                            this.overlayVisible && (this.hide(), e.preventDefault());
                            break;
                        case 9:
                            this.hide();
                            break;
                        default:
                            this.search(e)
                    }
                },
                onFilterKeyDown(e) {
                    switch (e.which) {
                        case 40:
                            this.onDownKey(e);
                            break;
                        case 38:
                            this.onUpKey(e);
                            break;
                        case 13:
                        case 27:
                            this.overlayVisible = !1, e.preventDefault()
                    }
                },
                onDownKey(e) {
                    if (this.visibleOptions)
                        if (!this.overlayVisible && e.altKey) this.show();
                        else {
                            let t = this.visibleOptions && this.visibleOptions.length > 0 ? this.findNextOption(this.getSelectedOptionIndex()) : null;
                            t && this.updateModel(e, this.getOptionValue(t))
                        } e.preventDefault()
                },
                onUpKey(e) {
                    if (this.visibleOptions) {
                        let t = this.findPrevOption(this.getSelectedOptionIndex());
                        t && this.updateModel(e, this.getOptionValue(t))
                    }
                    e.preventDefault()
                },
                findNextOption(e) {
                    if (this.optionGroupLabel) {
                        let t = -1 === e ? 0 : e.group,
                            i = -1 === e ? -1 : e.option,
                            l = this.findNextOptionInList(this.getOptionGroupChildren(this.visibleOptions[t]), i);
                        return l || (t + 1 !== this.visibleOptions.length ? this.findNextOption({
                            group: t + 1,
                            option: -1
                        }) : null)
                    }
                    return this.findNextOptionInList(this.visibleOptions, e)
                },
                findNextOptionInList(e, t) {
                    let i = t + 1;
                    if (i === e.length) return null;
                    let l = e[i];
                    return this.isOptionDisabled(l) ? this.findNextOptionInList(i) : l
                },
                findPrevOption(e) {
                    if (-1 === e) return null;
                    if (this.optionGroupLabel) {
                        let t = e.group,
                            i = e.option,
                            l = this.findPrevOptionInList(this.getOptionGroupChildren(this.visibleOptions[t]), i);
                        return l || (t > 0 ? this.findPrevOption({
                            group: t - 1,
                            option: this.getOptionGroupChildren(this.visibleOptions[t - 1]).length
                        }) : null)
                    }
                    return this.findPrevOptionInList(this.visibleOptions, e)
                },
                findPrevOptionInList(e, t) {
                    let i = t - 1;
                    if (i < 0) return null;
                    let l = e[i];
                    return this.isOptionDisabled(l) ? this.findPrevOption(i) : l
                },
                onClearClick(e) {
                    this.updateModel(e, null)
                },
                onClick(t) {
                    this.disabled || this.loading || e.DomHandler.hasClass(t.target, "p-dropdown-clear-icon") || "INPUT" === t.target.tagName || this.overlay && this.overlay.contains(t.target) || (this.overlayVisible ? this.hide() : this.show(), this.$refs.focusInput.focus())
                },
                onOptionSelect(e, t) {
                    let i = this.getOptionValue(t);
                    this.updateModel(e, i), this.$refs.focusInput.focus(), setTimeout((() => {
                        this.hide()
                    }), 200)
                },
                onEditableInput(e) {
                    this.$emit("update:modelValue", e.target.value)
                },
                onOverlayEnter(t) {
                    if (e.ZIndexUtils.set("overlay", t, this.$primevue.config.zIndex.overlay), this.alignOverlay(), this.bindOutsideClickListener(), this.bindScrollListener(), this.bindResizeListener(), this.scrollValueInView(), this.filter && this.$refs.filterInput.focus(), !this.virtualScrollerDisabled) {
                        const e = this.getSelectedOptionIndex(); - 1 !== e && this.virtualScroller.scrollToIndex(e)
                    }
                    this.$emit("show")
                },
                onOverlayLeave() {
                    this.unbindOutsideClickListener(), this.unbindScrollListener(), this.unbindResizeListener(), this.$emit("hide"), this.itemsWrapper = null, this.overlay = null
                },
                onOverlayAfterLeave(t) {
                    e.ZIndexUtils.clear(t)
                },
                alignOverlay() {
                    this.appendDisabled ? e.DomHandler.relativePosition(this.overlay, this.$el) : (this.overlay.style.minWidth = e.DomHandler.getOuterWidth(this.$el) + "px", e.DomHandler.absolutePosition(this.overlay, this.$el))
                },
                updateModel(e, t) {
                    this.$emit("update:modelValue", t), this.$emit("change", {
                        originalEvent: e,
                        value: t
                    })
                },
                bindOutsideClickListener() {
                    this.outsideClickListener || (this.outsideClickListener = e => {
                        this.overlayVisible && this.overlay && !this.$el.contains(e.target) && !this.overlay.contains(e.target) && this.hide()
                    }, document.addEventListener("click", this.outsideClickListener))
                },
                unbindOutsideClickListener() {
                    this.outsideClickListener && (document.removeEventListener("click", this.outsideClickListener), this.outsideClickListener = null)
                },
                bindScrollListener() {
                    this.scrollHandler || (this.scrollHandler = new e.ConnectedOverlayScrollHandler(this.$refs.container, (() => {
                        this.overlayVisible && this.hide()
                    }))), this.scrollHandler.bindScrollListener()
                },
                unbindScrollListener() {
                    this.scrollHandler && this.scrollHandler.unbindScrollListener()
                },
                bindResizeListener() {
                    this.resizeListener || (this.resizeListener = () => {
                        this.overlayVisible && !e.DomHandler.isTouchDevice() && this.hide()
                    }, window.addEventListener("resize", this.resizeListener))
                },
                unbindResizeListener() {
                    this.resizeListener && (window.removeEventListener("resize", this.resizeListener), this.resizeListener = null)
                },
                search(e) {
                    if (!this.visibleOptions) return;
                    this.searchTimeout && clearTimeout(this.searchTimeout);
                    const t = e.key;
                    if (this.previousSearchChar = this.currentSearchChar, this.currentSearchChar = t, this.previousSearchChar === this.currentSearchChar ? this.searchValue = this.currentSearchChar : this.searchValue = this.searchValue ? this.searchValue + t : t, this.searchValue) {
                        let t = this.getSelectedOptionIndex(),
                            i = this.optionGroupLabel ? this.searchOptionInGroup(t) : this.searchOption(++t);
                        i && this.updateModel(e, this.getOptionValue(i))
                    }
                    this.searchTimeout = setTimeout((() => {
                        this.searchValue = null
                    }), 250)
                },
                searchOption(e) {
                    let t;
                    return this.searchValue && (t = this.searchOptionInRange(e, this.visibleOptions.length), t || (t = this.searchOptionInRange(0, e))), t
                },
                searchOptionInRange(e, t) {
                    for (let i = e; i < t; i++) {
                        let e = this.visibleOptions[i];
                        if (this.matchesSearchValue(e)) return e
                    }
                    return null
                },
                searchOptionInGroup(e) {
                    let t = -1 === e ? {
                        group: 0,
                        option: -1
                    } : e;
                    for (let e = t.group; e < this.visibleOptions.length; e++) {
                        let i = this.getOptionGroupChildren(this.visibleOptions[e]);
                        for (let l = t.group === e ? t.option + 1 : 0; l < i.length; l++)
                            if (this.matchesSearchValue(i[l])) return i[l]
                    }
                    for (let e = 0; e <= t.group; e++) {
                        let i = this.getOptionGroupChildren(this.visibleOptions[e]);
                        for (let l = 0; l < (t.group === e ? t.option : i.length); l++)
                            if (this.matchesSearchValue(i[l])) return i[l]
                    }
                    return null
                },
                matchesSearchValue(e) {
                    return this.getOptionLabel(e).toLocaleLowerCase(this.filterLocale).startsWith(this.searchValue.toLocaleLowerCase(this.filterLocale))
                },
                onFilterChange(e) {
                    this.$emit("filter", {
                        originalEvent: e,
                        value: e.target.value
                    })
                },
                onFilterUpdated() {
                    this.overlayVisible && this.alignOverlay()
                },
                overlayRef(e) {
                    this.overlay = e
                },
                itemsWrapperRef(e) {
                    this.itemsWrapper = e
                },
                virtualScrollerRef(e) {
                    this.virtualScroller = e
                },
                scrollValueInView() {
                    if (this.overlay) {
                        let t = e.DomHandler.findSingle(this.overlay, "li.p-highlight");
                        t && t.scrollIntoView({
                            block: "nearest",
                            inline: "start"
                        })
                    }
                },
                onOverlayClick(e) {
                    s.default.emit("overlay-click", {
                        originalEvent: e,
                        target: this.$el
                    })
                }
            },
            computed: {
                visibleOptions() {
                    if (this.filterValue) {
                        if (this.optionGroupLabel) {
                            let e = [];
                            for (let t of this.options) {
                                let l = i.FilterService.filter(this.getOptionGroupChildren(t), this.searchFields, this.filterValue, this.filterMatchMode, this.filterLocale);
                                if (l && l.length) {
                                    let i = {
                                        ...t
                                    };
                                    i[this.optionGroupChildren] = l, e.push(i)
                                }
                            }
                            return e
                        }
                        return i.FilterService.filter(this.options, this.searchFields, this.filterValue, this.filterMatchMode, this.filterLocale)
                    }
                    return this.options
                },
                containerClass() {
                    return ["p-dropdown p-component p-inputwrapper", {
                        "p-disabled": this.disabled,
                        "p-dropdown-clearable": this.showClear && !this.disabled,
                        "p-focus": this.focused,
                        "p-inputwrapper-filled": this.modelValue,
                        "p-inputwrapper-focus": this.focused || this.overlayVisible
                    }]
                },
                labelClass() {
                    return ["p-dropdown-label p-inputtext", {
                        "p-placeholder": this.label === this.placeholder,
                        "p-dropdown-label-empty": !this.$slots.value && ("p-emptylabel" === this.label || 0 === this.label.length)
                    }]
                },
                panelStyleClass() {
                    return ["p-dropdown-panel p-component", this.panelClass, {
                        "p-input-filled": "filled" === this.$primevue.config.inputStyle,
                        "p-ripple-disabled": !1 === this.$primevue.config.ripple
                    }]
                },
                label() {
                    let e = this.getSelectedOption();
                    return e ? this.getOptionLabel(e) : this.placeholder || "p-emptylabel"
                },
                editableInputValue() {
                    let e = this.getSelectedOption();
                    return e ? this.getOptionLabel(e) : this.modelValue
                },
                equalityKey() {
                    return this.optionValue ? null : this.dataKey
                },
                searchFields() {
                    return this.filterFields || [this.optionLabel]
                },
                emptyFilterMessageText() {
                    return this.emptyFilterMessage || this.$primevue.config.locale.emptyFilterMessage
                },
                emptyMessageText() {
                    return this.emptyMessage || this.$primevue.config.locale.emptyMessage
                },
                appendDisabled() {
                    return "self" === this.appendTo
                },
                virtualScrollerDisabled() {
                    return !this.virtualScrollerOptions
                },
                appendTarget() {
                    return this.appendDisabled ? null : this.appendTo
                },
                dropdownIconClass() {
                    return ["p-dropdown-trigger-icon", this.loading ? this.loadingIcon : "pi pi-chevron-down"]
                }
            },
            directives: {
                ripple: a.default
            },
            components: {
                VirtualScroller: p.default
            }
        };
    const h = {
            class: "p-hidden-accessible"
        },
        u = {
            key: 0,
            class: "p-dropdown-header"
        },
        c = {
            class: "p-dropdown-filter-container"
        },
        b = o.createVNode("span", {
            class: "p-dropdown-filter-icon pi pi-search"
        }, null, -1),
        f = {
            class: "p-dropdown-item-group"
        },
        v = {
            key: 2,
            class: "p-dropdown-empty-message"
        },
        g = {
            key: 3,
            class: "p-dropdown-empty-message"
        };
    return function(e, t) {
        void 0 === t && (t = {});
        var i = t.insertAt;
        if (e && "undefined" != typeof document) {
            var l = document.head || document.getElementsByTagName("head")[0],
                n = document.createElement("style");
            n.type = "text/css", "top" === i && l.firstChild ? l.insertBefore(n, l.firstChild) : l.appendChild(n), n.styleSheet ? n.styleSheet.cssText = e : n.appendChild(document.createTextNode(e))
        }
    }("\n.p-dropdown {\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n    cursor: pointer;\n    position: relative;\n    -webkit-user-select: none;\n       -moz-user-select: none;\n        -ms-user-select: none;\n            user-select: none;\n}\n.p-dropdown-clear-icon {\n    position: absolute;\n    top: 50%;\n    margin-top: -.5rem;\n}\n.p-dropdown-trigger {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    -ms-flex-negative: 0;\n        flex-shrink: 0;\n}\n.p-dropdown-label {\n    display: block;\n    white-space: nowrap;\n    overflow: hidden;\n    -webkit-box-flex: 1;\n        -ms-flex: 1 1 auto;\n            flex: 1 1 auto;\n    width: 1%;\n    text-overflow: ellipsis;\n    cursor: pointer;\n}\n.p-dropdown-label-empty {\n    overflow: hidden;\n    visibility: hidden;\n}\ninput.p-dropdown-label  {\n    cursor: default;\n}\n.p-dropdown .p-dropdown-panel {\n    min-width: 100%;\n}\n.p-dropdown-panel {\n    position: absolute;\n    top: 0;\n    left: 0;\n}\n.p-dropdown-items-wrapper {\n    overflow: auto;\n}\n.p-dropdown-item {\n    cursor: pointer;\n    font-weight: normal;\n    white-space: nowrap;\n    position: relative;\n    overflow: hidden;\n}\n.p-dropdown-item-group {\n    cursor: auto;\n}\n.p-dropdown-items {\n    margin: 0;\n    padding: 0;\n    list-style-type: none;\n}\n.p-dropdown-filter {\n    width: 100%;\n}\n.p-dropdown-filter-container {\n    position: relative;\n}\n.p-dropdown-filter-icon {\n    position: absolute;\n    top: 50%;\n    margin-top: -.5rem;\n}\n.p-fluid .p-dropdown {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n}\n.p-fluid .p-dropdown .p-dropdown-label {\n    width: 1%;\n}\n"), d.render = function(e, t, i, l, n, r) {
        const s = o.resolveComponent("VirtualScroller"),
            a = o.resolveDirective("ripple");
        return o.openBlock(), o.createBlock("div", {
            ref: "container",
            class: r.containerClass,
            onClick: t[13] || (t[13] = e => r.onClick(e))
        }, [o.createVNode("div", h, [o.createVNode("input", {
            ref: "focusInput",
            type: "text",
            id: i.inputId,
            readonly: "",
            disabled: i.disabled,
            onFocus: t[1] || (t[1] = (...e) => r.onFocus && r.onFocus(...e)),
            onBlur: t[2] || (t[2] = (...e) => r.onBlur && r.onBlur(...e)),
            onKeydown: t[3] || (t[3] = (...e) => r.onKeyDown && r.onKeyDown(...e)),
            tabindex: i.tabindex,
            "aria-haspopup": "true",
            "aria-expanded": n.overlayVisible,
            "aria-labelledby": i.ariaLabelledBy
        }, null, 40, ["id", "disabled", "tabindex", "aria-expanded", "aria-labelledby"])]), i.editable ? (o.openBlock(), o.createBlock("input", {
            key: 0,
            type: "text",
            class: "p-dropdown-label p-inputtext",
            disabled: i.disabled,
            onFocus: t[4] || (t[4] = (...e) => r.onFocus && r.onFocus(...e)),
            onBlur: t[5] || (t[5] = (...e) => r.onBlur && r.onBlur(...e)),
            placeholder: i.placeholder,
            value: r.editableInputValue,
            onInput: t[6] || (t[6] = (...e) => r.onEditableInput && r.onEditableInput(...e)),
            "aria-haspopup": "listbox",
            "aria-expanded": n.overlayVisible
        }, null, 40, ["disabled", "placeholder", "value", "aria-expanded"])) : o.createCommentVNode("", !0), i.editable ? o.createCommentVNode("", !0) : (o.openBlock(), o.createBlock("span", {
            key: 1,
            class: r.labelClass
        }, [o.renderSlot(e.$slots, "value", {
            value: i.modelValue,
            placeholder: i.placeholder
        }, (() => [o.createTextVNode(o.toDisplayString(r.label || "empty"), 1)]))], 2)), i.showClear && null != i.modelValue ? (o.openBlock(), o.createBlock("i", {
            key: 2,
            class: "p-dropdown-clear-icon pi pi-times",
            onClick: t[7] || (t[7] = e => r.onClearClick(e))
        })) : o.createCommentVNode("", !0), o.createVNode("div", {
            class: "p-dropdown-trigger",
            role: "button",
            "aria-haspopup": "listbox",
            "aria-expanded": n.overlayVisible
        }, [o.renderSlot(e.$slots, "indicator", {}, (() => [o.createVNode("span", {
            class: r.dropdownIconClass
        }, null, 2)]))], 8, ["aria-expanded"]), (o.openBlock(), o.createBlock(o.Teleport, {
            to: r.appendTarget,
            disabled: r.appendDisabled
        }, [o.createVNode(o.Transition, {
            name: "p-connected-overlay",
            onEnter: r.onOverlayEnter,
            onLeave: r.onOverlayLeave,
            onAfterLeave: r.onOverlayAfterLeave
        }, {
            default: o.withCtx((() => [n.overlayVisible ? (o.openBlock(), o.createBlock("div", {
                key: 0,
                ref: r.overlayRef,
                class: r.panelStyleClass,
                onClick: t[12] || (t[12] = (...e) => r.onOverlayClick && r.onOverlayClick(...e))
            }, [o.renderSlot(e.$slots, "header", {
                value: i.modelValue,
                options: r.visibleOptions
            }), i.filter ? (o.openBlock(), o.createBlock("div", u, [o.createVNode("div", c, [o.withDirectives(o.createVNode("input", {
                type: "text",
                ref: "filterInput",
                "onUpdate:modelValue": t[8] || (t[8] = e => n.filterValue = e),
                onVnodeUpdated: t[9] || (t[9] = (...e) => r.onFilterUpdated && r.onFilterUpdated(...e)),
                autoComplete: "off",
                class: "p-dropdown-filter p-inputtext p-component",
                placeholder: i.filterPlaceholder,
                onKeydown: t[10] || (t[10] = (...e) => r.onFilterKeyDown && r.onFilterKeyDown(...e)),
                onInput: t[11] || (t[11] = (...e) => r.onFilterChange && r.onFilterChange(...e))
            }, null, 40, ["placeholder"]), [
                [o.vModelText, n.filterValue]
            ]), b])])) : o.createCommentVNode("", !0), o.createVNode("div", {
                ref: r.itemsWrapperRef,
                class: "p-dropdown-items-wrapper",
                style: {
                    "max-height": r.virtualScrollerDisabled ? i.scrollHeight : ""
                }
            }, [o.createVNode(s, o.mergeProps({
                ref: r.virtualScrollerRef
            }, i.virtualScrollerOptions, {
                items: r.visibleOptions,
                style: {
                    height: i.scrollHeight
                },
                disabled: r.virtualScrollerDisabled
            }), o.createSlots({
                content: o.withCtx((({
                    styleClass: t,
                    contentRef: l,
                    items: s,
                    getItemOptions: p
                }) => [o.createVNode("ul", {
                    ref: l,
                    class: ["p-dropdown-items", t],
                    role: "listbox"
                }, [i.optionGroupLabel ? (o.openBlock(!0), o.createBlock(o.Fragment, {
                    key: 1
                }, o.renderList(s, ((t, i) => (o.openBlock(), o.createBlock(o.Fragment, {
                    key: r.getOptionGroupRenderKey(t)
                }, [o.createVNode("li", f, [o.renderSlot(e.$slots, "optiongroup", {
                    option: t,
                    index: r.getOptionIndex(i, p)
                }, (() => [o.createTextVNode(o.toDisplayString(r.getOptionGroupLabel(t)), 1)]))]), (o.openBlock(!0), o.createBlock(o.Fragment, null, o.renderList(r.getOptionGroupChildren(t), ((t, i) => o.withDirectives((o.openBlock(), o.createBlock("li", {
                    class: ["p-dropdown-item", {
                        "p-highlight": r.isSelected(t),
                        "p-disabled": r.isOptionDisabled(t)
                    }],
                    key: r.getOptionRenderKey(t),
                    onClick: e => r.onOptionSelect(e, t),
                    role: "option",
                    "aria-label": r.getOptionLabel(t),
                    "aria-selected": r.isSelected(t)
                }, [o.renderSlot(e.$slots, "option", {
                    option: t,
                    index: r.getOptionIndex(i, p)
                }, (() => [o.createTextVNode(o.toDisplayString(r.getOptionLabel(t)), 1)]))], 10, ["onClick", "aria-label", "aria-selected"])), [
                    [a]
                ]))), 128))], 64)))), 128)) : (o.openBlock(!0), o.createBlock(o.Fragment, {
                    key: 0
                }, o.renderList(s, ((t, i) => o.withDirectives((o.openBlock(), o.createBlock("li", {
                    class: ["p-dropdown-item", {
                        "p-highlight": r.isSelected(t),
                        "p-disabled": r.isOptionDisabled(t)
                    }],
                    key: r.getOptionRenderKey(t),
                    onClick: e => r.onOptionSelect(e, t),
                    role: "option",
                    "aria-label": r.getOptionLabel(t),
                    "aria-selected": r.isSelected(t)
                }, [o.renderSlot(e.$slots, "option", {
                    option: t,
                    index: r.getOptionIndex(i, p)
                }, (() => [o.createTextVNode(o.toDisplayString(r.getOptionLabel(t)), 1)]))], 10, ["onClick", "aria-label", "aria-selected"])), [
                    [a]
                ]))), 128)), n.filterValue && (!s || s && 0 === s.length) ? (o.openBlock(), o.createBlock("li", v, [o.renderSlot(e.$slots, "emptyfilter", {}, (() => [o.createTextVNode(o.toDisplayString(r.emptyFilterMessageText), 1)]))])) : !i.options || i.options && 0 === i.options.length ? (o.openBlock(), o.createBlock("li", g, [o.renderSlot(e.$slots, "empty", {}, (() => [o.createTextVNode(o.toDisplayString(r.emptyMessageText), 1)]))])) : o.createCommentVNode("", !0)], 2)])),
                _: 2
            }, [e.$slots.loader ? {
                name: "loader",
                fn: o.withCtx((({
                    options: t
                }) => [o.renderSlot(e.$slots, "loader", {
                    options: t
                })]))
            } : void 0]), 1040, ["items", "style", "disabled"])], 4), o.renderSlot(e.$slots, "footer", {
                value: i.modelValue,
                options: r.visibleOptions
            })], 2)) : o.createCommentVNode("", !0)])),
            _: 3
        }, 8, ["onEnter", "onLeave", "onAfterLeave"])], 8, ["to", "disabled"]))], 2)
    }, d
}(primevue.utils, primevue.overlayeventbus, primevue.api, primevue.ripple, primevue.virtualscroller, Vue);

this.primevue = this.primevue || {}, this.primevue.dialog = function(e, t, n) {
    "use strict";

    function i(e) {
        return e && "object" == typeof e && "default" in e ? e : {
            default: e
        }
    }
    var a = {
        name: "Dialog",
        inheritAttrs: !1,
        emits: ["update:visible", "show", "hide", "maximize", "unmaximize", "dragend"],
        props: {
            header: null,
            footer: null,
            visible: Boolean,
            modal: Boolean,
            contentStyle: null,
            contentClass: String,
            rtl: Boolean,
            maximizable: Boolean,
            dismissableMask: Boolean,
            closable: {
                type: Boolean,
                default: !0
            },
            closeOnEscape: {
                type: Boolean,
                default: !0
            },
            showHeader: {
                type: Boolean,
                default: !0
            },
            baseZIndex: {
                type: Number,
                default: 0
            },
            autoZIndex: {
                type: Boolean,
                default: !0
            },
            ariaCloseLabel: {
                type: String,
                default: "close"
            },
            position: {
                type: String,
                default: "center"
            },
            breakpoints: {
                type: Object,
                default: null
            },
            draggable: {
                type: Boolean,
                default: !0
            },
            keepInViewport: {
                type: Boolean,
                default: !0
            },
            minX: {
                type: Number,
                default: 0
            },
            minY: {
                type: Number,
                default: 0
            },
            appendTo: {
                type: String,
                default: "body"
            }
        },
        data() {
            return {
                containerVisible: this.visible,
                maximized: !1
            }
        },
        documentKeydownListener: null,
        container: null,
        mask: null,
        styleElement: null,
        dragging: null,
        documentDragListener: null,
        documentDragEndListener: null,
        lastPageX: null,
        lastPageY: null,
        updated() {
            this.visible && (this.containerVisible = this.visible)
        },
        beforeUnmount() {
            this.unbindDocumentState(), this.unbindGlobalListeners(), this.destroyStyle(), this.mask = null, this.container && this.autoZIndex && e.ZIndexUtils.clear(this.container), this.container = null
        },
        mounted() {
            this.breakpoints && this.createStyle()
        },
        methods: {
            close() {
                this.$emit("update:visible", !1)
            },
            onBeforeEnter(t) {
                this.autoZIndex && e.ZIndexUtils.set("modal", t, this.baseZIndex + this.$primevue.config.zIndex.modal), t.setAttribute(this.attributeSelector, "")
            },
            onEnter() {
                this.mask.style.zIndex = String(parseInt(this.container.style.zIndex, 10) - 1), this.$emit("show"), this.focus(), this.enableDocumentSettings(), this.bindGlobalListeners()
            },
            onBeforeLeave() {
                this.modal && e.DomHandler.addClass(this.mask, "p-component-overlay-leave")
            },
            onLeave() {
                this.$emit("hide")
            },
            onAfterLeave(t) {
                this.autoZIndex && e.ZIndexUtils.clear(t), this.containerVisible = !1, this.unbindDocumentState(), this.unbindGlobalListeners()
            },
            onMaskClick(e) {
                this.dismissableMask && this.closable && this.modal && this.mask === e.target && this.close()
            },
            focus() {
                let e = this.container.querySelector("[autofocus]");
                e && e.focus()
            },
            maximize(t) {
                this.maximized ? (this.maximized = !1, this.$emit("unmaximize", t)) : (this.maximized = !0, this.$emit("maximize", t)), this.modal || (this.maximized ? e.DomHandler.addClass(document.body, "p-overflow-hidden") : e.DomHandler.removeClass(document.body, "p-overflow-hidden"))
            },
            enableDocumentSettings() {
                (this.modal || this.maximizable && this.maximized) && e.DomHandler.addClass(document.body, "p-overflow-hidden")
            },
            unbindDocumentState() {
                (this.modal || this.maximizable && this.maximized) && e.DomHandler.removeClass(document.body, "p-overflow-hidden")
            },
            onKeyDown(t) {
                if (9 === t.which) {
                    t.preventDefault();
                    let n = e.DomHandler.getFocusableElements(this.container);
                    if (n && n.length > 0)
                        if (document.activeElement) {
                            let e = n.indexOf(document.activeElement);
                            t.shiftKey ? -1 == e || 0 === e ? n[n.length - 1].focus() : n[e - 1].focus() : -1 == e || e === n.length - 1 ? n[0].focus() : n[e + 1].focus()
                        } else n[0].focus()
                } else 27 === t.which && this.closeOnEscape && this.close()
            },
            bindDocumentKeyDownListener() {
                this.documentKeydownListener || (this.documentKeydownListener = this.onKeyDown.bind(this), window.document.addEventListener("keydown", this.documentKeydownListener))
            },
            unbindDocumentKeyDownListener() {
                this.documentKeydownListener && (window.document.removeEventListener("keydown", this.documentKeydownListener), this.documentKeydownListener = null)
            },
            getPositionClass() {
                const e = ["left", "right", "top", "topleft", "topright", "bottom", "bottomleft", "bottomright"].find((e => e === this.position));
                return e ? `p-dialog-${e}` : ""
            },
            containerRef(e) {
                this.container = e
            },
            maskRef(e) {
                this.mask = e
            },
            createStyle() {
                if (!this.styleElement) {
                    this.styleElement = document.createElement("style"), this.styleElement.type = "text/css", document.head.appendChild(this.styleElement);
                    let e = "";
                    for (let t in this.breakpoints) e += `\n                        @media screen and (max-width: ${t}) {\n                            .p-dialog[${this.attributeSelector}] {\n                                width: ${this.breakpoints[t]} !important;\n                            }\n                        }\n                    `;
                    this.styleElement.innerHTML = e
                }
            },
            destroyStyle() {
                this.styleElement && (document.head.removeChild(this.styleElement), this.styleElement = null)
            },
            initDrag(t) {
                e.DomHandler.hasClass(t.target, "p-dialog-header-icon") || e.DomHandler.hasClass(t.target.parentElement, "p-dialog-header-icon") || this.draggable && (this.dragging = !0, this.lastPageX = t.pageX, this.lastPageY = t.pageY, this.container.style.margin = "0", e.DomHandler.addClass(document.body, "p-unselectable-text"))
            },
            bindGlobalListeners() {
                this.draggable && (this.bindDocumentDragListener(), this.bindDocumentDragEndListener()), this.closeOnEscape && this.closable && this.bindDocumentKeyDownListener()
            },
            unbindGlobalListeners() {
                this.unbindDocumentDragListener(), this.unbindDocumentDragEndListener(), this.unbindDocumentKeyDownListener()
            },
            bindDocumentDragListener() {
                this.documentDragListener = t => {
                    if (this.dragging) {
                        let n = e.DomHandler.getOuterWidth(this.container),
                            i = e.DomHandler.getOuterHeight(this.container),
                            a = t.pageX - this.lastPageX,
                            o = t.pageY - this.lastPageY,
                            l = this.container.getBoundingClientRect(),
                            s = l.left + a,
                            d = l.top + o,
                            r = e.DomHandler.getViewport();
                        this.container.style.position = "fixed", this.keepInViewport ? (s >= this.minX && s + n < r.width && (this.lastPageX = t.pageX, this.container.style.left = s + "px"), d >= this.minY && d + i < r.height && (this.lastPageY = t.pageY, this.container.style.top = d + "px")) : (this.lastPageX = t.pageX, this.container.style.left = s + "px", this.lastPageY = t.pageY, this.container.style.top = d + "px")
                    }
                }, window.document.addEventListener("mousemove", this.documentDragListener)
            },
            unbindDocumentDragListener() {
                this.documentDragListener && (window.document.removeEventListener("mousemove", this.documentDragListener), this.documentDragListener = null)
            },
            bindDocumentDragEndListener() {
                this.documentDragEndListener = t => {
                    this.dragging && (this.dragging = !1, e.DomHandler.removeClass(document.body, "p-unselectable-text"), this.$emit("dragend", t))
                }, window.document.addEventListener("mouseup", this.documentDragEndListener)
            },
            unbindDocumentDragEndListener() {
                this.documentDragEndListener && (window.document.removeEventListener("mouseup", this.documentDragEndListener), this.documentDragEndListener = null)
            }
        },
        computed: {
            maskClass() {
                return ["p-dialog-mask", {
                    "p-component-overlay p-component-overlay-enter": this.modal
                }, this.getPositionClass()]
            },
            dialogClass() {
                return ["p-dialog p-component", {
                    "p-dialog-rtl": this.rtl,
                    "p-dialog-maximized": this.maximizable && this.maximized,
                    "p-input-filled": "filled" === this.$primevue.config.inputStyle,
                    "p-ripple-disabled": !1 === this.$primevue.config.ripple
                }]
            },
            maximizeIconClass() {
                return ["p-dialog-header-maximize-icon pi", {
                    "pi-window-maximize": !this.maximized,
                    "pi-window-minimize": this.maximized
                }]
            },
            ariaId: () => e.UniqueComponentId(),
            ariaLabelledById() {
                return null != this.header ? this.ariaId + "_header" : null
            },
            attributeSelector: () => e.UniqueComponentId(),
            contentStyleClass() {
                return ["p-dialog-content", this.contentClass]
            },
            appendDisabled() {
                return "self" === this.appendTo
            },
            appendTarget() {
                return this.appendDisabled ? null : this.appendTo
            }
        },
        directives: {
            ripple: i(t).default
        }
    };
    const o = {
            class: "p-dialog-header-icons"
        },
        l = n.createVNode("span", {
            class: "p-dialog-header-close-icon pi pi-times"
        }, null, -1),
        s = {
            key: 1,
            class: "p-dialog-footer"
        };
    return function(e, t) {
        void 0 === t && (t = {});
        var n = t.insertAt;
        if (e && "undefined" != typeof document) {
            var i = document.head || document.getElementsByTagName("head")[0],
                a = document.createElement("style");
            a.type = "text/css", "top" === n && i.firstChild ? i.insertBefore(a, i.firstChild) : i.appendChild(a), a.styleSheet ? a.styleSheet.cssText = e : a.appendChild(document.createTextNode(e))
        }
    }("\n.p-dialog-mask {\n    position: fixed;\n    top: 0;\n    left: 0;\n    width: 100%;\n    height: 100%;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    pointer-events: none;\n}\n.p-dialog-mask.p-component-overlay {\n    pointer-events: auto;\n}\n.p-dialog {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n    pointer-events: auto;\n    max-height: 90%;\n    -webkit-transform: scale(1);\n            transform: scale(1);\n}\n.p-dialog-content {\n    overflow-y: auto;\n}\n.p-dialog-header {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: justify;\n        -ms-flex-pack: justify;\n            justify-content: space-between;\n    -ms-flex-negative: 0;\n        flex-shrink: 0;\n}\n.p-dialog-footer {\n    -ms-flex-negative: 0;\n        flex-shrink: 0;\n}\n.p-dialog .p-dialog-header-icons {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n}\n.p-dialog .p-dialog-header-icon {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    overflow: hidden;\n    position: relative;\n}\n\n/* Fluid */\n.p-fluid .p-dialog-footer .p-button {\n    width: auto;\n}\n\n/* Animation */\n/* Center */\n.p-dialog-enter-active {\n    -webkit-transition: all 150ms cubic-bezier(0, 0, 0.2, 1);\n    transition: all 150ms cubic-bezier(0, 0, 0.2, 1);\n}\n.p-dialog-leave-active {\n    -webkit-transition: all 150ms cubic-bezier(0.4, 0.0, 0.2, 1);\n    transition: all 150ms cubic-bezier(0.4, 0.0, 0.2, 1);\n}\n.p-dialog-enter-from,\n.p-dialog-leave-to {\n    opacity: 0;\n    -webkit-transform: scale(0.7);\n            transform: scale(0.7);\n}\n\n/* Top, Bottom, Left, Right, Top* and Bottom* */\n.p-dialog-top .p-dialog,\n.p-dialog-bottom .p-dialog,\n.p-dialog-left .p-dialog,\n.p-dialog-right .p-dialog,\n.p-dialog-topleft .p-dialog,\n.p-dialog-topright .p-dialog,\n.p-dialog-bottomleft .p-dialog,\n.p-dialog-bottomright .p-dialog {\n    margin: .75rem;\n    -webkit-transform: translate3d(0px, 0px, 0px);\n            transform: translate3d(0px, 0px, 0px);\n}\n.p-dialog-top .p-dialog-enter-active,\n.p-dialog-top .p-dialog-leave-active,\n.p-dialog-bottom .p-dialog-enter-active,\n.p-dialog-bottom .p-dialog-leave-active,\n.p-dialog-left .p-dialog-enter-active,\n.p-dialog-left .p-dialog-leave-active,\n.p-dialog-right .p-dialog-enter-active,\n.p-dialog-right .p-dialog-leave-active,\n.p-dialog-topleft .p-dialog-enter-active,\n.p-dialog-topleft .p-dialog-leave-active,\n.p-dialog-topright .p-dialog-enter-active,\n.p-dialog-topright .p-dialog-leave-active,\n.p-dialog-bottomleft .p-dialog-enter-active,\n.p-dialog-bottomleft .p-dialog-leave-active,\n.p-dialog-bottomright .p-dialog-enter-active,\n.p-dialog-bottomright .p-dialog-leave-active {\n    -webkit-transition: all .3s ease-out;\n    transition: all .3s ease-out;\n}\n.p-dialog-top .p-dialog-enter-from,\n.p-dialog-top .p-dialog-leave-to {\n    -webkit-transform: translate3d(0px, -100%, 0px);\n            transform: translate3d(0px, -100%, 0px);\n}\n.p-dialog-bottom .p-dialog-enter-from,\n.p-dialog-bottom .p-dialog-leave-to {\n    -webkit-transform: translate3d(0px, 100%, 0px);\n            transform: translate3d(0px, 100%, 0px);\n}\n.p-dialog-left .p-dialog-enter-from,\n.p-dialog-left .p-dialog-leave-to,\n.p-dialog-topleft .p-dialog-enter-from,\n.p-dialog-topleft .p-dialog-leave-to,\n.p-dialog-bottomleft .p-dialog-enter-from,\n.p-dialog-bottomleft .p-dialog-leave-to {\n    -webkit-transform: translate3d(-100%, 0px, 0px);\n            transform: translate3d(-100%, 0px, 0px);\n}\n.p-dialog-right .p-dialog-enter-from,\n.p-dialog-right .p-dialog-leave-to,\n.p-dialog-topright .p-dialog-enter-from,\n.p-dialog-topright .p-dialog-leave-to,\n.p-dialog-bottomright .p-dialog-enter-from,\n.p-dialog-bottomright .p-dialog-leave-to {\n    -webkit-transform: translate3d(100%, 0px, 0px);\n            transform: translate3d(100%, 0px, 0px);\n}\n\n/* Maximize */\n.p-dialog-maximized {\n    -webkit-transition: none;\n    transition: none;\n    -webkit-transform: none;\n            transform: none;\n    width: 100vw !important;\n    height: 100vh !important;\n    top: 0px !important;\n    left: 0px !important;\n    max-height: 100%;\n    height: 100%;\n}\n.p-dialog-maximized .p-dialog-content {\n    -webkit-box-flex: 1;\n        -ms-flex-positive: 1;\n            flex-grow: 1;\n}\n\n/* Position */\n.p-dialog-left {\n    -webkit-box-pack: start;\n        -ms-flex-pack: start;\n            justify-content: flex-start;\n}\n.p-dialog-right {\n    -webkit-box-pack: end;\n        -ms-flex-pack: end;\n            justify-content: flex-end;\n}\n.p-dialog-top {\n    -webkit-box-align: start;\n        -ms-flex-align: start;\n            align-items: flex-start;\n}\n.p-dialog-topleft {\n    -webkit-box-pack: start;\n        -ms-flex-pack: start;\n            justify-content: flex-start;\n    -webkit-box-align: start;\n        -ms-flex-align: start;\n            align-items: flex-start;\n}\n.p-dialog-topright {\n    -webkit-box-pack: end;\n        -ms-flex-pack: end;\n            justify-content: flex-end;\n    -webkit-box-align: start;\n        -ms-flex-align: start;\n            align-items: flex-start;\n}\n.p-dialog-bottom {\n    -webkit-box-align: end;\n        -ms-flex-align: end;\n            align-items: flex-end;\n}\n.p-dialog-bottomleft {\n    -webkit-box-pack: start;\n        -ms-flex-pack: start;\n            justify-content: flex-start;\n    -webkit-box-align: end;\n        -ms-flex-align: end;\n            align-items: flex-end;\n}\n.p-dialog-bottomright {\n    -webkit-box-pack: end;\n        -ms-flex-pack: end;\n            justify-content: flex-end;\n    -webkit-box-align: end;\n        -ms-flex-align: end;\n            align-items: flex-end;\n}\n.p-confirm-dialog .p-dialog-content {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n}\n"), a.render = function(e, t, i, a, d, r) {
        const p = n.resolveDirective("ripple");
        return n.openBlock(), n.createBlock(n.Teleport, {
            to: r.appendTarget,
            disabled: r.appendDisabled
        }, [d.containerVisible ? (n.openBlock(), n.createBlock("div", {
            key: 0,
            ref: r.maskRef,
            class: r.maskClass,
            onClick: t[4] || (t[4] = (...e) => r.onMaskClick && r.onMaskClick(...e))
        }, [n.createVNode(n.Transition, {
            name: "p-dialog",
            onBeforeEnter: r.onBeforeEnter,
            onEnter: r.onEnter,
            onBeforeLeave: r.onBeforeLeave,
            onLeave: r.onLeave,
            onAfterLeave: r.onAfterLeave,
            appear: ""
        }, {
            default: n.withCtx((() => [i.visible ? (n.openBlock(), n.createBlock("div", n.mergeProps({
                key: 0,
                ref: r.containerRef,
                class: r.dialogClass
            }, e.$attrs, {
                role: "dialog",
                "aria-labelledby": r.ariaLabelledById,
                "aria-modal": i.modal
            }), [i.showHeader ? (n.openBlock(), n.createBlock("div", {
                key: 0,
                class: "p-dialog-header",
                onMousedown: t[3] || (t[3] = (...e) => r.initDrag && r.initDrag(...e))
            }, [n.renderSlot(e.$slots, "header", {}, (() => [i.header ? (n.openBlock(), n.createBlock("span", {
                key: 0,
                id: r.ariaLabelledById,
                class: "p-dialog-title"
            }, n.toDisplayString(i.header), 9, ["id"])) : n.createCommentVNode("", !0)])), n.createVNode("div", o, [i.maximizable ? n.withDirectives((n.openBlock(), n.createBlock("button", {
                key: 0,
                class: "p-dialog-header-icon p-dialog-header-maximize p-link",
                onClick: t[1] || (t[1] = (...e) => r.maximize && r.maximize(...e)),
                type: "button",
                tabindex: "-1"
            }, [n.createVNode("span", {
                class: r.maximizeIconClass
            }, null, 2)], 512)), [
                [p]
            ]) : n.createCommentVNode("", !0), i.closable ? n.withDirectives((n.openBlock(), n.createBlock("button", {
                key: 1,
                class: "p-dialog-header-icon p-dialog-header-close p-link",
                onClick: t[2] || (t[2] = (...e) => r.close && r.close(...e)),
                "aria-label": i.ariaCloseLabel,
                type: "button",
                tabindex: "-1"
            }, [l], 8, ["aria-label"])), [
                [p]
            ]) : n.createCommentVNode("", !0)])], 32)) : n.createCommentVNode("", !0), n.createVNode("div", {
                class: r.contentStyleClass,
                style: i.contentStyle
            }, [n.renderSlot(e.$slots, "default")], 6), i.footer || e.$slots.footer ? (n.openBlock(), n.createBlock("div", s, [n.renderSlot(e.$slots, "footer", {}, (() => [n.createTextVNode(n.toDisplayString(i.footer), 1)]))])) : n.createCommentVNode("", !0)], 16, ["aria-labelledby", "aria-modal"])) : n.createCommentVNode("", !0)])),
            _: 3
        }, 8, ["onBeforeEnter", "onEnter", "onBeforeLeave", "onLeave", "onAfterLeave"])], 2)) : n.createCommentVNode("", !0)], 8, ["to", "disabled"])
    }, a
}(primevue.utils, primevue.ripple, Vue);

this.primevue = this.primevue || {}, this.primevue.paginator = function(e, t, n, a) {
    "use strict";

    function o(e) {
        return e && "object" == typeof e && "default" in e ? e : {
            default: e
        }
    }
    var r = o(t),
        i = o(n),
        s = o(a),
        p = {
            name: "CurrentPageReport",
            inheritAttrs: !1,
            props: {
                pageCount: {
                    type: Number,
                    default: 0
                },
                currentPage: {
                    type: Number,
                    default: 0
                },
                page: {
                    type: Number,
                    default: 0
                },
                first: {
                    type: Number,
                    default: 0
                },
                rows: {
                    type: Number,
                    default: 0
                },
                totalRecords: {
                    type: Number,
                    default: 0
                },
                template: {
                    type: String,
                    default: "({currentPage} of {totalPages})"
                }
            },
            computed: {
                text() {
                    return this.template.replace("{currentPage}", this.currentPage).replace("{totalPages}", this.pageCount).replace("{first}", this.pageCount > 0 ? this.first + 1 : 0).replace("{last}", Math.min(this.first + this.rows, this.totalRecords)).replace("{rows}", this.rows).replace("{totalRecords}", this.totalRecords)
                }
            }
        };
    const l = {
        class: "p-paginator-current"
    };
    p.render = function(t, n, a, o, r, i) {
        return e.openBlock(), e.createBlock("span", l, e.toDisplayString(i.text), 1)
    };
    var c = {
        name: "FirstPageLink",
        computed: {
            containerClass() {
                return ["p-paginator-first p-paginator-element p-link", {
                    "p-disabled": this.$attrs.disabled
                }]
            }
        },
        directives: {
            ripple: r.default
        }
    };
    const g = e.createVNode("span", {
        class: "p-paginator-icon pi pi-angle-double-left"
    }, null, -1);
    c.render = function(t, n, a, o, r, i) {
        const s = e.resolveDirective("ripple");
        return e.withDirectives((e.openBlock(), e.createBlock("button", {
            class: i.containerClass,
            type: "button"
        }, [g], 2)), [
            [s]
        ])
    };
    var u = {
        name: "LastPageLink",
        computed: {
            containerClass() {
                return ["p-paginator-last p-paginator-element p-link", {
                    "p-disabled": this.$attrs.disabled
                }]
            }
        },
        directives: {
            ripple: r.default
        }
    };
    const d = e.createVNode("span", {
        class: "p-paginator-icon pi pi-angle-double-right"
    }, null, -1);
    u.render = function(t, n, a, o, r, i) {
        const s = e.resolveDirective("ripple");
        return e.withDirectives((e.openBlock(), e.createBlock("button", {
            class: i.containerClass,
            type: "button"
        }, [d], 2)), [
            [s]
        ])
    };
    var h = {
        name: "NextPageLink",
        computed: {
            containerClass() {
                return ["p-paginator-next p-paginator-element p-link", {
                    "p-disabled": this.$attrs.disabled
                }]
            }
        },
        directives: {
            ripple: r.default
        }
    };
    const m = e.createVNode("span", {
        class: "p-paginator-icon pi pi-angle-right"
    }, null, -1);
    h.render = function(t, n, a, o, r, i) {
        const s = e.resolveDirective("ripple");
        return e.withDirectives((e.openBlock(), e.createBlock("button", {
            class: i.containerClass,
            type: "button"
        }, [m], 2)), [
            [s]
        ])
    };
    var k = {
        name: "PageLinks",
        inheritAttrs: !1,
        emits: ["click"],
        props: {
            value: Array,
            page: Number
        },
        methods: {
            onPageLinkClick(e, t) {
                this.$emit("click", {
                    originalEvent: e,
                    value: t
                })
            }
        },
        directives: {
            ripple: r.default
        }
    };
    const P = {
        class: "p-paginator-pages"
    };
    k.render = function(t, n, a, o, r, i) {
        const s = e.resolveDirective("ripple");
        return e.openBlock(), e.createBlock("span", P, [(e.openBlock(!0), e.createBlock(e.Fragment, null, e.renderList(a.value, (t => e.withDirectives((e.openBlock(), e.createBlock("button", {
            key: t,
            class: ["p-paginator-page p-paginator-element p-link", {
                "p-highlight": t - 1 === a.page
            }],
            type: "button",
            onClick: e => i.onPageLinkClick(e, t)
        }, [e.createTextVNode(e.toDisplayString(t), 1)], 10, ["onClick"])), [
            [s]
        ]))), 128))])
    };
    var f = {
        name: "PrevPageLink",
        computed: {
            containerClass() {
                return ["p-paginator-prev p-paginator-element p-link", {
                    "p-disabled": this.$attrs.disabled
                }]
            }
        },
        directives: {
            ripple: r.default
        }
    };
    const b = e.createVNode("span", {
        class: "p-paginator-icon pi pi-angle-left"
    }, null, -1);
    f.render = function(t, n, a, o, r, i) {
        const s = e.resolveDirective("ripple");
        return e.withDirectives((e.openBlock(), e.createBlock("button", {
            class: i.containerClass,
            type: "button"
        }, [b], 2)), [
            [s]
        ])
    };
    var v = {
        name: "RowsPerPageDropdown",
        inheritAttrs: !1,
        emits: ["rows-change"],
        props: {
            options: Array,
            rows: Number,
            disabled: Boolean
        },
        methods: {
            onChange(e) {
                this.$emit("rows-change", e)
            }
        },
        computed: {
            rowsOptions() {
                let e = [];
                if (this.options)
                    for (let t = 0; t < this.options.length; t++) e.push({
                        label: String(this.options[t]),
                        value: this.options[t]
                    });
                return e
            }
        },
        components: {
            RPPDropdown: i.default
        }
    };
    v.render = function(t, n, a, o, r, i) {
        const s = e.resolveComponent("RPPDropdown");
        return e.openBlock(), e.createBlock(s, {
            modelValue: a.rows,
            options: i.rowsOptions,
            optionLabel: "label",
            optionValue: "value",
            "onUpdate:modelValue": n[1] || (n[1] = e => i.onChange(e)),
            class: "p-paginator-rpp-options",
            disabled: a.disabled
        }, null, 8, ["modelValue", "options", "disabled"])
    };
    var w = {
        name: "JumpToPageDropdown",
        inheritAttrs: !1,
        emits: ["page-change"],
        props: {
            page: Number,
            pageCount: Number,
            disabled: Boolean
        },
        methods: {
            onChange(e) {
                this.$emit("page-change", e)
            }
        },
        computed: {
            pageOptions() {
                let e = [];
                for (let t = 0; t < this.pageCount; t++) e.push({
                    label: String(t + 1),
                    value: t
                });
                return e
            }
        },
        components: {
            JTPDropdown: i.default
        }
    };
    w.render = function(t, n, a, o, r, i) {
        const s = e.resolveComponent("JTPDropdown");
        return e.openBlock(), e.createBlock(s, {
            modelValue: a.page,
            options: i.pageOptions,
            optionLabel: "label",
            optionValue: "value",
            "onUpdate:modelValue": n[1] || (n[1] = e => i.onChange(e)),
            class: "p-paginator-page-options",
            disabled: a.disabled
        }, null, 8, ["modelValue", "options", "disabled"])
    };
    var C = {
        name: "JumpToPageInput",
        inheritAttrs: !1,
        emits: ["page-change"],
        props: {
            page: Number,
            pageCount: Number,
            disabled: Boolean
        },
        methods: {
            onChange(e) {
                this.$emit("page-change", e - 1)
            }
        },
        components: {
            JTPInput: s.default
        }
    };
    C.render = function(t, n, a, o, r, i) {
        const s = e.resolveComponent("JTPInput");
        return e.openBlock(), e.createBlock(s, {
            modelValue: a.page,
            "onUpdate:modelValue": n[1] || (n[1] = e => i.onChange(e)),
            class: "p-paginator-page-input",
            disabled: a.disabled
        }, null, 8, ["modelValue", "disabled"])
    };
    var y = {
        name: "Paginator",
        emits: ["update:first", "update:rows", "page"],
        props: {
            totalRecords: {
                type: Number,
                default: 0
            },
            rows: {
                type: Number,
                default: 0
            },
            first: {
                type: Number,
                default: 0
            },
            pageLinkSize: {
                type: Number,
                default: 5
            },
            rowsPerPageOptions: {
                type: Array,
                default: null
            },
            template: {
                type: String,
                default: "FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown"
            },
            currentPageReportTemplate: {
                type: null,
                default: "({currentPage} of {totalPages})"
            },
            alwaysShow: {
                type: Boolean,
                default: !0
            }
        },
        data() {
            return {
                d_first: this.first,
                d_rows: this.rows
            }
        },
        watch: {
            first(e) {
                this.d_first = e
            },
            rows(e) {
                this.d_rows = e
            },
            totalRecords(e) {
                this.page > 0 && e && this.d_first >= e && this.changePage(this.pageCount - 1)
            }
        },
        methods: {
            changePage(e) {
                const t = this.pageCount;
                if (e >= 0 && e < t) {
                    this.d_first = this.d_rows * e;
                    const n = {
                        page: e,
                        first: this.d_first,
                        rows: this.d_rows,
                        pageCount: t
                    };
                    this.$emit("update:first", this.d_first), this.$emit("update:rows", this.d_rows), this.$emit("page", n)
                }
            },
            changePageToFirst(e) {
                this.isFirstPage || this.changePage(0), e.preventDefault()
            },
            changePageToPrev(e) {
                this.changePage(this.page - 1), e.preventDefault()
            },
            changePageLink(e) {
                this.changePage(e.value - 1), e.originalEvent.preventDefault()
            },
            changePageToNext(e) {
                this.changePage(this.page + 1), e.preventDefault()
            },
            changePageToLast(e) {
                this.isLastPage || this.changePage(this.pageCount - 1), e.preventDefault()
            },
            onRowChange(e) {
                this.d_rows = e, this.changePage(this.page)
            }
        },
        computed: {
            templateItems() {
                let e = [];
                return this.template.split(" ").map((t => {
                    e.push(t.trim())
                })), e
            },
            page() {
                return Math.floor(this.d_first / this.d_rows)
            },
            pageCount() {
                return Math.ceil(this.totalRecords / this.d_rows)
            },
            isFirstPage() {
                return 0 === this.page
            },
            isLastPage() {
                return this.page === this.pageCount - 1
            },
            calculatePageLinkBoundaries() {
                const e = this.pageCount,
                    t = Math.min(this.pageLinkSize, e);
                let n = Math.max(0, Math.ceil(this.page - t / 2)),
                    a = Math.min(e - 1, n + t - 1);
                const o = this.pageLinkSize - (a - n + 1);
                return n = Math.max(0, n - o), [n, a]
            },
            pageLinks() {
                let e = [],
                    t = this.calculatePageLinkBoundaries,
                    n = t[0],
                    a = t[1];
                for (var o = n; o <= a; o++) e.push(o + 1);
                return e
            },
            currentState() {
                return {
                    page: this.page,
                    first: this.d_first,
                    rows: this.d_rows
                }
            },
            empty() {
                return 0 === this.pageCount
            },
            currentPage() {
                return this.pageCount > 0 ? this.page + 1 : 0
            }
        },
        components: {
            CurrentPageReport: p,
            FirstPageLink: c,
            LastPageLink: u,
            NextPageLink: h,
            PageLinks: k,
            PrevPageLink: f,
            RowsPerPageDropdown: v,
            JumpToPageDropdown: w,
            JumpToPageInput: C
        }
    };
    const B = {
            key: 0,
            class: "p-paginator p-component"
        },
        L = {
            key: 0,
            class: "p-paginator-left-content"
        },
        x = {
            key: 1,
            class: "p-paginator-right-content"
        };
    return function(e, t) {
        void 0 === t && (t = {});
        var n = t.insertAt;
        if (e && "undefined" != typeof document) {
            var a = document.head || document.getElementsByTagName("head")[0],
                o = document.createElement("style");
            o.type = "text/css", "top" === n && a.firstChild ? a.insertBefore(o, a.firstChild) : a.appendChild(o), o.styleSheet ? o.styleSheet.cssText = e : o.appendChild(document.createTextNode(e))
        }
    }("\n.p-paginator {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    -ms-flex-wrap: wrap;\n        flex-wrap: wrap;\n}\n.p-paginator-left-content {\n\tmargin-right: auto;\n}\n.p-paginator-right-content {\n\tmargin-left: auto;\n}\n.p-paginator-page,\n.p-paginator-next,\n.p-paginator-last,\n.p-paginator-first,\n.p-paginator-prev,\n.p-paginator-current {\n    cursor: pointer;\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    line-height: 1;\n    -webkit-user-select: none;\n       -moz-user-select: none;\n        -ms-user-select: none;\n            user-select: none;\n    overflow: hidden;\n    position: relative;\n}\n.p-paginator-element:focus {\n    z-index: 1;\n    position: relative;\n}\n"), y.render = function(t, n, a, o, r, i) {
        const s = e.resolveComponent("FirstPageLink"),
            p = e.resolveComponent("PrevPageLink"),
            l = e.resolveComponent("NextPageLink"),
            c = e.resolveComponent("LastPageLink"),
            g = e.resolveComponent("PageLinks"),
            u = e.resolveComponent("CurrentPageReport"),
            d = e.resolveComponent("RowsPerPageDropdown"),
            h = e.resolveComponent("JumpToPageDropdown"),
            m = e.resolveComponent("JumpToPageInput");
        return a.alwaysShow || i.pageLinks && i.pageLinks.length > 1 ? (e.openBlock(), e.createBlock("div", B, [t.$slots.left ? (e.openBlock(), e.createBlock("div", L, [e.renderSlot(t.$slots, "left", {
            state: i.currentState
        })])) : e.createCommentVNode("", !0), (e.openBlock(!0), e.createBlock(e.Fragment, null, e.renderList(i.templateItems, (t => (e.openBlock(), e.createBlock(e.Fragment, {
            key: t
        }, ["FirstPageLink" === t ? (e.openBlock(), e.createBlock(s, {
            key: 0,
            onClick: n[1] || (n[1] = e => i.changePageToFirst(e)),
            disabled: i.isFirstPage || i.empty
        }, null, 8, ["disabled"])) : "PrevPageLink" === t ? (e.openBlock(), e.createBlock(p, {
            key: 1,
            onClick: n[2] || (n[2] = e => i.changePageToPrev(e)),
            disabled: i.isFirstPage || i.empty
        }, null, 8, ["disabled"])) : "NextPageLink" === t ? (e.openBlock(), e.createBlock(l, {
            key: 2,
            onClick: n[3] || (n[3] = e => i.changePageToNext(e)),
            disabled: i.isLastPage || i.empty
        }, null, 8, ["disabled"])) : "LastPageLink" === t ? (e.openBlock(), e.createBlock(c, {
            key: 3,
            onClick: n[4] || (n[4] = e => i.changePageToLast(e)),
            disabled: i.isLastPage || i.empty
        }, null, 8, ["disabled"])) : "PageLinks" === t ? (e.openBlock(), e.createBlock(g, {
            key: 4,
            value: i.pageLinks,
            page: i.page,
            onClick: n[5] || (n[5] = e => i.changePageLink(e))
        }, null, 8, ["value", "page"])) : "CurrentPageReport" === t ? (e.openBlock(), e.createBlock(u, {
            key: 5,
            template: a.currentPageReportTemplate,
            currentPage: i.currentPage,
            page: i.page,
            pageCount: i.pageCount,
            first: r.d_first,
            rows: r.d_rows,
            totalRecords: a.totalRecords
        }, null, 8, ["template", "currentPage", "page", "pageCount", "first", "rows", "totalRecords"])) : "RowsPerPageDropdown" === t && a.rowsPerPageOptions ? (e.openBlock(), e.createBlock(d, {
            key: 6,
            rows: r.d_rows,
            options: a.rowsPerPageOptions,
            onRowsChange: n[6] || (n[6] = e => i.onRowChange(e)),
            disabled: i.empty
        }, null, 8, ["rows", "options", "disabled"])) : "JumpToPageDropdown" === t ? (e.openBlock(), e.createBlock(h, {
            key: 7,
            page: i.page,
            pageCount: i.pageCount,
            onPageChange: n[7] || (n[7] = e => i.changePage(e)),
            disabled: i.empty
        }, null, 8, ["page", "pageCount", "disabled"])) : "JumpToPageInput" === t ? (e.openBlock(), e.createBlock(m, {
            key: 8,
            page: i.currentPage,
            onPageChange: n[8] || (n[8] = e => i.changePage(e)),
            disabled: i.empty
        }, null, 8, ["page", "disabled"])) : e.createCommentVNode("", !0)], 64)))), 128)), t.$slots.right ? (e.openBlock(), e.createBlock("div", x, [e.renderSlot(t.$slots, "right", {
            state: i.currentState
        })])) : e.createCommentVNode("", !0)])) : e.createCommentVNode("", !0)
    }, y
}(Vue, primevue.ripple, primevue.dropdown, primevue.inputnumber);

this.primevue = this.primevue || {}, this.primevue.tree = function(e, t, n) {
    "use strict";

    function l(e) {
        return e && "object" == typeof e && "default" in e ? e : {
            default: e
        }
    }
    var i = {
        name: "TreeNode",
        emits: ["node-toggle", "node-click", "checkbox-change"],
        props: {
            node: {
                type: null,
                default: null
            },
            expandedKeys: {
                type: null,
                default: null
            },
            selectionKeys: {
                type: null,
                default: null
            },
            selectionMode: {
                type: String,
                default: null
            },
            templates: {
                type: null,
                default: null
            }
        },
        nodeTouched: !1,
        methods: {
            toggle() {
                this.$emit("node-toggle", this.node)
            },
            onChildNodeToggle(e) {
                this.$emit("node-toggle", e)
            },
            onClick(t) {
                e.DomHandler.hasClass(t.target, "p-tree-toggler") || e.DomHandler.hasClass(t.target.parentElement, "p-tree-toggler") || (this.isCheckboxSelectionMode() ? this.toggleCheckbox() : this.$emit("node-click", {
                    originalEvent: t,
                    nodeTouched: this.nodeTouched,
                    node: this.node
                }), this.nodeTouched = !1)
            },
            onChildNodeClick(e) {
                this.$emit("node-click", e)
            },
            onTouchEnd() {
                this.nodeTouched = !0
            },
            onKeyDown(e) {
                const t = e.target.parentElement;
                switch (e.which) {
                    case 40:
                        var n = t.children[1];
                        if (n) this.focusNode(n.children[0]);
                        else {
                            const e = t.nextElementSibling;
                            if (e) this.focusNode(e);
                            else {
                                let e = this.findNextSiblingOfAncestor(t);
                                e && this.focusNode(e)
                            }
                        }
                        e.preventDefault();
                        break;
                    case 38:
                        if (t.previousElementSibling) this.focusNode(this.findLastVisibleDescendant(t.previousElementSibling));
                        else {
                            let e = this.getParentNodeElement(t);
                            e && this.focusNode(e)
                        }
                        e.preventDefault();
                        break;
                    case 37:
                    case 39:
                        this.$emit("node-toggle", this.node), e.preventDefault();
                        break;
                    case 13:
                        this.onClick(e), e.preventDefault()
                }
            },
            toggleCheckbox() {
                let e = this.selectionKeys ? {
                    ...this.selectionKeys
                } : {};
                const t = !this.checked;
                this.propagateDown(this.node, t, e), this.$emit("checkbox-change", {
                    node: this.node,
                    check: t,
                    selectionKeys: e
                })
            },
            propagateDown(e, t, n) {
                if (t ? n[e.key] = {
                        checked: !0,
                        partialChecked: !1
                    } : delete n[e.key], e.children && e.children.length)
                    for (let l of e.children) this.propagateDown(l, t, n)
            },
            propagateUp(e) {
                let t = e.check,
                    n = {
                        ...e.selectionKeys
                    },
                    l = 0,
                    i = !1;
                for (let e of this.node.children) n[e.key] && n[e.key].checked ? l++ : n[e.key] && n[e.key].partialChecked && (i = !0);
                t && l === this.node.children.length ? n[this.node.key] = {
                    checked: !0,
                    partialChecked: !1
                } : (t || delete n[this.node.key], i || l > 0 && l !== this.node.children.length ? n[this.node.key] = {
                    checked: !1,
                    partialChecked: !0
                } : delete n[this.node.key]), this.$emit("checkbox-change", {
                    node: e.node,
                    check: e.check,
                    selectionKeys: n
                })
            },
            onChildCheckboxChange(e) {
                this.$emit("checkbox-change", e)
            },
            findNextSiblingOfAncestor(e) {
                let t = this.getParentNodeElement(e);
                return t ? t.nextElementSibling ? t.nextElementSibling : this.findNextSiblingOfAncestor(t) : null
            },
            findLastVisibleDescendant(e) {
                const t = e.children[1];
                if (t) {
                    const e = t.children[t.children.length - 1];
                    return this.findLastVisibleDescendant(e)
                }
                return e
            },
            getParentNodeElement(t) {
                const n = t.parentElement.parentElement;
                return e.DomHandler.hasClass(n, "p-treenode") ? n : null
            },
            focusNode(e) {
                e.children[0].focus()
            },
            isCheckboxSelectionMode() {
                return "checkbox" === this.selectionMode
            }
        },
        computed: {
            hasChildren() {
                return this.node.children && this.node.children.length > 0
            },
            expanded() {
                return this.expandedKeys && !0 === this.expandedKeys[this.node.key]
            },
            leaf() {
                return !1 !== this.node.leaf && !(this.node.children && this.node.children.length)
            },
            selectable() {
                return !1 !== this.node.selectable && null != this.selectionMode
            },
            selected() {
                return !(!this.selectionMode || !this.selectionKeys) && !0 === this.selectionKeys[this.node.key]
            },
            containerClass() {
                return ["p-treenode", {
                    "p-treenode-leaf": this.leaf
                }]
            },
            contentClass() {
                return ["p-treenode-content", this.node.styleClass, {
                    "p-treenode-selectable": this.selectable,
                    "p-highlight": this.checkboxMode ? this.checked : this.selected
                }]
            },
            icon() {
                return ["p-treenode-icon", this.node.icon]
            },
            toggleIcon() {
                return ["p-tree-toggler-icon pi pi-fw", {
                    "pi-chevron-down": this.expanded,
                    "pi-chevron-right": !this.expanded
                }]
            },
            checkboxClass() {
                return ["p-checkbox-box", {
                    "p-highlight": this.checked,
                    "p-indeterminate": this.partialChecked
                }]
            },
            checkboxIcon() {
                return ["p-checkbox-icon", {
                    "pi pi-check": this.checked,
                    "pi pi-minus": this.partialChecked
                }]
            },
            checkboxMode() {
                return "checkbox" === this.selectionMode && !1 !== this.node.selectable
            },
            checked() {
                return !!this.selectionKeys && (this.selectionKeys[this.node.key] && this.selectionKeys[this.node.key].checked)
            },
            partialChecked() {
                return !!this.selectionKeys && (this.selectionKeys[this.node.key] && this.selectionKeys[this.node.key].partialChecked)
            }
        },
        directives: {
            ripple: l(t).default
        }
    };
    const o = {
            key: 0,
            class: "p-checkbox p-component"
        },
        s = {
            class: "p-treenode-label"
        },
        c = {
            key: 0,
            class: "p-treenode-children",
            role: "group"
        };
    i.render = function(e, t, l, i, d, r) {
        const a = n.resolveComponent("TreeNode", !0),
            h = n.resolveDirective("ripple");
        return n.openBlock(), n.createBlock("li", {
            class: r.containerClass
        }, [n.createVNode("div", {
            class: r.contentClass,
            tabindex: "0",
            role: "treeitem",
            "aria-expanded": r.expanded,
            onClick: t[2] || (t[2] = (...e) => r.onClick && r.onClick(...e)),
            onKeydown: t[3] || (t[3] = (...e) => r.onKeyDown && r.onKeyDown(...e)),
            onTouchend: t[4] || (t[4] = (...e) => r.onTouchEnd && r.onTouchEnd(...e)),
            style: l.node.style
        }, [n.withDirectives(n.createVNode("button", {
            type: "button",
            class: "p-tree-toggler p-link",
            onClick: t[1] || (t[1] = (...e) => r.toggle && r.toggle(...e)),
            tabindex: "-1"
        }, [n.createVNode("span", {
            class: r.toggleIcon
        }, null, 2)], 512), [
            [h]
        ]), r.checkboxMode ? (n.openBlock(), n.createBlock("div", o, [n.createVNode("div", {
            class: r.checkboxClass,
            role: "checkbox",
            "aria-checked": r.checked
        }, [n.createVNode("span", {
            class: r.checkboxIcon
        }, null, 2)], 10, ["aria-checked"])])) : n.createCommentVNode("", !0), n.createVNode("span", {
            class: r.icon
        }, null, 2), n.createVNode("span", s, [l.templates[l.node.type] || l.templates.default ? (n.openBlock(), n.createBlock(n.resolveDynamicComponent(l.templates[l.node.type] || l.templates.default), {
            key: 0,
            node: l.node
        }, null, 8, ["node"])) : (n.openBlock(), n.createBlock(n.Fragment, {
            key: 1
        }, [n.createTextVNode(n.toDisplayString(l.node.label), 1)], 64))])], 46, ["aria-expanded"]), r.hasChildren && r.expanded ? (n.openBlock(), n.createBlock("ul", c, [(n.openBlock(!0), n.createBlock(n.Fragment, null, n.renderList(l.node.children, (e => (n.openBlock(), n.createBlock(a, {
            key: e.key,
            node: e,
            templates: l.templates,
            expandedKeys: l.expandedKeys,
            onNodeToggle: r.onChildNodeToggle,
            onNodeClick: r.onChildNodeClick,
            selectionMode: l.selectionMode,
            selectionKeys: l.selectionKeys,
            onCheckboxChange: r.propagateUp
        }, null, 8, ["node", "templates", "expandedKeys", "onNodeToggle", "onNodeClick", "selectionMode", "selectionKeys", "onCheckboxChange"])))), 128))])) : n.createCommentVNode("", !0)], 2)
    };
    var d = {
        name: "Tree",
        emits: ["node-expand", "node-collapse", "update:expandedKeys", "update:selectionKeys", "node-select", "node-unselect"],
        props: {
            value: {
                type: null,
                default: null
            },
            expandedKeys: {
                type: null,
                default: null
            },
            selectionKeys: {
                type: null,
                default: null
            },
            selectionMode: {
                type: String,
                default: null
            },
            metaKeySelection: {
                type: Boolean,
                default: !0
            },
            loading: {
                type: Boolean,
                default: !1
            },
            loadingIcon: {
                type: String,
                default: "pi pi-spinner"
            },
            filter: {
                type: Boolean,
                default: !1
            },
            filterBy: {
                type: String,
                default: "label"
            },
            filterMode: {
                type: String,
                default: "lenient"
            },
            filterPlaceholder: {
                type: String,
                default: null
            },
            filterLocale: {
                type: String,
                default: void 0
            },
            scrollHeight: {
                type: String,
                default: null
            }
        },
        data() {
            return {
                d_expandedKeys: this.expandedKeys || {},
                filterValue: null
            }
        },
        watch: {
            expandedKeys(e) {
                this.d_expandedKeys = e
            }
        },
        methods: {
            onNodeToggle(e) {
                const t = e.key;
                this.d_expandedKeys[t] ? (delete this.d_expandedKeys[t], this.$emit("node-collapse", e)) : (this.d_expandedKeys[t] = !0, this.$emit("node-expand", e)), this.d_expandedKeys = {
                    ...this.d_expandedKeys
                }, this.$emit("update:expandedKeys", this.d_expandedKeys)
            },
            onNodeClick(e) {
                if (null != this.selectionMode && !1 !== e.node.selectable) {
                    const t = !e.nodeTouched && this.metaKeySelection ? this.handleSelectionWithMetaKey(e) : this.handleSelectionWithoutMetaKey(e);
                    this.$emit("update:selectionKeys", t)
                }
            },
            onCheckboxChange(e) {
                this.$emit("update:selectionKeys", e.selectionKeys), e.check ? this.$emit("node-select", e.node) : this.$emit("node-unselect", e.node)
            },
            handleSelectionWithMetaKey(e) {
                const t = e.originalEvent,
                    n = e.node,
                    l = t.metaKey || t.ctrlKey;
                let i;
                return this.isNodeSelected(n) && l ? (this.isSingleSelectionMode() ? i = {} : (i = {
                    ...this.selectionKeys
                }, delete i[n.key]), this.$emit("node-unselect", n)) : (this.isSingleSelectionMode() ? i = {} : this.isMultipleSelectionMode() && (i = l && this.selectionKeys ? {
                    ...this.selectionKeys
                } : {}), i[n.key] = !0, this.$emit("node-select", n)), i
            },
            handleSelectionWithoutMetaKey(e) {
                const t = e.node,
                    n = this.isNodeSelected(t);
                let l;
                return this.isSingleSelectionMode() ? n ? (l = {}, this.$emit("node-unselect", t)) : (l = {}, l[t.key] = !0, this.$emit("node-select", t)) : n ? (l = {
                    ...this.selectionKeys
                }, delete l[t.key], this.$emit("node-unselect", t)) : (l = this.selectionKeys ? {
                    ...this.selectionKeys
                } : {}, l[t.key] = !0, this.$emit("node-select", t)), l
            },
            isSingleSelectionMode() {
                return "single" === this.selectionMode
            },
            isMultipleSelectionMode() {
                return "multiple" === this.selectionMode
            },
            isNodeSelected(e) {
                return !(!this.selectionMode || !this.selectionKeys) && !0 === this.selectionKeys[e.key]
            },
            isChecked(e) {
                return !!this.selectionKeys && (this.selectionKeys[e.key] && this.selectionKeys[e.key].checked)
            },
            isNodeLeaf: e => !1 !== e.leaf && !(e.children && e.children.length),
            onFilterKeydown(e) {
                13 === e.which && e.preventDefault()
            },
            findFilteredNodes(e, t) {
                if (e) {
                    let n = !1;
                    if (e.children) {
                        let l = [...e.children];
                        e.children = [];
                        for (let i of l) {
                            let l = {
                                ...i
                            };
                            this.isFilterMatched(l, t) && (n = !0, e.children.push(l))
                        }
                    }
                    if (n) return !0
                }
            },
            isFilterMatched(t, {
                searchFields: n,
                filterText: l,
                strict: i
            }) {
                let o = !1;
                for (let i of n) {
                    String(e.ObjectUtils.resolveFieldData(t, i)).toLocaleLowerCase(this.filterLocale).indexOf(l) > -1 && (o = !0)
                }
                return (!o || i && !this.isNodeLeaf(t)) && (o = this.findFilteredNodes(t, {
                    searchFields: n,
                    filterText: l,
                    strict: i
                }) || o), o
            }
        },
        computed: {
            containerClass() {
                return ["p-tree p-component", {
                    "p-tree-selectable": null != this.selectionMode,
                    "p-tree-loading": this.loading,
                    "p-tree-flex-scrollable": "flex" === this.scrollHeight
                }]
            },
            loadingIconClass() {
                return ["p-tree-loading-icon pi-spin", this.loadingIcon]
            },
            filteredValue() {
                let e = [];
                const t = this.filterBy.split(","),
                    n = this.filterValue.trim().toLocaleLowerCase(this.filterLocale),
                    l = "strict" === this.filterMode;
                for (let i of this.value) {
                    let o = {
                            ...i
                        },
                        s = {
                            searchFields: t,
                            filterText: n,
                            strict: l
                        };
                    (l && (this.findFilteredNodes(o, s) || this.isFilterMatched(o, s)) || !l && (this.isFilterMatched(o, s) || this.findFilteredNodes(o, s))) && e.push(o)
                }
                return e
            },
            valueToRender() {
                return this.filterValue && this.filterValue.trim().length > 0 ? this.filteredValue : this.value
            }
        },
        components: {
            TreeNode: i
        }
    };
    const r = {
            key: 0,
            class: "p-tree-loading-overlay p-component-overlay"
        },
        a = {
            key: 1,
            class: "p-tree-filter-container"
        },
        h = n.createVNode("span", {
            class: "p-tree-filter-icon pi pi-search"
        }, null, -1),
        p = {
            class: "p-tree-container",
            role: "tree"
        };
    return function(e, t) {
        void 0 === t && (t = {});
        var n = t.insertAt;
        if (e && "undefined" != typeof document) {
            var l = document.head || document.getElementsByTagName("head")[0],
                i = document.createElement("style");
            i.type = "text/css", "top" === n && l.firstChild ? l.insertBefore(i, l.firstChild) : l.appendChild(i), i.styleSheet ? i.styleSheet.cssText = e : i.appendChild(document.createTextNode(e))
        }
    }("\n.p-tree-container {\n    margin: 0;\n    padding: 0;\n    list-style-type: none;\n    overflow: auto;\n}\n.p-treenode-children {\n    margin: 0;\n    padding: 0;\n    list-style-type: none;\n}\n.p-tree-wrapper {\n    overflow: auto;\n}\n.p-treenode-selectable {\n    cursor: pointer;\n    -webkit-user-select: none;\n       -moz-user-select: none;\n        -ms-user-select: none;\n            user-select: none;\n}\n.p-tree-toggler {\n    cursor: pointer;\n    -webkit-user-select: none;\n       -moz-user-select: none;\n        -ms-user-select: none;\n            user-select: none;\n    display: -webkit-inline-box;\n    display: -ms-inline-flexbox;\n    display: inline-flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n    overflow: hidden;\n    position: relative;\n}\n.p-treenode-leaf > .p-treenode-content .p-tree-toggler {\n    visibility: hidden;\n}\n.p-treenode-content {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n}\n.p-tree-filter {\n    width: 100%;\n}\n.p-tree-filter-container {\n    position: relative;\n    display: block;\n    width: 100%;\n}\n.p-tree-filter-icon {\n    position: absolute;\n    top: 50%;\n    margin-top: -.5rem;\n}\n.p-tree-loading {\n    position: relative;\n    min-height: 4rem;\n}\n.p-tree .p-tree-loading-overlay {\n    position: absolute;\n    z-index: 1;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    -webkit-box-pack: center;\n        -ms-flex-pack: center;\n            justify-content: center;\n}\n.p-tree-flex-scrollable {\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-flex: 1;\n        -ms-flex: 1;\n            flex: 1;\n    height: 100%;\n    -webkit-box-orient: vertical;\n    -webkit-box-direction: normal;\n        -ms-flex-direction: column;\n            flex-direction: column;\n}\n.p-tree-flex-scrollable .p-tree-wrapper {\n    -webkit-box-flex: 1;\n        -ms-flex: 1;\n            flex: 1;\n}\n"), d.render = function(e, t, l, i, o, s) {
        const c = n.resolveComponent("TreeNode");
        return n.openBlock(), n.createBlock("div", {
            class: s.containerClass
        }, [l.loading ? (n.openBlock(), n.createBlock("div", r, [n.createVNode("i", {
            class: s.loadingIconClass
        }, null, 2)])) : n.createCommentVNode("", !0), l.filter ? (n.openBlock(), n.createBlock("div", a, [n.withDirectives(n.createVNode("input", {
            type: "text",
            autocomplete: "off",
            class: "p-tree-filter p-inputtext p-component",
            placeholder: l.filterPlaceholder,
            onKeydown: t[1] || (t[1] = (...e) => s.onFilterKeydown && s.onFilterKeydown(...e)),
            "onUpdate:modelValue": t[2] || (t[2] = e => o.filterValue = e)
        }, null, 40, ["placeholder"]), [
            [n.vModelText, o.filterValue]
        ]), h])) : n.createCommentVNode("", !0), n.createVNode("div", {
            class: "p-tree-wrapper",
            style: {
                maxHeight: l.scrollHeight
            }
        }, [n.createVNode("ul", p, [(n.openBlock(!0), n.createBlock(n.Fragment, null, n.renderList(s.valueToRender, (t => (n.openBlock(), n.createBlock(c, {
            key: t.key,
            node: t,
            templates: e.$slots,
            expandedKeys: o.d_expandedKeys,
            onNodeToggle: s.onNodeToggle,
            onNodeClick: s.onNodeClick,
            selectionMode: l.selectionMode,
            selectionKeys: l.selectionKeys,
            onCheckboxChange: s.onCheckboxChange
        }, null, 8, ["node", "templates", "expandedKeys", "onNodeToggle", "onNodeClick", "selectionMode", "selectionKeys", "onCheckboxChange"])))), 128))])], 4)], 2)
    }, d
}(primevue.utils, primevue.ripple, Vue);

this.primevue = this.primevue || {}, this.primevue.menu = function(e, t, i, n) {
    "use strict";

    function l(e) {
        return e && "object" == typeof e && "default" in e ? e : {
            default: e
        }
    }
    var s = l(t),
        r = {
            name: "Menuitem",
            inheritAttrs: !1,
            emits: ["click"],
            props: {
                item: null,
                template: null,
                exact: null
            },
            methods: {
                onClick(e, t) {
                    this.$emit("click", {
                        originalEvent: e,
                        item: this.item,
                        navigate: t
                    })
                },
                linkClass(e, t) {
                    return ["p-menuitem-link", {
                        "p-disabled": this.disabled(e),
                        "router-link-active": t && t.isActive,
                        "router-link-active-exact": this.exact && t && t.isExactActive
                    }]
                },
                visible() {
                    return "function" == typeof this.item.visible ? this.item.visible() : !1 !== this.item.visible
                },
                disabled: e => "function" == typeof e.disabled ? e.disabled() : e.disabled
            },
            computed: {
                containerClass() {
                    return ["p-menuitem", this.item.class]
                }
            },
            directives: {
                ripple: l(i).default
            }
        };
    const o = {
            class: "p-menuitem-text"
        },
        a = {
            class: "p-menuitem-text"
        };
    r.render = function(e, t, i, l, s, r) {
        const c = n.resolveComponent("router-link"),
            d = n.resolveDirective("ripple");
        return r.visible() ? (n.openBlock(), n.createBlock("li", {
            key: 0,
            class: r.containerClass,
            role: "none",
            style: i.item.style
        }, [i.template ? (n.openBlock(), n.createBlock(n.resolveDynamicComponent(i.template), {
            key: 1,
            item: i.item
        }, null, 8, ["item"])) : (n.openBlock(), n.createBlock(n.Fragment, {
            key: 0
        }, [i.item.to && !r.disabled(i.item) ? (n.openBlock(), n.createBlock(c, {
            key: 0,
            to: i.item.to,
            custom: ""
        }, {
            default: n.withCtx((({
                navigate: e,
                href: t,
                isActive: l,
                isExactActive: s
            }) => [n.withDirectives(n.createVNode("a", {
                href: t,
                onClick: t => r.onClick(t, e),
                class: r.linkClass(i.item, {
                    isActive: l,
                    isExactActive: s
                }),
                role: "menuitem"
            }, [n.createVNode("span", {
                class: ["p-menuitem-icon", i.item.icon]
            }, null, 2), n.createVNode("span", o, n.toDisplayString(i.item.label), 1)], 10, ["href", "onClick"]), [
                [d]
            ])])),
            _: 1
        }, 8, ["to"])) : n.withDirectives((n.openBlock(), n.createBlock("a", {
            key: 1,
            href: i.item.url,
            class: r.linkClass(i.item),
            onClick: t[1] || (t[1] = (...e) => r.onClick && r.onClick(...e)),
            target: i.item.target,
            role: "menuitem",
            tabindex: r.disabled(i.item) ? null : "0"
        }, [n.createVNode("span", {
            class: ["p-menuitem-icon", i.item.icon]
        }, null, 2), n.createVNode("span", a, n.toDisplayString(i.item.label), 1)], 10, ["href", "target", "tabindex"])), [
            [d]
        ])], 64))], 6)) : n.createCommentVNode("", !0)
    };
    var c = {
        name: "Menu",
        emits: ["show", "hide"],
        inheritAttrs: !1,
        props: {
            popup: {
                type: Boolean,
                default: !1
            },
            model: {
                type: Array,
                default: null
            },
            appendTo: {
                type: String,
                default: "body"
            },
            autoZIndex: {
                type: Boolean,
                default: !0
            },
            baseZIndex: {
                type: Number,
                default: 0
            },
            exact: {
                type: Boolean,
                default: !0
            }
        },
        data: () => ({
            overlayVisible: !1
        }),
        target: null,
        outsideClickListener: null,
        scrollHandler: null,
        resizeListener: null,
        container: null,
        beforeUnmount() {
            this.unbindResizeListener(), this.unbindOutsideClickListener(), this.scrollHandler && (this.scrollHandler.destroy(), this.scrollHandler = null), this.target = null, this.container && this.autoZIndex && e.ZIndexUtils.clear(this.container), this.container = null
        },
        methods: {
            itemClick(e) {
                const t = e.item;
                t.disabled || (t.command && t.command(e), t.to && e.navigate && e.navigate(e.originalEvent), this.hide())
            },
            toggle(e) {
                this.overlayVisible ? this.hide() : this.show(e)
            },
            show(e) {
                this.overlayVisible = !0, this.target = e.currentTarget
            },
            hide() {
                this.overlayVisible = !1, this.target = null
            },
            onEnter(t) {
                this.alignOverlay(), this.bindOutsideClickListener(), this.bindResizeListener(), this.bindScrollListener(), this.autoZIndex && e.ZIndexUtils.set("menu", t, this.baseZIndex + this.$primevue.config.zIndex.menu), this.$emit("show")
            },
            onLeave() {
                this.unbindOutsideClickListener(), this.unbindResizeListener(), this.unbindScrollListener(), this.$emit("hide")
            },
            onAfterLeave(t) {
                this.autoZIndex && e.ZIndexUtils.clear(t)
            },
            alignOverlay() {
                e.DomHandler.absolutePosition(this.container, this.target), this.container.style.minWidth = e.DomHandler.getOuterWidth(this.target) + "px"
            },
            bindOutsideClickListener() {
                this.outsideClickListener || (this.outsideClickListener = e => {
                    this.overlayVisible && this.container && !this.container.contains(e.target) && !this.isTargetClicked(e) && this.hide()
                }, document.addEventListener("click", this.outsideClickListener))
            },
            unbindOutsideClickListener() {
                this.outsideClickListener && (document.removeEventListener("click", this.outsideClickListener), this.outsideClickListener = null)
            },
            bindScrollListener() {
                this.scrollHandler || (this.scrollHandler = new e.ConnectedOverlayScrollHandler(this.target, (() => {
                    this.overlayVisible && this.hide()
                }))), this.scrollHandler.bindScrollListener()
            },
            unbindScrollListener() {
                this.scrollHandler && this.scrollHandler.unbindScrollListener()
            },
            bindResizeListener() {
                this.resizeListener || (this.resizeListener = () => {
                    this.overlayVisible && this.hide()
                }, window.addEventListener("resize", this.resizeListener))
            },
            unbindResizeListener() {
                this.resizeListener && (window.removeEventListener("resize", this.resizeListener), this.resizeListener = null)
            },
            isTargetClicked() {
                return this.target && (this.target === event.target || this.target.contains(event.target))
            },
            visible: e => "function" == typeof e.visible ? e.visible() : !1 !== e.visible,
            containerRef(e) {
                this.container = e
            },
            onOverlayClick(e) {
                s.default.emit("overlay-click", {
                    originalEvent: e,
                    target: this.target
                })
            }
        },
        computed: {
            containerClass() {
                return ["p-menu p-component", {
                    "p-menu-overlay": this.popup,
                    "p-input-filled": "filled" === this.$primevue.config.inputStyle,
                    "p-ripple-disabled": !1 === this.$primevue.config.ripple
                }]
            }
        },
        components: {
            Menuitem: r
        }
    };
    const d = {
            class: "p-menu-list p-reset",
            role: "menu"
        },
        m = {
            key: 0,
            class: "p-submenu-header"
        };
    return function(e, t) {
        void 0 === t && (t = {});
        var i = t.insertAt;
        if (e && "undefined" != typeof document) {
            var n = document.head || document.getElementsByTagName("head")[0],
                l = document.createElement("style");
            l.type = "text/css", "top" === i && n.firstChild ? n.insertBefore(l, n.firstChild) : n.appendChild(l), l.styleSheet ? l.styleSheet.cssText = e : l.appendChild(document.createTextNode(e))
        }
    }("\n.p-menu-overlay {\n    position: absolute;\n    top: 0;\n    left: 0;\n}\n.p-menu ul {\n    margin: 0;\n    padding: 0;\n    list-style: none;\n}\n.p-menu .p-menuitem-link {\n    cursor: pointer;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    text-decoration: none;\n    overflow: hidden;\n    position: relative;\n}\n.p-menu .p-menuitem-text {\n    line-height: 1;\n}\n"), c.render = function(e, t, i, l, s, r) {
        const o = n.resolveComponent("Menuitem");
        return n.openBlock(), n.createBlock(n.Teleport, {
            to: i.appendTo,
            disabled: !i.popup
        }, [n.createVNode(n.Transition, {
            name: "p-connected-overlay",
            onEnter: r.onEnter,
            onLeave: r.onLeave,
            onAfterLeave: r.onAfterLeave
        }, {
            default: n.withCtx((() => [!i.popup || s.overlayVisible ? (n.openBlock(), n.createBlock("div", n.mergeProps({
                key: 0,
                ref: r.containerRef,
                class: r.containerClass
            }, e.$attrs, {
                onClick: t[1] || (t[1] = (...e) => r.onOverlayClick && r.onOverlayClick(...e))
            }), [n.createVNode("ul", d, [(n.openBlock(!0), n.createBlock(n.Fragment, null, n.renderList(i.model, ((t, l) => (n.openBlock(), n.createBlock(n.Fragment, {
                key: t.label + l.toString()
            }, [t.items && r.visible(t) && !t.separator ? (n.openBlock(), n.createBlock(n.Fragment, {
                key: 0
            }, [t.items ? (n.openBlock(), n.createBlock("li", m, [n.renderSlot(e.$slots, "item", {
                item: t
            }, (() => [n.createTextVNode(n.toDisplayString(t.label), 1)]))])) : n.createCommentVNode("", !0), (n.openBlock(!0), n.createBlock(n.Fragment, null, n.renderList(t.items, ((t, s) => (n.openBlock(), n.createBlock(n.Fragment, {
                key: t.label + l + s
            }, [r.visible(t) && !t.separator ? (n.openBlock(), n.createBlock(o, {
                key: 0,
                item: t,
                onClick: r.itemClick,
                template: e.$slots.item,
                exact: i.exact
            }, null, 8, ["item", "onClick", "template", "exact"])) : r.visible(t) && t.separator ? (n.openBlock(), n.createBlock("li", {
                class: ["p-menu-separator", t.class],
                style: t.style,
                key: "separator" + l + s,
                role: "separator"
            }, null, 6)) : n.createCommentVNode("", !0)], 64)))), 128))], 64)) : r.visible(t) && t.separator ? (n.openBlock(), n.createBlock("li", {
                class: ["p-menu-separator", t.class],
                style: t.style,
                key: "separator" + l.toString(),
                role: "separator"
            }, null, 6)) : (n.openBlock(), n.createBlock(o, {
                key: t.label + l.toString(),
                item: t,
                onClick: r.itemClick,
                template: e.$slots.item,
                exact: i.exact
            }, null, 8, ["item", "onClick", "template", "exact"]))], 64)))), 128))])], 16)) : n.createCommentVNode("", !0)])),
            _: 3
        }, 8, ["onEnter", "onLeave", "onAfterLeave"])], 8, ["to", "disabled"])
    }, c
}(primevue.utils, primevue.overlayeventbus, primevue.ripple, Vue);

this.primevue = this.primevue || {}, this.primevue.tieredmenu = function(e, t, i, n) {
    "use strict";

    function l(e) {
        return e && "object" == typeof e && "default" in e ? e : {
            default: e
        }
    }
    var s = l(t),
        o = {
            name: "TieredMenuSub",
            emits: ["leaf-click", "keydown-item"],
            props: {
                model: {
                    type: Array,
                    default: null
                },
                root: {
                    type: Boolean,
                    default: !1
                },
                popup: {
                    type: Boolean,
                    default: !1
                },
                parentActive: {
                    type: Boolean,
                    default: !1
                },
                template: {
                    type: Function,
                    default: null
                },
                exact: {
                    type: Boolean,
                    default: !0
                }
            },
            documentClickListener: null,
            watch: {
                parentActive(e) {
                    e || (this.activeItem = null)
                }
            },
            data: () => ({
                activeItem: null
            }),
            updated() {
                this.root && this.activeItem && this.bindDocumentClickListener()
            },
            beforeUnmount() {
                this.unbindDocumentClickListener()
            },
            methods: {
                onItemMouseEnter(e, t) {
                    this.disabled(t) ? e.preventDefault() : this.root ? (this.activeItem || this.popup) && (this.activeItem = t) : this.activeItem = t
                },
                onItemClick(e, t, i) {
                    this.disabled(t) ? e.preventDefault() : (t.command && t.command({
                        originalEvent: e,
                        item: t
                    }), t.items && (this.activeItem && t === this.activeItem ? this.activeItem = null : this.activeItem = t), t.items || this.onLeafClick(), t.to && i && i(e))
                },
                onLeafClick() {
                    this.activeItem = null, this.$emit("leaf-click")
                },
                onItemKeyDown(e, t) {
                    let i = e.currentTarget.parentElement;
                    switch (e.which) {
                        case 40:
                            var n = this.findNextItem(i);
                            n && n.children[0].focus(), e.preventDefault();
                            break;
                        case 38:
                            var l = this.findPrevItem(i);
                            l && l.children[0].focus(), e.preventDefault();
                            break;
                        case 39:
                            t.items && (this.activeItem = t, setTimeout((() => {
                                i.children[1].children[0].children[0].focus()
                            }), 50)), e.preventDefault()
                    }
                    this.$emit("keydown-item", {
                        originalEvent: e,
                        element: i
                    })
                },
                onChildItemKeyDown(e) {
                    37 === e.originalEvent.which && (this.activeItem = null, e.element.parentElement.previousElementSibling.focus())
                },
                findNextItem(t) {
                    let i = t.nextElementSibling;
                    return i ? e.DomHandler.hasClass(i, "p-disabled") || !e.DomHandler.hasClass(i, "p-menuitem") ? this.findNextItem(i) : i : null
                },
                findPrevItem(t) {
                    let i = t.previousElementSibling;
                    return i ? e.DomHandler.hasClass(i, "p-disabled") || !e.DomHandler.hasClass(i, "p-menuitem") ? this.findPrevItem(i) : i : null
                },
                getItemClass(e) {
                    return ["p-menuitem", e.class, {
                        "p-menuitem-active": this.activeItem === e
                    }]
                },
                linkClass(e, t) {
                    return ["p-menuitem-link", {
                        "p-disabled": this.disabled(e),
                        "router-link-active": t && t.isActive,
                        "router-link-active-exact": this.exact && t && t.isExactActive
                    }]
                },
                bindDocumentClickListener() {
                    this.documentClickListener || (this.documentClickListener = e => {
                        this.$el && !this.$el.contains(e.target) && (this.activeItem = null, this.unbindDocumentClickListener())
                    }, document.addEventListener("click", this.documentClickListener))
                },
                unbindDocumentClickListener() {
                    this.documentClickListener && (document.removeEventListener("click", this.documentClickListener), this.documentClickListener = null)
                },
                visible: e => "function" == typeof e.visible ? e.visible() : !1 !== e.visible,
                disabled: e => "function" == typeof e.disabled ? e.disabled() : e.disabled
            },
            computed: {
                containerClass() {
                    return {
                        "p-submenu-list": !this.root
                    }
                }
            },
            directives: {
                ripple: l(i).default
            }
        };
    const r = {
            class: "p-menuitem-text"
        },
        a = {
            class: "p-menuitem-text"
        },
        c = {
            key: 0,
            class: "p-submenu-icon pi pi-angle-right"
        };
    o.render = function(e, t, i, l, s, o) {
        const d = n.resolveComponent("router-link"),
            u = n.resolveComponent("TieredMenuSub", !0),
            m = n.resolveDirective("ripple");
        return n.openBlock(), n.createBlock("ul", {
            ref: "element",
            class: o.containerClass,
            role: "'menubar' : 'menu'",
            "aria-orientation": "horizontal"
        }, [(n.openBlock(!0), n.createBlock(n.Fragment, null, n.renderList(i.model, ((e, t) => (n.openBlock(), n.createBlock(n.Fragment, {
            key: e.label + t.toString()
        }, [o.visible(e) && !e.separator ? (n.openBlock(), n.createBlock("li", {
            key: 0,
            class: o.getItemClass(e),
            style: e.style,
            onMouseenter: t => o.onItemMouseEnter(t, e),
            role: "none"
        }, [i.template ? (n.openBlock(), n.createBlock(n.resolveDynamicComponent(i.template), {
            key: 1,
            item: e
        }, null, 8, ["item"])) : (n.openBlock(), n.createBlock(n.Fragment, {
            key: 0
        }, [e.to && !o.disabled(e) ? (n.openBlock(), n.createBlock(d, {
            key: 0,
            to: e.to,
            custom: ""
        }, {
            default: n.withCtx((({
                navigate: t,
                href: i,
                isActive: l,
                isExactActive: s
            }) => [n.withDirectives(n.createVNode("a", {
                href: i,
                onClick: i => o.onItemClick(i, e, t),
                class: o.linkClass(e, {
                    isActive: l,
                    isExactActive: s
                }),
                onKeydown: t => o.onItemKeyDown(t, e),
                role: "menuitem"
            }, [n.createVNode("span", {
                class: ["p-menuitem-icon", e.icon]
            }, null, 2), n.createVNode("span", r, n.toDisplayString(e.label), 1)], 42, ["href", "onClick", "onKeydown"]), [
                [m]
            ])])),
            _: 2
        }, 1032, ["to"])) : n.withDirectives((n.openBlock(), n.createBlock("a", {
            key: 1,
            href: e.url,
            class: o.linkClass(e),
            target: e.target,
            "aria-haspopup": null != e.items,
            "aria-expanded": e === s.activeItem,
            onClick: t => o.onItemClick(t, e),
            onKeydown: t => o.onItemKeyDown(t, e),
            role: "menuitem",
            tabindex: o.disabled(e) ? null : "0"
        }, [n.createVNode("span", {
            class: ["p-menuitem-icon", e.icon]
        }, null, 2), n.createVNode("span", a, n.toDisplayString(e.label), 1), e.items ? (n.openBlock(), n.createBlock("span", c)) : n.createCommentVNode("", !0)], 42, ["href", "target", "aria-haspopup", "aria-expanded", "onClick", "onKeydown", "tabindex"])), [
            [m]
        ])], 64)), o.visible(e) && e.items ? (n.openBlock(), n.createBlock(u, {
            model: e.items,
            key: e.label + "_sub_",
            template: i.template,
            onLeafClick: o.onLeafClick,
            onKeydownItem: o.onChildItemKeyDown,
            parentActive: e === s.activeItem,
            exact: i.exact
        }, null, 8, ["model", "template", "onLeafClick", "onKeydownItem", "parentActive", "exact"])) : n.createCommentVNode("", !0)], 46, ["onMouseenter"])) : n.createCommentVNode("", !0), o.visible(e) && e.separator ? (n.openBlock(), n.createBlock("li", {
            class: ["p-menu-separator", e.class],
            style: e.style,
            key: "separator" + t.toString(),
            role: "separator"
        }, null, 6)) : n.createCommentVNode("", !0)], 64)))), 128))], 2)
    };
    var d = {
        name: "TieredMenu",
        inheritAttrs: !1,
        props: {
            popup: {
                type: Boolean,
                default: !1
            },
            model: {
                type: Array,
                default: null
            },
            appendTo: {
                type: String,
                default: "body"
            },
            autoZIndex: {
                type: Boolean,
                default: !0
            },
            baseZIndex: {
                type: Number,
                default: 0
            },
            exact: {
                type: Boolean,
                default: !0
            }
        },
        target: null,
        container: null,
        outsideClickListener: null,
        scrollHandler: null,
        resizeListener: null,
        data: () => ({
            visible: !1
        }),
        beforeUnmount() {
            this.unbindResizeListener(), this.unbindOutsideClickListener(), this.scrollHandler && (this.scrollHandler.destroy(), this.scrollHandler = null), this.target = null, this.container && this.autoZIndex && e.ZIndexUtils.clear(this.container), this.container = null
        },
        methods: {
            itemClick(e) {
                const t = e.item;
                t.command && (t.command(e), e.originalEvent.preventDefault()), this.hide()
            },
            toggle(e) {
                this.visible ? this.hide() : this.show(e)
            },
            show(e) {
                this.visible = !0, this.target = e.currentTarget
            },
            hide() {
                this.visible = !1
            },
            onEnter(t) {
                this.alignOverlay(), this.bindOutsideClickListener(), this.bindResizeListener(), this.bindScrollListener(), this.autoZIndex && e.ZIndexUtils.set("menu", t, this.baseZIndex + this.$primevue.config.zIndex.menu)
            },
            onLeave() {
                this.unbindOutsideClickListener(), this.unbindResizeListener(), this.unbindScrollListener()
            },
            onAfterLeave(t) {
                this.autoZIndex && e.ZIndexUtils.clear(t)
            },
            alignOverlay() {
                e.DomHandler.absolutePosition(this.container, this.target), this.container.style.minWidth = e.DomHandler.getOuterWidth(this.target) + "px"
            },
            bindOutsideClickListener() {
                this.outsideClickListener || (this.outsideClickListener = e => {
                    this.visible && this.container && !this.container.contains(e.target) && !this.isTargetClicked(e) && this.hide()
                }, document.addEventListener("click", this.outsideClickListener))
            },
            unbindOutsideClickListener() {
                this.outsideClickListener && (document.removeEventListener("click", this.outsideClickListener), this.outsideClickListener = null)
            },
            bindScrollListener() {
                this.scrollHandler || (this.scrollHandler = new e.ConnectedOverlayScrollHandler(this.target, (() => {
                    this.visible && this.hide()
                }))), this.scrollHandler.bindScrollListener()
            },
            unbindScrollListener() {
                this.scrollHandler && this.scrollHandler.unbindScrollListener()
            },
            bindResizeListener() {
                this.resizeListener || (this.resizeListener = () => {
                    this.visible && this.hide()
                }, window.addEventListener("resize", this.resizeListener))
            },
            unbindResizeListener() {
                this.resizeListener && (window.removeEventListener("resize", this.resizeListener), this.resizeListener = null)
            },
            isTargetClicked() {
                return this.target && (this.target === event.target || this.target.contains(event.target))
            },
            onLeafClick() {
                this.popup && this.hide()
            },
            containerRef(e) {
                this.container = e
            },
            onOverlayClick(e) {
                s.default.emit("overlay-click", {
                    originalEvent: e,
                    target: this.target
                })
            }
        },
        computed: {
            containerClass() {
                return ["p-tieredmenu p-component", {
                    "p-tieredmenu-overlay": this.popup,
                    "p-input-filled": "filled" === this.$primevue.config.inputStyle,
                    "p-ripple-disabled": !1 === this.$primevue.config.ripple
                }]
            }
        },
        components: {
            TieredMenuSub: o
        }
    };
    return function(e, t) {
        void 0 === t && (t = {});
        var i = t.insertAt;
        if (e && "undefined" != typeof document) {
            var n = document.head || document.getElementsByTagName("head")[0],
                l = document.createElement("style");
            l.type = "text/css", "top" === i && n.firstChild ? n.insertBefore(l, n.firstChild) : n.appendChild(l), l.styleSheet ? l.styleSheet.cssText = e : l.appendChild(document.createTextNode(e))
        }
    }("\n.p-tieredmenu-overlay {\n    position: absolute;\n    top: 0;\n    left: 0;\n}\n.p-tieredmenu ul {\n    margin: 0;\n    padding: 0;\n    list-style: none;\n}\n.p-tieredmenu .p-submenu-list {\n    position: absolute;\n    min-width: 100%;\n    z-index: 1;\n    display: none;\n}\n.p-tieredmenu .p-menuitem-link {\n    cursor: pointer;\n    display: -webkit-box;\n    display: -ms-flexbox;\n    display: flex;\n    -webkit-box-align: center;\n        -ms-flex-align: center;\n            align-items: center;\n    text-decoration: none;\n    overflow: hidden;\n    position: relative;\n}\n.p-tieredmenu .p-menuitem-text {\n    line-height: 1;\n}\n.p-tieredmenu .p-menuitem {\n    position: relative;\n}\n.p-tieredmenu .p-menuitem-link .p-submenu-icon {\n    margin-left: auto;\n}\n.p-tieredmenu .p-menuitem-active > .p-submenu-list {\n    display: block;\n    left: 100%;\n    top: 0;\n}\n"), d.render = function(e, t, i, l, s, o) {
        const r = n.resolveComponent("TieredMenuSub");
        return n.openBlock(), n.createBlock(n.Teleport, {
            to: i.appendTo,
            disabled: !i.popup
        }, [n.createVNode(n.Transition, {
            name: "p-connected-overlay",
            onEnter: o.onEnter,
            onLeave: o.onLeave,
            onAfterLeave: o.onAfterLeave
        }, {
            default: n.withCtx((() => [!i.popup || s.visible ? (n.openBlock(), n.createBlock("div", n.mergeProps({
                key: 0,
                ref: o.containerRef,
                class: o.containerClass
            }, e.$attrs, {
                onClick: t[1] || (t[1] = (...e) => o.onOverlayClick && o.onOverlayClick(...e))
            }), [n.createVNode(r, {
                model: i.model,
                root: !0,
                popup: i.popup,
                onLeafClick: o.onLeafClick,
                template: e.$slots.item,
                exact: i.exact
            }, null, 8, ["model", "popup", "onLeafClick", "template", "exact"])], 16)) : n.createCommentVNode("", !0)])),
            _: 1
        }, 8, ["onEnter", "onLeave", "onAfterLeave"])], 8, ["to", "disabled"])
    }, d
}(primevue.utils, primevue.overlayeventbus, primevue.ripple, Vue);