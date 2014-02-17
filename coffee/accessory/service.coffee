angular.module('AccessoryDataService',['ngResource']).
  factory('AccessoryList',($resource)->
    return $resource('/accessory/data/list',{},
      get:
        method: 'GET'
        params:
          action:'get'
        isArray:true
    )
  ).
  factory('AccessoryDetail',($resource)->
    return $resource('/accessory/data/detail',{},
      get:
        method:'GET'
        params:
          action:'get'
        isArray:true
    )
  ).
  factory('AccessoryEdit',($resource)->
    return $resource('/accessory/data/edit',{},
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
  factory('AccessoryAdd',($resource)->
    return $resource('/accessory/data/new',{},
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
  ).factory('AccessoryDelete',($resource)->
    return $resource('/accessory/data/delete',{},
      delete:
        method:'GET'
        params:
          action:'delete'
        isArray:true
    )
  ).
  factory('AccessoryHierarchy',($resource)->
      return $resource('/accessory/data/hierarchy',{},
        get:
          method:'GET'
          params:
            action:'get'
          isArray:true

      )
  ).
  factory('AccessoryBreadcrumbs',($resource)->
      return $resource('/accessory/data/breadcrumbs',{},
        get:
          method:'GET'
          params:
            action:'get'
          isArray:true

      )
  )