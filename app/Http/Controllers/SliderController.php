<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;


class SliderController extends Controller
{
    public function addslider(){
        return view('admin.addslider');
    }
    public function sliders(){
        return view('admin.sliders');
    }
    public function saveSlider(Request $request){
        $this->validate($request, [ 'description1' => 'required',
                                    'description2' => 'required',
                                    'slider_image' => 'image|nullable|max:1999|required' ]);

        // !: get file name with exts
        $fileNameWithExt = $request->file('slider_image')->getClientOriginalName();
        // 2: get just file name
        $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        //3: get just file extension
        $extension = $request->file('slider_image')->getClientOriginalExtension();
        //4: file name to store
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;

        // upload image
        $path = $request->file('slider_image')->storeAs('public/slider_images', $fileNameToStore);

        $slider = new Slider();
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        $slider->slider_image = $fileNameToStore;
        $slider->status = 1;

        $slider->save();

        return back()->with('status', 'The Slider has been successfully saved !!');
    }

}
