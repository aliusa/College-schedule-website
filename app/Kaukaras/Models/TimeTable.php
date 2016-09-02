<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-08-18
 * Time: 16:13
 */

namespace Kaukaras\Models;

/**
 * @property $TimeTableId int PK
 * @property $Name string
 * @property $DateFrom string
 * @property $DateTo string
 */
class TimeTable extends Entity
{
    public $timestamps = false;
    protected $table = 'timetable';
    protected $primaryKey = 'TimeTableId';
    protected $guarded = ['TimeTableId'];
    protected $fillable = ['Name', 'DateFrom', 'DateTo'];


    /**
     * @param $id int TimeTableId
     * @return TimeTable|null
     */
    public static function findById(int $id)
    {
        return static::where('TimeTableId', $id)->first();
    }


    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->TimeTableId;
    }
}
