///<reference path="../../common/decorators.ts"/>
///<reference path="../../common/configs/Global.ts" />
///<reference path="../../common/configs/Http.ts" />
namespace TotalCore.Common.Directives {

    @Directive('directives.common', 'track')
    export class ClickTracker {

        constructor($resource, prefix, ajaxEndpoint) {
            const resource = $resource(ajaxEndpoint, {}, {
                track: {method: 'POST', params: {action: `${prefix}_tracking_features`}},
            });

            return {
                restrict: 'A',
                link: ($scope, element: any, attributes: any) => {
                    let data  = $scope.$eval(attributes.track);
                    element.on('click', () => {
                        resource.track(data);
                    });
                }
            }
        }
    }
}