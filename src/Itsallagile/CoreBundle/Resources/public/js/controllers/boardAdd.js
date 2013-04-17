function BoardAddCtrl($scope, Team, Board) {
    $scope.teams = Team.query();
    $scope.board = new Board();

    $scope.save = function(board) {
        board.$save(function(newBoard) {
            window.location = '/scrumboard/' + newBoard.slug;
        });
    };
}