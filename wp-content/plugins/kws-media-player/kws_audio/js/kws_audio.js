/*
 * MediaPlayer - HTML5 Audio Player - v1.0
 */

(function (d) {
    function na(a) {
        a = document.getElementById(a.audioID);
        return !(!a.canPlayType || !a.canPlayType("audio/mpeg;").replace(/no/, ""))
    }
    function ha(a, c, f, g, k, n, e, L, C, z, m, M, Q, E) {
        if (!c.shuffle || !a.is_very_first) {
            a.totalTime = "Infinity";
            c.isSliderInitialized && (n.slider("destroy"), c.isSliderInitialized = !1);
            c.isProgressInitialized && (e.progressbar("destroy"), c.isProgressInitialized = !1);
            a.is_changeSrc = !0;
            a.is_buffer_complete = !1;
            z.width(a.titleWidth);
            M.width(a.titleWidth);
            e.css({
                background: c.bufferEmptyColor
            });
            a.curSongText = "";
            c.showTitle && null != a.playlist_arr[a.origID].title && "" != a.playlist_arr[a.origID].title && (a.curSongText += a.playlist_arr[a.origID].title);
            a.isAuthorTitleInsideScrolling = !1;
            a.authorTitleInsideWait = 0;
            m.stop();
            m.css({
                "margin-left": 0
            });
            m.html(a.curSongText);
            c.showAuthor && null != a.playlist_arr[a.origID].author && "" != a.playlist_arr[a.origID].author && (M.html(a.playlist_arr[a.origID].author), null != a.playlist_arr[a.origID].authorlink && "" != a.playlist_arr[a.origID].authorlink && M.html('<a href="' +
                    a.playlist_arr[a.origID].authorlink + '" target="' + a.playlist_arr[a.origID].authorlinktarget + '" style="color:' + c.songAuthorColor + ';">' + a.playlist_arr[a.origID].author + "</a>"));
            E.html('<img src="' + a.playlist_arr[a.origID].image + '" width="149">');
            a.curSongText || z.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            });
            d(a.thumbsHolder_Thumbs[a.current_img_no]).css({
                background: c.playlistRecordBgOnColor,
                "border-bottom-color": c.playlistRecordBottomBorderOnColor,
                color: c.playlistRecordTextOnColor
            });
            a.is_very_first ||
            da(-1, a, c, f);
            f = a.playlist_arr[a.origID].sources_mp3;
            if (-1 != t.indexOf("opera") || -1 != t.indexOf("firefox") || -1 != t.indexOf("mozzila"))
                f = a.playlist_arr[a.origID].sources_ogg, "" != na(a) && (f = a.playlist_arr[a.origID].sources_mp3);
            if (-1 != t.indexOf("chrome") || -1 != t.indexOf("msie") || -1 != t.indexOf("safari"))
                f = a.playlist_arr[a.origID].sources_mp3, -1 != t.indexOf("opr") && (f = a.playlist_arr[a.current_img_no].sources_ogg, "" != na(a) && (f = a.playlist_arr[a.origID].sources_mp3));
            -1 != t.indexOf("android") && (f = a.playlist_arr[a.origID].sources_mp3);
            if (-1 != t.indexOf("ipad") || -1 != t.indexOf("iphone") || -1 != t.indexOf("ipod") || -1 != t.indexOf("webos"))
                f = a.playlist_arr[a.origID].sources_mp3;
            document.getElementById(a.audioID).src = f;
            document.getElementById(a.audioID).load();
            c.googleTrakingOn && ga("send", "event", "Audio Files", "Play", "Title: " + a.playlist_arr[a.origID].title + "  ---  File: " + f);
            -1 != t.indexOf("android") || (-1 != t.indexOf("ipad") || -1 != t.indexOf("iphone") || -1 != t.indexOf("ipod") || -1 != t.indexOf("webos")) && a.is_very_first || (c.autoPlay ? (ia(c, g), document.getElementById(a.audioID).play(),
                    k.addClass("AudioPause"), W(c, a, g, !0)) : (k.removeClass("AudioPause"), W(c, a, g, !1)))
        }
    }
    function ea(a) {
        var c = 10 > Math.floor(a / 60) ? "0" + Math.floor(a / 60) : Math.floor(a / 60);
        return c + ":" + (10 > Math.floor(a - 60 * c) ? "0" + Math.floor(a - 60 * c) : Math.floor(a - 60 * c))
    }
    function ja(a, c, f, g, k, n, e, L, C) {
        a.is_changeSrc = !1;
        a.is_very_first && (a.is_very_first = !1);
        k.width(a.bufferWidth);
        a.bufferTopPos = a.timerTopPos + parseInt((n.height() - k.height()) / 2, 10) + 1;
        a.bufferLeftPos = parseInt(a.timerLeftPos + n.width() + 11);
        k.css({
            top: a.bufferTopPos + "px",
            left: a.bufferLeftPos + "px"
        });
        g.width(k.width());
        g.css({
            top: a.bufferTopPos + "px",
            left: a.bufferLeftPos + "px"
        });
        g.slider({
            value: 0,
            step: .01,
            orientation: "horizontal",
            range: "min",
            max: a.totalTime,
            slide: function () {
                a.is_seeking = !0
            },
            stop: function (z, m) {
                a.is_seeking = !1;
                document.getElementById(a.audioID).currentTime = m.value
            },
            create: function (z, m) {
                c.isSliderInitialized = !0
            }
        });
        d(".ui-slider-range", g).css({
            background: c.seekbarColor
        });
        k.progressbar({
            value: 0,
            complete: function () {
                a.is_buffer_complete = !0
            },
            create: function (z,
                m) {
                c.isProgressInitialized = !0
            }
        });
        d(".ui-widget-header", k).css({
            background: c.bufferFullColor
        })
    }
    function ra(a, c, f, g, k, n, e, L, C, z, m) {
        !a.isAuthorTitleInsideScrolling && 5 <= a.authorTitleInsideWait && m.width() > a.titleWidth ? (a.isAuthorTitleInsideScrolling = !0, a.authorTitleInsideWait = 0, m.html(a.curSongText + " **** " + a.curSongText + " **** " + a.curSongText + " **** " + a.curSongText + " **** " + a.curSongText + " **** "), m.css({
                "margin-left": 0
            }), m.stop().animate({
                "margin-left": c.playerWidth - m.width() + "px"
            }, parseInt(1E4 * (m.width() -
                        c.playerWidth) / 150, 10), "linear", function () {
                a.isAuthorTitleInsideScrolling = !1
            })) : !a.isAuthorTitleInsideScrolling && m.width() > a.titleWidth && a.authorTitleInsideWait++;
        z = document.getElementById(a.audioID).currentTime;
        m = 0;
        a.is_changeSrc && !isNaN(a.totalTime) && "Infinity" != a.totalTime && (ja(a, c, f, g, k, n, e, L, C), -1 != t.indexOf("android") && (c.autoPlay ? (document.getElementById(a.audioID).play(), L.addClass("AudioPause")) : L.removeClass("AudioPause")));
        !a.is_seeking && c.isSliderInitialized && g.slider("value", z);
        -1 != t.indexOf("android") ?
        (a.totalTime != document.getElementById(a.audioID).duration && 0 < document.getElementById(a.audioID).duration && (a.totalTime = document.getElementById(a.audioID).duration, c.isSliderInitialized && (g.slider("destroy"), c.isSliderInitialized = !1), c.isProgressInitialized && (k.progressbar("destroy"), c.isProgressInitialized = !1), ja(a, c, f, g, k, n, e, L, C)), k.css({
                background: c.bufferFullColor
            }), isNaN(a.totalTime) || "Infinity" == a.totalTime ? (n.text("00:00"), e.text(ea(0))) : (n.text(ea(z)), e.text(ea(a.totalTime)))) : (document.getElementById(a.audioID).buffered.length &&
            (m = document.getElementById(a.audioID).buffered.end(document.getElementById(a.audioID).buffered.length - 1), 0 < m && !a.is_buffer_complete && !isNaN(a.totalTime) && "Infinity" != a.totalTime && c.isProgressInitialized && k.progressbar({
                    value: 100 * m / a.totalTime
                })), n.text(ea(z)), isNaN(a.totalTime) || "Infinity" == a.totalTime ? e.text(ea(m)) : e.text(ea(a.totalTime)));
        F(c, "cookie_timePlayed", z)
    }
    function da(a, c, f, g) {
        if (c.selectedCateg_total_images > f.numberOfThumbsPerScreen) {
            var k = (c.thumbsHolder_ThumbHeight + 1) * (c.selectedCateg_total_images -
                f.numberOfThumbsPerScreen);
            g.stop(!0, !0);
            d("html, body").off("touchstart touchmove").on("touchstart touchmove", function (n) {
                n.preventDefault()
            });
            -1 == a || c.isCarouselScrolling ? !c.isCarouselScrolling && c.selectedCateg_total_images > f.numberOfThumbsPerScreen && (c.isCarouselScrolling = !0, a = -1 * parseInt((c.thumbsHolder_ThumbHeight + 1) * c.current_img_no, 10), Math.abs(a) > k && (a = -1 * k), c.selectedCateg_total_images > f.numberOfThumbsPerScreen && f.showPlaylist && c.kws_audio_sliderVertical.slider("value", 100 + parseInt(100 *
                        a / k)), g.animate({
                    top: a + "px"
                }, 500, "easeOutCubic", function () {
                    c.isCarouselScrolling = !1;
                    d("html, body").off("touchstart touchmove").on("touchstart touchmove", function (n) {})
                })) : (a = 2 >= a ? -1 * k : parseInt(k * (a - 100) / 100, 10), 1 <= a && (a = 0), 0 >= a && (c.isCarouselScrolling = !0, g.animate({
                        top: a + "px"
                    }, 600, "easeOutQuad", function () {
                        c.isCarouselScrolling = !1;
                        d("html, body").off("touchstart touchmove").on("touchstart touchmove", function (n) {})
                    })))
        }
    }
    function ka(a, c, f, g, k, n, e, L, C, z, m, M, Q, E, O, u, X, G, T, J, N, K, v, p, l, w, q, r, x, D, H, ba, b,
        A, U, S, P) {
        a.imageTopPos = -27;
        a.imageLeftPos = a.constantDistance;
        c.showVinylRecord ? (J.css({
                display: "none"
            }), N.css({
                top: a.imageTopPos + "px",
                left: a.imageLeftPos + "px"
            }), K.css({
                top: a.imageTopPos + "px",
                left: a.imageLeftPos + "px"
            })) : (N.css({
                visibility: "hidden",
                display: "none"
            }), K.css({
                visibility: "hidden",
                display: "none"
            }), J.css({
                top: a.imageTopPos + "px",
                left: a.imageLeftPos + "px"
            }));
        c.playerWidth < a.stickyFixedPlayerWidth ? l.css({
            display: "none"
        }) : l.css({
            display: "block"
        });
        645 > c.playerWidth ? c.showVinylRecord ? (N.css({
                visibility: "hidden",
                display: "none"
            }), K.css({
                visibility: "hidden",
                display: "none"
            })) : J.css({
            display: "none"
        }) : c.showVinylRecord ? document.getElementById(a.audioID).paused ? (N.css({
                visibility: "hidden",
                display: "none"
            }), K.css({
                visibility: "visible",
                display: "block"
            })) : (N.css({
                visibility: "visible",
                display: "block"
            }), K.css({
                visibility: "hidden",
                display: "none"
            })) : J.css({
            display: "block"
        });
        460 > c.playerWidth ? (G.css({
                display: "none"
            }), u.css({
                display: "none"
            })) : (c.showAuthor && G.css({
                display: "block"
            }), c.showTitle && u.css({
                display: "block"
            }));
        395 > c.playerWidth ? (M.css({
                display: "none"
            }), Q.css({
                display: "none"
            }), E.css({
                "margin-left": "7px"
            }), O.css({
                display: "none"
            })) : (M.css({
                display: "block"
            }), Q.css({
                display: "block"
            }), E.css({
                "margin-left": "0px"
            }), O.css({
                display: "block"
            }));
        345 > c.playerWidth ? (w.css({
                display: "none"
            }), q.css({
                display: "none"
            })) : (w.css({
                display: "block"
            }), q.css({
                display: "block"
            }));
        a.audioPlayerHeight = J.height() + a.imageTopPos;
        f.height(a.audioPlayerHeight);
        a.playTopPos = 15;
        a.playLeftPos = 645 > c.playerWidth ? a.imageLeftPos : a.imageLeftPos + J.width() +
            24;
        m.css({
            top: a.playTopPos + "px",
            left: a.playLeftPos + "px"
        });
        a.bufferWidth = c.playerWidth - (a.playLeftPos + 5) - 2 * E.width() - 2 * a.seekBarLeftRightSpacing - 2 * c.playerPadding - 260 - 20;
        u.css({
            color: c.songTitleColor
        });
        G.css({
            color: c.songAuthorColor
        });
        "none" == l.css("display") ? a.titleWidth = a.bufferWidth + E.width() + 2 * a.seekBarLeftRightSpacing + a.constantDistance - m.width() : a.titleWidth = a.bufferWidth + 2 * E.width() + 2 * a.seekBarLeftRightSpacing - m.width() - l.width() - (a.constantDistance + 25 + 20);
        u.width(a.titleWidth);
        G.width(a.titleWidth);
        a.authorTopPos = 20;
        a.authorLeftPos = a.playLeftPos + m.width() + a.constantDistance;
        a.titleTopPos = a.authorTopPos + G.height() + 10;
        a.titleLeftPos = a.authorLeftPos;
        G.css({
            top: a.authorTopPos + "px",
            left: a.authorLeftPos + "px"
        });
        u.css({
            top: a.titleTopPos + "px",
            left: a.titleLeftPos + "px"
        });
        a.timerTopPos = a.playTopPos + m.height() + a.constantDistance;
        a.timerLeftPos = a.playLeftPos + 5;
        E.css({
            color: c.timerColor,
            top: a.timerTopPos + "px",
            left: a.timerLeftPos + "px"
        });
        O.css({
            color: c.timerColor,
            top: a.timerTopPos + "px",
            left: a.timerLeftPos + E.width() +
            a.seekBarLeftRightSpacing + a.bufferWidth + a.seekBarLeftRightSpacing + "px"
        });
        a.bufferLeftPos = parseInt(a.timerLeftPos + E.width() + 11);
        Q.css({
            left: a.bufferLeftPos + "px"
        });
        M.css({
            left: a.bufferLeftPos + "px"
        });
        a.thebarsTopPos = a.playTopPos;
        a.thebarsLeftPos = a.titleLeftPos + a.titleWidth + 25 + 91;
        l.css({
            top: a.thebarsTopPos + "px",
            left: a.thebarsLeftPos + "px"
        });
        a.volumeTopPos = a.timerTopPos;
        a.volumeLeftPos = parseInt(O.css("left").substr(0, O.css("left").lastIndexOf("px")), 10) + O.width() + 20;
        w.css({
            top: a.volumeTopPos + "px",
            left: a.volumeLeftPos +
            "px"
        });
        a.volumesliderTopPos = a.volumeTopPos - q.height() - w.height();
        a.volumesliderLeftPos = a.volumeLeftPos + 1;
        q.css({
            top: a.volumesliderTopPos + "px",
            left: a.volumesliderLeftPos + "px"
        });
        a.shuffleTopPos = a.playTopPos + 5;
        a.shuffleLeftPos = a.volumeLeftPos + 2 * a.constantDistance + 10;
        r.css({
            top: a.shuffleTopPos + "px",
            left: a.shuffleLeftPos + "px"
        });
        c.shuffle && r.addClass("AudioShuffleON");
        c.showShuffleBut || (r.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            }), a.shuffleLeftPos = a.volumeLeftPos + a.constantDistance + 10);
        a.downloadTopPos =
            a.shuffleTopPos;
        a.downloadLeftPos = a.shuffleLeftPos + r.width() + a.constantDistance + 3;
        x.css({
            top: a.downloadTopPos + "px",
            left: a.downloadLeftPos + "px"
        });
        c.showDownloadBut || (x.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            }), a.downloadLeftPos = a.shuffleLeftPos + r.width());
        a.showhideplaylistTopPos = a.shuffleTopPos;
        a.showhideplaylistLeftPos = a.downloadLeftPos + x.width() + a.constantDistance + 3;
        D.css({
            top: a.showhideplaylistTopPos + "px",
            left: a.showhideplaylistLeftPos + "px"
        });
        c.showPlaylistBut || (D.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            }), a.showhideplaylistLeftPos = a.downloadLeftPos + x.width());
        a.lyricsTopPos = a.shuffleTopPos;
        a.lyricsLeftPos = a.showhideplaylistLeftPos + D.width() + a.constantDistance + 3;
        H.css({
            top: a.lyricsTopPos + "px",
            left: a.lyricsLeftPos + "px"
        });
        c.showLyricsBut || (H.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            }), a.lyricsLeftPos = a.showhideplaylistLeftPos + D.width());
        a.facebookTopPos = a.shuffleTopPos;
        a.facebookLeftPos = a.lyricsLeftPos + H.width() + a.constantDistance;
        ba.css({
            top: a.facebookTopPos +
            "px",
            left: a.facebookLeftPos + "px"
        });
        c.showFacebookBut || (ba.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            }), a.facebookLeftPos = a.lyricsLeftPos + H.width());
        a.twitterTopPos = a.shuffleTopPos;
        a.twitterLeftPos = a.facebookLeftPos + ba.width() + a.constantDistance + 3;
        b.css({
            top: a.twitterTopPos + "px",
            left: a.twitterLeftPos + "px"
        });
        c.showTwitterBut || (b.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            }), a.twitterLeftPos = a.facebookLeftPos + ba.width());
        a.popupTopPos = a.shuffleTopPos;
        a.popupLeftPos = a.twitterLeftPos +
            b.width() + a.constantDistance + 3;
        p.css({
            top: a.popupTopPos + "px",
            left: a.popupLeftPos + "px"
        });
        c.showPopupBut || (p.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            }), a.popupLeftPos = a.twitterLeftPos + b.width());
        a.rewindTopPos = a.constantDistance - 2;
        a.rewindLeftPos = a.volumeLeftPos + 2 * a.constantDistance + 10 - 3;
        A.css({
            bottom: a.rewindTopPos + "px",
            left: a.rewindLeftPos + "px"
        });
        c.showRewindBut || (A.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            }), a.rewindLeftPos -= parseInt(a.constantDistance / 2, 10));
        a.previousTopPos =
            a.rewindTopPos;
        a.previousLeftPos = a.rewindLeftPos + A.width() + parseInt(a.constantDistance / 2, 10);
        U.css({
            bottom: a.previousTopPos + "px",
            left: a.previousLeftPos + "px"
        });
        a.nextTopPos = a.rewindTopPos;
        a.nextLeftPos = a.previousLeftPos + U.width() + parseInt(a.constantDistance / 2, 10);
        S.css({
            bottom: a.nextTopPos + "px",
            left: a.nextLeftPos + "px"
        });
        c.showNextPrevBut || (U.css({
                display: "none"
            }), S.css({
                display: "none"
            }));
        a.buyTopPos = a.rewindTopPos;
        a.buyLeftPos = a.constantDistance;
        P.css({
            bottom: a.buyTopPos + "px",
            right: a.buyLeftPos + "px"
        });
        c.showBuyBut || P.css({
            display: "none",
            width: 0,
            height: 0,
            padding: 0,
            margin: 0
        })
    }
    function sa(a, c, f, g, k, n, e, L, C, z, m, M, Q, E, O, u, X, G, T, J, N, K) {
        g.stop(!0, !0);
        a.isCarouselScrolling = !1;
        g.stop().animate({
            left: -1 * n.width() + "px"
        }, 600, "easeOutQuad", function () {
            g.html("");
            for (var v = 0; v < a.category_arr.length; v++)
                a.thumbsHolder_Thumb = d('<div class="thumbsHolder_ThumbOFF" rel="' + v + '"><div class="padding">' + a.category_arr[v] + "</div></div>"), g.append(a.thumbsHolder_Thumb), a.thumbsHolder_Thumb.css({
                    top: (a.thumbsHolder_Thumb.height() +
                        1) * v + "px",
                    background: c.categoryRecordBgOffColor,
                    "border-bottom-color": c.categoryRecordBottomBorderOffColor,
                    color: c.categoryRecordTextOffColor
                }), a.category_arr[v] == a.selectedCateg && (a.current_img_no = v, a.thumbsHolder_Thumb.css({
                        background: c.categoryRecordBgOnColor,
                        "border-bottom-color": c.categoryRecordBottomBorderOnColor,
                        color: c.categoryRecordTextOnColor
                    }));
            a.selectedCateg_total_images = a.numberOfCategories;
            a.categsAreListed = !0;
            k.height(2 * c.playlistPadding + (a.thumbsHolder_Thumb.height() + 1) * c.numberOfThumbsPerScreen +
                e.height() + C.height() + 2 * c.selectedCategMarginBottom);
            n.height((a.thumbsHolder_Thumb.height() + 1) * c.numberOfThumbsPerScreen);
            z.css({
                padding: c.playlistPadding + "px"
            });
            a.thumbsHolder_Thumbs = d(".thumbsHolder_ThumbOFF", f);
            a.numberOfCategories > c.numberOfThumbsPerScreen && c.showPlaylist ? (c.isPlaylistSliderInitialized && a.kws_audio_sliderVertical.slider("destroy"), a.kws_audio_sliderVertical.slider({
                    orientation: "vertical",
                    range: "min",
                    min: 1,
                    max: 100,
                    step: 1,
                    value: 100,
                    slide: function (p, l) {
                        da(l.value, a, c, g)
                    }
                }),
                c.isPlaylistSliderInitialized = !0, a.kws_audio_sliderVertical.css({
                    display: "inline",
                    position: "absolute",
                    height: k.height() - 20 - e.height() - 2 * c.selectedCategMarginBottom - C.height() - 2 * c.playlistPadding + "px",
                    left: f.width() + 2 * c.playerPadding - a.kws_audio_sliderVertical.width() - c.playlistPadding + "px",
                    top: a.audioPlayerHeight + c.playlistTopPos + c.playlistPadding + e.height() + c.selectedCategMarginBottom + 2 + "px"
                }), c.showPlaylistOnInit || a.kws_audio_sliderVertical.css({
                    opacity: 0,
                    display: "none"
                }), c.showPlaylistOnInit =
                    !0, d(".thumbsHolder_ThumbOFF", f).css({
                    width: f.width() + 2 * c.playerPadding - a.kws_audio_sliderVertical.width() - 2 * c.playlistPadding - 3 + "px"
                })) : (c.isPlaylistSliderInitialized && (a.kws_audio_sliderVertical.slider("destroy"), c.isPlaylistSliderInitialized = !1), d(".thumbsHolder_ThumbOFF", f).css({
                    width: f.width() + 2 * c.playerPadding - 2 * c.playlistPadding + "px"
                }));
            a.thumbsHolder_Thumbs.on("click", function () {
                var p = d(this).attr("rel");
                a.selectedCateg = a.category_arr[p];
                F(c, "cookie_firstCateg", a.selectedCateg);
                L.html(a.selectedCateg);
                la(a, c, f, g, k, n, e, C, z, m, M, Q, E, O, u, X, G, T, J, N, K)
            });
            a.thumbsHolder_Thumbs.on("mouseover", function () {
                var p = d(this),
                l = "transparent";
                "#" != c.categoryRecordBgOnColor && (l = c.categoryRecordBgOnColor);
                p.css({
                    background: l,
                    "border-bottom-color": c.categoryRecordBottomBorderOnColor,
                    color: c.categoryRecordTextOnColor
                })
            });
            a.thumbsHolder_Thumbs.on("mouseout", function () {
                var p = d(this),
                l = "transparent";
                "#" != c.categoryRecordBgOffColor && (l = c.categoryRecordBgOffColor);
                var w = p.attr("rel");
                a.current_img_no != w && p.css({
                    background: l,
                    "border-bottom-color": c.categoryRecordBottomBorderOffColor,
                    color: c.categoryRecordTextOffColor
                })
            });
            n.mousewheel(function (p, l, w, q) {
                p.preventDefault();
                a.selectedCateg_total_images > c.numberOfThumbsPerScreen && (p = a.kws_audio_sliderVertical.slider("value"), 1 < parseInt(p) && -1 == parseInt(l) || 100 > parseInt(p) && 1 == parseInt(l)) && (p += l, a.kws_audio_sliderVertical.slider("value", p), da(p, a, c, g))
            });
            g.css({
                top: "0px"
            });
            g.stop().animate({
                left: "0px"
            }, 400, "easeOutQuad", function () {})
        })
    }
    function la(a, c, f, g, k, n, e, L, C,
        z, m, M, Q, E, O, u, X, G, T, J, N) {
        g.stop(!0, !0);
        a.isCarouselScrolling = !1;
        var K = "",
        v = !1,
        p = 500;
        a.is_very_first && (p = 1);
        "" != a.search_val && (p = 1);
        g.stop().animate({
            left: -1 * n.width() + "px"
        }, p, "easeOutQuad", function () {
            g.html("");
            for (var l = a.selectedCateg_total_images = 0; l < a.playlist_arr.length; l++) {
                v = !1;
                if ("" != a.search_val) {
                    if (K = a.playlist_arr[l].title.toLowerCase(), -1 != K.indexOf(a.search_val) && (v = !0), c.searchAuthor) {
                        var w = a.playlist_arr[l].author.toLowerCase();
                        -1 != w.indexOf(a.search_val) && (v = !0)
                    }
                } else  - 1 != a.playlist_arr[l].category.indexOf(a.selectedCateg +
                        ";") && (v = !0);
                v && (a.selectedCateg_total_images++, a.thumbsHolder_Thumb = d('<div class="thumbsHolder_ThumbOFF" rel="' + (a.selectedCateg_total_images - 1) + '" data-origID="' + l + '"><div class="padding">' + (c.showPlaylistNumber ? a.selectedCateg_total_images + ". " : "") + a.playlist_arr[l].title + "</div></div>"), g.append(a.thumbsHolder_Thumb), 0 == a.thumbsHolder_ThumbHeight && (a.thumbsHolder_ThumbHeight = a.thumbsHolder_Thumb.height()), w = "transparent", "#" != c.playlistRecordBgOffColor && (w = c.playlistRecordBgOffColor), a.thumbsHolder_Thumb.css({
                        top: (a.thumbsHolder_ThumbHeight +
                            1) * a.selectedCateg_total_images + "px",
                        background: w,
                        "border-bottom-color": c.playlistRecordBottomBorderOffColor,
                        color: c.playlistRecordTextOffColor
                    }), a.current_img_no = 0, a.origID == d("div[rel='" + (a.selectedCateg_total_images - 1) + "']").attr("data-origID") && a.thumbsHolder_Thumb.css({
                        background: c.playlistRecordBgOnColor,
                        "border-bottom-color": c.playlistRecordBottomBorderOnColor,
                        color: c.playlistRecordTextOnColor
                    }))
            }
            a.categsAreListed = !1;
            k.height(2 * c.playlistPadding + (a.thumbsHolder_ThumbHeight + 1) * c.numberOfThumbsPerScreen +
                e.height() + L.height() + 2 * c.selectedCategMarginBottom);
            n.height((a.thumbsHolder_ThumbHeight + 1) * c.numberOfThumbsPerScreen);
            C.css({
                padding: c.playlistPadding + "px"
            });
            a.thumbsHolder_Thumbs = d(".thumbsHolder_ThumbOFF", f);
            l = a.audioPlayerHeight + k.height() + c.playlistTopPos;
            c.showPlaylist && c.showPlaylistOnInit || (l = a.audioPlayerHeight);
            J.css({
                width: f.width() + 2 * c.playerPadding + "px",
                height: l + "px"
            });
            a.selectedCateg_total_images > c.numberOfThumbsPerScreen && c.showPlaylist ? (c.isPlaylistSliderInitialized && a.kws_audio_sliderVertical.slider("destroy"),
                a.kws_audio_sliderVertical.slider({
                    orientation: "vertical",
                    range: "min",
                    min: 1,
                    max: 100,
                    step: 1,
                    value: 100,
                    slide: function (q, r) {
                        da(r.value, a, c, g)
                    }
                }), c.isPlaylistSliderInitialized = !0, a.kws_audio_sliderVertical.css({
                    display: "inline",
                    position: "absolute",
                    height: k.height() - 20 - e.height() - 2 * c.selectedCategMarginBottom - L.height() - 2 * c.playlistPadding + "px",
                    left: f.width() + 2 * c.playerPadding - a.kws_audio_sliderVertical.width() - c.playlistPadding + "px",
                    top: a.audioPlayerHeight + c.playlistTopPos + c.playlistPadding +
                    e.height() + c.selectedCategMarginBottom + 2 + "px"
                }), c.showPlaylistOnInit || a.kws_audio_sliderVertical.css({
                    opacity: 0,
                    display: "none"
                }), c.showPlaylistOnInit = !0, d(".thumbsHolder_ThumbOFF", f).css({
                    width: f.width() + 2 * c.playerPadding - a.kws_audio_sliderVertical.width() - 2 * c.playlistPadding - 3 + "px"
                })) : (c.isPlaylistSliderInitialized && (a.kws_audio_sliderVertical.slider("destroy"), c.isPlaylistSliderInitialized = !1), d(".thumbsHolder_ThumbOFF", f).css({
                    width: f.width() + 2 * c.playerPadding - 2 * c.playlistPadding + "px"
                }));
            a.thumbsHolder_Thumbs.on("click", function () {
                if (!a.is_changeSrc) {
                    c.autoPlay = !0;
                    var q = d(this).attr("rel"),
                    r = "transparent";
                    "#" != c.playlistRecordBgOffColor && (r = c.playlistRecordBgOffColor);
                    a.thumbsHolder_Thumbs.css({
                        background: r,
                        "border-bottom-color": c.playlistRecordBottomBorderOffColor,
                        color: c.playlistRecordTextOffColor
                    });
                    a.current_img_no = q;
                    a.origID = d("div[rel='" + a.current_img_no + "']").attr("data-origID");
                    c.continuouslyPlayOnAllPages && (F(c, "cookie_current_img_no", a.current_img_no), F(c, "cookie_origID",
                            a.origID));
                    ha(a, c, g, f, z, m, M, Q, E, O, u, X, G, T)
                }
            });
            a.thumbsHolder_Thumbs.on("mouseover", function () {
                var q = d(this),
                r = "transparent";
                "#" != c.playlistRecordBgOnColor && (r = c.playlistRecordBgOnColor);
                q.css({
                    background: r,
                    "border-bottom-color": c.playlistRecordBottomBorderOnColor,
                    color: c.playlistRecordTextOnColor
                })
            });
            a.thumbsHolder_Thumbs.on("mouseout", function () {
                var q = d(this),
                r = "transparent";
                "#" != c.playlistRecordBgOffColor && (r = c.playlistRecordBgOffColor);
                var x = q.attr("rel");
                a.origID != d("div[rel='" + x + "']").attr("data-origID") &&
                q.css({
                    background: r,
                    "border-bottom-color": c.playlistRecordBottomBorderOffColor,
                    color: c.playlistRecordTextOffColor
                })
            });
            n.mousewheel(function (q, r, x, D) {
                q.preventDefault();
                a.selectedCateg_total_images > c.numberOfThumbsPerScreen && (q = a.kws_audio_sliderVertical.slider("value"), 1 < parseInt(q) && -1 == parseInt(r) || 100 > parseInt(q) && 1 == parseInt(r)) && (q += r, a.kws_audio_sliderVertical.slider("value", q), da(q, a, c, g))
            });
            g.css({
                top: "0px"
            });
            g.stop().animate({
                left: "0px"
            }, 400, "easeOutQuad", function () {});
            c.shuffle && void 0 ==
            a.cookie_current_img_no && (a.is_very_first = !1, N.click())
        })
    }
    function W(a, c, f, g) {
        c.isMinified || (0 == g ? (d(".sound", f).css({
                    "-webkit-animation-play-state": "paused",
                    "-moz-animation-play-state": "paused",
                    "-ms-animation-play-state": "paused",
                    "-o-animation-play-state": "paused",
                    "animation-play-state": "paused"
                }), d(".sound2", f).css({
                    "-webkit-animation-play-state": "paused",
                    "-moz-animation-play-state": "paused",
                    "-ms-animation-play-state": "paused",
                    "-o-animation-play-state": "paused",
                    "animation-play-state": "paused"
                }),
                645 > a.playerWidth ? a.showVinylRecord && (d(".pickUp_on", f).css({
                        visibility: "hidden",
                        display: "none"
                    }), d(".pickUp_off", f).css({
                        visibility: "hidden",
                        display: "none"
                    })) : a.showVinylRecord && (d(".pickUp_on", f).css({
                        visibility: "hidden",
                        display: "none"
                    }), d(".pickUp_off", f).css({
                        visibility: "visible",
                        display: "block"
                    }))) : (d(".sound", f).css({
                    "-webkit-animation-play-state": "running",
                    "-moz-animation-play-state": "running",
                    "-ms-animation-play-state": "running",
                    "-o-animation-play-state": "running",
                    "animation-play-state": "running"
                }),
                d(".sound2", f).css({
                    "-webkit-animation-play-state": "running",
                    "-moz-animation-play-state": "running",
                    "-ms-animation-play-state": "running",
                    "-o-animation-play-state": "running",
                    "animation-play-state": "running"
                }), 645 > a.playerWidth ? a.showVinylRecord && (d(".pickUp_on", f).css({
                        visibility: "hidden",
                        display: "none"
                    }), d(".pickUp_off", f).css({
                        visibility: "hidden",
                        display: "none"
                    })) : a.showVinylRecord && (d(".pickUp_on", f).css({
                        visibility: "visible",
                        display: "block"
                    }), d(".pickUp_off", f).css({
                        visibility: "hidden",
                        display: "none"
                    }))))
    }
    function oa(a) {
        var c,
        f;
        d("body *").each(function () {
            c = d(this);
            d.contains(c[0], a[0]) ? (a.unwrap(), oa(a)) : (f = this.className, f = String(f), d.contains(a[0], c[0]) || "the_wrapper" == f || -1 != f.indexOf("kws_audio") || this.remove())
        })
    }
    function F(a, c, f, g) {
        null == g && (g = 86400);
        a = "; max-age=" + g;
        document.cookie = encodeURI(c) + "=" + encodeURI(f) + a + "; path=/"
    }
    function V(a, c) {
        if (a.continuouslyPlayOnAllPages) {
            var f,
            g = document.cookie.split(";");
            for (f = 0; f < g.length; f++) {
                var k = g[f].substr(0, g[f].indexOf("="));
                var n = g[f].substr(g[f].indexOf("=") +
                        1);
                k = k.replace(/^\s+|\s+$/g, "");
                if (k == c)
                    return unescape(n)
            }
        }
    }
    function pa(a, c, f) {
        c.shuffle ? (c = Math.ceil(Math.random() * (a.selectedCateg_total_images - 1)), a.current_img_no = c != a.current_img_no ? c : Math.ceil(Math.random() * (a.selectedCateg_total_images - 1))) : "next" == f ? a.current_img_no == a.selectedCateg_total_images - 1 ? a.current_img_no = 0 : a.current_img_no++ : 0 > a.current_img_no - 1 ? a.current_img_no = a.selectedCateg_total_images - 1 : a.current_img_no--;
        a.origID = d("div[rel='" + a.current_img_no + "']").attr("data-origID")
    }
    function ta() {
        var a =
            -1;
        "Microsoft Internet Explorer" == navigator.appName && null != /MSIE ([0-9]{1,}[.0-9]{0,})/.exec(navigator.userAgent) && (a = parseFloat(RegExp.$1));
        return parseInt(a, 10)
    }
    function ia(a, c) {
        d("audio").each(function () {
            d(".AudioPlay").removeClass("AudioPause");
            d(this)[0].pause()
        });
        d(".sound").css({
            "-webkit-animation-play-state": "paused",
            "-moz-animation-play-state": "paused",
            "-ms-animation-play-state": "paused",
            "-o-animation-play-state": "paused",
            "animation-play-state": "paused"
        });
        d(".sound2").css({
            "-webkit-animation-play-state": "paused",
            "-moz-animation-play-state": "paused",
            "-ms-animation-play-state": "paused",
            "-o-animation-play-state": "paused",
            "animation-play-state": "paused"
        });
        645 <= a.playerWidth && d(".pickUp_on").each(function () {
            "block" == d(this).css("display") && (d(this).css({
                    visibility: "hidden",
                    display: "none"
                }), d(".pickUp_off", d(this).parent()).css({
                    visibility: "visible",
                    display: "block"
                }))
        })
    }
    var t = navigator.userAgent.toLowerCase();
    d.kws_audio = {
        version: "1.0"
    };
    d.fn.kws_audio = function (a) {
        a = d.extend({}, d.fn.kws_audio.defaults,
                a);
        return this.each(function () {
            var c = d(this),
            f = d('<div class="AudioControls"> <a class="AudioCloseBut" title="Minimize"></a> <a class="AudioRewind" title="Rewind"></a><a class="AudioShuffle" title="Shuffle Playlist"></a><a class="AudioDownload" title="Download File"></a><a class="AudioBuy" title="Buy Now"></a><a class="AudioLyrics" title="Lyrics"></a><a class="AudioFacebook" title="Facebook"></a><a class="AudioTwitter" title="Twitter"></a><a class="AudioPopup" title="Popup"></a><a class="AudioPlay" title="Play/Pause"></a><a class="AudioPrev" title="Previous"></a><a class="AudioNext" title="Next"></a><a class="AudioShowHidePlaylist" title="Show/Hide Playlist"></a><a class="VolumeButton" title="Mute/Unmute"></a><div class="VolumeSlider"></div> <div class="AudioTimer_a">00:00</div><div class="AudioTimer_b">00:00</div>  </div>   <div class="AudioBuffer"></div><div class="AudioSeek"></div><div class="songTitle"><div class="songTitleInside"></div></div>  <div class="songAuthor"></div>    <div class="thumbsHolderWrapper"><div class="playlistPadding"><div class="selectedCategDiv"><div class="innerSelectedCategDiv">CATEGORIES</div></div> <div class="thumbsHolderVisibleWrapper"><div class="thumbsHolder"></div></div><div class="searchDiv"><input class="search_term" type="text" value="search..." /></div></div></div>  <div class="slider-vertical"></div> <div class="ximage_kmp"></div>  '),
            g = d('<div class="barsContainer"><div id="bars" class="perspectiveDownZero"><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2" style="display:none;"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div><div class="bar sound2"></div></div><div id="bars"><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound" style="display:none;"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div><div class="bar sound"></div></div></div>'),
            k = d('<div class="pickUp_on"><div class="disc xWheel1"></div><div class="openUpLeftRetournAudioPlayer ac"></div></div>'),
            n = d('<div class="pickUp_off"><div class="disc pause_kmp"></div><div class="openUpLeftRetournAudioPlayer2 ac"></div></div>'),
            e = c.parent(".kws_audio");
            e.addClass(a.skin);
            e.append(f);
            e.append(g);
            e.append(k);
            e.append(n);
            d(".AudioControls", e);
            var L = d(".AudioRewind", e),
            C = d(".AudioShuffle", e),
            z = d(".AudioDownload", e),
            m = d(".AudioBuy", e),
            M = d(".AudioLyrics", e),
            Q = d(".AudioFacebook", e),
            E = d(".AudioTwitter",
                    e),
            O = d(".AudioPopup", e),
            u = d(".AudioPlay", e),
            X = d(".AudioPrev", e),
            G = d(".AudioNext", e),
            T = d(".AudioShowHidePlaylist", e),
            J = d(".VolumeButton", e),
            N = d(".VolumeSlider", e),
            K = d(".AudioCloseBut", e),
            v = d(".AudioTimer_a", e),
            p = d(".AudioTimer_b", e),
            l = d(".songTitle", e),
            w = d(".songTitleInside", e),
            q = d(".songAuthor", e),
            r = d(".ximage_kmp", e),
            x = d(".AudioBuffer", e),
            D = d(".AudioSeek", e);
            e.wrap("<div class='the_wrapper'></div>");
            var H = e.parent();
            H.css({
                margin: "0 auto"
            });
            var ba = ta();
            m.attr("title", a.buyButTitle);
            M.attr("title",
                a.lyricsButTitle);
            f = Math.floor(1E5 * Math.random());
            var b = {
                current_img_no: 0,
                origID: 0,
                is_very_first: !0,
                total_images: 0,
                selectedCateg_total_images: 0,
                numberOfCategories: 0,
                is_seeking: !1,
                is_changeSrc: !1,
                is_buffer_complete: !1,
                timeupdateInterval: "",
                totalTime: "",
                playlist_arr: "",
                isCarouselScrolling: !1,
                isAuthorTitleInsideScrolling: !1,
                curSongText: "",
                authorTitleInsideWait: 0,
                audioPlayerWidth: 0,
                audioPlayerHeight: 0,
                seekBarLeftRightSpacing: 11,
                category_arr: "",
                selectedCateg: "",
                categsAreListed: !1,
                thumbsHolder_Thumb: d('<div class="thumbsHolder_ThumbOFF" rel="0"><div class="padding">test</div></div>'),
                thumbsHolder_ThumbHeight: 0,
                thumbsHolder_Thumbs: "",
                search_val: "",
                constantDistance: 15,
                timerTopPos: 0,
                timerLeftPos: 0,
                bufferTopPos: 0,
                bufferLeftPos: 0,
                bufferWidth: 461,
                thebarsTopPos: 0,
                thebarsLeftPos: 0,
                titleWidth: 0,
                authorTopPos: 0,
                authorLeftPos: 0,
                titleTopPos: 0,
                titleLeftPos: 0,
                imageTopPos: 0,
                imageLeftPos: 0,
                playTopPos: 0,
                playLeftPos: 0,
                previousTopPos: 0,
                previousLeftPos: 0,
                nextTopPos: 0,
                nextLeftPos: 0,
                volumeTopPos: 0,
                volumeLeftPos: 0,
                volumesliderTopPos: 0,
                volumesliderLeftPos: 0,
                showhideplaylistTopPos: 0,
                showhideplaylistLeftPos: 0,
                rewindTopPos: 0,
                rewindLeftPos: 0,
                shuffleTopPos: 0,
                shuffleLeftPos: 0,
                downloadTopPos: 0,
                downloadLeftPos: 0,
                buyTopPos: 0,
                buyLeftPos: 0,
                lyricsTopPos: 0,
                lyricsLeftPos: 0,
                facebookTopPos: 0,
                facebookLeftPos: 0,
                twitterTopPos: 0,
                twitterLeftPos: 0,
                popupTopPos: 0,
                popupLeftPos: 0,
                minimizeTopPos: 0,
                minimizeLeftPos: 0,
                isMinified: !1,
                isPlaylistVisible: !0,
                cookie_timePlayed: 0,
                cookie_current_img_no: 0,
                cookie_origID: 0,
                cookie_initialVolume: 0,
                cookie_muteVolume: 0,
                cookie_autoPlay: !1,
                cookie_shuffle: !1,
                cookie_firstCateg: "",
                cookie_isMinified: !1,
                cookie_popupWin: "",
                origParentFloat: "",
                origParentPaddingTop: "",
                origParentPaddingRight: "",
                origParentPaddingBottom: "",
                origParentPaddingLeft: "",
                windowWidth: 0,
                audioObj: "",
                stickyFixedPlayerWidth: 980,
                audioID: "kmpaudio_audio_tag_id_" + f
            };
            b.html5_audio_tag = d('<audio id="' + b.audioID + '" preload="metadata"></audio>');
            e.append(b.html5_audio_tag);
            b.cookie_popupWin = V(a, "cookie_popupWin");
            "kmpaudio_PopupName" == window.self.name && (a.sticky = !1, a.showPopupBut = !1, H.css({
                    top: -1 * parseInt(r.css("top").substring(0, r.css("top").length -
                            2), 10) + "px",
                    left: 0,
                    position: "absolute"
                }), H.unwrap(), d("body").css({
                    "background-color": "#999999 !important",
                    "min-width": "305px"
                }), document.getElementsByTagName("body")[0].style.marginTop = "0px", document.getElementsByTagName("body")[0].style.marginBottom = "0px", document.getElementsByTagName("body")[0].style.marginLeft = "0px", document.getElementsByTagName("body")[0].style.marginRight = "0px", document.getElementsByTagName("body")[0].style.paddingTop = "0px", document.getElementsByTagName("body")[0].style.paddingBottom =
                    "0px", document.getElementsByTagName("body")[0].style.paddingLeft = "0px", document.getElementsByTagName("body")[0].style.paddingRight = "0px", oa(H));
            a.playerWidth = e.parent().width();
            a.sticky && (a.playerWidth = b.stickyFixedPlayerWidth + 2 * b.constantDistance);
            a.showPlaylistBut || T.css({
                display: "none",
                width: 0,
                height: 0,
                padding: 0,
                margin: 0
            });
            e.width(a.playerWidth);
            a.origWidth = a.playerWidth;
            a.sticky ? (H.wrap("<div class='kws_audio_sticky'></div>"), b.minimizeTopPos = -1 * K.height(), b.minimizeLeftPos = b.constantDistance,
                K.css({
                    top: b.minimizeTopPos + "px",
                    right: b.minimizeLeftPos + "px"
                }), e.css({
                    padding: a.playerPadding + "px"
                }), d(".kws_audio_sticky").css({
                    background: a.playerBg
                }), K.on("click", function () {
                    if (b.isMinified) {
                        var h = 1;
                        b.isMinified = !1;
                        K.removeClass("AudioOpenBut");
                        var y = "block";
                        var I = "visible"
                    } else
                        h = b.isPlaylistVisible ? -1 * (b.audioPlayerHeight + A.height() + a.playlistTopPos) : -1 * b.audioPlayerHeight, b.isMinified = !0, K.addClass("AudioOpenBut"), y = "none", I = "hidden";
                    F(a, "cookie_isMinified", b.isMinified);
                    645 > a.playerWidth &&
                    (y = "none", I = "hidden");
                    a.showVinylRecord ? (k.css({
                            visibility: I
                        }), n.css({
                            visibility: I
                        }), b.isMinified || (document.getElementById(b.audioID).paused ? 645 < a.playerWidth && (k.css({
                                    visibility: "hidden",
                                    display: "none"
                                }), n.css({
                                    visibility: "visible",
                                    display: "block"
                                })) : 645 < a.playerWidth && (k.css({
                                    visibility: "visible",
                                    display: "block"
                                }), n.css({
                                    visibility: "hidden",
                                    display: "none"
                                })))) : r.css({
                        display: y
                    });
                    d(".kws_audio_sticky").animate({
                        bottom: h + "px"
                    }, 500, "easeOutQuad", function () {
                        d(".kws_audio_sticky").css({
                            left: "0px"
                        })
                    })
                })) :
            (e.css({
                    background: a.playerBg,
                    padding: a.playerPadding + "px"
                }), K.css({
                    display: "none"
                }));
            d(".bar", e).css({
                background: a.barsColor
            });
            ka(b, a, e, P, A, S, R, Y, aa, U, u, D, x, v, p, l, w, q, c, r, k, n, H, O, g, J, N, C, z, T, M, Q, E, L, X, G, m);
            var A = d(".thumbsHolderWrapper", e),
            U = d(".playlistPadding", e),
            S = d(".thumbsHolderVisibleWrapper", e),
            P = d(".thumbsHolder", e);
            b.kws_audio_sliderVertical = d(".slider-vertical", e);
            var R = d(".selectedCategDiv", e),
            Y = d(".innerSelectedCategDiv", e),
            aa = d(".searchDiv", e),
            ca = d(".search_term", e);
            a.showPlaylist ||
            A.css({
                opacity: 0,
                visibility: "hidden"
            });
            a.showPlaylistOnInit || (A.css({
                    opacity: 0,
                    visibility: "hidden",
                    "margin-top": "-20px"
                }), b.isPlaylistVisible = !1);
            a.showCategories || R.css({
                visibility: "hidden",
                height: 0
            });
            R.css({
                "background-color": a.selectedCategBg,
                "background-position": "10px 50%",
                "margin-bottom": a.selectedCategMarginBottom + "px"
            });
            Y.css({
                color: a.selectedCategOffColor,
                "background-position": a.playerWidth - 2 * a.playlistPadding - 20 + "px 50%"
            });
            a.showSearchArea || aa.css({
                visibility: "hidden",
                height: 0
            });
            aa.css({
                "background-color": a.searchAreaBg,
                "margin-top": a.selectedCategMarginBottom + "px"
            });
            ca.val(a.searchInputText);
            ca.css({
                width: a.playerWidth - 30 - 2 * a.playlistPadding - 7 + "px",
                "background-color": a.searchInputBg,
                "border-color": a.searchInputBorderColor,
                color: a.searchInputTextColor
            });
            A.css({
                width: e.width() + 2 * a.playerPadding + "px",
                top: b.audioPlayerHeight + a.playlistTopPos + "px",
                left: "0px",
                background: a.playlistBgColor
            });
            S.width(e.width());
            b.playlist_arr = [];
            b.category_arr = [];
            var fa = [],
            B;
            d(".xaudioplaylist", e).children().each(function () {
                B = d(this);
                b.total_images++;
                b.playlist_arr[b.total_images - 1] = [];
                b.playlist_arr[b.total_images - 1].title = "";
                b.playlist_arr[b.total_images - 1].author = "";
                b.playlist_arr[b.total_images - 1].authorlink = "";
                b.playlist_arr[b.total_images - 1].image = "";
                b.playlist_arr[b.total_images - 1].category = "";
                b.playlist_arr[b.total_images - 1].sources_mp3 = "";
                b.playlist_arr[b.total_images - 1].sources_ogg = "";
                b.playlist_arr[b.total_images - 1].buy_link = "";
                b.playlist_arr[b.total_images - 1].lyrics_link = "";
                null != B.find(".xtitle").html() && (b.playlist_arr[b.total_images -
                        1].title = B.find(".xtitle").html());
                null != B.find(".xauthor").html() && (b.playlist_arr[b.total_images - 1].author = B.find(".xauthor").html());
                null != B.find(".xauthorlink").html() && (b.playlist_arr[b.total_images - 1].authorlink = B.find(".xauthorlink").html());
                null != B.find(".xauthorlinktarget").html() && (b.playlist_arr[b.total_images - 1].authorlinktarget = B.find(".xauthorlinktarget").html());
                null != B.find(".ximage").html() && (b.playlist_arr[b.total_images - 1].image = B.find(".ximage").html());
                null != B.find(".xbuy").html() &&
                (b.playlist_arr[b.total_images - 1].buy_link = B.find(".xbuy").html());
                null != B.find(".xlyrics").html() && (b.playlist_arr[b.total_images - 1].lyrics_link = B.find(".xlyrics").html());
                if (null != B.find(".xcategory").html()) {
                    b.playlist_arr[b.total_images - 1].category = B.find(".xcategory").html() + ";";
                    fa = b.playlist_arr[b.total_images - 1].category.split(";");
                    for (var h = 0; h < fa.length; h++)
                         - 1 === b.category_arr.indexOf(fa[h]) && "" != fa[h] && b.category_arr.push(fa[h])
                }
                null != B.find(".xsources_mp3").html() && (b.playlist_arr[b.total_images -
                        1].sources_mp3 = B.find(".xsources_mp3").html());
                null != B.find(".xsources_ogg").html() && (b.playlist_arr[b.total_images - 1].sources_ogg = B.find(".xsources_ogg").html())
            });
            b.cookie_firstCateg = V(a, "cookie_firstCateg");
            void 0 != b.cookie_firstCateg && (a.firstCateg = b.cookie_firstCateg);
            b.numberOfCategories = b.category_arr.length;
            b.category_arr.sort();
            b.selectedCateg = a.firstCateg;
            "" == a.firstCateg && -1 === b.category_arr.indexOf(a.firstCateg) && (b.selectedCateg = b.category_arr[0]);
            Y.html(b.selectedCateg);
            la(b, a, e, P, A,
                S, R, aa, U, u, D, x, v, p, l, w, q, c, r, H, G);
            R.on("click", function () {
                b.search_val = "";
                ca.val(a.searchInputText);
                sa(b, a, e, P, A, S, R, Y, aa, U, u, D, x, v, p, l, w, q, c, r, H, G)
            });
            R.on("mouseover", function () {
                Y.css({
                    color: a.selectedCategOnColor
                })
            });
            R.on("mouseout", function () {
                Y.css({
                    color: a.selectedCategOffColor
                })
            });
            b.cookie_initialVolume = V(a, "cookie_initialVolume");
            b.cookie_initialVolume && (a.initialVolume = b.cookie_initialVolume);
            N.slider({
                value: a.initialVolume,
                step: .05,
                orientation: "vertical",
                range: "min",
                min: 0,
                max: 1,
                animate: !0,
                slide: function (h, y) {
                    document.getElementById(b.audioID).volume = y.value;
                    F(a, "cookie_initialVolume", y.value)
                },
                stop: function (h, y) {}
            });
            document.getElementById(b.audioID).volume = a.initialVolume;
            N.css({
                background: a.volumeOffColor
            });
            d(".ui-widget-header", N).css({
                background: a.volumeOnColor
            });
            u.on("click", function () {
                var h = document.getElementById(b.audioID).paused;
                ia(a, e);
                0 == h ? (document.getElementById(b.audioID).pause(), u.removeClass("AudioPause"), W(a, b, e, !1), F(a, "cookie_autoPlay", !1)) : (document.getElementById(b.audioID).play(),
                    u.addClass("AudioPause"), W(a, b, e, !0), F(a, "cookie_autoPlay", !0))
            });
            L.on("click", function () {
                document.getElementById(b.audioID).currentTime = 0;
                ia(a, e);
                document.getElementById(b.audioID).play();
                u.addClass("AudioPause");
                W(a, b, e, !0)
            });
            G.on("click", function () {
                if (!b.categsAreListed && (!b.is_changeSrc || b.is_very_first)) {
                    a.autoPlay = !0;
                    var h = "transparent";
                    "#" != a.playlistRecordBgOffColor && (h = a.playlistRecordBgOffColor);
                    b.thumbsHolder_Thumbs.css({
                        background: h,
                        "border-bottom-color": a.playlistRecordBottomBorderOffColor,
                        color: a.playlistRecordTextOffColor
                    });
                    W(a, b, e, !0);
                    pa(b, a, "next");
                    a.continuouslyPlayOnAllPages && (F(a, "cookie_current_img_no", b.current_img_no), F(a, "cookie_origID", b.origID));
                    ha(b, a, P, e, u, D, x, v, p, l, w, q, c, r)
                }
            });
            X.on("click", function () {
                if (!b.categsAreListed && (!b.is_changeSrc || b.is_very_first)) {
                    a.autoPlay = !0;
                    var h = "transparent";
                    "#" != a.playlistRecordBgOffColor && (h = a.playlistRecordBgOffColor);
                    b.thumbsHolder_Thumbs.css({
                        background: h,
                        "border-bottom-color": a.playlistRecordBottomBorderOffColor,
                        color: a.playlistRecordTextOffColor
                    });
                    W(a, b, e, !0);
                    pa(b, a, "previous");
                    a.continuouslyPlayOnAllPages && (F(a, "cookie_current_img_no", b.current_img_no), F(a, "cookie_origID", b.origID));
                    ha(b, a, P, e, u, D, x, v, p, l, w, q, c, r)
                }
            });
            T.on("click", function () {
                A.css({
                    visibility: "visible"
                });
                if (0 > A.css("margin-top").substring(0, A.css("margin-top").length - 2)) {
                    var h = 1;
                    var y = "block";
                    b.isPlaylistVisible = !0;
                    var I = "0px";
                    var Z = b.audioPlayerHeight + A.height() + a.playlistTopPos;
                    A.css({
                        display: y
                    });
                    b.selectedCateg_total_images > a.numberOfThumbsPerScreen && b.kws_audio_sliderVertical.css({
                        opacity: 1,
                        display: "block"
                    })
                } else
                    h = 0, y = "none", b.isPlaylistVisible = !1, I = "-20px", b.selectedCateg_total_images > a.numberOfThumbsPerScreen && b.kws_audio_sliderVertical.css({
                        opacity: 0,
                        display: "none"
                    }), Z = b.audioPlayerHeight;
                A.animate({
                    opacity: h,
                    "margin-top": I
                }, 500, "easeOutQuad", function () {
                    A.css({
                        display: y
                    })
                });
                H.animate({
                    height: Z
                }, 500, "easeOutQuad", function () {})
            });
            J.on("click", function () {
                document.getElementById(b.audioID).muted ? (document.getElementById(b.audioID).muted = !1, J.removeClass("VolumeButtonMuted"), F(a, "cookie_muteVolume",
                        0)) : (document.getElementById(b.audioID).muted = !0, J.addClass("VolumeButtonMuted"), F(a, "cookie_muteVolume", 1))
            });
            C.on("click", function () {
                a.shuffle ? (C.removeClass("AudioShuffleON"), a.shuffle = !1, F(a, "cookie_shuffle", !1)) : (C.addClass("AudioShuffleON"), a.shuffle = !0, F(a, "cookie_shuffle", !0))
            });
            z.on("click", function () {
                window.open(a.pathToDownloadFile + "download.php?the_file=" + b.playlist_arr[b.origID].sources_mp3)
            });
            m.on("click", function () {
                "" != b.playlist_arr[b.origID].buy_link ? "_blank" == a.buyButTarget ? window.open(b.playlist_arr[b.origID].buy_link) :
                window.location = b.playlist_arr[b.origID].buy_link : alert("no link defined")
            });
            M.on("click", function () {
                "" != b.playlist_arr[b.origID].lyrics_link ? "_blank" == a.lyricsButTarget ? window.open(b.playlist_arr[b.origID].lyrics_link) : window.location = b.playlist_arr[b.origID].lyrics_link : alert("no link defined")
            });
            a.showFacebookBut && (window.fbAsyncInit = function () {
                FB.init({
                    appId: a.facebookAppID,
                    version: "v3.2",
                    status: !0,
                    cookie: !0,
                    xfbml: !0
                })
            }, function (h, y, I) {
                var Z = h.getElementsByTagName(y)[0];
                h.getElementById(I) || (h =
                        h.createElement(y), h.id = I, h.src = "//connect.facebook.com/en_US/sdk.js", Z.parentNode.insertBefore(h, Z))
            }
                (document, "script", "facebook-jssdk"), Q.on("click", function () {
                    var h = b.playlist_arr[b.origID].image,
                    y = window.location.pathname.split("/");
                    -1 == h.indexOf("http://") && -1 == h.indexOf("https://") && (-1 != y[y.length - 1].indexOf(".") && y.pop(), h = window.location.protocol + "//" + window.location.host + "/" + y.join("/") + "/" + b.playlist_arr[b.origID].image);
                    FB.ui({
                        method: "share_open_graph",
                        action_type: "og.likes",
                        action_properties: JSON.stringify({
                            object: {
                                "og:url": document.URL,
                                "og:title": a.facebookShareTitle,
                                "og:description": a.facebookShareDescription,
                                "og:image": h
                            }
                        })
                    }, function (I) {})
                }));
            if (a.showTwitterBut)
                E.on("click", function () {
                    window.open("https://twitter.com/intent/tweet?url=" + document.URL + "&text=" + b.playlist_arr[b.origID].title, "Twitter", "status = 1, left = 430, top = 270, height = 550, width = 420, resizable = 0")
                });
            if (a.showPopupBut)
                O.on("click", function () {
                    clearInterval(b.timeupdateInterval);
                    H[0].innerHTML = "";
                    a.sticky && (d(".kws_audio_sticky")[0].innerHTML = "");
                    b.cookie_popupWin = window.open(location.href, "kmpaudio_PopupName", "width=" + a.popupWidth + ", height=" + a.popupHeight + ", left=24, top=24, scrollbars=no, resizable");
                    b.cookie_popupWin.focus();
                    F(a, "cookie_popupWin", b.cookie_popupWin, 1201)
                });
            P.swipe({
                swipeStatus: function (h, y, I, Z, va, wa) {
                    b.selectedCateg_total_images > a.numberOfThumbsPerScreen && ("up" == I || "down" == I) && 0 != Z && (h = b.kws_audio_sliderVertical.slider("value"), h = "up" == I ? h - 1.5 : h + 1.5, b.kws_audio_sliderVertical.slider("value", h), d("html, body").off("touchstart touchmove").on("touchstart touchmove",
                            function (ua) {
                            ua.preventDefault()
                        }), da(h, b, a, P))
                },
                threshold: 100,
                maxTimeThreshold: 500,
                fingers: "all"
            });
            d.kws_audio.destroyPlayerInstance = function (h) {
                alert(the_param)
            };
            d.kws_audio.changeMp3 = function (h, y, I, Z) {
                b.totalTime = "Infinity";
                a.isSliderInitialized && (D.slider("destroy"), a.isSliderInitialized = !1);
                a.isProgressInitialized && (x.progressbar("destroy"), a.isProgressInitialized = !1);
                b.is_changeSrc = !0;
                b.is_buffer_complete = !1;
                l.width(b.titleWidth);
                q.width(b.titleWidth);
                x.css({
                    background: a.bufferEmptyColor
                });
                b.curSongText = "";
                a.showTitle && null != y && "" != y && (b.curSongText += y);
                b.isAuthorTitleInsideScrolling = !1;
                b.authorTitleInsideWait = 0;
                w.stop();
                w.css({
                    "margin-left": 0
                });
                w.html(b.curSongText);
                a.showAuthor && null != I && "" != I && q.html(I);
                r.html('<img src="' + Z + '" width="149">');
                b.curSongText || l.css({
                    display: "none",
                    width: 0,
                    height: 0,
                    padding: 0,
                    margin: 0
                });
                document.getElementById(b.audioID).src = h;
                document.getElementById(b.audioID).load();
                -1 != t.indexOf("android") || (-1 != t.indexOf("ipad") || -1 != t.indexOf("iphone") || -1 != t.indexOf("ipod") ||
                    -1 != t.indexOf("webos")) && b.is_very_first || (a.autoPlay ? (ia(a, e), document.getElementById(b.audioID).play(), u.addClass("AudioPause"), W(a, b, e, !0)) : (u.removeClass("AudioPause"), W(a, b, e, !1)))
            };
            ca.on("click", function () {
                d(this).val("")
            });
            ca.on("input", function () {
                b.search_val = ca.val().toLowerCase();
                la(b, a, e, P, A, S, R, aa, U, u, D, x, v, p, l, w, q, c, r, H, G)
            });
            document.getElementById(b.audioID).addEventListener("ended", function () {
                a.loop && G.click()
            });
            a.googleTrakingOn && ga("create", a.googleTrakingCode, "auto");
            b.cookie_timePlayed =
                V(a, "cookie_timePlayed");
            b.cookie_current_img_no = V(a, "cookie_current_img_no");
            b.cookie_origID = V(a, "cookie_origID");
            b.cookie_autoPlay = V(a, "cookie_autoPlay");
            b.cookie_shuffle = V(a, "cookie_shuffle");
            b.cookie_isMinified = V(a, "cookie_isMinified");
            void 0 != b.cookie_current_img_no && (b.current_img_no = b.cookie_current_img_no, void 0 != b.cookie_origID && (b.origID = b.cookie_origID));
            a.continuouslyPlayOnAllPages && F(a, "cookie_current_img_no", b.current_img_no);
            void 0 != b.cookie_autoPlay && (a.autoPlay = "true" == b.cookie_autoPlay ?
                    !0 : !1);
            "true" != b.cookie_autoPlay && -1 == (-1 == navigator.userAgent.indexOf("Opera") && navigator.userAgent.indexOf("OPR")) && (-1 != navigator.userAgent.indexOf("Chrome") && -1 != navigator.vendor.indexOf("Google") && (a.autoPlay = !1), -1 != navigator.userAgent.indexOf("Safari") && -1 != navigator.vendor.indexOf("Apple") && -1 == navigator.platform.indexOf("Win") && (a.autoPlay = !1));
            void 0 != b.cookie_shuffle && ("true" == b.cookie_shuffle ? (a.shuffle = !0, C.addClass("AudioShuffleON")) : (a.shuffle = !1, C.removeClass("AudioShuffleON")));
            b.cookie_timePlayed &&
            (document.getElementById(b.audioID).currentTime = b.cookie_timePlayed, b.cookie_timePlayed = null);
            a.shuffle && void 0 != b.cookie_current_img_no && (b.is_very_first = !1);
            ha(b, a, P, e, u, D, x, v, p, l, w, q, c, r);
            b.cookie_muteVolume = V(a, "cookie_muteVolume");
            1 <= b.cookie_muteVolume && J.click();
            b.timeupdateInterval = setInterval(function () {
                ra(b, a, e, D, x, v, p, u, c, l, w, q)
            }, 300);
            document.getElementById(b.audioID).addEventListener("durationchange", function () {
                b.is_changeSrc && (b.totalTime = document.getElementById(b.audioID).duration)
            });
            if (-1 != t.indexOf("ipad") || -1 != t.indexOf("iphone") || -1 != t.indexOf("ipod") || -1 != t.indexOf("webos"))
                b.cookie_timePlayed && (document.getElementById(b.audioID).currentTime = b.cookie_timePlayed, b.cookie_timePlayed = null), b.totalTime = 0, document.getElementById(b.audioID).addEventListener("canplaythrough", function () {
                    b.totalTime != document.getElementById(b.audioID).duration && (a.isSliderInitialized && (D.slider("destroy"), a.isSliderInitialized = !1), a.isProgressInitialized && (x.progressbar("destroy"), a.isProgressInitialized =
                                !1), b.totalTime = document.getElementById(b.audioID).duration, ja(b, a, e, D, x, v, p, u, c), a.isProgressInitialized && x.progressbar({
                            value: a.playerWidth
                        }))
                });
            void 0 == b.cookie_isMinified || "true" != b.cookie_isMinified || a.is_kmpSite || (d(".kws_audio_sticky").css({
                    left: "-5000px"
                }), setTimeout(function () {
                    K.click()
                }, 800));
            var qa = function () {
                "" == b.origParentFloat && (b.origParentFloat = e.parent().css("float"), b.origParentPaddingTop = e.parent().css("padding-top"), b.origParentPaddingRight = e.parent().css("padding-right"),
                    b.origParentPaddingBottom = e.parent().css("padding-bottom"), b.origParentPaddingLeft = e.parent().css("padding-left"));
                var h = e.parent().parent().width();
                a.sticky && (h = d(window).width());
                e.width() != h && (a.playerWidth = h, a.sticky && (a.playerWidth = a.origWidth > h ? h : a.origWidth), ka(b, a, e, P, A, S, R, Y, aa, U, u, D, x, v, p, l, w, q, c, r, k, n, H, O, g, J, N, C, z, T, M, Q, E, L, X, G, m), e.width() != a.playerWidth && (e.width(a.playerWidth), H.width(a.playerWidth), b.bufferWidth = a.playerWidth - b.timerLeftPos - 2 * v.width() - 2 * b.seekBarLeftRightSpacing -
                            2 * a.playerPadding - 260 - 20, x.width(b.bufferWidth), D.width(b.bufferWidth), A.width(e.width() + 2 * a.playerPadding), S.width(e.width()), R.width(a.playerWidth - 2 * a.playlistPadding), Y.css({
                            "background-position": a.playerWidth - 2 * a.playlistPadding - 20 + "px 50%"
                        }), b.selectedCateg_total_images > a.numberOfThumbsPerScreen && a.showPlaylist ? (b.kws_audio_sliderVertical.css({
                                left: e.width() + 2 * a.playerPadding - b.kws_audio_sliderVertical.width() - a.playlistPadding + "px"
                            }), d(".thumbsHolder_ThumbOFF", e).css({
                                width: e.width() +
                                2 * a.playerPadding - b.kws_audio_sliderVertical.width() - 2 * a.playlistPadding - 3 + "px"
                            })) : d(".thumbsHolder_ThumbOFF", e).css({
                            width: e.width() + 2 * a.playerPadding - 2 * a.playlistPadding + "px"
                        }), ca.css({
                            width: a.playerWidth - 30 - 2 * a.playlistPadding - 7 + "px"
                        })), ka(b, a, e, P, A, S, R, Y, aa, U, u, D, x, v, p, l, w, q, c, r, k, n, H, O, g, J, N, C, z, T, M, Q, E, L, X, G, m), a.playerWidth < d(window).width() && e.parent().css({
                        "float": b.origParentFloat,
                        "padding-top": b.origParentPaddingTop,
                        "padding-right": b.origParentPaddingRight,
                        "padding-bottom": b.origParentPaddingBottom,
                        "padding-left": b.origParentPaddingLeft
                    }))
            },
            ma = !1;
            d(window).on("resize", function () {
                var h = !0;
                -1 != ba && 9 == ba && 0 == b.windowWidth && (h = !1);
                b.windowWidth == d(window).width() ? (h = !1, a.windowCurOrientation != window.orientation && -1 != navigator.userAgent.indexOf("Android") && (a.windowCurOrientation = window.orientation, h = !0)) : b.windowWidth = d(window).width();
                a.responsive && h && (!1 !== ma && clearTimeout(ma), ma = setTimeout(function () {
                        qa()
                    }, 300))
            });
            a.responsive && qa();
            b.cookie_popupWin && "kmpaudio_PopupName" != window.name && e.parent().remove();
            d(window).on("beforeunload", function () {
                "kmpaudio_PopupName" == window.name && (F(a, "cookie_popupWin", b.cookie_popupWin, 1), b.cookie_popupWin = null)
            })
        })
    };
    d.fn.kws_audio.defaults = {
        playerWidth: 500,
        skin: "type_a",
        initialVolume: .5,
        autoPlay: !1,
        loop: !0,
        shuffle: !1,
        sticky: !0,
        playerPadding: 0,
        playerBg: "#000000",
        bufferEmptyColor: "#929292",
        bufferFullColor: "#454545",
        seekbarColor: "#ffffff",
        volumeOffColor: "#454545",
        volumeOnColor: "#ffffff",
        timerColor: "#ffffff",
        songTitleColor: "#a6a6a6",
        songAuthorColor: "#ffffff",
        showVinylRecord: !0,
        showRewindBut: !0,
        showNextPrevBut: !0,
        showShuffleBut: !0,
        showDownloadBut: !0,
        showBuyBut: !0,
        showLyricsBut: !0,
        buyButTitle: "Buy Now",
        lyricsButTitle: "Lyrics",
        buyButTarget: "_blank",
        lyricsButTarget: "_blank",
        showFacebookBut: !0,
        facebookAppID: "",
        facebookShareTitle: "AudioPlayer HTML5 Audio Player",
        facebookShareDescription: "A top-notch sticky full width HTML5 Audio Player compatible with all major browsers and mobile devices.",
        showTwitterBut: !0,
        showPopupBut: !0,
        showAuthor: !0,
        showTitle: !0,
        showPlaylistBut: !0,
        showPlaylist: !0,
        showPlaylistOnInit: !1,
        playlistTopPos: 2,
        playlistBgColor: "#000000",
        playlistRecordBgOffColor: "#000000",
        playlistRecordBgOnColor: "#333333",
        playlistRecordBottomBorderOffColor: "#333333",
        playlistRecordBottomBorderOnColor: "#4d4d4d",
        playlistRecordTextOffColor: "#777777",
        playlistRecordTextOnColor: "#FFFFFF",
        categoryRecordBgOffColor: "#191919",
        categoryRecordBgOnColor: "#252525",
        categoryRecordBottomBorderOffColor: "#2f2f2f",
        categoryRecordBottomBorderOnColor: "#2f2f2f",
        categoryRecordTextOffColor: "#4c4c4c",
        categoryRecordTextOnColor: "#00b4f9",
        numberOfThumbsPerScreen: 7,
        playlistPadding: 18,
        showCategories: !0,
        firstCateg: "",
        selectedCategBg: "#333333",
        selectedCategOffColor: "#FFFFFF",
        selectedCategOnColor: "#00b4f9",
        selectedCategMarginBottom: 12,
        showSearchArea: !0,
        searchAreaBg: "#333333",
        searchInputText: "search...",
        searchInputBg: "#ffffff",
        searchInputBorderColor: "#333333",
        searchInputTextColor: "#333333",
        searchAuthor: !0,
        googleTrakingOn: !1,
        googleTrakingCode: "",
        responsive: !0,
        origWidth: 0,
        continuouslyPlayOnAllPages: !0,
        pathToDownloadFile: "",
        showPlaylistNumber: !0,
        popupWidth: 1100,
        popupHeight: 500,
        barsColor: "#ffffff",
        is_kmpSite: !1,
        isSliderInitialized: !1,
        isProgressInitialized: !1,
        isPlaylistSliderInitialized: !1
    }
})(jQuery);
