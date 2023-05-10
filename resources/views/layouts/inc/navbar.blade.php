 <nav class="navbar navbar-expand-lg sticky-top px-5" style=" background-color: #ececec">

     <div class="container">
         <a class="navbar-brand" href="{{ route('dashboard.index') }}">
            {{ config('app.name', 'Raumbuchung') }}
         </a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
             aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
             <span class="navbar-toggler-icon"></span>
         </button>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <!-- Left Side Of Navbar -->
             <ul class="navbar-nav">
                 <!-- Räume -->
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                         aria-expanded="false">{{ __('messages.room') }}</a>  
                         {{-- {{ $room->name ?? 'Raum' }} --}}
                     <ul class="dropdown-menu">
                         @foreach ($all_rooms as $rooms)
                             <li><a class="dropdown-item"
                                    href="{{ route('dashboard.show', $rooms->id) }}">{{ $rooms->name }}</a></li>
                         @endforeach
                     </ul>
                 </li>
             </ul>


             <!-- Right Side Of Navbar -->
             <ul class="navbar-nav ms-auto">

                 <!-- Admin stuff -->
                 @can('is_admin')
                     <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             Admin Control
                         </a>
                         <ul class="dropdown-menu">
                             <li><a class="dropdown-item" href="{{ route('room.index') }}">{{ __('messages.rooms') }}</a></li>
                             <li><a class="dropdown-item" href="{{ route('room.create') }}">{{ __('messages.create_room') }}</a></li>

                         </ul>
                     </li>
                 @endcan


                 <!-- Authentication Links -->
                 @guest
                     @if (Route::has('login'))
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                         </li>
                     @endif

                     @if (Route::has('register'))
                         <li class="nav-item">
                             <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                         </li>
                     @endif
                 @else
                     <li class="nav-item dropdown">
                         <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                             {{ Auth::user()->name }}
                         </a>

                         <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                             <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                 {{ __('Logout') }}
                             </a>

                             <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                 @csrf
                             </form>
                         </div>
                     </li>
                 @endguest

                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         {{ strtoupper( session()->get('locale') ) }}
                     </a>
                     <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('language', 'de') }}">DE</a></li>
                        <li><a class="dropdown-item" href="{{ route('language', 'en') }}">EN</a></li>
                     </ul>
                 </li>
             </ul>
         </div>
     </div>
 </nav>
