<?php namespace App\Http\Controllers;

class BaseFuncController extends Controller{

	//错误码
	const STATS_OK 			 = 200;//操作成功
	const STATS_FIND_FAILED  = 401;//第三方搜索失败
	const STATS_ALREADY_HAVE = 402;//请求项已存在
	const STATS_NO_ITEM 	 = 403;//无对应项
	const STATS_NO_SPACE 	 = 405;//无创建空间
	const STATS_ALREADY_ADD  = 406;//已经创建过了
	const STATS_LOGIN_ERROR  = 407;//登陆错误

	protected static $Message = [
						self::STATS_OK           =>	'成功',
						self::STATS_FIND_FAILED  => '第三方搜索失败',
						self::STATS_ALREADY_HAVE => '请求项已存在',
						self::STATS_NO_ITEM 	 => '无对应项',
						self::STATS_NO_SPACE 	 => '无创建空间',
						self::STATS_ALREADY_ADD  => '已经创建过了',
						self::STATS_LOGIN_ERROR  => '登录失败',
	];


	public function toJson($code,$data = array())
	{
		if(!is_numeric($code))
		{
			return '';
		}

		$str = array(
			'code' 	  => $code,
			'message' => self::$Message[$code],
			'data'    => $data
		);

		$res = json_encode($str);
		return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function( '$matches', 'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'), $res);
	}

	/** 
	 * 发送post请求
	 * @param string $url 请求地址
	 * @param array $post_data post键值对数据
	 * @param string $method 请求方法
	 * @return string
 	*/
	public function HttpSend($url, $method)
	 {
		//$postdata = http_build_query($post_data);
		$options = array(
			'http' => array(
			'method' => $method,
			'header' => 'Content-type:application/x-www-form-urlencoded',
			//'content' => $postdata,
			'timeout' => 15 * 60 // 超时时间（单位:s）
			)
		);
		$context = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		return $result;
	}
	
	/*public function fetch_page($site,$url,$params=false)
	{
	    $ch = curl_init();
	    $cookieFile = $site . '_cookiejar.txt';
	    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
	    curl_setopt($ch, CURLOPT_COOKIEFILE,$cookieFile);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch,   CURLOPT_SSL_VERIFYPEER,   FALSE);
	    curl_setopt($ch, CURLOPT_HTTPGET, true);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 4);
	    if($params)
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
	    curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3');
	    curl_setopt($ch, CURLOPT_URL,$url);

	    $result = curl_exec($ch);
	    //file_put_contents('jobs.html',$result);
	    return $result;
	}*/
}