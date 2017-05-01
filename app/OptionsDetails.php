<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2017-04-01
 * Time: 16:43
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class OptionsDetails
 * @package app
 * @author  Alius Sultanovas
 * @property-read int $options_details_id
 * @property int      $options_id                FK to {@link Options}
 * @property string   $name
 * @property int      $sort_order
 */
class OptionsDetails extends Model
{
    public $timestamps = false;
    protected $table = 'options_details';
    protected $primaryKey = 'options_details_id';
    /**
     * The attributes that aren't mass assignable.
     * @var array
     */
    protected $guarded = ['options_details_id'];

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'options_id', 'name', 'sort_order'
    ];

    /**
     * Collection of {@link OptionsDetails}
     * @param $id int recurring_task_id
     * @return OptionsDetails|null
     */
    public static function findById(int $id)
    {
        return self::find($id);
    }

    /**
     * Collection of {@link OptionsDetails}
     * @return Collection
     */
    public static function getStudyFields(): Collection
    {
        return OptionsDetails::all()
            ->filter(function (OptionsDetails $option_details) {
                return intval($option_details->options_id) == Options::STUDY_FIELD;
            });
    }

    /**
     * Collection of {@link Cluster}
     * @return Collection
     */
    public function clustersByField(): Collection
    {
        return $this->hasMany(Cluster::class, 'field_id', 'options_details_id')->getResults();
    }
}
