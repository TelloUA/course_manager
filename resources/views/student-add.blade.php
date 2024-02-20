@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Add student</h1>
@stop

@section('content')
    <div class="col-md-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add student</h3>
            </div>
            <form method="post" action="/student-save/">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="firstName">First name</label>
                        <input type="text" class="form-control" name="firstName" placeholder="Enter first name">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last name</label>
                            <input type="text" class="form-control" name="lastName" placeholder="Enter last name">
                    </div>
                    <div class="form-group">
                        <label for="groupId">Group</label>
                        <select class="form-control" name="groupId">
                            <option></option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}">{{ ucfirst($group->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@stop
