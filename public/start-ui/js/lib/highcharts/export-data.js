/*
 Highcharts JS v7.0.3 (2019-02-06)
 Exporting module

 (c) 2010-2019 Torstein Honsi

 License: www.highcharts.com/license
*/
(function (h) {
    "object" === typeof module && module.exports ? (h["default"] = h, module.exports = h) : "function" === typeof define && define.amd ? define(function () {
        return h
    }) : h("undefined" !== typeof Highcharts ? Highcharts : void 0)
})(function (h) {
    (function (a) {
        a.ajax = function (k) {
            var b = a.merge(!0, {
                url: !1,
                type: "GET",
                dataType: "json",
                success: !1,
                error: !1,
                data: !1,
                headers: {}
            }, k);
            k = {
                json: "application/json",
                xml: "application/xml",
                text: "text/plain",
                octet: "application/octet-stream"
            };
            var f = new XMLHttpRequest;
            if (!b.url) return !1;
            f.open(b.type.toUpperCase(),
                b.url, !0);
            f.setRequestHeader("Content-Type", k[b.dataType] || k.text);
            a.objectEach(b.headers, function (a, k) {
                f.setRequestHeader(k, a)
            });
            f.onreadystatechange = function () {
                var a;
                if (4 === f.readyState) {
                    if (200 === f.status) {
                        a = f.responseText;
                        if ("json" === b.dataType) try {
                            a = JSON.parse(a)
                        } catch (n) {
                            b.error && b.error(f, n);
                            return
                        }
                        return b.success && b.success(a)
                    }
                    b.error && b.error(f, f.responseText)
                }
            };
            try {
                b.data = JSON.stringify(b.data)
            } catch (C) {
            }
            f.send(b.data || !0)
        }
    })(h);
    (function (a) {
        var k = a.win, b = k.navigator, f = k.document, h = k.URL ||
            k.webkitURL || k, n = /Edge\/\d+/.test(b.userAgent);
        a.dataURLtoBlob = function (a) {
            if ((a = a.match(/data:([^;]*)(;base64)?,([0-9A-Za-z+/]+)/)) && 3 < a.length && k.atob && k.ArrayBuffer && k.Uint8Array && k.Blob && h.createObjectURL) {
                for (var f = k.atob(a[3]), b = new k.ArrayBuffer(f.length), b = new k.Uint8Array(b), l = 0; l < b.length; ++l) b[l] = f.charCodeAt(l);
                a = new k.Blob([b], {type: a[1]});
                return h.createObjectURL(a)
            }
        };
        a.downloadURL = function (c, h) {
            var d = f.createElement("a"), l;
            if ("string" === typeof c || c instanceof String || !b.msSaveOrOpenBlob) {
                if (n ||
                    2E6 < c.length) if (c = a.dataURLtoBlob(c), !c) throw Error("Failed to convert to blob");
                if (void 0 !== d.download) d.href = c, d.download = h, f.body.appendChild(d), d.click(), f.body.removeChild(d); else try {
                    if (l = k.open(c, "chart"), void 0 === l || null === l) throw Error("Failed to open window");
                } catch (y) {
                    k.location.href = c
                }
            } else b.msSaveOrOpenBlob(c, h)
        }
    })(h);
    (function (a) {
        function k(a, b) {
            if (h.Blob && h.navigator.msSaveOrOpenBlob) return new h.Blob(["\ufeff" + a], {type: b})
        }

        var b = a.defined, f = a.pick, h = a.win, n = h.document, c = a.seriesTypes,
            z = a.downloadURL;
        a.setOptions({
            exporting: {
                csv: {
                    columnHeaderFormatter: null,
                    dateFormat: "%Y-%m-%d %H:%M:%S",
                    decimalPoint: null,
                    itemDelimiter: null,
                    lineDelimiter: "\n"
                }, showTable: !1, useMultiLevelHeaders: !0, useRowspanHeaders: !0
            },
            lang: {
                downloadXLS: "İndir (Excel)"
            }
        });
        a.addEvent(a.Chart, "render", function () {
            this.options && this.options.exporting && this.options.exporting.showTable && this.viewData()
        });
        a.Chart.prototype.setUpKeyToAxis =
            function () {
                c.arearange && (c.arearange.prototype.keyToAxis = {low: "y", high: "y"});
                c.gantt && (c.gantt.prototype.keyToAxis = {start: "x", end: "x"})
            };
        a.Chart.prototype.getDataRows = function (l) {
            var k = this.time, h = this.options.exporting && this.options.exporting.csv || {}, g, c = this.xAxis,
                q = {}, d = [], m, n = [], p = [], u, t, r, B = function (e, b, g) {
                    if (h.columnHeaderFormatter) {
                        var r = h.columnHeaderFormatter(e, b, g);
                        if (!1 !== r) return r
                    }
                    return e ? e instanceof a.Axis ? e.options.title && e.options.title.text || (e.isDatetimeAxis ? "DateTime" : "Category") :
                        l ? {
                            columnTitle: 1 < g ? b : e.name,
                            topLevelColumnTitle: e.name
                        } : e.name + (1 < g ? " (" + b + ")" : "") : "Category"
                }, w = [];
            t = 0;
            this.setUpKeyToAxis();
            this.series.forEach(function (e) {
                var b = e.options.keys || e.pointArrayMap || ["y"], g = b.length, r = !e.requireSorting && {}, v = {},
                    y = {}, m = c.indexOf(e.xAxis), A, d;
                b.forEach(function (a) {
                    var b = (e.keyToAxis && e.keyToAxis[a] || a) + "Axis";
                    v[a] = e[b] && e[b].categories || [];
                    y[a] = e[b] && e[b].isDatetimeAxis
                });
                if (!1 !== e.options.includeInCSVExport && !e.options.isInternal && !1 !== e.visible) {
                    a.find(w, function (e) {
                        return e[0] ===
                            m
                    }) || w.push([m, t]);
                    for (d = 0; d < g;) u = B(e, b[d], b.length), p.push(u.columnTitle || u), l && n.push(u.topLevelColumnTitle || u), d++;
                    A = {
                        chart: e.chart,
                        autoIncrement: e.autoIncrement,
                        options: e.options,
                        pointArrayMap: e.pointArrayMap
                    };
                    e.options.data.forEach(function (a, l) {
                        var c, p;
                        p = {series: A};
                        e.pointClass.prototype.applyOptions.apply(p, [a]);
                        a = p.x;
                        c = e.data[l] && e.data[l].name;
                        r && (r[a] && (a += "|" + l), r[a] = !0);
                        d = 0;
                        e.xAxis && "name" !== e.exportKey || (a = c);
                        q[a] || (q[a] = [], q[a].xValues = []);
                        q[a].x = p.x;
                        q[a].name = c;
                        for (q[a].xValues[m] =
                                 p.x; d < g;) l = b[d], c = p[l], q[a][t + d] = f(v[l][c], y[l] ? k.dateFormat(h.dateFormat, c) : null, c), d++
                    });
                    t += d
                }
            });
            for (m in q) q.hasOwnProperty(m) && d.push(q[m]);
            var v, x;
            m = l ? [n, p] : [p];
            for (t = w.length; t--;) v = w[t][0], x = w[t][1], g = c[v], d.sort(function (a, b) {
                return a.xValues[v] - b.xValues[v]
            }), r = B(g), m[0].splice(x, 0, r), l && m[1] && m[1].splice(x, 0, r), d.forEach(function (a) {
                var e = a.name;
                g && !b(e) && (g.isDatetimeAxis ? (a.x instanceof Date && (a.x = a.x.getTime()), e = k.dateFormat(h.dateFormat, a.x)) : e = g.categories ? f(g.names[a.x], g.categories[a.x],
                    a.x) : a.x);
                a.splice(x, 0, e)
            });
            m = m.concat(d);
            a.fireEvent(this, "exportData", {dataRows: m});
            return m
        };
        a.Chart.prototype.getCSV = function (a) {
            var b = "", l = this.getDataRows(), g = this.options.exporting.csv,
                c = f(g.decimalPoint, "," !== g.itemDelimiter && a ? (1.1).toLocaleString()[1] : "."),
                k = f(g.itemDelimiter, "," === c ? ";" : ","), h = g.lineDelimiter;
            l.forEach(function (a, g) {
                for (var f, d = a.length; d--;) f = a[d], "string" === typeof f && (f = '"' + f + '"'), "number" === typeof f && "." !== c && (f = f.toString().replace(".", c)), a[d] = f;
                b += a.join(k);
                g < l.length -
                1 && (b += h)
            });
            return b
        };
        a.Chart.prototype.getTable = function (b) {
            var c = '\x3ctable id\x3d"highcharts-data-table-' + this.index + '"\x3e', l = this.options,
                g = b ? (1.1).toLocaleString()[1] : ".", k = f(l.exporting.useMultiLevelHeaders, !0);
            b = this.getDataRows(k);
            var d = 0, h = k ? b.shift() : null, m = b.shift(), n = function (a, b, c, l) {
                var d = f(l, "");
                b = "text" + (b ? " " + b : "");
                "number" === typeof d ? (d = d.toString(), "," === g && (d = d.replace(".", g)), b = "number") : l || (b = "empty");
                return "\x3c" + a + (c ? " " + c : "") + ' class\x3d"' + b + '"\x3e' + d + "\x3c/" + a + "\x3e"
            };
            !1 !==
            l.exporting.tableCaption && (c += '\x3ccaption class\x3d"highcharts-table-caption"\x3e' + f(l.exporting.tableCaption, l.title.text ? l.title.text.replace(/&/g, "\x26amp;").replace(/</g, "\x26lt;").replace(/>/g, "\x26gt;").replace(/"/g, "\x26quot;").replace(/'/g, "\x26#x27;").replace(/\//g, "\x26#x2F;") : "Chart") + "\x3c/caption\x3e");
            for (var p = 0, u = b.length; p < u; ++p) b[p].length > d && (d = b[p].length);
            c += function (a, b, c) {
                var d = "\x3cthead\x3e", g = 0;
                c = c || b && b.length;
                var f, e, h = 0;
                if (e = k && a && b) {
                    a:if (e = a.length, b.length === e) {
                        for (; e--;) if (a[e] !==
                            b[e]) {
                            e = !1;
                            break a
                        }
                        e = !0
                    } else e = !1;
                    e = !e
                }
                if (e) {
                    for (d += "\x3ctr\x3e"; g < c; ++g) e = a[g], f = a[g + 1], e === f ? ++h : h ? (d += n("th", "highcharts-table-topheading", 'scope\x3d"col" colspan\x3d"' + (h + 1) + '"', e), h = 0) : (e === b[g] ? l.exporting.useRowspanHeaders ? (f = 2, delete b[g]) : (f = 1, b[g] = "") : f = 1, d += n("th", "highcharts-table-topheading", 'scope\x3d"col"' + (1 < f ? ' valign\x3d"top" rowspan\x3d"' + f + '"' : ""), e));
                    d += "\x3c/tr\x3e"
                }
                if (b) {
                    d += "\x3ctr\x3e";
                    g = 0;
                    for (c = b.length; g < c; ++g) void 0 !== b[g] && (d += n("th", null, 'scope\x3d"col"', b[g]));
                    d += "\x3c/tr\x3e"
                }
                return d +
                    "\x3c/thead\x3e"
            }(h, m, Math.max(d, m.length));
            c += "\x3ctbody\x3e";
            b.forEach(function (a) {
                c += "\x3ctr\x3e";
                for (var b = 0; b < d; b++) c += n(b ? "td" : "th", null, b ? "" : 'scope\x3d"row"', a[b]);
                c += "\x3c/tr\x3e"
            });
            c += "\x3c/tbody\x3e\x3c/table\x3e";
            b = {html: c};
            a.fireEvent(this, "afterGetTable", b);
            return b.html
        };
        a.Chart.prototype.downloadXLS = function () {
            var a = '\x3chtml xmlns:o\x3d"urn:schemas-microsoft-com:office:office" xmlns:x\x3d"urn:schemas-microsoft-com:office:excel" xmlns\x3d"http://www.w3.org/TR/REC-html40"\x3e\x3chead\x3e\x3c!--[if gte mso 9]\x3e\x3cxml\x3e\x3cx:ExcelWorkbook\x3e\x3cx:ExcelWorksheets\x3e\x3cx:ExcelWorksheet\x3e\x3cx:Name\x3eArk1\x3c/x:Name\x3e\x3cx:WorksheetOptions\x3e\x3cx:DisplayGridlines/\x3e\x3c/x:WorksheetOptions\x3e\x3c/x:ExcelWorksheet\x3e\x3c/x:ExcelWorksheets\x3e\x3c/x:ExcelWorkbook\x3e\x3c/xml\x3e\x3c![endif]--\x3e\x3cstyle\x3etd{border:none;font-family: Calibri, sans-serif;} .number{mso-number-format:"0.00";} .text{ mso-number-format:"@";}\x3c/style\x3e\x3cmeta name\x3dProgId content\x3dExcel.Sheet\x3e\x3cmeta charset\x3dUTF-8\x3e\x3c/head\x3e\x3cbody\x3e' +
                this.getTable(!0) + "\x3c/body\x3e\x3c/html\x3e";
            z(k(a, "application/vnd.ms-excel") || "data:application/vnd.ms-excel;base64," + h.btoa(unescape(encodeURIComponent(a))), this.getFilename() + ".xls")
        };
        var d = a.getOptions().exporting;
        d && (a.extend(d.menuItemDefinitions, {
            downloadXLS: {
                textKey: "downloadXLS", onclick: function () {
                    this.downloadXLS()
                }
            }
        }), d.buttons.contextButton.menuItems.push("separator", "downloadCSV", "downloadXLS", "viewData", "openInCloud"));
        c.map && (c.map.prototype.exportKey = "name");
        c.mapbubble && (c.mapbubble.prototype.exportKey = "name");
        c.treemap && (c.treemap.prototype.exportKey = "name")
    })(h)
});
//# sourceMappingURL=export-data.js.map
