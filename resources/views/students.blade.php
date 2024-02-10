@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Students</h1>
@stop

@section('content')
    <div class="card-body table-responsive p-0" style="height: 800px;">
        <table class="table table-head-fixed text-nowrap">
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
                        <a href="/student/{{ $student->id }}">
                            Personal link
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
