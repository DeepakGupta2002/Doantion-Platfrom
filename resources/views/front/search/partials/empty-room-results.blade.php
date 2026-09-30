@php
	$searchedLocation = request()->query('location');
	$searchedLocation = is_string($searchedLocation) ? trim(rawurldecode($searchedLocation)) : null;
	$searchedKeyword = request()->query('q');
	$searchedKeyword = is_string($searchedKeyword) ? trim(rawurldecode($searchedKeyword)) : null;
	
	$emptyTitle = !empty($searchedLocation)
		? 'Abhi ' . $searchedLocation . ' me room listed nahi hai'
		: 'Abhi is search ke liye room listed nahi hai';
	
	$listRoomUrl = doesGuestHaveAbilityToCreateListings() ? urlGen()->addPost() : urlGen()->signInModal();
	$popularSearches = [
		['label' => 'PG', 'q' => 'PG'],
		['label' => '1RK', 'q' => '1RK'],
		['label' => '1BHK', 'q' => '1BHK'],
		['label' => 'Shared room', 'q' => 'shared room'],
	];
@endphp

<div class="py-5 px-3 text-center w-100">
	<div class="mx-auto" style="max-width: 720px;">
		<div class="display-6 text-primary mb-3">
			<i class="bi bi-house-add"></i>
		</div>
		<h2 class="fs-4 fw-bold mb-2">{{ $emptyTitle }}</h2>
		<p class="text-secondary mb-4">
			@if (!empty($searchedKeyword))
				"{{ $searchedKeyword }}" ke liye matching room nahi mila.
			@endif
			Agar aapke paas room, PG ya flat available hai, listing add karke dusre users ki help kar sakte hain.
		</p>
		
		<div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
			<a href="{!! $listRoomUrl !!}" class="btn btn-primary">
				<i class="bi bi-plus-circle"></i> Apna room list karein
			</a>
			<a href="{!! urlGen()->searchWithoutQuery() !!}" class="btn btn-outline-secondary">
				<i class="bi bi-search"></i> Dusra area search karein
			</a>
		</div>
		
		<div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
			@foreach ($popularSearches as $item)
				<a href="{{ urlGen()->searchWithoutQuery() }}?q={{ rawurlencode($item['q']) }}@if(!empty($searchedLocation))&location={{ rawurlencode($searchedLocation) }}@endif"
				   class="badge rounded-pill text-bg-light text-decoration-none px-3 py-2"
				>
					{{ $item['label'] }}
				</a>
			@endforeach
		</div>
	</div>
</div>
