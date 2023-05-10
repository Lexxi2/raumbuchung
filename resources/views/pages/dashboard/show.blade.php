@extends('layouts.app')

<style>
    .sticky_th {
        vertical-align: middle;
        position: sticky;
        top: 55px;
        z-index: 999; 
        background-color: #f8fafc !important;
    }
</style>

@section('content')

    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="col-md-15">
                
                {{-- <h2>{{ $room->name }}</h2> --}}

                <table id="calendar" class="table" style="border:">
                    <thead>
                        <tr>
                            <th class="sticky_th" scope="col" style="width: 10%">{{ $room->name }}</th>
                            <th class="sticky_th" scope="col" style="text-align:right">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#terminModal">
                                    {{ __('messages.new_booking') }}
                                </button>
                            </th>
                        </tr>
                    </thead>

                    <tbody>

                        @for ($t = 7; $t <= $timespan; $t++)
                            <tr>
                                <td>@if($t<10){{ 0 }}@endif{{ $t }}:00</td>
                                <td id="@if($t<10){{ 0 }}@endif{{ $t }}:00"></td>
                            </tr>

                            <tr>
                                <td>@if($t<10){{ 0 }}@endif{{ $t }}:15</td>
                                <td id="@if($t<10){{ 0 }}@endif{{ $t }}:15"></td>
                            </tr>  

                            <tr>
                                <td>@if($t<10){{ 0 }}@endif{{ $t }}:30</td>
                                <td id="@if($t<10){{ 0 }}@endif{{ $t }}:30"></td>
                            </tr>

                            <tr>
                                <td>@if($t<10){{ 0 }}@endif{{ $t }}:45</td>
                                <td id="@if($t<10){{ 0 }}@endif{{ $t }}:45"></td>
                            </tr>  
                        @endfor

                    </tbody>
                </table>

                <!-- Modal -->
                <div class="modal fade" id="terminModal" tabindex="-1" aria-labelledby="terminModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="terminModalLabel">{{ __('messages.event_data') }}</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">

                                <form method="post" action="{{ route('dashboard.store') }}" enctype="multipart/form-data">
                                    @method('POST')
                                    @csrf

                                    {{-- Validation errors --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="list-unstyled">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    {{-- Hidden --}}
                                    <input class="form-control form-control-lg mt-3" name="room" type="hidden" id="floatingInput" placeholder="" value="{{ $room->id }}">

                                    {{-- Titel --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <input class="form-control form-control-lg mt-3" name="title" type="text" id="floatingInput" placeholder="" value="{{ old('title') }}">
                                        <label for="floatingInput">Titel</label>
                                    </div>

                                    {{-- Von --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <input class="form-control form-control-lg mt-3" name="von" type="time" id="floatingInput" placeholder="" step="900" value="{{ old('von') }}">
                                        <label for="floatingInput">Von</label>
                                    </div>

                                    {{-- Bis --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <input class="form-control form-control-lg mt-3" name="bis" type="time" id="floatingInput" placeholder="" step="900" value="{{ old('bis') }}">
                                        <label for="floatingInput">Bis</label>
                                    </div>

                                <input class="form-control form-control-lg mt-3" id="submit1" type="submit" value="Speichern">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schliessen</button>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>


    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" ;
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
        </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {    

                    const LOGIN_MODAL = new bootstrap.Modal('#terminModal');

                    LOGIN_MODAL.show();

            }, false);
        </script>
    @endif

    <script defer>  

        var events = <?php echo json_encode($events); ?>;
        var color = <?php echo json_encode($room->color); ?>;

        calendarFill(<?php echo json_encode($events); ?>);

        function calendarFill(events) {
            // alert(events[0].begin);
            // console.log(color);

            events.forEach(element => {
                console.log(element)
                document.getElementById(element.begin).style.backgroundColor = color;
                document.getElementById(element.begin).setAttribute('rowspan', element.duration);
                // document.getElementById(element.begin).style.borderBottomWidth = "0px";

                document.getElementById(element.begin).style.verticalAlign = "middle";
                document.getElementById(element.begin).style.textAlign = "center";
                document.getElementById(element.begin).innerHTML = element.title + "<br>" + element.begin + " - " + element.end;   
            });

        }

        document.addEventListener('DOMContentLoaded', function() {
            calendarFill(); 
        }, false);
    
    </script>

@endsection
