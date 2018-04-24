const datestring = document.currentScript.getAttribute('data-time');
const action = document.currentScript.getAttribute('data-action');
const label = document.currentScript.getAttribute('data-cancel-label');

function frameUpdate(date) {
  const limit = moment(date).add(2, 'days');
  const bounds = [
    { bound: { value: 24, unit: 'hours' }, timeout: { value: 1, unit: 'hour' }, format: 'd __ h __' },
    { bound: { value: 1, unit: 'hours' }, timeout: { value: 1, unit: 'minute' }, format: 'h _ m _' },
    { bound: { value: 0, unit: 'seconds' }, timeout: { value: 1, unit: 'second' }, format: 'm _ s _' },
    undefined
  ];

  for (bound of bounds) {
    if (!bound) {
      $('#data-interval').remove();
      $('#data-cancel').remove();
      break;
    } else if (limit.diff(moment.utc(), bound.bound.unit) >= bound.bound.value) {
      $('#data-interval-value').text(moment.duration(limit.diff(moment.utc())).format(bound.format));
      setTimeout(
        () => frameUpdate(date),
        moment.duration(bound.timeout.value, bound.timeout.unit).as('milliseconds'));      
      break;
    }
  }
}

$(() => {
  const date = moment.utc(datestring);
  if (date.diff(moment.utc(), 'days') < 2) {
    $('#sidebar-data').append(`
      <div id="data-cancel" class="row">
        <form action="${action}" method="post">
          <button type="submit" class="btn btn-sm btn-template-outlined">
            ${label}:&nbsp;<span id="data-interval-value"></span>
          </button>
        </form>
      </div>
    `);

    frameUpdate(date);
  }
});
