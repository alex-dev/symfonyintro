function redirect(event) {
  window.location = $('option:selected', event.source).val();
}
