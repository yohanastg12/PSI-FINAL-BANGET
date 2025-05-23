<?php
$user = Auth::user();
$roleId = Auth::user()->roles->first()->id ?? null;
$roleName = Auth::user()->roles->first()->name ?? null;
?>

<div class="sidebar">
    <nav class="sidebar-nav">

        <ul class="nav">
            <li class="nav-item">
                @if ($roleId == 2)
                    <a href="{{ route('baa.dashboard') }}" class="nav-link">
                    @else
                        <a href="{{ route('admin.home') }}" class="nav-link">
                @endif
                <i class="nav-icon fas fa-fw fa-tachometer-alt"></i>
                {{ trans('global.dashboard') }}
                </a>
            </li>
            @can('user_management_access')
                <li class="nav-item nav-dropdown">
                    <a class="nav-link  nav-dropdown-toggle" href="#">
                        <i class="fa-fw fas fa-users nav-icon"></i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="nav-dropdown-items">
                        @can('permission_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.permissions.index') }}"
                                    class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-unlock-alt nav-icon"></i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-briefcase nav-icon"></i>
                                    {{ trans('cruds.role.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-user nav-icon"></i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                            
                        @endcan
                        @can('school_class_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.school-classes.index') }}"
                                    class="nav-link {{ request()->is('admin/school-classes') || request()->is('admin/school-classes/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-school nav-icon"></i>
                                    {{ trans('cruds.schoolClass.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('course_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.course.index') }}"
                                    class="nav-link {{ request()->is('admin/course') || request()->is('admin/course/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-book nav-icon"></i>
                                    {{ trans('cruds.course.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('study_program_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.study-program.index') }}"
                                    class="nav-link {{ request()->is('admin/study-program') || request()->is('admin/study-program/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-book nav-icon"></i>
                                    {{ trans('cruds.studyProgram.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('room_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.room.index') }}"
                                    class="nav-link {{ request()->is('admin/room') || request()->is('admin/room/*') ? 'active' : '' }}">
                                    <i class="fa-fw fas fa-book nav-icon"></i>
                                    {{ trans('cruds.room.title') }}
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            {{-- @can('lesson_access')
                <li class="nav-item">
                    <a href="{{ route('admin.lessons.index') }}"
                        class="nav-link {{ request()->is('admin/lessons') || request()->is('admin/lessons/*') ? 'active' : '' }}">
                        <i class="fa-fw fas fa-clock nav-icon"></i>
                        {{ trans('cruds.lesson.title') }}
                    </a>
                </li>
            @endcan --}}
            <li class="nav-item">
                <a href="{{ route('admin.calendar.index') }}"
                    class="nav-link {{ request()->is('admin/calendar') || request()->is('admin/calendar/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-calendar nav-icon"></i>
                    Calendar
                </a>
            </li>
            <li class="nav-item">
                @if ($roleId == 1 || $roleId == 2)
                    <a href="{{ route('baa.dashboard') }}"
                        class="nav-link {{ request()->is('baa/dashboard') ? 'active' : '' }}">
                    @else
                        <a href="{{ route('student.ticket.index') }}"
                            class="nav-link {{ request()->is('admin/admin/ticketing') ? 'active' : '' }}">
                @endif
                <i class="fa-fw fas fa-ticket-alt nav-icon"></i>
                Ticketing
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link"
                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt"></i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
