<?php namespace App\Http\Controllers\LittleMovie;

use App\Http\Requests;
use App\Http\Controllers\BaseFuncController;

use Illuminate\Http\Request;
use App\user;
use App\topic;
use \Hash;
class UserController extends BaseFuncController {

	/** 
	 * 注册
	 * @param string $name 用户名
	 * @param string $password 密码
	 * @param string $sign 签名
 	*/
	public function anyRegister($name,$password,$sign)
	{
		$users = user::where('name', '=' , $name)->get();
		if($users->count() == 1)
		{
			return $this->toJson(self::STATS_ALREADY_HAVE);
		}
		$user = new user;
		$user->name = $name;
		$user->password = Hash::make($password);
		$user->sign = $sign;
		$user->save();
		$data = array(
			'id' => $user->id,
			'name' => $user->name,
			'password' => $user->password,
			'sign' => $user->sign,
		);
		return $this->toJson(self::STATS_OK,$data);
	}

	/** 
	 * 登陆
	 * @param string $name 用户名
	 * @param string $password 密码
 	*/
	public function anyLogin($name,$password)
	{
		$users = user::where('name', '=' , $name)->get();
		if(($users->count() == 1 && Hash::check($password,$users[0]->password)))
		{
			$data = array(
			'id' => $users[0]->id,
			'name' => $users[0]->name,
			'password' => $users[0]->password,
			'sign' => $users[0]->sign,
			);
			return $this->toJson(self::STATS_OK,$data);
		}

		return $this->toJson(self::STATS_LOGIN_ERROR);
	}

	/** 
	 * 修改资料
	 * @param id $user_id 用户id
	 * @param string $name 用户名
	 * @param string $password 密码
	 * @param string $sign 签名
 	*/
	public function anyUpdata($user_id,$name,$password,$sign)
	{
		$user = user::find($user_id);
		$user->name = $name;
		if(strlen($password) <= 32)//hash后的密码长度超过32
		{
			$user->password = Hash::make($password);
		}
		$user->sign = $sign;
		$user->save();

		return $this->toJson(self::STATS_OK);
	}


	/** 
	 * 查询用户
	 * @param int $id 用户id
	 * 
 	*/
	public function findUser($id)
	{
		return user::find($id);
	}

	/** 
	 * 查询某用户所有发布的电影
	 * @param int $user_id 用户id
	 * 
 	*/
	public function getAllPublish($user_id)
	{
		$user = user::find($user_id);
		$publishes = $user->publish()->get();
		$data = array();
		$index = 0;
		foreach ($publishes as $publish ) 
		{
			$data[$index++] = $this->publishData($publish->topic_id,$publish->topic_content,$publish->movie_id);
		}
		return $this->toJson(self::STATS_OK,$data);
	}

	public function publishData($topic_id,$content,$movie_id)
	{
		$topic = topic::find($topic_id);
		$like = $this->likeCount($topic,$movie_id);
		$MovieController = new MovieController;
		$movie = $MovieController->findMovie($movie_id);
		$res = array(
			'like'     => $like,	
			'topic_id' => $topic_id,
			'content'  => $content,
			'movie_id' => $movie_id,
			'movie_title'  => $movie->name,	
			'movie_year'   => $movie->year,
			'movie_poster' => $movie->poster_url
		);
		return $res;
	}

	public function likeCount($topic,$movie_id)
	{
		if ($topic->movie1_id == $movie_id) 
		{
			return $topic->movie1_like;
		}
		if ($topic->movie2_id == $movie_id) 
		{
			return $topic->movie2_like;
		}
		if ($topic->movie3_id == $movie_id) 
		{
			return $topic->movie3_like;
		}
		if ($topic->movie4_id == $movie_id) 
		{
			return $topic->movie4_like;
		}
	}


	/** 
	 * 查询某用户收藏的话题
	 * @param int $user_id 用户id
	 * 
 	*/
	public function getAllCollection($user_id)
	{
		$user = user::find($user_id);
		$collections = $user->collect()->get();
		$data = array();
		$index = 0;
		foreach ($collections as $collection ) 
		{
			$data[$index++] = $this->collectData($collection->topic_id);
		}
		return $this->toJson(self::STATS_OK,$data);
	}

	public function collectData($topic_id)
	{
		$topic = topic::find($topic_id);
		$res = array(
			'topic_id'      => $topic_id,
			'topic_content' => $topic->content,
			'movie1_poster' => $this->getMovieUrl($topic->movie1_id),
			'movie2_poster' => $this->getMovieUrl($topic->movie2_id),
			'movie3_poster' => $this->getMovieUrl($topic->movie3_id),
			'movie4_poster' => $this->getMovieUrl($topic->movie4_id),
		);
		return $res;
	}

	public function getMovieUrl($movie_id)
	{
		if($movie_id == 0)
		{
			return '';
		}
		$MovieController = new MovieController;
		$movie = $MovieController->findMovie($movie_id);
		return $movie->poster_url;
	}
}
