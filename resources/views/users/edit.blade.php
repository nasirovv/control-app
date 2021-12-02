@extends('layout')

@section('content')
    <form action="{{ route('users.update', ['user' => $id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
            <h4 class="modal-title">Edit Employee {{ $id }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="name" value={{ $oldName }}>
            </div>
            <div class="form-group">
                <label>Unique Id</label>
                <input type="text" class="form-control" name="uniqueId" value="{{ $oldUniqueId }}">
            </div>
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image" title="{{ $image }}">
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
            <input type="submit" class="btn btn-info" value="Save">
        </div>
    </form>
@endsection
