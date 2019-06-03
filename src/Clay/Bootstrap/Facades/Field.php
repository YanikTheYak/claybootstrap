<?php

namespace Clay\Bootstrap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Collective\Html\FormBuilder
 */
class Field extends Facade
{
    /**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
    protected static function getFacadeAccessor() { return 'field'; }

}
