<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin;

/**
 * Class Post
 * 
 * @property int $id
 * @property string $title
 * @property string $summary
 * @property string $content
 * @property int $category_id
 * @property int|null $image_file_id
 * @property int $author_id
 * @property int|null $status
 * @property int|null $views
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property string|null $deleted_at
 * 
 * @property User $admin
 * @property File|null $file
 * @property Category $category
 * @property Collection|Comment[] $comments
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Post extends Model
{
	use SoftDeletes;
	protected $table = 'posts';
	public static $snakeAttributes = false;

	protected $casts = [
		'category_id' => 'int',
		'image_file_id' => 'int',
		'author_id' => 'int',
		'status' => 'int',
		'views' => 'int'
	];

	protected $fillable = [
		'title',
		'summary',
		'content',
		'category_id',
		'image_file_id',
		'author_id',
		'status',
		'views'
	];

	public function admin()
	{
		return $this->belongsTo(User::class, 'author_id');
	}

	public function legacyAdmin()
	{
		return $this->belongsTo(Admin::class, 'author_id');
	}

	public function file()
	{
		return $this->belongsTo(File::class, 'image_file_id');
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'post_user_favorites')
					->withPivot('id');
	}
}
