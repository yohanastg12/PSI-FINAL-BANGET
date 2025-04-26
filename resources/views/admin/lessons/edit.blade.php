    @extends('layouts.admin')
    @section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.lesson.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.lessons.update", [$lesson->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="class_id">{{ trans('cruds.lesson.fields.class') }}</label>
                    <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}" name="class_id" id="class_id" required>
                        @foreach($classes as $id => $class)
                            <option value="{{ $id }}" {{ ($lesson->class ? $lesson->class->id : old('class_id')) == $id ? 'selected' : '' }}>{{ $class }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('class'))
                        <div class="invalid-feedback">
                            {{ $errors->first('class') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="teacher_id">{{ trans('cruds.lesson.fields.teacher') }}</label>
                    <select class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}" name="teacher_id" id="teacher_id" required>
                        @foreach($teachers as $id => $teacher)
                            <option value="{{ $id }}" {{ ($lesson->teacher ? $lesson->teacher->id : old('teacher_id')) == $id ? 'selected' : '' }}>{{ $teacher }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('teacher'))
                        <div class="invalid-feedback">
                            {{ $errors->first('teacher') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.lesson.fields.teacher_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="weekday">{{ trans('cruds.lesson.fields.weekday') }}</label>
                    <input class="form-control {{ $errors->has('weekday') ? 'is-invalid' : '' }}" type="number" name="weekday" id="weekday" value="{{ old('weekday', $lesson->weekday) }}" step="1" required>
                    @if($errors->has('weekday'))
                        <div class="invalid-feedback">
                            {{ $errors->first('weekday') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.lesson.fields.weekday_helper') }}</span>
                </div>

                <!-- Ganti start_time dan end_time dengan session_id -->
                <div class="form-group">
                    <label class="required" for="session_id">{{ trans('cruds.lesson.fields.session') }}</label>
                    <select class="form-control select2 {{ $errors->has('session_id') ? 'is-invalid' : '' }}" name="session_id" id="session_id" required>
                        @foreach($sessions as $id => $session)
                            <option value="{{ $id }}" {{ ($lesson->session ? $lesson->session->id : old('session_id')) == $id ? 'selected' : '' }}>{{ $session }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('session_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('session_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.lesson.fields.session_helper') }}</span>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @endsection
