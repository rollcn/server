<?php namespace App\Http\Controllers\LittleMovie;

use App\Http\Requests;
use App\Http\Controllers\BaseFuncController;

use Illuminate\Http\Request;
use App\vote;
use App\topic;

class VoteController extends BaseFuncController {

	public function doVote($topic_id,$user_id,$location)
	{
		$votes = vote::where('topic_id', '=', $topic_id)->Where('user_id','=',$user_id)->get();
		if($votes->count() == 0)
		{
			$vote = new vote;
			$vote->topic_id = $topic_id;
			$vote->user_id  = $user_id;
			$vote->vote_location = $location;
			$vote->save();
			$this->updataVote($topic_id,$location,1);
			return 200;
		}
		else if($votes[0]->vote_location == 0)
		{
			$vote = $votes[0];
			$this->updataVote($topic_id,$location,1);
			$vote->vote_location = $location;
			$vote->save();	
			return 200;
		}
		return $this->checkVote($votes[0],$location,$topic_id);
	}

	public function checkVote($vote,$location,$topic_id)
	{
		if($vote->vote_location == $location)
		{
			$this->updataVote($topic_id,$location,-1);
			$vote->vote_location = 0;
			$vote->save();
			return 200;
		}
		else
		{
			return 406;
		}
	}

	/** 
	 * 操作话题中电影的得票数
	 * @param int $topic_id 话题id
	 * @param int $location 电影顺序
	 * @param int $var 变化值 +1/-1
 	*/
	public function updataVote($topic_id,$location,$var)
	{
		$topic = topic::find($topic_id);
		switch ($location) {
			case 1:
				$topic->movie1_like+=$var;
				break;
			case 2:
				$topic->movie2_like+=$var;
				break;
			case 3:
				$topic->movie3_like+=$var;
				break;
			default:
				$topic->movie4_like+=$var;
				break;
		}
		$topic->save();
	}

	public function findVote($topic_id,$user_id)
	{
		$votes = vote::where('topic_id', '=', $topic_id)->Where('user_id','=',$user_id)->get();

		if($votes->count() != 0)
		{
			$vote = $votes[0];
			//var_dump($vote->location);
			return $vote->vote_location;
		}
		return 0;
	}
}
