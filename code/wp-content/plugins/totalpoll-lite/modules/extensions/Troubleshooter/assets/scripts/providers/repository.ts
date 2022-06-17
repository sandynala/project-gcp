namespace TotalPoll {
    import Service = TotalCore.Common.Service;

    @Service('services.totalpoll')
    export class RepositoryService {
        public resource;

        constructor($resource, prefix, ajaxEndpoint) {
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

        runCheck(runEndpoint) {
            return this.resource.check({action: runEndpoint}).$promise;
        }

        runFix(fixEndpoint) {
            return this.resource.fix({action: fixEndpoint}).$promise;
        }
    }
}