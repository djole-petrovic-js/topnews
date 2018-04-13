<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Navigation;
use App\Categories;
use App\Stories;
use App\Paragraphs;
use App\Galery;
use App\User;
use App\Role;
use App\Poll;
use App\PollOption;
use App\Comment;
use App\Slider;
use App\Activity;
use \App\Utils\Utils;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
  private $data = [];

  public function __construct() {
    $this->data['links'] = Utils::GetNavigation();
  }

  public function show() {
    Utils::insertActivity('Visited admin panel');
    
    $this->data['user'] = Auth::user();

    return view('pages.admin.index',$this->data);
  }

  public function links() {
    $this->data['allLinks'] = Navigation::all();

    return view('pages.admin.links',$this->data);
  }

  public function storiesShow() {
    $this->data['stories'] = Stories::join(
      'categories',
      'stories.categorie_id',
      '=',
      'categories.id'
    )->get([
      'stories.id as storyID',
      'title',
      'description',
      'stories.created_at',
      'categories.categorie_name',
      'categories.id as categoryID'
    ]);

    $this->data['categories'] = Categories::all();

    return view('pages.admin.stories',$this->data);
  }

  public function storiesAdd(Request $request) {
    $this->validate($request,[
      'title' => 'required|min:5',
      'short_description' => 'required|min:10',
      'paragraphs' => 'required',
      'image' => 'required|mimes:jpeg,jpg,png|max:2048'
    ]);

    $story = new Stories();
    $story->title = $request->input('title');
    $story->description = $request->input('short_description');
    $story->title = $request->input('title');
    $story->categorie_id = $request->input('categorie_id');

    $file = $request->file('image');
    $name = time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('/uploads'),$name);
    $story->image = $name;
    $story->save();

    foreach ( $request->input('paragraphs') as $p ) {
      $parag = new Paragraphs();
      $parag->content = trim($p);
      $parag->story_id = $story->id;
      $parag->save();
    }

    return redirect()->back()->with('success','Successufuly added...');
  }

  public function storiesEdit(Request $request) {
    $id = $request->input('id');
    $title = $request->input('title');
    $description = $request->input('description');
    $categorieID = $request->input('categorieID');

    $story = Stories::find($id);
    $story->title = $title;
    $story->description = $description;
    $story->categorie_id = $categorieID;
    $story->save();

    return redirect()->back()->with('success','Story successfully edited.');
  }

  public function storiesDestroy(Request $request) {
    $id = $request->input('id');

    $story = Stories::where('id',$id)->get()[0];

    File::delete(public_path('uploads/' . $story->image));

    $images = Galery::where('stories_id',$id)->get();

    foreach ( $images as $image ) {
      Galery::destroy('id',$image->id);
      File::delete(public_path('uploads/' . $image->path));
    }

    Stories::destroy('id',$id);
    Paragraphs::where('story_id',$id)->delete();

    return redirect()->back()->with('success','Successufuly deleted...');
  }

  public function categories() {
    $this->data['categories'] = Categories::all();

    return view('pages.admin.categories',$this->data);
  }

  public function categoriesAdd(Request $request) {
    $name = $request->input('name');

    $categorie = new Categories();
    $categorie->categorie_name = $name;
    $categorie->save();

    return redirect()->back()->with('success','Categorie added...');
  }

  public function categoriesEdit(Request $request) {
    $id = $request->input('id');
    $categorie = Categories::find($id);
    $categorie->categorie_name = $request->input('name');
    $categorie->save();

    return redirect()->back()->with('success','Categorie successfully edited.');
  }

  public function categoriesDestroy(Request $request) {
    $id = $request->input('id');

    Categories::destroy($id);

    return redirect()->back();
  }

  public function linksAdd(Request $request) {
    $this->validate($request,[
      'href' => 'required',
      'name' => 'required',
      'order' => 'required',
      'visibility' => 'required'
    ]);

    $link = new Navigation();
    $link->href = $request->input('href');
    $link->name = $request->input('name');
    $link->link_order = $request->input('order');
    $link->visibility = $request->input('visibility');
    $link->save();

    return redirect()->back()->with('success','Link added successfully');
  }

  public function linksDestroy(Request $request) {
    Navigation::destroy($request->input('id'));

    return redirect()->back();
  }

  public function linksEdit(Request $request) {
    $link = Navigation::find($request->input('id'));

    $link->href = $request->input('href');
    $link->name = $request->input('name');
    $link->link_order = $request->input('order');
    $link->visibility = $request->input('visibility');
    $link->save();

    return redirect()->back()->with('success','Updated successfully');
  }

  public function galery() {
      $this->data['stories'] = Stories::all();

      $this->data['images'] = Galery::join(
          'stories',
          'galeries.stories_id',
          '=',
          'stories.id'
      )->get(['galeries.id as id','title','path']);

      return view('pages.admin.galery',$this->data);
  }

  public function galeryAdd(Request $request) {
    $this->validate($request,[
        'id' => 'required',
        'image' => 'required|mimes:jpg,jpeg,png|max:2048'
    ]);

    $image = $request->file('image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();

    $galeryImage = new Galery();
    $galeryImage->path = $imageName;
    $galeryImage->stories_id = $request->input('id');

    $image->move(public_path('uploads/'),$imageName);
    $galeryImage->save();

    return redirect()->back()->with('success','Image successfully added...');
  }

  public function galeryDestroy(Request $request) {
      $id = $request->input('id');
      $path = $request->input('path');

      Galery::destroy($id);
      File::delete(public_path('uploads/' . $path));

      return redirect()->back()->with('success','Image deleted.');
  }

  public function users() {
      $this->data['users'] = User::join(
          'roles',
          'users.role_id',
          '=',
          'roles.id'
      )->get(['users.id as userID','users.role_id as userRole','name','email','roles.id as roleID','role_name']);

      $this->data['roles'] = Role::all();

      return view('pages.admin.users',$this->data);
  }

  public function usersEdit(Request $request) {
      $id = $request->input('id');
      $userID = $request->input('userID');

      $user = User::find($userID);
      $user->role_id = $id;
      $user->save();

      return redirect()->back()->with('success','User successfully updated');
  }

  public function usersDestroy(Request $request) {
      $id = $request->input('id');

      User::destroy($id);

      return redirect()->back()->with('success','User successfully deleted');
  }

  public function pollsShow() {
    $this->data['polls'] = Poll::all();

    $this->data['options'] = Poll::join(
      'poll_options',
      'polls.id',
      '=',
      'poll_options.poll_id'
    )->get([
      'polls.id as pollID',
      'polls_name',
      'number_of_votes',
      'is_selected',
      'poll_options.id as optionID',
      'poll_options.option_name',
      'poll_options.votes',
      'poll_id'
    ]);

    return view('pages.admin.polls',$this->data);
  }

  public function pollsAdd(Request $request) {
    $pollName = $request->input('name');
    $optionsArr = $request->input('options');

    $poll = new Poll();
    $poll->polls_name = $pollName;
    $poll->number_of_votes = 0;
    $poll->is_selected = false;
    $poll->save();

    foreach ( $optionsArr as $opt ) {
      $option = new PollOption();
      $option->option_name = $opt;
      $option->votes = 0;
      $option->poll_id = $poll->id;
      $option->save();
    }

    return redirect()->back()->with('success','Poll added successfully');
  }

  public function pollsDestroy(Request $request) {
    $id = $request->input('id');

    Poll::destroy('id',$id);
    PollOption::destroy('poll_id',$id);

    return redirect()->back()->with('success','Poll successfully deleted.');
  }

  public function pollsSelected(Request $request) {
    $id = $request->input('id');

    $selected = Poll::where('is_selected',true)->get();

    if ( count($selected) > 0 ) {
      $selected[0]->is_selected = false;
      $selected[0]->save();
    }

    $poll = Poll::where('id',$id)->get()[0];
    $poll->is_selected = true;
    $poll->save();

    return redirect()->back()->with('success','Poll successfully selected.');
  }

  public function pollsInactive(Request $request) {
    $id = $request->input('id');

    $poll = Poll::where('id',$id)->get()[0];
    $poll->is_selected = false;
    $poll->save();

    return redirect()->back()->with('success','This poll is not longer active.');
  }

  public function commentsShow() {
    $this->data['comments'] = Comment::join(
      'users',
      'comments.user_id',
      '=',
      'users.id'
    )->join(
      'stories',
      'comments.story_id',
      '=',
      'stories.id'
    )->get([
      'comments.id as commentID',
      'comments.created_at',
      'comments.comment',
      'stories.title',
      'users.name'
    ]);

    return view('pages.admin.comments',$this->data);
  }

  public function commentsDestroy(Request $request) {
    $id = $request->input('id');

    Comment::destroy('id',$id);

    return redirect()->back()->with('success','Comment successfully deleted.');
  }

  public function paragraphsShow() {
    $this->data['stories'] = Stories::all();

    return view('pages.admin.paragraphs',$this->data);
  }

  public function paragraphsMultiple(Request $request) {
    $id = $request->input('storyID');

    $this->data['singleStory'] = Stories::find($id);
    $this->data['stories'] = Stories::all();
    $this->data['paragraphs'] = Paragraphs::where('story_id',$id)->get();

    return view('pages.admin.paragraphs',$this->data);
  }

  public function paragraphsDestroy(Request $request) {
    $id = $request->input('id');

    Paragraphs::destroy('id',$id);

    return redirect(route('adminParagraphs'))->with('success','Paragraphs successfully deleted');
  }

  public function paragraphsEdit(Request $request) {
    $id = $request->input('id');
    $content = $request->input('content');

    $paragraph = Paragraphs::find($id);
    $paragraph->content = trim($content);
    $paragraph->save();

    return redirect(route('adminParagraphs'))->with('success','Paragraphs successfully edit'); 
  }

  public function sliderShow() {
    $this->data['images'] = Slider::all();

    return view('pages.admin.slider',$this->data);
  }

  public function sliderAdd(Request $request) {
    $this->validate($request,[
      'image' => 'required|mimes:jpg,jpeg,png|max:2048'
    ]);

    $image = $request->file('image');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('uploads/'),$imageName);
    $sliderImage = new Slider();
    $sliderImage->path = $imageName;
    $sliderImage->timestamps = false;
    $sliderImage->save();

    return redirect()->back()->with('success','Uploaded successfully.');
  }

  public function sliderDestroy(Request $request) {
    $id = $request->input('id');
    $image = Slider::find($id);

    Slider::destroy('id',$id);
    File::delete(public_path('uploads/' . $image->path));

    return redirect()->back()->with('success','Successufuly deleted');
  }

  public function activityShow(Request $request) {
    $this->data['activities'] = Activity::join(
      'users',
      'activities.user_id',
      '=',
      'users.id'
    )->orderBy(
      'activities.created_at','DESC'
    )->get([
      'activities.id as activityID',
      'activities.content',
      'activities.created_at as created_at',
      'users.name'
    ]);

    return view('pages.admin.activity',$this->data);
  }

  public function activityDestroyOne(Request $request) {
    $id = $request->input('id');

    Activity::destroy($id);

    return redirect()->back()->with('success','Successufuly delete activity.');
  }

  public function activityDestroyAll() {
    Activity::getQuery()->delete();

    return redirect()->back()->with('success','All activities successfully deleted.');
  }
}
