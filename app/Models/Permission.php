<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * 
 * @property int $id
 * @property string $name
 * @property Carbon $craeted_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Admin[] $admins
 *
 * @package App\Models
 */
class Permission extends Model
{
	protected $table = 'permissions';
	public $timestamps = false;
	public static $snakeAttributes = false;

	protected $casts = [
		'craeted_at' => 'datetime'
	];

	protected $fillable = [
		'name',
		'craeted_at'
	];

	public function admins()
	{
		return $this->belongsToMany(Admin::class, 'admin_permissions');
	}
}
