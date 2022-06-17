///<reference path="../../../../../build/typings/index.d.ts" />
///<reference path="../../../../../vendor/misqtech/totalsuite-totalcore/assets/scripts/common/decorators.ts" />
///<reference path="../../../../../vendor/misqtech/totalsuite-totalcore/assets/scripts/common/helpers.ts" />
///<reference path="../../../../../vendor/misqtech/totalsuite-totalcore/assets/scripts/common/configs/Global.ts" />
///<reference path="../../../../../vendor/misqtech/totalsuite-totalcore/assets/scripts/common/configs/Http.ts" />

///<reference path="providers/repository.ts"/>
///<reference path="controllers/troubleshooter.ts" />

module TotalPoll {
    import GlobalConfig = TotalCore.Common.Configs.GlobalConfig;
    import HttpConfig = TotalCore.Common.Configs.HttpConfig;

    export const dashboard = angular
        .module('troubleshooter', [
            'ngResource',
            'services.totalpoll',
            'controllers.totalpoll',
        ])
        .config(GlobalConfig)
        .config(HttpConfig)
        .value('ajaxEndpoint', window['ajaxurl'] || '/wp-admin/admin-ajax.php')
        .value('namespace', 'TotalPoll')
        .value('prefix', 'totalpoll')
}