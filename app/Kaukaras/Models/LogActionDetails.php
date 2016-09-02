<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2016-05-05
 * Time: 18:50
 */

namespace Kaukaras\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property $LogActionDetailsId int PK
 * @property $LogActionId int FK
 * @property $Field string
 * @property $OldValue string
 * @property $NewValue string
 */
class LogActionDetails extends Model
{
    public $timestamps = false;
    protected $table = 'log_actions_details';
    protected $primaryKey = 'LogActionDetailsId';
    protected $guarded = ['LogActionDetailsId'];
    protected $fillable = ['Field', 'OldValue', 'NewValue'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function logAction()
    {
        return $this->belongsTo('Kaukaras\Models\LogAction', 'LogActionId', 'LogId');
    }
}