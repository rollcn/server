<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledToTopiccomment extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t_comments', function(Blueprint $table)
		{
			$table->integer('topic_id')->after('tcomment_id');
			$table->integer('user_id')->after('topic_id');
			$table->string('content')->after('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('t_comments', function(Blueprint $table)
		{
			$table->dropColumn('topic_id');
			$table->dropColumn('user_id');
			$table->dropColumn('content');
		});
	}

}
