function popup(url, name) {
  $('#loading-modal .modal-body').load(`${ url } #product`, () => {
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
}

$(document).ready(() => {
  $('#loading-modal').on('hidden.bs.modal', popdown);
})
