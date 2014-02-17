# здесь задаем для каждого адреса свои контроллеры и angular-адрес
# устанавливаем так же зависимый контроллер фиьтра, чтобы фильтр работал в пределах модуля modulecat
angular.module("moduleAll", ['dataFilter','ModuleDataService','ngCookies']).config(["$routeProvider", ($routeProvider) ->
  $routeProvider.when("/module",
    templateUrl: "/module/template/list"
    controller: ModuleListCtrl
  ).when("/module/:id",
    templateUrl: "/module/template/list"
    controller: ModuleListCtrl
  ).when("/module/detail/:id",
    templateUrl: "/module/template/detail"
    cotroller: ModuleDetailCtrl
  ).when("/module/new/:pareId/:typeId",
    templateUrl: "/module/template/new"
    cotroller: ModuleNewCtrl
  ).when("/module/edit/:id",
    templateUrl: "/module/template/edit"
    cotroller: ModuleEditCtrl
  ).otherwise
    redirectTo: "/module"
]).
  directive('visualElement',->
    link: (scope, element, attr)->
      switch scope.param.field_type
        when "readonly" then element.html elements.readonly scope.param
        when "small-text" then element.html elements.input scope.param
        when "text" then element.html elements.textarea scope.param

).directive('listLink',->
  link:  (scope,element, attr)->
    m = scope.element
    if m.child_type>0
    then element.html "<a href='#/module/"+m.id+"'>"+m.name+"</a> ("+ m.type_name+")"
    else element.html "<a href='#/module/detail/"+m.id+"'>"+m.name+"</a> ("+ m.type_name+")"
).directive('breadcrumbsElement',->
  link:  (scope,element, attr)->
    if scope.breadcrumbs
      len = scope.breadcrumbs.length
      bc = scope.bc
      if bc==scope.breadcrumbs[len-1]
        element.html bc.name
      else
        element.html '<a href="#/module/'+bc.id+'">'+bc.name+'</a> / '
)