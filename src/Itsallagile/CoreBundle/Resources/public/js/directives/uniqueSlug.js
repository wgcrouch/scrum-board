/**
 * A validation directive to ensure that a board contains a unique slug
  */
itsallagile.application.directive('uniqueSlug', ['$http', function (http) {
  return {
    require:'ngModel',
    restrict:'A',
    link:function (scope, el, attrs, ctrl) {
      //using push() here to run it as the last parser, after we are sure that other validators were run
      ctrl.$parsers.push(function (viewValue) {
        if (viewValue) {
          http.get('/api/boards/' + viewValue).success(function(data) {
              ctrl.$setValidity('uniqueSlug', false);
          })
          .error(function(data, status, headers, config) {
            ctrl.$setValidity('uniqueSlug', true);
          });
          return viewValue;
        }
      });
    }
  };
}])