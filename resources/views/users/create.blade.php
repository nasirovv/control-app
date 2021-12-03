@extends('layout')

@section('content')
    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
            <h4 class="modal-title">Add Employee</h4>
            <a href="{{ route('users.index') }}" class="close" aria-hidden="true">&times;</a>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
            </div>
            <div class="form-group">
                <label>Unique Id</label>
                <input type="text" name="uniqueId" class="form-control @error('uniqueId') is-invalid @enderror"
                       required>
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            </div>
        </div>
        <div class="modal-footer">
            <a href="{{ route('users.index') }}" class="btn btn-default">
                Cancel
            </a>
            <input type="submit" class="btn btn-success" value="Add">
        </div>
    </form>
@endsection
