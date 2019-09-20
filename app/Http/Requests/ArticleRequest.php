<?php


namespace App\Http\Requests;


class ArticleRequest extends Request
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$cat = null;

		$rules = [
			'category_id'    => 'required|not_in:0',
			'title'          => 'required|mb_between:2,150|whitelist_word_title',
			'description'    => 'required|mb_between:5,12000|whitelist_word',
		];

		// CREATE
		if (in_array($this->method(), ['POST', 'CREATE'])) {
			$rules['parent_id'] = 'required|not_in:0';

			// Recaptcha
			if (config('settings.security.recaptcha_activation')) {
				$rules['g-recaptcha-response'] = 'required';
			}
		}

		// UPDATE
		// if (in_array($this->method(), ['PUT', 'PATCH', 'UPDATE'])) {}

		// COMMON

		// Location
		if (in_array(config('country.admin_type'), ['1', '2']) && config('country.admin_field_active') == 1) {
			$rules['admin_code'] = 'required|not_in:0';
		}



		/*
		 * Tags (Only allow letters, numbers, spaces and ',;_-' symbols)
		 *
		 * Explanation:
		 * [] 	=> character class definition
		 * p{L} => matches any kind of letter character from any language
		 * p{N} => matches any kind of numeric character
		 * _- 	=> matches underscore and hyphen
		 * + 	=> Quantifier — Matches between one to unlimited times (greedy)
		 * /u 	=> Unicode modifier. Pattern strings are treated as UTF-16. Also causes escape sequences to match unicode characters
		 */
		if ($this->filled('tags')) {
			$rules['tags'] = 'regex:/^[\p{L}\p{N} ,;_-]+$/u';
		}

		return $rules;
	}

	/**
	 * @return array
	 */
	public function messages()
	{
		$messages = [];

		return $messages;
	}
}
