<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdminRole
 * 
 * @property int $id
 * @property int $admin_id
 * @property int $role_id
 * 
 * @property Admin $admin
 * @property Role $role
 *
 * @package App\Models
 */
class AdminRole extends Model
{
	protected $table = 'admin_roles';
	public $timestamps = false;
	public static $snakeAttributes = false;

	protected $casts = [
		'admin_id' => 'int',
		'role_id' => 'int'
	];

	protected $fillable = [
		'admin_id',
		'role_id'
	];

	public function admin()
	{
		return $this->belongsTo(Admin::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}
}
