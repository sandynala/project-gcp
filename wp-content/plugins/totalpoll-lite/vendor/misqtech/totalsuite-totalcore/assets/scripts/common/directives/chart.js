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
            var Chart = /** @class */ (function () {
                function Chart() {
                    return {
                        restrict: 'E',
                        require: 'ngModel',
                        scope: {
                            'model': '=ngModel'
                        },
                        template: '<canvas></canvas>',
                        link: function ($scope, element, attributes, ngModel) {
                            var chartInstance;
                            if (!window['Chart']) {
                                throw new Error('Chart.js library is required for charts.');
                            }
                            var defaultOptions = {
                                type: attributes.type || 'line',
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        yAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }],
                                        xAxes: [{
                                                ticks: {
                                                    beginAtZero: true
                                                }
                                            }]
                                    },
                                    animation: {
                                        animateScale: true,
                                        animateRotate: true
                                    }
                                },
                                data: $scope.model || { datasets: [] },
                            };
                            if (defaultOptions.type === 'doughnut') {
                                delete defaultOptions.options.scales;
                            }
                            var userOptions = JSON.parse(attributes.options || "{}");
                            var mergedOptions = angular.merge({}, defaultOptions, userOptions);
                            chartInstance = new window['Chart'](element.find('canvas'), mergedOptions);
                            $scope.$watch('model', function (newValue, oldValue, scope) {
                                if (newValue === oldValue) {
                                    return;
                                }
                                chartInstance.data = angular.copy(newValue);
                                chartInstance.update();
                            }, true);
                        }
                    };
                }
                Chart = __decorate([
                    Common.Directive('directives.common', 'chart')
                ], Chart);
                return Chart;
            }());
            Directives.Chart = Chart;
        })(Directives = Common.Directives || (Common.Directives = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
