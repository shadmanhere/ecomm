<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Slider;


class SliderController extends Controller
{
    public function addslider(){
        return view('admin.addslider');
    }
    public function sliders(){
        $sliders = Slider::All();
        return view('admin.sliders')->with('sliders',$sliders);
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

    public function editSlider($id){
        $slider = Slider::find($id);
        return view('admin.editslider')->with('slider',$slider);
    }

    public function updateSlider(Request $request){
        $this->validate($request, [ 'description1' => 'required',
                                    'description2' => 'required',
                                    'slider_image' => 'image|nullable|max:1999' ]);
        $slider = Slider::find($request->input('id'));
        $slider->description1 = $request->input('description1');
        $slider->description2 = $request->input('description2');
        
        if($request->hasFile('slider_image')){
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
            $slider->slider_image = $fileNameToStore;
        }
        
        $slider->update();
        return redirect('/sliders')->with('status', 'The Slider has been successfully updated !!');
     
    }

    public function deleteSlider($id){
        $slider = Slider::find($id);

        Storage::delete('public/slider_images/'.$slider->slider_image);

        $slider->delete();
        return back()->with('status', 'The Slider has been successfully deleted !!');
    }

    public function unactivate_slider($id){
        $slider = Slider::find($id);
        $slider->status = 0;
        $slider->update();
        return back()->with('status', 'The Slider has been successfully unactivated !!');
    }

    public function activate_slider($id){
        $slider = Slider::find($id);
        $slider->status = 1;
        $slider->update();
        return back()->with('status', 'The Slider has been successfully activated !!');
    }

}
