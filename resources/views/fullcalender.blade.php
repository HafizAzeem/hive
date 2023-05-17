@extends('layouts.master_backend')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>-->
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />-->
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <style>
        .fc-event-container{
            display:none;
            /*opacity:0.1;*/
        }
        .fc-row.fc-week.fc-widget-content {
            max-height: 6em;
        }
        td.fc-day.fc-widget-content{
            vertical-align: middle;
        }
        .event-count{
            left: 40px;
            position: relative;
            font-size: 20px;
            background: darkgreen;
            color: white;
            padding: 7px;
        }
        .headingtext{
            font-size: 25px;
            color: black;
            font-weight: 600;
            background: lightgrey;
            padding: 1%;
        }
        .modal {
            background: white;
            /*position: absolute;*/
            float: left;
            left: 50%;
            top: 45%;
            transform: translate(-50%, -50%);
            width:70%;
        }
        .modal-content{
            box-shadow: none;
            border: none;
            padding: 5%;
            background: aliceblue;
        }
        .close{
            font-size: 40px;
            background: red;
            opacity: 1;
            margin-bottom: 2%;
            border-radius: 50%;
            width: 5%;
            text-align: center;
        }
        .trstyle{
            background: black;
            color: white;
        }
        .task{
            color: black;
        }
    </style>
  
    <div class="container">
        <!--<h1> Inventory Details </h1>-->
        <div id='calendar'></div>
    </div>
    
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div>
                <span class="headingtext">Arrival List Booked Rooms Detail</span>
                <span class="close" id="modelclosex">&times;</span>
            </div>
            
            <div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="trstyle">
                            <th>S.no</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Customer ID </th>
                            <th>Check In </th>
                            <th>Check Out</th>
                            <th>Duration </th>
                            <th>Amount </th>
                            <th>Source </th>
                        </tr>
                    </thead>
                    <tbody id="task" class="task">
                              
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
    
        $("#modelclosex").click(function() {
            $("#myModal").modal('hide');
        });
      
    </script>


<script>
$(document).ready(function () {
   
var SITEURL = "{{ url('/') }}";
  
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

    // var date = new Date();
    // var d = date.getDate();
    // var m = date.getMonth();
    // var y = date.getFullYear();
  
    var calendar = $('#calendar').fullCalendar({
        
        // header: {
        //     right: 'month,agendaWeek,prev,today,next',
        //     left: 'title',
        // },
        //  initialView: 'timeGrid',
        //  visibleRange: {
        //     start: '2022-06-01',
        //     end: '2023-06-01'
        //   },
        // editable: true,
        // events: SITEURL + "/fullcalender",
        // displayEventTime: false,
        editable: false,
        eventColor: '#378006',
        displayEventTime: false,
        events: function( start, end, timezone, callback ) { 
          $.ajax({
            url: '/inventory',
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
              
              var events = [];
              if (data != null) {
                $.each(data, function(i, item) {
                  events.push({
                    
                    start: item.start,
                    title: item.id.toString(),
                    display: item.start.length
                    
                  })
                
                })
              }
            //   console.log('events', events.length);
              callback(events);
            }
          })
        },

        eventRender: function (event, element, view) { 
            $(element).each(function () { 
                $(this).attr('date-num', event.start.format('YYYY-MM-DD')); 
            });
        },
        
        eventAfterAllRender: function(view){
            for( cDay = view.start.clone(); cDay.isBefore(view.end) ; cDay.add(1, 'day') ){
                var dateNum = cDay.format('YYYY-MM-DD');
                var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
                var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
                if(eventCount){
                    var html = '<span class="event-count">' + 
                                '<i>' +
                                eventCount + 
                                '</i>' +
                                ' / 21' +
                                '</span>';

                    dayEl.append(html);

                }
            }
        },
        
        selectable: false,
        selectHelper: true,
        
        eventClick: function (event,date,calEvent) {
            var datecurent = event.start.format('YYYY-MM-DD');
        
            $.ajax({
                url: '/fullcalenderAjax',
                data: {
                    eventdatemain: datecurent,
                },

                type: 'POST',
                
                dataType: 'JSON',
                success: function(data) {
                  console.log(data);
                  var html = "";
                    $.each(data, function(i, item) {
                        console.log(item.id);
                        html+=` <tr id="${item.id}">
                          <td>${i+1}</td>
                          <td>${item.customer_id}</td>
                          <td>${item.check_in}</td>
                          <td>${item.check_out}</td>
                          <td>${item.duration_of_stay}</td>
                          <td>${item.payment}</td>
                          <td>${item.referred_by_name}</td>
                      </tr>`
                      $('#task').html(html);
                      $("#myModal").modal('show');
                    })
                    
                    // <td>${item.name}</td>
                    //       <td>${item.email}</td>
                    //       <td>${item.mobile}</td>
                    // <td class="d-flex">
                    //         <button id ="edit-exam"  data-id="${item.id}" style="color:white" class="mb-2 mr-2 btn btn-primary">Edit</button>
                    //         <button id="delete-exam" data-id="${item.id}" class="mb-2 mr-2 btn btn-danger">Delete</button>
                    //       </td>
                 
                }
            });
            
        },
        
        dayClick: function(event, jsEvent, view, resource) {
            //   alert('clicked ' + event.format());
            var datecurent = event.format('YYYY-MM-DD');
            var date = moment().format('YYYY-MM-DD');
            
            if(datecurent >= date ){
                $.ajax({
                url: '/fullcalenderAjax',
                data: {
                    eventdatemain: datecurent,
                },

                type: 'POST',
                
                dataType: 'JSON',
                success: function(data) {
                //   console.log(data);
                //   var j = 1;
                  var html = "";
                    $.each(data, function(i, item) {
                        console.log(item.id);
                        html+=` <tr id="${item.id}">
                          <td>${i+1}</td>
                          <td>${item.name}</td>
                          <td>${item.mobile}</td>
                          <td>${item.customer_id}</td>
                          <td>${item.check_in}</td>
                          <td>${item.check_out}</td>
                          <td>${item.duration_of_stay}</td>
                          <td>${item.payment}</td>
                          <td>${item.referred_by_name}</td>
                      </tr>`
                      $('#task').html(html);
                      $("#myModal").modal('show');
                    })
                
                 
                }
            });
            }
            
        
        },
                    
    });
 
});
 
function displayMessage(message) {
    toastr.success(message, 'Event');
} 
  
</script>
  
@endsection