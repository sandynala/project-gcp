///<reference path="../../../../../../vendor/misqtech/totalsuite-totalcore/assets/scripts/common/decorators.ts" />
///<reference path="../../../../../../vendor/misqtech/totalsuite-totalcore/assets/scripts/common/helpers.ts" />

namespace TotalPoll {
    import Controller = TotalCore.Common.Controller;
    import Processable = TotalCore.Common.Processable;
    import RepositoryService = TotalPoll.RepositoryService;
    import ISCEService = angular.ISCEService;

    @Controller('controllers.totalpoll')
    export class TroubleshooterCtrl extends Processable {
        public currentTest = 0;
        public tests = window['TotalPollTests'] || [];

        public constructor(private RepositoryService: RepositoryService, private $sce: ISCEService) {
            super();
        }

        public fix(test) {
            test.running = true;
            test.errors = null;
            test.fixing = true;

            this.RepositoryService
                .runFix(test.fix)
                .then((result) => {
                    test.done = true;
                    test.fixable = false;
                })
                .catch((result) => {
                    test.fixable = result.data.data.fixable || false;
                    test.warnings = this.$sce.trustAsHtml(result.data.data.warnings);
                    test.errors = this.$sce.trustAsHtml(result.data.data.errors);
                })
                .finally((result) => {
                    test.running = false;
                    test.fixing = false;
                });
        }

        public run() {
            var test = this.tests[this.currentTest];
            if (!test) {
                this.stopProcessing();
                return;
            }

            this.startProcessing();

            test.running = true;
            this.RepositoryService
                .runCheck(test.check)
                .then((result) => {
                    test.done = true;

                    return result;
                })
                .catch((result) => {
                    test.fixable = result.data.data.fixable || false;
                    test.warnings = this.$sce.trustAsHtml(result.data.data.warnings);
                    test.errors = this.$sce.trustAsHtml(result.data.data.errors);

                    return result;
                })
                .finally((result) => {
                    test.running = false;
                    this.currentTest++;
                    this.run();

                    return result;
                });

        }
    }

}