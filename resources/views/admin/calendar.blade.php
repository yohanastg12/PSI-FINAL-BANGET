    @extends('layouts.admin')
    @section('content')
        <html>

        <head>
            <style>
                .lesson-table {
                    table-layout: fixed;
                    width: 100%;
                }

                .lesson-table th,
                .lesson-table td {
                    word-wrap: break-word;
                    word-break: break-word;
                    text-align: center;
                    vertical-align: top;
                    padding: 8px;
                }
            </style>
            <script src="https://cdn.tailwindcss.com"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        </head>

        <body class="bg-gray-100">
            <div class="container mx-auto p-4">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-2xl font-bold mb-4">{{ trans('cruds.lesson.title_singular') }} {{ trans('global.list') }}
                    </h2>
                    <form method="GET" action="">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label for="classSelect" class="block text-gray-700 font-bold mb-2">Filter by Study
                                    Program</label>
                                <select name="class" id="classSelect"
                                    class="block w-full bg-white border border-gray-300 rounded-md py-2 px-3 shadow-sm">
                                    <option value="">Select Study Program</option>
                                    <option value="Sistem Informasi">Sistem Informasi</option>
                                    <option value="Elektro">Elektro</option>
                                    <option value="Informatika">Informatika</option>
                                    <option value="Teknologi Informasi">Teknologi Informasi</option>
                                    <option value="Teknologi Komputer">Teknologi Komputer</option>
                                    <option value="Teknologi Rekayasa Perangkat Lunak">Teknologi Rekayasa Perangkat Lunak
                                    </option>
                                    <option value="Bioproses">Bioproses</option>
                                    <option value="Manajemen Rekayasa">Manajemen Rekayasa</option>
                                    <option value="Metalurgi">Metalurgi</option>
                                </select>
                            </div>
                            <div>
                                <label for="yearSelect" class="block text-gray-700 font-bold mb-2">Filter by Year</label>
                                <select name="year" id="yearSelect"
                                    class="block w-full bg-white border border-gray-300 rounded-md py-2 px-3 shadow-sm">
                                    <option value="">Select Year</option>
                                    <option value="2019">2019</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit"
                                    class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-200">
                                    <i class="fas fa-filter mr-2"></i>Filter
                                </button>
                                <button id="modalBtnAddLesson" type="button"
                                    class="ml-2 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-200">Add
                                    Lesson</button>
                            </div>
                        </div>
                    </form>
                    <div class="card">
                        <div class="card-header">
                            {{ trans('cruds.lesson.title_singular') }} {{ trans('global.list') }}
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.calendar.clear-lessons') }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus semua lesson?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mb-3">Hapus Semua Lesson</button>
                            </form>
                            <table class="lesson-table table-bordered table-striped w-full">
                                <thead>
                                    <tr>
                                        <th>Sesi</th>
                                        <th>Sunday</th>
                                        <th>Monday</th>
                                        <th>Tuesday</th>
                                        <th>Wednesday</th>
                                        <th>Thursday</th>
                                        <th>Friday</th>
                                        <th>Saturday</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $sesiWaktu = [
                                            1 => '08:00 - 08:50',
                                            2 => '09:00 - 09:50',
                                            3 => '10:00 - 10:50',
                                            4 => '11:00 - 11:50',
                                            5 => '13:00 - 13:50',
                                            6 => '14:00 - 14:50',
                                            7 => '15:00 - 15:50',
                                            8 => '16:00 - 16:50',
                                        ];
                                    @endphp

                                    @foreach ($sesiWaktu as $sesi => $waktu)
                                        <tr>
                                            <td>Sesi {{ $sesi }}<br><small>{{ $waktu }}</small></td>
                                            @for ($dayIndex = 0; $dayIndex < 7; $dayIndex++)
                                                @php
                                                    $value = $calendarData[$sesi][$dayIndex] ?? null;
                                                @endphp

                                                @if (is_array($value))
                                                    <td class="align-middle text-center clickable-cell bg-gray-100"
                                                        data-class="{{ $value['class_name'] }}"
                                                        data-teacher="{{ $value['teacher_name'] }}"
                                                        data-time="{{ $waktu }}" data-day="{{ $dayIndex }}">
                                                        <div class="font-semibold text-indigo-700">
                                                            {{ $value['class_name'] }}</div>
                                                        <div class="text-xs text-gray-600">Teacher:
                                                            {{ $value['teacher_name'] }}</div>
                                                    </td>
                                                @else
                                                    <td class="clickable-cell" data-time="{{ $waktu }}"
                                                        data-day="{{ $dayIndex }}"></td>
                                                @endif
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div id="addLessonModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Tambah Pelajaran Baru
                                    </h3>
                                    <div class="mt-2">
                                        <div class="card-body">
                                            <form method="POST" action="{{ route('admin.lessons.store') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="required"
                                                        for="class_id">{{ trans('cruds.lesson.fields.class') }}</label>
                                                    <select
                                                        class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}"
                                                        name="class_id" id="class_id" required>
                                                        @foreach ($classes as $id => $class)
                                                            <option value="{{ $id }}"
                                                                {{ old('class_id') == $id ? 'selected' : '' }}>
                                                                {{ $class }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('class'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('class') }}
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="help-block">{{ trans('cruds.lesson.fields.class_helper') }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="required"
                                                        for="teacher_id">{{ trans('cruds.lesson.fields.teacher') }}</label>
                                                    <select
                                                        class="form-control select2 {{ $errors->has('teacher') ? 'is-invalid' : '' }}"
                                                        name="teacher_id" id="teacher_id" required>
                                                        @foreach ($teachers as $id => $teacher)
                                                            <option value="{{ $id }}"
                                                                {{ old('teacher_id') == $id ? 'selected' : '' }}>
                                                                {{ $teacher }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('teacher'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('teacher') }}
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="help-block">{{ trans('cruds.lesson.fields.teacher_helper') }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="required"
                                                        for="weekday">{{ trans('cruds.lesson.fields.weekday') }}</label>
                                                    <input
                                                        class="form-control {{ $errors->has('weekday') ? 'is-invalid' : '' }}"
                                                        type="number" name="weekday" id="weekday"
                                                        value="{{ old('weekday') }}" step="1" required>
                                                    @if ($errors->has('weekday'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('weekday') }}
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="help-block">{{ trans('cruds.lesson.fields.weekday_helper') }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="required"
                                                        for="session_id">{{ trans('cruds.lesson.fields.session') }}</label>
                                                    <select
                                                        class="form-control select2 {{ $errors->has('session_id') ? 'is-invalid' : '' }}"
                                                        name="session_id" id="session_id" required>
                                                        @foreach ($sessions as $id => $session)
                                                            <option value="{{ $id }}"
                                                                {{ old('session_id') == $id ? 'selected' : '' }}>
                                                                {{ $session }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('session_id'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('session_id') }}
                                                        </div>
                                                    @endif
                                                    <span
                                                        class="help-block">{{ trans('cruds.lesson.fields.session_helper') }}</span>
                                                </div>
                                                <div class="form-group">
                                                    <button type="button" id="closeModalBtn"
                                                        class="inline-flex justify-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 transition duration-150">
                                                        Batal
                                                    </button>
                                                    <button
                                                        class="inline-flex justify-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                                                        {{ trans('global.save') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </body>

        </html>
    @endsection

    @section('scripts')
        @parent
        <script>
            const modalBtnAddLesson = document.getElementById('modalBtnAddLesson');
            const closeModalBtn = document.getElementById('closeModalBtn');
            const addLessonModal = document.getElementById('addLessonModal');

            modalBtnAddLesson.addEventListener('click', () => {
                addLessonModal.classList.remove('hidden');
            });

            closeModalBtn.addEventListener('click', () => {
                addLessonModal.classList.add('hidden');
            });

            // Tutup modal jika area di luar modal diklik
            window.addEventListener('click', (event) => {
                if (event.target === addLessonModal) {
                    addLessonModal.classList.add('hidden');
                }
            });
        </script>
    @endsection
