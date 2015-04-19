<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledToTopicCollection extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('t_collection', function(Blueprint $table)
		{
			$table->integer('user_id')->after('tcollection_id');
			$table->integer('topic_id')->after('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('t_collection', function(Blueprint $table)
		{
			$table->dropColumn('user_id');
			$table->dropColumn('topic_id');
		});
	}

}
