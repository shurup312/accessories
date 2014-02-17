angular.module("moduleAll", ['dataFilter', 'ModuleDataService', 'ngCookies']).config([
  "$routeProvider", function($routeProvider) {
    return $routeProvider.when("/module", {
      templateUrl: "/module/template/list",
      controller: ModuleListCtrl
    }).when("/module/:id", {
      templateUrl: "/module/template/list",
      controller: ModuleListCtrl
    }).when("/module/detail/:id", {
      templateUrl: "/module/template/detail",
      cotroller: ModuleDetailCtrl
    }).when("/module/new/:pareId/:typeId", {
      templateUrl: "/module/template/new",
      cotroller: ModuleNewCtrl
    }).when("/module/edit/:id", {
      templateUrl: "/module/template/edit",
      cotroller: ModuleEditCtrl
    }).otherwise({
      redirectTo: "/module"
    });
  }
]).directive('visualElement', function() {
  return {
    link: function(scope, element, attr) {
      switch (scope.param.field_type) {
        case "readonly":
          return element.html(elements.readonly(scope.param));
        case "small-text":
          return element.html(elements.input(scope.param));
        case "text":
          return element.html(elements.textarea(scope.param));
      }
    }
  };
}).directive('listLink', function() {
  return {
    link: function(scope, element, attr) {
      var m;
      m = scope.element;
      if (m.child_type > 0) {
        return element.html("<a href='#/module/" + m.id + "'>" + m.name + "</a> (" + m.type_name + ")");
      } else {
        return element.html("<a href='#/module/detail/" + m.id + "'>" + m.name + "</a> (" + m.type_name + ")");
      }
    }
  };
}).directive('breadcrumbsElement', function() {
  return {
    link: function(scope, element, attr) {
      var bc, len;
      if (scope.breadcrumbs) {
        len = scope.breadcrumbs.length;
        bc = scope.bc;
        if (bc === scope.breadcrumbs[len - 1]) {
          return element.html(bc.name);
        } else {
          return element.html('<a href="#/module/' + bc.id + '">' + bc.name + '</a> / ');
        }
      }
    }
  };
});
