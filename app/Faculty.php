<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2017-03-31
 * Time: 20:42
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Faculty
 * @package App
 * @author  Alius Sultanovas, 2017-03-31
 * @property-read int $faculty_id       PK
 * @property string   $name
 * @property int      $sort_order
 */
class Faculty extends Model
{
    public $timestamps = false;
    protected $table = 'faculty';
    protected $primaryKey = 'faculty_id';
    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = ['faculty_id'];
    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'name', 'sort_order'
    ];

    /**
     * @param $id int faculty_id
     * @return Faculty|null
     */
    public static function findById(int $id)
    {
        return self::all()->filter(function (Faculty $faculty) use ($id) {
            return intval($faculty->faculty_id) === $id;
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
     * Collection of {@link Cluster}
     * @return Collection
     */
    public function getActiveClusters(): Collection
    {
        return $this->getClusters()->filter(function (Cluster $cluster) {
            return intval($cluster->is_active) === Cluster::IS_ACTIVE;
        });
    }

    /**
     * @return Collection
     */
    public function getClusters(): Collection
    {
        return Cluster::findByFacultyId($this->faculty_id);
    }

    /**
     * @return Collection
     */
    public function clusters(): Collection
    {
        return $this->hasMany(Cluster::class, 'faculty_id', 'faculty_id')->getResults();
    }
}
