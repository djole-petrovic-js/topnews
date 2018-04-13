<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Utils\Utils;
use App\Stories;
use App\Categories;

class SearchController extends Controller
{
  private $data = [];

  public function __construct() {
    $this->data['links'] = Utils::GetNavigation();
  }

  public function show($category) {
    Utils::insertActivity('Visited search page');

    return view('pages.search',$this->data);
  }

  public function getStories(Request $request) {
    $category = Categories::where('categorie_name',$request->input('category'))->first();
    $limit = $request->input('limit');
    $offset = $request->input('offset');

    return Stories::where('categorie_id',$category->id)->limit($limit)->offset($offset)->get();
  }

  public function getNumberOfStories(Request $request) {
    $category = Categories::where('categorie_name',$request->input('category'))->first();

    return [
      'numberOfStories' => Stories::where('categorie_id',$category->id)->count()
    ];
  }
}
