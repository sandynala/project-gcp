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
///<reference path="../../common/helpers.ts"/>
///<reference path="../../common/providers/settings.ts"/>
///<reference path="../providers/repository.ts"/>
var TotalCore;
(function (TotalCore) {
    var Dashboard;
    (function (Dashboard) {
        var Components;
        (function (Components) {
            var Component = TotalCore.Common.Component;
            var Processable = TotalCore.Common.Processable;
            var DashboardActivationComponent = /** @class */ (function (_super) {
                __extends(DashboardActivationComponent, _super);
                function DashboardActivationComponent(RepositoryService, SettingsService) {
                    var _this = _super.call(this) || this;
                    _this.RepositoryService = RepositoryService;
                    _this.SettingsService = SettingsService;
                    _this.activation = {
                        status: _this.SettingsService.activation['status'] || false,
                        key: _this.SettingsService.activation['key'] || '',
                        email: _this.SettingsService.activation['email'] || '',
                    };
                    return _this;
                }
                DashboardActivationComponent.prototype.validate = function () {
                    var _this = this;
                    this.startProcessing();
                    this.error = null;
                    this.RepositoryService.postActivation(this.activation)
                        .then(function (response) {
                        if (response.success) {
                            _this.activation.status = true;
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
                DashboardActivationComponent = __decorate([
                    Component('components.dashboard', {
                        templateUrl: 'dashboard-activation-component-template',
                        bindings: {}
                    })
                ], DashboardActivationComponent);
                return DashboardActivationComponent;
            }(Processable));
        })(Components = Dashboard.Components || (Dashboard.Components = {}));
    })(Dashboard = TotalCore.Dashboard || (TotalCore.Dashboard = {}));
})(TotalCore || (TotalCore = {}));
