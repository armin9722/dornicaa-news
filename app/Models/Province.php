<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Province
 * 
 * @property int $id
 * @property string $name
 * 
 * @property Collection|City[] $cities
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Province extends Model
{
	protected $table = 'provinces';
	public $timestamps = false;
	public static $snakeAttributes = false;

	protected $fillable = [
		'name'
	];

	public function cities()
	{
		return $this->hasMany(City::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
