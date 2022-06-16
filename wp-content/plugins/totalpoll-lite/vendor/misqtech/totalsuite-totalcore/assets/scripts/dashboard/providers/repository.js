var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var TotalCore;
(function (TotalCore) {
    var Dashboard;
    (function (Dashboard) {
        var Providers;
        (function (Providers) {
            var Service = TotalCore.Common.Service;
            var RepositoryService = /** @class */ (function () {
                function RepositoryService($resource, ajaxEndpoint, prefix) {
                    this.resource = $resource(ajaxEndpoint, {}, {
                        activate: { method: 'GET', params: { action: prefix + "_dashboard_activate" } },
                        account: { method: 'GET', params: { action: prefix + "_dashboard_account" } },
                    });
                    return this;
                }
                RepositoryService.prototype.postAccount = function (account) {
                    return this.resource.account(account).$promise;
                };
                RepositoryService.prototype.postActivation = function (activation) {
                    return this.resource.activate(activation).$promise;
                };
                RepositoryService = __decorate([
                    Service('services.dashboard')
                ], RepositoryService);
                return RepositoryService;
            }());
            Providers.RepositoryService = RepositoryService;
        })(Providers = Dashboard.Providers || (Dashboard.Providers = {}));
    })(Dashboard = TotalCore.Dashboard || (TotalCore.Dashboard = {}));
})(TotalCore || (TotalCore = {}));
