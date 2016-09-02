<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.12.23
 * Time: 16:39
 */

namespace Kaukaras\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * @property $RecurringTaskId int PK
 * @property $ModuleId int FK
 * @property $ProfessorId int FK
 * @property $ModuleClusterId int FK
 * @property $IsRecurring int
 * @property $DateStart date
 * @property $DateEnd date
 * @property $TimeStart time
 * @property $TimeEnd time
 * @property $Duration time virtual column TIMEDIFF(TimeEnd, TimeStart)
 * @property $IsMonday int
 * @property $IsTuesday int
 * @property $IsWednesday int
 * @property $IsThursday int
 * @property $IsFriday int
 * @property $IsSaturday int
 * @property $IsSunday int
 * @property $Occurs int
 * @property $OccursEvery int
 * @property $DateCreated string TIMESTAMP
 */
class RecurringTask extends Entity
{
    public $timestamps = false;
    protected $table = 'recurringtask';
    protected $primaryKey = 'RecurringTaskId';
    protected $guarded = ['RecurringTaskId'];
    protected $fillable = ['IsRecurring', 'DateStart', 'DateEnd', 'TimeStart', 'TimeEnd',
        'IsMonday', 'IsTuesday', 'IsWednesday', 'IsThursday', 'IsFriday', 'IsSaturday', 'IsSunday',
        'Occurs', 'OccursEvery'];

    /**
     * @param $id int RecurringTask
     * @return RecurringTask|null
     */
    public static function findById(int $id)
    {
        return RecurringTask::all()->where('RecurringTaskId', $id)->first();
    }

    /**
     * @return RecurringTask Last RecurringTask
     */
    public static function getLast(): RecurringTask
    {
        return RecurringTask::all()
            ->sortByDesc('RecurringTaskId')
            ->first();
    }

    /**
     * TODO: this column does not exist. FIXME
     * @param int $id
     * @return Collection|null
     */
    public static function getBySubClusterId(int $id)
    {
        return RecurringTask::all()->where("ClusterId", $id);
    }

    /**
     * @param $id int Module
     * @return Collection|null
     */
    public static function findByModuleId(int $id)
    {
        return RecurringTask::all()->where('ModuleId', $id);
    }

    /**
     * @return int Last RecurringTask Id
     */
    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }

    public function module()
    {
        return $this->belongsTo('Kaukaras\Models\Module', 'ModuleId', 'ModuleId');
    }

    public function professor()
    {
        return $this->belongsTo('Kaukaras\Models\Professor', 'ProfessorId', 'ProfessorId');
    }

    public function lecture()
    {
        return $this->hasMany('Kaukaras\Models\Lecture', 'RecurringTaskId', 'RecurringTaskId');
    }

    public function module_cluster()
    {
        return $this->belongsTo('Kaukaras\Models\ModuleCluster', 'ModuleClusterId', 'ModuleClusterId');
    }

    public function getSubjet(): Subject
    {
        return Subject::findById($this->getModule()->SubjectId);
    }

    public function getModule(): Module
    {
        return Module::findById($this->ModuleId);
    }

    public function getSemester(): Semester
    {
        return Semester::findById($this->getModule()->SemesterId);
    }

    public function getId():int
    {
        return $this->RecurringTaskId;
    }
}