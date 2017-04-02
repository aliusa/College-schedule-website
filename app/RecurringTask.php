<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Child of {@link Module}
 * @package App
 * @author  Alius Sultanovas, 2017-03-26 21:37
 * @property-read int $recurring_task_id
 * @property int      $module_id          FK {@link Module}
 * @property int      $professor_id       FK {@link Professor}
 * @property int      $module_cluster_id  FK {@link ModuleCluster}
 * @property int      $is_recurring
 * @property string   $date_start
 * @property string   $date_end
 * @property string   $time_start
 * @property string   $time_end
 * @property string   $duration           Virtual column
 * @property int      $is_monday
 * @property int      $is_tuesday
 * @property int      $is_wednesday
 * @property int      $is_thursday
 * @property int      $is_friday
 * @property int      $is_saturday
 * @property int      $is_sunday
 * @property int      $occurs
 * @property int      $occurs_every
 * @property-read int $date_created       When record was created
 */
class RecurringTask extends Model
{
    public $timestamps = false;
    protected $table = 'recurringtask';
    protected $primaryKey = 'recurring_task_id';
    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = ['recurring_task_id', 'duration', 'date_created'];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'module_id', 'professor_id', 'module_cluster_id', 'is_recurring', 'date_start', 'date_end',
        'time_start', 'time_end', 'is_monday', 'is_tuesday', 'is_wednesday', 'is_thursday', 'is_friday', 'is_saturday',
        'is_sunday', 'occurs', 'occurs_every'
    ];

    /**
     * @param $id int recurring_task_id
     * @return RecurringTask|null
     */
    public static function findById(int $id)
    {
        return self::all()->filter(function (RecurringTask $recurringTask) use ($id) {
            return intval($recurringTask->recurring_task_id) === $id;
        })->first();
    }

    /**
     * @return RecurringTask
     */
    public static function getLast(): RecurringTask
    {
        return RecurringTask::all()->last();
    }

}
