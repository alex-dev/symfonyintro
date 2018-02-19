$(document).ready(() => {
  $('.slider').each((index, item) => {
    $(item).slider({
      tooltip: 'bottom'
    });
  });
});
