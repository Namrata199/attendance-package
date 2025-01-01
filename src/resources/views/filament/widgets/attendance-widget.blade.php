<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-2 gap-2">
            <!-- Attendance Section -->
            <div class="bg-white dark:bg-gray-800 flex flex-col items-center justify-center p-4 rounded-lg shadow">
                <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-8">Attendance</h2>
                
                <div class="mb-6">
                    <button 
                        wire:click="toggleAttendance" 
                        class="px-6 py-3 text-lg font-semibold rounded-lg transition duration-300 
                            {{ $currentState === 'out' ? ' text-white' : 'bg-red-500 hover:bg-red-600 text-white' }}">
                        {{ $currentState === 'out' ? 'Clock In' : 'Clock Out' }}
                    </button>
                    <div class="text-sm text-gray-600 dark:text-gray-300 mt-4">
                        @if ($currentState === 'in')
                            Last Clock-In: {{ $latestIn ? \Carbon\Carbon::parse($latestIn)->format('h:i A') : 'N/A' }}
                        @else
                            Last Clock-Out: {{ $latestOut ? \Carbon\Carbon::parse($latestOut)->format('h:i A') : 'N/A' }}
                        @endif
                    </div>
                </div>

                <div class="mt-6 p-4 bg-blue-100 dark:bg-blue-900 rounded-lg">
                    <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-300">
                        Total Present Today: {{ $totalHoursToday }}
                    </h3>
                </div>
            </div>

            <!-- Today's Attendance Records Section -->
            <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Today's Attendance Records:</h3>
                <table class="table-auto w-full mt-4 text-left border dark:border-gray-700">
                    <thead>
                        <tr class="bg-gray-200 dark:bg-gray-700">
                            <th class="px-4 py-2 text-gray-800 dark:text-gray-200">In Time</th>
                            <th class="px-4 py-2 text-gray-800 dark:text-gray-200">Out Time</th>
                            <th class="px-4 py-2 text-gray-800 dark:text-gray-200">Duration (Minutes)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr class="border-t dark:border-gray-700">
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                    {{ \Carbon\Carbon::parse($attendance->in)->format('h:i A') }}
                                </td>
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                    {{ $attendance->out ? \Carbon\Carbon::parse($attendance->out)->format('h:i A') : 'Ongoing' }}
                                </td>
                                <td class="px-4 py-2 text-gray-800 dark:text-gray-200">
                                    {{ $attendance->out ? (int)(\Carbon\Carbon::parse($attendance->in)->diffInMinutes(\Carbon\Carbon::parse($attendance->out))) : 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
