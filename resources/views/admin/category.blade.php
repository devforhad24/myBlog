@extends('admin.layouts.app')

@section('title')
    Categories
@endsection

@php
    $page = 'Categories';
@endphp

@section('mainpart')
    <div class="card">

        <div class="card-header d-flex align-items-center justify-content-between">
            <h3>All Categories</h3>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addCategoryModal">Add Category</button>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $key=>$category)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->description }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Category Add Modal-->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('category.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="category_name">Category Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="category_des">Category Description</label>
                            <textarea type="text" name="description" class="form-control" rows="5"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-light" type="button" data-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
