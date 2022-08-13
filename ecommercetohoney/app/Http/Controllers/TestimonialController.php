<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestimonialStoreRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
        //
        $testimonials = Testimonial::latest('id')
        ->select(['id', 'client_name','client_name_slug', 'client_designation', 'client_message', 'client_image', 'updated_at'])->paginate(10);

        return view('backend.pages.testimonial.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.testimonial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestimonialStoreRequest $request)
    {
        //

         $testimonial=Testimonial::create([
            'client_name' => $request->client_name,
            'client_name_slug' => Str::slug($request->client_name),
            'client_designation' => $request->client_designation,
            'client_message' => $request->client_message,
        ]);

         $this->image_upload($request, $testimonial->id);

        // Toastr::success('Data Stored Successfully!!');
        return redirect()->route('testimonial.index');
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
    public function edit($slug)
    {
        //
        $testimonial = Testimonial::where('client_name_slug', $slug)->first();
        return view('backend.pages.testimonial.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
        $testimonial = Testimonial::where('client_name_slug', $slug)->first();
        $testimonial->update([
            'client_name' => $request->client_name,
            'client_name_slug' => Str::slug($request->client_name),
            'client_designation' => $request->client_designation,
            'client_message' => $request->client_message,
            'is_active' => $request->filled('is_active')
        ]);


        return redirect()->route('testimonial.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //
        $testimonial = Testimonial::where('client_name_slug', $slug)->first();
        $testimonial->delete();


        return redirect()->route('testimonial.index');
    }
    public function image_upload($request, $item_id)
    {

        $testimonial = Testimonial::findorFail($item_id);
        //dd($request->all(), $testimonial, $request->hasFile('client_image'));
        if ($request->hasFile('client_image')) {
            if ($testimonial->client_image != 'default-client.jpg') {
                //delete old photo
                $photo_location = 'public/uploads/testimonials/';
                $old_photo_location = $photo_location . $testimonial->client_image;
                unlink(base_path($old_photo_location));
            }
            $photo_location = 'public/uploads/testimonials/';
            // dd($photo_location);
            $uploaded_photo = $request->file('client_image');

            $new_photo_name = $testimonial->id . '.' . $uploaded_photo->getClientOriginalExtension();
            // dd($new_photo_name);
            $new_photo_location = $photo_location . $new_photo_name;

             Image::make($uploaded_photo)->resize(105,105)->save(base_path($new_photo_location), 40);

            $testimonial->update([
                'client_image' => $new_photo_name,
            ]);
        }
    }
}
