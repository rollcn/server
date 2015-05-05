<?php namespace App\Http\Controllers\LittleMovie;

use App\Http\Requests;
use App\Http\Controllers\BaseFuncController;

use Illuminate\Http\Request;
use App\publish;

class PublishController extends BaseFuncController {

	public function savePublish($topic_id,$user_id,$moive_id,$content,$MakerOrNot)
	{
		$publish = new publish;
		$publish->topic_id = $topic_id;
		$publish->user_id = $user_id;
		$publish->movie_id = $moive_id;
		$publish->topic_content = $content;
		$publish->topic_maker = $MakerOrNot; //1为话题创建者，0为普通发布者
		$publish->save();
	}
}
