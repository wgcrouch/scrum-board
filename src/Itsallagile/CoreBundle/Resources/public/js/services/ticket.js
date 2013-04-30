itsallagile.application
    .factory('Ticket', ['$resource', function(resource) {
        return resource(
            '/api/boards/:boardId/stories/:storyId/tickets/:ticketId',
            {boardId: '@boardId', storyId: '@storyId', ticketId: '@id'}
        );
    }]);