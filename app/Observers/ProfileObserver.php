<?php


namespace App\Observer;

use App\Models\Profile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ProfileObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  Profile $profile
     * @return void
     */
    public function deleting(Profile $profile)
    {

    }

    /**
     * Listen to the Entry saved event.
     *
     * @param  Profile $profile
     * @return void
     */
    public function saved(Profile $profile)
    {
        $this->clearCache($profile);
    }

    /**
     * Listen to the Entry deleted event.
     *
     * @param  Profile $profile
     * @return void
     */
    public function deleted(Profile $profile)
    {
        $this->clearCache($profile);
    }

    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $profile
     */
    private function clearCache($profile)
    {
		$limit = config('icetea.core.selectProfileInto', 5);
        Cache::forget('profiles.take.' . $limit . '.where.user.' . $profile->user_id);
		Cache::forget('profile.where.user.' . $profile->user_id);
    }
}
