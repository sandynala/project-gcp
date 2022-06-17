var TotalCore;
(function (TotalCore) {
    var Common;
    (function (Common) {
        var Models;
        (function (Models) {
            var Model = /** @class */ (function () {
                function Model(attributes) {
                    this.attributes = attributes;
                }
                Model.prototype.get = function (prop, defaultValue) {
                    if (defaultValue === void 0) { defaultValue = null; }
                    try {
                        var path_1 = this.attributes;
                        prop.split('.').forEach(function (part) {
                            path_1 = path_1[part];
                        });
                        return typeof path_1 === 'undefined' ? defaultValue : path_1;
                    }
                    catch (ex) {
                        return defaultValue;
                    }
                };
                Model.prototype.getFlatten = function () {
                    var result = {};
                    function recurse(cur, prop) {
                        if (Object(cur) !== cur) {
                            result[prop] = cur;
                        }
                        else if (Array.isArray(cur)) {
                            for (var i = 0, l = cur.length; i < l; i++)
                                recurse(cur[i], prop + "[" + i + "]");
                            if (l == 0)
                                result[prop] = [];
                        }
                        else {
                            var isEmpty = true;
                            for (var p in cur) {
                                isEmpty = false;
                                recurse(cur[p], prop ? prop + "." + p : p);
                            }
                            if (isEmpty && prop)
                                result[prop] = {};
                        }
                    }
                    recurse(this.getRaw(), "");
                    return result;
                };
                Model.prototype.getId = function () {
                    return this.get('id');
                };
                Model.prototype.getRaw = function () {
                    return this.attributes;
                };
                Model.prototype.set = function (prop, value) {
                    var path = this.attributes;
                    var parts = prop.split('.');
                    parts.forEach(function (part, index) {
                        if (!path[part]) {
                            path[part] = {};
                        }
                        if (index == (parts.length - 1)) {
                            path[part] = value;
                        }
                        else {
                            path = path[part];
                        }
                    });
                    return path;
                };
                return Model;
            }());
            Models.Model = Model;
        })(Models = Common.Models || (Common.Models = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
