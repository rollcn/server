<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledToPublish extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('publish', function(Blueprint $table)
		{
			$table->integer('topic_id')->after('id');
			$table->integer('user_id')->after('topic_id');
			$table->integer('movie_id')->after('user_id');
			$table->string('topic_content')->after('movie_id');
			$table->boolean('topic_maker')->after('topic_content');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('publish', function(Blueprint $table)
		{
			$table->dropColumn('topic_id');
			$table->dropColumn('user_id');
			$table->dropColumn('movie_id');
			$table->dropColumn('topic_content');
			$table->dropColumn('topic_maker');
		});
	}

}
