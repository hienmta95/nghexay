<?php


namespace App\Observer;

use App\Models\Picture;
use App\Models\Article;
use App\Models\Scopes\StrictActiveScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ArticleObserver
{
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param  Article $article
	 * @return void
	 */
	public function deleting(Article $article)
	{

		// Delete all Pictures
		/*$pictures = Picture::where('article_id', $article->id)->get();
		if ($pictures->count() > 0) {
			foreach ($pictures as $picture) {
				$picture->delete();
			}
		}*/

	}

	/**
	 * Listen to the Entry saved event.
	 *
	 * @param  Article $article
	 * @return void
	 */
	public function saved(Article $article)
	{
		// Removing Entries from the Cache
		$this->clearCache($article);
	}

	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param  Article $article
	 * @return void
	 */
	public function deleted(Article $article)
	{
		// Remove the ad media folder
		if (!empty($article->country_code) && !empty($article->id)) {
			$directoryPath = 'files/article-' . strtolower($article->country_code) . '/' . $article->id;
			Storage::deleteDirectory($directoryPath);
		}

		// Removing Entries from the Cache
		$this->clearCache($article);
	}

	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $article
	 */
	private function clearCache($article)
	{
		Cache::forget($article->country_code . '.sitemaps.articles.xml');

		Cache::forget($article->country_code . '.home.getArticles.sponsored');
		Cache::forget($article->country_code . '.home.getArticles.latest');
		Cache::forget($article->country_code . '.home.getFeaturedArticlesCompanies');


	}
}
