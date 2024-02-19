@extends('adminlte::page')
@section('js')
    <script src="https://kit.fontawesome.com/5b269200c6.js" crossorigin="anonymous"></script>
    <script>
        function confirmDelete(studentId) {
            if (confirm('Are you sure you want to delete this student?')) {
                document.getElementById('deleteForm_' + studentId).submit();
            }
        }
    </script>
@endsection

@section('title', 'Dashboard')

@section('content_header')
    <h1>Students</h1>
@stop

@section('content')
    @if(Session::has('success'))
        <div class="alert alert-info alert-dismissible col-md-4">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-info"></i>Deleted</h5>
            {{ Session::get('success') }}
        </div>
    @endif

    <form action="{{ route('students') }}" method="GET">
        <div class="form-group">
            <label for="groupFilter">Filter by Group:</label>
            <select name="group_id" id="groupFilter" class="form-control col-md-4">
                <option value="">All</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $selectedGroup == $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div style="width: fit-content">
        <a href="/student-add">
            <button type="button" class="btn btn-block btn-primary">Add student</button>
        </a>
    </div>

    <div class="card-body table-responsive p-0" style="height: 800px;">
        <table class="table table-head-fixed text-nowrap">
            {{ $students->links('vendor/pagination/default') }}
            <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Group</th>
                <th>Link</th>
            </tr>
            </thead>
            <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->last_name }}</td>
                    @php($group = $student->group->name ?? '-')
                    <td>{{ $group }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <form id="deleteForm_{{ $student->id }}" action="{{ route('studentDelete', $student->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm mr-2" onclick="confirmDelete({{ $student->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('student', $student->id) }}" class="mr-2"><i class="fa-solid fa-user"></i></a>
                            <span class="mr-2">Next icon</span>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
