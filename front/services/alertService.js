/**
 * Created by andrey on 14.10.16.
 */
angular.module("iwg.lib.alert", [])
.factory('alertService', [function(){
    var alertMessage = null;
    return {
        msg: alertMessage
    };
}]);