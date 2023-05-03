@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        {{-- {{ ddd($rooms) }} --}}

        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2>Meetingräume</h2>
                

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Raumname</th>
                            <th scope="col">Ort</th>
                            <th scope="col">Editieren</th>
                            <th scope="col">Löschen</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($rooms as $room)
                            <tr style="background-color: {{ $room['calendar']->getRBGcolor() }}">
                                <td scope="row">{{ $room['attributes']->name }}</td>
                                <td>Wallisellen_test</td>
                                <td><a href="" class="btn btn-outline-success"><i class="fa-solid fa-pen-to-square"></i>Editieren</a></td>
                                <td><a href="" class="btn btn-outline-danger"><i class="fa-solid fa-pen-to-square"></i>Löschen</a></td>
                            </tr>       
                        @endforeach
                        
                    </tbody>
                </table>
 
            </div>
        </div>
    </div>


@endsection
