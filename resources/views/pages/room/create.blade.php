@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="col-md-15">
                <h2>{{ __('messages.create') }}</h2>

                <div class="py-10">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class=" overflow-hidden sm:rounded-lg">
                            <div class="p-6 border-b border-gray-200">
        
                                {{-- Form --}}
                                <form method="post" action="{{ route('room.store') }}" enctype="multipart/form-data">
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
                                    
                                    {{-- Email --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <input class="form-control form-control-lg mt-3"  name="email" type="text" id="floatingInput" placeholder="" value="{{ old('email') }}" >
                                        <label for="floatingInput">Email <span class="required">*</span></label>
                                    </div>

                                    {{-- Bezeichnung : <cn> --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <input class="form-control form-control-lg mt-3"  name="username" type="text" id="floatingInput" placeholder="" value="{{ old('username') }}" >
                                        <label for="floatingInput">{{ __('messages.username') }}<span class="required">*</span></label>
                                    </div>
                                
                                    {{-- Raumname --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <input class="form-control form-control-lg mt-3"  name="name" type="text" id="floatingInput" placeholder="" value="{{ old('name') }}" >
                                        <label for="floatingInput">{{ __('messages.room_name') }} <span class="required">*</span></label>
                                    </div>
            
                                    {{-- Ort --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <select class="form-select" id="floatingSelect" name="location" >
                                            <option value="" @if (old('location') == '') selected @endif></option>
                                            <option value="Wallisellen" @if ( old('location') == 'Wallisellen') selected @endif>Wallisellen</option>
                                            <option value="Schaan" @if ( old('location') == 'Schaan') selected @endif>Schaan</option>
                                        </select>
                                        <label for="floatingSelect">{{ __('messages.location') }}</label>
                                    </div>

                                    {{-- Passwort --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <input class="form-control form-control-lg mt-3"  name="password" type="password" id="floatingInput" placeholder="" value="" >
                                        <label for="floatingInput">{{ __('messages.password') }} <span class="required">*</span></label>
                                    </div>
                                 
                                    {{-- Farbe --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <input class="form-control form-control-lg mt-3"  name="color" type="color" id="floatingInput" placeholder="" value="{{ old('color') }}" >
                                        <label for="floatingInput">{{ __('messages.color') }} <span class="required">*</span></label>
                                    </div>            
            
                                    {{-- Beschreibung --}}
                                    <div class="form-floating mb-3 mx-1">
                                        <textarea class="form-control" id="floatingTextarea2" name="description" style="height: 100%" rows="5">{{ old('description') }}</textarea>
                                        <label for="floatingTextarea2">{{ __('messages.description') }}</label>
                                    </div>
                                
                                <input class="form-control form-control-lg mt-3" id="submit1" type="submit" value="{{ __('messages.save') }}">
        
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection