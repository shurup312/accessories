angular.module("accessoryAll", ['AccessoryDataFilter', 'AccessoryDataService', 'ngCookies']).config([
  "$routeProvider", function($routeProvider) {
    return $routeProvider.when("/accessory", {
      templateUrl: "/accessory/template/list",
      controller: AccessoryListCtrl
    }).when("/accessory/:id", {
      templateUrl: "/accessory/template/list",
      controller: AccessoryListCtrl
    }).when("/accessory/detail/:id", {
      templateUrl: "/accessory/template/detail",
      cotroller: AccessoryDetailCtrl
    }).when("/accessory/new/:pareId/:typeId", {
      templateUrl: "/accessory/template/new",
      cotroller: AccessoryNewCtrl
    }).when("/accessory/edit/:id", {
      templateUrl: "/accessory/template/edit",
      cotroller: AccessoryEditCtrl
    }).otherwise({
      redirectTo: "/accessory"
    });
  }
]).directive('visualElement', function($compile) {
  return {
    link: function(scope, element, attr) {
      var el, template;
      template = '';
      switch (scope.param.field_type) {
        case "readonly":
          template = element.html(elements.readonly(scope.param));
          break;
        case "small-text":
          template = elements.input(scope.param);
          break;
        case "text":
          template = elements.textarea(scope.param);
          break;
        case "file":
          template = elements.file(scope.param);
      }
      if (scope.param.field_type !== 'readonly') {
        el = angular.element(template);
        $compile(el)(scope);
        return element.append(el);
      }
    }
  };
}).directive('listLink', function() {
  return {
    link: function(scope, element, attr) {
      var m;
      m = scope.element;
      if (m.child_type > 0) {
        return element.html("<a href='#/accessory/" + m.id + "'>" + m.name + "</a> (" + m.type_name + ")");
      } else {
        return element.html("<a href='#/accessory/detail/" + m.id + "'>" + m.name + "</a> (" + m.type_name + ")");
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
          return element.html('<a href="#/accessory/' + bc.id + '">' + bc.name + '</a> / ');
        }
      }
    }
  };
});
