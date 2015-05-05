<?php namespace App\Http\Controllers\LittleMovie;

use App\Http\Requests;
use App\Http\Controllers\BaseFuncController;

use Illuminate\Http\Request;
use App\comment;
class CommentController extends BaseFuncController {

	public function anyCreateComment($topic_id,$user_id,$content)
	{
		$comment = new comment;
		$comment->user_id  = $user_id;
		$comment->topic_id = $topic_id;
		$comment->content  = $content;
		$comment->save();
		return $this->toJson(self::STATS_OK); 
	}

	/** 
	 * 查询某话题的全部评论
	 * @param id $topic_id 话题id
 	*/
	public function getAll($topic_id)
	{
		$comments = comment::where('topic_id','=',$topic_id)->with('user')->get();//预先加载
		$res = array();
		$index = 0;
		foreach ($comments as $comment) 
		{
			$res[$index++] = array(
				'content' => $comment->content,
				'user_id' => $comment->user_id,
				'user_name' => $comment->user->name,
			);
		}
		// var_dump($res);
		return $this->toJson(self::STATS_OK,$res);
	}
}
