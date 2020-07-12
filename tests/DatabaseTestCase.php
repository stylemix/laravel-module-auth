<?php

namespace StylemixModules\Auth\Tests;

class DatabaseTestCase extends TestCase
{
	/**
	 * Setup the test environment.
	 */
	protected function setUp() : void
	{
		parent::setUp();

		$this->loadMigrationsFrom(__DIR__ . '/database/migrations');
	}

	/**
	 * Define environment setup.
	 *
	 * @param  \Illuminate\Foundation\Application  $app
	 * @return void
	 */
	protected function getEnvironmentSetUp($app)
	{
		parent::getEnvironmentSetUp($app);

		// Setup default database to use sqlite :memory:
		$app['config']->set('database.default', 'testing');
		$app['config']->set('database.connections.testing', [
			'driver'   => 'sqlite',
			'database' => ':memory:',
			'prefix'   => '',
		]);
	}

}
