<?php


namespace Icetea\Admin\app\Models;


trait Translated
{
    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */
    public function getTranslationOfAttribute()
    {
        $translationOf = (isset($this->attributes['translation_of'])) ? $this->attributes['translation_of'] : null;
        $entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : $translationOf;

        // Admin panel
        if (request()->segment(1) == admin_uri()) {
            return $translationOf;
        }

        // Front
        if (!empty($translationOf)) {
            if ($this->attributes['translation_lang'] == config('appLang.abbr')) {
                return $entityId;
            } else {
                return $translationOf;
            }
        } else {
            return $entityId;
        }
    }

    public function getTidAttribute()
    {
        $translationOf = (isset($this->attributes['translation_of'])) ? $this->attributes['translation_of'] : null;
        $entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : $translationOf;

        // Admin panel
        if (request()->segment(1) == admin_uri()) {
            return $translationOf;
        }

        // Front
        if (!empty($translationOf)) {
            if ($this->attributes['translation_lang'] == config('appLang.abbr')) {
                return $entityId;
            } else {
                return $translationOf;
            }
        } else {
            return $entityId;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
    public function setTranslationOfAttribute($value)
    {
        $entityId = (isset($this->attributes['id'])) ? $this->attributes['id'] : null;

        if (empty($value)) {
            if ($this->attributes['translation_lang'] == config('appLang.abbr')) {
                $this->attributes['translation_of'] = $entityId;
            } else {
                $this->attributes['translation_of'] = $value;
            }
        } else {
            $this->attributes['translation_of'] = $value;
        }
    }
}