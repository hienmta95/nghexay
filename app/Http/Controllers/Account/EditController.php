<?php


namespace App\Http\Controllers\Account;

use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\EducationType;
use App\Models\PositionType;
use App\Models\PostType;
use App\Models\Profile;
use App\Models\Scopes\VerifiedScope;
use App\Models\SkillType;
use App\Models\UserType;
use Creativeorange\Gravatar\Facades\Gravatar;
use App\Models\Post;
use App\Models\SavedPost;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Models\User;
use Illuminate\Http\Request;

class EditController extends AccountBaseController
{
    use VerificationTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $data = [];
        $currentUser = auth()->user();

        $data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
        $data['genders'] = Gender::trans()->get();
        $data['userTypes'] = UserType::all();
        $data['skillTypes'] = SkillType::trans()->get();
        $data['educationTypes'] = EducationType::trans()->get();
        $data['positionTypes'] = PositionType::trans()->get();
        $data['postTypes'] = PostType::trans()->get();
        $data['categories'] = Category::trans()->get();
        $data['cities'] = City::where('country_code', 'VN')->orderBy('name', 'asc')->get();
        $data['gravatar'] = (!empty(auth()->user()->email)) ? Gravatar::fallback(url('images/user.jpg'))->get(auth()->user()->email) : null;

        // Mini Stats
        $data['countPostsVisits'] = DB::table('posts')
            ->select('user_id', DB::raw('SUM(visits) as total_visits'))
            ->where('country_code', config('country.code'))
            ->where('user_id', auth()->user()->id)
            ->groupBy('user_id')
            ->first();
        $data['countPosts'] = Post::currentCountry()
            ->where('user_id', auth()->user()->id)
            ->count();
        $data['countFavoritePosts'] = SavedPost::whereHas('post', function ($query) {
            $query->currentCountry();
        })->where('user_id', $currentUser->id)
            ->count();

