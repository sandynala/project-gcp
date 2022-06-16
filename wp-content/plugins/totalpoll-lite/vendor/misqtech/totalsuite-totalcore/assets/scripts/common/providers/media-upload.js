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
        var Providers;
        (function (Providers) {
            var wp = window['wp'];
            var MediaUploadService = /** @class */ (function () {
                function MediaUploadService($q) {
                    this.$q = $q;
                }
                MediaUploadService.prototype.customFrame = function (args) {
                    return wp.media(angular.extend({}, { title: wp.media.view.l10n.insertMediaTitle }, args));
                };
                MediaUploadService.prototype.frame = function (type) {
                    if (!this.wpMediaFrame) {
                        this.wpMediaFrame = wp.media({
                            title: wp.media.view.l10n.insertMediaTitle,
                            multiple: false,
                            library: {
                                type: type
                            }
                        });
                    }
                    if (type !== this.wpMediaFrame.options.library.type) {
                        this.wpMediaFrame = false;
                        this.frame(type);
                    }
                    return this.wpMediaFrame;
                };
                MediaUploadService.prototype.open = function (type) {
                    var _this = this;
                    return this.$q(function (resolve, reject) {
                        try {
                            _this.frame(type).open();
                            _this.wpMediaFrame
                                .state('library')
                                .off('select')
                                .on('select', function () {
                                resolve(this.get('selection').first());
                            });
                        }
                        catch (exception) {
                            reject(exception);
                        }
                    });
                };
                MediaUploadService = __decorate([
                    Common.Service('services.common')
                ], MediaUploadService);
                return MediaUploadService;
            }());
            Providers.MediaUploadService = MediaUploadService;
        })(Providers = Common.Providers || (Common.Providers = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
