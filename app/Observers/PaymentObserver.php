<?php


namespace App\Observer;

use App\Models\Payment;
use Illuminate\Support\Facades\Cache;

class PaymentObserver
{
	/**
	 * Listen to the Entry saved event.
	 *
	 * @param  Payment $payment
	 * @return void
	 */
	public function saved(Payment $payment)
	{
		// Removing Entries from the Cache
		$this->clearCache($payment);
	}
	
	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param  Payment $payment
	 * @return void
	 */
	public function deleted(Payment $payment)
	{
		// Removing Entries from the Cache
		$this->clearCache($payment);
	}
	
	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $payment
	 */
	private function clearCache($payment)
	{
		if (!isset($payment->post) || empty($payment->post)) {
			return;
		}
		
		$post = $payment->post;
		
		Cache::forget($post->country_code . '.sitemaps.posts.xml');
		
		Cache::forget($post->country_code . '.home.getPosts.sponsored');
		Cache::forget($post->country_code . '.home.getPosts.latest');
		Cache::forget($post->country_code . '.home.getFeaturedPostsCompanies');
		
		Cache::forget('post.withoutGlobalScopes.with.user.city.pictures.' . $post->id);
		Cache::forget('post.with.user.city.pictures.' . $post->id);
		
		Cache::forget('post.withoutGlobalScopes.with.user.city.pictures.' . $post->id . '.' . config('app.locale'));
		Cache::forget('post.with.user.city.pictures.' . $post->id . '.' . config('app.locale'));
		
		Cache::forget('posts.similar.category.' . $post->category_id . '.post.' . $post->id);
		Cache::forget('posts.similar.city.' . $post->city_id . '.post.' . $post->id);
	}
}
