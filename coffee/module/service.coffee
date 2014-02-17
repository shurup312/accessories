angular.module('ModuleDataService',['ngResource']).
  factory('ModuleList',($resource)->
    return $resource('/module/data/list',{},
      get:
        method: 'GET'
        params:
          action:'get'
        isArray:true
    )
  ).
  factory('ModuleDetail',($resource)->
    return $resource('/module/data/detail',{},
      get:
        method:'GET'
        params:
          action:'get'
        isArray:true
    )
  ).
  factory('ModuleEdit',($resource)->
    return $resource('/module/data/edit',{},
      get:
        method:'GET'
        params:
          action:'get'
        isArray:true
      save:
        method:'GET'
        params:
          action:'save'
        isArray:true
    )
  ).
  factory('ModuleAdd',($resource)->
    return $resource('/module/data/new',{},
      get:
        method:'GET'
        params:
          action:'get'
        isArray:true
      save:
        method:'GET'
        params:
          action:'save'
        isArray:true
    )
  ).factory('ModuleDelete',($resource)->
    return $resource('/module/data/delete',{},
      delete:
        method:'GET'
        params:
          action:'delete'
        isArray:true
    )
  ).
  factory('ModuleHierarchy',($resource)->
      return $resource('/module/data/hierarchy',{},
        get:
          method:'GET'
          params:
            action:'get'
          isArray:true

      )
  ).
  factory('ModuleBreadcrumbs',($resource)->
      return $resource('/module/data/breadcrumbs',{},
        get:
          method:'GET'
          params:
            action:'get'
          isArray:true

      )
  )