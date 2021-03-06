@extends('layout')

@section('content')
    <form action="{{ route('users.update', ['user' => $id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
            <h4 class="modal-title">Edit Employee {{ $id }}</h4>
            <a href="{{ route('users.index') }}" class="close" aria-hidden="true">&times;</a>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value={{ $oldName }}>
            </div>
            <div class="form-group">
                <label>Unique Id</label>
                <input type="text" class="form-control @error('uniqueId') is-invalid @enderror" name="uniqueId" value="{{ $oldUniqueId }}">
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" title="{{ $image }}">
            </div>
        </div>
        <div class="modal-footer">
            <a href="{{ route('users.index') }}" class="btn btn-default">
                Cancel
            </a>
            <input type="submit" class="btn btn-info" value="Save">
        </div>
    </form>
@endsection
