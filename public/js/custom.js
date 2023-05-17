"use strict";
initDatePicker();

$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});
if ($(".summernote")[0] != undefined) {
    $('.summernote').summernote({
        height: 250
    });
}
/* ***** start form validations ***** */
if ($("#database-form")[0] != undefined) {
    $("#database-form").validate({
        rules: {
            "host": { required: true },
            "database": { required: true },
            "username": { required: true },
            "password": { required: true },
        }
    });
}
if ($("#siteconfig-form")[0] != undefined) {
    $("#siteconfig-form").validate({
        rules: {
            "site_page_title": { required: true },
            "site_language": { required: true },
            "hotel_name": { required: true },
            "name": { required: true, maxlength: 10 },
            "username": { required: true, email: true },
            "password": { required: true, minlength: 6, maxlength: 12 },
        }
    });
}
if ($("#room-type-form")[0] != undefined) {
    $("#room-type-form").validate({
        rules: {
            "title": { required: true },
            "short_code": { required: true },
            "adult_capacity": { required: true, minlength: 1, maxlength: 2, digits: true },
            "kids_capacity": { required: true, minlength: 1, maxlength: 2 },
            "base_price": { required: true, number: true },
            "amenities_ids[]": { required: true },
        }
    });
}
if ($("#add-amenities-form")[0] != undefined) {
    $("#add-amenities-form").validate({
        rules: {
            "name": { required: true },
        }
    });
}
if ($("#room-form")[0] != undefined) {
    $("#room-form").validate({
        rules: {
            "room_no": { required: true, minlength: 1, maxlength: 5, digits: true },
            "floor": { required: true },
            "room_type_id": { required: true },
        }
    });
}
if ($("#add-user-form")[0] != undefined) {
    $("#add-user-form").validate({
        rules: {
            "role_id": { required: true },
            "name": { required: true },
            "email": { required: true, email: true },
            "mobile": { required: true, minlength: 10, maxlength: 10, digits: true, },
            "gender": { required: true },
            "address": { required: true },
            "new_password": { required: true, minlength: 6 },
            "conf_password": { required: true, minlength: 6, equalTo: "#password" },
            "status": { required: true },

        }
    });
}
if ($("#edit-user-form")[0] != undefined) {
    $("#edit-user-form").validate({
        rules: {
            "role_id": { required: true },
            "name": { required: true },
            "email": { required: true, email: true },
            "mobile": { required: true, minlength: 10, maxlength: 10, digits: true, },
            "gender": { required: true },
            "address": { required: true },
            "status": { required: true },
        }
    });
}
if ($("#profile-update-form")[0] != undefined) {
    $("#profile-update-form").validate({
        rules: {
            "name": { required: true },
            "email": { required: true, email: true },
            "mobile": { required: true, minlength: 10, maxlength: 10, digits: true, },
            "gender": { required: true },

        }
    });
}
if ($("#password-update-form")[0] != undefined) {
    $("#password-update-form").validate({
        rules: {
            "new_password": { required: true, minlength: 6 },
            "conf_password": { required: true, minlength: 6, equalTo: "#password" },
        }
    });
}
if ($("#food-category-form")[0] != undefined) {
    $("#food-category-form").validate({
        rules: {
            "name": { required: true },
            "status": { required: true },
        }
    });
}
if ($("#food-item-form")[0] != undefined) {
    $("#food-item-form").validate({
        rules: {
            "name": { required: true },
            "status": { required: true },
            "category_id": { required: true },
            "price": { required: true, number: true },
        }
    });
}
if ($("#expense-category-form")[0] != undefined) {
    $("#expense-category-form").validate({
        rules: {
            "name": { required: true },
            "status": { required: true },
        }
    });
}
if ($("#expense-form")[0] != undefined) {
    $("#expense-form").validate({
        rules: {
            "title": { required: true },
            "datetime": { required: true },
            "category_id": { required: true },
            "amount": { required: true, number: true },
        }
    });
}
if ($("#add-product-form")[0] != undefined) {
    $("#add-product-form").validate({
        rules: {
            "name": { required: true },
            "status": { required: true },
            "stock_qty": { required: true },
            "measurement": { required: true },
        }
    });
}
if ($("#update-product-form")[0] != undefined) {
    $("#update-product-form").validate({
        rules: {
            "name": { required: true },
            "status": { required: true },
        }
    });
}
if ($("#amenities-form")[0] != undefined) {
    $("#amenities-form").validate({
        rules: {
            "name": { required: true },
            "status": { required: true },
        }
    });
}
if ($("#stock-form")[0] != undefined) {
    $("#stock-form").validate({
        rules: {
            "product_id": { required: true },
            "stock_is": { required: true },
            "qty": { required: true },
            //"price": { required: true },
        }
    });
}
if ($("#add-reservation-form")[0] != undefined) {
    $("#add-reservation-form").validate({
        rules: {
            "guest_type": { required: true },
            "selected_customer_id": {
                required: {
                    depends: function(element) {
                        return checkGuestType('existing');
                    }
                },
            },
            "name": {
                required: {
                    depends: function(element) {
                        return checkGuestType('new');
                    }
                },
            },
            "mobile": {
                required: {
                    depends: function(element) {
                        return checkGuestType('new');
                    }
                },
                minlength: 10,
                maxlength: 10,
                digits: true,
            },
            "address": {
                required: {
                    depends: function(element) {
                        return checkGuestType('new');
                    }
                },
            },
            "country": {
                required: {
                    depends: function(element) {
                        return checkGuestType('new');
                    }
                },
            },
            "state": {
                required: {
                    depends: function(element) {
                        return checkGuestType('new');
                    }
                },
            },
            "city": {
                required: {
                    depends: function(element) {
                        return checkGuestType('new');
                    }
                },
            },
            "gender": {
                required: {
                    depends: function(element) {
                        return checkGuestType('new');
                    }
                },
            },

            "check_in_date": {
                required: true,
            },
            // "duration_of_stay": {
            //     required: true,
            // },
            "no_of_rooms": {
                required: true,

            },
            "room_type_id": {
                required: true,
            },
            "room_num[]": {
                required: true,
            },
            // "adult": {
            //     required: true,
            // },
            "kids": {
                // required: true,
            },
            // "idcard_type": {
            //     required: true,
            // },
            // "idcard_no": {
            //     required: true,
            //     minlength: 12,
            //     maxlength: 12,
            // },
        }
    });
}
if ($("#customer-form")[0] != undefined) {
    $("#customer-form").validate({
        rules: {
            "name": { required: true },
            "father_name": { required: true },
            "mobile": { required: true, minlength: 10, maxlength: 10, digits: true },
            "email": { email: true },
            "address": { required: true },
            "country": { required: true },
            "state": { required: true },
            "city": { required: true },
            "gender": { required: true },
            "age": { required: true },
        }
    });
}
/* ***** end form validations ***** */

/* ***** start swal alert ***** */
$(document).on('click', '.delete_btn', function() {
    var deleteUrl = $(this).data('url');
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then(function(result) {
        if (result.value) {
            window.location.href = deleteUrl;
        }
    });
});
/* ***** start swal alert ***** */

/* ***** start custom functions ***** */
function checkGuestType(type) {
    return ($("input[name='guest_type']:checked").val() == type) ? true : false;
}

function getMaxDiscount(amount, perc = 20) {
    var maxDiscount = (perc / 100) * amount;
    return maxDiscount;
}

function initDatePicker() {

    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        autoUpdateInput: false,
    })
}

function cleanCache() {
    globalFunc.ajaxCall('api/clean-cache', '', 'GET', globalFunc.before, globalFunc.successCache, globalFunc.error, globalFunc.complete);
}
globalFunc.successCache = function(data) {
    console.log(data);
}
if (current_segment === 'set-siteconfig') {
    cleanCache();
}
/* ***** end custom functions ***** */


/* ***** start js room_reservation_view page ***** */
$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
});
/* ***** end js room_reservation_view page ***** */
