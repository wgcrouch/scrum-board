itsallagile.application = angular.module('itsallagile', ['ngResource']);


itsallagile.application.config(['$routeProvider', function($routeProvider) {

    var basePath = '/bundles/itsallagilecore/js/';
    $routeProvider.
        when('/dashboard', {templateUrl: basePath + 'partials/dashboard.html',   controller: DashboardCtrl}).
        when('/new-board', {templateUrl: basePath + 'partials/addBoard.html',   controller: BoardAddCtrl}).
        when('/new-team', {templateUrl: basePath + 'partials/addTeam.html',   controller: TeamAddCtrl}).
        when('/board/:slug', {templateUrl: basePath + 'partials/scrumboard.html',   controller: ScrumBoardCtrl}).
        otherwise({redirectTo: '/dashboard'});
}]);