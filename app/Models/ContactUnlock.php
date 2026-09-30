<?php

namespace App\Models;

use App\Casts\NullableDateTimeCast;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactUnlock extends BaseModel
{
	protected $table = 'contact_unlocks';
	
	protected $fillable = [
		'user_id',
		'post_id',
		'donation_amount',
		'donation_status',
		'unlocked_at',
	];
	
	protected function casts(): array
	{
		return [
			'donation_amount' => 'decimal:2',
			'unlocked_at'     => NullableDateTimeCast::class,
		];
	}
	
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class, 'user_id');
	}
	
	public function post(): BelongsTo
	{
		return $this->belongsTo(Post::class, 'post_id');
	}
}
