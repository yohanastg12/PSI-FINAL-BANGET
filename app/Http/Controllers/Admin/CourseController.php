<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Course;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Requests\StoreCourseRequest;


class CourseController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('course_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $courses = Course::all();

        return view('admin.course.index', compact('courses'));
    }

    public function show(Course $course)
    {
        abort_if(Gate::denies('course_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $course->load('classLessons', 'classUsers');

        return view('admin.course.show', compact('course'));
    }

    public function create()
    {
        abort_if(Gate::denies('course_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.course.create');
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->all());

        return redirect()->route('admin.course.index');
    }

    public function edit(Course $course)
    {
        abort_if(Gate::denies('course_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.course.edit', compact('course'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->all());

        return redirect()->route('admin.course.index');
    }

    public function destroy(Course $course)
    {
        abort_if(Gate::denies('course_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $course->delete();

        return back();
    }

    public function massDestroy(MassDestroyCourseRequest $request)
    {
        Course::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}