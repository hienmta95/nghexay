<?php

namespace App\Plugins\offlinepayment;

use App\Helpers\Number;
use App\Models\Post;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Plugins\offlinepayment\app\Mail\PaymentNotification;
use App\Plugins\offlinepayment\app\Notifications\PaymentSent;
use Illuminate\Http\Request;
use App\Helpers\Payment;
use App\Models\Package;
use App\Models\Payment as PaymentModel;
use Illuminate\Support\Facades\Mail;

class Offlinepayment extends Payment
{
	/**
	 * Send Payment
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\Post $post
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public static function sendPayment(Request $request, Post $post)
	{
		// Messages
		self::$msg['checkout']['success'] = trans('offlinepayment::messages.We have received your offline payment request.') . ' ' .
			trans('offlinepayment::messages.We will wait to receive your payment to process your request.');
		
		// Set URLs
		parent::$uri['previousUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['previousUrl']);
		parent::$uri['nextUrl'] = str_replace(['#entryToken', '#entryId', '#title'], [$post->tmp_token, $post->id, slugify($post->title)], parent::$uri['nextUrl']);
		parent::$uri['paymentCancelUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['paymentCancelUrl']);
		parent::$uri['paymentReturnUrl'] = str_replace(['#entryToken', '#entryId'], [$post->tmp_token, $post->id], parent::$uri['paymentReturnUrl']);
		
		// Get the Package
		$package = Package::find($request->input('package_id'));
		
		// Don't make a payment if 'price' = 0 or null
		if (empty($package) || $package->price <= 0) {
			if (isFromApi()) {
				return self::error(400);
			} else {
				return redirect(parent::$uri['previousUrl'] . '?error=package')->withInput();
			}
		}
		
		// API Parameters
		$params = [
			'cancelUrl'         => parent::$uri['paymentCancelUrl'],
			'returnUrl'         => parent::$uri['paymentReturnUrl'],
			'payment_method_id' => $request->input('payment_method_id'),
			'post_id'           => $post->id,
			'package_id'        => $package->id,
			'name'              => $package->name,
			'description'       => trans('offlinepayment::messages.Ad') . ' #' . $post->id . ' - ' . $package->name,
			'amount'            => Number::toFloat($package->price),
			'currency'          => $package->currency_code,
		];
		
		// Save the Payment in database
		$payment = self::register($post, $params);
		
		if (isFromApi()) {
			// Transform Entity using its Eloquent Resource
			$payment = (new \App\Plugins\api\app\Http\Resources\PaymentResource($payment))->toArray($request);
			
			$msg = self::$msg['checkout']['success'];
			return self::response($payment, $msg);
		} else {
			// Successful transaction
			flash(self::$msg['checkout']['success'])->success();
			
			// Redirect
			session()->flash('message', self::$msg['post']['success']);
			
			return redirect(self::$uri['nextUrl']);
		}
	}
	
	/**
	 * Save the payment and Send payment confirmation email
	 *
	 * @param Post $post
	 * @param $params
	 * @return PaymentModel|\Illuminate\Http\JsonResponse|null
	 */
	public static function register(Post $post, $params)
	{
		if (empty($post)) {
			return null;
		}
		
		// Update ad 'reviewed' & 'featured' fields
		$post->reviewed = ($post->reviewed == 1) ? 1 : 0;
		$post->featured = ($post->featured == 1) ? 1 : 0;
		$post->save();
		
		// Save the payment
		$paymentInfo = [
			'post_id'           => $post->id,
			'package_id'        => $params['package_id'],
			'payment_method_id' => $params['payment_method_id'],
			'transaction_id'    => (isset($params['transaction_id'])) ? $params['transaction_id'] : null,
			'active'            => 0,
		];
		$payment = new PaymentModel($paymentInfo);
		$payment->save();
		
		// SEND EMAILS
		
		// Get all admin users
		$admins = User::where('is_admin', 1)->get();
		
		// Send Payment Email Notifications
		if (config('settings.mail.payment_email_notification') == 1) {
			// Send Confirmation Email
			try {
				$post->notify(new PaymentSent($payment, $post));
			} catch (\Exception $e) {
				if (isFromApi()) {
					self::$errors[] = $e->getMessage();
					return self::error(400);
				} else {
					flash($e->getMessage())->error();
				}
			}
			
			// Send to Admin the Payment Notification Email
			try {
				if ($admins->count() > 0) {
					foreach ($admins as $admin) {
						Mail::send(new PaymentNotification($payment, $post, $admin));
					}
				}
			} catch (\Exception $e) {
				if (isFromApi()) {
					self::$errors[] = $e->getMessage();
					return self::error(400);
				} else {
					flash($e->getMessage())->error();
				}
			}
		}
		
		return $payment;
	}
	
	/**
	 * @return array
	 */
	public static function getOptions()
	{
		$options = [];
		
		$paymentMethod = PaymentMethod::active()->where('name', 'offlinepayment')->first();
		if (!empty($paymentMethod)) {
			$options[] = (object)[
				'name'     => mb_ucfirst(trans('admin::messages.settings')),
				'url'      => url(config('icetea.admin.route_prefix', 'admin') . '/payment_methods/' . $paymentMethod->id . '/edit'),
				'btnClass' => 'btn-info',
			];
		}
		
		return $options;
	}
	
	/**
	 * @return bool
	 */
	public static function installed()
	{
		$paymentMethod = PaymentMethod::active()->where('name', 'offlinepayment')->first();
		if (empty($paymentMethod)) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * @return bool
	 */
	public static function install()
	{
		// Remove the plugin entry
		self::uninstall();
		
		// Plugin data
		$data = [
			'id'                => 5,
			'name'              => 'offlinepayment',
			'display_name'      => 'Offline Payment',
			'description'       => null,
			'has_ccbox'         => 0,
			'is_compatible_api' => 1,
			'lft'               => 5,
			'rgt'               => 5,
			'depth'             => 1,
			'active'            => 1,
		];
		
		try {
			// Create plugin data
			$paymentMethod = PaymentMethod::create($data);
			if (empty($paymentMethod)) {
				return false;
			}
		} catch (\Exception $e) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * @return bool
	 */
	public static function uninstall()
	{
		$paymentMethod = PaymentMethod::where('name', 'offlinepayment')->first();
		if (!empty($paymentMethod)) {
			$deleted = $paymentMethod->delete();
			if ($deleted > 0) {
				plugin_clear_uninstall('offlinepayment');
				
				return true;
			}
		}
		
		return false;
	}
}
