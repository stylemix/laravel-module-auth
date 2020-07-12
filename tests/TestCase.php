<?php

namespace StylemixModules\Auth\Tests;

use StylemixModules\Auth\Models\User;
use StylemixModules\Auth\Providers\ModuleServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{

	protected function resolveApplicationConfiguration($app)
	{
		parent::resolveApplicationConfiguration($app);

		// to see debug information
		$app['config']->set('app.debug', true);

		// configure auth to jwt driver
		$app['config']->set('auth.guards.api.driver', 'jwt');
		$app['config']->set('auth.providers.users.model', User::class);

		// register this module to concord
		$app['config']->set('concord.modules', [
			ModuleServiceProvider::class,
		]);
	}

	protected function getPackageProviders($app)
	{
		return [
			\Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
			\Konekt\Concord\ConcordServiceProvider::class,
		];
	}

}
