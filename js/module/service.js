angular.module('ModuleDataService', ['ngResource']).factory('ModuleList', function($resource) {
  return $resource('/module/data/list', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    }
  });
}).factory('ModuleDetail', function($resource) {
  return $resource('/module/data/detail', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    }
  });
}).factory('ModuleEdit', function($resource) {
  return $resource('/module/data/edit', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    },
    save: {
      method: 'GET',
      params: {
        action: 'save'
      },
      isArray: true
    }
  });
}).factory('ModuleAdd', function($resource) {
  return $resource('/module/data/new', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    },
    save: {
      method: 'GET',
      params: {
        action: 'save'
      },
      isArray: true
    }
  });
}).factory('ModuleDelete', function($resource) {
  return $resource('/module/data/delete', {}, {
    "delete": {
      method: 'GET',
      params: {
        action: 'delete'
      },
      isArray: true
    }
  });
}).factory('ModuleHierarchy', function($resource) {
  return $resource('/module/data/hierarchy', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    }
  });
}).factory('ModuleBreadcrumbs', function($resource) {
  return $resource('/module/data/breadcrumbs', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    }
  });
});
