<?php
namespace App\Utils;

use App\Navigation;
use App\Activity;
use Illuminate\Support\Facades\Auth;

class Utils {
	public static function GetNavigation() {
		$visibility = [0];

		if ( !Auth::check() ) {
			$visibility[] = 1;
		} else {
			$user = Auth::user();
			$visibility[] = 2;

			if ( $user->role_id == 2 ) {
				$visibility[] = 3;
			}
		}

		return Navigation::whereIn('visibility',$visibility)->orderBy('link_order','asc')->get();
	}

	public static function insertActivity($message) {
		if ( !Auth::check() ) return;

		$id = Auth::user()->id;

		$activity = new Activity();
		$activity->user_id = $id;
		$activity->content = $message;
		$activity->save();
	}
}
