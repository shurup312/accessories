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
          break;
        case "checkbox":
          template = elements.checkbox(scope.param);
          break;
        case "select":
          template = elements.select(scope.param);
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
