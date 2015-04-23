<?php namespace App\Http\Controllers\LittleMovie;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class MovieController extends Controller {

	public function getSearch($key = 'nothing')
	{
		return $key;
	}

}
