<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledToTopics extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('topics', function(Blueprint $table)
		{
			$table->string('content')->after('topic_id');
			$table->integer('like')->after('content');
			$table->integer('movie1_id')->after('like');
			$table->integer('movie2_id')->after('movie1_id');
			$table->integer('movie3_id')->after('movie2_id');
			$table->integer('movie4_id')->after('movie3_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('topics', function(Blueprint $table)
		{
			$table->dropColumn('content');
			$table->dropColumn('like');
			$table->dropColumn('movie1_id');
			$table->dropColumn('movie2_id');
			$table->dropColumn('movie3_id');
			$table->dropColumn('movie4_id');
		});
	}

}
