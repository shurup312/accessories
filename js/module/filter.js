angular.module('dataFilter', []).filter('isempty', function() {
  return function(input) {
    if (input != null) {
      return input;
    } else {
      return '--';
    }
  };
});
