<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFiledToMovies extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('movies', function(Blueprint $table)
		{
			$table->string('name')->after('id');
			$table->string('description')->after('name');
			$table->string('director')->after('description');
			$table->string('cast')->after('director');
			$table->string('poster_url')->after('cast');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('movies', function(Blueprint $table)
		{
			$table->dropColumn('name');
			$table->dropColumn('description');
			$table->dropColumn('director');
			$table->dropColumn('cast');
			$table->dropColumn('poster_url');
		});
	}

}
