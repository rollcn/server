<?php namespace App\Http\Controllers\LittleMovie;

use App\Http\Requests;
use App\Http\Controllers\BaseFuncController;

use Illuminate\Http\Request;
use App\t_collection;

class CollectController extends BaseFuncController {

	public function anyCollectTopic($topic_id,$user_id)
	{
		$count = t_collection::where('topic_id', '=', $topic_id)->Where('user_id','=',$user_id)->count();
		if($count >= 1)
		{
			return $this->toJson(402);
		}
		else
		{
			$this->saveCollect($topic_id,$user_id);
			$TopicController = new TopicController;
			$TopicController->addTopicLike($topic_id);
			return $this->toJson(200);
		}
	}

	public function saveCollect($topic_id,$user_id)
	{
		$collect = new t_collection;
		$collect->topic_id = $topic_id;
		$collect->user_id  = $user_id;
		$collect->save();
	}

	public function findCollect($topic_id,$user_id)
	{
		$collections = t_collection::where('topic_id', '=', $topic_id)->Where('user_id','=',$user_id)->get();
		if($collections->count() != 0)
		{
			return true;
		}
		return false;
	}
}
