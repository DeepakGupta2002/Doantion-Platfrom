<?php

namespace App\Services\Post;

use App\Models\City;
use App\Models\Post;
use Illuminate\Http\Request;

trait LocationConfirmationTrait
{
	protected function applyLocationConfirmation(Post $post, City $city, Request $request): void
	{
		$lat = $request->input('lat');
		$lon = $request->input('lon');
		$hasConfirmedLocation = $request->boolean('location_confirmed')
			&& is_numeric($lat)
			&& is_numeric($lon);
		
		$post->lat = $hasConfirmedLocation ? (float)$lat : $city->latitude;
		$post->lon = $hasConfirmedLocation ? (float)$lon : $city->longitude;
		
		$post->area = $request->input('area') ?: null;
		$post->location_source = $hasConfirmedLocation
			? $request->input('location_source', 'gps')
			: 'city';
		$post->location_confirmed = $hasConfirmedLocation;
		$post->location_verified_at = $hasConfirmedLocation ? now() : null;
	}
}
