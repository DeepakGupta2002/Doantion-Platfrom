@php
	$locationPost ??= [];
	$mapsKey = config('services.google_maps_platform.maps_javascript_api_key');
	$latValue = old('lat', data_get($locationPost, 'lat'));
	$lonValue = old('lon', data_get($locationPost, 'lon'));
	$areaValue = old('area', data_get($locationPost, 'area'));
	$sourceValue = old('location_source', data_get($locationPost, 'location_source', 'city'));
	$confirmedValue = old('location_confirmed', data_get($locationPost, 'location_confirmed', false)) ? 1 : 0;
@endphp

<div class="mb-3 col-md-8">
	<label class="form-label" for="area">Area / Locality</label>
	<input id="area"
	       name="area"
	       type="text"
	       class="form-control"
	       value="{{ $areaValue }}"
	       placeholder="Vijay Nagar, Bhawarkua, Palasia..."
	>
	<div class="form-text">Confirm the room location so nearby search and map results stay accurate.</div>
</div>

<input id="listingLat" name="lat" type="hidden" value="{{ $latValue }}">
<input id="listingLon" name="lon" type="hidden" value="{{ $lonValue }}">
<input id="listingLocationSource" name="location_source" type="hidden" value="{{ $sourceValue }}">
<input id="listingLocationConfirmed" name="location_confirmed" type="hidden" value="{{ $confirmedValue }}">

<div class="mb-3 col-md-8">
	<div class="border rounded p-3 bg-body">
		<div class="d-flex flex-column flex-sm-row gap-2 align-items-sm-center justify-content-between">
			<div>
				<div class="fw-semibold">Is this the right room location?</div>
				<div id="listingLocationStatus" class="small text-muted">
					{{ $confirmedValue ? 'Location confirmed. You can move the map pin if needed.' : 'Use your current location or drag the pin on the map.' }}
				</div>
			</div>
			<button id="useCurrentLocationBtn" type="button" class="btn btn-outline-primary btn-sm">
				<i class="bi bi-crosshair"></i> Use current location
			</button>
		</div>
		
		@if (!empty($mapsKey))
			<div id="listingLocationMap" class="mt-3 rounded border" style="height: 260px;"></div>
		@else
			<div class="alert alert-warning mt-3 mb-0 small">
				Google Maps key is missing, but location can still be captured from browser GPS.
			</div>
		@endif
	</div>
</div>

@pushonce('listing_location_confirmation_scripts')
	@if (!empty($mapsKey))
		<script src="https://maps.googleapis.com/maps/api/js?key={{ $mapsKey }}&callback=initListingLocationMap" async defer></script>
	@endif
	<script>
		(function () {
			var defaultPosition = {lat: 22.7196, lng: 75.8577};
			var latInput = document.getElementById('listingLat');
			var lonInput = document.getElementById('listingLon');
			var sourceInput = document.getElementById('listingLocationSource');
			var confirmedInput = document.getElementById('listingLocationConfirmed');
			var status = document.getElementById('listingLocationStatus');
			var button = document.getElementById('useCurrentLocationBtn');
			var map;
			var marker;
			
			function currentPosition() {
				var lat = parseFloat(latInput ? latInput.value : '');
				var lon = parseFloat(lonInput ? lonInput.value : '');
				
				if (Number.isFinite(lat) && Number.isFinite(lon)) {
					return {lat: lat, lng: lon};
				}
				
				return defaultPosition;
			}
			
			function setPosition(position, source) {
				if (!latInput || !lonInput || !sourceInput || !confirmedInput) {
					return;
				}
				
				latInput.value = position.lat.toFixed(7);
				lonInput.value = position.lng.toFixed(7);
				sourceInput.value = source || 'map';
				confirmedInput.value = '1';
				
				if (status) {
					status.textContent = 'Location confirmed: ' + latInput.value + ', ' + lonInput.value;
				}
				
				if (marker) {
					marker.setPosition(position);
				}
				if (map) {
					map.setCenter(position);
				}
			}
			
			window.initListingLocationMap = function () {
				var mapElement = document.getElementById('listingLocationMap');
				if (!mapElement || !window.google || !google.maps) {
					return;
				}
				
				map = new google.maps.Map(mapElement, {
					center: currentPosition(),
					zoom: 14,
					mapTypeControl: false,
					streetViewControl: false
				});
				
				marker = new google.maps.Marker({
					position: currentPosition(),
					map: map,
					draggable: true
				});
				
				marker.addListener('dragend', function () {
					var position = marker.getPosition();
					setPosition({lat: position.lat(), lng: position.lng()}, 'map');
				});
				
				map.addListener('click', function (event) {
					setPosition({lat: event.latLng.lat(), lng: event.latLng.lng()}, 'map');
				});
			};
			
			if (button) {
				button.addEventListener('click', function () {
					if (!navigator.geolocation) {
						if (status) status.textContent = 'Current location is not available in this browser.';
						return;
					}
					
					if (status) status.textContent = 'Checking current location...';
					
					navigator.geolocation.getCurrentPosition(function (result) {
						setPosition({
							lat: result.coords.latitude,
							lng: result.coords.longitude
						}, 'gps');
					}, function () {
						if (status) status.textContent = 'Location permission was not allowed. You can select the pin on the map.';
					}, {
						enableHighAccuracy: true,
						timeout: 10000,
						maximumAge: 60000
					});
				});
			}
		})();
	</script>
@endpushonce
