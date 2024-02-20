@extends('adminlte::page')

@section('js')
    <script src="https://kit.fontawesome.com/5b269200c6.js" crossorigin="anonymous"></script>
@endsection

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ $student->first_name . ' ' . $student->last_name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card card-widget widget-user-2">
                <div class="widget-user-header bg-warning">

                    <div class="widget-user-image">
                        <img class="" alt="User Avatar">
                    </div>

                    <h3 class="widget-user-username">{{ $student->first_name . ' ' . $student->last_name }}</h3>
                    <h5 class="widget-user-desc">Student</h5>

                </div>
            <div class="card-footer p-0">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        @php
                            $group = $student->group;
                            if (is_null($group)) {
                                $groupName = 'Out of group';
                                $groupStudents = 0;
                                $link = '';
                            } else {
                                $groupName = 'Group ' . $group->name;
                                $groupStudents = $group->students->count();
                                $link = route('group', $group->id);
                            }
                        @endphp
                        <a href="{{ $link }}" class="nav-link">
                            {{ $groupName }} <span class="float-right badge bg-primary">{{ $groupStudents }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Courses <span class="float-right badge bg-info">{{ count($student->courses) }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-primary collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Student Courses</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

            </div>

            <div class="card-body">
                <ul class="nav flex-column">
                    @foreach($student->courses as $course)
                        <li class="nav-item">
                            <span class="nav-link">{{ ucfirst($course->name) }}</span>
                        </li>
                    @endforeach
                </ul>

            </div>

        </div>

    </div>
    </div>

@stop
