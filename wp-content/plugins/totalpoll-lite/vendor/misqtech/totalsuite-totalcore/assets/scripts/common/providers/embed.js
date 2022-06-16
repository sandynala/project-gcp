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
            var EmbedService = /** @class */ (function () {
                function EmbedService($q, $http) {
                    this.$q = $q;
                    this.$http = $http;
                    this.providersUrlPatterns = [
                        /https?:\/\/((m|www)\.)?youtube\.com\/watch.*/i,
                        /https?:\/\/((m|www)\.)?youtube\.com\/playlist.*/i,
                        /https?:\/\/youtu\.be\/.*/i,
                        /https?:\/\/(.+\.)?vimeo\.com\/.*/i,
                        /https?:\/\/(www\.)?dailymotion\.com\/.*/i,
                        /https?:\/\/dai\.ly\/.*/i,
                        /https?:\/\/(www\.)?(animoto|video214)\.com\/play\/.*/i,
                        /https?:\/\/(www\.)?twitter\.com\/i\/moments\/.*/i,
                        /https?:\/\/www\.facebook\.com\/video\.php.*/i,
                        /https?:\/\/www\.facebook\.com\/.*\/videos\/.*/i,
                        /https?:\/\/vine\.co\/v\/.*/i,
                        /https?:\/\/(www\.)?mixcloud\.com\/.*/i,
                        /https?:\/\/(www\.)?reverbnation\.com\/.*/i,
                        /https?:\/\/(www\.)?soundcloud\.com\/.*/i,
                        /https?:\/\/(open|play)\.spotify\.com\/.*/i,
                    ];
                }
                EmbedService.prototype.discover = function (url) {
                    return this.$http
                        .get('https://noembed.com/embed', {
                        params: {
                            format: 'json',
                            url: url,
                        },
                        cache: true,
                        responseType: 'json'
                    })
                        .then(function (response) {
                        return response.data;
                    });
                };
                EmbedService.prototype.fetch = function (url) {
                    var _this = this;
                    return this.$q(function (resolve, reject) {
                        for (var _i = 0, _a = _this.providersUrlPatterns; _i < _a.length; _i++) {
                            var regExp = _a[_i];
                            if (regExp.exec(url)) {
                                return _this.discover(url).then(function (response) {
                                    resolve(response);
                                }).catch(reject);
                            }
                        }
                        reject();
                    });
                };
                EmbedService = __decorate([
                    Common.Service('services.common')
                ], EmbedService);
                return EmbedService;
            }());
            Providers.EmbedService = EmbedService;
        })(Providers = Common.Providers || (Common.Providers = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
