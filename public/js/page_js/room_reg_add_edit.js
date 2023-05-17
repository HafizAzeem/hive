"use strict";
$(document).on('click', '.add-new-row', function() {
    var html = $(".colne_persons_info_elem").html();
    $(".persons_info_parent").append(html);
});
$(document).on('click', '.delete-row', function() {
    $(this).parents('.persons_info_elem').remove();
});



$('.guest_type').on('ifChanged', function() {
    $('#new_guest_section,#existing_guest_section').hide();
    var type = $(this).val();
    if (type == 'new') {
        $('#new_guest_section').show();
    } else {
        $('#existing_guest_section').show();
    }
});


var checkInDate = '';
var checkOutDate = '';
var durationOfStayDays = 0;
var basePriceOneRoom = 0;
var room_nums = [];
$('#check_in_date,#check_out_date').datetimepicker();
$("#check_in_date").on("change", function() {
    checkInDate = $(this).val();

    $("#check_out_date,#duration_of_stay").val('');
});

$("#check_out_date").on("change", function() {
    checkOutDate = $(this).val();
    var startDate = moment(checkInDate, "YYYY.MM.DD");
    var endDate = moment(checkOutDate, "YYYY.MM.DD");
    durationOfStayDays = endDate.diff(startDate, 'days');
    $('#duration_of_stay').val(durationOfStayDays);
    paymentInfo();
});

$("#duration_of_stay").on("keyup click", function() {
    if ($(this).val() > 0) {
        durationOfStayDays = $(this).val();
    } else {
        durationOfStayDays = 0;
    }
    paymentInfo();
});
// $(document).on('click', '#change_room', function(e) {
//     $('#room_num').html('');
//     $('#rooms_list').html('');
//     var post_data = { room_type_id: $(this).val() };
//     globalFunc.ajaxCall('api/get-room-num-list', post_data, 'POST', globalFunc.before, globalFunc.listOfRooms, globalFunc.error, globalFunc.complete);
// });
$(document).on('change', '#room_type_id', function(e) {
    alert("change");
    $('#room_num').html('');
    $('#rooms_list').html('');
    var post_data = { room_type_id: $(this).val() };
    globalFunc.ajaxCall('api/get-room-num-list', post_data, 'POST', globalFunc.before, globalFunc.listOfRooms, globalFunc.error, globalFunc.complete);
});
globalFunc.listOfRooms = function(data) {
    var bookedRooms = data.booked_rooms;
    var maintinance = data.undermaintinance;
    if (Object.keys(data.rooms).length > 0) {
        var k = 1;
        $.each(data.rooms, function(index, val) {
            var statusBtn = '<span class="btn btn-xs btn-success">Available</span>';
            var checkbox = '<input name="room_num[]" type="checkbox" data-roomid="' + index + '" value="' + val + '" class="room_checkbox"></td>';
            if (bookedRooms[val] != undefined) {
                statusBtn = '<span class="btn btn-xs btn-cust">Booked</span>';
                checkbox = '<input name="room_num_booked[]" type="checkbox" value="' + val + '" disabled></td>';
            }
            if (maintinance[val] != undefined) {
                statusBtn = '<span class="btn btn-xs btn-info">R&M Issue</span>';
                checkbox = '<input name="room_num_maintinance[]" type="checkbox" value="' + val + '" disabled></td>';
            }
            $('#rooms_list').append('<tr>\
            <td width="5%">' + (k++) + '</td>\
            <td width="5%">' + checkbox + '</td>\
            <td>' + val + '</td>\
            <td>' + statusBtn + '</td>\
          </tr>');
        });
    } else {
        addNoRoomTr();
    }
}
addNoRoomTr();

function addNoRoomTr() {
    $('#rooms_list').append('<tr><td colspan="4"> No Rooms Found</td></tr>');
}
$(document).on('click', '.room_checkbox', function() {
    var room_ids = [];
    room_nums = [];
    $.each($(".room_checkbox:checked"), function() {
        room_nums.push($(this).val());
        room_ids.push($(this).data('roomid'));
    });
    paymentInfo();
    if (room_ids.length > 0) {
        var post_data = { room_ids: room_ids };
        globalFunc.ajaxCall('api/get-room-details', post_data, 'POST', globalFunc.before, globalFunc.roomDetails, globalFunc.error, globalFunc.complete);
    } else {
        //$("#adult,#kids,#base_price").val('');
        $("#base_price").val('');
    }
});

globalFunc.roomDetails = function(data) {
    var adultCapacity = 0;
    var kidsCapacity = 0;
    var basePrice = 0;
    if (data) {
        $.each(data, function(index, val) {
            adultCapacity = adultCapacity + parseInt(val.room_type.adult_capacity);
            kidsCapacity = kidsCapacity + parseInt(val.room_type.kids_capacity);
            basePrice = basePrice + parseInt(val.room_type.base_price);
            basePriceOneRoom = parseInt(val.room_type.base_price);
        });
        paymentInfo();
    }
}

function paymentInfo() {
    $("#base_price").val(basePriceOneRoom);
    if (durationOfStayDays >= 0) $('#td_dur_stay').html(durationOfStayDays);
    if (basePriceOneRoom >= 0) $('#td_base_price').html(currency_symbol + ' ' + basePriceOneRoom);

    var roomQty = room_nums.length;
    $('#room_qty').val(roomQty);
}

$(document).on('click', '.btn-submit-form', function(e) {
    v = $(check_in_date_my).val();
    v1 = $(check_out_date_my).val();
    var d1 = new Date(v);
    var d2 = new Date(v1);
    if (d2 < d1) {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Checkout should be greater than check in',
        })
        e.preventDefault();
    }

});

$(document).on('click', '.btn-submit-form', function(e) {
    if (room_nums.length == 0) {
        swal({
            type: 'error',
            title: 'Oops...',
            text: 'Please select room number',
        })
        e.preventDefault();
    }
})

$(document).on('change', '#referred_by', function() {
    var val = 'OYO';
    if ($(this).val() == 'Self') {
        val = 'WALK-IN';
    }
    $('#referred_by_name').val(val);
});