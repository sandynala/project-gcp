var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
///<reference path="../../common/decorators.ts"/>
var TotalCore;
(function (TotalCore) {
    var Dashboard;
    (function (Dashboard) {
        var Components;
        (function (Components) {
            var Component = TotalCore.Common.Component;
            var DashboardGetStartedComponent = /** @class */ (function () {
                function DashboardGetStartedComponent($sce) {
                    this.$sce = $sce;
                }
                DashboardGetStartedComponent.prototype.getEmbedUrl = function () {
                    return this.$sce.trustAsResourceUrl("https://www.youtube-nocookie.com/embed/" + this.videoId + "?rel=0&amp;showinfo=0");
                };
                DashboardGetStartedComponent.prototype.isPlayingVideo = function (videoId) {
                    return this.videoId === videoId;
                };
                DashboardGetStartedComponent.prototype.playVideo = function (videoId) {
                    this.videoId = videoId;
                };
                DashboardGetStartedComponent = __decorate([
                    Component('components.dashboard', {
                        templateUrl: 'dashboard-get-started-component-template',
                        bindings: {}
                    })
                ], DashboardGetStartedComponent);
                return DashboardGetStartedComponent;
            }());
        })(Components = Dashboard.Components || (Dashboard.Components = {}));
    })(Dashboard = TotalCore.Dashboard || (TotalCore.Dashboard = {}));
})(TotalCore || (TotalCore = {}));
