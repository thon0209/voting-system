@extends('layouts.app')

@section('content')
<div class="container">
    @if(Auth::user()->isAdmin === 1)
        <div id="app">
            <results></results>
        </div>
    @else
        <h1>Sorry, you don't permission to access this page!</h1>
    @endif
</div>
@endsection