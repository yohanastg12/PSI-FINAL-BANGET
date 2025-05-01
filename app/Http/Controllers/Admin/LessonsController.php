<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLessonRequest;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Lesson;
use App\SchoolClass;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LessonsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('lesson_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lessons = Lesson::all();

        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        abort_if(Gate::denies('lesson_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $teachers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // Menambahkan sesi waktu
        $sessions = [
            '1' => '08:00 - 08:50',
            '2' => '09:00 - 09:50',
            '3' => '10:00 - 10:50',
            '4' => '11:00 - 11:50',
            '5' => '12:00 - 12:50',
            '6' => '13:00 - 13:50',
            '7' => '14:00 - 14:50',
            '8' => '15:00 - 15:50',
            '9' => '16:00 - 16:50',
            '10' => '17:00 - 17:50',
        ];

        return view('admin.lessons.create', compact('classes', 'teachers', 'sessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'weekday' => 'required',
            'session_id' => 'required',
            'class_id' => 'required',
            'course_id' => 'required',
            'teacher_id' => 'required',
        ]);

        // Simpan data lesson dengan session_id yang dipilih
        Lesson::create([
            'weekday' => $request->weekday,
            'class_id' => $request->class_id,
            'teacher_id' => $request->teacher_id,
            'course_id' => $request->course_id,
            'session_id' => $request->session_id,  // Simpan ID sesi
        ]);

        return redirect()->route('admin.calendar.index')->with('success', 'Lesson added successfully.');
    }

    public function edit(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $classes = SchoolClass::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $teachers = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        // Menambahkan sesi waktu
        $sessions = [
            '1' => '08:00 - 08:50',
            '2' => '09:00 - 09:50',
            '3' => '10:00 - 10:50',
            '4' => '11:00 - 11:50',
            '5' => '13:00 - 13:50',
            '6' => '14:00 - 14:50',
            '7' => '15:00 - 15:50',
            '8' => '16:00 - 16:50',

        ];

        return view('admin.lessons.edit', compact('classes', 'teachers', 'lesson', 'sessions'));
    }

    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->update([
            'weekday' => $request->weekday,
            'class_id' => $request->class_id,
            'teacher_id' => $request->teacher_id,
            'session_id' => $request->session_id,  // Simpan ID sesi
        ]);

        return redirect()->route('admin.lessons.index');
    }

    public function show(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lesson->load('class', 'teacher');

        return view('admin.lessons.show', compact('lesson'));
    }

    public function destroy(Lesson $lesson)
    {
        abort_if(Gate::denies('lesson_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lesson->delete();

        return back();
    }

    public function massDestroy(MassDestroyLessonRequest $request)
    {
        Lesson::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function clearAllLessons()
    {
        Lesson::truncate(); // Menghapus semua data di tabel lessons
        return redirect()->route('admin.calendar.index')->with('success', 'Semua data lesson berhasil dihapus.');
    }

    public function getLessons()
    {
        $lessons = Lesson::with(['class', 'teacher'])->get()->map(function ($lesson) {
            $sessions = [
                '1' => ['start' => '08:00', 'end' => '08:50'],
                '2' => ['start' => '09:00', 'end' => '09:50'],
                '3' => ['start' => '10:00', 'end' => '10:50'],
                '4' => ['start' => '11:00', 'end' => '11:50'],
                '5' => ['start' => '12:00', 'end' => '12:50'],
                '6' => ['start' => '13:00', 'end' => '13:50'],
                '7' => ['start' => '14:00', 'end' => '14:50'],
                '8' => ['start' => '15:00', 'end' => '15:50'],
                '9' => ['start' => '16:00', 'end' => '16:50'],
                '10' => ['start' => '17:00', 'end' => '17:50'],
            ];

            $session = $sessions[$lesson->session_id];  // Ambil waktu berdasarkan session_id

            return [
                'id' => $lesson->id,
                'weekday' => $lesson->weekday,
                'class' => $lesson->class->name ?? '-',
                'teacher' => $lesson->teacher->name ?? '-',
                'start_session' => $session['start'],
                'end_session' => $session['end'],
            ];
        });

        return response()->json($lessons);
    }
}