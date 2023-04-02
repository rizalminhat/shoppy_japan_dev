<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BrandContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data['brands'] = Brand::all();
        return view('admin.brand.list_brand', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.brand.create_brand');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        // dd($request->all());
        // $brands = Brand::all();

        // dd($brands);

        // $data = new Brand();
        // $data->brand_name = $request->brandName;
        // $data->brand_url = $request->brandUrl;
        // $data->admin_id = Auth::user()->id ;

        // if($request->file('brandImage')){
        //     $file = $request->file('brandImage');
        //     // @unlink(public_path('upload/brand_images/'.$data->image));
        //     $filename =uniqid().$file->getClientOriginalName();
        //     $file->move(public_path('upload/brand_images/'), $filename);
        //     $data->brand_img = $filename;
        // }

        // $data->save();

        $notifikasi = array(
            'message' => 'Brand successfully inserted',
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
