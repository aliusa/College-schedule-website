<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-05-05
 * Time: 18:45
 */

namespace Kaukaras\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property $LogId int PK
 * @property $Date datetime
 * @property $UserId int FK
 * @property $action string
 * @property $sql string
 * @property $pk int
 * @property $tbl string
 */
class LogAction extends Model
{
    public $timestamps = false;
    protected $table = 'log_actions';
    protected $primaryKey = 'LogId';
    protected $guarded = ['LogId'];
    protected $fillable = ['Date', 'action', 'sql', 'pk', 'tbl'];

    /**
     * @param $id int LogId
     * @return LogAction|null
     */
    public static function findById(int $id)
    {
        return static::where('LogId', $id)->first();
    }

    /**
     * @return LogAction|null
     */
    public static function getLast()
    {
        return LogAction::all()
            ->sortByDesc('LogId')
            ->first();
    }

    /**
     * @return int Last Task Id
     */
    public static function getLastId(): int
    {
        return LogAction::all()
            ->sortByDesc('LogId')
            ->pluck('LogId')
            ->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Kaukaras\Models\User', 'UserId', 'UserId');
    }

    public function logDetails()
    {
        return $this->hasMany('Kaukaras\Models\LogActionDetails', 'LogActionId', 'UserId');
    }

}