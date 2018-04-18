$(() => {
  moment.locale(window.navigator.userLanguage || window.navigator.language);
  $('.date').each(() => {
    this.text(moment.utc(this.text()).local().format('LLLL'));
  });
});

