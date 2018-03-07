function addToCart(url, key) {
  $.post(url, { 'item': key })
    .done(() => $('#add-done-modal').modal({show: true}))
    .fail(() => $('#add-failed-modal').modal({show: true}));
}