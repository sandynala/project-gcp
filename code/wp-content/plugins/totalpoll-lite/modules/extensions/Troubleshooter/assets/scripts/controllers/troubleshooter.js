///<reference path="../../../../../../vendor/misqtech/totalsuite-totalcore/assets/scripts/common/decorators.ts" />
///<reference path="../../../../../../vendor/misqtech/totalsuite-totalcore/assets/scripts/common/helpers.ts" />
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
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
var TotalPoll;
(function (TotalPoll) {
    var Controller = TotalCore.Common.Controller;
    var Processable = TotalCore.Common.Processable;
    var TroubleshooterCtrl = /** @class */ (function (_super) {
        __extends(TroubleshooterCtrl, _super);
        function TroubleshooterCtrl(RepositoryService, $sce) {
            var _this = _super.call(this) || this;
            _this.RepositoryService = RepositoryService;
            _this.$sce = $sce;
            _this.currentTest = 0;
            _this.tests = window['TotalPollTests'] || [];
            return _this;
        }
        TroubleshooterCtrl.prototype.fix = function (test) {
            var _this = this;
            test.running = true;
            test.errors = null;
            test.fixing = true;
            this.RepositoryService
                .runFix(test.fix)
                .then(function (result) {
                test.done = true;
                test.fixable = false;
            })
                .catch(function (result) {
                test.fixable = result.data.data.fixable || false;
                test.warnings = _this.$sce.trustAsHtml(result.data.data.warnings);
                test.errors = _this.$sce.trustAsHtml(result.data.data.errors);
            })
                .finally(function (result) {
                test.running = false;
                test.fixing = false;
            });
        };
        TroubleshooterCtrl.prototype.run = function () {
            var _this = this;
            var test = this.tests[this.currentTest];
            if (!test) {
                this.stopProcessing();
                return;
            }
            this.startProcessing();
            test.running = true;
            this.RepositoryService
                .runCheck(test.check)
                .then(function (result) {
                test.done = true;
                return result;
            })
                .catch(function (result) {
                test.fixable = result.data.data.fixable || false;
                test.warnings = _this.$sce.trustAsHtml(result.data.data.warnings);
                test.errors = _this.$sce.trustAsHtml(result.data.data.errors);
                return result;
            })
                .finally(function (result) {
                test.running = false;
                _this.currentTest++;
                _this.run();
                return result;
            });
        };
        TroubleshooterCtrl = __decorate([
            Controller('controllers.totalpoll')
        ], TroubleshooterCtrl);
        return TroubleshooterCtrl;
    }(Processable));
    TotalPoll.TroubleshooterCtrl = TroubleshooterCtrl;
})(TotalPoll || (TotalPoll = {}));
