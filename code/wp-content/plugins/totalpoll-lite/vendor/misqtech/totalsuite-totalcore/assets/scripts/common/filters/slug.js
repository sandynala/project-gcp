var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
///<reference path="../../common/decorators.ts"/>
var TotalCore;
(function (TotalCore) {
    var Common;
    (function (Common) {
        var Filters;
        (function (Filters) {
            var Slug = /** @class */ (function () {
                function Slug() {
                    return function (input, separator) {
                        if (separator === void 0) { separator = '-'; }
                        return Slug_1.filter(input, separator);
                    };
                }
                Slug_1 = Slug;
                Slug.filter = function (name, separator, keepEdge) {
                    if (keepEdge === void 0) { keepEdge = false; }
                    if (name && name.toString) {
                        return name
                            .toString()
                            .toLowerCase()
                            .replace(/\s+/g, separator) // Replace spaces with -
                            .replace(new RegExp(("[\\" + Slug_1.specialChars.join('\\') + "]+").replace("\\" + separator, ''), 'g'), '') // Remove all non-word chars
                            .replace(new RegExp("\\" + separator + "\\" + separator + "+", 'g'), separator) // Replace multiple - with single -
                            .replace(keepEdge ? null : new RegExp("^\\" + separator + "+"), '') // Trim - from start of text
                            .replace(keepEdge ? null : new RegExp("\\" + separator + "+$"), ''); // Trim - from end of text
                    }
                };
                var Slug_1;
                Slug.$inject = [];
                Slug.specialChars = ["!", "@", "#", "$", "%", "^", "&", "*", "<", ">", ":", ".", ";", ",", "!", "?", "§", "¨", "£", "-", "_", "(", ")", "{", "}", "[", "]", "=", "+", "|", "~", "`", "'", "°", '"', "/", "\\"];
                Slug = Slug_1 = __decorate([
                    Common.Filter('filters.common', 'slug')
                ], Slug);
                return Slug;
            }());
            Filters.Slug = Slug;
        })(Filters = Common.Filters || (Common.Filters = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
