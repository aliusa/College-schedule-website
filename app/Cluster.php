<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Cluster
 * @package App
 * @author  Alius Sultanovas, 2017-03-31 21:09
 * @property-read int $cluster_id
 * @property string   $name
 * @property int      $parent_id        FK to {@link Cluster}
 * @property string   $email
 * @property int      $is_active
 * @property int      $is_archived
 * @property int      $study_form_id    FK to {@link Option_details}
 * @property int      $faculty_id       FK to {@link Faculty}
 * @property int      $field_id         FK to {@link Option_details}
 * @property string   $start_year
 */
class Cluster extends Model
{
    const IS_ACTIVE = 1;
    const IS_ARCHIVED = 1;
    public $timestamps = false;
    protected $table = 'cluster';
    protected $primaryKey = 'cluster_id';
    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = ['cluster_id'];
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'sort_order'
    ];

    /**
     * @param $id int cluster_id
     * @return Cluster|null
     */
    public static function findById(int $id)
    {
        return self::all()->filter(function (Cluster $cluster) use ($id) {
            return intval($cluster->cluster_id) === $id;
        })->first();
    }

    /**
     * @return Collection
     */
    public static function getAll(): Collection
    {
        return static::all();
    }

    /**
     * @param          $id int faculty_id
     * @param bool|int $active
     * @return Collection
     */
    public static function findByFacultyId(int $id, int $active = 2): Collection
    {
        $collection = self::all()->filter(function (Cluster $cluster) use ($id, $active) {
            return intval($cluster->faculty_id) === $id;
        });

        if ($active !== 2) {
            return $collection->filter(function (Cluster $cluster) use ($active) {
                return intval($cluster->is_active) === $active;
            });
        }

        return $collection;
    }

    /**
     * @param $id int faculty_id
     * @return Collection
     */
    public static function findByFieldId(int $id): Collection
    {
        return self::all()->filter(function (Cluster $cluster) use ($id) {
            return intval($cluster->field_id) === $id;
        });
    }

    /**
     * @return Collection
     */
    public static function getActiveClusters(): Collection
    {
        return self::all()->filter(function (Cluster $cluster) {
            return intval($cluster->is_active) === self::IS_ACTIVE;
        });
    }

    /**
     * @return OptionsDetails
     */
    public function field(): OptionsDetails
    {
        return $this->belongsTo(OptionsDetails::class, 'field_id', 'options_details_id')->getResults();
    }

    /**
     * @return Faculty
     */
    public function faculty():Faculty
    {
        return $this->belongsTo(Faculty::class, 'faculty_id', 'faculty_id')->getResults();
    }

}
