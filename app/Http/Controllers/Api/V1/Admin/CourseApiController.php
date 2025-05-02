<?php

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CourseResource;
use App\Course;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CourseApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('school_class_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CourseResource(Course::all());
    }
}