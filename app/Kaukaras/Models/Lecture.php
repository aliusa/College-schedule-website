<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.13
 * Time: 09:58
 */

namespace Kaukaras\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * @property $LectureId int PK
 * @property $RecurringTaskId int FK
 * @property $ClassroomId int FK
 * @property $Date date
 * @property $TimeStart time
 * @property $TimeEnd time
 * @property $Duration time Virtual column TIMEDIFF(TimeEnd, TimeStart)
 * @property $WeekDay tinyint Virtual column (WEEKDAY(Date)+1)
 * @property $Notes string
 * @property $Topic string
 * @property $IsCanceled int
 * @property $DateCreated string TIMESTAMP
 */
class Lecture extends Entity
{
    public $timestamps = false;
    protected $table = 'lecture';
    protected $primaryKey = 'LectureId';
    protected $guarded = ['LectureId'];
    protected $fillable = ['Date', 'TimeStart', 'TimeEnd', 'Notes', 'Topic', 'IsCanceled'];

    /**
     * @param $id int LectureId
     * @return Lecture|null
     */
    public static function findById(int $id)
    {
        return static::where('LectureId', $id)->first();
    }

    /**
     * @param int $id
     * @return Collection|null
     */
    public static function getByRecurringTaskId(int $id)
    {
        return static::where('RecurringTaskId', $id);
    }

    /**
     * @param int $id
     * @return Collection|null
     */
    public static function getByProfessorId(int $id)
    {
        return static::where('ProfessorId', $id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classroom()
    {
        return $this->belongsTo('Kaukaras\Models\Classroom', 'ClassroomId', 'ClassroomId');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recurringTask()
    {
        return $this->belongsTo('Kaukaras\Models\RecurringTask', 'RecurringTaskId', 'RecurringTaskId');
    }

    public function getId():int
    {
        return $this->LectureId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }
}