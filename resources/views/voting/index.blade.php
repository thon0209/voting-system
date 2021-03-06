@extends('layouts.app')

@section('content')

<div id="app">
  
    <div class="container">
            @if (Auth::user()->isVoted === 1)
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Status</div>     
                        <div class="card-body">
                            <div class="alert alert-danger" role="alert">
                              
                                    Sorry, <strong>{{Auth::user()->name}}</strong> you have already voted!
                              
                            </div>       
                        </div>
                    </div>
                </div>
            </div>
            @else
            <votes></votes>
        @endif 
        </div>

    
</div>

@endsection