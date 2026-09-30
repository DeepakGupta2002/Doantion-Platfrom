@php
	$startNowUrl = !doesGuestHaveAbilityToCreateListings() ? urlGen()->signInModal() : urlGen()->addPost();
@endphp
<div class="container mb-4">
	<div class="card bg-body-tertiary border text-secondary p-3">
		<div class="card-body text-center">
			<h3 class="fs-3 fw-bold">
				Room, PG ya flat available hai?
			</h3>
			<h5 class="fs-5 mb-4">
				Apna room list karein aur apne area me room dhoondhne walon ki help karein.
			</h5>
			<a href="{!! $startNowUrl !!}" class="btn btn-primary px-3">
				<i class="bi bi-plus-circle"></i> Apna room list karein
			</a>
		</div>
	</div>
</div>
