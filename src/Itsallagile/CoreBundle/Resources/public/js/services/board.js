itsallagile.application
    .factory('Board', ['$resource', function(resource){
        return resource('/api/boards/:boardId');
    }]);