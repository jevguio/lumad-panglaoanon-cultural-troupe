@extends('layouts.app')

@section('content')
    <div class="container"  style="padding:20px">
        <h2 class="mb-4 text-danger">PERFORMER ATTENDANCE</h2>

        <div class="  mb-4">
            <div class=" p-0">
                <table class="table table-bordered mb-0" style="background-color:  #F2BB55;">
                    <thead class=" "  style="background-color: #F2BB55;">
                        <tr style="background-color:  #F2BB55;">
                            <th  style="background-color:  #F2BB55;">Performer ID</th>
                            <th style="background-color:  #F2BB55;">Name</th>
                            <th style="background-color:  #F2BB55;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            @foreach ($event->selectedPerformers as $performer)
                                @if ($performer->id == Auth::user()->id)
                                    <tr style="background-color: #F2BB55;">
                                        <td>Performer {{ $performer->id }}</td>
                                        <td>{{ $performer->name }}</td>
                                        <td>
                                            {{ $performer->attendance }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
