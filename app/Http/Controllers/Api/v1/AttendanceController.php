<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Return the authenticated employee's attendance status for today.
     */
    public function today(Request $request): JsonResponse
    {
        $user = $request->user();
        $employee = $user->employee;

        if (! $employee) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'No employee record found for this user.',
            ]);
        }

        $today = Carbon::today();
        $now = Carbon::now();

        $checkIn = AttendanceLog::where('employee_id', $employee->id)
            ->where('type', 'check_in')
            ->whereDate('recorded_at', $today)
            ->orderBy('recorded_at', 'asc')
            ->first();

        $checkOut = AttendanceLog::where('employee_id', $employee->id)
            ->where('type', 'check_out')
            ->whereDate('recorded_at', $today)
            ->orderBy('recorded_at', 'desc')
            ->first();

        if (! $checkIn) {
            return response()->json([
                'success' => true,
                'data' => [
                    'status' => 'absent',
                    'check_in' => null,
                    'check_out' => null,
                    'expected_checkout' => null,
                    'hours_worked' => 0,
                    'hours_target' => 9,
                    'progress_pct' => 0,
                    'can_checkout' => false,
                    'branch' => $employee->branch,
                ],
                'message' => 'No check-in recorded for today.',
            ]);
        }

        $checkInTime = Carbon::parse($checkIn->recorded_at);
        $shiftStart = Carbon::today()->setTime(9, 0, 0);
        $flexDeadline = Carbon::today()->setTime(10, 0, 0);

        if ($checkInTime->lessThanOrEqualTo($shiftStart)) {
            $status = 'on_time';
        } elseif ($checkInTime->lessThanOrEqualTo($flexDeadline)) {
            $status = 'within_flex';
        } else {
            $status = 'late';
        }

        $expectedCheckout = $checkInTime->copy()->addHours(9);
        $referenceTime = $checkOut ? Carbon::parse($checkOut->recorded_at) : $now;
        $hoursWorked = $referenceTime->greaterThan($checkInTime)
            ? $checkInTime->diffInSeconds($referenceTime) / 3600
            : 0;
        $hoursTarget = 9;
        $progressPct = min(100, round(($hoursWorked / $hoursTarget) * 100, 1));
        $canCheckout = $hoursWorked >= $hoursTarget;

        return response()->json([
            'success' => true,
            'data' => [
                'status' => $status,
                'check_in' => $checkInTime->toDateTimeString(),
                'check_out' => $checkOut?->recorded_at?->toDateTimeString(),
                'expected_checkout' => $expectedCheckout->toDateTimeString(),
                'hours_worked' => round($hoursWorked, 2),
                'hours_target' => $hoursTarget,
                'progress_pct' => $progressPct,
                'can_checkout' => $canCheckout,
                'branch' => $checkIn->branch ?? $employee->branch,
            ],
            'message' => 'Attendance retrieved successfully.',
        ]);
    }
}
