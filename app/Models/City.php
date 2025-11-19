<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 * 
 * @property int $id
 * @property int $province_id
 * @property string $name
 * 
 * @property Province $province
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class City extends Model
{
	protected $table = 'cities';
	public $timestamps = false;
	public static $snakeAttributes = false;

	protected $casts = [
		'province_id' => 'int'
	];

	protected $fillable = [
		'province_id',
		'name'
	];

	public function province()
	{
		return $this->belongsTo(Province::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
