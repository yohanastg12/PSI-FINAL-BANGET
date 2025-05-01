<?php

namespace App\Services;

use App\Lesson;

class CalendarService
{
    public function generateCalendarData($weekDays)
    {
        $calendarData = [];

        // Daftar waktu sesi tetap
        $sesiWaktu = [
            1 => ['08:00', '08:50'],
            2 => ['09:00', '09:50'],
            3 => ['10:00', '10:50'],
            4 => ['11:00', '11:50'],
            5 => ['13:00', '13:50'],
            6 => ['14:00', '14:50'],
            7 => ['15:00', '15:50'],
            8 => ['16:00', '16:50'],
        ];

        // Ambil semua lesson dengan relasi yang diperlukan
        $lessons = Lesson::with(['class', 'teacher'])
            ->calendarByRoleOrClassId()
            ->get();

        // Inisialisasi struktur kalender kosong
        foreach ($sesiWaktu as $sesi => $range) {
            foreach ($weekDays as $index => $day) {
                $calendarData[$sesi][$index] = null;
            }
        }

        // Isi data pelajaran sesuai sesi dan hari
        foreach ($lessons as $lesson) {
            $sessionNumber = $lesson->session_id;

            if ($sessionNumber && isset($calendarData[$sessionNumber][$lesson->weekday_id])) {
                [$startTime, $endTime] = $sesiWaktu[$sessionNumber];

                $calendarData[$sessionNumber][$lesson->weekday_id] = [
                    'class_name' => $lesson->class->name ?? '-',
                    'teacher_name' => $lesson->teacher->name ?? '-',
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ];
            }
        }
        return $calendarData;
    }
}