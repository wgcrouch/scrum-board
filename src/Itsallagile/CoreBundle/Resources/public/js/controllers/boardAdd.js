function BoardAddCtrl($scope, $http) {
    $http.get('/api/teams').success(function(data) {
        $scope.teams = data;
    });
    $scope.board = {};
    $scope.master = {};

    $scope.save = function(board) {
        $http.post('/api/boards', $scope.board).success(function(newBoard) {
            window.location = '/scrumboard/' + newBoard.slug;
        });
    };
}