/**
 * A validation directive to ensure that a board contains a unique slug
 */
 itsallagile.application.directive('uniqueSlug', ['Board', function (board) {
    return {
        require:'ngModel',
        restrict:'A',
        link:function (scope, el, attrs, ctrl) {
            //using push() here to run it as the last parser, after we are sure that other validators were run
            ctrl.$parsers.push(function (viewValue) {
                if (viewValue) {
                    board.get({boardId:viewValue}, 
                        //Success
                        function() {
                            ctrl.$setValidity('uniqueSlug', false);
                        }, 
                        //Error
                        function() {
                            ctrl.$setValidity('uniqueSlug', true);
                        }
                    );
                    return viewValue;
                }
            });
        }
    };
}])