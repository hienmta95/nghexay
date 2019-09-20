<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Upgrading
|--------------------------------------------------------------------------
|
| The upgrading process routes
|
*/
/*Route::group(['middleware' => ['web'], 'namespace' => 'App\Http\Controllers'], function () {
    Route::get('upgrade', 'UpgradeController@version');
});*/


/*
|--------------------------------------------------------------------------
| Installation
|--------------------------------------------------------------------------
|
| The installation process routes
|
*/
/*Route::group([
	'middleware' => ['web'],
	'namespace'  => 'App\Http\Controllers',
], function () {
	Route::get('install', 'InstallController@starting');
	Route::get('install/site_info', 'InstallController@siteInfo');
	Route::post('install/site_info', 'InstallController@siteInfo');
	Route::get('install/system_compatibility', 'InstallController@systemCompatibility');
	Route::get('install/database', 'InstallController@database');
	Route::post('install/database', 'InstallController@database');
	Route::get('install/database_import', 'InstallController@databaseImport');
	Route::get('install/cron_jobs', 'InstallController@cronJobs');
	Route::get('install/finish', 'InstallController@finish');
});
*/

/*
|--------------------------------------------------------------------------
| Back-end
|--------------------------------------------------------------------------
|
| The admin panel routes
|
*/
Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'middleware' => ['web'],
    'prefix' => config('icetea.admin.route_prefix', 'admin'),
], function ($router) {
    // Auth
    Route::auth();
    Route::get('logout', 'Auth\LoginController@logout');

    // Admin Panel Area
    Route::group([
        'middleware' => ['admin', 'clearance', 'bannedUser', 'preventBackHistory'],
    ], function ($router) {
        // Dashboard
        Route::get('dashboard', 'DashboardController@dashboard');
        Route::get('logs', 'LogController@index');
        Route::get('/', 'DashboardController@redirect');

        // Extra (must be called before CRUD)
        Route::get('homepage/{action}', 'HomeSectionController@reset')->where('action', 'reset_(.*)');
        Route::get('languages/sync_files', 'LanguageController@syncFilesLines');
        Route::get('permissions/create_default_entries', 'PermissionController@createDefaultEntries');

        // CRUD
        CRUD::resource('advertisings', 'AdvertisingController');
        CRUD::resource('blacklists', 'BlacklistController');
        CRUD::resource('categories', 'CategoryController');
        CRUD::resource('categories/{catId}/subcategories', 'SubCategoryController');
        //CRUD::resource('article_categories/{catId}/subcategories', 'SubCategoryController');
        CRUD::resource('cities', 'CityController');
        CRUD::resource('companies', 'CompanyController');
        CRUD::resource('countries', 'CountryController');
        CRUD::resource('countries/{countryCode}/cities', 'CityController');
        CRUD::resource('countries/{countryCode}/admins1', 'SubAdmin1Controller');
        CRUD::resource('currencies', 'CurrencyController');
        CRUD::resource('genders', 'GenderController');
        CRUD::resource('homepage', 'HomeSectionController');
        CRUD::resource('admins1/{admin1Code}/cities', 'CityController');
        CRUD::resource('admins1/{admin1Code}/admins2', 'SubAdmin2Controller');
        CRUD::resource('admins2/{admin2Code}/cities', 'CityController');
        CRUD::resource('languages', 'LanguageController');
        CRUD::resource('meta_tags', 'MetaTagController');
        CRUD::resource('packages', 'PackageController');
        CRUD::resource('pages', 'PageController');
        CRUD::resource('payments', 'PaymentController');
        CRUD::resource('payment_methods', 'PaymentMethodController');
        CRUD::resource('permissions', 'PermissionController');
        CRUD::resource('pictures', 'PictureController');
        CRUD::resource('posts', 'PostController');
        CRUD::resource('p_types', 'PostTypeController');
        CRUD::resource('position_types', 'PositionTypeController');
        CRUD::resource('report_types', 'ReportTypeController');
        CRUD::resource('roles', 'RoleController');
        CRUD::resource('salary_types', 'SalaryTypeController');
        CRUD::resource('skill_types', 'SkillTypeController');
        CRUD::resource('education_types', 'EducationTypeController');
        CRUD::resource('settings', 'SettingController');
        CRUD::resource('time_zones', 'TimeZoneController');
        CRUD::resource('users', 'UserController');
        CRUD::resource('staffs', 'StaffController');
        CRUD::resource('candidates', 'CandidateController');
        CRUD::resource('articles', 'ArticleController');
        CRUD::resource('article_categories', 'ArticleCategoryController');

        // Others
        Route::get('account', 'UserController@account');

        Route::post('ajax/{table}/{field}', 'InlineRequestController@make');

        // Backup
        Route::get('backups', 'BackupController@index');
        Route::put('backups/create', 'BackupController@create');
        Route::get('backups/download/{file_name?}', 'BackupController@download');
        Route::delete('backups/delete/{file_name?}', 'BackupController@delete')->where('file_name', '(.*)');

        // Actions
        Route::get('actions/clear_cache', 'ActionController@clearCache');
        Route::get('actions/call_ads_cleaner_command', 'ActionController@callAdsCleanerCommand');
        Route::post('actions/maintenance_down', 'ActionController@maintenanceDown');
        Route::get('actions/maintenance_up', 'ActionController@maintenanceUp');

        // Re-send Email or Phone verification message
        Route::get('verify/user/{id}/resend/email', 'UserController@reSendVerificationEmail');
        Route::get('verify/user/{id}/resend/sms', 'UserController@reSendVerificationSms');
        Route::get('verify/post/{id}/resend/email', 'PostController@reSendVerificationEmail');
        Route::get('verify/post/{id}/resend/sms', 'PostController@reSendVerificationSms');

        // Plugins
        Route::get('plugins', 'PluginController@index');
        Route::post('plugins/{plugin}/install', 'PluginController@install');
        Route::get('plugins/{plugin}/install', 'PluginController@install');
        Route::get('plugins/{plugin}/uninstall', 'PluginController@uninstall');
        Route::get('plugins/{plugin}/delete', 'PluginController@delete');
    });
});


