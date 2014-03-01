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
directive('visualElement',($compile)->
  link:(scope, element, attr)->
    template = ''
    switch scope.param.field_type
      when "readonly" then template = element.html elements.readonly scope.param
      when "small-text" then template = elements.input scope.param
      when "text" then template = elements.textarea scope.param
      when "file" then template = elements.file scope.param

    if scope.param.field_type!='readonly'
      el = angular.element template
      $compile(el)(scope)
      element.append(el);

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