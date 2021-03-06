/regular=[0-10]$\s+/;
var ModuleDetailCtrl, ModuleEditCtrl, ModuleListCtrl, ModuleNewCtrl;

ModuleNewCtrl = function($scope, $routeParams, ModuleAdd, ModuleBreadcrumbs, $timeout, $compile, $location) {
  $scope.fields = {};
  $scope.files = [];
  ModuleAdd.get({
    id: $routeParams.pareId,
    type_id: $routeParams.typeId
  }, function(ok) {
    var i, tab, _i, _len, _results;
    $scope.data = ok;
    _results = [];
    for (_i = 0, _len = ok.length; _i < _len; _i++) {
      tab = ok[_i];
      _results.push((function() {
        var _j, _len1, _ref, _results1;
        _ref = tab.params;
        _results1 = [];
        for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
          i = _ref[_j];
          $scope.fields[i.field] = i;
          console.log($scope.fields);
          if (i.field_type === 'file') {
            $scope.files.push(i.field);
            if (typeof $scope.fields[i.field].value !== 'undefined' && $scope.fields[i.field].value !== '') {
              _results1.push($timeout(function() {
                return $scope.setImage(i.field, $scope.fields[i.field].value);
              }, 0));
            } else {
              _results1.push(void 0);
            }
          } else {
            _results1.push(void 0);
          }
        }
        return _results1;
      })());
    }
    return _results;
  }, function(error) {
    $scope.errorMessage = error.data;
    return $timeout(function() {
      return $scope.errorMessage = '';
    }, 10000);
  });
  ModuleBreadcrumbs.get({
    id: $routeParams.pareId
  }, function(ok) {
    $scope.breadcrumbs = ok;
    return $scope.breadcrumbs[ok.length] = {
      'name': 'Создать новый'
    };
  }, function(error) {
    $scope.errorMessage = error.data;
    return $timeout(function() {
      return $scope.errorMessage = '';
    }, 10000);
  });
  $scope.create = function() {
    var data, i;
    data = {};
    for (i in $scope.fields) {
      data[$scope.fields[i].field] = $scope.fields[i].value;
    }
    data = $.toJSON(data);
    return ModuleAdd.save({
      data: data,
      type_id: $routeParams.typeId,
      parent_id: $routeParams.pareId
    }, function(ok) {
      $scope.okMessage = ok[0]['message'] + '. Вы будете перенаправлены на список записей.';
      return $timeout(function() {
        $scope.okMessage = '';
        return $location.path('/module/' + $routeParams.pareId);
      }, 3000);
    }, function(error) {
      $scope.errorMessage = error.data;
      return $timeout(function() {
        return $scope.errorMessage = '';
      }, 10000);
    });
  };
  window.setInterval(function() {
    var id, interval, _i, _len, _ref, _results;
    _ref = $scope.files;
    _results = [];
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      id = _ref[_i];
      if ($('#' + id + '_input').val() !== '') {
        $('#' + id + '_form').submit();
        $scope.files = [];
        _results.push(interval = window.setInterval(function() {
          var answer;
          answer = $('#' + id + '_frame').contents().find('body').html();
          if (answer) {
            window.clearInterval(interval);
            answer = JSON.parse(answer);
            if (answer.ok === 0) {
              alert('Ошибка: ' + answer.message);
            }
            if (answer.ok === 1) {
              return $scope.setImage(id, answer.message);
            }
          }
        }, 200));
      } else {
        _results.push(void 0);
      }
    }
    return _results;
  }, 1000);
  $scope.clear = function(id) {
    $scope.fields[id].value = '';
    $('#' + id + '_input').val('');
    $('#' + id + '_form').show();
    return $('#' + id + '_setimage').html('');
  };
  return $scope.setImage = function(id, imgsrc) {
    var a, div, img;
    img = $('<img/>', {
      src: '/images/upload/module/tmp/' + imgsrc
    }).css('margin', '0 0 10px');
    a = $('<a></a>', {
      'href': 'javascript:void(0)',
      'ng-click': 'clear("' + id + '")'
    }).html('Удалить');
    div = angular.element(img.wrap('<div></div>').parent());
    a = angular.element(a);
    $compile(div)($scope);
    $compile(a)($scope);
    $('#' + id + '_setimage').append(div).append(a);
    $('#' + id + '_form').hide();
    $scope.fields[id].value = imgsrc;
    return $('#' + id + '_input').val('');
  };
};

