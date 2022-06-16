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
            var CustomizerComponent = /** @class */ (function () {
                function CustomizerComponent($scope, $compile, $templateCache, $http, $sce, $element, $q, SettingsService) {
                    this.$scope = $scope;
                    this.$compile = $compile;
                    this.$templateCache = $templateCache;
                    this.$http = $http;
                    this.$sce = $sce;
                    this.$element = $element;
                    this.$q = $q;
                    this.SettingsService = SettingsService;
                    this.device = 'laptop';
                    this.devices = {
                        smartphone: {
                            width: 431,
                            height: 877,
                            canvas: {
                                width: 375,
                                height: 667,
                                top: 105,
                                right: 402,
                                bottom: 772,
                                left: 27,
                            }
                        },
                        tablet: {
                            width: 875,
                            height: 1253,
                            canvas: {
                                width: 768,
                                height: 1024,
                                top: 114,
                                right: 820,
                                bottom: 1138,
                                left: 52,
                            }
                        },
                    };
                    this.preview = {
                        screen: '',
                    };
                    this.settings = {};
                    this.tab = [];
                    this.settings = SettingsService.settings.design || this.settings;
                    this.iframe = $element.find('iframe').contents();
                    if (!this.SettingsService.templates[this.getTemplate()]) {
                        this.setTemplate(this.SettingsService.defaults.design.template);
                    }
                    window['jQuery'](window).resize(function () {
                        $scope.$applyAsync();
                    });
                }
                CustomizerComponent.prototype.$onInit = function () {
                    this.preparePreview();
                };
                CustomizerComponent.prototype.changeTemplateTo = function (template, $event) {
                    $event.stopPropagation();
                    this.setTemplate(template.id);
                    this.popToRoot();
                    this.preparePreview();
                };
                CustomizerComponent.prototype.escape = function (content) {
                    return this.$sce.trustAsHtml(content);
                };
                CustomizerComponent.prototype.getActiveTab = function () {
                    return this.tab[this.tab.length - 1];
                };
                CustomizerComponent.prototype.getActiveTabBreadcrumb = function () {
                    return this.tab
                        .map(function (tab) {
                        return tab.label;
                    })
                        .join(' / ');
                };
                CustomizerComponent.prototype.getCurrentTemplate = function (field) {
                    var template = this.SettingsService.templates[this.getTemplate()];
                    return field ? template[field] : template;
                };
                CustomizerComponent.prototype.getCurrentTemplateDefaults = function () {
                    if (this.getCurrentTemplate('defaults')) {
                        return this.$http.get(this.prefixUrl(this.getCurrentTemplate('defaults')), { cache: true }).then(function (response) { return response.data; });
                    }
                    return this.$q.resolve({});
                };
                CustomizerComponent.prototype.getCurrentTemplatePreviewContentId = function () {
                    return this.getCurrentTemplate('preview') ? this.prefixUrl(this.getCurrentTemplate('preview')) : null;
                };
                CustomizerComponent.prototype.getCurrentTemplatePreviewCssId = function () {
                    return this.getCurrentTemplate('stylesheet') ? this.prefixUrl(this.getCurrentTemplate('stylesheet')) : null;
                };
                CustomizerComponent.prototype.getCurrentTemplateSettingsId = function () {
                    return this.getCurrentTemplate('settings') ? this.prefixUrl(this.getCurrentTemplate('settings')) : null;
                };
                CustomizerComponent.prototype.getDevice = function () {
                    return this.device;
                };
                CustomizerComponent.prototype.getDeviceScaleAttributes = function () {
                    if (this.device === 'laptop') {
                        return {};
                    }
                    var scale = this.$element.find('iframe').parent().outerHeight() / this.devices[this.device].height;
                    return {
                        transform: "scale(" + scale + ")",
                        marginTop: this.devices[this.device].canvas.top * scale,
                    };
                };
                CustomizerComponent.prototype.getScreen = function () {
                    return this.preview.screen;
                };
                CustomizerComponent.prototype.getTemplate = function () {
                    return this.settings.template;
                };
                CustomizerComponent.prototype.getTemplates = function () {
                    return this.SettingsService.templates;
                };
                CustomizerComponent.prototype.hasActiveTab = function (tab) {
                    if (tab) {
                        for (var _i = 0, _a = this.tab; _i < _a.length; _i++) {
                            var item = _a[_i];
                            if (item.id === tab) {
                                return true;
                            }
                        }
                        return false;
                    }
                    else {
                        return this.tab.length > 0;
                    }
                };
                CustomizerComponent.prototype.hasActiveTabAfter = function (tab) {
                    return this.hasActiveTab(tab) && this.getActiveTab().id !== tab;
                };
                CustomizerComponent.prototype.isActiveTab = function (tab) {
                    if (this.tab.length > 0) {
                        return this.tab[this.tab.length - 1].id === tab;
                    }
                    return false;
                };
                CustomizerComponent.prototype.isDevice = function (device) {
                    return this.device === device;
                };
                CustomizerComponent.prototype.isScreen = function (screen) {
                    return this.preview.screen === screen;
                };
                CustomizerComponent.prototype.isTemplate = function (template) {
                    return this.settings.template === template;
                };
                CustomizerComponent.prototype.popActiveTab = function () {
                    this.tab.pop();
                };
                CustomizerComponent.prototype.popToRoot = function () {
                    this.tab = [];
                };
                CustomizerComponent.prototype.preparePreview = function () {
                    var _this = this;
                    var headTemplate = this.$templateCache.get('customizer-preview-head-template');
                    var bodyTemplate = this.$templateCache.get('customizer-preview-body-template');
                    var compiledHeadTemplate = this.$compile(headTemplate);
                    var compiledBodyTemplate = this.$compile(bodyTemplate);
                    this.getCurrentTemplateDefaults()
                        .then(function (defaults) {
                        _this.settings.custom = angular.extend({}, defaults, _this.settings.custom);
                        _this.$scope.custom = _this.settings.custom;
                        angular.forEach(_this.settings, function (value, key) {
                            _this.$scope[key] = value;
                        });
                    });
                    this.iframe.html('');
                    this.iframe.find('head').append(compiledHeadTemplate(this.$scope));
                    this.iframe.find('body').html(compiledBodyTemplate(this.$scope));
                };
                CustomizerComponent.prototype.resetActiveTab = function () {
                    this.tab = [];
                };
                CustomizerComponent.prototype.resetToDefaults = function (confirmBefore) {
                    var _this = this;
                    if (confirmBefore === void 0) { confirmBefore = false; }
                    if (confirmBefore && !confirm('Are you sure?')) {
                        return;
                    }
                    this.getCurrentTemplateDefaults()
                        .then(function (defaults) {
                        _this.settings.custom = angular.extend({}, _this.settings.custom, defaults);
                        _this.$scope.custom = _this.settings.custom;
                    });
                    if (confirmBefore) {
                        alert('Done');
                    }
                };
                CustomizerComponent.prototype.setActiveTab = function (tab, label) {
                    this.tab.push({ id: tab, label: label });
                };
                CustomizerComponent.prototype.setDevice = function (device) {
                    this.device = device;
                };
                CustomizerComponent.prototype.setScreen = function (screen) {
                    this.preview.screen = screen;
                };
                CustomizerComponent.prototype.setTemplate = function (template) {
                    this.settings.template = template;
                    this.resetToDefaults();
                };
                CustomizerComponent.prototype.prefixUrl = function (url) {
                    if (url.match(/^(https?:)?\/\//g)) {
                        return url;
                    }
                    return "" + this.getCurrentTemplate('url') + url;
                };
                CustomizerComponent = __decorate([
                    Component('components.customizer', {
                        templateUrl: 'customizer-component-template',
                        bindings: {}
                    })
                ], CustomizerComponent);
                return CustomizerComponent;
            }());
        })(Components = Customizer.Components || (Customizer.Components = {}));
    })(Customizer = TotalCore.Customizer || (TotalCore.Customizer = {}));
})(TotalCore || (TotalCore = {}));
