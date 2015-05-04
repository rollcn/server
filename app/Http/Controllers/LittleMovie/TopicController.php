<?php namespace App\Http\Controllers\LittleMovie;

use App\Http\Requests;
use App\Http\Controllers\BaseFuncController;
use Illuminate\Http\Request;
use App\topic;
use App\movie;
use App\user;

class TopicController extends BaseFuncController {

	
	/** 
	 * 创建话题
	 * @param int $user_id 用户id
	 * @param string $content 话题内容
	 * @param int $moive_id 电影id
 	*/
	public function anyCreate($user_id = 0,$content = '',$moive_id = 0)
	{
		/*电影入库*/
		$this->addMovie($moive_id);
		
		$msg_code = $this->findTopicContent($content);	//检测话题是否已经存在
		if($msg_code == 200)
		{
			/*新增话题*/
			$topic = new topic; 
			$topic->create_user_id = $user_id;
			$topic->content = $content;
			$topic->movie1_id = $moive_id;
			$topic->movie1_like = 1;  //投票数
			$topic->movie1_user_id = $user_id;
			$topic->location = 2;
			$topic->save();		

			/*新增发布信息*/
			$this->addPublish($topic->id,$user_id,$moive_id,$topic->content,1);
			/*新增收藏信息*/
			$this->addCollect($topic->id,$user_id);
			/*新增投票信息*/	
			$VoteController = new VoteController;
			$VoteController->doVote($topic_id,$user_id,1);
		}
		return $this->toJson($msg_code);
		//var_dump($res);	
		//return json_encode($res,true);
		
	}

	/** 
	 * 给话题增加电影
	 * @param int $topic_id 话题id
	 * @param int $moive_id 电影id
	 * @param int $user_id 用户id
 	*/
	public function anyAddMovie($topic_id,$movie_id,$user_id)
	{
		/*电影入库*/
		$this->addMovie($movie_id);

		$topic = Topic::find($topic_id);
		$code = $this->addMovieToTopicCheck($topic,$movie_id,$user_id);
		if($code != 200)
		{
			return $this->toJson($code);
		}
		else
		{
			$location = 0;
			/*新增发布信息*/
			$this->addPublish($topic_id,$user_id,$movie_id,$topic->content,0);
			if($topic->location == 2)
			{
				$topic->movie2_id = $movie_id;
				$topic->movie2_like = 1;
				$topic->movie2_user_id = $user_id;
				$location = 2;
			}
			if($topic->location == 3)
			{
				$topic->movie3_id = $movie_id;
				$topic->movie3_like = 1;
				$topic->movie3_user_id = $user_id;
				$location = 3;
			}
			if($topic->location == 4)
			{
				$topic->movie4_id = $movie_id;
				$topic->movie4_like = 1;
				$topic->movie4_user_id = $user_id;
				$location = 4;
			}
			$topic->location++;
			$topic->save();

			/*新增收藏信息*/
			$this->addCollect($topic->id,$user_id);
			/*新增投票信息*/
			$VoteController = new VoteController;
			$VoteController->doVote($topic_id,$user_id,$location);
		}
		return $this->toJson(200);
	}

	/** 
	 * 给话题中的电影投票
	 * @param int $topic_id 话题id
	 * @param int $user_id 用户id
	 * @param int $location 电影在话题中的index
	 * 
 	*/
	public function anyVote($topic_id,$user_id,$location)
	{
		$VoteController = new VoteController;
		$msg_code = $VoteController->doVote($topic_id,$user_id,$location);
		return $this->toJson($msg_code);
	}

	/** 
	 * 得到话题详情
	 * @param int $topic_id 话题id
	 * @param int $user_id 用户id ，当前用户
 	*/
	public function getTopicDetail($topic_id,$user_id = 0)
	{
		$res = $this->topicData($topic_id,$user_id);
		return $this->toJson(self::STATS_OK,$res);
	}

