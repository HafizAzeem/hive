
<?php $__env->startSection('content'); ?>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
  
    <div class="container">
        <h1> Inventory Details </h1>
        <div id='calendar'></div>
    </div>


<script>
$(document).ready(function () {
   
var SITEURL = "<?php echo e(url('/')); ?>";
  
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
  
var calendar = $('#calendar').fullCalendar({
                    // editable: true,
                    // events: SITEURL + "/fullcalender",
                    // displayEventTime: false,
                    editable: false,
                    eventColor: '#378006',
                    displayEventTime: false,
                    events: function( start, end, timezone, callback ) { 
                      $.ajax({
                        url: '/fullcalender',
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
                          console.log('events', events.length);
                          callback(events);
                        }
                      })
                    },
                    // eventSources: [
                    //     {
                    //         url: SITEURL + '/fullcalender',
                    //         type: 'GET',
                    //         color: '#65a9d7',    // an option!
                    //         textColor: '#3c3d3d'  // an option!
    
                    //     }                    
                    // ],
                    // eventSources: [
                    //     {
                            // events: function(start, end, timezone, callback){
                            //     $.ajax({
                            //         url: '/fullcalender',
                            //         type: 'GET',
                            //         // data: {
                            //         //     // our hypothetical feed requires UNIX timestamps
                            //         //     start: start.unix(),
                            //         //     end: end.unix()
                            //         //   },
                            //         dataType: 'json',
                            //         success: function(res) {
                            //             console.log('start: ', start);
                            //             console.log('end: ', end);
                            //             console.log(JSON.stringify(res));
                            //             // var events = [];
                            //             // for (var i = 0; i < res.length; i++){
                            //             //     console.log(res[0].id);
                            //             //     events.push({
                            //             //         id: res[0].id,
                            //             //         start: res[0].start,
                            //             //         end: res[0].end
                            //             //     });
                            //             // }
                            //             callback(res);
                            //         },
                            //     });
                            // },
                            // color: 'darkblue',   // an option!
                            // textColor: 'white', // an option!
                        // }
                    // ],
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                                event.allDay = true;
                        } else {
                                event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    
                    dayClick: function(date, allDay, jsEvent, view) {
                        var eventsCount = 0;
                        var date = date.format('YYYY-MM-DD');
                        $('#calendar').fullCalendar('clientEvents', function(event) {
                            var start = moment(event.start).format("YYYY-MM-DD");
                            var end = moment(event.end).format("YYYY-MM-DD");
                            if(date == start)
                            {
                                eventsCount++;
                            }
                        });
                        alert(eventsCount);
                    }
                    
                    // select: function (start, end, allDay) {
                    //     var title = prompt('Event Title:');
                    //     if (title) {
                    //         var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                    //         var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                    //         $.ajax({
                    //             url: SITEURL + "/fullcalenderAjax",
                    //             data: {
                    //                 title: title,
                    //                 start: start,
                    //                 end: end,
                    //                 type: 'add'
                    //             },
                    //             type: "POST",
                    //             success: function (data) {
                    //                 displayMessage("Event Created Successfully");
  
                    //                 calendar.fullCalendar('renderEvent',
                    //                     {
                    //                         id: data.id,
                    //                         title: title,
                    //                         start: start,
                    //                         end: end,
                    //                         allDay: allDay
                    //                     },true);
  
                    //                 calendar.fullCalendar('unselect');
                    //             }
                    //         });
                    //     }
                    // },
                    // eventDrop: function (event, delta) {
                    //     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                    //     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
  
                    //     $.ajax({
                    //         url: SITEURL + '/fullcalenderAjax',
                    //         data: {
                    //             title: event.title,
                    //             start: start,
                    //             end: end,
                    //             id: event.id,
                    //             type: 'update'
                    //         },
                    //         type: "POST",
                    //         success: function (response) {
                    //             displayMessage("Event Updated Successfully");
                    //         }
                    //     });
                    // },
                    // eventClick: function (event) {
                    //     var deleteMsg = confirm("Do you really want to delete?");
                    //     if (deleteMsg) {
                    //         $.ajax({
                    //             type: "POST",
                    //             url: SITEURL + '/fullcalenderAjax',
                    //             data: {
                    //                     id: event.id,
                    //                     type: 'delete'
                    //             },
                    //             success: function (response) {
                    //                 calendar.fullCalendar('removeEvents', event.id);
                    //                 displayMessage("Event Deleted Successfully");
                    //             }
                    //         });
                    //     }
                    // }
 
                });
 
});
 
function displayMessage(message) {
    toastr.success(message, 'Event');
} 
  
</script>
  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master_backend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/businessbuysell/public_html/pms/resources/views/fullcalender.blade.php ENDPATH**/ ?>