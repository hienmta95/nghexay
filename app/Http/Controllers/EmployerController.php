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

class EmployerController extends FrontController
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


    public function getEmployerLanding()
    {
        return \view('employer.landing');
    }


    public function getEmployerPricing()
    {
        return \view('employer.pricing');
    }

    public function getEmployerRegister()
    {
        return \view('employer.pricing');
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
