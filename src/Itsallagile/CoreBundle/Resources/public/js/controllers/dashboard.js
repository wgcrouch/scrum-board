function DashboardCtrl($scope, Team, Board) {
    $scope.teams = Team.query();
    $scope.boards = Board.query();

    $scope.currentUser = itsallagile.currentUser;
}