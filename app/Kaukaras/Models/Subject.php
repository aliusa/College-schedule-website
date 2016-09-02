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
 * @property $SubjectId int PK
 * @property $Name string
 * @property $IsActive int
 */
class Subject extends Entity
{
    public $timestamps = false;
    protected $table = 'subject';
    protected $primaryKey = 'SubjectId';
    protected $guarded = ['SubjectId'];
    protected $fillable = ['Name', 'IsActive'];

    /**
     * @param $id int SubjectId
     * @return Subject|null
     */
    public static function findById(int $id)
    {
        return static::where('SubjectId', $id)->first();
    }

    /**
     * @param $name string Subject name
     * @return Subject|null
     */
    public static function nameExists(string $name)
    {
        return static::where('Name', $name)->first();
    }

    public static function getSubjects(): Collection
    {
        return Subject::all()
            ->sortBy("Name");
    }

    /**
     * @return int Last Subject Id
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
        return $this->hasMany('Kaukaras\Models\Module', 'SubjectId', 'SubjectId');
    }


    public function getId() : int
    {
        return $this->SubjectId;
    }
}