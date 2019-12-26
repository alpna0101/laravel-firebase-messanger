@extends('app.layout')

@section('title', 'Chat | Laravel Chat')

@section('content')
    <div id="app" class="ui main container" style="margin-top:65px;">
        <div class="ui grid">
            <div class="row">
                <div class="three wide column">
                    <div class="ui vertical pointing menu">
                        <h3 class="item ui header">
                            Users:
                        </h3>
    
                        @foreach($users as $key=>$user)
                     
                            @if($user->id == $receptorUser->id)
                                <a href="{{route('chat', [$user->username])}}/{{$user->id}}" class="active item">
                                    {{ $user->name }}
                                </a>
                            @else
                                <a href="{{route('chat', [$user->username])}}/{{$user->id}}" class="item">
                                    {{ $user->name }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="thirteen wide column">
                    <div class="ui segment" style="padding: 1.5em 1.5em;">
                        <div class="ui comments" style="max-width: 100%;">
                            <h3 class="ui dividing header"><i class="talk outline icon"></i> Messages  {{ $receptorUser->name }}</h3>
                            <firebase-messages user-id="{{ Auth::user()->id }}" chat-id="{{ $chat->id }}" receptor-name="{{ $receptorUser->name }}"></firebase-messages>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://www.gstatic.com/firebasejs/4.5.0/firebase.js"></script>
    <script src="https://raw.githubusercontent.com/savanihd/multi-select-autocomplete/master/autocomplete.multiselect.js"></script>
    <script>
        // Initialize Firebase
        var firebaseConfig = {
    apiKey: "AIzaSyBZ1tRgMSj7NhBa28-kjpUbqYwNpAPtZU4",
    authDomain: "friendlychat-f9048.firebaseapp.com",
    databaseURL: "https://friendlychat-f9048.firebaseio.com",
    projectId: "friendlychat-f9048",
    storageBucket: "friendlychat-f9048.appspot.com",
    messagingSenderId: "686268314302",
    appId: "1:686268314302:web:f3a99a970bbb9d3b"
  };
        firebase.initializeApp(firebaseConfig);

        const database = firebase.database();
    </script>
    <script src="{{ asset('js/myapp.js') }}"></script>
@endsection