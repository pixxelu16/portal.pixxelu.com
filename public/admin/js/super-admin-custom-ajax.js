//Super admin ajax
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
                url: base_url + '/super-admin/submit-student-fees',
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
//Get student pay fees model
$('body').on('click', '.student_pay_fees', function() { 
    var student_id = $(this).data("student_id");
    var student_name = $(this).data("student_name");
  
    //Append value
    $("#model_student_id").val(student_id);      
    //student pay fees header
    $(".student_name_pay_fees").text(student_name);    
});

//Student assign accessories
$(document).ready(function() {
    //Submit assign accessories form
    $('body').on('click', '.is_create_student_assign_accessorie', function(event) {
        event.preventDefault();     
        //serialize form data
        var data = $('#student_accessories').serialize();  
        //Call Ajax
        $.ajax({
            type: 'POST',      
            url: base_url + '/super-admin/submit-student-assign-accessories',
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
//Get student asign accessories model
$('body').on('click', '.student_assign_accessories', function() {
    var student_id = $(this).data("student_id");
  
    //Append value
    $("#model_student_id").val(student_id);      
});

//Student damage accessories
$(document).ready(function() {
    //Submit damage accessories form
    $('body').on('click', '.is_create_student_damage_accessorie', function(event) {
        event.preventDefault();  
        //serialize form data   
        var data = $('#student_damage_accessories').serialize();  
        //Call Ajax
        $.ajax({
            type: 'POST',      
            url: base_url + '/super-admin/submit-student-damage-accessories',
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
//Get damage accessories model
$('body').on('click', '.student_damage_accessories', function() {
    var student_id = $(this).data("student_id");
  
    //Append value
    $("#modeal_student_id").val(student_id);      
});

//Students search list accor course type
$(document).ready(function() {
    $('body').on('change', '#search_student_list', function() {
        var courseType = $(this).val();
        window.location.href = base_url+'/super-admin/search-students-list/'+courseType;
    });
});

//Students search list accor fees paid or pending
$(document).ready(function() {
    $('body').on('change', '#search_student_fees_status', function() {
        var fees_status = $(this).val();
        window.location.href = base_url+'/super-admin/search-students-fees-list/'+fees_status;
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
                url: base_url + '/super-admin/trash-student',
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
//Get student trash model
$('body').on('click', '.student_trash_record', function() {
    $('#modeal_student_id').modal('show');
    var student_id = $(this).data("student_id");

    //Append value
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
                    url: base_url + '/super-admin/delete-student',
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

//Get student single details 
$(document).ready(function() {
    $('.student-link').on('click', function(e) {
        e.preventDefault();
        var studentId = $(this).data('student_id');
        $(".student_detail_response").empty();
        //Get student details
        $.ajax({
            url:  base_url +'/super-admin/get-student-detail',
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

//Student fees model 
$(document).ready(function() {
    //Show our model
    $('body').on('click', '.edit-btn', function() {
        var feeId = $(this).data('fee-id');
        var feeMonth = $(this).data('fee-month');
        $('#fee_id').val(feeId);
        $('#fee_month').val(feeMonth);  
        $('#editFeeModal').modal('show');
    });

    //Update student fees 
        $('body').on('click', '.is_update_student_fees', function(e) {
        e.preventDefault();
        //Validate form
        var userFees = $('#user_fees').val();
        if (userFees === '' || !/^\d+$/.test(userFees)) {
            $('.user_fee_responce').html('<div class="alert alert-danger">This field is required</div>');
            return;
        }
        //serialize form data
        var data = $('#editFeeForm').serialize();  
        $.ajax({ 
            type: 'POST',
            url: base_url + '/super-admin/update-student-fees',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                $(".com_ajax_loader").show();
                $('.is_update_student_fees').prop('disabled', true);
            },
            success: function (response) {
                $('.student_update_fee_responce').html(response);
                $(".is_update_student_fees").prop('disabled', false);
                $(".com_ajax_loader").hide();

            }
        });
    });
});

//Employee details
//Employee attendance details
$(document).ready(function() {
    //validation
    $("#employee_attendance").validate({
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
                url: base_url + '/super-admin/submit-employee-attendance',
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
                    $('#employee_attendance')[0].reset();
                    $(".is_create_employee_attendance").prop("disabled", false);
                    $(".com_ajax_loader").hide();
                },
            });
        }
    });
    
    //Getting employee attandance id and name
    $('body').on('click', '.employee_attandance', function() {
        var employee_id = $(this).data("employee_id");
        var employee_name = $(this).data("employee_name");
        //Apend value
        $("#models_employee_id").val(employee_id);
        //attendance employee header
        $(".employee_attendances").text(employee_name);  
    });
});

//Employee pay salary
$(document).ready(function() {
    //Validate form
    $('#is_create_employee_salary').validate({
        rules: {
            employee_salary: {
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
            //Ajax employee submit salary form
            $.ajax({
                type: 'POST',
                url: base_url + '/super-admin/submit-employee-salary',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    $(".com_ajax_loader").show();
                    $('.disable-submit').prop('disabled', true);
                },
                success: function (response) {
                    $('.employee_salary_responce').html(response);
                    //Reset form
                    $('#is_create_employee_salary')[0].reset();
                    $(".disable-submit").prop('disabled', false);
                    $(".com_ajax_loader").hide();
                }
            });
        }
    }); 
});

//Get employee pay salary detail
$('body').on('click', '.employee_pay_salary', function() {
    var employee_id = $(this).data("employee_id");
    var employee_name = $(this).data("employee_name");
    var employee_amount = $(this).data("employee_amount");
    
    //Apend value
    $("#model_employees_id").val(employee_id);   
    $("#employee_name").val(employee_name);   
    $("#employee_salary").val(employee_amount);
    //pay salary employee header
    $(".pay_employee_salary").text(employee_name);   
});    

//Employee increment salary
$(document).ready(function() {
    //Validate form
    $('#employee_salaries').validate({
        rules: {
            increment_amount: {
            required: true,
            },
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            var formData = $(form).serialize();
            //Ajax employee increment form
            $.ajax({
                type: 'POST',
                url: base_url + '/super-admin/submit-employee-increment-salary',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show();
                    $('.is_create_employee_increment_salary').prop('disabled', true);
                },
                success: function(response) {
                    $('.salary_responce').html(response);
                    //Reset form
                    $('#employee_salaries')[0].reset();
                    $('.is_create_employee_increment_salary').prop('disabled', false);
                    $(".com_ajax_loader").hide();
                }
            });
        }
    });
});
//Get employee pay increment salary details
$('body').on('click', '.employee_increment_salary', function() {
    var employee_id = $(this).data("employee_id"); 
    var employee_name = $(this).data("employee_name"); 

    //Append value
    $("#employee_increment").val(employee_id);
    $("#employee_names").val(employee_name);
    //pay increment employee header
    $(".add_increment_employee_salary").text(employee_name);  
});

//Employees role search list 
$(document).ready(function() {
    $('body').on('change', '#employee_role', function() {
        var employee_role = $(this).val();
        window.location.href = base_url+'/super-admin/search-employees-list/'+employee_role;
    });
});

//Employee assign accessories
$(document).ready(function() {
    $('body').on('click', '.is_create_employee_assign_accessories', function(event) {
        event.preventDefault();       
        //Serialize form data
        var data = $('#employee_assign_accessoriess').serialize();      
        //Call Ajax submit assign form
        $.ajax({
            type: 'POST',
            url: base_url + '/super-admin/submit-employee-assign-accessories',
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
//Get employee assign modal
$('body').on('click', '.employee_assign_accessori', function() {
    var employee_id = $(this).data("employee_id");
    $("#models_employee_id").val(employee_id);
});

//Employee damage accessories
$(document).ready(function() {
    //Submit damage accessories form
    $('body').on('click', '.is_create_damage_damage_accessories', function(event) {
        event.preventDefault();     
        var data = $('#employee_damage_accessoriess').serialize();  
        //Call Ajax damage form
        $.ajax({
            type: 'POST',      
            url: base_url + '/super-admin/submit-employee-damage-accessories',
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
//Get employee damage accessories model
$('body').on('click', '.employee_damage_accessories', function() {
    var employee_id = $(this).data("employee_id");
  
    //Append value
    $("#modeal_employee_id").val(employee_id);      
});

//Trah employee record
$(document).ready(function() {
    //Validation form
    $('#trash_employee_form').validate({
        rules: {
            employee_status: {
                required: true
            }
        },
        submitHandler: function(form) {
            //Ajax request
            var employee_id = $("#trash_employee_id").val();
            var employee_status = $("input[name='employee_status']:checked").val();
            //Call ajax 
            $.ajax({
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url + '/super-admin/trash-employee',
                data: {
                    employee_id: employee_id,
                    employee_status: employee_status
                },
                beforeSend: function() {
                    $(".com_ajax_loader").show();
                    $(".is_delete_employee_trash_record").prop("disabled", true);
                },
                success: function(response) {
                    $(".trash_responce").html(response);
                    $(".is_delete_employee_trash_record").prop("disabled", false);
                    $(".com_ajax_loader").hide();
                },
            });
        }
    });
});
//GET employee trash model
$('body').on('click', '.employee_trash_record', function() {
    $('#model_employee_id').modal('show');
    var employee_id = $(this).data("employee_id");

    //Append value
    $("#trash_employee_id").val(employee_id);
});

//Employee record delete
$(document).ready(function() {
    //Delete employee record
    $('body').on('click', '.is_delete_employee_record', function(event) {
        event.preventDefault();
        var employee_id = $(this).data('employee_id');       
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
                    url: base_url + '/super-admin/delete-employee',
                    data: { employee_id: employee_id },
                    //Show success message
                    success: function(response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Employee record deleted successfully.",
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

//Employee single details 
$(document).ready(function() {
    $('.employee_detail').on('click', function(e) {
        e.preventDefault();
        var employee_id = $(this).data('employee_id');
        $(".employee_detail_response").empty();
        //AJAX request to get employees details
        $.ajax({
            url:  base_url +'/super-admin/get-employee-detail',
            method: 'GET',
            data: {employee_id: employee_id},
            beforeSend: function() {
                $(".com_ajax_loaders").css('visibility', 'visible');
            },
            success: function(response) {
                $(".employee_detail_response").html(response);
            },
            complete: function() {
                $(".com_ajax_loaders").css('visibility', 'hidden');
            },
        });
    });
});