        // Meta Tags
        MetaTag::set('title', t('My account'));
        MetaTag::set('description', t('My account on :app_name', ['app_name' => config('settings.app.app_name')]));
        if ($currentUser->user_type_id == 2) {

            $data['profile'] = Profile::firstOrCreate([
                'user_id' => $currentUser->id
            ]);

            return view('account.candidate', $data);
        } else {
            return view('account.edit', $data);
        }

    }

    public function edit()
    {
        $data = [];
        $currentUser = auth()->user();

        $data['countries'] = CountryLocalizationHelper::transAll(CountryLocalization::getCountries());
        $data['genders'] = Gender::trans()->get();
        $data['userTypes'] = UserType::all();
        $data['skillTypes'] = SkillType::trans()->get();
        $data['educationTypes'] = EducationType::trans()->get();
        $data['positionTypes'] = PositionType::trans()->get();
        $data['postTypes'] = PostType::trans()->get();
        $data['categories'] = Category::trans()->get();
        $data['cities'] = City::where('country_code', 'VN')->orderBy('name', 'asc')->get();
        $data['gravatar'] = (!empty(auth()->user()->email)) ? Gravatar::fallback(url('images/user.jpg'))->get(auth()->user()->email) : null;

        // Mini Stats
        $data['countPostsVisits'] = DB::table('posts')
            ->select('user_id', DB::raw('SUM(visits) as total_visits'))
            ->where('country_code', config('country.code'))
            ->where('user_id', auth()->user()->id)
            ->groupBy('user_id')
            ->first();
        $data['countPosts'] = Post::currentCountry()
            ->where('user_id', auth()->user()->id)
            ->count();
        $data['countFavoritePosts'] = SavedPost::whereHas('post', function ($query) {
            $query->currentCountry();
        })->where('user_id', $currentUser->id)
            ->count();

        // Meta Tags
        MetaTag::set('title', t('My account'));
        MetaTag::set('description', t('My account on :app_name', ['app_name' => config('settings.app.app_name')]));
        if ($currentUser->user_type_id == 2) {

            $data['profile'] = Profile::firstOrCreate([
                'user_id' => $currentUser->id
            ]);

            return view('account.candidate', $data);
        } else {
            return view('account.edit', $data);
        }
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateDetails(UserRequest $request)
    {
        // Check if these fields has changed
        $emailChanged = $request->filled('email') && $request->input('email') != auth()->user()->email;
        $phoneChanged = $request->filled('phone') && $request->input('phone') != auth()->user()->phone;
        $usernameChanged = $request->filled('username') && $request->input('username') != auth()->user()->username;

        // Conditions to Verify User's Email or Phone
        $emailVerificationRequired = config('settings.mail.email_verification') == 1 && $emailChanged;
        $phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $phoneChanged;

        // Get User
        $user = User::withoutGlobalScopes([VerifiedScope::class])->find(auth()->user()->id);

        // Update User
        $input = $request->only($user->getFillable());
        foreach ($input as $key => $value) {
            if (in_array($key, ['email', 'phone', 'username']) && empty($value)) {
                continue;
            }
            $user->{$key} = $value;
        }

        $user->phone_hidden = $request->input('phone_hidden',1);

        // Email verification key generation
        if ($emailVerificationRequired) {
            $user->email_token = md5(microtime() . mt_rand());
            $user->verified_email = 0;
        }

        // Phone verification key generation
        if ($phoneVerificationRequired) {
            $user->phone_token = mt_rand(100000, 999999);
            $user->verified_phone = 0;
        }

        // Don't logout the User (See User model)
        if ($emailVerificationRequired || $phoneVerificationRequired) {
            session(['emailOrPhoneChanged' => true]);
        }

        // Save
        $user->save();



        if(request()->has('profile')){
            $profileData= request()->get('profile');
            $user->profile->update($profileData);
        }

        // Message Notification & Redirection
        flash(t("Your details account has updated successfully."))->success();
        $nextUrl = config('app.locale') . '/account';

        // Send Email Verification message
        if ($emailVerificationRequired) {
            $this->sendVerificationEmail($user);
            $this->showReSendVerificationEmailLink($user, 'user');
        }

        // Send Phone Verification message
        if ($phoneVerificationRequired) {
            // Save the Next URL before verification
            session(['itemNextUrl' => $nextUrl]);

            $this->sendVerificationSms($user);
            $this->showReSendVerificationSmsLink($user, 'user');

            // Go to Phone Number verification
            $nextUrl = config('app.locale') . '/verify/user/phone/';
        }


        // Redirection
        if (request()->ajax()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return redirect($nextUrl);
        }

    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateProfileDetails()
    {

        $nextUrl = config('app.locale') . '/account';
        $type = request()->get('type', 'default');
        $index = request()->get('index', null);
        //dd($type);

        if (request()->has('profile')) {
            $result = null;
            $profileData = request()->get('profile');
            $method = request()->get('method', 'put');

            $check = request()->get('check', 'true');

            $user = User::withoutGlobalScopes([VerifiedScope::class])->find(auth()->user()->id);
            //$profile = Profile::where('user_id','=', $user->id)->firstOrFail();
            $profile = Profile::firstOrNew([
                'user_id' => $user->id
            ]);

            //dd( request()->get('type'));

            if ($method == 'put') {
                //Edu
                if ($type == 'default') {
                    $profile->update($profileData);
                    return response()->json([
                        'success' => true
                    ]);
                }
                $typeData = $profile->$type != null ? json_decode($profile->$type) : [];
                $typeData = (array)$typeData;
                if (isset($profileData[$type]) && $profileData[$type] != null) {
                    $oldData = collect($typeData);
                    $existed = true;
                    if ($type == 'education_data' && isset($profileData['education_data'])) {
                        $checkEntry = $oldData->where('school_name', $profileData[$type]['school_name'])
                            ->where('degree_name', $profileData[$type]['degree_name'])
                            ->where('year', $profileData[$type]['year']);
                    }

                    if ($type == 'skill_data' && isset($profileData['education_data'])) {
                        $checkEntry = $oldData->where('skill_data', $profileData[$type]['school_name']);
                    }
                    if ($type == 'experience_data' && isset($profileData['experience_data'])) {
                        $checkEntry = $oldData->where('company_name', $profileData[$type]['company_name'])
                            ->where('position', $profileData[$type]['position']);
                    }
                    if ($type == 'expected_job_data' && isset($profileData['expected_job_data'])) {
                        $checkEntry = $oldData->where('school_name', $profileData[$type]['school_name'])
                            ->where('degree_name', $profileData[$type]['degree_name'])
                            ->where('year', $profileData[$type]['year']);
                    }
                    if ($checkEntry->toArray() == []) {
                        $existed = false;
                    } else {
                        return response()->json([
                            'success' => false,
                            'msg' => 'Thông tin đã tồn tại'
                        ]);
                    }
                    if ($existed == false) {
                        $typeData[] = $profileData[$type];
                    }

                }
                $profile->$type = json_encode($typeData);
                $result = $profileData[$type];

            }
            if ($method == 'delete') {
                $index = request()->get('index', null);

                //dd($type);
                $oldData = $profile->$type != null ? json_decode($profile->$type) : [];
                $oldData = (array)$oldData;
                if (isset($oldData[$index])) {
                    unset($oldData[$index]);
                    $profile->$type = json_encode($oldData);
                }
            }
            if ($method == 'update') {
                $newData = request()->get('profile');
                //dd($newData[$type]);
                $oldData = $profile->$type != null ? json_decode($profile->$type) : [];
                $oldData = (array)$oldData;
                if (isset($oldData[$index]) && isset($newData[$type])) {
                    $oldData[$index] =  $newData[$type];
                    $profile->$type = json_encode($oldData);
                }
            }

            //Update
            $profile->save();
            $profile->getOnlineResume();
            // Redirection
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } else {
                return redirect($nextUrl);
            }

        }
        return response()->json([
            'success' => false
        ]);


    }

    public function getUpdateProfileItem(){
        $index = \request()->get('index');
        $type = \request()->get('type');

        $user = User::withoutGlobalScopes([VerifiedScope::class])->find(auth()->user()->id);
        $educationTypes = EducationType::trans()->get();
        $profile = Profile::firstOrNew([
            'user_id' => $user->id
        ]);
        $typeData = $profile->$type != null ? json_decode($profile->$type) : [];
        $typeData = (array)$typeData;
        $item = [];
        if(isset($typeData[$index])){
            $item = $typeData[$index];
        }

        $view = 'account.inc.modal-education';

        if($type == 'education_data'){
            $view = 'account.inc.modal-education';
        }
        if($type == 'experience_data'){
            $view = 'account.inc.modal-exp';
        }
        if($type == 'expected_job_data'){
            $view = 'account.inc.modal-expected-job';
        }
        return view($view,compact('item','educationTypes'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateSettings(Request $request)
    {
        // Validation
        if ($request->filled('password')) {
            $rules = ['password' => 'between:6,60|dumbpwd|confirmed'];
            $this->validate($request, $rules);
        }

        // Get User
        $user = User::find(auth()->user()->id);

        // Update
        $user->disable_comments = (int)$request->input('disable_comments');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Save
        $user->save();
        // Redirection
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'msg' => t("Your settings account has updated successfully.")
            ]);
        } else {
            flash(t("Your settings account has updated successfully."))->success();

            return redirect(config('app.locale') . '/account');
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updatePreferences()
    {
        $data = [];

        return view('account.edit', $data);
    }


    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateProfileSkills()
    {

        // Get User
        $user = User::withoutGlobalScopes([VerifiedScope::class])->find(auth()->user()->id);


        // Message Notification & Redirection
        flash(t("Your details account has updated successfully."))->success();
        $nextUrl = config('app.locale') . '/account';


        $result = null;
        $profileData = request()->get('tags');


        //dd($profileData);
        //$profile = Profile::where('user_id','=', $user->id)->firstOrFail();
        $profile = Profile::firstOrNew([
            'user_id' => $user->id
        ]);

        $profile->skill_data = $profileData;

        //Update
        $profile->save();
        $profile->getOnlineResume();
        // Redirection
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $profileData
            ]);
        } else {
            return redirect($nextUrl);
        }


        return response()->json([
            'success' => false
        ]);


    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateExpectedJobData()
    {

        // Get User
        $user = User::withoutGlobalScopes([VerifiedScope::class])->find(auth()->user()->id);


        // Message Notification & Redirection
        flash(t("Your details account has updated successfully."))->success();
        $nextUrl = config('app.locale') . '/account';


        $result = null;
        $profileData = request()->all();

        //dd($profileData);
        unset($profileData['_token']);
        //$profile = Profile::where('user_id','=', $user->id)->firstOrFail();
        $profile = Profile::firstOrNew([
            'user_id' => $user->id
        ]);

        /*$profile->expected_job_data = json_encode($profileData);

        //Update
        $profile->save();*/
        $profile->update($profileData['profile']);
        // Redirection
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $profileData,
                'html' => view('account.inc.expected_item',compact('profile'))->render()
            ]);
        } else {
            return redirect($nextUrl);
        }


        return response()->json([
            'success' => false
        ]);


    }

    public function uploadAvatar()
    {
        $validator = \Validator::make(request()->all(), [
            'file' => 'required|max:2000|mimes:jpg,jpeg,png'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'msg' => $validator->getMessageBag()
            ]);
        } else {
            $user = auth()->user();
            $file = 'avatars/' . md5($user->id) . '.png';
            \Storage::delete($file);
            request()->file('file')->storeAs('avatars', md5($user->id) . '.png');


            $img = Image::make(\Storage::path($file));
            $img->fit(300, 300, function ($constraint) {
                //$constraint->aspectRatio();
                //$constraint->upsize();
            });
            $img->save();

            $user->avatar = $file;
            $user->save();
            return response()->json([
                'success' => true,
                'url' => \Storage::url($user->avatar).'?t='.time(),
                'path' => $file
            ]);
        }

    }

    public function cropAvatar()
    {

        $data = request()->all();

        /*$validator = \Validator::make(request()->all(), [
            'file' => 'required|max:2000|mimes:jpg,jpeg,png'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'msg' => $validator->getMessageBag()
            ]);
        } else {
            $user = auth()->user();
            $file = 'avatars/' . md5($user->id) . '.png';
            \Storage::delete($file);
            request()->file('file')->storeAs('avatars', md5($user->id) . '.png');

            $user->avatar = $file;
            $user->save();
            return response()->json([
                'success' => true,
                'url' => \Storage::url($user->avatar)
            ]);
        }*/

    }
}
