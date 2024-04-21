@extends('adminlte::page')

@section('title', 'Groups')

@section('content_header')
    <h1>Groups</h1>
@stop

@section('content')
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
            @foreach($courses as $course)
                <tr>
                    <td>{{ ucfirst($course->name) }}</td>
                    <td>{{ $course->students()->count() }}</td>
                    <td><a href="{{ route('course',$course->id ) }}">Details</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop
