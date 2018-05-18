function add(tag) {
  const collection = $(tag);
  const index = collection.data('index');
  const prototype = collection.data('prototype')
    .replace(/__name__label__/g, index)
    .replace(/__name__/g, index);
  
  collection.data('index', index + 1);
  collection.append(`
    <li>
      ${prototype}
    </li>
  `);
}
