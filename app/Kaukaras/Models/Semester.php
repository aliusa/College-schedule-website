<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.12.23
 * Time: 16:35
 */

namespace Kaukaras\Models;


use Illuminate\Database\Eloquent\Collection;

/**
 * @property $SemesterId int PK
 * @property $Name string
 * @property $SortOrder int
 */
class Semester extends Entity
{
    public $timestamps = false;
    protected $table = 'semester';
    protected $primaryKey = 'SemesterId';
    protected $guarded = ['SemesterId'];
    protected $fillable = ['Name', 'SortOrder'];


    public static function getSemesters(): Collection
    {
        return Semester::all()
            ->sortBy("SortOrder");
    }

    /**
     * @param $id int SemesterId
     * @return Semester|null
     */
    public static function findById(int $id)
    {
        return static::where('SemesterId', $id)->first();
    }

    /**
     * @param $name string Semester name
     * @return Semester|null
     */
    public static function nameExists(string $name)
    {
        return static::where('Name', $name)->first();
    }

    public function module()
    {
        return $this->hasMany('Kaukaras\Models\Module', 'SemesterId', 'SemesterId');
    }

    public function getId():int
    {
        return $this->SemesterId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }
}