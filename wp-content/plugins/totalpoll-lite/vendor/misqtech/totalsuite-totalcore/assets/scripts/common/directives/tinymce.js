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
            var TinyMCE = /** @class */ (function () {
                function TinyMCE($sce, $rootScope, $timeout, $compile) {
                    return {
                        require: ['ngModel'],
                        restrict: 'E',
                        scope: {
                            'model': '=ngModel',
                        },
                        link: function ($scope, element, attributes, ctrls) {
                            var tinymceElement;
                            var debouncedUpdate;
                            var editor;
                            var updateView;
                            var uniqueId;
                            var template;
                            var id;
                            var settings;
                            if (!window['tinymce']) {
                                return;
                            }
                            updateView = function (editor) {
                                $scope.model = editor.getContent().trim();
                                if (!$rootScope.$$phase) {
                                    $scope.$digest();
                                }
                            };
                            debouncedUpdate = (function (debouncedUpdateDelay) {
                                var debouncedUpdateTimer;
                                return function (editorInstance) {
                                    $timeout.cancel(debouncedUpdateTimer);
                                    debouncedUpdateTimer = $timeout(function () {
                                        return (function (editorInstance) {
                                            if (editorInstance.isDirty()) {
                                                editorInstance.save();
                                                updateView(editorInstance);
                                            }
                                        })(editorInstance);
                                    }, debouncedUpdateDelay);
                                };
                            })(400);
                            template = window['TinyMCETemplate'] || '';
                            uniqueId = Date.now() + Math.floor(Math.random() * 30);
                            id = "tinymce-field-" + uniqueId;
                            settings = angular.copy(window['tinyMCEPreInit']['mceInit']['tinymce-field']);
                            settings.selector = "#" + id;
                            settings.cache_suffix = "wp-mce-" + uniqueId;
                            settings.body_class = settings.body_class.replace('tinymce-field', id);
                            settings.init_instance_callback = function (editor) {
                                editor.on('ExecCommand change NodeChange ObjectResized', function () {
                                    debouncedUpdate(editor);
                                });
                                try {
                                    editor.setContent($scope.model || '');
                                }
                                catch (ex) {
                                    if (!(ex instanceof TypeError)) {
                                        console.error(ex);
                                    }
                                }
                                if (window['switchEditors']) {
                                    window['switchEditors'].go(id, 'html');
                                }
                            };
                            template = template
                                .replace(/name="tinymce\-textarea\-name"/g, "name=\"" + id + "\" ng-model=\"model\"")
                                .replace(/tinymce\-field/g, id);
                            tinymceElement = $compile(template)($scope);
                            element.append(tinymceElement);
                            window['tinyMCEPreInit'].mceInit[id] = settings;
                            window['tinyMCEPreInit']['qtInit'][id] = angular.copy(window['tinyMCEPreInit']['qtInit']['tinymce-field']);
                            window['tinyMCEPreInit']['qtInit'][id].id = id;
                            window['tinymce'].init(settings);
                            window['quicktags']({ id: id, buttons: window['tinyMCEPreInit']['qtInit'][id].buttons });
                            window['QTags']._buttonsInit();
                        }
                    };
                }
                ;
                TinyMCE = __decorate([
                    Common.Directive('directives.common', 'tinymce')
                ], TinyMCE);
                return TinyMCE;
            }());
            Directives.TinyMCE = TinyMCE;
        })(Directives = Common.Directives || (Common.Directives = {}));
    })(Common = TotalCore.Common || (TotalCore.Common = {}));
})(TotalCore || (TotalCore = {}));
