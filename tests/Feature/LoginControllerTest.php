<?php

namespace StylemixModules\Auth\Tests\Feature;

use StylemixModules\Auth\Models\User;
use StylemixModules\Auth\Tests\DatabaseTestCase;

class LoginControllerTest extends DatabaseTestCase
{

	public function testLogin()
	{
		(new User)->forceFill([
			'email' => 'test@stylemix.net',
			'password' => bcrypt('secret'),
		])->save();

		$this->postJson('api/auth/login', [
			'email' => 'test@stylemix.net',
			'password' => 'secret',
		])
			->assertSuccessful()
			->assertJsonStructure(['token', 'token_type', 'expires_in']);

		$this->postJson('api/auth/login', [
			'email' => 'test@stylemix.net',
			'password' => 'terces',
		])
			->assertStatus(422)
			->assertJsonStructure(['message', 'errors']);
	}
}
