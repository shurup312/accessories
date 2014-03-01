///
regular =
  [0-10]$ # можно оставлять комментарии
  \s+ #прямо посрдени регулярки
///

AccessoryNewCtrl = ($scope,$routeParams, AccessoryAdd, AccessoryBreadcrumbs, $timeout)->
  AccessoryAdd.get
    id:$routeParams.pareId
    type_id:$routeParams.typeId
    (ok)->
      $scope.data = ok
    (error)->
      $scope.errorMessage = error.data
      $timeout(->
        $scope.errorMessage = ''
      ,10000
      )

    AccessoryBreadcrumbs.get
      id:$routeParams.pareId
      (ok)->
        $scope.breadcrumbs = ok
        $scope.breadcrumbs[ok.length] = {'name':'Создать новый'}
      (error)->
        $scope.errorMessage = error.data
        $timeout(->
          $scope.errorMessage = ''
        ,10000
        )



  $scope.create = ->
    data = dataSave.get()
    data = $.toJSON data
    AccessoryAdd.save(
      data:data
      type_id:$routeParams.typeId
      parent_id:$routeParams.pareId
      (ok)->
        $scope.okMessage = ok[0]['message']
        $timeout(->
          $scope.okMessage = ''
        ,10000
        )

      (error)->
        $scope.errorMessage = error.data
        $timeout(->
          $scope.errorMessage = ''
        ,10000
        )
    )

AccessoryEditCtrl = ($scope, $routeParams,AccessoryEdit,AccessoryBreadcrumbs, $timeout,$compile)->
  $scope.fields  = {}
  $scope.files = []

  AccessoryEdit.get
    id:$routeParams.id
    (ok)->
      $scope.data = ok
      for tab in ok
        for i in tab.params
          $scope.fields[i.field] = i
          if i.field_type=='file'
            $scope.files.push i.field
            if($scope.fields[i.field].value!='')
              $timeout(->
                $scope.setImage(i.field,$scope.fields[i.field].value)
              ,0)
    (error)->
      $scope.errorMessage = error.data
      $timeout(->
        $scope.errorMessage = ''
      ,10000
      )

  $scope.save = ->
    data = {}
    for i of $scope.fields
      data[$scope.fields[i].field] = $scope.fields[i].value
    data = $.toJSON(data)
    AccessoryEdit.save(
      id:$routeParams.id
      data:data
      (ok)->
        $scope.okMessage = ok[0]['message']
        $timeout(->
          $scope.okMessage = ''
        ,10000
        )
      (error)->
        $scope.errorMessage = error.data
        $timeout(->
          $scope.errorMessage = ''
        ,10000
        )
    )

  AccessoryBreadcrumbs.get
    id:$routeParams.id
    (ok)->
      $scope.breadcrumbs = ok
      $scope.breadcrumbs[$scope.breadcrumbs.length-1].name+=' (редактирование)'
    (error)->
      $scope.errorMessage = error.data
      $timeout(->
        $scope.errorMessage = ''
      ,10000
      )

  window.setInterval(->
    for id in $scope.files
      if $('#'+id+'_input').val()!=''
        $('#'+id+'_form').submit()
        $scope.files = []

        interval = window.setInterval(->
          answer = $('#'+id+'_frame').contents().find('body').html()
          if(answer)
            window.clearInterval interval
            answer = JSON.parse answer
            if answer.ok==0
              alert 'Ошибка: '+answer.message
            if answer.ok ==1
              $scope.setImage(id, answer.message)
        ,200
        )
  ,1000
  )

  $scope.clear = (id)->
    $scope.fields[id].value = '';
    $('#'+id+'_input').val ''
    $('#'+id+'_form').show()
    $('#'+id+'_setimage').html('')

  $scope.setImage = (id, imgsrc)->
    img = $('<img/>',
      src:'/images/upload/accessory/tmp/'+imgsrc

    ).css('margin','0 0 10px')

    a = $('<a></a>',
      'href':'javascript:void(0)'
      'ng-click':'clear("'+id+'")'
    ).html 'Удалить'
    div  = angular.element img.wrap('<div></div>').parent()
    a  = angular.element a

    $compile(div)($scope)
    $compile(a)($scope)
    $('#'+id+'_setimage').append(div).append a

    $('#'+id+'_form').hide()
    $scope.fields[id].value = imgsrc;
    $('#'+id+'_input').val('')

