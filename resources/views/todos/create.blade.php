@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Todos App</div>

                <div class="card-body">

                @if ($errors->any())
                  <div class="alert alert-danger">
                     <ul>
                           @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                     </ul>
                  </div>
               @endif

                <form method="post" action="{{ route('todos.store')}}" enctype="multipart/form-data">
                  @csrf
                  <div class="mb-3">
                     <label class="form-label">Title</label>
                     <input type="text" name="title" class="form-control" >
                  </div>
                  <div class="mb-3">
                     <label class="form-label">Description</label>
                     <textarea name="description" class="form-control" cols="5" rows="5"></textarea>
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Tags</label>
                        <input type="text" name="keywords" class="form-control" data-role="tagsinput">
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Users</label>
                        <select name="id_user_content" class="form-control" multiple>
                           @foreach ($users as $user)
                           @if($user->id != auth()->user()->id)
                              <option value="{{ $user->id }}">{{ $user->name }}</option>
                           @endif
                           @endforeach
                        </select>
                  </div>
                  <div class="mb-3 form-group">
                        <label class="form-label">Role users</label>
                        <select name="role" class="form-control">
                              <option value="">choose a role</option>
                              <option value="0">Role Reader</option>
                              <option value="1">Role Editor</option>
                        </select>
                  </div>
                  <div class="mb-3">
                     <strong>Image:</strong>
                     <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/jpg" placeholder="image">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
               </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
