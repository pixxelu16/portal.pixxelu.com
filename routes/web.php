<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
}); 

Route::group(['middleware' => 'auth'], function() { 
    //Stcks
    Route::post('super-admin/submit-stock', [App\Http\Controllers\CommonStockController::class, 'submit_stock'])->name('common.submit.stock');
    //Super_Admin Only 
    Route::group(['middleware' => 'Super_Admin'], function() { 
        //Super_Admin dashboard  
       Route::get('super-admin/dashboard', [App\Http\Controllers\SuperAdmin\DashboardController::class, 'dashboard']);
       //profile
       Route::get('super-admin/profile', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'edit_profile']);
       Route::post('super-admin/update-profile/{id}', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'update_profile'])->name('super.admin.update.profile');
       Route::get('super-admin/change-password', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'changed_password']);
       Route::post('super-admin/submit-change-password/{id}', [App\Http\Controllers\SuperAdmin\ProfileController::class, 'submit_changed_password'])->name('super.admin.changed.password');
       //employees  
       Route::get('super-admin/get-employee-detail', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'single_employee_detail']);
       Route::get('super-admin/all-employees-list', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'all_employees_list']);
       Route::get('super-admin/add-new-employee', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'add_employee']);
       Route::post('super-admin/submit-employee-increment-salary', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'submit_employee_salary_increment'])->name('super.admin.employee.salary.increment');
       Route::post('super-admin/submit-employee', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'submit_employee'])->name('super.admin.submit.employee');
       Route::get('super-admin/edit-employee/{id}', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'edit_employee']);
       Route::post('super-admin/update-employee{id}', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'update_employee'])->name('super.admin.update.employee');
       Route::get('super-admin/search-employees-list/{any}', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'search_employee_list'])->name('super.admin.search.employee.list');
       Route::get('super-admin/trash-employee', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'trash_employee'])->name('super.admin.employee.trash');
       Route::get('super-admin/all-employees-trash-list', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'all_trash_employees_list']);
       Route::get('super-admin/delete-employee', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'delete_employee'])->name('super.admin.employee.delete');
       //Route::get('super-admin/employee-detail/{id}', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'single_employee_details']);
       //employee attendance 
       Route::post('super-admin/submit-employee-attendance', [App\Http\Controllers\SuperAdmin\EmployeeAttendanceController::class, 'employee_attendance'])->name('super.admin.submit.employee.attendance');
       //Employee assign accessories 
       Route::post('super-admin/submit-employee-assign-accessories', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'submit_employee_assign_accessories'])->name('super.admin.submit.assign.accessories.employee');
       Route::post('super-admin/submit-employee-damage-accessories', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'submit_employee_damage_accessories'])->name('super.admin.submit.damage.accessories.employee');
       //employee salary
       Route::post('super-admin/submit-employee-salary', [App\Http\Controllers\SuperAdmin\EmployeeController::class, 'submit_employee_salary'])->name('super.admin.submit.employee.salary');
       //clients detail
       Route::get('super-admin/all-clients-list', [App\Http\Controllers\SuperAdmin\ClientController::class, 'all_clients_list']);
       Route::get('super-admin/add-new-client', [App\Http\Controllers\SuperAdmin\ClientController::class, 'add_client']);
       Route::post('super-admin/submit-client', [App\Http\Controllers\SuperAdmin\ClientController::class, 'submit_client'])->name('super.admin.submit.client');
       Route::get('super-admin/edit-client/{id}', [App\Http\Controllers\SuperAdmin\ClientController::class, 'edit_client']);
       Route::post('super-admin/update-client/{id}', [App\Http\Controllers\SuperAdmin\ClientController::class, 'update_client'])->name('super.admin.update.client');
       //students detail
       Route::get('super-admin/all-students-list', [App\Http\Controllers\SuperAdmin\StudentController::class, 'all_students']);
       Route::get('super-admin/add-new-student', [App\Http\Controllers\SuperAdmin\StudentController::class, 'add_student']);
       Route::post('super-admin/submit-student', [App\Http\Controllers\SuperAdmin\StudentController::class, 'submit_student'])->name('super.admin.submit.student');
       Route::get('super-admin/edit-student/{id}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'edit_student']); 
       Route::post('super-admin/update-student/{id}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'update_student'])->name('super.admin.update.student');
       Route::get('super-admin/trash-student', [App\Http\Controllers\SuperAdmin\StudentController::class, 'trash_student'])->name('super.admin.student.trash');
       Route::get('super-admin/all-students-trash-list', [App\Http\Controllers\SuperAdmin\StudentController::class, 'all_trash_students_list']);
       Route::get('super-admin/delete-student', [App\Http\Controllers\SuperAdmin\StudentController::class, 'delete_student'])->name('super.admin.student.delete');     
       //student submit fees
       Route::post('super-admin/submit-student-fees', [App\Http\Controllers\SuperAdmin\StudentController::class, 'submit_student_fees'])->name('super.admin.submit.student.fees');
       Route::post('super-admin/update-student-fees', [App\Http\Controllers\SuperAdmin\StudentController::class, 'update_student_feess'])->name('super.admin.update.student.fees');
       //student previous fees 
       Route::get('super-admin/add-student-previous-fees', [App\Http\Controllers\SuperAdmin\StudentController::class, 'add_previous_fees']);
       Route::post('super-admin/submit-student-previous-fees', [App\Http\Controllers\SuperAdmin\StudentController::class, 'submit_previous_fees'])->name('super.admin.student.submit.fees');
       //single student detail 
       Route::get('super-admin/get-student-detail', [App\Http\Controllers\SuperAdmin\StudentController::class, 'single_student_detail']);
       Route::get('super-admin/edit-student-fees/{id}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'edit_student_fees']);
      //Route::post('super-admin/update-student-fees/{id}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'update_student_fees'])->name('super.admin.update.student.fees');
       Route::get('super-admin/delete-student-fees/{id}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'delete_student_fees']);
       //student assign accessories 
       Route::post('super-admin/submit-student-assign-accessories', [App\Http\Controllers\SuperAdmin\StudentController::class, 'submit_student_assign_accessories'])->name('super.admin.submit.assign.accessories.student');
       Route::post('super-admin/submit-student-damage-accessories', [App\Http\Controllers\SuperAdmin\StudentController::class, 'submit_student_damage_accessories'])->name('super.admin.submit.damage.accessories.student');
       Route::get('super-admin/edit-student-assign-accessories/{id}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'edit_student_assign_accessories']);
       Route::post('super-admin/update-student-assign-accessories/{id}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'update_student_assign_accessories'])->name('super.admin.update.assign.accessories.student');
       Route::get('super-admin/delete-student-assign-accessories/{id}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'delete_student_assign_accessories']);
       //students search coure type list
       Route::get('super-admin/search-students-list/{any}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'search_students_list'])->name('super.admin.search.student.list');
       //student search fees status list 
       Route::get('super-admin/search-students-fees-list/{any}', [App\Http\Controllers\SuperAdmin\StudentController::class, 'search_students_fees_list'])->name('super.admin.search.student.fees.list');
       //inqueries deatils 
       Route::get('super-admin/add-new-inquery', [App\Http\Controllers\SuperAdmin\InqueryController::class, 'add_inquery']);
       Route::post('super-admin/submit-inquery', [App\Http\Controllers\SuperAdmin\InqueryController::class, 'submit_inquery'])->name('super.admin.submit.inquery');
       Route::get('super-admin/all-inqueries-list', [App\Http\Controllers\SuperAdmin\InqueryController::class, 'all_inqueries']);
       Route::get('super-admin/edit-inquery/{id}', [App\Http\Controllers\SuperAdmin\InqueryController::class, 'edit_inquery'])->name('super.admin.edit.success');
       Route::post('super-admin/update-inquery/{id}', [App\Http\Controllers\SuperAdmin\InqueryController::class, 'update_inquery'])->name('super.admin.update.inquery');
       Route::get('super-admin/delete-inquery/{id}', [App\Http\Controllers\SuperAdmin\InqueryController::class, 'delete_inquery']);
       //stocks 
       Route::get('super-admin/all-stocks-list', [App\Http\Controllers\SuperAdmin\StudentController::class, 'all_stocks_list']);
       Route::get('super-admin/add-new-stock', [App\Http\Controllers\SuperAdmin\StudentController::class, 'add_new_stock']);
       //Route::post('super-admin/submit-stock', [App\Http\Controllers\SuperAdmin\StudentController::class, 'submit_stock'])->name('super.admin.submit.stock');
       //export students record
       Route::get('super-admin/export-student', [App\Http\Controllers\SuperAdmin\ExportStudentController::class, 'export_students']);
       //export students monthly fees record
       Route::get('super-admin/export-students-paid-fees', [App\Http\Controllers\SuperAdmin\ExportStudentController::class, 'export_students_paid_fees'])->name('super.admin.export.paid.fees');
       Route::get('super-admin/export-students-pending-fees', [App\Http\Controllers\SuperAdmin\ExportStudentController::class, 'export_students_pending_fees'])->name('super.admin.export.pending.fees');
    });

    //Admin Only  
    Route::group(['middleware' => 'Admin'], function() { 
        //Admin dashboard
        Route::get('admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard']);
        //profile
        Route::get('admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit_profile']);
        Route::post('admin/update-profile/{id}', [App\Http\Controllers\Admin\ProfileController::class, 'update_profile'])->name('admin.update.profile');
        Route::get('admin/change-password', [App\Http\Controllers\Admin\ProfileController::class, 'changed_password']);
        Route::post('admin/submit-change-password/{id}', [App\Http\Controllers\Admin\ProfileController::class, 'submit_changed_password'])->name('admin.changed.password');
        //employees 
        Route::get('admin/all-employees-list', [App\Http\Controllers\Admin\EmployeeController::class, 'all_employees_list']);
        Route::get('admin/get-employee-detail', [App\Http\Controllers\Admin\EmployeeController::class, 'single_employee_detail']);
        Route::get('admin/search-employees-list/{any}', [App\Http\Controllers\Admin\EmployeeController::class, 'search_employee_list'])->name('admin.search.employee.list');
        //Employee attendance  
        Route::post('admin/submit-employee-attendance', [App\Http\Controllers\Admin\EmployeeAttendanceController::class, 'employee_attendance'])->name('admin.submit.employee.attendance');
        Route::post('admin/update-employee-punch-out-attendance', [App\Http\Controllers\Admin\EmployeeAttendanceController::class, 'employee_punch_out_attendance'])->name('admin.update.employee.punch.out.attendance');
        Route::get('admin/all-employees-attendance-list', [App\Http\Controllers\Admin\EmployeeAttendanceController::class, 'all_employees_attendance_list']);
        Route::get('admin/search-employee-attendance', [App\Http\Controllers\Admin\EmployeeAttendanceController::class, 'search_employee_attendance_list'])->name('admin.search.employee.attendance');
        //employee assign accessories 
        Route::post('admin/submit-employee-assign-accessories', [App\Http\Controllers\Admin\EmployeeController::class, 'submit_employee_assign_accessories'])->name('admin.submit.assign.accessories.employee');
        Route::post('admin/submit-employee-damage-accessories', [App\Http\Controllers\Admin\EmployeeController::class, 'submit_employee_damage_accessories'])->name('admin.submit.damage.accessories.employee');
        //students 
        Route::get('admin/all-students-list', [App\Http\Controllers\Admin\StudentController::class, 'all_students']);
        Route::get('admin/add-new-student', [App\Http\Controllers\Admin\StudentController::class, 'add_student']);
        Route::post('admin/submit-student', [App\Http\Controllers\Admin\StudentController::class, 'submit_student'])->name('admin.submit.student');
        Route::get('admin/edit-student/{id}', [App\Http\Controllers\Admin\StudentController::class, 'edit_student']); 
        Route::post('admin/update-student/{id}', [App\Http\Controllers\Admin\StudentController::class, 'update_student'])->name('admin.update.student');
        Route::get('admin/trash-student', [App\Http\Controllers\Admin\StudentController::class, 'trash_student'])->name('admin.student.trash');
        Route::get('admin/delete-student', [App\Http\Controllers\Admin\StudentController::class, 'delete_student'])->name('admin.student.delete');
        Route::get('admin/all-students-trash-list', [App\Http\Controllers\Admin\StudentController::class, 'all_trash_students_list']);
        //student submit fees 
        Route::post('admin/submit-student-fees', [App\Http\Controllers\Admin\StudentController::class, 'submit_student_fees'])->name('admin.submit.student.fees');
        Route::post('admin/update-student-fees', [App\Http\Controllers\Admin\StudentController::class, 'update_student_feess'])->name('admin.update.student.fees');
        //student previous fees 
        Route::get('admin/add-student-previous-fees', [App\Http\Controllers\Admin\StudentController::class, 'add_previous_fees']);
        Route::post('admin/submit-student-previous-fees', [App\Http\Controllers\Admin\StudentController::class, 'submit_previous_fees'])->name('admin.student.submit.fees');
        //single student detail 
        Route::get('admin/get-student-detail', [App\Http\Controllers\Admin\StudentController::class, 'single_student_detail']);
        Route::get('admin/edit-student-fees/{id}', [App\Http\Controllers\Admin\StudentController::class, 'edit_student_fees']);
        Route::post('admin/update-student-fees/{id}', [App\Http\Controllers\Admin\StudentController::class, 'update_ssstudent_feess'])->name('admin.updddate.student.fees');
        Route::get('admin/delete-student-fees/{id}', [App\Http\Controllers\Admin\StudentController::class, 'delete_student_fees']);
        //student assign accessories 
        Route::post('admin/submit-student-assign-accessories', [App\Http\Controllers\Admin\StudentController::class, 'submit_student_assign_accessories'])->name('admin.submit.assign.accessories.student');
        Route::post('admin/submit-student-damage-accessories', [App\Http\Controllers\Admin\StudentController::class, 'submit_student_damage_accessories'])->name('admin.submit.damage.accessories.student');
        Route::get('admin/edit-student-assign-accessories/{id}', [App\Http\Controllers\Admin\StudentController::class, 'edit_student_assign_accessories']);
        Route::post('admin/update-student-assign-accessories/{id}', [App\Http\Controllers\Admin\StudentController::class, 'update_student_assign_accessories'])->name('admin.update.assign.accessories.student');
        Route::get('admin/delete-student-assign-accessories/{id}', [App\Http\Controllers\Admin\StudentController::class, 'delete_student_assign_accessories']);
        //Students search coure type list
        Route::get('admin/search-students-list/{any}', [App\Http\Controllers\Admin\StudentController::class, 'search_students_list'])->name('admin.search.student.list');
        //Student search fees status list 
        Route::get('admin/search-students-fees-list/{any}', [App\Http\Controllers\Admin\StudentController::class, 'search_students_fees_list'])->name('admin.search.student.fees.list');
        //inqueries deatils 
        //inqueries search acc status list
        Route::get('admin/search-inquery/{any}', [App\Http\Controllers\Admin\InqueryController::class, 'search_inquery_status_list'])->name('admin.search.inquery.status.list');
        Route::get('admin/search-inquery-course-type/{any}', [App\Http\Controllers\Admin\InqueryController::class, 'search_inquery_course_type_list'])->name('admin.search.inquery.course.list');
        Route::get('admin/add-new-inquery', [App\Http\Controllers\Admin\InqueryController::class, 'add_inquery']);
        Route::post('admin/submit-inquery', [App\Http\Controllers\Admin\InqueryController::class, 'submit_inquery'])->name('admin.submit.inquery');
        Route::get('admin/all-inqueries-list', [App\Http\Controllers\Admin\InqueryController::class, 'all_inqueries'])->name('admin.students.list');
        Route::get('admin/all-converted-inqueries-list', [App\Http\Controllers\Admin\InqueryController::class, 'all_converted_inqueries']);
        Route::get('admin/edit-inquery/{id}', [App\Http\Controllers\Admin\InqueryController::class, 'edit_inquery'])->name('admin.edit.success');
        Route::post('admin/update-inquery/{id}', [App\Http\Controllers\Admin\InqueryController::class, 'update_inquery'])->name('admin.update.inquery');
        Route::get('admin/delete-inquery/{id}', [App\Http\Controllers\Admin\InqueryController::class, 'delete_inquery']);
        //export inqueries
        Route::get('admin/export-inqueries', [App\Http\Controllers\Inquery\ExportInqueryController::class, 'export_inqueries']);        
        //stocks 
        Route::get('admin/all-stocks-list', [App\Http\Controllers\Admin\StudentController::class, 'all_stocks_list']);
        Route::get('admin/add-new-stock', [App\Http\Controllers\Admin\StudentController::class, 'add_new_stock']);
        // Route::post('admin/submit-stock', [App\Http\Controllers\Admin\StudentController::class, 'submit_stock'])->name('admin.submit.stock');
        //export students record
        Route::get('admin/export-student', [App\Http\Controllers\Admin\ExportStudentController::class, 'export_students']);
        //export students monthly fees record
        Route::get('admin/export-students-paid-fees', [App\Http\Controllers\Admin\ExportStudentController::class, 'export_students_paid_fees'])->name('admin.export.paid.fees');
        Route::get('admin/export-students-pending-fees', [App\Http\Controllers\Admin\ExportStudentController::class, 'export_students_pending_fees'])->name('admin.export.pending.fees');
    });

    //Student Only 
    Route::group(['middleware' => 'Student'], function() {  
        //Student dashboard
        Route::get('student/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'student_detail']); 
        //Student attendance 
        Route::get('student/student-attendance-list', [App\Http\Controllers\Student\AttendanceController::class, 'student_attendance_list']);
        Route::get('student/search-attendance', [App\Http\Controllers\Student\AttendanceController::class, 'search_student_attendance_list'])->name('student.search.attendance');
        Route::post('student/submit-punch-in-attendance', [App\Http\Controllers\Student\AttendanceController::class, 'submit_student_punch_attendance'])->name('student.submit.puch.in.attendance');
        Route::post('student/update-punch-out-attendance', [App\Http\Controllers\Student\AttendanceController::class, 'update_student_punch_out_attendance'])->name('student.update.puch.out.attendance');
        //profile
        Route::get('student/profile', [App\Http\Controllers\Student\ProfileController::class, 'edit_profile']);
        Route::post('student/update-profile/{id}', [App\Http\Controllers\Student\ProfileController::class, 'update_profile'])->name('student.update.profile');
        Route::get('student/change-password', [App\Http\Controllers\Student\ProfileController::class, 'changed_password']);
        Route::post('student/submit-change-password/{id}', [App\Http\Controllers\Student\ProfileController::class, 'submit_changed_password'])->name('student.changed.password');  
        
    });

    //Employee Only 
    Route::group(['middleware' => 'Employee'], function() {  
        //Employee dashboard
        Route::get('employee/dashboard', [App\Http\Controllers\Employee\DashboardController::class, 'employee_detail']); 
         //employee attendance 
         Route::get('employee/employee-attendance-list', [App\Http\Controllers\Employee\AttendanceController::class, 'employee_attendance_list']);
         Route::get('employee/search-attendance', [App\Http\Controllers\Employee\AttendanceController::class, 'search_employee_attendance_list'])->name('employee.search.attendance');
         Route::post('employee/submit-punch-in-attendance', [App\Http\Controllers\Employee\AttendanceController::class, 'submit_employee_punch_in_attendance'])->name('employee.submit.puch.in.attendance');
         Route::post('employee/update-punch-out-attendance', [App\Http\Controllers\Employee\AttendanceController::class, 'update_employee_punch_out_attendance'])->name('employee.update.puch.out.attendance');
        //profile
        Route::get('employee/profile', [App\Http\Controllers\Employee\ProfileController::class, 'edit_profile']);
        Route::post('employee/update-profile/{id}', [App\Http\Controllers\Employee\ProfileController::class, 'update_profile'])->name('employee.update.profile');
        Route::get('employee/change-password', [App\Http\Controllers\Employee\ProfileController::class, 'changed_password']);
        Route::post('employee/submit-change-password/{id}', [App\Http\Controllers\Employee\ProfileController::class, 'submit_changed_password'])->name('employee.changed.password');                    
    });

    //Subscriber Only 
    Route::group(['middleware' => 'Subscriber'], function() { 
        //Subscriber dashboard
         Route::get('subscriber/dashboard', [App\Http\Controllers\Subscriber\DashboardController::class, 'dashboard']);
    });
});

    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

