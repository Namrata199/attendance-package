<?php

namespace Namratalohani\FilamentHrSystem\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $fillable = ['user_id', 'in', 'out'];
}
