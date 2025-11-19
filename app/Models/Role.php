<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|Admin[] $admins
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'roles';
	public $timestamps = false;
	public static $snakeAttributes = false;

	protected $fillable = [
		'name'
	];

	public function admins()
	{
		return $this->belongsToMany(Admin::class, 'admin_roles')
					->withPivot('id');
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
