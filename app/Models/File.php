<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class File
 * 
 * @property int $id
 * @property string $name
 * @property string $extension
 * @property int $size
 * @property string $path
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 * 
 * @property Collection|Category[] $categories
 * @property Collection|Post[] $posts
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class File extends Model
{
	use SoftDeletes;
	protected $table = 'files';
	public static $snakeAttributes = false;

	protected $casts = [
		'size' => 'int'
	];

	protected $fillable = [
		'name',
		'extension',
		'size',
		'path'
	];

	public function categories()
	{
		return $this->hasMany(Category::class, 'image_file_id');
	}

	public function posts()
	{
		return $this->hasMany(Post::class, 'image_file_id');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'avatar_file_id');
	}
}
