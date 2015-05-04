<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLikecountToPublish extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('publish', function(Blueprint $table)
		{
			$table->integer('like_count')->after('topic_maker');
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
			$table->dropColumn('like_count');
		});
	}

}
