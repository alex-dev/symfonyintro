$(() => {
  moment.locale(window.navigator.userLanguage || window.navigator.language);
  $('.date').text((index, value) => moment.utc(value).local().format('LLLL'));
});

