<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.12.23
 * Time: 16:53
 */

namespace Kaukaras\Models;

/**
 * @property $ClassroomId int PK
 * @property $FacultyId int FK
 * @property $Name string
 * @property $Vacancy int
 */
class Classroom extends Entity
{
    public $timestamps = false;
    protected $table = 'classroom';
    protected $primaryKey = 'ClassroomId';
    protected $guarded = ['ClassroomId'];
    protected $fillable = ['Name', 'Vacancy'];

    /**
     * @param $id int ClassroomId
     * @return Classroom|null
     */
    public static function findById(int $id)
    {
        return static::all()->where('ClassroomId', $id)->first();
    }

    /**
     * @param String $name
     * @param $facultyId
     * @return Classroom|null
     */
    public static function classroomExists(String $name, $facultyId)
    {
        return Classroom::all()
            ->where('Name', $name)
            ->where('FacultyId', $facultyId)
            ->first();
    }

    public function faculty()
    {
        return $this->belongsTo('Kaukaras\Models\OptionDetails', 'FacultyId', 'OptionsDetailsId');
    }

    public function lecture()
    {
        return $this->hasMany('Kaukaras\Models\Lecture', 'ClassroomId', 'ClassroomId');
    }

    public function getId():int
    {
        return $this->ClassroomId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }

    public function equipment()
    {
        return $this->hasManyThrough('Kaukaras\Models\Equipment', 'Kaukaras\Models\Classroom_Equipment', 'ClassroomId', 'EquipmentId');
    }
}