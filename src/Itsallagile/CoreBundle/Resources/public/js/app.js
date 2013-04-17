itsallagile.application = angular.module('itsallagile', []);


itsallagile.application.config(['$routeProvider', function($routeProvider) {

    var basePath = '/bundles/itsallagilecore/js/';
    $routeProvider.
        when('/dashboard', {templateUrl: basePath + 'partials/dashboard.html',   controller: DashboardCtrl}).
        when('/new-board', {templateUrl: basePath + 'partials/addBoard.html',   controller: BoardAddCtrl}).
        otherwise({redirectTo: '/dashboard'});
}]);