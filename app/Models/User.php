<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $national_code
 * @property int $gender
 * @property string $mobile
 * @property string $email
 * @property int|null $avatar_file_id
 * @property string $username
 * @property string $password
 * @property int|null $province_id
 * @property int|null $city_id
 * @property int $role_id
 * @property int $military_service_status
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property File|null $file
 * @property City|null $city
 * @property Province|null $province
 * @property Role $role
 * @property Collection|Comment[] $comments
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use Notifiable;

	protected $table = 'users';
	public static $snakeAttributes = false;

	protected $casts = [
		'gender' => 'int',
		'avatar_file_id' => 'int',
		'province_id' => 'int',
		'city_id' => 'int',
		'role_id' => 'int',
		'military_service_status' => 'int',
		'status' => 'int'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'national_code',
		'gender',
		'mobile',
		'email',
		'avatar_file_id',
		'username',
		'password',
		'province_id',
		'city_id',
		'role_id',
		'military_service_status',
		'status'
	];

	protected $appends = [
		'created_at_jalali',
	];

	public function file()
	{
		return $this->belongsTo(File::class, 'avatar_file_id');
	}

	public function city()
	{
		return $this->belongsTo(City::class);
	}

	public function province()
	{
		return $this->belongsTo(Province::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function posts()
	{
		return $this->belongsToMany(Post::class, 'post_user_favorites')
					->withPivot('id');
	}

	public function favoritePosts()
	{
		return $this->belongsToMany(Post::class, 'post_user_favorites')
			->withPivot('id', 'created_at');
	}

	public function getCreatedAtJalaliAttribute(): ?string
	{
		if (!$this->created_at) {
			return null;
		}

		return Verta::instance($this->created_at)->format('Y/m/d H:i');
	}
}
