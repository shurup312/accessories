elements =
  readonly:(data)->
    html = $("<input/>",
      type:'hidden'
      value:data.value
      id:data.field
      class:'dataFields'
    )
    # получаем outerHTML
    data.value+html.clone().wrap('<p>').parent().html()
  select:(data)->
    select = $('<select/>',
      id:data.field
      class:'dataFields'
    )
    for item of data.set
        option = $('<option/>',
          value:item
          text:data.set[item]
        )
        if item == data.value then option.attr 'selected',true
        option.appendTo select

    # получаем outerHTML
    select.clone().wrap('<p>').parent().html()
  input:(data)->
    html = $("<input/>",
      type:'text'
      value:data.value
      id:data.field
      class:'dataFields'
      title:data.field_hint
    )
    # получаем outerHTML
    html.clone().wrap('<p>').parent().html()
  textarea:(data)->
    html = $('<textarea/>',
      id:data.field
      class:'dataFields'
      title:data.field_hint
    ).html data.value
    # получаем outerHTML
    html.clone().wrap('<p>').parent().html()
  file:(data)->
    input_img = $("<input/>",
      type:'file'
      id:data.field+'_input'
      name:data.field
      class:'dataFields'
      title:data.field_hint
      'ng-model':"files."+data.field
    )
    div = $("<div/>",
      id:data.field+'_setimage'
    )
    form = $('<form></form>',
      id:data.field+'_form'
      method:'post'
      action:'/accessory/data/upload'
      enctype:'multipart/form-data'
      target:data.field+'_frame'
    ).append input_img

    frame = $('<iframe></iframe>',
      src:''
      name:data.field+'_frame'
      id:data.field+'_frame'
      width:500
      height:100
    ).css('display','none')

    div = $('<div></div>').html(div).html()
    frame = $('<div></div>').html(frame).html()
    form = $('<div></div>').html(form).html()

    # получаем outerHTML
    div+form+frame



