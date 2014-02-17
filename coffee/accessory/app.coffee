# здесь задаем для каждого адреса свои контроллеры и angular-адрес
# устанавливаем так же зависимый контроллер фиьтра, чтобы фильтр работал в пределах модуля modulecat
angular.module("accessoryAll", ['AccessoryDataFilter','AccessoryDataService','ngCookies']).config(["$routeProvider", ($routeProvider) ->
  $routeProvider.when("/accessory",
    templateUrl: "/accessory/template/list"
    controller: AccessoryListCtrl
  ).when("/accessory/:id",
    templateUrl: "/accessory/template/list"
    controller: AccessoryListCtrl
  ).when("/accessory/detail/:id",
    templateUrl: "/accessory/template/detail"
    cotroller: AccessoryDetailCtrl
  ).when("/accessory/new/:pareId/:typeId",
    templateUrl: "/accessory/template/new"
    cotroller: AccessoryNewCtrl
  ).when("/accessory/edit/:id",
    templateUrl: "/accessory/template/edit"
    cotroller: AccessoryEditCtrl
  ).otherwise
    redirectTo: "/accessory"
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
    then element.html "<a href='#/accessory/"+m.id+"'>"+m.name+"</a> ("+ m.type_name+")"
    else element.html "<a href='#/accessory/detail/"+m.id+"'>"+m.name+"</a> ("+ m.type_name+")"
).directive('breadcrumbsElement',->
  link:  (scope,element, attr)->
    if scope.breadcrumbs
      len = scope.breadcrumbs.length
      bc = scope.bc
      if bc==scope.breadcrumbs[len-1]
        element.html bc.name
      else
        element.html '<a href="#/accessory/'+bc.id+'">'+bc.name+'</a> / '
)