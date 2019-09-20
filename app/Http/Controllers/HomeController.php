<?php


namespace App\Http\Controllers;

use App\Helpers\Arr;
use App\Helpers\DBTool;
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

class HomeController extends FrontController
//class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
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
        $data = [];
        $countryCode = config('country.code');

        // Get all homepage sections
        $cacheId = $countryCode . '.homeSections';

        $data['sections'] = Cache::remember($cacheId, $this->cacheExpiration, function () use ($countryCode) {
            $sections = collect([]);

            // Check if the Domain Mapping plugin is available
            if (config('plugins.domainmapping.installed')) {
                try {
                    $sections = \App\Plugins\domainmapping\app\Models\DomainHomeSection::where('country_code', $countryCode)->orderBy('lft')->get();
                } catch (\Exception $e) {
                }
            }

            // Get the entry from the core
            if ($sections->count() <= 0) {
                $sections = HomeSection::orderBy('lft')->get();
            }

            return $sections;
        });


        if (isset($data['sections']) && $data['sections']->count() > 0) {
            foreach ($data['sections'] as $section) {
                // Clear method name
                $method = str_replace(strtolower($countryCode) . '_', '', $section->method);

                // Check if method exists
                if (!method_exists($this, $method)) {
                    continue;
                }

                // Call the method
                try {
                    if (isset($section->value)) {
                        $this->{$method}($section->value);
                    } else {
                        $this->{$method}();
                    }
                } catch (\Exception $e) {
                    flash($e->getMessage())->error();
                    continue;
                }
            }
        }

        // Get SEO
        $this->setSeo();

        $data['cities'] = City::currentCountry()->where('feature_class','P')->orderBy('sort', 'desc')->orderBy('name')->get();

        $data['homepage'] = 1;
        return view('AAAAAAAA.home.index', $data);
    }


    public function getEmployerLanding()
    {
        return \view('employer.landing');
    }


    public function getEmployerPricing()
    {
        return \view('employer.pricing');
    }

    /**
     * Get search form (Always in Top)
     *
     * @param array $value
     */
    protected function getSearchForm($value = [])
    {
        view()->share('searchFormOptions', $value);
    }

    /**
     * Get locations & SVG map
     *
     * @param array $value
     */
    protected function getLocations($value = [])
    {
        // Get the default Max. Items
        $maxItems = 14;
        if (isset($value['max_items'])) {
            $maxItems = (int)$value['max_items'];
        }

        // Get the Default Cache delay expiration
        $cacheExpiration = $this->getCacheExpirationTime($value);

        // Modal - States Collection
        $cacheId = config('country.code') . '.home.getLocations.modalAdmins';
        $modalAdmins = Cache::remember($cacheId, $cacheExpiration, function () {
            $modalAdmins = SubAdmin1::currentCountry()->orderBy('name')->get(['code', 'name'])->keyBy('code');

            return $modalAdmins;
        });
        view()->share('modalAdmins', $modalAdmins);

        // Get cities
        $cacheId = config('country.code') . 'home.getLocations.cities';
        $cities = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
            $cities = City::currentCountry()->take($maxItems)->orderBy('sort', 'desc')->orderBy('name')->get();

            return $cities;
        });
        $cities = collect($cities)->push(Arr::toObject([
            'id' => 999999999,
            'name' => t('More cities') . ' &raquo;',
            'subadmin1_code' => 0,
        ]));

        // Get cities number of columns
        $nbCol = 4;
        if (file_exists(config('icetea.core.maps.path') . strtolower(config('country.code')) . '.svg')) {
            if (isset($value['show_map']) && $value['show_map'] == '1') {
                $nbCol = (isset($value['items_cols']) && !empty($value['items_cols'])) ? (int)$value['items_cols'] : 3;
            }
        }

        // Chunk
        $cols = round($cities->count() / $nbCol, 0); // PHP_ROUND_HALF_EVEN
        $cols = ($cols > 0) ? $cols : 1; // Fix array_chunk with 0
        $cities = $cities->chunk($cols);

        view()->share('cities', $cities);
        view()->share('citiesOptions', $value);
    }

    /**
     * Get sponsored posts
     *
     * @param array $value
     */
    protected function getSponsoredPosts($value = [])
    {
        // Get the default Max. Items
        $maxItems = 20;
        if (isset($value['max_items'])) {
            $maxItems = (int)$value['max_items'];
        }

        // Get the default orderBy value
        $orderBy = 'random';
        if (isset($value['order_by'])) {
            $orderBy = $value['order_by'];
        }

        // Get the Default Cache delay expiration
        $cacheExpiration = $this->getCacheExpirationTime($value);

        $sponsored = null;

        // Get Posts
        $posts = $this->getPosts($maxItems, 'sponsored', $cacheExpiration);

        if (!empty($posts)) {
            if ($orderBy == 'random') {
                shuffle($posts);
            }
            $attr = ['countryCode' => config('country.icode')];
            $sponsored = [
                'title' => t('Home - Sponsored Jobs'),
                'link' => lurl(trans('routes.v-search', $attr), $attr),
                'posts' => $posts,
            ];
            $sponsored = Arr::toObject($sponsored);
        }

        view()->share('featured', $sponsored);
        view()->share('featuredOptions', $value);
    }

    /**
     * Get latest posts
     *
     * @param array $value
     */
    protected function getLatestPosts($value = [])
    {
        // Get the default Max. Items
        $maxItems = 5;
        if (isset($value['max_items'])) {
            $maxItems = (int)$value['max_items'];
        }

        // Get the default orderBy value
        $orderBy = 'date';
        if (isset($value['order_by'])) {
            $orderBy = $value['order_by'];
        }

        // Get the Default Cache delay expiration
        $cacheExpiration = $this->getCacheExpirationTime($value);

        $latest = null;

        // Get Posts
        $posts = $this->getPosts($maxItems, 'sponsored', $cacheExpiration);

        if (!empty($posts)) {
            if ($orderBy == 'random') {
                $posts = Arr::shuffle($posts);
            }
            $attr = ['countryCode' => config('country.icode')];
            $latest = [
                'title' => t('Home - Latest Jobs'),
                'link' => lurl(trans('routes.v-search', $attr), $attr),
                'posts' => $posts,
            ];
            $latest = Arr::toObject($latest);
        }

        $this->getFeaturedCompanies([
            'max_items' => 8,
            'order_by' => 'date'
        ]);


        $vipJobs = Post::where('archived',0)->where('vip',1)->orderBy('updated_at','desc')->limit(48)->get();

        view()->share('latest', $latest);
        view()->share('vipJobs', $vipJobs);
        view()->share('latestOptions', $value);
    }


    /**
     * Get latest posts
     *
     * @param array $value
     */
    protected function getLatestArticles($value = [])
    {
        // Get the default Max. Items
        $maxItems = 4;
        if (isset($value['max_items'])) {
            $maxItems = (int)$value['max_items'];
        }

        // Get the default orderBy value
        $orderBy = 'date';
        if (isset($value['order_by'])) {
            $orderBy = $value['order_by'];
        }

        // Get the Default Cache delay expiration
        $cacheExpiration = $this->getCacheExpirationTime($value);

        $latest = null;

        // Get Posts
        $posts = $this->getArticles($maxItems, 'latest', $cacheExpiration);

        if (!empty($posts)) {
            if ($orderBy == 'random') {
                $posts = Arr::shuffle($posts);
            }
            $attr = ['countryCode' => config('country.icode')];
            $latest = [
                'title' => t('Home - Latest Articles'),
                'link' => lurl(trans('routes.v-articles', $attr), $attr),
                //'link' => '',
                'posts' => $posts,
            ];
            $latest = Arr::toObject($latest);
        }


        view()->share('latestArticles', $latest);
        view()->share('latestArticlesOptions', $value);
    }

    /**
     * Get featured ads companies
     *
     * @param array $value
     */
    private function getFeaturedCompanies($value = [])
    {
        // Get the default Max. Items
        $maxItems = 12;
        if (isset($value['max_items'])) {
            $maxItems = (int)$value['max_items'];
        }

        // Get the default orderBy value
        $orderBy = 'random';
        if (isset($value['order_by'])) {
            $orderBy = $value['order_by'];
        }

        // Get the Default Cache delay expiration
        $cacheExpiration = $this->getCacheExpirationTime($value);

        $featuredCompanies = null;

        // Get all Companies
        $cacheId = config('country.code') . '.home.getFeaturedPostsCompanies.take.limit.x';
        $companies = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
            $companies = Company::where('featured',1)
                ->take($maxItems)
                ->orderByDesc('id')
                ->get();

            return $companies;
        });

        if ($companies->count() > 0) {
            if ($orderBy == 'random') {
                $companies = $companies->shuffle();
            }
            $attr = ['countryCode' => config('country.icode')];
            $featuredCompanies = [
                'title' => t('Home - Featured Companies'),
                'link' => lurl(trans('routes.v-companies-list', $attr), $attr),
                'companies' => $companies,
            ];
            $featuredCompanies = Arr::toObject($featuredCompanies);
        }


        return [
            'featuredCompanies' => $featuredCompanies,
            'featuredCompaniesOptions' => $value
        ];
    }



    /**
     * Get featured ads companies
     *
     * @param array $value
     */
    private function getFeaturedPostsCompanies($value = [])
    {
        // Get the default Max. Items
        $maxItems = 12;
        if (isset($value['max_items'])) {
            $maxItems = (int)$value['max_items'];
        }

        // Get the default orderBy value
        $orderBy = 'random';
        if (isset($value['order_by'])) {
            $orderBy = $value['order_by'];
        }

        // Get the Default Cache delay expiration
        $cacheExpiration = $this->getCacheExpirationTime($value);

        $featuredCompanies = null;

        // Get all Companies
        $cacheId = config('country.code') . '.home.getFeaturedPostsCompanies.take.limit.x';
        $companies = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
            $companies = Company::where('featured',1)->take($maxItems)
                ->orderByDesc('id')
                ->get();

            return $companies;
        });

        if ($companies->count() > 0) {
            if ($orderBy == 'random') {
                $companies = $companies->shuffle();
            }
            $attr = ['countryCode' => config('country.icode')];
            $featuredCompanies = [
                'title' => t('Home - Featured Companies'),
                'link' => lurl(trans('routes.v-companies-list', $attr), $attr),
                'companies' => $companies,
            ];
            $featuredCompanies = Arr::toObject($featuredCompanies);
        }

        view()->share('featuredCompanies', $featuredCompanies);
        view()->share('featuredCompaniesOptions', $value);
    }

    /**
     * Get list of categories
     *
     * @param array $value
     */
    protected function getCategories($value = [])
    {
        // Get the default Max. Items
        $maxItems = 12;
        if (isset($value['max_items'])) {
            $maxItems = (int)$value['max_items'];
        }

        // Get the Default Cache delay expiration
        $cacheExpiration = $this->getCacheExpirationTime($value);

        $cacheId = 'categories.parents.' . config('app.locale') . '.take.' . $maxItems;

        if (isset($value['type_of_display']) && in_array($value['type_of_display'], ['cc_normal_list', 'cc_normal_list_s'])) {

            $categories = Cache::remember($cacheId, $cacheExpiration, function () {
                $categories = Category::trans()->orderBy('lft')->get();

                return $categories;
            });
            $categories = collect($categories)->keyBy('translation_of');
            $categories = $subCategories = $categories->groupBy('parent_id');

            if ($categories->has(0)) {
                $cols = round($categories->get(0)->count() / 3, 0, PHP_ROUND_HALF_EVEN);
                $cols = ($cols > 0) ? $cols : 1;
                $categories = $categories->get(0)->chunk($cols);
                $subCategories = $subCategories->forget(0);
            } else {
                $categories = collect([]);
                $subCategories = collect([]);
            }

            $categories = $categories->take($maxItems);

            view()->share('categories', $categories);
            view()->share('subCategories', $subCategories);

        } else {

            $categories = Cache::remember($cacheId, $cacheExpiration, function () use ($maxItems) {
                $categories = Category::trans()->where('parent_id', 0)->take($maxItems)->orderBy('lft')->get();

                return $categories;
            });

            if (isset($value['type_of_display']) && $value['type_of_display'] == 'c_picture_icon') {
                $categories = collect($categories)->keyBy('id');
            } else {
                $cols = round($categories->count() / 3, 0); // PHP_ROUND_HALF_EVEN
                $cols = ($cols > 0) ? $cols : 1; // Fix array_chunk with 0
                $categories = $categories->chunk($cols);
            }

            view()->share('categories', $categories);

        }

        view()->share('categoriesOptions', $value);
    }

    /**
     * Get mini stats data
     */
    protected function getStats()
    {
        // Count posts
        $countPosts = Post::currentCountry()->unarchived()->count();

        // Count cities
        $countCities = City::currentCountry()->count();

        // Count users
        $countUsers = User::count();

        // Share vars
        view()->share('countPosts', $countPosts);
        view()->share('countCities', $countCities);
        view()->share('countUsers', $countUsers);
    }

    /**
     * Set SEO information
     */
    protected function setSeo()
    {
        $title = getMetaTag('title', 'home');
        $description = getMetaTag('description', 'home');
        $keywords = getMetaTag('keywords', 'home');

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);

        // Open Graph
        $this->og->title($title)->description($description);
        view()->share('og', $this->og);
    }

    /**
     * @param int $limit
     * @param string $type (latest OR featured)
     * @param int $cacheExpiration
     * @return mixed
     */
    private function getPosts($limit = 20, $type = 'latest', $cacheExpiration = 0)
    {
        $paymentJoin = '';
        $sponsoredCondition = '';
        $sponsoredOrder = '';
        if ($type == 'sponsored') {
            /*$paymentJoin .= 'INNER JOIN ' . DBTool::table('payments') . ' as py ON py.post_id=a.id AND py.active=1' . "\n";
            $paymentJoin .= 'INNER JOIN ' . DBTool::table('packages') . ' as p ON p.id=py.package_id' . "\n";*/
            $sponsoredCondition = ' AND a.featured = 1';
            //$sponsoredOrder = 'p.lft DESC, ';
        } else {
            // $paymentJoin .= 'LEFT JOIN ' . DBTool::table('payments') . ' as py ON py.post_id=a.id AND py.active=1' . "\n";
            $paymentJoin .= 'LEFT JOIN (SELECT MAX(id) max_id, post_id FROM ' . DBTool::table('payments') . ' WHERE active=1 GROUP BY post_id) mpy ON mpy.post_id = a.id AND a.featured=1' . "\n";
            $paymentJoin .= 'LEFT JOIN ' . DBTool::table('payments') . ' as py ON py.id=mpy.max_id' . "\n";
            $paymentJoin .= 'LEFT JOIN ' . DBTool::table('packages') . ' as p ON p.id=py.package_id' . "\n";
        }
        $reviewedCondition = '';
        if (config('settings.single.posts_review_activation')) {
            $reviewedCondition = ' AND a.reviewed = 1';
        }
        //$sql = 'SELECT DISTINCT a.*,ct.name as city_name, py.package_id as py_package_id' . '
        $sql = 'SELECT DISTINCT a.*,ct.name as city_name' . '
                FROM ' . DBTool::table('posts') . ' as a
                INNER JOIN ' . DBTool::table('categories') . ' as c ON c.id=a.category_id AND c.active=1
                INNER JOIN ' . DBTool::table('cities') . ' as ct ON ct.id=a.city_id 
                ' . $paymentJoin . '
                WHERE a.country_code = :countryCode
                	AND (a.verified_email=1 AND a.verified_phone=1)
                	AND a.archived!=1 ' . $reviewedCondition . $sponsoredCondition . '
                GROUP BY a.id 
                ORDER BY ' . $sponsoredOrder . 'a.created_at DESC
                LIMIT 0,' . (int)$limit;
        $bindings = [
            'countryCode' => config('country.code'),
        ];

        $cacheId = config('country.code') . '.home.getPosts.' . $type;
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
     * @param int $limit
     * @param string $type (latest OR featured)
     * @param int $cacheExpiration
     * @return mixed
     */
    private function getArticles($limit = 20, $type = 'latest', $cacheExpiration = 0)
    {

        $sponsoredOrder = '';

        $publishedCondition = 'AND a.published = 1';

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

    public function getVipPosts(){
        $vipJobs = Post::where('archived',0)->where('vip',1)->orderBy('updated_at','desc')->limit(48)->get();
        return \view('home.inc.latest-vip',compact('vipJobs'))->render();
    }
}
