<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.13
 * Time: 10:29
 */

namespace Kaukaras\Models;

/**
 * @property $ClusterId int PK
 * @property $Name string
 * @property $ParentId int FK
 * @property $Email string
 * @property $FieldId int FK
 * @property $StudyFormId int FK
 * @property $FacultyId int FK
 * @property $isActive int
 * @property $isArchived int
 * @property $StartYear string
 */
class Cluster extends Entity
{
    public $timestamps = false;
    protected $table = 'cluster';
    protected $primaryKey = 'ClusterId';
    protected $guarded = ['ClusterId'];
    protected $fillable = ['Name', 'Email', 'IsActive', 'isArchived', 'StartYear'];

    /**
     * @param $id int ClusterId
     * @return Cluster|null
     */
    public static function findById(int $id)
    {
        return static::all()->where('ClusterId', $id)->first();
    }

    /**
     * @param $name string Cluster name
     * @return Cluster|null
     */
    public static function nameExists(string $name)
    {
        return Cluster::all()->where('Name', $name)->where('ParentId', null)->first();
    }

    /**
     * get last Cluster (not SubCluster)
     * @return Cluster Last Cluster
     */
    public static function getLast(): Cluster
    {
        return Cluster::all()->where('ParentId', null)->sortByDesc('ClusterId')->first();
    }

    /**
     * @param int $clusterId Cluster Id
     * @return int
     */
    public static function getSubClusterCount(int $clusterId): int
    {
        return Cluster::all()->where('ParentId', $clusterId)->count();
    }

    public static function getSubclusters(int $clusterId): array
    {
        return static::all()->where('ParentId', $clusterId)->all();
    }

    /**
     * @return int Last Cluster Id
     */
    public function getLastId(): int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }

    /**
     * parent Cluster
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cluster()
    {
        return $this->belongsTo('Kaukaras\Models\Cluster', 'ParentId', 'ClusterId');
    }

    public function studyForm()
    {
        return $this->belongsTo('Kaukaras\Models\OptionDetails', 'StudyFormId', 'OptionsDetailsId');
    }

    public function faculty()
    {
        return $this->belongsTo('Kaukaras\Models\Faculty', 'FacultyId', 'FacultyId');
    }

    public function field()
    {
        return $this->belongsTo('Kaukaras\Models\OptionDetails', 'FieldId', 'OptionsDetailsId');
    }

    public function subCluster()
    {
        return $this->hasMany('Kaukaras\Models\Cluster', 'ParentId', 'ClusterId');
    }

    public function getId():int
    {
        return $this->ClusterId;
    }
}