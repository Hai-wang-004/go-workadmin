var BSHARE_SHOST_NAME = "http://static.bshare.cn",
    BSHARE_BUTTON_HOST = "http://b.bshare.cn",
    BSHARE_WEB_HOST = "http://www.bshare.cn";
(function(g, h) {
    if (!g.bShareUtil || !g.bShareControl) var k = h.documentElement,
        f = navigator,
        i = g.BUZZ = {},
        b = g.bShareControl = {
            count: 0,
            viewed: !1,
            viewInfo: null,
            bShareLoad: !1,
            clicked: !1
        },
        e = g.bShareUtil = {
            requestedScripts: [],
            encode: encodeURIComponent,
            isIe6: /msie|MSIE 6/.test(f.userAgent),
            isIe7: /MSIE 7/.test(f.userAgent),
            isIe8: /MSIE 8/.test(f.userAgent),
            isIe9: /MSIE 9/.test(f.userAgent),
            isIe: /Microsoft Internet Explorer/.test(f.appName),
            isSt: h.compatMode == "CSS1Compat",
            isQk: function() {
                return e.isIe6 || e.isIe && !e.isSt
            },
            eleInViewport: function(a) {
                a = a.getBoundingClientRect();
                return a.top >= 0 && a.left >= 0 && a.bottom <= (g.innerHeight || k.clientHeight) && a.right <= (g.innerWidth || k.clientWidth)
            },
            getElemById: function(a) {
                return h.getElementById(a)
            },
            createElement: function(a, d, c, b, e) {
                a = h.createElement(a);
                if (d) a.id = d;
                if (c) a.className = c;
                if (b) a.style.cssText = b;
                if (e) a.innerHTML = e;
                return a
            },
            formatParam: function(a, d) {
                return typeof a == "number" ? +d : typeof a == "boolean" ? /^true$/i.test(d) : d
            },
            isUndefined: function(a) {
                return typeof a == "undefined"
            },
            arrayContains: function(a, d, c) {
                for (var b = a.length; b--;) if (!e.isUndefined(d) && a[b] === d || !e.isUndefined(c) && c.test(a[b])) return !0;
                return !1
            },
            loadScript: function(a, d) {
                var c = e.requestedScripts;
                if (!e.arrayContains(c, a)) / (bsMore | bshareS887)(Org) ? \.js / .test(a) && c.push(a), d = d ||
                function() {}, c = e.createElement("script"), c.src = a, c.type = "text/javascript", c.charset = "utf-8", c.onload = d, c.onreadystatechange = function() {
                    /complete|loaded/.test(this.readyState) && d()
                }, h.getElementsByTagName("head")[0].appendChild(c)
            },
            loadStyle: function(a) {
                var d = e.createElement("style");
                d.type = "text/css";
                d.styleSheet ? d.styleSheet.cssText = a : d.appendChild(h.createTextNode(a));
                h.getElementsByTagName("head")[0].appendChild(d)
            },
            getOffset: function(a) {
                for (var d = {
                    x: a.offsetLeft,
                    y: a.offsetTop,
                    h: a.offsetHeight,
                    w: a.offsetWidth
                }; a = a.offsetParent; d.x += a.offsetLeft, d.y += a.offsetTop);
                return d
            },
            getElem: function(a, d, c, b) {
                for (var a = a.getElementsByTagName(d), d = [], e = 0, j = 0, g = a.length; e < g; e++) {
                    var f = a[e];
                    if (!c || f.className.indexOf(c) != -1) d.push(f), typeof b == "function" && b(f, j++)
                }
                return d
            },
            getText: function(a) {
                return e.isIe ? a.innerText : a.textContent
            },
            insertAfter: function(a, d) {
                var c = d.parentNode;
                c.lastChild === d ? c.appendChild(a) : c.insertBefore(a, d.nextSibling)
            },
            getWH: function() {
                return {
                    h: (e.isSt ? k : h.body).clientHeight,
                    w: (e.isSt ? k : h.body).clientWidth
                }
            },
            stopProp: function(a) {
                a = a || g.event || {};
                a.stopPropagation ? a.stopPropagation() : a.cancelBubble = !0
            },
            getScript: function(a) {
                for (var d = h.getElementsByTagName("script"), c = [], b = 0, e = d.length; b < e; b++) {
                    var j = d[b].src;
                    j && j.search(a) >= 0 && /bshare.(cn|com|me)|static.(local|dev)/i.test(j) && c.push(d[b])
                }
                return c
            },
            parseOptions: function(a, d) {
                var c = {};
                if (a = /\?(.*)|#(.*)/.exec(a)) for (var a = a[0].slice(1).replace("+", " "), b = a.split(/[&;]/g), e = 0, j = b.length; e < j; e++) {
                    var f = b[e].split("="),
                        g = decodeURIComponent(f[0]),
                        h = d ? f[1] : null;
                    if (!d) try {
                        h = decodeURIComponent(f[1])
                    } catch (i) {}
                    c[g] = h
                }
                return c
            },
            submitForm: function(a, d, c, b) {
                var b = b || "post",
                    f = e.createElement("form");
                h.body.appendChild(f);
                f.method = b;
                f.target = c;
                f.setAttribute("accept-charset", "utf-8");
                f.action = a;
                for (var j in d) if (typeof d[j] != "function") a = e.createElement("input"), a.type = "hidden", a.name = j, a.value = d[j], f.appendChild(a);
                if (e.isIe) h.charset = "utf-8";
                f.submit();
                h.body.removeChild(f)
            },
            replaceParam: function(a, d, c) {
                return d ? c.replace(a, e.encode(d)) : c.replace(a, "")
            },
            ready: function(a) {
                if (h.addEventListener) h.addEventListener("DOMContentLoaded", function() {
                    h.removeEventListener("DOMContentLoaded", arguments.callee, !1);
                    a.call()
                }, !1), g.addEventListener("load", a, !1);
                else if (h.attachEvent) {
                    h.attachEvent("onreadystatechange", function() {
                        h.readyState == "complete" && (h.detachEvent("onreadystatechange", arguments.callee), a.call())
                    });
                    g.attachEvent("onload", a);
                    var d = !1;
                    try {
                        d = g.frameElement === null
                    } catch (c) {}
                    k.doScroll && d &&
                    function() {
                        try {
                            k.doScroll("left")
                        } catch (c) {
                            setTimeout(arguments.callee, 10);
                            return
                        }
                        a.call()
                    }()
                } else g.onload = a
            },
            createBuzzObject: function(a, d) {
                if (g[a]) return g[a];
                d.namespace = a;
                var c = g[a] = {
                    shost: g.BSHARE_SHOST_NAME,
                    bhost: g.BSHARE_BUTTON_HOST,
                    whost: g.BSHARE_WEB_HOST,
                    defaultConfig: d,
                    params: {
                        type: 0,
                        publisherUuid: "",
                        url: "",
                        title: "",
                        summary: "",
                        content: "",
                        pic: "",
                        pics: "",
                        video: "",
                        vTag: "",
                        vUid: "",
                        vEmail: "",
                        product: "",
                        price: "0",
                        brand: "",
                        tag: "",
                        category: "",
                        template: "1",
                        popcss: "",
                        apvuid: "",
                        apts: "",
                        apsign: "",
                        admtest: !1
                    },
                    isReady: !1,
                    completed: !1,
                    curb: 0,
                    preb: -1,
                    entries: [],
                    counters: []
                };
                c.config = {};
                c.elems = {
                    powerBy: '<div id="bsPower" style="float:right;text-align:right;overflow:hidden;height:100%;"><a class="bsSiteLink" style="font-size:10px;vertical-align:text-bottom;line-height:24px;cursor:pointer;" href="' + c.whost + '" target="_blank"><span style="font-size:10px;vertical-align:text-bottom;"><span style="color:#f60;">b</span>Share</span></a></div>'
                };
                for (var m in c.defaultConfig) c.config[m] = c.defaultConfig[m];
                c.imageBasePath = c.shost + "/frame/images/";
                c.jsBasePath = c.shost + "/b/";
                c.addEntry = function(a) {
                    if (typeof c.counters == "number") c.counters = [];
                    c.entries.push(a);
                    c.counters.push(0)
                };
                c.fc = "";
                c.createFlashObj = function() {
                    if (!e.getElemById("bshareFS")) {
                        var a = c.shost + "/flash/bfc.swf";
                        h.body.appendChild(e.createElement("div", "", "", "height:0;line-height:0;font-size:0;", '<object id="bshareFS" type="application/x-shockwave-flash" data="' + a + '" width="0" height="0"><param name="movie" value="' + a + '"/><param name="allowScriptAccess" value="always"/><param name="allowNetworking" value="all"/></object>'));
                        i.fCB = function() {
                            b.viewed || c.view()
                        }
                    }
                };
                c.updateFC = function(a) {
                    try {
                        var d = f.appName.indexOf("Microsoft") != -1 ? g.bshareFS : h.bshareFS;
                        c.fc = d.bSyncInfo(a || "")
                    } catch (b) {}
                };
                c.initAdm = function(a) {
                    var d = e.createElement("a"),
                        b, i, m = ["rayli.com"];
                    d.href = g.location.href;
                    d = d.host;
                    for (b = 0, i = m.length; b < i; ++b) if (d.indexOf(m[b]) > -1) {
                        c.params.admtest = !0;
                        break
                    }
                    if (!c.params.admtest) return "";
                    c.admIds = g.admObjArray || [];
                    c.admIdsObj = [];
                    var m = g.admCookie || "",
                        k;
                    try {
                        a = a || c.fc;
                        for (b = 0; b < c.admIds.length; b++) if (k = c.admIds[b], c.admIdsObj[b] = f.appName.indexOf("Microsoft") != -1 ? e.getElemById(k) : h[k], c.admIdsObj[b]) c.admIdsObj[b].isViewed = !1, a && typeof c.admIdsObj[b].cookieMap == "function" && c.admIdsObj[b].cookieMap(a)
                    } catch (q) {}
                    c.eleInViewportEvent = function() {
                        for (b = 0; b < c.admIdsObj.length; b++) {
                            var a = c.admIdsObj[b];
                            if (a && e.eleInViewport(a) && !a.isViewed) try {
                                a.objVisible(), a.isViewed = !0
                            } catch (d) {}
                        }
                    };
                    g.addEventListener ? g.addEventListener("scroll", c.eleInViewportEvent, !1) : g.attachEvent("onscroll", c.eleInViewportEvent);
                    c.eleInViewportEvent();
                    return m
                };
                return g[a]
            },
            parseBuzzOptions: function(a, b, c, f, g) {
                var d;
                d = (a = e.getScript(b)[a]) ? e.parseOptions(a.src) : {}, a = d;
                g && (a = g(a));
                for (var h in a) if (!e.isUndefined(a[h]) && !(a[h] === null || typeof c[h] == "number" && a[h] === "")) e.isUndefined(c[h]) ? e.isUndefined(f[h]) || (f[h] = e.formatParam(f[h], a[h])) : c[h] = e.formatParam(c[h], a[h])
            }
        }
})(window, document);
(function(g, h, k) {
    var f = h.bShareUtil,
        i = h.bShareControl;
    if (!(i.count > 0)) {
        var b = f.createBuzzObject(g, {
            lang: "zh",
            height: 0,
            width: 0,
            image: "",
            bgc: "none",
            fgc: "#333",
            poptxtc: "#666",
            popbgc: "#f2f2f2",
            sn: !1,
            logo: !0,
            style: 1,
            fs: 0,
            inline: !1,
            beta: !1,
            popjs: "",
            popHCol: 2,
            pop: 0,
            mdiv: 0,
            poph: "auto",
            bps: "",
            bps2: "",
            showShareCount: !0,
            icon: !0,
            text: null,
            promote: !1
        }),
            e = b.config,
            a = b.params;
        b.topMap = {
            baiduhi: 0,
            bsharesync: 1,
            douban: 2,
            facebook: 3,
            feixin: 4,
            ifengmb: 5,
            itieba: 6,
            kaixin001: 7,
            msn: 8,
            neteasemb: 9,
            peoplemb: 10,
            qqmb: 11,
            qqxiaoyou: 12,
            qzone: 13,
            renren: 14,
            sinaminiblog: 15,
            sinaqing: 16,
            sohuminiblog: 17,
            tianya: 18,
            twitter: 19
        };
        b.boxConfig = {
            position: 0,
            boxHeight: 408,
            boxWidth: 548,
            closeTop: 8,
            closeRight: 20,
            hasWrapper: !0
        };
        b.customization = {};
        b.loadOptions = function() {
            f.parseBuzzOptions(0, /button(Lite)?(Org)?\.js|bshare_load/, e, a, function(a) {
                if (!f.isUndefined(h.bShareOpt)) for (var b in h.bShareOpt) a[b] = h.bShareOpt[b];
                a.lang = a.lang == "en" ? "en" : "zh";
                if (a.h && a.w && a.img) a.height = a.h, a.width = a.w, a.image = a.img;
                a.bgc = a.bgcolor || void 0;
                a.fgc = a.textcolor || void 0;
                a.logo = !(a.logo && /^false$/i.test(a.logo));
                a.popHCol = a.pophcol || void 0;
                if (a.style) a.style = /^(-1|0|1|2|3|4|5|10|11|999)$/.test(a.style) ? +a.style : void 0;
                if (a.bp) a.style && a.style == 2 ? a.bps2 = a.bp.split(",") : a.bps = a.bp.split(",");
                a.showShareCount = a.style && /3|4|5/.test(a.style) ? !1 : !(a.ssc && /^false$/i.test(a.ssc.toString()));
                a.type = h.BSHARE_BUTTON_TYPE || a.type;
                a.publisherUuid = a.uuid || void 0;
                return a
            });
            b.buttonType = a.type;
            for (var d in b.defaultConfig) b.defaultConfig[d] !== e[d] && (b.customization[d] = e[d]);
            if (b.buttonType != 15) a.popcss = "";
            if (h.location.href.indexOf(b.whost + "/moreStyles") < 0) e.promote = !1
        };
        b.writeButton = function() {
            var a = "",
                c = {
                    0: 0,
                    1: [110, 85],
                    10: [90, 51],
                    11: [82, 82]
                },
                h = {
                    0: 16,
                    1: 24,
                    10: 21,
                    11: 49
                },
                g = b.imageBasePath,
                j = e.style,
                i = e.image,
                o = e.showShareCount,
                n = e.width,
                p = e.height;
            /^(3|4|5)$/.test(j) || (a = '<div class="bsPromo bsPromo1"></div>');
            j > 1 && j < 6 ? b.writeBshareDiv(a) : j == -1 ? (f.getElem(k, "div", "bshare-custom", function(a) {
                if (!a.childNodes[0].className || a.childNodes[0].className.indexOf("bsPromo") < 0) {
                    var d = f.createElement("div", "", "bsPromo bsPromo" + (b.isLite ? 2 : 1));
                    a.insertBefore(d, a.childNodes[0])
                }
            }), (e.beta || e.popjs) && b.writeBshareDiv('<div class="buzzButton">' + e.text + "</div>", "")) : j >= 0 && (j != 999 && (i = g + "logo_square_s.gif", j != 0 && (i = g + "button_custom" + j + "-" + (e.lang == "en" ? "en" : "zh"), o && (i += "-c"), j == 10 && (n = /Blue|Red|Green|Grey|Orange/.test(e.bgc) ? e.bgc : "Orange", i += "-" + n), i += ".gif"), n = c[j][o ? 0 : 1], p = h[j]), a += '<div class="buzzButton bsStyle' + j + '" style="height:' + p + "px;color:" + e.fgc + ";", j == 0 ? (a += e.icon ? "background:transparent url(" + i + ") no-repeat;" : "", a += 'float:left"><div style="padding:0 4px 0 ' + (e.icon ? "21px" : "0") + ";" + (b.isLite ? "height:16px;" : "") + '"><span class="bshareText" style="line-height:18px;float:left;">' + (e.text === null ? "\u5206\u4eab" : e.text) + "</span></div></div>", o && (a += '<div style="background:transparent url(' + g + 'counter_box.gif) no-repeat;float:left;width:40px;height:16px;text-align:center;font-weight:bold;">&nbsp;<span style="position:relative;line-height:16px;" class="shareCount"></span></div>')) : (a += ";background:transparent url(" + i + ") no-repeat;text-align:center;width:" + n + 'px;">', o && j != 999 && (a += '<span style="font-weight:bold;position:relative;line-height:' + (j == 10 ? "22" : "25") + 'px;" class="shareCount"></span>'), a += "</div>"), a += '<div style="clear:both;"></div>', b.writeBshareDiv(a, "font-size:12px;height:" + p + "px;width:" + n + "px;"))
        };
        b.more = function() {
            return typeof b.moreDiv == "function" ? (b.moreDiv(), !0) : !1
        };
        b.commLoad = function(d) {
            if (!d) {
                if (e.mdiv < 0) return;
                var c = 0,
                    g = setInterval(function() {
                        b.more() || c >= 30 ? clearInterval(g) : ++c
                    }, 100);
                return !1
            }
            var l;
            if (d == "bsharesync") l = [b.whost, "/bsyncShare?site=", d].join(""), b.shareStats(d), f.submitForm(l, a, "_blank");
            else if (d == "email") l = [b.bhost, "/bshareEmail"].join(""), b.shareStats(d), f.submitForm(l, a, "_blank");
            else if (d == "clipboard") f.copy2Clipboard(), b.shareStats(d);
            else if (d == "favorite") f.add2Bookmark(), b.shareStats(d);
            else if (d == "printer") f.add2Printer(), b.shareStats(d);
            else {
                if (i.bShareLoad) {
                    l = b.bhost + "/bshare_redirect?site=" + d;
                    for (var j in a)!/content|target/.test(j) && typeof a[j] != "function" && (l += "&" + j + "=" + f.encode(a[j]))
                } else(l = h.BS_PURL_MAP[d]) || alert(b.iL8n.loadFailed), d == "gmw" ? l = f.replaceParam("${URL}", a.url.replace("http://", ""), l) : a.url && (l = f.replaceParam("${URL}", a.url, l)), l = f.replaceParam("${TITLE}", a.title, l), l = f.replaceParam("${CONTENT}", a.summary, l), l = f.replaceParam("${IMG}", a.pic, l), l = f.replaceParam("${VIDEO}", a.video, l);
                h.open(l, "", "height=600,width=800,top=100,left=100,screenX=100,screenY=100,scrollbars=yes,resizable=yes")
            }
        };
        b.onLoad = function() {
            f.getElem(k, "a", "bshareDiv", function(a, c) {
                f.getElem(a, "div", "buzzButton", function(a) {
                    a.onclick = function(a) {
                        return function(c) {
                            b.more(c, a);
                            return !1
                        }
                    }(c)
                })
            });
            var a = e.showShareCount;
            if (e.style == 0) {
                var c = f.getElem(k, "div", "buzzButton")[0].offsetWidth;
                a && (c += 41);
                f.getElem(k, "a", "bshareDiv", function(a) {
                    a.style.width = c + "px"
                })
            }
            var g = b.entries.length;
            if (a && g > 0) {
                for (var a = "", i = 0; i < g; i++) {
                    var j = b.entries[i];
                    if (typeof j.url == "string") {
                        if (f.isIe && a.length + j.url.length > 2E3) break;
                        a != "" && (a += "|");
                        a += j.url
                    }
                }
                a != "" && (a += "|");
                a += h.location.href;
                b.count(a)
            }
        };
        b.renderButton = function() {
            f.loadStyle("a.bshareDiv,#bsPanel,#bsMorePanel,#bshareF{border:none;background:none;padding:0;margin:0;font:12px Helvetica,Calibri,Tahoma,Arial,\u5b8b\u4f53,sans-serif;line-height:14px;}#bsPanel div,#bsMorePanel div,#bshareF div{display:block;}.bsRlogo .bsPopupAwd,.bsRlogoSel .bsPopupAwd,.bsLogo .bsPopupAwd,.bsLogoSel .bsPopupAwd{line-height:16px !important;}a.bshareDiv div,#bsFloatTab div{*display:inline;zoom:1;display:inline-block;}a.bshareDiv img,a.bshareDiv div,a.bshareDiv span,a.bshareDiv a,#bshareF table,#bshareF tr,#bshareF td{text-decoration:none;background:none;margin:0;padding:0;border:none;line-height:1.2}a.bshareDiv span{display:inline;float:none;}div.buzzButton{cursor:pointer;font-weight:bold;}.buzzButton .shareCount a{color:#333}.bsStyle1 .shareCount a{color:#fff}span.bshareText{white-space:nowrap;}span.bshareText:hover{text-decoration:underline;}a.bshareDiv .bsPromo,div.bshare-custom .bsPromo{display:none;position:absolute;z-index:100;}a.bshareDiv .bsPromo.bsPromo1,div.bshare-custom .bsPromo.bsPromo1{width:51px;height:18px;top:-18px;left:0;line-height:16px;font-size:12px !important;font-weight:normal !important;color:#fff;text-align:center;background:url(" + b.imageBasePath + "bshare_box_sprite2.gif) no-repeat 0 -606px;}div.bshare-custom .bsPromo.bsPromo2{background:url(" + b.imageBasePath + "bshare_promo_sprite.gif) no-repeat;cursor:pointer;}");
            b.writeButton()
        };
        b.loadButtonStyle = function() {
            if (b.buttonType != 15) {
                var a, c = e.style;
                if (e.beta) a = b.jsBasePath + "styles/bshareS888.js?v=20130703";
                else if (e.popjs) a = e.popjs;
                else if (e.style != -1 && (a = b.jsBasePath + "styles/bshareS" + (c > 1 && c < 6 ? c : 1) + ".js?v=20130703", e.pop == -1 && (c <= 1 || c >= 6))) a = "";
                a && f.loadScript(a)
            }
        };
        b.international = function(a) {
            var c = b.jsBasePath + "langs/bs-lang-";
            c += e.lang == "en" ? "en.js?v=20130703" : "zh.js?v=20130703";
            f.loadScript(c, a)
        };
        b.start = function() {
            f.loadEngine && (f.loadEngine(g), b.createFlashObj(), b.isLite && b.loadOptions(), b.international(function() {
                if (!b.completed) {
                    if (f.isUndefined(e.text) || e.text === null) e.text = e.style == 0 ? b.iL8n.shareTextShort : b.iL8n.shareText;
                    b.isLite && b.renderButton();
                    if (b.buttonType == 15) b.boxConfig = {
                        position: 0,
                        boxHeight: 404,
                        boxWidth: 650,
                        closeTop: 10,
                        closeRight: 16
                    };
                    f.createShareBox(g);
                    b.createBox && b.createBox();
                    e.mdiv >= 0 && b.buttonType != 15 && f.loadScript(b.jsBasePath + "components/bsMore.js?v=20130703");
                    if (b.buttonType == 1) return b.show(), !1;
                    b.loadButtonStyle();
                    b.onLoad();
                    b.prepare(0);
                    setTimeout(function() {
                        i.viewed || b.view();
                        setTimeout(function() {
                            i.bShareLoad || f.loadScript(b.jsBasePath + "components/bsPlatforms.js?v=20130703")
                        }, 3E3)
                    }, 3E3);
                    b.completed = !0
                }
            }))
        };
        b.init = function() {
            if (!b.isReady) b.isReady = !0, f.loadScript(b.jsBasePath + "engines/bs-engine.js?v=20130703", b.start)
        }
    }
})("bShare", window, document);
(function(g, h, k) {
    if (!(h.bShareControl.count > 0 && h[g].isLite)) {
        h.bShareControl.count += 1;
        var f = h.bShareUtil,
            i = h.bShareControl,
            b = h[g],
            e = b.params;
        b.load = function(a) {
            b.click();
            var d, c = i.bShareLoad;
            if (c && b.buttonType == 15) {
                if (!e.pic) e.pic = b.shost + "/images/ec-no-pic.jpg";
                if (!e.product) e.product = e.title;
                d = "shareBox?site=" + a
            } else if (c && /^peoplemb$/.test(a)) d = "bshareXauth?site=" + a;
            else if (c && /^(.*miniblog|neteasemb|qqmb|qzone|renren|kaixin001|tianya|xinhuamb|facebook|twitter|youdaonote)$/.test(a)) d = "bshareOauth?site=" + a;
            else return b.commLoad(a), !1;
            if (!c) return !1;
            e.target = a || "";
            f.submitForm(b.bhost + "/" + d, e, k.getElementById("bShareFrame").name);
            b.display();
            return !0
        }
    }
})("bShare", window, document);
(function(g, h, k) {
    if (!(h.bShareControl.count > 0 && h[g].isLite)) {
        var f = h.bShareUtil,
            i = h[g],
            b = i.config;
        i.customization.type = "plus";
        i.ecSyncPlats = "sinaminiblog,sohuminiblog,neteasemb,qqmb,qzone,renren,kaixin001,tianya".split(",");
        i.ecHotPlats = ["meilishuo", "mogujie", "taojianghu", "huaban", "duitang"];
        i.filterECPlats = function() {
            i.buttonType == 15 && f.getElem(k, "div", "bshare-custom", function(b) {
                for (var b = b.getElementsByTagName("a"), a = 0, d = b.length; a < d; a++) {
                    var c = b[a],
                        g = c.className.replace("bshare-", "");
                    if (!f.arrayContains(i.ecSyncPlats, g) && !f.arrayContains(i.ecHotPlats, g)) c.style.display = "none"
                }
            })
        };
        i.writeBshareDiv = function(e, a) {
            if (f.isUndefined(i.usePlaceHolder)) i.usePlaceHolder = !0;
            var d = (b.inline ? "" : "display:block;") + "text-decoration:none;padding:0;margin:0;",
                a = a || "",
                c = [];
            i.usePlaceHolder && (c = f.getElem(k, "a", "bshareDiv", function(b) {
                b.innerHTML = e;
                b.onclick = function() {
                    return !1
                };
                b.style.cssText = d + a
            }));
            if (!i.usePlaceHolder || c.length == 0) k.write('<a class="bshareDiv" onclick="javascript:return false;" style="' + d + a + '">' + e + "</a>"), i.usePlaceHolder = !1;
            i.customization.anchor = i.usePlaceHolder
        };
        f.ready(i.init)
    }
})("bShare", window, document);
window.bShare.isLite || (window.bShare.loadOptions(), window.bShare.renderButton(), window.bShare.filterECPlats());
(function() {
    var g = window.bShare;
    if (!g) g = window.bShare = {};
    g.pnMap = {
        115: ["115\u6536\u85cf\u5939", 0],
        "139mail": ["139\u90ae\u7bb1", 2],
        "9dian": ["\u8c46\u74e39\u70b9", 6],
        baiducang: ["\u767e\u5ea6\u641c\u85cf", 7],
        baiduhi: ["\u767e\u5ea6\u7a7a\u95f4", 8],
        bgoogle: ["Google\u4e66\u7b7e", 10],
        bsharesync: ["\u4e00\u952e\u901a", 16],
        caimi: ["\u8d22\u8ff7", 17],
        cfol: ["\u4e2d\u91d1\u5fae\u535a", 18],
        chouti: ["\u62bd\u5c49", 20],
        clipboard: ["\u590d\u5236\u7f51\u5740", 21],
        cyolbbs: ["\u4e2d\u9752\u8bba\u575b", 22],
        cyzone: ["\u521b\u4e1a\u5427", 23],
        delicious: ["\u7f8e\u5473\u4e66\u7b7e", 24],
        dig24: ["\u9012\u5ba2\u7f51", 25],
        digg: ["Digg", 26],
        diglog: ["\u5947\u5ba2\u53d1\u73b0", 27],
        diigo: ["Diigo", 29],
        douban: ["\u8c46\u74e3\u7f51", 30],
        dream: ["\u68a6\u5e7b\u4eba\u751f", 31],
        duitang: ["\u5806\u7cd6", 32],
        eastdaymb: ["\u4e1c\u65b9\u5fae\u535a", 33],
        email: ["\u7535\u5b50\u90ae\u4ef6", 34],
        evernote: ["Evernote", 35],
        facebook: ["Facebook", 36],
        fanfou: ["\u996d\u5426", 37],
        favorite: ["\u6536\u85cf\u5939", 38],
        feixin: ["\u98de\u4fe1", 39],
        friendfeed: ["FriendFeed", 40],
        fwisp: ["Fwisp", 42],
        ganniu: ["\u8d76\u725b\u5fae\u535a", 43],
        gmail: ["Gmail", 44],
        gmw: ["\u5149\u660e\u7f51", 45],
        gtranslate: ["\u8c37\u6b4c\u7ffb\u8bd1", 46],
        hemidemi: ["\u9ed1\u7c73\u4e66\u7b7e", 47],
        hexunmb: ["\u548c\u8baf\u5fae\u535a", 48],
        huaban: ["\u82b1\u74e3", 49],
        ifengkb: ["\u51e4\u51f0\u5feb\u535a", 50],
        ifengmb: ["\u51e4\u51f0\u5fae\u535a", 51],
        ifensi: ["\u7c89\u4e1d\u7f51", 52],
        instapaper: ["Instapaper", 53],
        itieba: ["i\u8d34\u5427", 54],
        joinwish: ["\u597d\u613f\u7f51", 55],
        kaixin001: ["\u5f00\u5fc3\u7f51", 56],
        laodao: ["\u5520\u53e8\u7f51", 57],
        leihou: ["\u96f7\u7334", 58],
        leshou: ["\u4e50\u6536", 59],
        linkedin: ["LinkedIn", 60],
        livespace: ["MS Livespace", 61],
        mala: ["\u9ebb\u8fa3\u5fae\u535a", 63],
        masar: ["\u739b\u6492\u7f51", 65],
        meilishuo: ["\u7f8e\u4e3d\u8bf4", 66],
        miliao: ["\u7c73\u804a", 67],
        mister_wong: ["Mister Wong", 68],
        mogujie: ["\u8611\u83c7\u8857", 69],
        moptk: ["\u732b\u6251\u63a8\u5ba2", 70],
        msn: ["MSN", 71],
        myshare: ["MyShare", 72],
        myspace: ["MySpace", 73],
        neteasemb: ["\u7f51\u6613\u5fae\u535a", 74],
        netvibes: ["Netvibes", 75],
        peoplemb: ["\u4eba\u6c11\u5fae\u535a", 76],
        pinterest: ["Pinterest", 79],
        poco: ["Poco\u7f51", 81],
        printer: ["\u6253\u5370", 82],
        printf: ["Print Friendly", 83],
        qqmb: ["\u817e\u8baf\u5fae\u535a", 84],
        qqshuqian: ["QQ\u4e66\u7b7e", 85],
        qqxiaoyou: ["\u670b\u53cb\u7f51", 86],
        qzone: ["QQ\u7a7a\u95f4", 87],
        readitlater: ["ReadItLater", 88],
        reddit: ["Reddit", 89],
        redmb: ["\u7ea2\u5fae\u535a", 90],
        renjian: ["\u4eba\u95f4\u7f51", 91],
        renmaiku: ["\u4eba\u8109\u5e93", 92],
        renren: ["\u4eba\u4eba\u7f51", 93],
        shouji: ["\u624b\u673a", 95],
        sinaminiblog: ["\u65b0\u6d6a\u5fae\u535a", 96],
        sinaqing: ["\u65b0\u6d6aQing", 97],
        sinavivi: ["\u65b0\u6d6aVivi", 98],
        sohubai: ["\u641c\u72d0\u767d\u793e\u4f1a", 99],
        sohuminiblog: ["\u641c\u72d0\u5fae\u535a", 100],
        southmb: ["\u5357\u65b9\u5fae\u535a", 101],
        stumbleupon: ["StumbleUpon", 102],
        szone: ["\u5b88\u682a\u7f51", 103],
        taojianghu: ["\u6dd8\u6c5f\u6e56", 104],
        tianya: ["\u5929\u6daf", 105],
        tongxue: ["\u540c\u5b66\u5fae\u535a", 106],
        tuita: ["\u63a8\u4ed6", 107],
        tumblr: ["Tumblr", 108],
        twitter: ["Twitter", 109],
        ushi: ["\u4f18\u58eb\u7f51", 110],
        waakee: ["\u6316\u5ba2", 112],
        wealink: ["\u82e5\u90bb\u7f51", 113],
        woshao: ["\u6211\u70e7\u7f51", 115],
        xianguo: ["\u9c9c\u679c\u7f51", 116],
        xiaomeisns: ["\u6821\u5a92\u91c7\u901a", 117],
        xinminmb: ["\u65b0\u6c11\u5fae\u535a", 118],
        xyweibo: ["\u5fae\u535a\u6821\u56ed", 119],
        yaolanmb: ["\u6447\u7bee\u5fae\u535a", 120],
        yijee: ["\u6613\u96c6\u7f51", 121],
        youdao: ["\u6709\u9053\u4e66\u7b7e", 122],
        zjol: ["\u6d59\u6c5f\u5fae\u535a", 124],
        xinhuamb: ["\u65b0\u534e\u5fae\u535a"],
        szmb: ["\u6df1\u5733\u5fae\u535a"],
        changshamb: ["\u5fae\u957f\u6c99"],
        hefeimb: ["\u5408\u80a5\u5fae\u535a"],
        wansha: ["\u73a9\u5565e\u65cf"],
        "189share": ["\u624b\u673a\u5feb\u4f20"],
        diandian: ["\u70b9\u70b9\u7f51"],
        tianji: ["\u5929\u9645\u7f51"],
        jipin: ["\u5f00\u5fc3\u96c6\u54c1"],
        chezhumb: ["\u8f66\u4e3b\u5fae\u535a"],
        gplus: ["Google+"],
        yidongweibo: ["\u79fb\u52a8\u5fae\u535a"],
        youdaonote: ["\u6709\u9053\u7b14\u8bb0"],
        jschina: ["\u5fae\u6c5f\u82cf"],
        mingdao: ["\u660e\u9053"],
        jxcn: ["\u6c5f\u897f\u5fae\u535a"],
        qileke: ["\u5947\u4e50\u6536\u85cf"],
        sohukan: ["\u641c\u72d0\u968f\u8eab\u770b"],
        maikunote: ["\u9ea6\u5e93\u8bb0\u4e8b"],
        lezhimark: ["\u4e50\u77e5\u4e66\u7b7e"],
        "189mail": ["189\u90ae\u7bb1"],
        wo: ["WO+\u5206\u4eab"],
        gmweibo: ["\u5149\u660e\u5fae\u535a"],
        jianweibo: ["\u5409\u5b89\u5fae\u535a"],
        qingbiji: ["\u8f7b\u7b14\u8bb0"],
        duankou: ["\u7aef\u53e3\u7f51"],
        qqim: ["QQ\u597d\u53cb"],
        kdweibo: ["\u4e91\u4e4b\u5bb6"],
        xueqiu: ["\u96ea\u7403"]
    };
    g.defaultBps = "bsharesync,sinaminiblog,qqmb,renren,qzone,sohuminiblog,douban,kaixin001,baiduhi,qqxiaoyou,neteasemb,ifengmb,email,facebook,twitter,tianya,clipboard".split(",");
    g.boldPlatforms = [];
    g.redPlatforms = ["bsharesync", "xinhuamb"];
    g.arrayIsHot = ["bsharesync", "qzone"];
    g.arrayIsNew = ["chinanews", "peoplemb", "moptk", "woshao"];
    g.arrayIsRec = ["renren", "sohuminiblog", "feixin", "tianya"];
    g.arrayIsAwd = g.isLite ? ["bsharesync"] : "sinaminiblog,qqmb,renren,neteasemb,sohuminiblog,kaixin001,qzone,tianya,bsharesync".split(",");
    g.iL8n = {
        promoteHot: "\u70ed",
        promoteNew: "\u65b0",
        promoteRec: "\u63a8\u8350",
        rtnTxt: "\u9009\u62e9\u5176\u4ed6\u5e73\u53f0 >>",
        shareText: "\u5206\u4eab\u5230",
        shareTextShort: "\u5206\u4eab",
        shareTextPromote: "\u5206\u4eab\u6709\u793c",
        morePlats: "\u66f4\u591a\u5e73\u53f0...",
        morePlatsShort: "\u66f4\u591a...",
        whatsThis: "\u8fd9\u662f\u4ec0\u4e48\u5de5\u5177\uff1f",
        promote: "\u5206\u4eab\u6709\u793c",
        promoteShort: "\u5956",
        searchHint: "\u8f93\u5165\u5e73\u53f0\u5173\u952e\u5b57\u67e5\u8be2",
        closeHint: "30\u5206\u949f\u5185\u4e0d\u518d\u51fa\u73b0\u6b64\u5206\u4eab\u6846",
        loadFailed: "\u7f51\u7edc\u592a\u6162\u65e0\u6cd5\u52a0\u8f7d\uff0c\u8bf7\u7a0d\u540e\u518d\u8bd5\u3002",
        loadFailed2: "\u5f88\u62b1\u6b49\uff0c\u65e0\u6cd5\u8fde\u63a5\u670d\u52a1\u5668\u3002\u8bf7\u7a0d\u540e\u91cd\u8bd5\uff01",
        notSupport: "\u4e0d\u652f\u6301\uff01",
        copySuccess: "\u590d\u5236\u6210\u529f\uff01\u60a8\u53ef\u4ee5\u7c98\u8d34\u5230QQ/MSN\u4e0a\u5206\u4eab\u7ed9\u60a8\u7684\u597d\u53cb\uff01",
        copyTip: "\u8bf7\u6309Ctrl+C\u590d\u5236\uff0c\u7136\u540e\u60a8\u53ef\u4ee5\u7c98\u8d34\u5230QQ/MSN\u4e0a\u5206\u4eab\u7ed9\u60a8\u7684\u597d\u53cb\uff01",
        bookmarkTip: "\u6309\u4e86OK\u4ee5\u540e\uff0c\u8bf7\u6309Ctrl+D\uff08Macs\u7528Command+D\uff09\u3002",
        confirmClose: "\u5173\u95ed\u540e\uff0c\u8be5\u5206\u4eab\u6309\u94ae30\u5206\u949f\u5c06\u4e0d\u518d\u51fa\u73b0\uff0c\u60a8\u4e5f\u65e0\u6cd5\u4f7f\u7528\u5206\u4eab\u529f\u80fd\uff0c\u786e\u5b9a\u5417\uff1f"
    }
})();