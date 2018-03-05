function redirect(event, origin, url) {
  $.post(url, {
    locale: $('option:selected', event.source).val(),
    origin: origin
  }, (data) => {
    console.log(data);
  });
}
