<?php

namespace App\Http\Controllers\admin;
use App\Models\Testimonials;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonial = Testimonials::orderBy('id','desc')->get();
        return view('admin.testimonial.index',compact('testimonial'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $testimonial = Testimonials::all();
        return view('admin.testimonial.create' ,compact('testimonial'));
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'review' =>  'required' ,
            
        ], [
            'name.required' => 'Name is required!',
            'review.required'  => 'Review is required!',
           
        ]);
        $filename ='';
        if($request->file('image'))
        {
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
            $image = Image::make($request->file('image')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/testimonial/'). $file_name);
            $filename= $file_name;  
        }
        
        $testimonial = Testimonials::create([
            'name' => $request['name'],
            'review' => $request['review'],
            'image' => $filename,
            
        ]);
        Toastr::success('Testimonial added successfully!');
        return redirect()->route('testimonials.list');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testimonial = Testimonials::find($id);
        $html_response = view('admin.testimonial.partials.testimonial_view_modal', compact('testimonial'))->render();

        return response()->json([
            'success' => true,
            'html_response' => $html_response
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testimonial = Testimonials::find($id);
        return view('admin.testimonial.edit',compact('testimonial'));
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
        $request->validate([
            'name' => 'required',
            'review' =>  'required' ,
        ], [
            'name.required' => 'Name is required!',
            'review.required'  => 'Review is required!',
           
        ]);

        $testimonial = Testimonials::find($id);
        $testimonial->name = $request['name'];
        $testimonial->review = $request['review'];
       
        if($request->file('image'))
        {
            unlink(public_path('admin/assets/img/testimonial/'). $testimonial->image);
            $file_name = time().'_'.trim($request->file('image')->getClientOriginalName());
            
             $image = Image::make($request->file('image')->getRealPath());
            $image->resize(300,200);
            $image->save(public_path('admin/assets/img/testimonial/'). $file_name);
            $filename= $file_name;  
            $testimonial->image = $filename;
        }
      
        $testimonial->save();

        Toastr::success('Testimonial updated successfully!');
        return redirect()->route('testimonials.list');
    }

    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimonial = Testimonials::find($id);

        $testimonial->delete();

        Toastr::success('Testimonial deleted successfully!');
        return back();
    }
}

