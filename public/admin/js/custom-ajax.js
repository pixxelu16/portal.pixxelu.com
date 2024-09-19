//Student fees submit 
$(document).ready(function() {
    //Validate form
    $('#is_create_student_fee').validate({
        rules: {
            fees_amount: {
                required: true,
            },
            payment_type: {
                required: true,
            },        
        },
        messages: { },
        submitHandler: function (form, e) {
            e.preventDefault();
            var formData = $(form).serialize();
            //Ajax student submit fees form
            $.ajax({
                type: 'POST',
                url: base_url + '/admin/submit-student-fees',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $(".com_ajax_loader").show();
                    $('.disable-submit').prop('disabled', true);
                },
                success: function (response) {
                    $('.student_fee_responce').html(response);
                    $(".disable-submit").prop('disabled', false);
                    $(".com_ajax_loader").hide();
                }
            });
        }
    }); 
});
//For get student pay fees model
$('body').on('click', '.student_pay_fees', function() {
    var student_id = $(this).data("student_id");
    var student_name = $(this).data("student_name");
  
    //Append value
    $("#model_student_id").val(student_id);
    //student pay fees header
    $(".student_name_pay_fees").text(student_name);      
});

//Student edit fees model 
$(document).ready(function() {
    //Show modal and populate fields
    $('body').on('click', '.edit-btn', function() {
        var feeId = $(this).data('fee-id');   
        var feeMonth = $(this).data('fee-month');
        var feesAmount = $(this).data('fee-amount');
        var studentName = $(this).data('student-name');
        
        //Populate values
        $('#fee_id').val(feeId);
        $('#fee_month').val(feeMonth);  
        $("#model_student_amount").val(feesAmount);    
        $(".edit_pay_fees").text(studentName);   
        $('#editFeeModal').modal('show');
    });

    //Update student fees 
    $('body').on('submit', '#editFeeForm', function(e) {
        e.preventDefault(); 

        //Get field values
        var userFees = $('#model_student_amount').val();
        var paymentType = $('#payment_type').val();

        //Validate form
        var isValid = true;
        $('.user_fee_responce').empty();
        $('.user_fee_type_responce').empty();

        if (userFees === '' || !/^\d+$/.test(userFees)) {
            $('.user_fee_responce').html('<div class="alert alert-danger">Fees Amount is required and must be a valid number.</div>');
            isValid = false;
        }

        if (paymentType === '') {
            $('.user_fee_type_responce').html('<div class="alert alert-danger">Payment Type is required.</div>');
            isValid = false;
        }

        if (isValid) {
            var formData = $(this).serialize();

            $.ajax({
                type: 'POST',
                url: base_url + '/admin/update-student-fees',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show(); 
                    $('.is_update_student_fees').prop('disabled', true); 
                },
				   success: function (response) {
					$('.student_update_fee_responce').html(response);
					$(".is_update_student_fees").prop('disabled', false);
					$(".com_ajax_loader").hide();
				}              
            });
        }
    });
});

//Student assign accessories
$(document).ready(function(){
    //Submit assign accessories form
    $('body').on('click', '.is_create_student_assign_accessorie', function(event) {
        event.preventDefault();     
            //serialize form data
            var data = $('#student_accessories').serialize();  
        //Call Ajax
        $.ajax({
            type: 'POST',      
            url: base_url + '/admin/submit-student-assign-accessories',
            data: data,
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, 
            beforeSend: function() {
                $(".com_ajax_loader").show();
                $(".is_create_student_assign_accessorie").prop("disabled", true);
            },
            success: function(response) {
                $(".assign_accessorie_responce").html(response);
                $(".is_create_student_assign_accessorie").prop("disabled", false);
                $(".com_ajax_loader").hide(); 
            },
        });
    });
});
//For get student asign accessories model
$('body').on('click', '.student_assign_accessories', function() {
    var student_id = $(this).data("student_id");
  
    //Append value
    $("#model_student_id").val(student_id);      
});

//Student damage accessories
$(document).ready(function(){
    //Submit damage accessories form
    $('body').on('click', '.is_create_student_damage_accessorie', function(event) {
        event.preventDefault();     
            //alert('yes'); return false;
            var data = $('#student_damage_accessories').serialize();  
        //Call Ajax
        $.ajax({
            type: 'POST',      
            url: base_url + '/admin/submit-student-damage-accessories',
            data: data,
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, 
            beforeSend: function() {
                $(".com_ajax_loader").show();
                $(".is_create_student_damage_accessorie").prop("disabled", true);
            },
            success: function(response) {
                $(".damage_accessorie_responce").html(response);
                $(".is_create_student_damage_accessorie").prop("disabled", false);
                $(".com_ajax_loader").hide(); 
            },
        });
    });
});
//For get damage accessories model
$('body').on('click', '.student_damage_accessories', function() {
    var student_id = $(this).data("student_id");
  
    //Append value
    $("#modeal_student_id").val(student_id);      
});

