<?php

namespace  Namratalohani\FilamentHrSystem\Filament\Widgets;

use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;
use Namratalohani\FilamentHrSystem\Models\Attendance;

class AttendanceWidget extends Widget
{
    protected static string $view = 'attendance::filament.widgets.attendance-widget';

    protected int|string|array $columnSpan = 'full';

    public $currentState = 'out';

    public $latestIn = null;

    public $latestOut = null;

    public $totalHoursToday = 0;

    public $attendances = [];

    public function mount()
    {
        $this->updateAttendanceState();
        $this->calculateTotalHoursToday();
    }

    public function updateAttendanceState()
    {
        $user = Auth::user();

        $latestAttendance = Attendance::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->whereDate('in', '>=', today())
            ->first();

        if ($latestAttendance) {
            $this->latestIn = $latestAttendance->in ? Carbon::parse($latestAttendance->in)->toDateTimeString() : null;
            $this->latestOut = $latestAttendance->out ? Carbon::parse($latestAttendance->out)->toDateTimeString() : null;

            if ($latestAttendance->in && now()->startOfDay()->greaterThan($latestAttendance->in)) {
                $this->currentState = 'out';
            } elseif ($latestAttendance->in && ! $latestAttendance->out) {
                $this->currentState = 'in';
            } else {
                $this->currentState = 'out';
            }
        } else {
            $this->currentState = 'out';
        }
    }

    public function calculateTotalHoursToday()
    {
        $user = Auth::user();

        $this->attendances = Attendance::where('user_id', $user->id)
            ->whereDate('in', today())
            ->get();

        $totalMinutes = 0;

        foreach ($this->attendances as $attendance) {
            $diff = $attendance->out
                ? Carbon::parse($attendance->in)->diffInMinutes(Carbon::parse($attendance->out))
                : 0;

            $totalMinutes += $diff;
        }

        $hours = (int) ($totalMinutes / 60);
        $minutes = $totalMinutes % 60;

        $this->totalHoursToday = "{$hours} hrs {$minutes} mins";
    }

    public function toggleAttendance()
    {
        $user = Auth::user();

        if ($this->currentState === 'out') {
            Attendance::create([
                'user_id' => $user->id,
                'in' => now(),
            ]);
        } elseif ($this->currentState === 'in') {
            $attendance = Attendance::where('user_id', $user->id)
                ->whereNull('out')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($attendance) {
                $attendance->update([
                    'out' => now(),
                ]);
            }
        }

        $this->updateAttendanceState();
        $this->calculateTotalHoursToday();
    }
}
