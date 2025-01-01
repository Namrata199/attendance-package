<?php 

namespace Namratalohani\FilamentHrSystem\Traits;

use Namratalohani\FilamentHrSystem\Models\Attendance;

trait HasAttendances
{
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}
