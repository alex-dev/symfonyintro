function popup(url, name) {
  $.get(url, 'html')
    .then((data) => new DOMParser().parseFromString(data, 'text/html'))
    .done((data) => {
      $('#loading-modal .modal-body').html($('#product', data));
      $('body').append($('#add-done-modal, #add-failed-modal', data));
      $('#loading-modal .modal-body .owl-carousel:not(.owl-loaded)').owlCarousel({
        items: 1,
        thumbs: true,
        nav: false,
        dots: false,
        autoplay: true,
        thumbsPrerendered: true
      });
    });

  $('#loading-modal .modal-header .modal-title').html(name);
  $('#loading-modal').modal('show');
}

function popdown() {
  $('#loading-modal .modal-body').html('<div class="loader">');
  $('#add-done-modal, #add-failed-modal').remove();
}

$(document).ready(() => {
  $('#loading-modal').on('hidden.bs.modal', popdown);
})
