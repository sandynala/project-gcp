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
            var Carousel = /** @class */ (function () {
                function Carousel() {
                    return {
                        restrict: 'A',
                        link: function ($scope, element, attributes) {
                            var $slides = element.find('[carousel-slides-item]');
                            var $controls = element.find('[carousel-controls-item]');
                            var autoSlidingInterval;
                            var startAutoSliding = function () {
                                if (!autoSlidingInterval) {
                                    moveToNext();
                                }
                                else {
                                    clearInterval(autoSlidingInterval);
                                }
                                autoSlidingInterval = setInterval(function () { return moveToNext(); }, 5000);
                            };
                            var stopAutoSliding = function () {
                                clearInterval(autoSlidingInterval);
                            };
                            var moveToNext = function () {
                                moveTo($slides.filter('.active').index() + 1);
                            };
                            var moveTo = function (offset) {
                                var $current = $slides.filter('.active');
                                if ($current.index() === offset) {
                                    return;
                                }
                                if (offset >= $slides.length) {
                                    offset = 0;
                                }
                                $slides.removeClass('previous');
                                $slides.removeClass('active');
                                $slides.eq(offset).addClass('active');
                                $current.addClass('previous');
                                setTimeout(function () {
                                    $current.removeClass('previous');
                                }, 750);
                                $controls.removeClass('active');
                                $controls.eq(offset).addClass('active');
                            };
                            $controls.on('click', function (event) {
                                moveTo(angular.element(event.target).index());
                            });
                            element.on('mouseleave', startAutoSliding);
                            element.on('mouseenter', stopAutoSliding);
                            startAutoSliding();
                        }
                    };
                }
                Carousel = __decorate([
                    Common.Directive('directives.common', 'carousel')
                ], Carousel);
                return Carousel;
            }());
            Directives.Carousel = Carousel;
        })(Directives = Common.Directives || (Common.Directives = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
