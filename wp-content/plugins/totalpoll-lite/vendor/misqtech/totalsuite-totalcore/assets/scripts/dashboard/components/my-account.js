var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
///<reference path="../../common/decorators.ts"/>
var TotalCore;
(function (TotalCore) {
    var Component = TotalCore.Common.Component;
    var Processable = TotalCore.Common.Processable;
    var DashboardMyAccountComponent = /** @class */ (function (_super) {
        __extends(DashboardMyAccountComponent, _super);
        function DashboardMyAccountComponent($scope, RepositoryService, SettingsService) {
            var _this = _super.call(this) || this;
            _this.$scope = $scope;
            _this.RepositoryService = RepositoryService;
            _this.SettingsService = SettingsService;
            _this.account = {
                access_token: _this.SettingsService.account['access_token'] || '',
                email: _this.SettingsService.account['email'] || '',
                status: _this.SettingsService.account['status'] || false,
            };
            return _this;
        }
        DashboardMyAccountComponent.prototype.$onInit = function () {
            var _this = this;
            window.addEventListener('message', function (event) {
                if (event.data.totalsuite && event.data.totalsuite.auth.access_token) {
                    _this.$scope.$applyAsync(function () {
                        _this.account.access_token = event.data.totalsuite.auth.access_token;
                        _this.validate();
                    });
                }
            }, false);
        };
        DashboardMyAccountComponent.prototype.openSignInPopup = function (url) {
            window.open(url, 'popup', 'width=600,height=600');
        };
        DashboardMyAccountComponent.prototype.validate = function () {
            var _this = this;
            this.startProcessing();
            this.error = null;
            this.RepositoryService.postAccount(this.account)
                .then(function (response) {
                if (response.success) {
                    _this.account.status = true;
                    _this.account.email = response.data.email;
                }
                else {
                    _this.error = response.data;
                }
            })
                .catch(function (error) {
                _this.error = error.statusText;
            })
                .finally(function () { return _this.stopProcessing(); });
        };
        DashboardMyAccountComponent = __decorate([
            Component('components.dashboard', {
                templateUrl: 'dashboard-my-account-component-template',
                bindings: {}
            })
        ], DashboardMyAccountComponent);
        return DashboardMyAccountComponent;
    }(Processable));
})(TotalCore || (TotalCore = {}));
