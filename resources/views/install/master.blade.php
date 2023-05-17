@php
  $segment = Request::segment(2);
@endphp
<!DOCTYPE html>
<html lang="en">
    <head>
       <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Quickbuzz</title>
      <link rel="icon" href="{{url('public/images/hotel.png')}}" sizes="16x16" type="image/png">

      <link href="{{URL::asset('public/assets/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
      <link href="{{URL::asset('public/assets/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
      <link href="{{URL::asset('public/assets/nprogress/nprogress.css')}}" rel="stylesheet">
      <link href="{{URL::asset('public/assets/custom.min.css')}}" rel="stylesheet">
      <link href="{{URL::asset('public/css/install.css')}}" rel="stylesheet">
         {{-- this inline script is required: set global access var --}}
        <script>
          var base_url="{{url('/').'/'}}";
          var csrf_token="{{ csrf_token() }}";
          var current_segment = "{{$segment}}";
        </script>

        <script type="text/javascript" src="{{URL::asset('public/js/init.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('public/assets/jquery/jquery.min.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('public/js/jquery.validate.min.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('public/assets/jqueryvalidation/jqueryvalidation.js')}}"></script>
        <script type="text/javascript" src="{{URL::asset('public/assets/moment/min/moment.min.js')}}"></script>
         <script type="text/javascript" src="{{URL::asset('public/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js')}}"></script>

         <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
        <script type="text/javascript" src="{{URL::asset('public/assets/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
       
    </head>
    
    <body class="nav-md">
        <div class="container">
            <div class="main_container">
                <div class="right_col" role="main">
                    <div class="col-sm-6 col-sm-offset-3">
                      <div class="row">
                        <div class="col-sm-12 text-center site-name">
                          <h1>
                              <i class="fa fa-paw"></i>
                               QUICKBUZZ PARADISE
                          </h1>
                        </div>
                      </div>
                      <div class="panel panel-default">
                        <div class="panel-heading-install">
                        <ul class="nav nav-pills">
                            <li class="{{ ($segment==null) ? 'active' : '' }}"><a href="#">Checklist</a></li>
                            <li class="{{ ($segment=='set-database') ? 'active' : '' }}"><a href="#">Database</a></li>
                            <li class="{{ ($segment=='set-siteconfig') ? 'active' : '' }}"><a href="#">Site Config</a></li>
                            <li class="{{ ($segment=='done') ? 'active' : '' }}"><a href="#">Done!</a></li>
                        </ul>
                        </div>
                        @include('layouts.flash_msg')          
                        @yield('content')
                      </div>
                    </div>
                </div>
            </div>
        </div>
         <script src="{{URL::asset('public/assets/bootstrap/dist/js/bootstrap.min.js')}}"></script>
          <script src="{{URL::asset('public/assets/nprogress/nprogress.js')}}"></script>
          <script src="{{URL::asset('public/assets/js/custom.min.js')}}"></script>
          <script src="{{URL::asset('public/js/ajax_call.js')}}"></script>
          <script src="{{URL::asset('public/js/custom.js')}}"></script>
    </body>
</html>
