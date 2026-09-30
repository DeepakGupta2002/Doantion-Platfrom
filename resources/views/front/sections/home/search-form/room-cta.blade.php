@php
	$popularRoomSearches = [
		['label' => 'PG near me', 'q' => 'PG'],
		['label' => '1RK', 'q' => '1RK'],
		['label' => '1BHK', 'q' => '1BHK'],
		['label' => 'Shared room', 'q' => 'shared room'],
		['label' => 'Under budget', 'q' => 'budget room'],
	];
@endphp

<div class="room-home-actions mt-3">
	<div class="d-flex flex-wrap justify-content-center gap-2">
		<button id="nearMeRoomSearch" type="button" class="btn btn-light btn-sm">
			<i class="bi bi-crosshair"></i> Mere paas ke rooms
		</button>
		<a href="{{ url('create') }}" class="btn btn-success btn-sm">
			<i class="bi bi-plus-circle"></i> Apna room list karein
		</a>
	</div>
	
	<div class="d-flex flex-wrap justify-content-center gap-2 mt-3">
		@foreach ($popularRoomSearches as $item)
			<a class="badge rounded-pill text-bg-light text-decoration-none px-3 py-2"
			   href="{{ urlGen()->searchWithoutQuery() }}?q={{ rawurlencode($item['q']) }}"
			>
				{{ $item['label'] }}
			</a>
		@endforeach
	</div>
	
	<div class="small text-white text-shadow mt-3">
		Area me room nahi mila? Search results par empty message ke saath listing add karne ka option milega.
	</div>
</div>

@pushonce('room_home_search_scripts')
	<script>
		onDocumentReady(() => {
			const nearMeBtn = document.getElementById('nearMeRoomSearch');
			if (!nearMeBtn) return;
			
			nearMeBtn.addEventListener('click', () => {
				const form = document.getElementById('searchForm');
				const locationInput = document.getElementById('locSearch');
				
				if (!navigator.geolocation) {
					if (locationInput) {
						locationInput.focus();
						locationInput.placeholder = 'Apna city ya area type karein';
					}
					return;
				}
				
				nearMeBtn.disabled = true;
				nearMeBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Location...';
				
				navigator.geolocation.getCurrentPosition((position) => {
					const latInput = document.createElement('input');
					const lonInput = document.createElement('input');
					latInput.type = 'hidden';
					lonInput.type = 'hidden';
					latInput.name = 'lat';
					lonInput.name = 'lon';
					latInput.value = position.coords.latitude.toFixed(7);
					lonInput.value = position.coords.longitude.toFixed(7);
					form.appendChild(latInput);
					form.appendChild(lonInput);
					form.submit();
				}, () => {
					nearMeBtn.disabled = false;
					nearMeBtn.innerHTML = '<i class="bi bi-crosshair"></i> Mere paas ke rooms';
					if (locationInput) {
						locationInput.focus();
						locationInput.placeholder = 'Location permission nahi mili, city ya area type karein';
					}
				}, {
					enableHighAccuracy: true,
					timeout: 10000,
					maximumAge: 60000
				});
			});
		});
	</script>
@endpushonce
