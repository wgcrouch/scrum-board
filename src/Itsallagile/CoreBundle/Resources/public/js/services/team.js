itsallagile.application
    .factory('Team', ['$resource', function(resource){
        return resource('/api/teams/:teamId');
    }]);