<?php


namespace App\Http\Requests\Admin;

class PostRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$rules = [
            'category_id'         => 'required|not_in:0',
            'post_type_id'        => 'required|not_in:0',
            'company_name'        => 'required|mb_between:2,200|whitelist_word_title',
            'company_description' => 'required|mb_between:10,3000|whitelist_word',
            'title'               => 'required|mb_between:2,150',
            'description'         => 'required|mb_between:5,12000',
            'contact_name'        => 'required|mb_between:3,200',
            'email'               => 'required|email|max:100',
        ];
	
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
}
