<?php


namespace App\Providers;

use App\Helpers\DBTool;
use App\Models\Language;
use App\Models\Permission;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Jenssegers\Date\Date;

class AppServiceProvider extends ServiceProvider
{
	private $cacheExpiration = 1440; // Cache for 1 day (60 * 24)
	
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Paginator::useBootstrapThree();
		
		try {
			Schema::defaultStringLength(191);
		} catch (\Exception $e) {

		}
		
		// Create the local storage symbolic link
		$this->checkAndCreateStorageSymlink();
		
		// Setup ACL system
		$this->setupAclSystem();
		
		// Force HTTPS protocol
		$this->forceHttps();
		
		// Create setting config var for the default language
		$this->getDefaultLanguage();
		
		// Create config vars from settings table
		$this->createConfigVars();
		
		// Update the config vars
		$this->setConfigVars();
		
		// Check the Multi-Countries feature
		// To prevent the Locale (Language Abbr) & the Country Code conflict,
		// Don't hive the Default Locale in URL
		if (config('settings.seo.multi_countries_urls')) {
			Config::set('laravellocalization.hideDefaultLocaleInURL', true);
		}

		if (!DBTool::checkIfMySQLFunctionExists(config('icetea.core.distanceCalculationFormula'))) {
			$res = DBTool::createMySQLDistanceCalculationFunction(config('icetea.core.distanceCalculationFormula'));
		}