# контроллер для списка элементов
AccessoryListCtrl = ($scope,$http,$routeParams,AccessoryList,AccessoryHierarchy,AccessoryBreadcrumbs,AccessoryDelete,$window,$timeout,$cookieStore)->
  # ID параметр элемента, в котором находится, для корня проставится  0
  $scope.id = 0
  # список чекбоксов для всех элементов в таблице
  $scope.checkBoxes = []
  # текущая страница
  $scope.page = 1
  # элементов на странице
  $scope.onPage = $cookieStore.get('onPage')
  $scope.onPage ?= 10

  # список элементов для вывода в таблицу
  $scope.elementsInTable = []
  # список всех элеменетов
  $scope.allData = []
  # список страниц, строится на основе данных и onPage параметра
  $scope.pages = []
  # указывает, будет ли пагинация или нет, задается автоматически на основе рассчетов
  $scope.isPagination = false
  # поиск и сортировка - пустые
  $scope.query = ''
  $scope.orderProp = ''
  # галочка "выделить все"
  $scope.checkAllBox = {}
  $scope.checkAllBox.check = false
  $scope.checkAllBox.visible = false

  # показывать ли кнопку массового удаления
  $scope.massDelete = false

  # задаем, что если нет ID параметра в URL, то мы в корне
  id = $routeParams.id ? 0




  $scope.id = id

  $scope.setValue = (param,value)->
    $scope[param] = value

  # вызываем список тех элеменетов, которые можно создавать в текущем элементе
  AccessoryHierarchy.get
    id:$scope.id
    (data)->
      $scope.addItem = data
    (error)->
      $scope.errorMessage = error.data
      $timeout(->
        $scope.errorMessage = ''
      ,10000
      )
  # получает список элеменетов, раскладываем заголовки данных и сами данные в две разные переменные
  # в случае ошибки выводим текст ошибки
  # так же проставляем страницу равной единице, чтобы у нас выстроилась таблица с данными в вотчере,
  # построились страницы

  $scope.getData = ->
    $scope.checkAllBox.check = false
    AccessoryList.get(
      id:$scope.id
      (data)->
        $scope.header = data[..0]
        $scope.allData = data[1..]
        $scope.setData()
        $timeout ->
          $('.list-pagination-button').removeClass 'list-paginate-active'
          $(".list-pagination-button#{$scope.page}").addClass 'list-paginate-active'
          ,200

      (error)->
        $scope.errorMessage = error.data
        $timeout(->
          $scope.errorMessage = ''
        ,10000
        )
    )

  $scope.getData()
  # изменяем текущую страницу при клике на пагинаторе
  $scope.setPage = (p)->
    $scope.page = p
    $('.list-pagination-button').removeClass 'list-paginate-active'
    $(".list-pagination-button#{$scope.page}").addClass 'list-paginate-active'
    $scope.setData()

  # функция пробегается по всем данным, строит список чекбоксов для данных
  # далее вычисляем на основе текущей страницы, какая же часть из всех данных должна быть показана в таблицк
  # и помещаем эти данные в соответствующую переменную
  # так же считается количество страниц, которое должно быть построено, и делается массив для страниц
  # если страниц больше одной, то проставляем, что надо вывести пагинацию
  $scope.setData = ->
    for j of $scope.allData
      $scope.checkBoxes[$scope.allData[j].id] =
        check:false
    f = ($scope.page-1)*$scope.onPage
    t = $scope.page*$scope.onPage-1

    $scope.elementsInTable = $scope.allData[f..t]

    for i in $scope.elementsInTable
      $scope.checkAllBox.visible or = i.can_delete
    $scope.pages = []
    i = 0
    variable = Math.ceil($scope.allData.length / $scope.onPage)
    while i<variable
      i++
      $scope.pages.push i
    $scope.isPagination = false
    $scope.isPagination = true if i>1

  # следим за изменением параметра "сколько записей на странице"
  $scope.$watch('onPage',()->
    $scope.setData()
    $cookieStore.put 'onPage',$scope.onPage
    $('.list-pagination-button').removeClass 'list-paginate-active'
    $(".list-pagination-button1").addClass 'list-paginate-active'
    $scope.page = 1
  )

  # вызываем список элеменетов для хлебных крошек, если ошибка в процессе вызова, то выводим ее
  AccessoryBreadcrumbs.get
    id:$scope.id
    (ok)->
      $scope.breadcrumbs = ok
    (error)->
      $scope.errorMessage = error.data
      $timeout(->
        $scope.errorMessage = ''
      ,10000
      )
  # при нажатии на чекбокс "выделить все" выделяем все
  $scope.checkAll = ->
    $scope.checkAllBox.check =! $scope.checkAllBox.check
    for i in $scope.elementsInTable
      if i.can_delete is '1'
        $scope.checkBoxes[i.id] =
          check:$scope.checkAllBox.check

    $scope.showMassActions()

  $scope.checkElement = (id)->
    $scope.checkBoxes[id].check=!$scope.checkBoxes[id].check
    $scope.showMassActions()

  $scope.showMassActions = ->
    $scope.massDelete = on
    for i in $scope.elementsInTable
      $scope.massDelete = $scope.massDelete||$scope.checkBoxes[i.id].check

  $scope.goMassDelete = ->
    elements = []
    okCount = 0
    errorCount = 0
    for i in $scope.elementsInTable
      if $scope.checkBoxes[i.id].check
        elements.push i.id
    for element in elements
      AccessoryDelete.delete
        id:element
        (ok)->
          okCount++
          $scope.okMessage = "#{okCount} из #{elements.length} - #{ok[0]['message']}"
          if !$scope.okMessage?
            $timeout(->
              $scope.okMessage = ''
            ,10000
            )
          $scope.getData() if elements.length is okCount+errorCount

        (error)->
          errorCount++
          $scope.errorMessage = "#{errorCount} из #{elements.length} - #{error.data}"
          if !$scope.errorMessage?
            $timeout(->
              $scope.errorMessage = ''
            ,10000
            )
          $scope.getData() if elements.length is okCount+errorCount



  # при удалении записи задаем вопрос, и если все в порядке, то отправляем запрос на сервер, саму запись
  # исключаем из массива записей.
  $scope.delete = (id)->
    if confirm('Вы дейстивительно хотите удалить?')
      AccessoryDelete.delete
        id:id
        (ok)->
          i=0
          deleteElement = off;

          while i<$scope.allData.length || !deleteElement
            if $scope.allData[i].id is id
              $scope.allData.splice(i,1)
              deleteElement = on
            i++
          $scope.setData()
          $scope.okMessage = ok[0]['message']
          $timeout(->
            $scope.okMessage = ''
          ,10000
          )
        (error)->
          $scope.errorMessage = error.data
          $timeout(->
            $scope.errorMessage = ''
          ,10000
          )



# контроллер детализации модуля
AccessoryDetailCtrl = ($scope,$routeParams,$http,AccessoryDetail,AccessoryBreadcrumbs,$timeout)->
  # получает из адресной строки id, по нему получает данные от Yii и помещает в шаблон.
  # именно id параметр у routeParams называется, так как именно такое имя мы ему дали в app файле.
  AccessoryDetail.get
    id:$routeParams.id
    (ok)->
      $scope.details = ok
    (error)->
      $scope.errorMessage = error.data
      $timeout(->
        $scope.errorMessage = ''
      ,10000
      )

    # вызываем список элеменетов для хлебных крошек, если ошибка в процессе вызова, то выводим ее
  AccessoryBreadcrumbs.get
    id:$routeParams.id
    (ok)->
      $scope.breadcrumbs = ok
    (error)->
      $scope.errorMessage = error.data
      $timeout(->
        $scope.errorMessage = ''
      ,10000
      )

