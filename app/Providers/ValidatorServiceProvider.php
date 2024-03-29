<?php


namespace App\Providers;

use App\Helpers\Validator\BlacklistValidator;
use App\Helpers\Validator\GlobalValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('whitelist_domain', function ($attribute, $value, $parameters, $validator) {
            return BlacklistValidator::checkDomain($attribute, $value, $parameters, $validator);
        });
        
        Validator::extend('whitelist_email', function ($attribute, $value, $parameters, $validator) {
            return BlacklistValidator::checkEmail($attribute, $value, $parameters, $validator);
        });
        
        Validator::extend('whitelist_word', function ($attribute, $value, $parameters, $validator) {
            return BlacklistValidator::checkWord($attribute, $value, $parameters, $validator);
        });
        
        Validator::extend('whitelist_word_title', function ($attribute, $value, $parameters, $validator) {
            return BlacklistValidator::checkTitle($attribute, $value, $parameters, $validator);
        });
        
        Validator::extend('mb_between', function ($attribute, $value, $parameters, $validator) {
            return GlobalValidator::mbBetween($attribute, $value, $parameters, $validator);
        });
        Validator::replacer('mb_between', function($message, $attribute, $rule, $parameters) {
            $min = (isset($parameters[0])) ? (int)$parameters[0] : 0;
            $max = (isset($parameters[1])) ? (int)$parameters[1] : 999999;
            return str_replace([':min', ':max'], [$min, $max], $message);
        });

        Validator::extend('valid_username', '\App\Helpers\Validator\UsernameValidator@isValid');
        Validator::extend('allowed_username', '\App\Helpers\Validator\UsernameValidator@isAllowed');
	
		Validator::extend('language_check_locale', '\App\Helpers\Validator\LocaleValidator@languageCheckLocale');
		Validator::extend('country_check_locale', '\App\Helpers\Validator\LocaleValidator@countryCheckLocale');
		Validator::extend('check_currencies', '\App\Helpers\Validator\LocaleValidator@checkCurrencies');
    }
    
    public function register()
    {
        //
    }
}
