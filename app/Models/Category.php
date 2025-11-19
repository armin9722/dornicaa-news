<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property int|null $image_file_id
 * @property int $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property File|null $file
 * @property Collection|Post[] $posts
 *
 * @package App\Models
 */
class Category extends Model
{
	protected $table = 'categories';
	public static $snakeAttributes = false;

	protected $casts = [
		'image_file_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'image_file_id',
		'status'
	];

	public function file()
	{
		return $this->belongsTo(File::class, 'image_file_id');
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}
}