//Students search list course type
$(document).ready(function() {
    $('body').on('change', '#search_student_list', function() {
        var courseType = $(this).val();
        window.location.href = base_url+'/admin/search-students-list/'+courseType;
    });
});

//Students search status Fees
$(document).ready(function() {
    $('body').on('change', '#search_student_fees_status', function() {
        var fees_status = $(this).val();
        window.location.href = base_url+'/admin/search-students-fees-list/'+fees_status;
    });
});

//Trash student record
$(document).ready(function() {
    //Validation form
    $('#trash_student_form').validate({
        rules: {
            user_status: {
                required: true
            }
        },
        submitHandler: function(form) {
            //Ajax request
            var student_id = $("#trash_student_id").val();
            var status = $("input[name='user_status']:checked").val();
            //Call ajax
            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url + '/admin/trash-student',
                data: {
                    student_id: student_id,
                    status: status
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show();
                    $(".is_delete_trash_record").prop("disabled", true);
                },
                success: function(response) {
                    $(".trash_responce").html(response);
                    $(".is_delete_trash_record").prop("disabled", false);
                    $(".com_ajax_loader").hide();
                },
            });
        }
    });
});
//Show student trash model
$('body').on('click', '.student_trash_record', function() {
    $('#modeal_student_id').modal('show');
    var student_id = $(this).data("student_id");
    // Append value
    $("#trash_student_id").val(student_id);
});


//Student record delete
$(document).ready(function() {
    //Delete student record
    $('body').on('click', '.is_delete_student_record', function(event) {
        event.preventDefault();
        var id = $(this).data('id');       
        //through sweet alert
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                //Call ajax
                $.ajax({
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: base_url + '/admin/delete-student',
                    data: { id: id },
                    //Show success message
                    success: function(response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Student record Deleted successfully.",
                            icon: "success"
                        }).then(() => {
                            location.reload();
                        });
                    },
                });
            }
        });
    });
});

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
                url: base_url + '/admin/submit-employee-attendance',
                data: formData,
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show();
                    $(".is_create_employee_attendance").prop("disabled", true);
                },
                success: function(response) {
                    $(".employee_attendance_responce").html(response);
                    //Reset form
                    $('#employee_punch_in_attendance')[0].reset();
                    $(".is_create_employee_attendance").prop("disabled", false);
                    $(".com_ajax_loader").hide();
                },
            });
        }
    });
    //Getting employee attandance id and name
    $('body').on('click', '.employee_punch_in_attendance', function() {
        var employee_id = $(this).data("employee_id");
        var employee_name = $(this).data("employee_name");
        //Apend value
        $("#models_employee_id").val(employee_id);
        //attendance employee header
        $(".employee_attendances").text(employee_name);  
    });
});


//Employee attendance punch out details
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
            var employee_id = $("#models_employee_id").val();  
            var punch_out_time = $("#punch_out_time").val();  
            
            //Ajax employee attendance submit form
            $.ajax({
                type: 'POST', 
                url: base_url + '/admin/update-employee-punch-out-attendance',
                data: {
                    employee_id: employee_id,
                    punch_out_time: punch_out_time,  
                },
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show();
                    $(".is_create_employee_punch_out_attendance").prop("disabled", true);
                },
                success: function(response) {
                    $(".employee_attendance_responce").html(response);
                    //Reset form
                    $('#employee_punch_out_attendance')[0].reset();
                    $(".is_create_employee_punch_out_attendance").prop("disabled", false);
                    $(".com_ajax_loader").hide();
                },
            });
        }
    });
    //Getting employee attandance id and name
    $('body').on('click', '.employee_punch_out_attendance', function() {
        var employee_id = $(this).data("employee_id");
        var employee_name = $(this).data("employee_name");
        //Apend value
        $("#models_employee_id").val(employee_id);
        //attendance employee header
        $(".employee_attendances").text(employee_name);  
    });
});

