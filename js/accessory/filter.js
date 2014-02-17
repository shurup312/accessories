angular.module('AccessoryDataFilter', []).filter('isempty', function() {
  return function(input) {
    if (input != null) {
      return input;
    } else {
      return '--';
    }
  };
});
