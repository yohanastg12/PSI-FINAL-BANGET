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
            <h2 class="text-2xl font-bold mb-4">{{ trans('cruds.lesson.title_singular') }} {{ trans('global.list') }}</h2>
            <form method="GET" action="">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label for="classSelect" class="block text-gray-700 font-bold mb-2">Filter by Study Program</label>
                        <select name="class" id="classSelect" class="block w-full bg-white border border-gray-300 rounded-md py-2 px-3 shadow-sm">
                            <option value="">Select Study Program</option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Elektro">Elektro</option>
                            <option value="Informatika">Informatika</option>
                            <option value="Teknologi Informasi">Teknologi Informasi</option>
                            <option value="Teknologi Komputer">Teknologi Komputer</option>
                            <option value="Teknologi Rekayasa Perangkat Lunak">Teknologi Rekayasa Perangkat Lunak</option>
                            <option value="Bioproses">Bioproses</option>
                            <option value="Manajemen Rekayasa">Manajemen Rekayasa</option>
                            <option value="Metalurgi">Metalurgi</option>
                        </select>
                    </div>
                    <div>
                        <label for="yearSelect" class="block text-gray-700 font-bold mb-2">Filter by Year</label>
                        <select name="year" id="yearSelect" class="block w-full bg-white border border-gray-300 rounded-md py-2 px-3 shadow-sm">
                            <option value="">Select Year</option>
                            <option value="2019">2019</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition duration-200">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.lesson.title_singular') }} {{ trans('global.list') }}
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.calendar.clear-lessons') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua lesson?')">
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
                        
                        @foreach($sesiWaktu as $sesi => $waktu)
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
                                        data-time="{{ $waktu }}"
                                        data-day="{{ $dayIndex }}">
                                        <div class="font-semibold text-indigo-700">{{ $value['class_name'] }}</div>
                                        <div class="text-xs text-gray-600">Teacher: {{ $value['teacher_name'] }}</div>
                                    </td>
                                @else
                                    <td class="clickable-cell" data-time="{{ $waktu }}" data-day="{{ $dayIndex }}"></td>
                                @endif
                            @endfor
                        </tr>
                    @endforeach                        </tbody>
                                            </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Pop-Up -->
    <div id="lessonModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-semibold">Lesson Details</h3>
            <div id="lessonContent" class="mt-2">
                <p><strong>Class:</strong> <span id="modal-class"></span></p>
                <p><strong>Teacher:</strong> <span id="modal-teacher"></span></p>
                <p><strong>Start Time:</strong> <span id="modal-start-time"></span></p>
            </div>
            <div class="flex justify-end mt-3">
                <button id="closeModal" class="bg-gray-500 px-4 py-2 rounded-md text-white">Close</button>
            </div>
        </div>
    </div>
    </body>
    </html>
    @endsection

    @section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.clickable-cell').click(function() {
                let className = $(this).data('class');
                let teacherName = $(this).data('teacher');
                let startTime = $(this).data('time');

                if (!className || !teacherName || !startTime) {
                    console.error('Lesson data is missing!');
                    return;
                }

                $('#modal-class').text(className);
                $('#modal-teacher').text(teacherName);
                $('#modal-start-time').text(startTime);

                $('#lessonModal').removeClass('hidden');
            });

            $('#closeModal').click(function() {
                $('#lessonModal').addClass('hidden');
            });
        });
    </script>
    @endsection