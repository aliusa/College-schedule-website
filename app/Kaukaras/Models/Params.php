<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-09-02
 * Time: 23:28
 */

namespace Kaukaras\Models;

/**
 * @property $ParamId int PK
 * @property $Title string
 * @property $Param1 string
 * @property $Param2 string
 */
class Params extends Entity
{
    public $timestamps = false;
    protected $table = 'params';
    protected $primaryKey = 'ParamId';
    protected $guarded = ['ParamId'];
    protected $fillable = ['Title', 'Param1', 'Param2'];

    /**
     * @param $id int Params
     * @return Params|null
     */
    public static function findById(int $id)
    {
        return static::all()->where('ParamId', $id)->first();
    }

    /**
     * @return int
     */
    public function getId():int
    {
        return $this->ParamId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }
}