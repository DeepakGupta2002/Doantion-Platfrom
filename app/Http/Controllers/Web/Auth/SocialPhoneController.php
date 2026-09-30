<?php
/*
 * LaraClassifier - Classified Ads Web Application
 * Copyright (c) BeDigit. All Rights Reserved.
 */

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Web\Front\FrontController;
use App\Models\Scopes\VerifiedScope;
use App\Models\User;
use App\Services\VerificationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Larapen\LaravelMetaTags\Facades\MetaTag;

class SocialPhoneController extends FrontController
{
	public function showForm(): View|RedirectResponse
	{
		$user = auth(getAuthGuard())->user();
		if (empty($user)) {
			return redirect()->to(urlGen()->signIn());
		}
		
		if (!empty($user->phone) && !empty($user->phone_verified_at)) {
			return redirect()->intended(urlGen()->accountOverview());
		}
		
		MetaTag::set('title', 'Verify your phone number');
		MetaTag::set('description', 'Add and verify your phone number to continue.');
		
		$coverTitle = 'One last step';
		$coverDescription = 'Add your phone number so contacts and room listings stay trustworthy.';
		
		return view('auth.social-phone', compact('coverTitle', 'coverDescription', 'user'));
	}
	
	public function submit(Request $request): RedirectResponse
	{
		$authUser = auth(getAuthGuard())->user();
		if (empty($authUser)) {
			return redirect()->to(urlGen()->signIn());
		}
		
		$validator = Validator::make($request->all(), [
			'phone'         => ['required', 'string', 'min:6', 'max:30'],
			'phone_country' => ['required', 'string', 'size:2'],
		]);
		
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}
		
		$user = User::query()
			->withoutGlobalScopes([VerifiedScope::class])
			->where('id', $authUser->id)
			->first();
		
		if (empty($user)) {
			return redirect()->to(urlGen()->signIn());
		}
		
		$user->phone = $request->input('phone');
		$user->phone_country = strtoupper($request->input('phone_country'));
		$user->auth_field = $user->auth_field ?: 'email';
		$user->phone_verified_at = null;
		$user->phone_token = null;
		$user->save();
		
		$data = getServiceData((new VerificationService())->resendPhoneVerification('users', $user->id));
		$message = data_get($data, 'message');
		
		if (!data_get($data, 'success')) {
			flash($message ?: trans('auth.unknown_error'))->error();
			
			return redirect()->back()->withInput();
		}
		
		$resendPhoneVerificationData = data_get($data, 'extra');
		session()->put('resendPhoneVerificationData', collect($resendPhoneVerificationData)->toJson());
		session()->put('userNextUrl', session('url.intended', urlGen()->accountOverview()));
		
		if (!empty($message)) {
			flash($message)->success();
		}
		
		return redirect()->to(urlGen()->phoneVerification('users'));
	}
}
