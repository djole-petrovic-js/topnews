<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Stories;
use App\LikesDislikes;
use Illuminate\Http\Request;
use \App\Utils\Utils;

class LikesDislikesCommentsController extends Controller
{
  public function like(Request $request) {
  	$userID = AUTH::user()->id;
  	$storyID = $request->input('id');

  	$ifVoted = LikesDislikes::where([
  		'user_id' => $userID,
  		'story_id' => $storyID
  	])->get();

  	if ( count($ifVoted) > 0 ) {
  		return redirect()->back()->with('error','You have already voted...');
  	}

		$story = Stories::find($storyID);
		$story->likes++;
		$story->save();

		$likesDislikes = new LikesDislikes();
		$likesDislikes->user_id = $userID;
		$likesDislikes->story_id = $storyID;
		$likesDislikes->save();

    Utils::insertActivity('Liked a story');

		return redirect()->back()->with('success','Voting successfull...');  	
  }

  public function dislike(Request $request) {
  	$userID = AUTH::user()->id;
  	$storyID = $request->input('id');

  	$ifVoted = LikesDislikes::where([
  		'user_id' => $userID,
  		'story_id' => $storyID
  	])->get();

  	if ( count($ifVoted) > 0 ) {
  		return redirect()->back()->with('error','You have already voted...');
  	}

		$story = Stories::find($storyID);
		$story->dislikes++;
		$story->save();

		$likesDislikes = new LikesDislikes();
		$likesDislikes->user_id = $userID;
		$likesDislikes->story_id = $storyID;
		$likesDislikes->save();

    Utils::insertActivity('Disliked a story');

		return redirect()->back()->with('success','Voting successfull...');
  }
}
