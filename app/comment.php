<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model {

	protected $table = 't_comments';
	protected $timestamp = true;

	public function user()
    {
        return $this->belongsTo('App\user');
    }

}
