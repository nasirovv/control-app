@extends('layout')

@section('content')
    <div class="container">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row d-flex justify-content-between">
                        <div class="col-xs-6">
                            <h2>Manage <b>Users</b></h2>
                        </div>
                        <div class="col-xs-6">
                            <a href="{{ route('users.create') }}" class="btn btn-success"><i
                                    class="material-icons">&#xE147;</i> <span>Add New User</span></a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Unique Id</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->uniqueId }}</td>
                            <td><img src="{{ $user->image }}" style="width: 60px" alt="image"></td>
                            <td>
                                <a href="{{ route('users.edit', [$user->id]) }}" class="edit">
                                    <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <form style="display: inline-block" method="post" action={{ route('users.destroy', ['user' => $user->id]) }}>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete" data-toggle="modal">
                                        <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection


