@extends('layouts/layoutMaster')

@section('title', 'Academy - Absensi')

@section('vendor-style')
@vite('resources/assets/vendor/libs/plyr/plyr.scss')
@endsection

@section('page-style')
@vite('resources/assets/vendor/scss/pages/app-academy-details.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/plyr/plyr.js')
@endsection

@section('page-script')
@vite('resources/assets/js/kehadiran.js')
@endsection 

@section('content')
<div class="card app-academy-wrapper">
    <div class="card-body">
        <!-- Course Information -->
        <h4 class="mb-4">{{ $course->title }}</h4>
        <p>{{ $course->description }}</p>
        <p><strong>Start Date:</strong> {{ $course->start_date }} | <strong>End Date:</strong> {{ $course->end_date }}</p>
        <p><strong>Jam masuk:</strong> {{ $course->check_in_start }} | <strong>Jam keluar:</strong> {{ $course->check_in_end }}</p>

        <!-- Attendance Table -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dates as $index => $date)
                        @php
                            $attended = $attendance->where('tanggal_hadir', $date)->first();
                            $isToday = \Carbon\Carbon::now()->toDateString() === $date;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($date)->format('l, d F Y') }}</td>
                            <td>
                                @if ($attended)
                                    <span class="badge bg-{{ $attended->status === 'On-Time' ? 'success' : 'warning' }}">
                                        {{ $attended->status }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Absent</span>
                                @endif
                            </td>
                            <td>
                                @if ($attended)
                                    <button class="btn btn-success btn-sm" disabled>Marked Present</button>
                                @elseif ($isToday)
                                    <form action="{{ route('attendance.store') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <input type="hidden" name="nip" value="{{ auth()->user()->nip }}">
                                        <input type="hidden" name="tanggal_hadir" value="{{ $date }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Mark Present</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Unavailable</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
