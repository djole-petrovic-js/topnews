( function(){

  'use strict';

  const $btnAddParagraph = $('#btnAddParagraph');
  const $paragraphs = $('#paragraphs');

  $btnAddParagraph.on('click',() => {
    $paragraphs.append(`
      <textarea name="paragraphs[]" class="form-control"></textarea><br/>
    `);
  });

}());