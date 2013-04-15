itsallagile.application = angular.module('itsallagile', []);


itsallagile.application.config(['$routeProvider', function($routeProvider) {

    var basePath = '/bundles/itsallagilecore/js/';
    $routeProvider.
        when('/dashboard', {templateUrl: basePath + 'partials/dashboard.html',   controller: DashboardCtrl}).
        otherwise({redirectTo: '/dashboard'});
}]);