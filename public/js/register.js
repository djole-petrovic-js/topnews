( function(){

  'use strict';

  const form = $('#registerForm');
  const errorsdiv = $('#errorsdiv');

  form.on('submit',(e) => {
    const f = new Form({
      username:'required',
      password:'required',
      confirmPassword:'required|same:password',
      email:'required|regex:^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,6}$'
    });

    f.bindValues('#registerForm');
    f.validate();

    if ( !f.isValid() ) {
      e.preventDefault();
      errorsdiv.html(f.getErrorsAsUL('list-group','list-group-item'));
    }
  });

}());