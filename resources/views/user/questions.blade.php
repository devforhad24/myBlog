@extends('layouts.app')
@section('content')
@include('layouts.banner')

  <!-- questions section -->
  <section class="section-sm">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8  mb-5 mb-lg-0">
          <h2 class="h5 section-title">Questions</h2>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="h5">Frequently asked questions</h5>
              <a href="#askQuestion" class="btn btn-primary">Ask a Question</a>
          </div>

            <!-- questions list -->
          @foreach ($questions as $question)
            <div class="card mt-4 border">
                <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('question.answers', $question->id) }}" class="btn-link h4">{{ $question->question }}</a>
                    @if ($question->user_id == auth()->user()->id)
                        <form action="{{ route('question.delete', $question->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="delete text-danger border-0 bg-white"> <i class="fas fa-trash"></i> </button>
                        </form>
                    @endif
                </div>

                <ul class="card-meta list-inline mt-4">
                    <li class="list-inline-item">
                    <a href="#" class="card-meta-author">
                        @if($question->user->photo)
                        <img src="{{ asset('images/user_photos/' .$question->user_photo) }}">
                        <span>{{ $question->user_name }}</span>
                        @else
                            <img src="{{ asset('images/user_photos/avatar.png') }}">
                            <span>{{ $question->user_name }}</span>
                        @endif
                    </a>
                    </li>
                    <li class="list-inline-item">
                    <i class="ti-calendar"></i>{{ date('d M Y', strtotime($question->created_at)) }}
                    </li>
                    <li class="list-inline-item text-primary">
                    <i class="ti-bookmark"></i>{{ $question->category_name }}
                    </li>
                    <li class="list-inline-item text-primary">
                    <i class="ti-comment"></i>
                    @php
                        $answers = DB::table('question_answers')->where('question_id', $question->id)->get();
                        echo count($answers);
                        if(count($answers) > 1){
                            echo ' Answers';
                        }else{
                            echo ' Answer';
                        }
                    @endphp
                    </li>
                </ul>

                <a href="{{ route('question.answers', $question->id) }}" class="btn btn-outline-primary btn-sm mt-4 py-1">See answers</a>
                </div>
            </div>
          @endforeach
            <div class="mt-4">
                {{ $questions->links('pagination::bootstrap-5') }}
            </div>

          <!-- ask question form -->
          <h3 class="h4 mb-3" id="askQuestion">Ask a question</h3>

          <form action="{{ route('question.store') }}" method="post">
            @csrf
            <div class="form-group mb-3">
              <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                <option disabled selected>Choose Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
              @error('category_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="form-group mb-3">
              <textarea class="form-control @error('question') is-invalid @enderror" name="question" rows="10"
                placeholder="Enter question here...">{{ old('question') }}</textarea>
                @error('question')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Submit Question</button>
          </form>

        </div>

        <!-- aside rightbar -->
        @include('layouts.rightbar')
      </div>
    </div>
  </section>
    <!-- /questions section -->
@endsection