<?php


namespace App\Observer;

use App\Models\EducationType;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class EducationTypeObserver extends TranslatedModelObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  EducationType $educationType
     * @return void
     */
    public function deleting($educationType)
    {
		parent::deleting($educationType);

    }

    /**
     * Listen to the Entry saved event.
     *
     * @param  EducationType $educationType
     * @return void
     */
    public function saved(EducationType $educationType)
    {
        // Removing Entries from the Cache
        $this->clearCache($educationType);
    }

    /**
     * Listen to the Entry deleted event.
     *
     * @param  EducationType $educationType
     * @return void
     */
    public function deleted(EducationType $educationType)
    {
        // Removing Entries from the Cache
        $this->clearCache($educationType);
    }

    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $educationType
     */
    private function clearCache($educationType)
    {
        Cache::flush();
    }
}
