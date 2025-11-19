<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PostUserFavorite
 * 
 * @property int $id
 * @property int $user_id
 * @property int $post_id
 * @property Carbon $created_at
 * 
 * @property Post $post
 * @property User $user
 *
 * @package App\Models
 */
class PostUserFavorite extends Model
{
	protected $table = 'post_user_favorites';
	public $timestamps = false;
	public static $snakeAttributes = false;

	protected $casts = [
		'user_id' => 'int',
		'post_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'post_id'
	];

	public function post()
	{
		return $this->belongsTo(Post::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
