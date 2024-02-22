@extends('adminlte::page')

@section('title', 'Groups')

@section('content_header')
    <h1>Groups</h1>
@stop

@section('content')
    <form action="{{ route('groups') }}" method="GET">
        <div class="form-group">
            <label for="countStudents">Number of students (less or equal):</label>
            <input type="number" class="form-control col-md-4" id="countStudents" name="count_students" value="{{$count ?? ''}}">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <div class="card-body table-responsive p-0" style="height: 800px;">
        <table class="table table-head-fixed text-nowrap">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Number of students</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
            @foreach($groups as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->students()->count() }}</td>
                    <td><a href="{{ route('group',$group->id ) }}">Details</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
