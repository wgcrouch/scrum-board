function DashboardCtrl($scope, $http) {
    $http.get('/api/teams').success(function(data) {
        $scope.teams = data;
    });

    $http.get('/api/boards').success(function(data) {
        $scope.boards = data;
    });
    $scope.currentUser = itsallagile.currentUser;
}