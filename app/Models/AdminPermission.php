<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminPermission
 * 
 * @property int $permission_id
 * @property int $admin_id
 * 
 * @property Admin $admin
 * @property Permission $permission
 *
 * @package App\Models
 */
class AdminPermission extends Model
{
	protected $table = 'admin_permissions';
	public $incrementing = false;
	public $timestamps = false;
	public static $snakeAttributes = false;

	protected $casts = [
		'permission_id' => 'int',
		'admin_id' => 'int'
	];

	protected $fillable = [
		'permission_id',
		'admin_id'
	];

	public function admin()
	{
		return $this->belongsTo(Admin::class);
	}

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}
}
