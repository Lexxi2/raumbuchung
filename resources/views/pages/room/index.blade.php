@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="col-md-15">
                <h2>Meetingräume</h2>

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- <a href="{{ route('room.create') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-pen-to-square"></i>Raum erstellen</a> --}}
                
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <table class="table">
                    <thead>
                        <tr style=" background-color: #ececec;">
                            <th scope="col"></th>
                            <th scope="col">Raumname</th>
                            <th scope="col">Ort</th>
                            <th scope="col">Editieren</th>
                            <th scope="col">Löschen</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($all_rooms as $room)
                            <tr>
                                <td  style="background-color:{{ $room->color }}"></td>
                                <td scope="row">{{ $room->name }}</td>
                                <td>{{ $room->location }}</td>
                                <td><a href="{{ route('room.edit', $room->id) }}" class="btn btn-outline-success" ><i class="fa-solid fa-pen-to-square"></i>Editieren</a></td>
                                <td>
                                    <form action="{{ route('room.destroy', $room->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" value="Löschen" class="btn btn-outline-danger"
                                            onclick="return confirm('Are you sure to delete?')">
                                    </form>
                                </td>
                            </tr>       
                        @endforeach
                        
                    </tbody>
                </table>
 
            </div>
        </div>
    </div>

{{-- style="background-color: rgb(228, 228, 228)" 
style="border: 5px solid; border-color: {{ $room->color }}"
--}}
@endsection
