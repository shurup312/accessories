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
    )
    # получаем outerHTML
    html.clone().wrap('<p>').parent().html()
  textarea:(data)->
    html = $('<textarea/>',
      id:data.field
      class:'dataFields'
    ).html data.value
    console.log data
    # получаем outerHTML
    html.clone().wrap('<p>').parent().html()

dataSave =
  get : ->
    val = {}
    $('.dataFields').each(->
      val[this.id] = this.value
    )
    val