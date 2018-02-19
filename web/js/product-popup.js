function popup(url) {
  $('#loading-modal .modal-body').load(`${ url } #product`, () => {
    $('.owl-carousel:not(.owl-loaded)').owlCarousel({
      items: 1,
      thumbs: true,
      nav: false,
      dots: false,
      autoplay: true,
      thumbsPrerendered: true
    });
  });

  $('#loading-modal').modal('show');
}

function popdown() {
  $('#loading-modal .modal-body').html('<div class="loader">');
}

$(document).ready(() => {
  $('#loading-modal').on('hidden.bs.modal', popdown);
})
