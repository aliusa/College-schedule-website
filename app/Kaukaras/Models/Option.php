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
 * @property $OptionsId int PK
 * @property $Name string
 * @property $IntervalStart int
 * @property $IntervalEnd int
 */
class Option extends Model
{
    const STUDY_FORM = 1;
    const STUDY_FIELD = 2;
    const ACADEMIC_DEGREE = 3;
    const GENDER = 4;

    public $timestamps = false;
    protected $table = 'options';
    protected $primaryKey = 'OptionsId';
    protected $guarded = ['OptionsId'];
    protected $fillable = ['Name', 'IntervalStart', 'IntervalEnd'];

    /**
     * @param $id int OptionsId
     * @return Option|null
     */
    public static function findById(int $id)
    {
        return static::all()->where('OptionsId', $id)->first();
    }
}