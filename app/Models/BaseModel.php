<?php


namespace App\Models;

use App\Models\Traits\ActiveTrait;
use App\Models\Traits\VerifiedTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Prologue\Alerts\Facades\Alert;

class BaseModel extends Model
{
    use ActiveTrait, VerifiedTrait;
    use Cachable;

    public static $msg = 'This feature has been turned off in demo mode.';

    /**
     * BaseModel constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * @param array $attributes
     * @return $this|bool|Model
     */
    public static function create(array $attributes = [])
    {
        return static::query()->create($attributes);
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        if (!$this->exists) {
            return false;
        }

        if (isDemo()) {
            if (isset($options['canBeUpdated']) && $options['canBeUpdated'] == true) {
                unset($options['canBeUpdated']);
                return $this->fill($attributes)->save($options);
            }

            self::$msg = t(self::$msg);

            if (isFromAdminPanel()) {
                Alert::info(self::$msg)->flash();
            } else {
                flash(self::$msg)->info();
            }

            return false;
        } else {
            return $this->fill($attributes)->save($options);
        }
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        return parent::save($options);
    }

    /**
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        return parent::delete();
    }
}
