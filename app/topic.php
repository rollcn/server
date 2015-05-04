<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class topic extends Model {
	protected $table = 'topics';
	protected $timestamp = true;

	public function publishes()
    {
        return $this->hasMany('App\publish');
    }
}
