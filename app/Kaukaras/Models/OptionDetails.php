<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.20
 * Time: 21:55
 */

namespace Kaukaras\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property $OptionsDetailsId int PK
 * @property $OptionsId int FK
 * @property $Name string
 * @property $SortOrder int
 */
class OptionDetails extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'options_details';
    protected $primaryKey = 'OptionsDetailsId';
    protected $guarded = [];
    protected $fillable = ['Name', 'SortOrder', 'OptionsDetailsId'];

    /**
     * @param $id int OptionDetails
     * @return OptionDetails|null
     */
    public static function findById(int $id)
    {
        return static::all()->where('OptionsDetailsId', $id)->first();
    }

    /**
     * @param int $option OptionsId
     * @return OptionDetails
     */
    public static function getDetails(int $option)
    {
        return OptionDetails::all()
            ->where("OptionsId", $option)
            ->sortBy('Name')
            ->sortBy('SortOrder')
            ->all();
    }

    /**
     * @param $name string name
     * @return OptionDetails|null
     */
    public static function nameExists(string $name, int $optionsId)
    {
        return static::all()->where('Name', $name)
            ->where('OptionsId', '=', $optionsId)
            ->first();
    }

    /**
     * @param int $optionId
     * @return OptionDetails|null
     */
    public static function lastId(int $optionId)
    {
        return OptionDetails::all()
            ->where('OptionsId', $optionId)
            ->sortByDesc('OptionsDetailsId')
            ->pluck('OptionsDetailsId')
            ->first();
    }

    public function option()
    {
        return $this->belongsTo('Kaukaras\Models\Option', 'OptionsId', 'OptionsId');
    }
}