var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
///<reference path="../../common/decorators.ts"/>
///<reference path="../providers/settings.ts"/>
var TotalCore;
(function (TotalCore) {
    var Common;
    (function (Common) {
        var Filters;
        (function (Filters) {
            var I18n = /** @class */ (function () {
                function I18n(SettingsService) {
                    return function (input, separator) {
                        if (separator === void 0) { separator = '-'; }
                        return I18n_1.filter(input, separator, SettingsService.i18n);
                    };
                }
                I18n_1 = I18n;
                I18n.filter = function (name, separator, expressions) {
                    if (name && name.toString) {
                        return expressions[name] || name;
                    }
                };
                var I18n_1;
                I18n = I18n_1 = __decorate([
                    Common.Filter('filters.common', 'i18n')
                ], I18n);
                return I18n;
            }());
            Filters.I18n = I18n;
        })(Filters = Common.Filters || (Common.Filters = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
