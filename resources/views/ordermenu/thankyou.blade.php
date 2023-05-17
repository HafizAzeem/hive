@extends('layouts.master_backend_order')

@section('content')
<?php 
    $roomnumb = session()->get('roomno');
    $rnumber = 'menu/'.$roomnumb;
?>
<style>
    .mtnclsthank{
        margin-top: 8%;
    }
    @media only screen and (max-width: 600px) {
        .mtnclsthank{
            margin-top: 25%;
        }
    }
    
</style>
<input type="hidden" name="roomnumberdj" id="roomnumberdj" value="{{$roomnumb}}">
<div class="container">
    <div class="row justify-content-center">
        <br>
        <div class="col-md-12 mtnclsthank">
            <article class="bg-secondary mb-3">  
                <div class="card-body text-center">
                    <br><br>
                    <h3>Thank You for Being Our Valued Customer.</h3>
                    <h3>We Are Preparing Your Food Order Please Wait.</h3>
                    <p>
                        <a class="btn btn-warning" href="{{$rnumber}}"> Order Again </a>
                    </p>
                </div>
                <br><br><br>
            </article>
        </div>
    </div>
</div>

@endsection