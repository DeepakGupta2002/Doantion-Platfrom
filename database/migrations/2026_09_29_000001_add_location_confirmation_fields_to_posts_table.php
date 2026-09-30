<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::table('posts', function (Blueprint $table) {
			if (!Schema::hasColumn('posts', 'area')) {
				$table->string('area', 191)->nullable()->after('address');
				$table->index('area');
			}
			
			if (!Schema::hasColumn('posts', 'location_source')) {
				$table->string('location_source', 30)->nullable()->default('city')->after('lat');
			}
			
			if (!Schema::hasColumn('posts', 'location_confirmed')) {
				$table->boolean('location_confirmed')->default(false)->after('location_source');
				$table->index('location_confirmed');
			}
			
			if (!Schema::hasColumn('posts', 'location_verified_at')) {
				$table->timestamp('location_verified_at')->nullable()->after('location_confirmed');
			}
		});
	}
	
	public function down(): void
	{
		Schema::table('posts', function (Blueprint $table) {
			if (Schema::hasColumn('posts', 'area')) {
				$table->dropIndex(['area']);
			}
			if (Schema::hasColumn('posts', 'location_confirmed')) {
				$table->dropIndex(['location_confirmed']);
			}
			
			$columns = array_values(array_filter([
				Schema::hasColumn('posts', 'area') ? 'area' : null,
				Schema::hasColumn('posts', 'location_source') ? 'location_source' : null,
				Schema::hasColumn('posts', 'location_confirmed') ? 'location_confirmed' : null,
				Schema::hasColumn('posts', 'location_verified_at') ? 'location_verified_at' : null,
			]));
			
			if (!empty($columns)) {
				$table->dropColumn($columns);
			}
		});
	}
};
