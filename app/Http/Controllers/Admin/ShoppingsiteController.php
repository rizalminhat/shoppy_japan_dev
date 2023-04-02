<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ShoppingsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data['sites'] = Site::orderBy('id','DESC')->get();
        return view('admin.site.list_site', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.site.add_site');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validate = $request->validate([
            'brandName' => 'required',
            'brandUrl' => 'required',
            'brandImage' => 'required|mimes:jpg,png,jpeg,pdf|max:2000',
            ],
            [
            'brandImage.max' => 'Image file must be less than 2MB' ,
            ]
        );

        $data = new Site();
        $data->site_name = $request->brandName;
        $data->site_url = $request->brandUrl;
        $data->site_status = '0';
        $data->admin_id = Auth::user()->id ;

        if($request->file('brandImage')){
            $file = $request->file('brandImage');
            // @unlink(public_path('upload/brand_images/'.$data->image));
            $filename =uniqid().$request->brandName.'.'.$file->getClientOriginalExtension();
            // $file->move(public_path('upload/brand_images/'), $filename);
            $request->file('brandImage')->storeAs('public/upload/brand_images/', $filename);
            $data->site_img = $filename;
        }

        $data->save();

        $notifikasi = array(
            'message' => 'Shopping Site Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.shoppingsite.view')->with($notifikasi);

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
        
        $data['site'] = Site::findorfail($id);
       
        return view('admin.site.edit_site', $data);
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


    $validate = $request->validate([
            'brandName' => 'required',
            'brandUrl' => 'required',
            'brandStatus' => 'required',
            'brandImage' => 'mimes:jpg,png,jpeg,pdf|max:2000',
            ],
        );

        $data = Site::find($id);
        $data->site_name = $request->brandName;
        $data->site_url = $request->brandUrl;
        $data->site_status = $request->brandStatus;
        $data->admin_id = Auth::user()->id ;

        if($request->file('brandImage')){
            $file = $request->file('brandImage');
            // @unlink(public_path('upload/brand_images/'.$data->site_img));
            \Storage::delete('public/upload/brand_images/'.$data->site_img);
            $filename =uniqid().$request->brandName.'.'.$file->getClientOriginalExtension();
            // $file->move(public_path('upload/brand_images/'), $filename);
            $request->file('brandImage')->storeAs('public/upload/brand_images/', $filename);

            $data->site_img = $filename;
        }

        $data->save();

        $notifikasi = array(
            'message' => 'Shopping Site Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.shoppingsite.view')->with($notifikasi);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $ids = $request->select;

        foreach($ids as $id)
        {
            $site = Site::find($id)->site_img;
            \Storage::delete('public/upload/brand_images/'.$site);
        }

        
        $data = Site::whereIn('id', $ids)->delete();
        return array('Data has been successfully deleted','success');
    }


}
