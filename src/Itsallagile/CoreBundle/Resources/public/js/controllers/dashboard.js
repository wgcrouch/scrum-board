function DashboardCtrl($scope, Team, Board) {
    $scope.teams = Team.query();
    $scope.boards = Board.query();

    $scope.currentUser = itsallagile.currentUser;
    $scope.teamQuery = '';
    
    $scope.teamFilter = function(item) {
        if (!$scope.teamQuery)  {
            return true;
        }
        if (item.team.id == $scope.teamQuery) {            
            return true;
        }
        return false;
    }
}