	public function topicData($topic_id,$user_id)
	{
		$topic = topic::find($topic_id);
		$data = array(
			'title' => $topic->content,
			'movie1' => array(),
			'movie2' => array(),
			'movie3' => array(),
			'movie4' => array(),
			'vote_location' => 0,
			'topic_collect' => false
		);
		if($topic->movie1_id != 0)
		{
			$data['movie1'] = $this->movieDetail($topic->movie1_id,$topic->movie1_user_id,$topic->movie1_like);
		}
		if($topic->movie2_id != 0)
		{
			$data['movie2'] = $this->movieDetail($topic->movie2_id,$topic->movie2_user_id,$topic->movie2_like);
		}
		if($topic->movie3_id != 0)
		{
			$data['movie3'] = $this->movieDetail($topic->movie3_id,$topic->movie3_user_id,$topic->movie3_like);
		}
		if($topic->movie4_id != 0)
		{
			$data['movie4'] = $this->movieDetail($topic->movie4_id,$topic->movie4_user_id,$topic->movie4_like);
		}
		$VoteController = new VoteController;
		$data['vote_location'] = $VoteController->findVote($topic_id,$user_id);

		$CollectController = new CollectController;
		$data['topic_collect'] = $CollectController->findCollect($topic_id,$user_id);

		return $data;
	}

	/** 
	 * 得到全部话题
	 * @param int $user_id 当前用户id
 	*/
	public function getAllTopic($user_id = 0)
	{
		$topics = topic::all();
		$res = array();
		$index = 0;
		foreach ($topics as $topic)
		{
			$res[$index++] = $this->topicData($topic->id,$user_id);
		}
		return $this->toJson(self::STATS_OK,$res);

	}


	/** 
	 * 得到话题中每个电影的详情及发布者信息
	 * @param int $topic_id 话题id
	 * @param int $user_id 用户id，发布者
	 * @param int $like 赞数
 	*/
	public function movieDetail($movie_id,$user_id,$like)
	{
		$UserController = new UserController;
		$user = $UserController->findUser($user_id);
		$MovieController = new MovieController;
		$movie = $MovieController->findMovie($movie_id);

		$res = array(
			'like' => $like,
			'movie_id' => $movie->id, 
			'movie_year' => $movie->year,
			'movie_title' => $movie->name,
			'movie_poster' => $movie->poster_url,
			'publish_user_id' => $user->id,
			'publish_user_name' => $user->name
		);
		return $res;
	}


	/** 
	 * 检查话题是否存在
	 * @param int $content 话题内容
 	*/
	public function findTopicContent($content)
	{
		$count = Topic::where('content', '=', $content)->count();
		//$topic = Topic::find(2);
		if($count != 0)
		{
			return 402;	//话题已存在
		}
		return 200;
	}

	/** 
	 * 电影入本地库
	 * @param int $id 豆瓣电影id
 	*/
	public function addMovie($id)
	{
		$MovieController = new MovieController;
		$msg_code = $MovieController->findMovieInDb($id);
	}

	/** 
	 * 增加发布信息
	 * @param int $topic_id 话题id
	 * @param int $moive_id 电影id
	 * @param int $user_id 用户id
	 * @param string $content 话题内容
	 * @param int $MakerOrNot 是否为话题创建者	 
 	*/
	public function addPublish($topic_id,$user_id,$moive_id,$content,$MakerOrNot)
	{
		$PublishController = new PublishController;
		$PublishController->savePublish($topic_id,$user_id,$moive_id,$content,$MakerOrNot);
	}

	/** 
	 * 为话题添加电影前的检查
	 * @param int $topic_id 话题id
	 * @param int $moive_id 电影id
	 * @param int $user_id 用户id	 
 	*/
	public function addMovieToTopicCheck($topic,$movie_id,$user_id)
	{
		if($topic->location == 5)
		{
			return 405;
		}
		if($movie_id == $topic->movie1_id || $movie_id == $topic->movie2_id || $movie_id == $topic->movie3_id)
		{
			return 402;
		}
		// $publish = $topic->publishes;
		// foreach ($publish as $key) 	//检查该用户是否已经参加过此话题了   直接拼接where查询没有结果，有空看看
		// {
		// 	if ($key->user_id == $user_id) {
		// 		return 406;
		// 	}

		// }
		if($user_id == $topic->movie1_user_id || $user_id == $topic->movie2_user_id || $user_id == $topic->movie3_user_id || $user_id == $topic->movie4_user_id)
		{
			return 406;
		}
		return 200;
	}

	/** 
	 * 话题收藏数+1
	 * @param int $topic_id 话题id
 	*/
	public function addTopicLike($topic_id)
	{
		$topic = Topic::find($topic_id);
		$topic->like++;
		$topic->save();
	}

	/** 
	 * 新增收藏信息
	 * @param int $topic_id 话题id
	 * @param int $user_id 	用户id
 	*/
	public function addCollect($topic_id,$user_id)
	{
		$CollectController = new CollectController;
		$CollectController->saveCollect($topic_id,$user_id);
	}

	
}
