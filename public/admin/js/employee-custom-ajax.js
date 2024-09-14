//Employee attendance details
$(document).ready(function() {
    //validation
    $("#employee_punch_in_attendance").validate({
        rules: {
            attendance_status: {
                required: true,
            },
            sift: {
                required: true,
            },
            sift_type: {
                required: true,
            },
            punch_in_time: {
                required: true,
            },
        },
        messages: {
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            var formData = $(form).serialize();    
            //Ajax employee attendance submit form
            $.ajax({
                type: 'POST',
                url: base_url + '/employee/submit-punch-in-attendance',
                data: formData,
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show();
                    $(".is_create_employee_punch_in_attendance").prop("disabled", true);
                },
                success: function(response) {
                    $(".employee_attendance_responce").html(response);
                    //Reset form
                    $('#employee_punch_in_attendance')[0].reset();
                    $(".is_create_employee_punch_in_attendance").prop("disabled", false);
                    $(".com_ajax_loader").hide();
                },
            });
        }
    });
    //Getting employee attandance id and name
    $('body').on('click', '.employeet_punch_in_attendances', function() {
        var employee_id = $(this).data("employee_id");
        var employee_name = $(this).data("employee_name");
        //Apend value
        $("#model_employee_id").val(employee_id);
        //attendance employee header
        $(".employee_attendances").text(employee_name);  
    });
});


//employee attendance punch out details
$(document).ready(function() {
    //validation
    $("#employee_punch_out_attendance").validate({
        rules: {
            punch_out_time: {
                required: true,
            },
        },
        messages: {
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            //Get id
            var employee_id = $("#model_punch_out_employee_id").val();  
            var punch_out_time = $("#punch_out_time").val();  
            
            //Ajax employee attendance submit form
            $.ajax({
                type: 'POST', 
                url: base_url + '/employee/update-punch-out-attendance',
                data: {
                    employee_id: employee_id,
                    punch_out_time: punch_out_time,  
                },
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show();
                    $(".is_update_employee_punch_out_attendance").prop("disabled", true);
                },
                success: function(response) {
                    $(".student_attendance_responce").html(response);
                    //Reset form
                    $('#employee_punch_out_attendance')[0].reset();
                    $(".is_update_employee_punch_out_attendance").prop("disabled", false);
                    $(".com_ajax_loader").hide();
                },
            });
        }
    });
    //Getting employee attandance id and name
    $('body').on('click', '.employee_punch_out_attendance', function() {
        var employee_id = $(this).data("employee_id");
        var student_name = $(this).data("student_name");
        //Apend value
        $("#model_punch_out_employee_id").val(employee_id);
        //attendance employee header
        $(".student_attendance_name").text(student_name);  
    });
});

