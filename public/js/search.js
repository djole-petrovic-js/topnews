( function(){

  'use strict';

  const href  = window.location.href;
  const [category,page = 1] = href.slice(href.indexOf('search') + 'search'.length + 1).split('/');
  const limit = 2;
  const offset = (page - 1) * limit;
  const $storiesWrapper = $('#storiesWrapper');
  const $paginate = $('#paginate');
  const $container = $('#container');

  const template = `
    <article>
      <h1><a href="{{ href }}">{{ title }}</a></h1>
      <p>Posted on : {{ date }}</p>
      <img class="img-responsive" src="{{ image }}" alt="" />
      <p>{{ description }} <a class="continue" href="{{ href }}">Continue Reading.</a></p>
    </article>
  `;

  const compile = checkTypes(['string','object'],(template,data) => {
    for ( const [key,value] of Object.entries(data) ) {
      const regex = new RegExp(`{{\\s?${ key }\\s?}}`,'g');
      template = template.replace(regex,value);
    }

    return template;
  });

  const getContent = attempt(checkTypes(['string','number','number'],async(category,limit,offset) => {
    const response = await fetch('/public/search/getStories',{
      method:'POST',
      headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      body:JSON.stringify({ category,limit,offset })
    });

    let stories = await response.json();

    if ( stories.length === 0 ) {
      return $storiesWrapper.html('<div class="alert alert-info"><p>No stories at the moment...</p></div>');
    }

    stories = stories.map(x => {
      x.date = x.created_at.split(' ')[0].split('-').reverse().join('/');
      x.href = '/public/stories/' + x.id;
      x.image = '/public/uploads/' + x.image;

      return x;
    });

    $storiesWrapper.html(stories.map(x => compile(template,x)).join(''));
  }));

  const getNumberOfPages = attempt(checkTypes(['string'],async(category) => {
    const response = await fetch('/public/search/getNumberOfStories',{
      method:'POST',
      headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      body:JSON.stringify({ category })
    });

    const { numberOfStories } = await response.json();
    const paginateHTML = ['<ul class="pagination">'];

    for ( let i = 1 ; i <= Math.ceil(numberOfStories / limit) ; i++ ) {
      paginateHTML.push(`
        <li class="${ i === +page ? 'active' : '' }">
          <a>${ i }</a>
        </li>
      `);
    }

    paginateHTML.push('</ul>');
    $paginate.html(paginateHTML.join(''));
  }));

  const handlePagination = async (e) => {
    const el = e.target;

    if ( el.tagName !== 'A' ) return;

    if ( el.parentElement.className === 'active' ) return;

    const lastLinkClicked = $('#paginate li[class=active]').toArray()[0];

    lastLinkClicked.classList.remove('active');
    el.parentElement.classList.add('active');

    const newPage = +el.innerHTML;

    const [error,response] = await getContent(category,limit,(newPage - 1) * limit);

    if ( error ) {
      return alert('Error occured while trying to fetch new stories, please try again...');
    }

    window.scrollTo(0,$container.offset().top);
  }

  $('#paginate').on('click',handlePagination);

  //bootstrap 
  ( async function(){

    const [[error1],[error2]] = await Promise.all([
      getNumberOfPages(category),
      getContent(category,limit,offset)
    ]);

    if ( error1 || error2 ) {
      alert('Fatal error has occured, please refresh your browser!');
    }
  }());

}());