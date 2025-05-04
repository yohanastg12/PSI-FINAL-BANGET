<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Session;
use App\Room;
use App\StudyProgram;
use App\WeekDay;
use App\Services\CalendarService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index(Request $request, CalendarService $calendarService)
    {
        // Ambil daftar kelas dan guru
        $classes = \App\SchoolClass::pluck('name', 'id');
        $teachers = \App\User::whereHas('roles', function ($query) {
            $query->where('id', 3); // ID 3 = guru
        })->pluck('name', 'id');

        $lessonsQuery = DB::table('lessons')
            ->join('study_program', 'lessons.study_program_id', '=', 'study_program.id') // Join dengan study_programs
            ->join('school_classes', 'lessons.class_id', '=', 'school_classes.id') // Join dengan school_classes
            ->join('sessions', 'lessons.session_id', '=', 'sessions.id') // Join dengan sessions
            ->join('course', 'lessons.course_id', '=', 'course.id') // Join dengan course
            ->join('users as teachers', 'lessons.teacher_id', '=', 'teachers.id') // Join dengan users (alias teachers)
            ->join('weekday', 'lessons.weekday_id', '=', 'weekday.id') // Join dengan weekdays
            ->join('room', 'lessons.room_id', '=', 'room.id') // Join dengan room
            ->select(
                'lessons.*',
                'study_program.name as study_program_name',
                'school_classes.name as class_name',
                'room.name as room_name',
                'course.name as course_name',
                'teachers.name as teacher_name',
                'weekday.name as weekday_name'
            );

        $studyProgramIdRequest = $request->input('study_program_id');
        $yearRequest = $request->input('year');

        if ($studyProgramIdRequest) {
            $lessonsQuery->where('lessons.study_program_id', $studyProgramIdRequest);
        }

        if ($yearRequest) {
            $lessonsQuery->where('lessons.year', $yearRequest);
        }

        $lessons = $lessonsQuery->get();

        $courses = Course::pluck('name', 'id');

        $sessions = Session::orderBy('id')->get()->mapWithKeys(function ($session) {
            return [
                $session->id => \Carbon\Carbon::parse($session->start_time)->format('H:i') . ' - ' .
                    \Carbon\Carbon::parse($session->end_time)->format('H:i')
            ];
        })->toArray();

        $years = DB::table('lessons')
            ->selectRaw('DISTINCT year')
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        $weekdays = Weekday::orderBy('id')->pluck('name', 'id')->toArray();

        $studyPrograms = StudyProgram::pluck('name', 'id');
        $rooms = Room::pluck('name', 'id');

        $calendar = [];

        foreach ($lessons as $lesson) {
            $sessionId = $lesson->session_id;
            $weekdayId = $lesson->weekday_id;

            $calendar[$sessionId][$weekdayId][] = $lesson;
        }

        return view('admin.calendar', compact('classes', 'teachers', 'lessons', 'sessions', 'courses', 'weekdays', 'studyPrograms', 'calendar', 'years', 'rooms'));
    }

    public function clearLessons()
    {
        Lesson::truncate(); // Reset semua lesson
        return redirect()->route('admin.calendar.index')->with('success', 'Semua lesson berhasil dihapus.');
    }
}