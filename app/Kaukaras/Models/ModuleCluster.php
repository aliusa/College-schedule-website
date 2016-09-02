<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-05-29
 * Time: 22:46
 */

namespace Kaukaras\Models;

use Illuminate\Database\Eloquent\Collection;

/**
 * @property $ModuleClusterId int PK
 * @property $ModuleId int FK
 * @property $ClusterId int FK (subCluster)
 * @property $IsChosen int
 */
class ModuleCluster extends Entity
{
    public $timestamps = false;
    protected $table = 'module_cluster';
    protected $primaryKey = 'ModuleClusterId';
    protected $guarded = ['ModuleClusterId'];
    protected $fillable = ['IsChosen'];

    /**
     * @param $id int ModuleSubcluster
     * @return ModuleCluster|null
     */
    public static function findById(int $id)
    {
        return static::all()->where('ModuleClusterId', $id)->first();
    }

    /**
     * @param int $id
     * @return Collection|null
     */
    public static function findByModuleId(int $id)
    {
        return static::all()->where('ModuleId', $id);
    }

    /**
     * @param int $moduleId
     * @param int $clusterId
     * @return ModuleCluster
     */
    public static function findByModuleAndCluster(int $moduleId, int $clusterId): ModuleCluster
    {
        return static::all()->where('ModuleId', $moduleId)->where('ClusterId', $clusterId)->first();
    }

    public function getId():int
    {
        return $this->ModuleClusterId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }

    public function module()
    {
        return $this->belongsTo('Kaukaras\Models\Module', 'ModuleId', 'ModuleId');
    }

    public function subCluster()
    {
        return $this->belongsTo('Kaukaras\Models\Cluster', 'ClusterId', 'ClusterId');
    }

    public function recurringTask()
    {
        return $this->hasMany('Kaukaras\Models\RecurringTask', 'ModuleClusterId', 'ModuleClusterId');
    }
}