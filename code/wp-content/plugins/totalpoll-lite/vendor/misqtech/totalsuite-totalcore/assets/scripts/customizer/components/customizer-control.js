var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var TotalCore;
(function (TotalCore) {
    var Customizer;
    (function (Customizer) {
        var Components;
        (function (Components) {
            var Component = TotalCore.Common.Component;
            var CustomizerControl = /** @class */ (function () {
                function CustomizerControl() {
                    this.type = 'text';
                }
                CustomizerControl.prototype.getTemplate = function () {
                    return "customizer-control-" + this.type + "-template";
                };
                CustomizerControl = __decorate([
                    Component('components.customizer', {
                        templateUrl: 'customizer-control-component-template',
                        bindings: {
                            type: '@',
                            label: '@',
                            help: '@',
                            options: '<',
                            ngModel: '=',
                        },
                        transclude: true,
                    })
                ], CustomizerControl);
                return CustomizerControl;
            }());
        })(Components = Customizer.Components || (Customizer.Components = {}));
    })(Customizer = TotalCore.Customizer || (TotalCore.Customizer = {}));
})(TotalCore || (TotalCore = {}));
