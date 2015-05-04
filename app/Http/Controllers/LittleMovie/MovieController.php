<?php namespace App\Http\Controllers\LittleMovie;

use App\Http\Requests;
use App\Http\Controllers\BaseFuncController;

use Illuminate\Http\Request;
use App\movie;

class MovieController extends BaseFuncController {

	/** 
	 * 本地库中查找电影
	 * @param int $id 
	 * 
 	*/
	public function findMovieInDb($id)
	{
		if (Movie::find($id) !== null)
		{
			/*已入库则返回*/			
			return 200;
		}
		else
		{
			/*访问豆瓣搜索电影api，得到电影信息入库*/
			$msg = 0;	//标记访问情况
			$result = $this->HttpSend('http://api.douban.com/v2/movie/subject/'.$id.'?apikey=043b351015b71b4d0cb19f30412551e7','GET');
			//var_dump($result);
			if($result !== null)
			{
				$array = json_decode($result,true);   //把得到json数据转换成array
				$msg = 200;		//访问正常

				$casts = $this->getAllNames($array['casts']);
				$directors = $this->getAllNames($array['directors']);	//拼接演员名和导演名

				$this->saveMovie($id,$array['title'],$array['summary'],$array['year'],$casts,$directors,$array['images']['medium']);	//电影信息入库
				//var_dump($array['rating']['max']);
			}
			else
			{	
				$msg = 401;		//未得到电影数据
			}
			return $msg;
		}
	}

	/** 
	 * 拼接名字
	 * @param array[][] $array 
	 * 
 	*/
	public function getAllNames($array)
	{
		$name = '';
		foreach ($array as $key)
		{
			$name = $name.$key['name'].'/';
		}
		return $name;
	}

	/** 
	 * 电影入本地库
	 * @param int $id 豆瓣电影id
	 * @param string $title 名字
	 * @param string $summary 简介
	 * @param int $year 年份
	 * @param string $casts 演员表
	 * @param string $directors 导演
	 * @param string $poster_url 图片地址
	 * 
 	*/
	public function saveMovie($id,$title,$summary,$year,$casts,$directors,$poster_url)
	{
		$movie = new movie;
		$movie->id = $id;
		$movie->name = $title;
		$movie->description = $summary;
		$movie->cast = $casts;
		$movie->year = $year;
		$movie->director = $directors;
		$movie->poster_url = $poster_url;

		$movie->save();
	}

	/** 
	 * 查询电影
	 * @param int $id 电影id
	 * 
 	*/
	public function findMovie($id)
	{
		return movie::find($id);
	}
}
