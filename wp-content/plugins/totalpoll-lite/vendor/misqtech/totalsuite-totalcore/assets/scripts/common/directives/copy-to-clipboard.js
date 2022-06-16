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
        var Directives;
        (function (Directives) {
            var CopyToClipboard = /** @class */ (function () {
                function CopyToClipboard() {
                    var copyToClipboard = function (text) {
                        if (window['clipboardData'] && window['clipboardData'].setData) {
                            return window['clipboardData'].setData("Text", text);
                        }
                        else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
                            var textarea = document.createElement("textarea");
                            textarea.textContent = text;
                            textarea.style.position = "fixed";
                            document.body.appendChild(textarea);
                            textarea.select();
                            try {
                                return document.execCommand("copy");
                            }
                            catch (ex) {
                                prompt('', text);
                                return false;
                            }
                            finally {
                                document.body.removeChild(textarea);
                            }
                        }
                    };
                    return {
                        restrict: 'A',
                        link: function ($scope, element, attributes) {
                            element.on('click', function () {
                                var originalHTML = element.html();
                                copyToClipboard(attributes['copyToClipboard']);
                                element.html(attributes['copyToClipboardDone'] || '<span class="dashicons dashicons-yes"></span>');
                                setTimeout(function () {
                                    element.html(originalHTML);
                                }, 1000);
                            });
                        }
                    };
                }
                CopyToClipboard = __decorate([
                    Common.Directive('directives.common', 'copyToClipboard')
                ], CopyToClipboard);
                return CopyToClipboard;
            }());
            Directives.CopyToClipboard = CopyToClipboard;
        })(Directives = Common.Directives || (Common.Directives = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
