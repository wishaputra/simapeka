@extends('layouts/layoutMaster')


<!-- Add custom styling -->
<style>
    .card-img-container {
        width: 100%;
        height: 200px; /* Fixed height for thumbnails */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card-img-container img {
        height: 100%;
        width: auto;
        object-fit: cover; /* Ensures proper cropping */
    }
    .text-truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

@section('content')
<div class="container">
    <h2 class="mb-4">Course yang tersedia</h2>
    <div class="row">
        @foreach ($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Thumbnail with fixed size -->
                    <div class="card-img-container">
                        <img src="{{ $course->thumbnail ? asset($course->thumbnail) : asset('assets/img/placeholder.png') }}"
                             class="card-img-top"
                             alt="{{ $course->title }}">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $course->title }}</h5>
                        <p class="card-text text-truncate">{{ $course->description }}</p>
                        @if (in_array($course->id, $enrolledCourseIds))
                            <!-- Disabled button if already enrolled -->
                            <button class="btn btn-secondary w-100" disabled>Already Enrolled</button>
                        @else
                            <form action="{{ route('enrollment.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                <button type="submit" class="btn btn-primary w-100">Enroll</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection
