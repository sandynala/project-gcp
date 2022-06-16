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
        var Directives;
        (function (Directives) {
            var Colorpicker = /** @class */ (function () {
                function Colorpicker() {
                    return {
                        restrict: 'A',
                        require: 'ngModel',
                        scope: {
                            'model': '=ngModel'
                        },
                        link: function ($scope, element, attributes, ngModel) {
                            var updateModel = function (color) {
                                ngModel.$setViewValue(color);
                                ngModel.$render();
                                $scope.$applyAsync();
                            };
                            var defaultOptions = {
                                change: function (event, ui) {
                                    updateModel(ui.color.toCSS());
                                },
                                clear: function () {
                                    updateModel('');
                                }
                            };
                            var userOptions = JSON.parse(attributes.colorPicker || "{}");
                            var mergedOptions = angular.merge({}, defaultOptions, userOptions);
                            element.wpColorPicker(mergedOptions);
                            element.wpColorPicker('color', $scope.model);
                            $scope.$watch('model', function (color, oldColor) {
                                if (color != oldColor) {
                                    element.wpColorPicker('color', color);
                                }
                            });
                        }
                    };
                }
                Colorpicker = __decorate([
                    Common.Directive('directives.common', 'colorPicker')
                ], Colorpicker);
                return Colorpicker;
            }());
            Directives.Colorpicker = Colorpicker;
        })(Directives = Common.Directives || (Common.Directives = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
