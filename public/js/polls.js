( function(){

  'use strict';

  const pollID = Number($('#poll').attr('data-id'));

  const getResults = attempt(checkTypes(['number'],async (pollID) => {
    const response = await fetch('/public/polls/get/' + pollID);

    if ( response.status < 200 || response.status > 300 ) {
      throw new Error('Error while getting results');
    }

    return response.json();
  }));

  const displayResults = attempt(checkTypes(['array'],(options) => {
    const total = options.reduce((total,item) => {
      total += Number(item.votes); return total;
    },0);

    $('#pollUL').html(options.map(({ option_name,votes }) => {
      const percent = total === 0 ? 0 : Math.round(Number(votes) / total * 100);

      return `
        <li class="list-group-item">
          ${ option_name } : ${ votes } ${ percent } %
        </li>`;
    }).join(''));
  }));

  const vote = attempt(checkTypes(['number','number'],async(pollID,optionID) => {
    const response = await fetch('/public/polls/vote',{
      method:'POST',
      headers:{
        'Content-Type':'application/json'
      },
      credentials:'same-origin',
      body:JSON.stringify({ pollID,optionID })
    });

    return await response.json();
  }));

  $('#btnVote').on('click',async() => {
    const optionID = $('#pollUL input:checked').val();

    if ( !optionID ) return alert('Choose one options in order to vote!');

    const [e,result] = await vote(pollID,Number(optionID));

    if ( e ) return alert('Error occured while voting, please try again!');

    if ( result.alreadyVoted === true ) {
      alert('You have already voted on this poll...');
    }

    if ( result.userDoesntExist === true ) {
      alert('You have to be logged in to vote, poll results are below!');
    }

    if ( result.success === false ) {
      alert('Error occured while voting, please try again...');
    }

    const [error,options] = await getResults(pollID);

    if ( error ) {
      alert('Error while getting your results, please try again!');
    }

    $('#controls').html('');
    displayResults(options);
  });

  $('#btnShowVotes').on('click',async() => {
    const [error,options] = await getResults(pollID);

    if ( error ) {
      alert('Error while getting your results, please try again!');
    }

    $('#controls').html('');
    displayResults(options);
  });

}());
