<?php

namespace App\Http\Controllers\admin;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       // print_r($_GET); exit;
        $invoice = Invoice::where('tenant_id',$request->id)->where('month',$request->month)->first();
        return view('admin.invoice.create' ,compact('invoice'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save_invoice_info(Request $request)
    {
        $request->validate([
            'renter_name' => 'required',
            'apartment_no' => 'required',
            'invoice_no' => 'required',
            'rent' => 'required',
            'ewa_bill' => 'required',
            'utility_bill' => 'required',
            'date_of_issue' => 'required',
            'paid_date' => 'required',
            'payment_method' => 'required|string',
            'note' => 'required',
            'rent_paid_status_code' => 'required',
            'grand_total' => 'required',
        ]);
        $invoice = new Invoice();
        
        $invoice->renter_name = $request['renter_name'];
        $invoice->apartment_no = $request['apartment_no'];
        $invoice->invoice_no = $request['invoice_no'];
        $invoice->rent = $request['rent'];
        $invoice->ewa_bill = $request['ewa_bill'];
        $invoice->utility_bill = $request['utility_bill'];
        $invoice->date_of_issue = $request['date_of_issue'];
        $invoice->paid_date = $request['paid_date'];
        $invoice->payment_method = $request['payment_method'];
        $invoice->note = $request['note'];
        $invoice->rent_paid_status_code = $request['rent_paid_status_code'];
        $invoice->grand_total = $request['grand_total'];
        if($invoice->save()){
        Toastr::success('Invoice created successfully!');
        return redirect()->route('rent.list');
        }
    }
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
