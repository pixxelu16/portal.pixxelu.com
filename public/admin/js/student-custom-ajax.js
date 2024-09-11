//Employee attendance details
$(document).ready(function() {
    //validation
    $("#student_punch_in_attendance").validate({
        rules: {
            attendance_status: {
                required: true,
            },
            batch: {
                required: true,
            },
            batch_time: {
                required: true,
            },
            punch_in_time: {
                required: true,
            },
            punch_out_time: {
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
                url: base_url + '/student/submit-punch-in-attendance',
                data: formData,
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show();
                    $(".is_create_student_punch_in_attendance").prop("disabled", true);
                },
                success: function(response) {
                    $(".employee_attendance_responce").html(response);
                    //Reset form
                    $('#student_punch_in_attendance')[0].reset();
                    $(".is_create_student_punch_in_attendance").prop("disabled", false);
                    $(".com_ajax_loader").hide();
                },
            });
        }
    });
    //Getting student attandance id and name
    $('body').on('click', '.student_punch_in_attendances', function() {
        var student_id = $(this).data("student_id");
        var student_name = $(this).data("student_name");
        //Apend value
        $("#model_student_id").val(student_id);
        //attendance student header
        $(".student_attendances").text(student_name);  
    });
});


//student attendance punch out details
$(document).ready(function() {
    //validation
    $("#student_punch_out_attendance").validate({
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
            var student_id = $("#model_punch_out_student_id").val();  
            var punch_out_time = $("#punch_out_time").val();  
            
            //Ajax student attendance submit form
            $.ajax({
                type: 'POST', 
                url: base_url + '/student/update-punch-out-attendance',
                data: {
                    student_id: student_id,
                    punch_out_time: punch_out_time,  
                },
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show();
                    $(".is_create_student_punch_out_attendance").prop("disabled", true);
                },
                success: function(response) {
                    $(".student_attendance_responce").html(response);
                    //Reset form
                    $('#student_punch_out_attendance')[0].reset();
                    $(".is_create_student_punch_out_attendance").prop("disabled", false);
                    $(".com_ajax_loader").hide();
                },
            });
        }
    });
    //Getting student attandance id and name
    $('body').on('click', '.student_punch_out_attendance', function() {
        var student_id = $(this).data("student_id");
        var student_name = $(this).data("student_name");
        //Apend value
        $("#model_punch_out_student_id").val(student_id);
        //attendance employee header
        $(".student_attendance_name").text(student_name);  
    });
});