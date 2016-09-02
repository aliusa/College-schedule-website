<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.12.23
 * Time: 16:30
 */

namespace Kaukaras\Models;

/**
 * @property $ModuleId int PK
 * @property $SemesterId int FK
 * @property $SubjectId int FK
 * @property $Credits int
 */
class Module extends Entity
{
    public $timestamps = false;
    protected $table = 'module';
    protected $primaryKey = 'ModuleId';
    protected $guarded = ['ModuleId'];
    protected $fillable = ['Credits'];

    /**
     * @param $id int ModuleId
     * @return Module|null
     */
    public static function findById(int $id)
    {
        return static::where('ModuleId', $id)->first();
    }

    /**
     * @param int $subject
     * @param int $semester
     * @return Module|null
     */
    public static function exists(int $subject, int $semester)
    {
        return static::where('SemesterId', $semester)
            ->where('SubjectId', $subject)
            ->first();
    }

    /**
     * @return Module Last Module
     */
    public static function getLastModule(): Module
    {
        return Module::all()
            ->sortByDesc('ModuleId')
            ->first();
    }

    /**
     * @return int Last Module Id
     */
    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }

    public function semester()
    {
        return $this->belongsTo('Kaukaras\Models\Semester', 'SemesterId', 'SemesterId');
    }

    public function subject()
    {
        return $this->belongsTo('Kaukaras\Models\Subject', 'SubjectId', 'SubjectId');
    }

    public function recurringTask()
    {
        return $this->hasMany('Kaukaras\Models\RecurringTask', 'ModuleId', 'ModuleId');
    }

    public function getSubject(): Subject
    {
        return Subject::findById($this->SubjectId);
    }

    public function getSemester(): Semester
    {
        return Semester::findById($this->SemesterId);
    }

    public function getId():int
    {
        return $this->ModuleId;
    }

    public function moduleSubcluster()
    {
        return $this->hasMany('Kaukaras\Models\ModuleSubcluster', 'ModuleId', 'ModuleId');
    }
}