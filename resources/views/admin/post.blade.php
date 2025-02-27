@extends('admin.layouts.app')

@section('title')
    Posts
@endsection

@php
    $page = 'Posts';
@endphp

@section('mainpart')
    <div class="card">

        <div class="card-header d-flex align-items-center justify-content-between">
            <h3>All Posts</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addPostModal">Add Post</button>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Thumbnail</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $key => $post)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->description }}</td>
                            <td>{{ $post->category_name }}</td>
                            <td>
                                <img src="{{ asset('post_thumbnails/'.$post->thumbnail) }}" alt="" style="width: 100px">
                            </td>
                            <td>
                                @if($post->status == 1)
                                    <span class="badge badge-success">Public</span>
                                @else
                                    <span class="badge badge-danger">Private</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-primary mr-1" data-toggle="modal"
                                    data-target="{{ '#edit' . $post->id . 'PostModal' }}">
                                    <i class="fas fa-edit"></i>
                                    </button>
                                <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="delete btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Post Edit Modal-->
                        <div class="modal fade" id="{{ 'edit' . $post->id . 'PostModal' }}" tabindex="-1"
                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $post->title }}</h5>
                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="_method" value="put">
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label for="Post_name">Post Title</label>
                                                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                                    value="{{ $post->title }}">
                                                @error('title')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="post-thumbnail">Post Category</label>
                                                <select name="category_id" class="form-control">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" @if($category->id == $post->category_id) selected @endif>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Post_des">Post Description</label>
                                                <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                                    rows="5">{{ $post->description }}</textarea>
                                                @error('description')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="post-thumbnail">Post Thumbnail</label>
                                                <input type="file" name="thumbnail" class="form-control">
                                                <input type="hidden" name="old_thumb" value="{{ $post->thumbnail }}">
                                            </div>
                    
                                                <label for="status" class="form-check-label">
                                                    <input type="checkbox" name="status" value="1" id="status" @if($post->status == 1) checked @endif> Status
                                                </label>
                    
                    
                                        </div>
                                        <div class="modal-footer">
                                            <a class="btn btn-light" type="button" data-dismiss="modal">Cancel</a>
                                            <button type="submit" class="btn btn-primary">Update Post</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Post Add Modal-->
    <div class="modal fade" id="addPostModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Post</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
               <form action="{{ route('post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="Post_name">Post Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-thumbnail">Post Category</label>
                            <select name="category_id" class="form-control">
                                <option selected disabled>Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Post_des">Post Description</label>
                            <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-thumbnail">Post Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control">
                        </div>

                            <label for="status" class="form-check-label">
                                <input type="checkbox" name="status" value="1" id="status"> Status
                            </label>


                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" type="button" data-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Post</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
