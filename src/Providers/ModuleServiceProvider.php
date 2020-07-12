<?php

namespace StylemixModules\Auth\Providers;

use Konekt\Concord\BaseModuleServiceProvider;
use StylemixModules\Auth\Models\User;

class ModuleServiceProvider extends BaseModuleServiceProvider
{

	protected $models = [
		User::class,
	];
}
