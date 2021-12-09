<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Unit;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function generate_rented_apartment_list()
    {
        $unit_list = Unit::where('unit_status_code', 1)->get();

        return (new FastExcel($unit_list))->download('rented_apartment_list.csv', function ($unit_list) {
            return [
                'id' => $unit_list->id,
                'Apartment Number' => $unit_list->unit_number,
                'Apartment Type' => $unit_list->apartment_type,
                'No of bedrooms' => $unit_list->no_of_bed_rooms,
                'Apartment Area' => $unit_list->unit_area,
                'Status' => $unit_list->unit_status->unit_status_name,
            ];
        });
    }
    
    public function generate_vacant_apartment_list()
    {
        $unit_list = Unit::where('unit_status_code', 2)->get();

        return (new FastExcel($unit_list))->download('vacant_apartment_list.csv', function ($unit_list) {
            return [
                'id' => $unit_list->id,
                'Apartment Number' => $unit_list->unit_number,
                'Apartment Type' => $unit_list->apartment_type,
                'No of bedrooms' => $unit_list->no_of_bed_rooms,
                'Apartment Area' => $unit_list->unit_area,
                'Status' => $unit_list->unit_status->unit_status_name,
            ];
        });
    }

    public function generate_full_apartment_list()
    {
        $unit_list = Unit::all();

        return (new FastExcel($unit_list))->download('vacant_apartment_list.csv', function ($unit_list) {
            return [
                'id' => $unit_list->id,
                'Apartment Number' => $unit_list->unit_number,
                'Apartment Type' => $unit_list->apartment_type,
                'No of bedrooms' => $unit_list->no_of_bed_rooms,
                'Apartment Area' => $unit_list->unit_area,
                'Status' => $unit_list->unit_status->unit_status_name,
            ];
        });
    }

    public function generate_active_tenant_list()
    {
        $tenant_list = Tenant::where('is_passed','!=', 1)->get();

        return (new FastExcel($tenant_list))->download('active_tenant_list.csv', function ($tenant) {
            return [
                'id' => $tenant->id,
                'First Name' => $tenant->tenant_first_name,
                'Last Name' => $tenant->tenant_last_name,
                'Email Address' => $tenant->tenant_email_address,
                'Emergency Email Address' => $tenant->emergancy_email,
                'Mobile Phone Number' => $tenant->tenant_mobile_phone,
                'Emergency Phone Number' => $tenant->emergancy_contact_number,
                'Date Of Birth' => Carbon::parse($tenant->tenant_date_of_birth)->format('Y-m-d'),
                'Present Address' => $tenant->tenant_present_address,
                'Permanant Address' => $tenant->tenant_permanent_address,
                'Home Country Address' => $tenant->home_country_address,
                'tenant Image' => url('/').'/public/admin/assets/img/staff/'.$tenant->tenant_image,
                'Contract Start Date' => Carbon::parse($tenant->lease_period_start_datetime)->format('Y-m-d'),
                'Contract End Date' => Carbon::parse($tenant->lease_period_end_datetime)->format('Y-m-d'),
                'Apartment Number' => $tenant->unit->unit_number,
                'Apartment Rent' => $tenant->tenant_rent. 'BHD',
                'Facilities list' => implode(',', $tenant->tenant_facilities_list),
                'Passport Copy' => url('/').'/public/admin/assets/img/documents/'.$tenant->tenant_passport_copy,
                'Passport Copy' => url('/').'/public/admin/assets/img/documents/'.$tenant->tenant_passport_copy,
                'Cpr Copy' => url('/').'/public/admin/assets/img/documents/'.$tenant->tenant_cpr_copy,
                'Contract Copy' => url('/').'/public/admin/assets/img/documents/'.$tenant->tenant_contract_copy,


            ];
        });
    }

    public function generate_passed_tenant_list()
    {
        $tenant_list = Tenant::where('is_passed', 1)->get();

        return (new FastExcel($tenant_list))->download('passed_tenant_list.csv', function ($tenant) {
            return [
                'id' => $tenant->id,
                'First Name' => $tenant->tenant_first_name,
                'Last Name' => $tenant->tenant_last_name,
                'Email Address' => $tenant->tenant_email_address,
                'Emergency Email Address' => $tenant->emergancy_email,
                'Mobile Phone Number' => $tenant->tenant_mobile_phone,
                'Emergency Phone Number' => $tenant->emergancy_contact_number,
                'Date Of Birth' => Carbon::parse($tenant->tenant_date_of_birth)->format('Y-m-d'),
                'Present Address' => $tenant->tenant_present_address,
                'Permanant Address' => $tenant->tenant_permanent_address,
                'Home Country Address' => $tenant->home_country_address,
                'tenant Image' => url('/').'/public/admin/assets/img/staff/'.$tenant->tenant_image,
                'Contract Start Date' => Carbon::parse($tenant->lease_period_start_datetime)->format('Y-m-d'),
                'Contract End Date' => Carbon::parse($tenant->lease_period_end_datetime)->format('Y-m-d'),
                'Apartment Number' => $tenant->unit->unit_number,
                'Apartment Rent' => $tenant->tenant_rent. 'BHD',
                'Facilities list' => implode(',', $tenant->tenant_facilities_list),
                'Passport Copy' => url('/').'/public/admin/assets/img/documents/'.$tenant->tenant_passport_copy,
                'Passport Copy' => url('/').'/public/admin/assets/img/documents/'.$tenant->tenant_passport_copy,
                'Cpr Copy' => url('/').'/public/admin/assets/img/documents/'.$tenant->tenant_cpr_copy,
                'Contract Copy' => url('/').'/public/admin/assets/img/documents/'.$tenant->tenant_contract_copy,


            ];
        });
    }
}
