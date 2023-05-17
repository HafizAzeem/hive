"use strict";
$(function() {
    $(".datePickerDefault").datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0

    });
});

$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
});
$('#stock_is').on('change', function() {
    $('#price_section').hide();
    if ($(this).val() == 'add') {
        $('#price_section').show();
    }
});

function printSlip() {
    window.print();
}

if (globalVar.page == 'checkout') {
    paymentInfo();
    $('#check_in_date').datepicker({
        startDate: '-0d'
    });

    if (globalVar.userRole == 3) {
        $('#check_out_date').datetimepicker({
            startDate: new Date(),
            startDate: '-0d'
        });
    } else {
        $('#check_out_date').datetimepicker({
            startDate: new Date(),
            startDate: '-0d'
        });
    }


    $("#check_in_date").on("change", function() {
        globalVar.checkInDate = $(this).val();
        $("#check_out_date,#duration_of_stay").val('');
    });

    $("#check_out_date").on("change", function() {
        globalVar.checkOutDate = $(this).val();
        var endDate = moment(globalVar.checkOutDate, "YYYY.MM.DD");
        globalVar.durationOfStayDays = endDate.diff(globalVar.startDate, 'days');
        globalVar.durationOfStayDays = (globalVar.durationOfStayDays > 0) ? globalVar.durationOfStayDays : 1;
        $('#duration_of_stay').val(globalVar.durationOfStayDays);
        paymentInfo();
    });

    $("#per_room_price").on("keyup click", function() {
        if ($(this).val() > 0) { globalVar.basePriceOneRoom = $(this).val(); } else { globalVar.basePriceOneRoom = 0; }
        paymentInfo();
    });
    $("#duration_of_stay").on("keyup click", function() {
        if ($(this).val() > 0) { globalVar.durationOfStayDays = $(this).val(); } else { globalVar.durationOfStayDays = 0; }
        paymentInfo();
    });

    $("#discount").on("keyup click", function() {

        $('.discount_room_err_msg').html('');
        if (globalVar.subTotalRoomAmount > 0) {
            if ($(this).val() > 0) { globalVar.discount = $(this).val(); } else { globalVar.discount = 0; }

            var maxDisc = getMaxDiscount(globalVar.subTotalRoomAmount);
            if (globalVar.discount > maxDisc) {
                globalVar.isError = true;
                $('.discount_room_err_msg').html('Allow only 20% of total amount');
            } else {
                globalVar.isError = false;
                paymentInfo();
            }
        } else {
            $(this).val(0);
        }
    });
    $("#order_discount").on("keyup click", function() {
        $('.discount_order_err_msg').html('');
        if (globalVar.totalOrdersAmount > 0) {
            if ($(this).val() > 0) { globalVar.foodOrderDiscount = $(this).val(); } else { globalVar.foodOrderDiscount = 0; }

            var maxDisc = getMaxDiscount(globalVar.totalOrdersAmount);
            if (globalVar.foodOrderDiscount > maxDisc) {
                globalVar.isError = true;
                $('.discount_order_err_msg').html('Allow only 20% of total amount');
            } else {
                globalVar.isError = false;
                paymentInfo();
            }
        } else {
            $(this).val(0);
        }

    });
    $("#apply_gst").on("click", function() {
        if ($(this).prop("checked") == true) {
            globalVar.applyFoodGst = 1;
        } else if ($(this).prop("checked") == false) {
            globalVar.applyFoodGst = 0;
        }
        $(this).val(globalVar.applyFoodGst);
        paymentInfo();
    });

    function paymentInfo() {
        if (globalVar.durationOfStayDays >= 0) $('#td_dur_stay').html(globalVar.durationOfStayDays);
        if (globalVar.basePriceOneRoom >= 0) $('#td_base_price').html(currency_symbol + ' ' + globalVar.basePriceOneRoom);

        //start room Amount Calculation
        var totalRoomAmount = (parseFloat(globalVar.basePriceOneRoom) * parseFloat(globalVar.durationOfStayDays) * parseFloat(globalVar.roomQty));
        gstCalculation(globalVar.basePriceOneRoom, 'room_gst');
        Console.log("Here");
        $('.td_total_room_amount').html(currency_symbol + ' ' + parseFloat(totalRoomAmount).toFixed(2));
        $('#total_room_amount').val(parseFloat(totalRoomAmount).toFixed(2));

        var finalRoomAmount = (parseFloat(totalRoomAmount) + parseFloat(globalVar.gstRoomAmount) + parseFloat(globalVar.cgstRoomAmount) - parseFloat(globalVar.advanceAmount) - parseFloat(globalVar.discount));
        $('#td_room_final_amount').html(currency_symbol + ' ' + parseFloat(finalRoomAmount).toFixed(2));
        $('#total_room_final_amount').val(parseFloat(finalRoomAmount).toFixed(2));

        //start foodOrders Amount Calculation
        gstCalculation(globalVar.totalOrdersAmount, 'food_gst');

        var finalOrderAmount = (parseFloat(globalVar.totalOrdersAmount) + parseFloat(globalVar.gstOrderAmount) + parseFloat(globalVar.cgstOrderAmount) - parseFloat(globalVar.foodOrderDiscount));
        $('#td_order_final_amount').html(currency_symbol + ' ' + parseFloat(finalOrderAmount).toFixed(2));
        $('#total_order_final_amount').val(parseFloat(finalOrderAmount).toFixed(2));

        //start Final Amount Calculation
        var finalAmount = (parseFloat(finalRoomAmount) + parseFloat(finalOrderAmount));
        $('#td_final_amount').html(currency_symbol + ' ' + parseFloat(finalAmount).toFixed(2));
        $('#total_final_amount').val(parseFloat(finalAmount).toFixed(2));
    }

    function gstCalculation(amount, type) {
        debug
        if (type == 'room_gst') {

            if (amount > 999) {
                globalVar.gstRoomAmount = (globalVar.gstPercent / 100) * parseFloat(amount);
                globalVar.cgstRoomAmount = (globalVar.cgstPercent / 100) * parseFloat(amount);
            } else {
                globalVar.gstRoomAmount = '0.00';
                globalVar.cgstRoomAmount = '0.00';
            }
            $('#total_room_amount_gst').val(globalVar.gstRoomAmount);
            $('#total_room_amount_cgst').val(globalVar.cgstRoomAmount);

            $('#td_total_room_amount_gst').html(currency_symbol + ' ' + parseFloat(globalVar.gstRoomAmount).toFixed(2));
            $('#td_total_room_amount_cgst').html(currency_symbol + ' ' + parseFloat(globalVar.cgstRoomAmount).toFixed(2));
        } else {
            if (globalVar.applyFoodGst == 1) {
                globalVar.gstOrderAmount = (globalVar.gstPercentFood / 100) * parseFloat(amount).toFixed(2);
                globalVar.cgstOrderAmount = (globalVar.cgstPercentFood / 100) * parseFloat(amount).toFixed(2);
            } else {
                globalVar.gstOrderAmount = '0.00';
                globalVar.cgstOrderAmount = '0.00';
            }
            $('#total_order_amount_gst').val(parseFloat(globalVar.gstOrderAmount).toFixed(2));
            $('#total_order_amount_cgst').val(parseFloat(globalVar.cgstOrderAmount).toFixed(2));

            $('#td_order_amount_gst').html(currency_symbol + ' ' + parseFloat(globalVar.gstOrderAmount).toFixed(2));
            $('#td_order_amount_cgst').html(currency_symbol + ' ' + parseFloat(globalVar.cgstOrderAmount).toFixed(2));
        }
        return;

    }

    $(document).on('click', '.btn-submit-form', function(e) {
        if (parseFloat($("#per_room_price").val() < parseFloat(globalVar.basePriceOneRoomOriginal))) {
            globalVar.isError = true;
            $('.base_price_err_msg').html('Base price must be greater than or equal to ' + globalVar.basePriceOneRoomOriginal);
        }

        if (globalVar.isError) {
            e.preventDefault();
        }
    });
}
if (globalVar.page == 'room_reservation_add') {

    globalVar.checkInDate = '';
    globalVar.checkOutDate = '';
    globalVar.durationOfStayDays = 0;
    globalVar.basePriceOneRoom = 0;
    globalVar.room_nums = [];
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
    $('#check_in_date,#check_out_date').datetimepicker();
    $("#check_in_date").on("change", function() {
        globalVar.checkInDate = $(this).val();
        $("#check_out_date,#duration_of_stay").val('');
    });

    $("#check_out_date").on("change", function() {
        globalVar.checkOutDate = $(this).val();
        var startDate = moment(globalVar.checkInDate, "YYYY.MM.DD");
        var endDate = moment(globalVar.checkOutDate, "YYYY.MM.DD");
        globalVar.durationOfStayDays = endDate.diff(startDate, 'days');
        $('#duration_of_stay').val(globalVar.durationOfStayDays);
        paymentInfo();
    });

    $("#duration_of_stay").on("keyup click", function() {
        if ($(this).val() > 0) {
            globalVar.durationOfStayDays = $(this).val();
        } else {
            globalVar.durationOfStayDays = 0;
        }
        paymentInfo();
    });

    $('#room_type_id').change(function(e) {
        $('#room_num').html('');
        $('#rooms_list').html('');
        var post_data = { room_type_id: $(this).val() };
        globalFunc.ajaxCall('api/get-room-num-list', post_data, 'POST', globalFunc.before, globalFunc.listOfRooms, globalFunc.error, globalFunc.complete);

    });
    window.onload = function() {
        $('#room_num').html('');
        $('#rooms_list').html('');
        var post_data = { room_type_id: $(this).val() };
        globalFunc.ajaxCall('api/get-room-num-list', post_data, 'POST', globalFunc.before, globalFunc.listOfRooms, globalFunc.error, globalFunc.complete);
    };


    globalFunc.listOfRooms = function(data) {

        var bookedRooms = data.booked_rooms;
        console.log(bookedRooms);
        var maintinance = data.undermaintinance;
        console.log(maintinance);
        if (Object.keys(data.rooms).length > 0) {
            var k = 1;
            $.each(data.rooms, function(index, val) {
                var statusBtn = '<span class="btn btn-xs btn-success">Available</span>';
                var checkbox = '<input name="room_num[]" type="checkbox" data-roomid="' + index + '" value="' + val + '" class="room_checkbox"></td>';
                if (maintinance[val] != undefined) {
                    statusBtn = '<span class="btn btn-xs btn-info">R&M Issue</span>';
                    checkbox = '<input name="room_num_maintinance[]" type="checkbox" value="' + val + '" disabled></td>';
                }
                if (bookedRooms[val] != undefined) {
                    statusBtn = '<span class="btn btn-xs btn-cust">Booked</span>';
                    checkbox = '<input name="room_num_booked[]"   type="checkbox" value="' + val + '" disabled></td>';
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
        var no_of_room = $('#no_of_rooms').val();
        var room_ids = [];
        globalVar.room_nums = [];
        var radio = $(this).val();

        $.each($(".room_checkbox:checked"), function() {
            globalVar.room_nums.push($(this).val());
            room_ids.push($(this).data('roomid'));

        });
        console.log(room_ids);
        if (globalVar.room_nums.length > no_of_room) {
            swal({
                type: 'error',
                title: 'Oops...',
                text: 'You Can Select Only ' + no_of_room + ' Rooms',
            });
            $(".room_checkbox").prop("checked", false);
        }
        paymentInfo();
        if (room_ids.length > 0) {
            var post_data = { room_ids: room_ids };
            globalFunc.ajaxCall('api/get-room-details', post_data, 'POST', globalFunc.before, globalFunc.roomDetails, globalFunc.error, globalFunc.complete);
        } else {
            //$("#adult,#kids,#base_price").val('');
            $("#base_price").val('5000');
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
                globalVar.basePriceOneRoom = parseInt(val.room_type.base_price);
            });
            paymentInfo();
        }
    }

    function paymentInfo() {
        $("#base_price").val(globalVar.basePriceOneRoom);
        if (globalVar.durationOfStayDays >= 0) $('#td_dur_stay').html(globalVar.durationOfStayDays);
        if (globalVar.basePriceOneRoom >= 0) $('#td_base_price').html(currency_symbol + ' ' + globalVar.basePriceOneRoom);

        var roomQty = globalVar.room_nums.length;
        $('#room_qty').val(roomQty);
    }

    $(document).on('click', '.btn-submit-form', function(e) {
        if (globalVar.room_nums.length == 0) {
            swal({
                type: 'error',
                title: 'Oops...',
                text: 'Please select room number',
            })
            e.preventDefault();
        }
    })
    $(document).on('click', '.btn-update-form', function(e) {

    })

    $('#referred_by').change(function() {
        var val = 'OYO';
        if ($(this).val() == 'Self') {
            val = 'WALK-IN';
        }
        $('#referred_by_name').val(val);
    });
}
if (globalVar.page == 'food_order_final') {
    globalVar.foodOrderDiscount = 0;
    globalVar.gstOrderAmount = 0;
    globalVar.cgstOrderAmount = 0;
    globalVar.applyFoodGst = 1;
    globalVar.subtotalAmount = 0;
    globalVar.isError = false;

    calculateTotalAmount();
    $("#discount_amount").on("keyup click", function() {
        $('.discount_err_msg').html('');
        if (globalVar.subtotalAmount > 0) {
            if ($(this).val() > 0) { globalVar.foodOrderDiscount = $(this).val(); } else { globalVar.foodOrderDiscount = 0; }

            var maxDisc = getMaxDiscount(globalVar.subtotalAmount);
            if (globalVar.foodOrderDiscount > maxDisc) {
                globalVar.isError = true;
                $('.discount_err_msg').html('Allow only 20% of total amount');
            } else {
                globalVar.isError = false;
                calculateTotalAmount();
            }
        } else {
            $(this).val(0);
        }
    });
    $("#apply_gst").on("click", function() {
        if ($(this).prop("checked") == true) {
            globalVar.applyFoodGst = 1;
        } else if ($(this).prop("checked") == false) {
            globalVar.applyFoodGst = 0;
        }
        calculateTotalAmount();
    });
    $(document).on('click', '.btn-submit-form', function(e) {
        if (globalVar.isError) {
            e.preventDefault();
        }
    })

    function calculateTotalAmount() {
        globalVar.subtotalAmount = 0;
        $.each($(".input-number"), function() {
            var calcAmount = parseInt($(this).val()) * parseFloat($(this).data('price'));
            globalVar.subtotalAmount = globalVar.subtotalAmount + calcAmount;
        });
        gstCalculation(globalVar.subtotalAmount);
        var finalAmount = globalVar.subtotalAmount + parseFloat(globalVar.gstOrderAmount) + parseFloat(globalVar.cgstOrderAmount) - parseFloat(globalVar.foodOrderDiscount);

        $('#subtotal_amount').val(parseFloat(globalVar.subtotalAmount).toFixed(2));
        $('#final_amount').val(parseFloat(finalAmount).toFixed(2));

        $('#td_subtotal_amount').html(currency_symbol + ' ' + parseFloat(globalVar.subtotalAmount).toFixed(2));
        $('#td_final_amount').html(currency_symbol + ' ' + parseFloat(finalAmount).toFixed(2));
    }

    function gstCalculation(amount, type) {
        if (globalVar.applyFoodGst == 1) {
            globalVar.gstOrderAmount = (globalVar.gstPercentFood / 100) * parseFloat(amount).toFixed(2);
            globalVar.cgstOrderAmount = (globalVar.cgstPercentFood / 100) * parseFloat(amount).toFixed(2);
        } else {
            globalVar.gstOrderAmount = '0.00';
            globalVar.cgstOrderAmount = '0.00';
        }
        $('#gst_amount').val(parseFloat(globalVar.gstOrderAmount).toFixed(2));
        $('#cgst_amount').val(parseFloat(globalVar.cgstOrderAmount).toFixed(2));

        $('#td_gst_amount').html(currency_symbol + ' ' + parseFloat(globalVar.gstOrderAmount).toFixed(2));
        $('#td_cgst_amount').html(currency_symbol + ' ' + parseFloat(globalVar.cgstOrderAmount).toFixed(2));
    }
}
if (globalVar.page == 'food_order_page') {
    globalVar.foodOrderDiscount = 0;
    globalVar.gstOrderAmount = 0;
    globalVar.cgstOrderAmount = 0;
    globalVar.applyFoodGst = 0;
    //start table items seraching 
    $(document).ready(function() {
        $('#txt_searchall').keyup(function() {
            var search = $(this).val();
            $('.tr-items,.tr-bg').hide();
            var len = $('table tbody tr:not(.notfound) td:contains("' + search + '")').length;
            if (len > 0) {
                $('table tbody tr:not(.notfound) td:contains("' + search + '")').each(function() {
                    $(this).closest('tr').show();
                });
            } else {
                $('.notfound').show();
            }
        });
    });
    // Case-insensitive searching (Note - remove the below script for Case sensitive search )
    $.expr[":"].contains = $.expr.createPseudo(function(arg) {
        return function(elem) {
            return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
        };
    });
    //end table items seraching 

    $(document).on('click', '.btn-number', function(e) {
        e.preventDefault();
        var fieldName = $(this).attr('data-field');
        var type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        currentVal = isNaN(currentVal) ? 0 : currentVal;
        if (!isNaN(currentVal)) {
            if (type == 'minus') {

                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if (type == 'plus') {

                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }
            }
        } else {
            input.val(0);
        }
        calculateTotalAmount();
    });
    $('.input-number').focusin(function() {
        $(this).data('oldValue', $(this).val());
        calculateTotalAmount();
    });
    $('.input-number').change(function() {
        var minValue = parseInt($(this).attr('min'));
        var maxValue = parseInt($(this).attr('max'));
        var valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        calculateTotalAmount();
    });
    $(".input-number").keydown(function(e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
        calculateTotalAmount();
    });
    $("#discount_amount").on("keyup click", function() {
        if ($(this).val() > 0) { globalVar.foodOrderDiscount = $(this).val(); } else { globalVar.foodOrderDiscount = 0; }
        calculateTotalAmount();
    });
    $("#apply_gst").on("click", function() {
        if ($(this).prop("checked") == true) {
            globalVar.applyFoodGst = 1;
        } else if ($(this).prop("checked") == false) {
            globalVar.applyFoodGst = 0;
        }
        calculateTotalAmount();
    });

    function calculateTotalAmount() {
        var subtotalAmount = 0;
        $.each($(".input-number"), function() {
            var calcAmount = parseInt($(this).val()) * parseFloat($(this).data('price'));
            subtotalAmount = subtotalAmount + calcAmount;
        });
        gstCalculation(subtotalAmount);
        var finalAmount = subtotalAmount + parseFloat(globalVar.gstOrderAmount) + parseFloat(globalVar.cgstOrderAmount) - parseFloat(globalVar.foodOrderDiscount);

        $('#subtotal_amount').val(parseFloat(subtotalAmount).toFixed(2));
        $('#final_amount').val(parseFloat(finalAmount).toFixed(2));

        $('#td_subtotal_amount').html(currency_symbol + ' ' + parseFloat(subtotalAmount).toFixed(2));
        $('#td_final_amount').html(currency_symbol + ' ' + parseFloat(finalAmount).toFixed(2));
    }

    function gstCalculation(amount, type) {
        if (globalVar.applyFoodGst == 1) {
            globalVar.gstOrderAmount = (globalVar.gstPercentFood / 100) * parseFloat(amount).toFixed(2);
            globalVar.cgstOrderAmount = (globalVar.cgstPercentFood / 100) * parseFloat(amount).toFixed(2);
        } else {
            globalVar.gstOrderAmount = '0.00';
            globalVar.cgstOrderAmount = '0.00';
        }
        $('#gst_amount').val(parseFloat(globalVar.gstOrderAmount).toFixed(2));
        $('#cgst_amount').val(parseFloat(globalVar.cgstOrderAmount).toFixed(2));

        $('#td_gst_amount').html(currency_symbol + ' ' + parseFloat(globalVar.gstOrderAmount).toFixed(2));
        $('#td_cgst_amount').html(currency_symbol + ' ' + parseFloat(globalVar.cgstOrderAmount).toFixed(2));
    }




}