// Generated by CoffeeScript 1.6.3
(function() {
  angular.module('AccessoryDataFilter', []).filter('isempty', function() {
    return function(input) {
      if (input != null) {
        return input;
      } else {
        return '--';
      }
    };
  });

}).call(this);

/*
//@ sourceMappingURL=filter.map
*/