		if (config('settings.app.date_force_utf8')) {
			Date::setUTF8(true);
		}
		Date::setLocale(config('appLang.abbr', 'en'));
		setlocale(LC_ALL, config('appLang.locale', 'en_US'));
	}
	
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
	
	/**
	 * Check the local storage symbolic link and Create it if does not exist.
	 */
	private function checkAndCreateStorageSymlink()
	{
		$symlink = public_path('storage');
		try {
			if (!is_link($symlink)) {
				// $exitCode = Artisan::call('storage:link');
				symlink('../storage/app/public', './storage');
			}
		} catch (\Exception $e) {
			$errorUrl = '';
			$message = ($e->getMessage() != '') ? $e->getMessage() : 'symlink() has been disabled on your server';
			
			flash($message)->error();
		}
	}
	
	/**
	 * Force HTTPS protocol
	 */
	private function forceHttps()
	{
		if (config('icetea.core.forceHttps') == true) {
			URL::forceScheme('https');
		}
	}

	private function getDefaultLanguage()
	{
		
		try {
			// Get the DB default language
			$defaultLang = Cache::remember('language.default', $this->cacheExpiration, function () {
				$defaultLang = Language::where('default', 1)->first();
				
				return $defaultLang;
			});
			
			if (!empty($defaultLang)) {
				// Create DB default language settings
				Config::set('appLang', $defaultLang->toArray());
				
				// Set dates default locale
				Date::setLocale(config('appLang.abbr'));
				setlocale(LC_ALL, config('appLang.locale'));
			} else {
				Config::set('appLang.abbr', config('app.locale'));
			}
		} catch (\Exception $e) {
			Config::set('appLang.abbr', config('app.locale'));
		}
	}

	private function createConfigVars()
	{
		Config::set('settings.app.default_date_format', config('icetea.core.defaultDateFormat'));
		Config::set('settings.app.default_datetime_format', config('icetea.core.defaultDatetimeFormat'));
		
		// Check DB connection and catch it
		try {
			// Get all settings from the database
			$settings = Cache::remember('settings.active', $this->cacheExpiration, function () {
				$settings = Setting::where('active', 1)->get();
				
				return $settings;
			});
			
			// Bind all settings to the Laravel config, so you can call them like
			if ($settings->count() > 0) {
				foreach ($settings as $setting) {
					if (count($setting->value) > 0) {
						foreach ($setting->value as $subKey => $value) {
							if (!empty($value)) {
								Config::set('settings.' . $setting->key . '.' . $subKey, $value);
							}
						}
					}
				}
			}
		} catch (\Exception $e) {
			Config::set('settings.error', true);
			Config::set('settings.app.logo', config('icetea.core.logo'));
		}
	}

	private function setConfigVars()
	{
		// App
		Config::set('app.name', config('settings.app.app_name'));
		Config::set('app.timezone', config('settings.app.default_timezone', config('app.timezone')));
		// reCAPTCHA
		Config::set('recaptcha.public_key', env('RECAPTCHA_PUBLIC_KEY', config('settings.security.recaptcha_public_key')));
		Config::set('recaptcha.private_key', env('RECAPTCHA_PRIVATE_KEY', config('settings.security.recaptcha_private_key')));
		// Mail
		Config::set('mail.driver', env('MAIL_DRIVER', config('settings.mail.driver')));
		Config::set('mail.host', env('MAIL_HOST', config('settings.mail.host')));
		Config::set('mail.port', env('MAIL_PORT', config('settings.mail.port')));
		Config::set('mail.encryption', env('MAIL_ENCRYPTION', config('settings.mail.encryption')));
		Config::set('mail.username', env('MAIL_USERNAME', config('settings.mail.username')));
		Config::set('mail.password', env('MAIL_PASSWORD', config('settings.mail.password')));
		Config::set('mail.from.address', env('MAIL_FROM_ADDRESS', config('settings.mail.email_sender')));
		Config::set('mail.from.name', env('MAIL_FROM_NAME', config('settings.app.app_name')));
		// Mailgun
		Config::set('services.mailgun.domain', env('MAILGUN_DOMAIN', config('settings.mail.mailgun_domain')));
		Config::set('services.mailgun.secret', env('MAILGUN_SECRET', config('settings.mail.mailgun_secret')));
		// Mandrill
		Config::set('services.mandrill.secret', env('MANDRILL_SECRET', config('settings.mail.mandrill_secret')));
		// Amazon SES
		Config::set('services.ses.key', env('SES_KEY', config('settings.mail.ses_key')));
		Config::set('services.ses.secret', env('SES_SECRET', config('settings.mail.ses_secret')));
		Config::set('services.ses.region', env('SES_REGION', config('settings.mail.ses_region')));
		// Sparkpost
		Config::set('services.sparkpost.secret', env('SPARKPOST_SECRET', config('settings.mail.sparkpost_secret')));
		// Facebook
		Config::set('services.facebook.client_id', env('FACEBOOK_CLIENT_ID', config('settings.social_auth.facebook_client_id')));
		Config::set('services.facebook.client_secret', env('FACEBOOK_CLIENT_SECRET', config('settings.social_auth.facebook_client_secret')));
		// Google
		Config::set('services.google.client_id', env('GOOGLE_CLIENT_ID', config('settings.social_auth.google_client_id')));
		Config::set('services.google.client_secret', env('GOOGLE_CLIENT_SECRET', config('settings.social_auth.google_client_secret')));
		Config::set('services.googlemaps.key', env('GOOGLE_MAPS_API_KEY', config('settings.other.googlemaps_key')));
		// Meta-tags
		Config::set('meta-tags.title', config('settings.app.slogan'));
		Config::set('meta-tags.open_graph.site_name', config('settings.app.app_name'));
		Config::set('meta-tags.twitter.creator', config('settings.seo.twitter_username'));
		Config::set('meta-tags.twitter.site', config('settings.seo.twitter_username'));
		// Cookie Consent
		Config::set('cookie-consent.enabled', env('COOKIE_CONSENT_ENABLED', config('settings.other.cookie_consent_enabled')));
		
		// Admin panel
		Config::set('icetea.admin.skin', config('settings.style.admin_skin'));
		Config::set('icetea.admin.default_date_format', config('settings.app.default_date_format'));
		Config::set('icetea.admin.default_datetime_format', config('settings.app.default_datetime_format'));
		if (str_contains(config('settings.footer.show_powered_by'), 'fa')) {
			Config::set('icetea.admin.show_powered_by', str_contains(config('settings.footer.show_powered_by'), 'fa-check-square-o') ? 1 : 0);
		} else {
			Config::set('icetea.admin.show_powered_by', config('settings.footer.show_powered_by'));
		}
	}
	
	/**
	 * Setup ACL system
	 * Check & Migrate Old admin authentication to ACL system
	 */
	private function setupAclSystem()
	{
		if (isFromAdminPanel()) {
			// Check & Fix the default Permissions
			if (!Permission::checkDefaultPermissions()) {
				Permission::resetDefaultPermissions();
			}
		}
	}
}
