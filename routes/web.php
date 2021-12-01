<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\admin\RentController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\RoomController;
use App\Http\Controllers\admin\TaskController;
use App\Http\Controllers\admin\UnitController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\admin\FloorController;
use App\Http\Controllers\admin\OwnerController;
use App\Http\Controllers\admin\StaffController;
use App\Http\Controllers\admin\ModuleController;
use App\Http\Controllers\admin\NoticeController;

use App\Http\Controllers\admin\TenantController;

use App\Http\Controllers\admin\RequestController;

use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\LeavesController;
use App\Http\Controllers\admin\VisitorController;
use App\Http\Controllers\admin\EmployeeController;
use App\Http\Controllers\admin\HelpdeskController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\ComplaintsController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\RentreportController;
use App\Http\Controllers\admin\ReservationController;
use App\Http\Controllers\admin\TestimonialController;
use App\Http\Controllers\admin\UtilitybillController;
use App\Http\Controllers\admin\VisitorsreportController;
use App\Http\Controllers\admin\ComplaintreportController;
use App\Http\Controllers\admin\MaintenanceCostController;
use App\Http\Controllers\admin\MaintenanceRequestController;
use App\Http\Controllers\admin\SecuritydepositController;
use App\Http\Controllers\admin\UnitstatusreportController;
use App\Models\MaintenanceRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::view('/', 'index');
Route::view('/terms', 'termsofservice');
Route::view('/jobs', 'job');
Route::get('/testimonials',  [PagesController::class, 'testimonials_info']);
Route::view('/contact', 'contact');
Route::post('/save_job_info', [PagesController::class, 'save_job_info'])->name('save_job_info');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');


