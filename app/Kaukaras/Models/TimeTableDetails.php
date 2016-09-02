<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-08-18
 * Time: 16:21
 */

namespace Kaukaras\Models;

/**
 * @property $TimeTableDetailsId int PK
 * @property $TimeTableId int FK
 * @property $Weekday bit
 * @property $TimeStart TIME/string
 * @property $TimeEnd TIME/string
 */
class TimeTableDetails extends Entity
{
    public $timestamps = false;
    protected $table = 'timetable_details';
    protected $primaryKey = 'TimeTableDetailsId';
    protected $guarded = ['TimeTableDetailsId'];
    protected $fillable = ['Weekday', 'TimeStart', 'TimeEnd'];

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->TimeTableDetailsId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }
}