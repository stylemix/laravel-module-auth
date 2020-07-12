<?php

namespace StylemixModules\Auth\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use StylemixModules\Auth\Contracts\User as UserContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property string $email
 * @property \Carbon\Carbon $email_verified_at
 * @property string $password
 */
class User extends Authenticatable implements UserContract, JWTSubject
{

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}
}
