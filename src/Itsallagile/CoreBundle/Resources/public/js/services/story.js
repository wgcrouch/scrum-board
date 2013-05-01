itsallagile.application
    .factory('Story', ['$resource', function(resource){
        return resource(
            '/api/boards/:boardId/stories/:storyId',
            {boardId: '@boardId', storyId: '@id', points:0}
        );
    }]);