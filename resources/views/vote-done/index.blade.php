@extends('layouts.app')

@section('content')

<div id="app">
  
    <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Status</div>     
                        <div class="card-body">
                            <div class="alert alert-success" role="alert">
                              
                                    Thank you, <strong>{{Auth::user()->name}}</strong> for voting. Please log out your account.
                              
                            </div>       
                        </div>
                    </div>
                </div>
            </div>

        </div>

    
</div>

@endsection