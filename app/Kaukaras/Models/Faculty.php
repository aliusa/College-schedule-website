<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-08-21
 * Time: 09:58
 */

namespace Kaukaras\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * @property $FacultyId int PK
 * @property $Name string
 */
class Faculty extends Entity
{
    public $timestamps = false;
    protected $table = 'faculty';
    protected $primaryKey = 'FacultyId';
    protected $guarded = ['FacultyId'];
    protected $fillable = ['Name'];

    /**
     * @param $id int FacultyId
     * @return Faculty|null
     */
    public static function findById(int $id)
    {
        return static::all()->where('FacultyId', $id)->first();
    }

    /**
     * @return Collection|null
     */
    public static function getAll()
    {
        return Faculty::all()
            ->sortBy('Name')
            ->sortBy('SortOrder');
    }

    /**
     * @param $name string name
     * @return Faculty|null
     */
    public static function nameExists(string $name)
    {
        return static::all()
            ->where('Name', $name)
            ->first();
    }

    public function getId():int
    {
        return $this->FacultyId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }
}