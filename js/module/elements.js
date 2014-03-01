var elements;

elements = {
  readonly: function(data) {
    var html;
    html = $("<input/>", {
      type: 'hidden',
      value: data.value,
      id: data.field,
      "class": 'dataFields'
    });
    return data.value + html.clone().wrap('<p>').parent().html();
  },
  select: function(data) {
    var item, option, select;
    select = $('<select/>', {
      id: data.field,
      "class": 'dataFields'
    });
    for (item in data.set) {
      option = $('<option/>', {
        value: item,
        text: data.set[item]
      });
      if (item === data.value) {
        option.attr('selected', true);
      }
      option.appendTo(select);
    }
    return select.clone().wrap('<p>').parent().html();
  },
  input: function(data) {
    var html;
    html = $("<input/>", {
      type: 'text',
      value: data.value,
      id: data.field,
      "class": 'dataFields',
      title: data.field_hint,
      'ng-model': "fields." + data.field + '.value'
    });
    return html.clone().wrap('<p>').parent().html();
  },
  textarea: function(data) {
    var html;
    html = $('<textarea/>', {
      id: data.field,
      "class": 'dataFields',
      title: data.field_hint,
      'ng-model': "fields." + data.field + '.value'
    }).html(data.value);
    return html;
  },
  checkbox: function(data) {
    var html;
    html = $('<input/>', {
      type: 'checkbox',
      id: data.field,
      "class": 'dataFields',
      title: data.field_hint,
      'ng-model': "fields." + data.field + '.value',
      'ng-true-value': 1,
      'ng-false-value': 0
    });
    return html;
  },
  select: function(data) {
    var html, i, option;
    console.log(data);
    html = $('<select/>', {
      id: data.field,
      "class": 'dataFields',
      title: data.field_hint,
      'ng-model': "fields." + data.field + '.value'
    });
    for (i in data.options) {
      option = $('<option></option>', {
        value: i
      }).html(data.options[i]);
      html.append(option);
    }
    return html;
  },
  file: function(data) {
    var div, form, frame, input_img;
    input_img = $("<input/>", {
      type: 'file',
      id: data.field + '_input',
      name: data.field,
      "class": 'dataFields',
      title: data.field_hint
    });
    div = $("<div/>", {
      id: data.field + '_setimage'
    });
    form = $('<form></form>', {
      id: data.field + '_form',
      method: 'post',
      action: '/module/data/upload',
      enctype: 'multipart/form-data',
      target: data.field + '_frame'
    }).append(input_img);
    frame = $('<iframe></iframe>', {
      src: '',
      name: data.field + '_frame',
      id: data.field + '_frame',
      width: 500,
      height: 100
    }).css('display', 'none');
    div = $('<div></div>').html(div).html();
    frame = $('<div></div>').html(frame).html();
    form = $('<div></div>').html(form).html();
    return div + form + frame;
  }
};
