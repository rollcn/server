<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMakeridToTopics extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('topics', function(Blueprint $table)
		{
			$table->integer('movie1_user_id')->after('movie1_id');
			$table->integer('movie2_user_id')->after('movie2_id');
			$table->integer('movie3_user_id')->after('movie3_id');
			$table->integer('movie4_user_id')->after('movie4_id');
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
			$table->dropColumn('movie1_user_id');
			$table->dropColumn('movie2_user_id');
			$table->dropColumn('movie3_user_id');
			$table->dropColumn('movie4_user_id');
		});
	}

}
