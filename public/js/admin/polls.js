( function(){

  'use strict';

  const pollsWreaper = $('#options-wreaper');

  $('#btnAddOption').on('click',(e) => {
    pollsWreaper.append(`
      <div class="form-group">
        <input type="text" class="form-control" name="options[]">
      </div>
    `);
  });

}());