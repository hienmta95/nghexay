<?php


namespace App\Observer;

use App\Models\SkillType;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SkillTypeObserver extends TranslatedModelObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  SkillType $skillType
     * @return void
     */
    public function deleting($skillType)
    {
		parent::deleting($skillType);
    }

    /**
     * Listen to the Entry saved event.
     *
     * @param  SkillType $skillType
     * @return void
     */
    public function saved(SkillType $skillType)
    {
        // Removing Entries from the Cache
        $this->clearCache($skillType);
    }

    /**
     * Listen to the Entry deleted event.
     *
     * @param  SkillType $skillType
     * @return void
     */
    public function deleted(SkillType $skillType)
    {
        // Removing Entries from the Cache
        $this->clearCache($skillType);
    }

    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $skillType
     */
    private function clearCache($skillType)
    {
        Cache::flush();
    }
}
