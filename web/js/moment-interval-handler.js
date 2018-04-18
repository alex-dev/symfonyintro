function frameUpdate(date) {
  if (date.diff(moment.utc(), 'days') >= 2) {
    $('#data-interval').remove();
    $('#data-cancel').remove();
  } else {
    let nextFrame;
    
    {
      nextFrame = moment.duration(15, 'seconds');
      $('data-interval-value').text(date.diff(moment.utc(), 'seconds'));  
    }

    setTimeout(() => frameUpdate(date), nextFrame.as('milliseconds'));
  }
}

$(() => {
  const date = moment.utc(document.currentScript.getAttribute('data-time'));
  const action = document.currentScript.getAttribute('data-action');
  const labels = {
    text: document.currentScript.getAttribute('data-time-to-cancel-label'),
    button: document.currentScript.getAttribute('data-cancel-label')
  };

  if (date.diff(moment.utc(), 'days') < 2) {
    $('#sidebar-data').append(`
      <div id="data-interval" class="row">
        ${labels.text}:&nbsp;<span id="data-interval-value"></span>
      </div>
      <div id="data-cancel" class="row">
        <form action="${action}" method="post">
          <button type="submit">${labels.button}</button>
        </form>
      </div>
    `);

    frameUpdate(date);
  }
});
