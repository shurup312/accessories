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
  directive('visualElement',($compile)->
    link:(scope, element, attr)->
      template = ''
      switch scope.param.field_type
        when "readonly" then template = element.html elements.readonly scope.param
        when "small-text" then template = elements.input scope.param
        when "text" then template = elements.textarea scope.param
        when "file" then template = elements.file scope.param
        when "checkbox" then template = elements.checkbox scope.param
        when "select" then template = elements.select scope.param

      if scope.param.field_type!='readonly'
        el = angular.element template
        $compile(el)(scope)
        element.append(el);
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