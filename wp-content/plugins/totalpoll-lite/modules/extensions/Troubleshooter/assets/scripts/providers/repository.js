var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var TotalPoll;
(function (TotalPoll) {
    var Service = TotalCore.Common.Service;
    var RepositoryService = /** @class */ (function () {
        function RepositoryService($resource, prefix, ajaxEndpoint) {
            this.resource = $resource(ajaxEndpoint, {}, {
                check: {
                    method: 'POST',
                },
                fix: {
                    method: 'POST',
                },
            });
            return this;
        }
        RepositoryService.prototype.runCheck = function (runEndpoint) {
            return this.resource.check({ action: runEndpoint }).$promise;
        };
        RepositoryService.prototype.runFix = function (fixEndpoint) {
            return this.resource.fix({ action: fixEndpoint }).$promise;
        };
        RepositoryService = __decorate([
            Service('services.totalpoll')
        ], RepositoryService);
        return RepositoryService;
    }());
    TotalPoll.RepositoryService = RepositoryService;
})(TotalPoll || (TotalPoll = {}));