ModuleEditCtrl = function($scope, $routeParams, ModuleEdit, ModuleBreadcrumbs, $timeout, $compile) {
  $scope.fields = {};
  $scope.files = [];
  ModuleEdit.get({
    id: $routeParams.id
  }, function(ok) {
    var i, tab, _i, _len, _results;
    $scope.data = ok;
    _results = [];
    for (_i = 0, _len = ok.length; _i < _len; _i++) {
      tab = ok[_i];
      _results.push((function() {
        var _j, _len1, _ref, _results1;
        _ref = tab.params;
        _results1 = [];
        for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
          i = _ref[_j];
          $scope.fields[i.field] = i;
          if (i.field_type === 'file') {
            $scope.files.push(i.field);
            if ($scope.fields[i.field].value !== '') {
              _results1.push($timeout(function() {
                return $scope.setImage(i.field, $scope.fields[i.field].value);
              }, 0));
            } else {
              _results1.push(void 0);
            }
          } else {
            _results1.push(void 0);
          }
        }
        return _results1;
      })());
    }
    return _results;
  }, function(error) {
    $scope.errorMessage = error.data;
    return $timeout(function() {
      return $scope.errorMessage = '';
    }, 10000);
  });
  $scope.save = function() {
    var data, i;
    data = {};
    for (i in $scope.fields) {
      data[$scope.fields[i].field] = $scope.fields[i].value;
    }
    data = $.toJSON(data);
    return ModuleEdit.save({
      id: $routeParams.id,
      data: data
    }, function(ok) {
      $scope.okMessage = ok[0]['message'];
      return $timeout(function() {
        return $scope.okMessage = '';
      }, 10000);
    }, function(error) {
      $scope.errorMessage = error.data;
      return $timeout(function() {
        return $scope.errorMessage = '';
      }, 10000);
    });
  };
  ModuleBreadcrumbs.get({
    id: $routeParams.id
  }, function(ok) {
    $scope.breadcrumbs = ok;
    return $scope.breadcrumbs[$scope.breadcrumbs.length - 1].name += ' (редактирование)';
  }, function(error) {
    $scope.errorMessage = error.data;
    return $timeout(function() {
      return $scope.errorMessage = '';
    }, 10000);
  });
  window.setInterval(function() {
    var id, interval, _i, _len, _ref, _results;
    _ref = $scope.files;
    _results = [];
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      id = _ref[_i];
      if ($('#' + id + '_input').val() !== '') {
        $('#' + id + '_form').submit();
        $scope.files = [];
        _results.push(interval = window.setInterval(function() {
          var answer;
          answer = $('#' + id + '_frame').contents().find('body').html();
          if (answer) {
            window.clearInterval(interval);
            answer = JSON.parse(answer);
            if (answer.ok === 0) {
              alert('Ошибка: ' + answer.message);
            }
            if (answer.ok === 1) {
              return $scope.setImage(id, answer.message);
            }
          }
        }, 200));
      } else {
        _results.push(void 0);
      }
    }
    return _results;
  }, 1000);
  $scope.clear = function(id) {
    $scope.fields[id].value = '';
    $('#' + id + '_input').val('');
    $('#' + id + '_form').show();
    return $('#' + id + '_setimage').html('');
  };
  return $scope.setImage = function(id, imgsrc) {
    var a, div, img;
    img = $('<img/>', {
      src: '/images/upload/module/tmp/' + imgsrc
    }).css('margin', '0 0 10px');
    a = $('<a></a>', {
      'href': 'javascript:void(0)',
      'ng-click': 'clear("' + id + '")'
    }).html('Удалить');
    div = angular.element(img.wrap('<div></div>').parent());
    a = angular.element(a);
    $compile(div)($scope);
    $compile(a)($scope);
    $('#' + id + '_setimage').append(div).append(a);
    $('#' + id + '_form').hide();
    $scope.fields[id].value = imgsrc;
    return $('#' + id + '_input').val('');
  };
};

