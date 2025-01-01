<?php

namespace Namratalohani\FilamentHrSystem;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Namratalohani\FilamentHrSystem\Skeleton\SkeletonClass
 */
class FilamentHrSystemFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'filament-hr-system';
    }
}
