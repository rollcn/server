<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLikecountToTopic extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('topics', function(Blueprint $table)
		{
			$table->integer('movie1_like')->after('movie1_id');
			$table->integer('movie2_like')->after('movie2_id');
			$table->integer('movie3_like')->after('movie3_id');
			$table->integer('movie4_like')->after('movie4_id');
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
			$table->dropColumn('movie1_like');
			$table->dropColumn('movie2_like');
			$table->dropColumn('movie3_like');
			$table->dropColumn('movie4_like');
		});
	}

}
