<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\Utils\Utils;
use \App\Categories;
use \App\Stories;
use \App\Poll;
use \App\PollOption;
use \App\Slider;
use \App\UserVoted;

class IndexController extends Controller
{
  private $data = [];

  public function __construct() {
    $this->data['links'] = Utils::GetNavigation();
    $this->data['categories'] = Categories::all();
    $this->data['stories'] = Stories::limit(4)->orderBy('created_at','DESC')->get();
  }

  public function about() {
    Utils::insertActivity('Visited about page');

    return view('pages.about',$this->data);
  }

  public function index() {
    $poll = Poll::where('is_selected',true)->get();

    if ( count($poll) > 0 ) {
      $poll = $poll[0];
      $options = PollOption::where('poll_id',$poll->id)->get();
      $this->data['poll'] = $poll;
      $this->data['options'] = $options;      
    }

    $this->data['sliderImages'] = Slider::all();

    Utils::insertActivity('Visited index page');

    return view('pages.index',$this->data);
  }

  public function getResults($id) {
    return PollOption::where('poll_id',$id)->get();
  }

  public function vote(Request $request) {
    if ( !Auth::check() ) {
      return ['userDoesntExist' => true];
    }

    $userID = Auth::user()->id;
    $pollID = $request->input('pollID');
    $optionID = $request->input('optionID');

    $alreadyVoted = UserVoted::where([
      'user_id' => $userID,
      'poll_id' => $pollID
    ])->get();

    if ( count($alreadyVoted) > 0 ) {
      return ['alreadyVoted' => true];
    }

    try {
      $poll = Poll::where('id',$pollID)->get()[0];
      $poll->number_of_votes++;
      $poll->save();
      $option = PollOption::where('id',$optionID)->get()[0];
      $option->votes++;
      $option->save();

      $userVoted = new UserVoted();
      $userVoted->user_id = $userID;
      $userVoted->poll_id = $pollID;
      $userVoted->save();

      Utils::insertActivity('Voted on a poll');

      return ['success' => true];
    } catch (\Exception $ex) {
      return ['success' => false];
    }
  }
}
