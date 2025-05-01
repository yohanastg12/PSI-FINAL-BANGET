<?php

namespace App\Services;

use App\Lesson;
use App\Session;

class CalendarService
{
    public function generateCalendarData($weekDays)
    {
        $calendarData = [];

        // Daftar waktu sesi tetap
        $sesiWaktu = Session::orderBy('id')->get()->mapWithKeys(function ($session) {
            return [
                $session->id => \Carbon\Carbon::parse($session->start_time)->format('H:i') . ' - ' .
                    \Carbon\Carbon::parse($session->end_time)->format('H:i')
            ];
        })->toArray();

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