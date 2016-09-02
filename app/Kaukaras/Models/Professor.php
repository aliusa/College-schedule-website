<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.13
 * Time: 09:58
 */

namespace Kaukaras\Models;

/**
 * @property $ProfessorId int PK
 * @property $FirstName string
 * @property $LastName string
 * @property $Email string
 * @property $Notes string
 * @property $Picture string
 * @property $Phone string
 * @property $DegreeId int FK
 * @property $IsActive tinyint
 */
class Professor extends Entity
{
    public $timestamps = false;
    protected $table = 'professor';
    protected $primaryKey = 'ProfessorId';
    protected $guarded = ['ProfessorId'];
    protected $fillable = ['FirstName', 'LastName', 'Email', 'Notes', 'Picture', 'Phone', 'DegreeId', 'IsActive'];


    /**
     * @param $id int ProfessorId
     * @return Professor|null
     */
    public static function findById(int $id)
    {
        return Professor::where('ProfessorId', $id)->first();
    }


    public function getFullName()
    {
        return $this->LastName . " " . substr($this->FirstName, 0, 1) . ".";
    }

    public function lecture()
    {
        return $this->hasMany('Kaukaras\Models\Lecture', 'ProfessorId', 'ProfessorId');
    }

    public function degree()
    {
        return $this->belongsTo('Kaukaras\Models\OptionDetails', 'DegreeId', 'OptionsDetailsId');
    }

    public function getId():int
    {
        return $this->ProfessorId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }

    public function semester()
    {
        return $this->hasManyThrough('Kaukaras\Models\Semester', 'Kaukaras\Models\Professor_Semester', 'ProfessorId', 'SemesterId');
    }
}