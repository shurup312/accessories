var dataSave, elements;

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
      title: data.field_hint
    });
    return html.clone().wrap('<p>').parent().html();
  },
  textarea: function(data) {
    var html;
    html = $('<textarea/>', {
      id: data.field,
      "class": 'dataFields',
      title: data.field_hint
    }).html(data.value);
    console.log(data);
    return html.clone().wrap('<p>').parent().html();
  }
};

dataSave = {
  get: function() {
    var val;
    val = {};
    $('.dataFields').each(function() {
      return val[this.id] = this.value;
    });
    return val;
  }
};
