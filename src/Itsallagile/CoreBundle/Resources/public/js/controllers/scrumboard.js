function ScrumBoardCtrl($scope, $routeParams, Board, Story, Ticket) {
    $scope.stories = [];
    $scope.board = Board.get({slug: $routeParams.slug}, function(board) {
        //Make new resources for the sub resources
        for (var storyId in board.stories) {
            var story = new Story(board.stories[storyId]);
            story.boardId = board.id;
            board.stories[storyId] = new Story(story);
            for (var ticketId in story.tickets) {
                var ticket = new Ticket(story.tickets[ticketId]);
                ticket.storyId = storyId;
                ticket.boardId = board.id;
                story.tickets[ticketId] = ticket;
            }
        }
    });

    $scope.ticketStatuses = [{"id":"new","status":"New"},{"id":"assigned","status":"Assigned"},{"id":"done","status":"Done"}];
}