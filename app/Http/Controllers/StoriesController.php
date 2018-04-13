<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Utils\Utils;
use App\Stories;
use App\Galery;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class StoriesController extends Controller
{
  private $data = [];

  public function __construct() {
    $this->data['links'] = Utils::GetNavigation();
  }

  public function show($id) {
    $paragraphs = Stories::join('paragraphs','stories.id','=','paragraphs.story_id')->where('stories.id',$id)->get();
    $story = $paragraphs[0];

    $this->data['paragraphs'] = $paragraphs;
    $this->data['story'] = $story;

    $this->data['comments'] = Comment::where('story_id',$id)->join(
      'users',
      'comments.user_id',
      '=',
      'users.id'
    )->orderBy(
      'comments.created_at','DESC'
    )->get([
      'comments.comment',
      'comments.created_at',
      'users.name'
    ]);

    Utils::insertActivity('Visited stories page.');

    return view('pages.stories',$this->data);
  }

  public function galery($id) {
    $story = Stories::find($id);
    $image = new Galery();
    $image->id = 1;
    $image->path = $story->image;

    $this->data['images'] = Galery::where('stories_id',$id)->get();
    $this->data['images'][] = $image;

    Utils::insertActivity('Visited galeries page');

    return view('pages.galery',$this->data);
  }

  public function comment(Request $request) {
    $storyID = $request->input('id');
    $userID = Auth::user()->id;

    $comment = new Comment();
    $comment->comment = trim($request->content);
    $comment->story_id = $storyID;
    $comment->user_id = $userID;
    $comment->save();

    Utils::insertActivity('Added a comment.');

    return redirect()->back();
  }
}
