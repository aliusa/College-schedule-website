<?php
/**
 * Created by PhpStorm.
 * User: alius
 * Date: 2015.11.13
 * Time: 10:29
 */

namespace Kaukaras\Models;

/**
 * @property $UserId int PK
 * @property $Username string
 * @property $FirstName string
 * @property $LastName string Virtual column (CONCAT(FirstName,' ',LastName))
 * @property $IsActive tinyint
 * @property $Password string
 * @property $AllowedIp string
 * @property $BannedIp string
 * @property $Email string
 */
class User extends Entity
{
    public $timestamps = false;
    protected $table = 'user';
    protected $primaryKey = 'UserId';
    protected $guarded = ['UserId'];
    protected $fillable = ['Username', 'FirstName', 'IsActive', 'AllowedIp', 'BannedIp', 'Email'];

    /**
     * @param $id int UserId
     * @return User|null
     */
    public static function findById(int $id)
    {
        return static::where('UserId', $id)->first();
    }

    public function getId():int
    {
        return $this->UserId;
    }

    public function getLastId():int
    {
        return static::all()
            ->sortByDesc($this->primaryKey)
            ->pluck($this->primaryKey)
            ->first();
    }

}