@extends('layouts.app')

@section('content')

@include('layouts.banner')
{{-- @include('layouts.tranding') --}}

<section class="section-sm">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8  mb-5 mb-lg-0">
                <h2 class="h5 section-title">Recent Post</h2>

                @foreach ($posts as $post)
                    <article class="card mb-4">
                        <div class="post-slider">
                            <img src="{{ asset('post_thumbnails/'.$post->thumbnail) }}" class="card-img-top"
                                alt="post-thumb">
                        </div>
                        <div class="card-body">
                            <h3 class="mb-3"><a class="post-title" href="{{ route('single.post.view', $post->id) }}">{{ $post->title }}</a></h3>
                            <ul class="card-meta list-inline">
                                <li class="list-inline-item">
                                    <i class="ti-calendar"></i>{{ date('d M Y', strtotime($post->created_at)) }}
                                </li>
                                <li class="list-inline-item">
                                   Category: <b class="text-primary">{{ $post->category_name }}</b>
                                </li>
                            </ul>
                            <p>{{ $post->sub_title }}</p>
                            <a href="{{ route('single.post.view', $post->id) }}" class="btn btn-outline-primary">Read More</a>
                        </div>
                    </article>
                @endforeach

                {{-- pagination --}}
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
            {{-- aside rightbar --}}
            @include('layouts.rightbar')
        </div>
    </div>
</section>


@endsection