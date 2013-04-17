function TeamAddCtrl($scope, $location, Team) {
    $scope.team = new Team();

    $scope.save = function(team) {
        team.$save(function(newTeam) {
            $location.path('/');
        });
    };
}