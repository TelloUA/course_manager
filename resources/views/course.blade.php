@extends('adminlte::page')

@section('js')
    <script src="https://kit.fontawesome.com/5b269200c6.js" crossorigin="anonymous"></script>

    <script>
        document.getElementById('userPlusIcon').addEventListener('click', function() {
            document.getElementById('addStudentFormContainer').style.display = 'block';
        });
    </script>
    <script>
        function confirmDelete(studentId) {
            if (confirm('Are you sure you want to delete this student from this group?')) {
                document.getElementById('deleteForm_' + studentId).submit();
            }
        }
    </script>
@endsection

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ ucfirst($course->name) }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="margin-bottom: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $course->students->count() }}</h3>
                    <h4>students on course</h4>
                </div>
                <div class="icon" id="userPlusIcon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="card-footer"  id="addStudentFormContainer" style="display: none;">
                    <form action="{{ route('courseAddStudent', $course->id) }}" method="post">
                        @csrf
                        <div class="input-group">
                            <select class="form-control" name="studentId" id="studentId">
                                <option></option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">{{ $student->getFullName() }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-append">
                            <button type="submit" class="btn btn-success">Add</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-primary collapsed-card">
                <div class="card-header">
                    <h3 class="card-title">Students</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>

                </div>

                <div class="card-body">
                    <ul class="nav flex-column">
                        @foreach($course->students()->orderBy('first_name')->get() as $student)
                            <li class="nav-item d-flex align-items-center justify-content-between">
                                <span class="nav-link">
                                    <a href="{{ route('student', $student->id) }}">{{ $student->getFullName() }}</a>
                                </span>
                                <form id="deleteForm_{{ $student->id }}"
                                      action="{{ route('courseRemoveStudent', $course->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="studentId" value="{{ $student->id }}" >
                                    <button type="button" class="btn btn-sm" onclick="confirmDelete({{ $student->id }})">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

@stop
