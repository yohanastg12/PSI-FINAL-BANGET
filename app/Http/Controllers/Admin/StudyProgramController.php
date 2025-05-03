<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreStudyProgramRequest;
use App\Http\Requests\UpdateStudyProgramRequest;
use App\Http\Requests\MassDestroyStudyProgramRequest;
use App\StudyProgram;

class StudyProgramController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('study_program_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studyPrograms = StudyProgram::all();

        return view('admin.studyProgram.index', compact('studyPrograms'));
    }

    public function show(StudyProgram $studyProgram)
    {
        abort_if(Gate::denies('study_program_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studyProgram.show', compact('studyProgram'));
    }

    public function create()
    {
        abort_if(Gate::denies('study_program_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studyProgram.create');
    }

    public function store(StoreStudyProgramRequest $request)
    {
        $studyProgram = StudyProgram::create($request->all());

        return redirect()->route('admin.study-program.index');
    }

    public function edit(StudyProgram $studyProgram)
    {
        abort_if(Gate::denies('study_program_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.studyProgram.edit', compact('studyProgram'));
    }

    public function update(UpdateStudyProgramRequest $request, StudyProgram $studyProgram)
    {
        $studyProgram->update($request->all());

        return redirect()->route('admin.study-program.index');
    }

    public function destroy(StudyProgram $studyProgram)
    {
        abort_if(Gate::denies('study_program_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $studyProgram->delete();

        return back();
    }

    public function massDestroy(MassDestroyStudyProgramRequest $request)
    {
        StudyProgram::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}