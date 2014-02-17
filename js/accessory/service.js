angular.module('AccessoryDataService', ['ngResource']).factory('AccessoryList', function($resource) {
  return $resource('/accessory/data/list', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    }
  });
}).factory('AccessoryDetail', function($resource) {
  return $resource('/accessory/data/detail', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    }
  });
}).factory('AccessoryEdit', function($resource) {
  return $resource('/accessory/data/edit', {}, {
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
}).factory('AccessoryAdd', function($resource) {
  return $resource('/accessory/data/new', {}, {
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
}).factory('AccessoryDelete', function($resource) {
  return $resource('/accessory/data/delete', {}, {
    "delete": {
      method: 'GET',
      params: {
        action: 'delete'
      },
      isArray: true
    }
  });
}).factory('AccessoryHierarchy', function($resource) {
  return $resource('/accessory/data/hierarchy', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    }
  });
}).factory('AccessoryBreadcrumbs', function($resource) {
  return $resource('/accessory/data/breadcrumbs', {}, {
    get: {
      method: 'GET',
      params: {
        action: 'get'
      },
      isArray: true
    }
  });
});