/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The not translated front-end routes
|
*/
Route::group([
    'middleware' => ['web'],
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    // SEO
    Route::get('sitemaps.xml', 'SitemapsController@index');

    // Impersonate (As admin user, login as an another user)
    Route::group(['middleware' => 'auth'], function ($router) {
        Route::impersonate();
    });
});


/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The translated front-end routes
|
*/
Imgfly::routes();
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    //'middleware' => ['local'],
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    Route::group(['middleware' => ['web']], function ($router) {
        // HOMEPAGE
        Route::get('/', 'HomeController@index')->name('homepage');
        Route::get('/home', 'HomeController@index');
        Route::get('/nha-tuyen-dung', 'HomeController@getEmployerLanding');
        Route::get('/ung-vien', 'Search\CandidateController@index');
        Route::get('/ho-so/{hash}', 'Search\CandidateController@profile')->name('search.candidate.profile');
        Route::get('/ho-so/{hash}/pdf', 'Search\CandidateController@downloadPdf')->name('search.candidate.download-pdf');


        Route::group(['prefix' => 'cam-nang'], function () {
            Route::get('/', [
                'as' => 'article.index',
                'uses' => "ArticleController@index"
            ]);
            Route::get('/c-{slug}', [
                'as' => 'article.category',
                'uses' => "ArticleController@category"
            ]);
            Route::get('/d-{slug}', [
                'as' => 'article.detail',
                'uses' => "ArticleController@detail"
            ]);
        });

        Route::get(LaravelLocalization::transRoute('routes.countries'), 'CountriesController@index');


        // AUTH
        Route::group(['middleware' => ['guest', 'preventBackHistory']], function () {
            // Registration Routes...
            Route::get(LaravelLocalization::transRoute('routes.register'), 'Auth\RegisterController@showRegistrationForm');
            Route::post(LaravelLocalization::transRoute('routes.register'), 'Auth\RegisterController@register');
            Route::get('register/finish', 'Auth\RegisterController@finish');

            // Authentication Routes...
            Route::get(LaravelLocalization::transRoute('routes.login'), 'Auth\LoginController@showLoginForm');
            Route::post(LaravelLocalization::transRoute('routes.login'), 'Auth\LoginController@login');

            // Forgot Password Routes...
            Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
            Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

            // Reset Password using Token
            Route::get('password/token', 'Auth\ForgotPasswordController@showTokenRequestForm');
            Route::post('password/token', 'Auth\ForgotPasswordController@sendResetToken');

            // Reset Password using Link (Core Routes...)
            Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
            Route::post('password/reset', 'Auth\ResetPasswordController@reset');

            // Social Authentication
            Route::get('auth/facebook', 'Auth\SocialController@redirectToProvider');
            Route::get('auth/facebook/callback', 'Auth\SocialController@handleProviderCallback');
            Route::get('auth/google', 'Auth\SocialController@redirectToProvider');
            Route::get('auth/google/callback', 'Auth\SocialController@handleProviderCallback');
            Route::get('auth/twitter', 'Auth\SocialController@redirectToProvider');
            Route::get('auth/twitter/callback', 'Auth\SocialController@handleProviderCallback');
        });

        // Email Address or Phone Number verification
        $router->pattern('field', 'email|phone');
        Route::get('verify/user/{id}/resend/email', 'Auth\RegisterController@reSendVerificationEmail');
        Route::get('verify/user/{id}/resend/sms', 'Auth\RegisterController@reSendVerificationSms');
        Route::get('verify/user/{field}/{token?}', 'Auth\RegisterController@verification');
        Route::post('verify/user/{field}/{token?}', 'Auth\RegisterController@verification');

        // User Logout
        Route::get(LaravelLocalization::transRoute('routes.logout'), 'Auth\LoginController@logout');


        // POSTS
        Route::group(['namespace' => 'Post'], function ($router) {
            $router->pattern('id', '[0-9]+');
            // $router->pattern('slug', '.*');
            $router->pattern('slug', '^(?=.*)((?!\/).)*$');

            Route::get('posts/create/{tmpToken?}', 'CreateController@getForm');
            Route::post('posts/create', 'CreateController@postForm');
            Route::put('posts/create/{tmpToken}', 'CreateController@postForm');
            Route::get('posts/create/{tmpToken}/payment', 'PaymentController@getForm');
            Route::post('posts/create/{tmpToken}/payment', 'PaymentController@postForm');
            Route::get('posts/create/{tmpToken}/finish', 'CreateController@finish');

            // Payment Gateway Success & Cancel
            Route::get('posts/create/{tmpToken}/payment/success', 'PaymentController@paymentConfirmation');
            Route::get('posts/create/{tmpToken}/payment/cancel', 'PaymentController@paymentCancel');

            // Email Address or Phone Number verification
            $router->pattern('field', 'email|phone');
            Route::get('verify/post/{id}/resend/email', 'CreateController@reSendVerificationEmail');
            Route::get('verify/post/{id}/resend/sms', 'CreateController@reSendVerificationSms');
            Route::get('verify/post/{field}/{token?}', 'CreateController@verification');
            Route::post('verify/post/{field}/{token?}', 'CreateController@verification');

            Route::group(['middleware' => 'auth'], function ($router) {
                $router->pattern('id', '[0-9]+');

                Route::get('posts/{id}/edit', 'EditController@getForm');
                Route::put('posts/{id}/edit', 'EditController@postForm');
                Route::get('posts/{id}/payment', 'PaymentController@getForm');
                Route::post('posts/{id}/payment', 'PaymentController@postForm');

                // Payment Gateway Success & Cancel
                Route::get('posts/{id}/payment/success', 'PaymentController@paymentConfirmation');
                Route::get('posts/{id}/payment/cancel', 'PaymentController@paymentCancel');
            });

            // Post's Details
            Route::get(LaravelLocalization::transRoute('routes.post'), 'DetailsController@index');

            // Contact Job's Author
            Route::post('posts/{id}/contact', 'DetailsController@sendMessage');

            // Send report abuse
            Route::get('posts/{id}/report', 'ReportController@showReportForm');
            Route::post('posts/{id}/report', 'ReportController@sendReport');
        });
        Route::post('send-by-email', 'Search\SearchController@sendByEmail');
        Route::post('ajax/account/upload-avatar', 'Account\EditController@uploadAvatar');
        Route::post('ajax/account/crop-avatar', 'Account\EditController@cropAvatar');
        // ACCOUNT
        Route::group(['middleware' => ['auth', 'bannedUser', 'preventBackHistory'], 'namespace' => 'Account'], function ($router) {
            $router->pattern('id', '[0-9]+');
            // Users
            Route::get('account', 'EditController@index');

            Route::group(['prefix' => 'account'], function () {
                Route::get('dashboard', 'DashboardController@index');
                Route::get('search', 'SearchController@index')->name('search.index');
                Route::get('do-search', 'SearchController@doSearch')->name('search.do-search');
                Route::get('view-profile/{hash}', 'SearchController@viewProfile')->name('search.view-profile');

            });


            Route::put('account', 'EditController@updateDetails')->name('account.update-details');
            Route::put('account/update-profile', 'EditController@updateProfileDetails')->name('account.update-profile');
            Route::get('account/update-profile-item', 'EditController@getUpdateProfileItem')->name('account.update-profile-item');
            Route::post('account/skills', 'EditController@updateProfileSkills')->name('account.update-profile-skill');
            Route::put('account/expected-job', 'EditController@updateExpectedJobData')->name('account.update-profile-expected-job');
            Route::put('account/settings', 'EditController@updateSettings');
            Route::put('account/preferences', 'EditController@updatePreferences');

            Route::get('account/close', 'CloseController@index');
                Route::post('account/close', 'CloseController@submit');

            // Companies
            Route::get('account/companies', 'CompanyController@index');
            Route::get('account/companies/create', 'CompanyController@create');
            Route::post('account/companies', 'CompanyController@store');
            Route::get('account/companies/{id}', 'CompanyController@show');
            Route::get('account/companies/{id}/edit', 'CompanyController@edit');
            Route::put('account/companies/{id}', 'CompanyController@update');
            Route::get('account/companies/{id}/delete', 'CompanyController@destroy');
            Route::post('account/companies/delete', 'CompanyController@destroy');

            // Resumes
            Route::get('account/resumes', 'ResumeController@index');
            Route::get('account/resumes/create', 'ResumeController@create');
            Route::post('account/resumes', 'ResumeController@store');
            Route::get('account/resumes/{id}', 'ResumeController@show');
            Route::get('account/resumes/{id}/edit', 'ResumeController@edit');
            Route::put('account/resumes/{id}', 'ResumeController@update');
            Route::get('account/resumes/{id}/delete', 'ResumeController@destroy');
            Route::post('account/resumes/delete', 'ResumeController@destroy');

            // Posts
            Route::get('account/saved-search', 'PostsController@getSavedSearch');
            Route::get('account/saved-candidates', 'DashboardController@getSavedCandidates');
            Route::get('account/viewed-candidates', 'DashboardController@getPaidCandidates');
            $router->pattern('pagePath', '(my-posts|archived|favourite|suitable|pending-approval|saved-search)+');
            Route::get('account/{pagePath}', 'PostsController@getPage');
            Route::get('account/{pagePath}/{id}/repost', 'PostsController@getArchivedPosts');
            Route::get('account/{pagePath}/{id}/delete', 'PostsController@destroy');
            Route::post('account/{pagePath}/delete', 'PostsController@destroy');

            // Conversations
            Route::get('account/conversations', 'ConversationsController@index');
            Route::get('account/conversations/{id}/delete', 'ConversationsController@destroy');
            Route::post('account/conversations/delete', 'ConversationsController@destroy');
            Route::post('account/conversations/{id}/reply', 'ConversationsController@reply');
            $router->pattern('msgId', '[0-9]+');
            Route::get('account/conversations/{id}/messages', 'ConversationsController@messages');
            Route::get('account/conversations/{id}/messages/{msgId}/delete', 'ConversationsController@destroyMessages');
            Route::post('account/conversations/{id}/messages/delete', 'ConversationsController@destroyMessages');

            // Transactions
            Route::get('account/transactions', 'TransactionsController@index');
        });


        // AJAX
        Route::group(['prefix' => 'ajax'], function ($router) {
            Route::get('countries/{countryCode}/admins/{adminType}', 'Ajax\LocationController@getAdmins');
            Route::get('countries/{countryCode}/admins/{adminType}/{adminCode}/cities', 'Ajax\LocationController@getCities');
            Route::get('countries/{countryCode}/cities/{id}', 'Ajax\LocationController@getSelectedCity');
            Route::post('countries/{countryCode}/cities/autocomplete', 'Ajax\LocationController@searchedCities');
            Route::post('countries/{countryCode}/admin1/cities', 'Ajax\LocationController@getAdmin1WithCities');
            Route::post('category/sub-categories', 'Ajax\CategoryController@getSubCategories');
            Route::post('save/post', 'Ajax\PostController@savePost')->name('ajax.save-post');
            Route::post('candidate/save', 'Ajax\EmployerController@saveCandidate')->name('ajax.save-candidate');
            Route::post('candidate/pay', 'Ajax\EmployerController@paidCandidate')->name('ajax.paid-candidate');
            Route::post('save/search', 'Ajax\PostController@saveSearch');
            Route::post('post/phone', 'Ajax\PostController@getPhone');
            Route::post('messages/check', 'Ajax\ConversationController@checkNewMessages');
            Route::get('skills', [
                'as' => 'ajax.get-skills',
                'uses' => 'Ajax\CommonController@getSkillTypes'
            ]);

            Route::get('employer/dashboard-charts', 'Ajax\EmployerController@getViewChart')->name('ajax.employer.dashboard-chart');
        });


        // FEEDS
        Route::feeds();


        // Country Code Pattern
        $countryCodePattern = implode('|', array_map('strtolower', array_keys(getCountries())));
        $router->pattern('countryCode', $countryCodePattern);


        // XML SITEMAPS
        Route::get('{countryCode}/sitemaps.xml', 'SitemapsController@site');
        Route::get('{countryCode}/sitemaps/pages.xml', 'SitemapsController@pages');
        Route::get('{countryCode}/sitemaps/categories.xml', 'SitemapsController@categories');
        Route::get('{countryCode}/sitemaps/cities.xml', 'SitemapsController@cities');
        Route::get('{countryCode}/sitemaps/posts.xml', 'SitemapsController@posts');
        Route::get('{countryCode}/sitemaps/articles.xml', 'SitemapsController@posts');


        // STATICS PAGES
        Route::get(LaravelLocalization::transRoute('routes.page'), 'PageController@index');
        Route::get(LaravelLocalization::transRoute('routes.contact'), 'PageController@contact');
        Route::post(LaravelLocalization::transRoute('routes.contact'), 'PageController@contactPost');
        Route::get(LaravelLocalization::transRoute('routes.sitemap'), 'SitemapController@index');
        Route::get(LaravelLocalization::transRoute('routes.companies-list'), 'Search\CompanyController@index');


        // DYNAMIC URL PAGES
        $router->pattern('id', '[0-9]+');
        $router->pattern('username', '[a-zA-Z0-9]+');
        Route::get(LaravelLocalization::transRoute('routes.search'), 'Search\SearchController@index');
        Route::get(LaravelLocalization::transRoute('routes.search-user'), 'Search\UserController@index');
        Route::get(LaravelLocalization::transRoute('routes.search-username'), 'Search\UserController@profile');
        Route::get(LaravelLocalization::transRoute('routes.search-company'), 'Search\CompanyController@profile');
        Route::get(LaravelLocalization::transRoute('routes.search-tag'), 'Search\TagController@index');
        Route::get(LaravelLocalization::transRoute('routes.search-city'), 'Search\CityController@index');
        Route::get(LaravelLocalization::transRoute('routes.search-subCat'), 'Search\CategoryController@index');
        Route::get(LaravelLocalization::transRoute('routes.search-cat'), 'Search\CategoryController@index');
    });
});
