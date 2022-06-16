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
            var CustomizerTab = /** @class */ (function () {
                function CustomizerTab() {
                }
                CustomizerTab.prototype.getTarget = function () {
                    return [this.$content ? this.$content.getTarget() : null, this.target].filter(Boolean).join('.');
                };
                CustomizerTab = __decorate([
                    Component('components.customizer', {
                        templateUrl: 'customizer-tab-component-template',
                        bindings: {
                            target: '@',
                        },
                        require: {
                            $customizer: '^customizer',
                            $content: '?^^customizerTabContent',
                        },
                        transclude: true,
                    })
                ], CustomizerTab);
                return CustomizerTab;
            }());
        })(Components = Customizer.Components || (Customizer.Components = {}));
    })(Customizer = TotalCore.Customizer || (TotalCore.Customizer = {}));
})(TotalCore || (TotalCore = {}));
