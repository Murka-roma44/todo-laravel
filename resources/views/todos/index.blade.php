@extends('layouts.app')
@section('styles')
<style>
   #outer{
      width: auto;
      text-align: center;
   }
   .inner{
      display: inline-block;
   }
</style>
@endsection
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-4">
      <div class="card">
         <div class="card-body">

            <!-- @if ($errors->any())
            <div class="alert alert-danger">
               <ul>
                     @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                     @endforeach
               </ul>
            </div>
            @endif -->

            <form enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="ajax" value="ajax">
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
            <div class="mb-3">
               <strong>Image:</strong>
               <input type="file" name="image" class="form-control" accept="image/png, image/jpeg, image/jpg" placeholder="image">
            </div>
            <button id="btn-save" type="submit" class="btn btn-primary">Submit</button>
            </form>

         </div>
      </div>
   </div>
   <div class="col-md-8">
      <div class="card">
         <div class="card-header">{{ __('Dashboard') }} <a class="btn btn-sm btn-info float-end" href="{{ route('todos.create' )}}">Create todo</a></div>
         <div class="card-header">     
            <div class="filter-container">
               <h2>Filter</h2>
               <form class="row">
                     @csrf
                     <input name="user_id" type="hidden" class="form-control" value="{{ auth()->user()->id }}">
                     <div class="col-md-3">
                        <label for="">Search Title</label>
                        <input name="title" type="text" class="form-control" >
                     </div>

                     <div class="col-md-2">
                        <label for="">Completed</label>
                        <select name="completed" class="form-control" >
                           <option value="">Choose One</option>
                           <option value="1">Completed</option>
                           <option value="0">in Completed</option>
                        </select>
                     </div>

                     <div class="col-md-3">
                        <label for="">Tags</label>
                        <input name="tags" type="text" class="form-control" >
                     </div>

                     <div class="col-md-2" style="display: flex;align-items: flex-end;" >
                        <div>
                           <button type="submit" class="btn btn-primary" >Filter</button>
                        </div>
                     </div>
               </form>
            </div>
         </div>

         <div id="table" class="card-body">
               
                  <!-- @if (Session::has('alert-success'))
                     <div class="alert alert-secondary" role="alert">
                        {{ Session::get('alert-success') }}
                     </div>
                  @endif

                  @if (Session::has('alert-info'))
                     <div class="alert alert-secondary" role="alert">
                        {{ Session::get('alert-info') }}
                     </div>
                  @endif

                  @if (Session::has('error'))
                     <div class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                     </div>
                  @endif -->

                     <table class="table">
                        <thead>
                           <tr>
                              <th>Title</th>
                              <th>Description</th>
                              <th>Image</th>
                              <th>Tags</th>
                              <th>Completed</th>
                              <th>Actions</th>
                           </tr>
                        </thead>
                        <tbody>
                        @if (count($todos)>0)
                           @foreach ($todos as $todo)
                           <tr id="{{ $todo->id}}">
                              <td>{{ $todo->title }}</td>
                              <td>{{ $todo->description }}</td>
                              <td>
                                 @if($todo->image != '' )
                                    @if(in_array( auth()->user()->id , explode(",",$todo->id_user) ) )
                                       <a class="" href="{{ route('todos.edit', $todo->id)}}"><img src="/images/thumbnail/{{ $todo->image }}" width="150px"></a>
                                    @else
                                       <img src="/images/thumbnail/{{ $todo->image }}" width="150px">
                                    @endif
                                 @endif
                              </td>
                              <td id="outer">
                                 @foreach(explode(",",$todo->keywords) as $tag)
                                    <label class="inner btn-sm btn-info">{{ $tag }}</label>
                                 @endforeach
                              </td>
                              <td id="completed-{{ $todo->id}}">
                                 @if($todo->is_completed == 1 )
                                    <a class="btn btn-sm btn-success" 
                                          id="btn-completed"
                                       data-completed="0" data-id="{{ $todo->id}}">Completed</a>
                                 @else
                                    <a class="btn btn-sm btn-danger" 
                                          id="btn-completed"
                                        data-completed="1" data-id="{{ $todo->id}}">In completed</a>
                                 @endif
                              </td>
                              <td id="outer">
                                 <a class="inner btn btn-sm btn-success" href="{{ route('todos.show', $todo->id)}}">View</a>
                                 @if(in_array( auth()->user()->id , explode(",",$todo->id_user) ) )
                                 <a class="inner btn btn-sm btn-info" href="{{ route('todos.edit', $todo->id)}}">Edit</a>
                                 <form class="inner">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="todo_id" value="{{ $todo->id}}">
                                    <input id="btn-delete" type="submit" class="btn btn-sm btn-danger" value="Delete">
                                 </form>
                                 @endif
                              </td>
                           </tr>
                           @endforeach
                        @endif
                        </tbody>
                     </table>
                  
            </div>
      </div>
   </div>
</div>
@endsection