ModuleListCtrl = function($scope, $http, $routeParams, ModuleList, ModuleHierarchy, ModuleBreadcrumbs, ModuleDelete, $window, $timeout, $cookieStore) {
  var id, _ref;
  $scope.id = 0;
  $scope.checkBoxes = [];
  $scope.page = 1;
  $scope.onPage = $cookieStore.get('onPage');
  if ($scope.onPage == null) {
    $scope.onPage = 10;
  }
  $scope.elementsInTable = [];
  $scope.allData = [];
  $scope.pages = [];
  $scope.isPagination = false;
  $scope.query = '';
  $scope.orderProp = '';
  $scope.checkAllBox = {};
  $scope.checkAllBox.check = false;
  $scope.checkAllBox.visible = false;
  $scope.massDelete = false;
  id = (_ref = $routeParams.id) != null ? _ref : 0;
  $scope.id = id;
  $scope.setValue = function(param, value) {
    return $scope[param] = value;
  };
  ModuleHierarchy.get({
    id: $scope.id
  }, function(data) {
    return $scope.addItem = data;
  }, function(error) {
    $scope.errorMessage = error.data;
    return $timeout(function() {
      return $scope.errorMessage = '';
    }, 10000);
  });
  $scope.getData = function() {
    $scope.checkAllBox.check = false;
    return ModuleList.get({
      id: $scope.id
    }, function(data) {
      $scope.header = data.slice(0, 1);
      $scope.allData = data.slice(1);
      $scope.setData();
      return $timeout(function() {
        $('.list-pagination-button').removeClass('list-paginate-active');
        return $(".list-pagination-button" + $scope.page).addClass('list-paginate-active', 200);
      });
    }, function(error) {
      $scope.errorMessage = error.data;
      return $timeout(function() {
        return $scope.errorMessage = '';
      }, 10000);
    });
  };
  $scope.getData();
  $scope.setPage = function(p) {
    $scope.page = p;
    $('.list-pagination-button').removeClass('list-paginate-active');
    $(".list-pagination-button" + $scope.page).addClass('list-paginate-active');
    return $scope.setData();
  };
  $scope.setData = function() {
    var f, i, j, t, variable, _base, _i, _len, _ref1;
    for (j in $scope.allData) {
      $scope.checkBoxes[$scope.allData[j].id] = {
        check: false
      };
    }
    f = ($scope.page - 1) * $scope.onPage;
    t = $scope.page * $scope.onPage - 1;
    $scope.elementsInTable = $scope.allData.slice(f, +t + 1 || 9e9);
    _ref1 = $scope.elementsInTable;
    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
      i = _ref1[_i];
      (_base = $scope.checkAllBox).visible || (_base.visible = i.can_delete);
    }
    $scope.pages = [];
    i = 0;
    variable = Math.ceil($scope.allData.length / $scope.onPage);
    while (i < variable) {
      i++;
      $scope.pages.push(i);
    }
    $scope.isPagination = false;
    if (i > 1) {
      return $scope.isPagination = true;
    }
  };
  $scope.$watch('onPage', function() {
    $scope.setData();
    $cookieStore.put('onPage', $scope.onPage);
    $('.list-pagination-button').removeClass('list-paginate-active');
    $(".list-pagination-button1").addClass('list-paginate-active');
    return $scope.page = 1;
  });
  ModuleBreadcrumbs.get({
    id: $scope.id
  }, function(ok) {
    return $scope.breadcrumbs = ok;
  }, function(error) {
    $scope.errorMessage = error.data;
    return $timeout(function() {
      return $scope.errorMessage = '';
    }, 10000);
  });
  $scope.checkAll = function() {
    var i, _i, _len, _ref1;
    $scope.checkAllBox.check = !$scope.checkAllBox.check;
    _ref1 = $scope.elementsInTable;
    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
      i = _ref1[_i];
      if (i.can_delete === '1') {
        $scope.checkBoxes[i.id] = {
          check: $scope.checkAllBox.check
        };
      }
    }
    return $scope.showMassActions();
  };
  $scope.checkElement = function(id) {
    $scope.checkBoxes[id].check = !$scope.checkBoxes[id].check;
    return $scope.showMassActions();
  };
  $scope.showMassActions = function() {
    var i, _i, _len, _ref1, _results;
    $scope.massDelete = true;
    _ref1 = $scope.elementsInTable;
    _results = [];
    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
      i = _ref1[_i];
      _results.push($scope.massDelete = $scope.massDelete || $scope.checkBoxes[i.id].check);
    }
    return _results;
  };
  $scope.goMassDelete = function() {
    var element, elements, errorCount, i, okCount, _i, _j, _len, _len1, _ref1, _results;
    elements = [];
    okCount = 0;
    errorCount = 0;
    _ref1 = $scope.elementsInTable;
    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
      i = _ref1[_i];
      if ($scope.checkBoxes[i.id].check) {
        elements.push(i.id);
      }
    }
    _results = [];
    for (_j = 0, _len1 = elements.length; _j < _len1; _j++) {
      element = elements[_j];
      _results.push(ModuleDelete["delete"]({
        id: element
      }, function(ok) {
        okCount++;
        $scope.okMessage = "" + okCount + " из " + elements.length + " - " + ok[0]['message'];
        if ($scope.okMessage == null) {
          $timeout(function() {
            return $scope.okMessage = '';
          }, 10000);
        }
        if (elements.length === okCount + errorCount) {
          return $scope.getData();
        }
      }, function(error) {
        errorCount++;
        $scope.errorMessage = "" + errorCount + " из " + elements.length + " - " + error.data;
        if ($scope.errorMessage == null) {
          $timeout(function() {
            return $scope.errorMessage = '';
          }, 10000);
        }
        if (elements.length === okCount + errorCount) {
          return $scope.getData();
        }
      }));
    }
    return _results;
  };
  return $scope["delete"] = function(id) {
    if (confirm('Вы дейстивительно хотите удалить?')) {
      return ModuleDelete["delete"]({
        id: id
      }, function(ok) {
        var deleteElement, i;
        i = 0;
        deleteElement = false;
        while (i < $scope.allData.length || !deleteElement) {
          if ($scope.allData[i].id === id) {
            $scope.allData.splice(i, 1);
            deleteElement = true;
          }
          i++;
        }
        $scope.setData();
        $scope.okMessage = ok[0]['message'];
        return $timeout(function() {
          return $scope.okMessage = '';
        }, 10000);
      }, function(error) {
        $scope.errorMessage = error.data;
        return $timeout(function() {
          return $scope.errorMessage = '';
        }, 10000);
      });
    }
  };
};

ModuleDetailCtrl = function($scope, $routeParams, $http, ModuleDetail, ModuleBreadcrumbs, $timeout) {
  $scope.details = ModuleDetail.get({
    id: $routeParams.id
  }, function() {}, function(error) {
    $scope.errorMessage = error.data;
    return $timeout(function() {
      return $scope.errorMessage = '';
    }, 10000);
  });
  return ModuleBreadcrumbs.get({
    id: $routeParams.id
  }, function(ok) {
    return $scope.breadcrumbs = ok;
  }, function(error) {
    $scope.errorMessage = error.data;
    return $timeout(function() {
      return $scope.errorMessage = '';
    }, 10000);
  });
};