Route::group(['middleware' => ['auth:web']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/fetch_floors/{floor_type_code}', [PagesController::class, 'fetch_floors'])->name('floor_type.fetch_floors');
    Route::get('/fetch_all_units_and_floors_list/{floor_type_code}', [PagesController::class, 'fetch_all_units_and_floors_list'])->name('floor_type.fetch_all_units_and_floors_list');
    Route::get('/fetch_units/{floor_id}', [PagesController::class, 'fetch_units'])->name('floor.fetch_units');
    Route::get('/fetch_all_units/{floor_id}', [PagesController::class, 'fetch_all_units'])->name('floor_type.fetch_all_units');


    //Floor routes
    Route::group(['prefix' => 'floors', 'as' => 'floors.'], function () {
        Route::get('/floor_list', [FloorController::class, 'index'])->name('list');
        Route::post('/floor/store', [FloorController::class, 'store'])->name('store');
        Route::get('/floor/show/{id}', [FloorController::class, 'show'])->name('show');
        Route::delete('/floor/delete/{id}', [FloorController::class, 'destroy'])->name('delete');
        Route::get('/floor/edit/{id}', [FloorController::class, 'edit'])->name('edit');
        Route::post('/floor/update/{id}', [FloorController::class, 'update'])->name('update');
       
    });

    //Service Contract list
    Route::group(['prefix' => 'service_contract', 'as' => 'service_contract.'], function () {
        Route::get('/list', [ServiceController::class, 'index'])->name('list');
        Route::get('/create', [ServiceController::class, 'create'])->name('create');
        Route::post('/service_contract/store', [ServiceController::class, 'store'])->name('store');
        Route::get('/service_contract/show/{id}', [ServiceController::class, 'show'])->name('show');
        Route::delete('/service_contract/delete/{id}', [ServiceController::class, 'destroy'])->name('delete');
        Route::get('/service_contract/edit/{id}', [ServiceController::class, 'edit'])->name('edit');
        Route::post('/service_contract/update/{id}', [ServiceController::class, 'update'])->name('update');
       
    });

    // Units routes
    Route::group(['prefix' => 'units', 'as' => 'units.'], function () {
        Route::get('/unit_list', [UnitController::class, 'index'])->name('list');
       

        Route::any('/apartment_by_floor', [UnitController::class, 'apartment_by_floor'])->name('apartment_by_floor.list');
        Route::get('/apartment_by_floor/show/{id}', [UnitController::class, 'show'])->name('apartment_by_floor.show');

        
        Route::get('/full_apartment', [UnitController::class, 'index'])->name('full_apartment.list');
        Route::get('/full_apartment/show/{id}', [UnitController::class, 'show'])->name('full_apartment.show');

        Route::any('/apartment_by_type', [UnitController::class, 'apartment_by_type'])->name('apartment_by_type.list');
        Route::get('/apartment_by_type/show/{id}', [UnitController::class, 'show'])->name('apartment_by_type.show');


        Route::any('/apartment_by_color', [UnitController::class, 'apartment_by_color'])->name('apartment_by_color.list');
        Route::get('/apartment_by_color/show/{id}', [UnitController::class, 'show'])->name('apartment_by_color.show');
         
        Route::any('/rented_apartment', [UnitController::class, 'rented_apartment'])->name('rented_apartment.list');
        Route::get('/rented_apartment/show/{id}', [UnitController::class, 'show'])->name('rented_apartment.show');

        Route::any('/leave', [UnitController::class, 'leave'])->name('leave.list');
        Route::get('/leave/show/{id}', [UnitController::class, 'show'])->name('leave.show');


        Route::get('/fetch_floors/{id}', [UnitController::class, 'fetch_floors'])->name('fetch_floors');
        Route::get('/create', [UnitController::class, 'create'])->name('create');
        Route::post('/unit/store', [UnitController::class, 'store'])->name('store');
        Route::get('/unit/show/{id}', [UnitController::class, 'show'])->name('show');
        Route::any('/search_by_apartment', [UnitController::class, 'search_by_appartment'])->name('search_by_apartment_list');
        Route::get('/search_by_apartment/show/{id}', [UnitController::class, 'show'])->name('search_by_apartment.show');
        Route::get('/unit/edit/{id}', [UnitController::class, 'edit'])->name('edit');
        Route::post('/unit/update/{id}', [UnitController::class, 'update'])->name('update');
        Route::delete('/unit/delete/{id}', [UnitController::class, 'destroy'])->name('delete');
        Route::post('/unit/search_filter', [UnitController::class, 'search_filter'])->name('search_filter');

    });
   

    // Roles routes
    Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
        Route::get('/list', [RoleController::class, 'index'])->name('list');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [RoleController::class, 'destroy'])->name('delete');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
        Route::any('assign-permission/{id}', [ RoleController::class, 'assignPermission'])->name('assignPermission');

        
    });

    // Modules routes
    Route::group(['prefix' => 'module', 'as' => 'module.'], function () {
        Route::get('/list', [ModuleController::class, 'index'])->name('list');
        Route::get('/create', [ModuleController::class, 'create'])->name('create');
        Route::post('/store', [ModuleController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [ModuleController::class, 'destroy'])->name('delete');
        Route::get('/edit/{id}', [ModuleController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [ModuleController::class, 'update'])->name('update');
    });

    // Permissions routes
    Route::group(['prefix' => 'permission', 'as' => 'permission.'], function () {
        Route::get('/list', [PermissionController::class, 'index'])->name('list');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/store', [PermissionController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [PermissionController::class, 'destroy'])->name('delete');
        Route::get('/edit/{id}', [PermissionController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [PermissionController::class, 'update'])->name('update');
        
    });

    // Staff routes
    Route::group(['prefix' => 'staff', 'as' => 'staff.'], function () {
        Route::get('/list', [StaffController::class, 'index'])->name('list');
        Route::get('/create', [StaffController::class, 'create'])->name('create');
        Route::get('/show/{id}', [StaffController::class, 'show'])->name('show');
        Route::post('/store', [StaffController::class, 'store'])->name('store');
        Route::delete('/delete/{id}', [StaffController::class, 'destroy'])->name('delete');
        Route::get('/edit/{id}', [StaffController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [StaffController::class, 'update'])->name('update');
        Route::get('/profile', [StaffController::class, 'profile'])->name('profile');
        Route::post('/profile/change_image/{id}', [StaffController::class, 'change_profile_image'])->name('change_profile_image');
        Route::post('/profile/edit-profile/{id}', [StaffController::class, 'edit_profile'])->name('edit_profile');
        Route::post('/profile/change_password/{id}', [StaffController::class, 'change_password'])->name('change_password');
    });
 
    
   
    // Tenant routes
    Route::group(['prefix' => 'tenants', 'as' => 'tenants.'], function () {
        Route::get('/tenant_list', [TenantController::class, 'index'])->name('list');
        Route::get('/floors/{id}', [TenantController::class, 'fetch_floors'])->name('fetch_floors');
        Route::get('/units/{id}', [TenantController::class, 'fetch_units'])->name('fetch_units');
        Route::get('/tenant_list', [TenantController::class, 'index'])->name('list');
        Route::get('/tenant/create', [TenantController::class, 'create'])->name('create');
        Route::post('/tena nt/store', [TenantController::class, 'store'])->name('store');
        Route::get('/tenant/show/{id}', [TenantController::class, 'show'])->name('show');
        Route::get('/tenant/edit/{id}', [TenantController::class, 'edit'])->name('edit');
        Route::post('/tenant/update/{id}', [TenantController::class, 'update'])->name('update');
        Route::delete('/tenant/delete/{id}', [TenantController::class, 'destroy'])->name('delete');
    });

     // Employee routes
     Route::group(['prefix' => 'employee', 'as' => 'employee.'], function () {
         Route::get('/employee_list', [EmployeeController::class, 'index'])->name('list');
        Route::get('/employee/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/employee/store', [EmployeeController::class, 'store'])->name('store');
        Route::get('/employee/show/{id}', [EmployeeController::class, 'show'])->name('show');
        Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('edit');
        Route::post('/employee/update/{id}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/employee/delete/{id}', [EmployeeController::class, 'destroy'])->name('delete');
     });

    // Rent Collection routes
    Route::group(['prefix' => 'rent', 'as' => 'rent.'], function () {
        Route::get('/rent_list', [RentController::class, 'index'])->name('list');
        Route::get('/rent/create', [RentController::class, 'create'])->name('create');
        Route::post('/rent/store', [RentController::class, 'store'])->name('store');
        Route::get('/rent/show/{id}', [RentController::class, 'show'])->name('show');
        Route::get('/rent/edit/{id}', [RentController::class, 'edit'])->name('edit');
        Route::post('/rent/update/{id}', [RentController::class, 'update'])->name('update');
        Route::delete('/rent/delete/{id}', [RentController::class, 'destroy'])->name('delete');
    });

    // Utility bill routes
    Route::group(['prefix' => 'utility_bill', 'as' => 'utility_bill.'], function () {
        Route::get('/utilitybill_list', [UtilitybillController::class, 'index'])->name('list');
        Route::get('/utility_bill/create', [UtilityBillController::class, 'create'])->name('create');
        Route::post('/utility_bill/store', [UtilityBillController::class, 'store'])->name('store');
        Route::get('/utility_bill/show/{id}', [UtilityBillController::class, 'show'])->name('show');
        Route::get('/utility_bill/edit/{id}', [UtilityBillController::class, 'edit'])->name('edit');
        Route::post('/utility_bill/update/{id}', [UtilityBillController::class, 'update'])->name('update');
        Route::delete('/utility_bill/delete/{id}', [UtilityBillController::class, 'destroy'])->name('delete');
    });
    //Maintenance Cost routes
    Route::group(['prefix' => 'maintenancecost', 'as' => 'maintenancecosts.'], function () {
    Route::get('/maintenancecost_list', [MaintenanceCostController::class, 'index'])->name('list');
    Route::get('/maintenancecost/create', [MaintenanceCostController::class, 'create'])->name('create');
    Route::post('/maintenancecost/store', [MaintenanceCostController::class, 'store'])->name('store');
    Route::get('/maintenancecost/edit/{id}', [MaintenanceCostController::class, 'edit'])->name('edit');
    Route::post('/maintenancecost/update/{id}', [MaintenanceCostController::class, 'update'])->name('update');
    Route::delete('/maintenancecost/delete/{id}', [MaintenanceCostController::class, 'destroy'])->name('delete');
    Route::get('/maintenancecost/show/{id}', [MaintenanceCostController::class, 'show'])->name('show');
    });
    //Security Deposit routes
    Route::group(['prefix' => 'securitydeposit', 'as' => 'securitydeposit.'], function () {
    Route::get('/securitydeposit_list', [SecuritydepositController::class, 'index'])->name('list');
    Route::delete('/securitydeposit/delete/{id}', [SecuritydepositController::class, 'destroy'])->name('delete');
    Route::get('/securitydeposit/show/{id}', [SecuritydepositController::class, 'show'])->name('show');
    });
    //Complaints routes
    Route::group(['prefix' => 'complains', 'as' => 'complains.'], function () {
        Route::get('/complaints/complaints_list', [ComplaintsController::class, 'index'])->name('list');
        Route::get('/complaints/create', [ComplaintsController::class, 'create'])->name('create');
        Route::post('/complaints/store', [ComplaintsController::class, 'store'])->name('store');
        Route::get('/complaints/edit/{id}', [ComplaintsController::class, 'edit'])->name('edit');
        Route::post('/complaints/update/{id}', [ComplaintsController::class, 'update'])->name('update');
        Route::delete('/complaints/delete/{id}', [ComplaintsController::class, 'destroy'])->name('delete');
        Route::get('/complaints/show/{id}', [ComplaintsController::class, 'show'])->name('show');
        Route::post('/assign_request/', [ComplaintsController::class, 'assign_request'])->name('assign_request');
        Route::post('/add_solution/', [ComplaintsController::class, 'add_solution'])->name('add_solution');
    });
    //Complaints routes
    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function () {
        Route::get('task/list', [TaskController::class, 'index'])->name('list');
        Route::get('/task/create', [TaskController::class, 'create'])->name('create');
        Route::post('/task/store', [TaskController::class, 'store'])->name('store');
        Route::get('/task/edit/{id}', [TaskController::class, 'edit'])->name('edit');
        Route::post('/task/update/{id}', [TaskController::class, 'update'])->name('update');
        Route::delete('/task/delete/{id}', [TaskController::class, 'destroy'])->name('delete');
        Route::get('/task/show/{id}', [TaskController::class, 'show'])->name('show');
        Route::post('/change_task_status', [TaskController::class, 'change_task_status'])->name('change_task_status');
        Route::get('/closed/{id}', [TaskController::class, 'task_closed'])->name('closed');
        Route::get('/cancel/{id}', [TaskController::class, 'task_cancelled'])->name('cancelled');
        Route::post('/task/resubmit', [TaskController::class, 'resubmit_task'])->name('resubmit');
        Route::get('/completed_task/list', [TaskController::class, 'complete_task_list'])->name('completed_task.list');
        Route::get('/locations/{id}', [TaskController::class, 'get_task_location'])->name('get_task_location');
        Route::post('/assign_task', [TaskController::class, 'assign_task'])->name('assign_task');
        Route::post('/search', [TaskController::class, 'search_tasks_by_status'])->name('search_tasks_by_status');
        Route::post('/assign_task_for_maintenance', [TaskController::class, 'assign_task_for_maintenance'])->name('assign_task_for_maintenance');

    });

    //Request Routes
    Route::group(['prefix' => 'request', 'as' => 'request.'], function () {
        Route::get('/request/list', [RequestController::class, 'index'])->name('list');
        Route::get('/request/create', [RequestController::class, 'create'])->name('create');
        Route::post('/request/store', [MaintenanceRequestController::class, 'store'])->name('store');
        Route::get('/request/edit/{id}', [RequestController::class, 'edit'])->name('edit');
        Route::post('/request/update/{id}', [RequestController::class, 'update'])->name('update');
        Route::delete('/request/delete/{id}', [RequestController::class, 'destroy'])->name('delete');
        Route::get('/request/show/{id}', [MaintenanceRequestController::class, 'show'])->name('show');
        Route::get('/request/under_review/{id}', [MaintenanceRequestController::class, 'maintenance_request_under_review'])->name('under_review');
        Route::post('/request/action/{id}', [RequestController::class, 'request_action']);
    });
     //Visitors routes
       Route::group(['prefix' => 'visitor', 'as' => 'visitor.'], function () {
        Route::get('/visitor_list', [VisitorController::class, 'index'])->name('list');
        Route::get('/visitor/create', [VisitorController::class, 'create'])->name('create');
        Route::post('/visitor/store', [VisitorController::class, 'store'])->name('store');
        Route::get('/visitor/edit/{id}', [VisitorController::class, 'edit'])->name('edit');
        Route::post('/visitor/update/{id}', [VisitorController::class, 'update'])->name('update');
        Route::delete('/visitor/delete/{id}', [VisitorController::class, 'destroy'])->name('delete');
        Route::get('/visitor/show/{id}', [VisitorController::class, 'show'])->name('show');
});

     //Reservation details routes
    Route::group(['prefix' => 'reservation', 'as' => 'reservation.'], function () {
    Route::get('/reservation_list', [ReservationController::class, 'index'])->name('list');
    Route::get('/reservation/create', [ReservationController::class, 'create'])->name('create');
    Route::post('/reservation/store', [ReservationController::class, 'store'])->name('store');
    Route::get('/reservation/edit/{id}', [ReservationController::class, 'edit'])->name('edit');
    Route::post('/reservation/update/{id}', [ReservationController::class, 'update'])->name('update');
    Route::delete('/reservation/delete/{id}', [ReservationController::class, 'destroy'])->name('delete');
    Route::get('/reservation/show/{id}', [ReservationController::class, 'show'])->name('show');
});

    //Add Room routes
    Route::group(['prefix' => 'room', 'as' => 'room.'], function () {
    Route::get('/room_list', [RoomController::class, 'index'])->name('list');
    Route::get('/room/create', [RoomController::class, 'create'])->name('create');
    Route::post('/room/store', [RoomController::class, 'store'])->name('store');
    Route::get('/room/edit/{id}', [RoomController::class, 'edit'])->name('edit');
    Route::post('/room/update/{id}', [RoomController::class, 'update'])->name('update');
    Route::delete('/room/delete/{id}', [RoomController::class, 'destroy'])->name('delete');
    Route::get('/room/show/{id}', [RoomController::class, 'show'])->name('show');
});
     //notice routes
     Route::group(['prefix' => 'notice', 'as' => 'notice.'], function () {
     Route::get('/notice_list', [NoticeController::class, 'index'])->name('list');
     Route::get('/notice/create', [NoticeController::class, 'create'])->name('create');
     Route::post('/notice/store', [NoticeController::class, 'store'])->name('store');
     Route::get('/notice/edit/{id}', [NoticeController::class, 'edit'])->name('edit');
     Route::post('/notice/update/{id}', [NoticeController::class, 'update'])->name('update');
     Route::delete('/notice/delete/{id}', [NoticeController::class, 'destroy'])->name('delete');
     Route::get('/notice/show/{id}', [NoticeController::class, 'show'])->name('show');
});
   //leave routes
   Route::group(['prefix' => 'leave', 'as' => 'leave.'], function () {
    Route::get('/leave_list', [LeavesController::class, 'index'])->name('list');
    Route::get('/leave/create', [LeavesController::class, 'create'])->name('create');
    Route::post('/leave/store', [LeavesController::class, 'store'])->name('store');
    Route::get('/leave/edit/{id}', [LeavesController::class, 'edit'])->name('edit');
    Route::post('/leave/update/{id}', [LeavesController::class, 'update'])->name('update');
    Route::delete('/leave/delete/{id}', [LeavesController::class, 'destroy'])->name('delete');
    Route::get('/leave/show/{id}', [LeavesController::class, 'show'])->name('show');
    Route::post('/leave/get_approved_leave_info', [LeavesController::class, 'get_approved_leave_info'])->name('get_approved_leave_info');
    Route::post('/leave/get_disapproved_leave_info', [LeavesController::class, 'get_disapproved_leave_info'])->name('get_disapproved_leave_info');


   });
   //Testimonials routes
   Route::group(['prefix' => 'testimonials', 'as' => 'testimonials.'], function () {
    Route::get('/testimonials_list', [TestimonialController::class, 'index'])->name('list');
    Route::get('/testimonials/create', [TestimonialController::class, 'create'])->name('create');
    Route::post('/testimonials/store', [TestimonialController::class, 'store'])->name('store');
    Route::get('/testimonials/edit/{id}', [TestimonialController::class, 'edit'])->name('edit');
    Route::post('/testimonials/update/{id}', [TestimonialController::class, 'update'])->name('update');
    Route::delete('/testimonials/delete/{id}', [TestimonialController::class, 'destroy'])->name('delete');
    Route::get('/testimonials/show/{id}', [TestimonialController::class, 'show'])->name('show');

   });

   //Approve routes
   Route::group(['prefix' => 'approveleave', 'as' => 'approveleave.'], function () {
    Route::get('/approveleave_list', [LeavesController::class, 'index'])->name('list');
    Route::post('/save_leave_status', [LeavesController::class, 'save_leave_status'])->name('save_leave_status');
});


    Route::get('/helpdesk_list', [HelpdeskController::class, 'index'])->name('helpdesk');
    Route::get('/rentreport_list', [RentreportController::class, 'index'])->name('rentreport');
    Route::get('/visitorsreport_list', [VisitorsreportController::class, 'index'])->name('visitorsreport');
    Route::get('/complaintreport_list', [ComplaintreportController::class, 'index'])->name('complaintreport');
    Route::get('/unitstatusreport_list', [UnitstatusreportController::class, 'index'])->name('unitstatusreport');
});

