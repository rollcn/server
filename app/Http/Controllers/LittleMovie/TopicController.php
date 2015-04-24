<?php namespace App\Http\Controllers\LittleMovie;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\topic;

class TopicController extends Controller {

	public function postCreate()
	{
		$topic = new topic; 
		$topic = topic::find(1);
		var_dump($topic->toArray());
	}

}