//Employee assign accessories
$(document).ready(function() {
    $('body').on('click', '.is_create_employee_assign_accessories', function(event) {
        event.preventDefault();
        //Serialize form data
        var data = $('#employee_assign_accessoriess').serialize();        
        //Call Ajax
        $.ajax({
            type: 'POST',
            url: base_url + '/admin/submit-employee-assign-accessories',
            data: data,
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function() {
                $(".com_ajax_loader").show();
                $(".is_create_employee_assign_accessories").prop("disabled", true);
            },
            success: function(response) {
                $(".assign_accessorie_responce").html(response);
                $(".is_create_employee_assign_accessories").prop("disabled", false);
                $(".com_ajax_loader").hide();
            },
        });
    }); 
});
//For get assign employee accessories model
$('body').on('click', '.employee_assign_accessori', function() {
    var employee_id = $(this).data("employee_id");
    //Append value
    $("#assign_model_employee_id").val(employee_id);     
});

//Employee damage accessories
$(document).ready(function() {
    //Submit damage accessories form
    $('body').on('click', '.is_create_damage_damage_accessories', function(event) {
        event.preventDefault();     
            //alert('yes'); return false;
            var data = $('#employee_damage_accessoriess').serialize();  
        //Call Ajax
        $.ajax({
            type: 'POST',      
            url: base_url + '/admin/submit-employee-damage-accessories',
            data: data,
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, 
            beforeSend: function() {
                $(".com_ajax_loader").show();
                $(".is_create_damage_damage_accessories").prop("disabled", true);
            },
            success: function(response) {
                $(".damage_accessorie_responce").html(response);
                $(".is_create_damage_damage_accessories").prop("disabled", false);
                $(".com_ajax_loader").hide(); 
            },
        });
    });
});
//For get employee damage accessories model
$('body').on('click', '.employee_damage_accessories', function() {
    var employee_id = $(this).data("employee_id");  
    //Append value
    $("#damage_model_employee_id").val(employee_id);      
});

//Employees role search list 
$(document).ready(function() {
    $('body').on('change', '#employee_role', function() {
        var employee_role = $(this).val();
        window.location.href = base_url+'/admin/search-employees-list/'+employee_role;
    });
});

//Employee attendances search list 
// $(document).ready(function() {
//     $('#get_employee_attendance').on('submit', function(e) {
//         e.preventDefault();

        //alert "yes"; return false;

        // Capture the input values
        // var employeeName = $('input[name="employee_name"]').val().trim();
        // var selectedMonth = $('select[name="month"]').val();
        // var selectedYear = $('select[name="year"]').val();

        // // Build the URL with the captured values
        // var searchUrl = base_url + '/admin/search-employee-attendance-list?' +
        //     'employee_name=' + encodeURIComponent(employeeName) + '&' +
        //     'month=' + encodeURIComponent(selectedMonth) + '&' +
        //     'year=' + encodeURIComponent(selectedYear);

        // Redirect to the constructed URL
//         window.location.href = searchUrl;
//     });
// });

//Student single details 
$(document).ready(function() {
    $('.student-link').on('click', function(e) {
        e.preventDefault();
        var studentId = $(this).data('student_id');
        $(".student_detail_response").empty();
        // Make AJAX request to get student details
        $.ajax({
            url:  base_url +'/admin/get-student-detail',
            method: 'GET',
            data: {studentId: studentId},
            beforeSend: function() {
                $(".com_ajax_loaders").css('visibility', 'visible');
            },
            success: function(response) {
                $(".student_detail_response").html(response);
            },
            complete: function() {
                $(".com_ajax_loaders").css('visibility', 'hidden');
            },
        });
    });
});

//Employee single details 
$(document).ready(function() {
    $('.employee_detail').on('click', function(e) {
        e.preventDefault();
        var employee_id = $(this).data('employee_id');
        $(".student_detail_response").empty();
        // Make AJAX request to get student details
        $.ajax({
            url:  base_url +'/admin/get-employee-detail',
            method: 'GET',
            data: {employee_id: employee_id},
            beforeSend: function() {
                $(".com_ajax_loaders").css('visibility', 'visible');
            },
            success: function(response) {
                $(".student_detail_response").html(response);
            },
            complete: function() {
                $(".com_ajax_loaders").css('visibility', 'hidden');
            },
        });
    });
});

//inquery search list accor status
$(document).ready(function() {
    $('body').on('change', '#search_inquery_status_list', function() {
        var inquery_status = $(this).val();
        window.location.href = base_url+'/admin/search-inquery/'+inquery_status;
    });
});

//inquery search list accor course type
$(document).ready(function() {
    $('body').on('change', '#search_inquery_course_type_list', function() {
        var course_type = $(this).val();
        window.location.href = base_url+'/admin/search-inquery-course-type/'+course_type;
    });
});


var service_name = $(this).data("service_name");

$(document).on("click","#cust_btn",function(){
  
  $("#myModal").modal("toggle");
  
})