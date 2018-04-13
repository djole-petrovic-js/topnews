( function(){

  'use strict';

  const textareas = Array.from(
    document.getElementsByTagName('textarea')
  );

  for ( const ta of textareas ) {
    const old = ta.value.trim();
    ta.value = '';
    ta.value = old;
  }

}());