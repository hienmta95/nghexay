<?php


namespace App\Http\Controllers;

use App\Helpers\Arr;
use App\Helpers\DBTool;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Company;
use App\Models\Post;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\SubAdmin1;
use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;

class ArticleController extends FrontController
{
    /**
     * HomeController constructor.
     */
    public $categories;

    public function __construct()
    {
        parent::__construct();

        // Check Country URL for SEO
        $countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
        view()->share('countries', $countries);
    }

    /**
     * @return View
     */
    public function index()
    {
        $articles = Article::where('published', 1)->orderBy('id', 'desc')->paginate(10);
        $featuredArticles = Article::where('published', 1)->where('featured', 1)->orderBy('id', 'desc')->limit(5)->get();
        $latestArticles = Article::where('published', 1)->orderBy('id', 'desc')->limit(5)->get();
        $categories = $this->getCategories(6);
        return view('articles.index', compact('articles', 'featuredArticles','latestArticles', 'categories'));
    }

    public function category($slug)
    {
        $category = Category::trans()->where('slug', $slug)->firstOrFail();
        $articles = Article::where('published', 1)->where('category_id', $category->id)->orderBy('id', 'desc')->paginate(10);
        $featuredArticles = Article::where('published', 1)->where('featured', 1)->orderBy('id', 'desc')->limit(5)->get();
        $latestArticles = Article::where('published', 1)->orderBy('id', 'desc')->limit(5)->get();
        $categories = $this->getCategories(6);
        return view('articles.index', compact('articles', 'featuredArticles','latestArticles', 'categories', 'category'));
    }

    public function detail($slug)
    {

        $article = Article::where('published', 1)->where('slug',$slug)->firstOrFail();
        $category = Category::trans()->where('id', $article->category_id)->firstOrFail();
        $featuredArticles = Article::where('published', 1)->where('featured', 1)->orderBy('id', 'desc')->limit(5)->get();
        $latestArticles = Article::where('published', 1)->orderBy('id', 'desc')->limit(5)->get();
        $categories = $this->getCategories(6);
        return view('articles.detail', compact('article', 'featuredArticles', 'latestArticles','categories', 'category'));
    }

    /**
     * Get list of categories
     *
     * @param array $value
     */
    private function getCategories($maxItems = 12)
    {

        // Get the Default Cache delay expiration
        $cacheExpiration = $this->getCacheExpirationTime(60);

        $cacheId = 'categories.parents.' . config('app.locale') . '.take.' . $maxItems;


        $categories = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
            $categories = Category::trans()->where('parent_id', 0)->take($maxItems)->orderBy('lft')->get();

            return $categories;
        });

        return $categories;


    }

    public function getArticle($slug)
    {

        $article = Article::where('slug', $slug)->where('published', 1)->firstOrFail();
        $categories = $this->getCategories(6);
        return view('articles.detail', compact('article', 'categories'));
    }

    /**
     * @param int $limit
     * @param string $type (latest OR featured)
     * @param int $cacheExpiration
     * @return mixed
     */
    private function getArticles($limit = 20, $type = 'latest', $cacheExpiration = 0)
    {

        $sponsoredOrder = '';

        $publishedCondition = 'AND a.reviewed = 1';

        $sql = 'SELECT DISTINCT a.*' . '
                FROM ' . DBTool::table('articles') . ' as a
                INNER JOIN ' . DBTool::table('article_categories') . ' as c ON c.id=a.category_id AND c.active=1                
                WHERE a.country_code = :countryCode
                GROUP BY a.id 
                ORDER BY a.created_at DESC
                LIMIT 0,' . (int)$limit;
        $bindings = [
            'countryCode' => config('country.code'),
        ];

        $cacheId = config('country.code') . '.home.getArticles.' . $type;
        $posts = Cache::remember($cacheId, $cacheExpiration, function () use ($sql, $bindings) {
            $posts = DB::select(DB::raw($sql), $bindings);

            return $posts;
        });

        // Append the Posts 'uri' attribute
        $posts = collect($posts)->map(function ($post) {
            $post->title = mb_ucfirst($post->title);
            $post->uri = trans('routes.v-post', ['slug' => slugify($post->title), 'id' => $post->id]);

            return $post;
        })->toArray();

        return $posts;
    }

    /**
     * @param array $value
     * @return int
     */
    private function getCacheExpirationTime($value = [])
    {
        // Get the default Cache Expiration Time
        $cacheExpiration = 0;
        if (isset($value['cache_expiration'])) {
            $cacheExpiration = (int)$value['cache_expiration'];
        }

        return $cacheExpiration;
    }
}
