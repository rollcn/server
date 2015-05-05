<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledToVote extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vote', function(Blueprint $table)
		{
			$table->integer('topic_id')->after('id');
			$table->integer('user_id')->after('topic_id');
			$table->integer('vote_location')->after('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vote', function(Blueprint $table)
		{
			$table->dropColumn('vote_location');
			$table->dropColumn('topic_id');
			$table->dropColumn('user_id');
		});
	}

}
