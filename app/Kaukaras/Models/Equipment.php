<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-05-15
 * Time: 19:13
 */

namespace Kaukaras\Models;

/**
 * @property $EquipmentId int PK
 * @property $Name string
 * @property $Type int
 */
class Equipment extends Entity
{
    const TYPE_HARDWARE = 1;
    const TYPE_SOFTWARE = 2;

    public $timestamps = false;
    protected $table = 'equipment';
    protected $primaryKey = 'EquipmentId';
    protected $guarded = ['EquipmentId'];
    protected $fillable = ['Name', 'Type'];

    /**
     * @param $id int Equipment
     * @return Equipment|null
     */
    public static function findById(int $id)
    {
        return static::all()->where('HardwareId', $id)->first();
    }

    /**
     * @param $name string Equipment name
     * @return Equipment|null
     */
    public static function nameExists(string $name)
    {
        return static::all()->where('Name', $name)->first();
    }

    public function getId():int
    {
        return $this->EquipmentId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }

    public function classroom()
    {
        return $this->hasManyThrough('Kaukaras\Models\Classroom', 'Kaukaras\Models\Classroom_Equipment');
    }
}