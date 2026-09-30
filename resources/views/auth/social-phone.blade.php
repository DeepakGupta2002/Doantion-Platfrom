@extends('auth.layouts.master')

@section('content')
	<div class="col-11 col-sm-11 col-md-10 col-lg-9 col-xl-8 mx-auto">
		<h3 class="fw-600 mb-4">Verify your phone number</h3>
		
		<p class="text-muted mb-4">
			Google sign-in is ready. Add your phone number once so room contacts and listings stay trustworthy.
		</p>
		
		<form id="socialPhoneForm" action="{{ route('auth.social.phone.submit') }}" method="post" role="form">
			@csrf
			@honeypot
			
			@include('helpers.forms.fields.intl-tel-input', [
				'label'       => trans('auth.phone_number'),
				'id'          => 'phone',
				'name'        => 'phone',
				'required'    => true,
				'placeholder' => null,
				'value'       => old('phone', $user->phone ?? null),
				'countryCode' => old('phone_country', $user->phone_country ?? config('country.code', 'IN')),
			])
			
			<div class="d-grid my-4">
				<button type="submit" id="socialPhoneBtn" class="btn btn-primary btn-lg btn-block">
					Send verification code
				</button>
			</div>
		</form>
		
		<p class="text-center text-muted">
			<a href="{{ urlGen()->signIn() }}">{{ trans('auth.back_to_login') }}</a>
		</p>
	</div>
@endsection
