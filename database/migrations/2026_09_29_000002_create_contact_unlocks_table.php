<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('contact_unlocks', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('user_id')->unsigned();
			$table->bigInteger('post_id')->unsigned();
			$table->decimal('donation_amount', 10, 2)->nullable();
			$table->string('donation_status', 30)->default('pledged');
			$table->timestamp('unlocked_at')->nullable();
			$table->timestamps();
			
			$table->unique(['user_id', 'post_id']);
			$table->index(['post_id']);
			$table->index(['donation_status']);
			$table->index(['unlocked_at']);
		});
	}
	
	public function down(): void
	{
		Schema::dropIfExists('contact_unlocks');
	}
};
