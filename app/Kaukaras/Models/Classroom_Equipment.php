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
 * @property $ClassroomId int PK
 * @property $EquipmentId int FK
 */
class Classroom_Equipment extends Model
{
    public $timestamps = false;
    protected $table = 'classroom_equipment';
    protected $primaryKey = 'EquipmentId';
    protected $fillable = ['ClassroomId', 'EquipmentId'];

    public function classroom()
    {
        return $this->belongsTo('Kaukaras\Models\Classroom', 'ClassroomId', 'ClassroomId');
    }

    public function equipment()
    {
        return $this->belongsTo('Kaukaras\Models\Equipment', 'EquipmentId', 'EquipmentId');
    }
}