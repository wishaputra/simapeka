@extends('layouts/layoutMaster')

@section('content')
<div class="container">
    <h2 class="mb-4">Attendance for {{ $course->title }}</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>NIP</th>
                <th>Student Name</th>
                <th>Attendance Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendance as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record->nip }}</td>
                    <td>{{ $record->pegawai->nama ?? 'Unknown' }}</td> <!-- Get nama from pegawai -->
                    <td>{{ $record->tanggal_hadir }}</td>
                    <td>{{ ucfirst($record->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
