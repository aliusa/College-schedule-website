<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-05-15
 * Time: 20:37
 */

namespace Kaukaras\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property $ProfessorId int PK
 * @property $SemesterId int FK
 */
class Professor_Semester extends Model
{
    public $timestamps = false;
    protected $table = 'professor_semester';
    protected $primaryKey = 'SemesterId';
    protected $fillable = ['ProfessorId', 'SemesterId'];

    /**
     * @param int $professorId
     * @param int $semesterId
     * @return Professor_Semester|null
     */
    public static function getByProfessorSemester(int $professorId, int $semesterId)
    {
        return static::where('ProfessorId', $professorId)->where('SemesterId', $semesterId);
    }

    public function professor()
    {
        return $this->belongsTo('Kaukaras\Models\Professor', 'ProfessorId', 'ProfessorId');
    }

    public function semester()
    {
        return $this->belongsTo('Kaukaras\Models\Semester', 'SemesterId', 'SemesterId');
    }
}