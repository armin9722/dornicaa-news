<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Admin
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Permission[] $permissions
 * @property Collection|Role[] $roles
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class Admin extends Model
{
	protected $table = 'admins';
	public static $snakeAttributes = false;

	protected $casts = [
		'status' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'password',
		'status'
	];

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'admin_permissions');
	}

	public function roles()
	{
		return $this->belongsToMany(Role::class, 'admin_roles')
					->withPivot('id');
	}

	public function posts()
	{
		return $this->hasMany(Post::class, 'author_id');
	}
}
