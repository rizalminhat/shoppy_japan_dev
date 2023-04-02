<?php

namespace App\Http\Controllers\Admin;

use App\Models\Config;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

       $data['configs'] = DB::table('configs')->get();
    //    dd($data['config']);
        return view('admin.setting.list_setting', $data);


        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $validated = $request->validate([
            'currency_rate' => 'required',
            'service_charge' => 'required',
        ]);


        $setting = Config::find($id);
        $setting->currency_yentomyr = $request->currency_rate;
        $setting->services_charge = $request->service_charge;
        $setting->updated_by = Auth::user()->name;

        $setting->save();


        $notifikasi = array(
            'message' => 'Setting updated successfully',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notifikasi);
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


    public function CourierTypeView()
    {
        $courType = Courier::all();

        // dd($courType);
        return view('admin.setting.list_courier_type', compact('courType'));
    }

    public function CourierTypeAdd()
    {

    }

    public function CourierTypeStore(Request $request)
    {
        

        $cour = new Courier();
        $cour->name = $request->courier_name;
        $cour->url = $request->courier_url;
        $cour->status = $request->courier_status;
        $cour->save();

        $notifikasi = array(
            'message' => 'Courier type add successfully',
            'alert-type' => 'success'
        );

        return back()->with($notifikasi);
    }

    public function CourierTypeUpdate(Request $request, $id)
    {
        // dd($request->all());

        $validated = $request->validate([
            'courier_name' => 'required',
            'courier_url' => 'required',
            'courier_status' => 'required'
        ]);


        $data = Courier::find($id);
        // dd($data);
        $data->name = strtoupper($request->courier_name);
        $data->url = $request->courier_url;
        $data->status = $request->courier_status;

        $data->save();


        $notifikasi = array(
            'message' => 'Courier type updated successfully',
            'alert-type' => 'success'
        );


        return redirect()->back()->with($notifikasi);

    }

    public function CourierTypeDelete(Request $request)
    {

        $ids = $request->select;

        foreach($ids as $id)
        {
            $cour = Courier::find($id);
            $cour->delete();
        }

        return array('Courier type delete succesfully','success');

    }
}
