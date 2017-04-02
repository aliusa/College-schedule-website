<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2017-04-01
 * Time: 17:22
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

/**
 * Class OptionDetails
 * @package app
 * @author  Alius Sultanovas
 * @property-read int $option_id
 * @property string   $name
 * @property int      $interval_start
 * @property int      $interval_end
 */
class Options extends Model
{
    const STUDY_FORM = 1;
    const STUDY_FIELD = 2;
    const ACADEMIC_DEGREE = 3;
    const GENDER = 4;

    public $timestamps = false;
    protected $table = 'options';
    protected $primaryKey = 'option_id';

    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = ['option_id'];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'interval_start', 'interval_end'
    ];

    /**
     * @param $id int recurring_task_id
     * @return Options|null
     */
    public static function findById(int $id)
    {
        return self::all()->filter(function (Options $options) use ($id) {
            return intval($options->option_id) === $id;
        })->first();
    }
}
