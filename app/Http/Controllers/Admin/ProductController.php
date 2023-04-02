<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site;
use App\Models\Product;
use App\Models\Announce;
use App\Traits\OrderTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{

    use OrderTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data['config'] = $this->configRate();
        $data['products'] = Product::with('site')->orderBy('id', 'DESC')->get();

        // dd($data['products']);
        return view('admin.product.list_product', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['configinfo'] = $this->configRate();
        $data['sites'] = Site::orderBy('id', 'DESC')->get();
        
        // dd($data);
        return view('admin.product.add_product', $data);
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
        $validate = $request->validate([
            'siteName' => 'required',
            'productName' => 'required',
            'productImage' => 'mimes:jpg,png,jpeg,pdf|max:2000',
            'productPrice' => 'required',
        ],
        [
            'siteName.required' => 'Please choose shopping site',
        ]);

        $data = new Product();
        $data->product_name = $request->productName;
        $data->product_url = $request->productURL;
        $data->product_price = $request->productPrice;
        // $data->product_price_rm = $request->productPriceRm;
        $data->product_status = '1';
        $data->site_id = $request->siteName;

        if($request->file('productImage')){
            $file = $request->file('productImage');
            // @unlink(public_path('upload/brand_images/'.$data->image));
            $filename =uniqid().'.'.$file->getClientOriginalExtension();
            // $file->move(public_path('upload/brand_images/'), $filename);
            $file->storeAs('public/upload/product_images/', $filename);
            $data->product_img = $filename;
        }

        $data->save();

        $notifikasi = array(
            'message' => 'Product successfully inserted',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.product.view')->with($notifikasi);
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
        $data['sites'] = Site::orderBy('id', 'DESC')->get();

        $data['product'] = Product::find($id);
        // dd($data['product']);
        $data['configinfo'] = $this->configRate();

        return view('admin.product.edit_product', $data);
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

        // dd($request->all());
        //

        $validate = $request->validate([
            'siteName' => 'required',
            'productName' => 'required',
            'productStatus' => 'required',
            'productURL' => 'required',
            'productImage' => 'mimes:jpg,png,jpeg,pdf|max:2000',
            'productPrice' => 'required',
        ],
        [
            'siteName.required' => 'Please choose shopping site',
        ]);

        $data = Product::find($id);
        $data->product_name = $request->productName;
        $data->product_url = $request->productURL;
        $data->product_status = $request->productStatus;
        $data->product_price = $request->productPrice;
        // $data->product_price_rm = $request->productPriceRm;
        $data->site_id = $request->siteName;

        if($request->file('productImage')){
            $file = $request->file('productImage');
            // @unlink(public_path('upload/brand_images/'.$data->image));
            \Storage::delete('public/upload/product_images/'.$data->product_img);

            $filename =uniqid().'.'.$file->getClientOriginalExtension();
            // $file->move(public_path('upload/brand_images/'), $filename);
            $file->storeAs('public/upload/product_images/', $filename);
            $data->product_img = $filename;

        }

        $data->save();

        $notifikasi = array(
            'message' => 'Product successfully updated',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.product.view')->with($notifikasi);

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
        // dd($request->all());

        $ids = $request->select;
        foreach($ids as $id)
        {
            $product = Product::find($id)->product_img;
            \Storage::delete('public/upload/product_images/'.$product);
        }

        
        $data = Product::whereIn('id', $ids)->delete();
        return array('Data has been successfully deleted','success');
    }


    public function allProduct()
    {
 

        $search = '1';
        $site = Site::
        whereHas('product', function($q){

        $q->where('product_status', '=', '1');

        })->get();

        $data['sites'] = Site::where('site_status','1')
        ->whereHas('product')
        ->orderBy('id','DESC')
        ->get();
        // ->map(function($pd) {
        //     $pd->setRelation('product', $pd->product->take(6));           
        //         return $pd;

        // });

       
        // whereHas('product', function ($query) {
        //     $query->where('product_status','=','1');
        // })

        $data['shops'] = Site::where('site_status', '1')->get();
        // dd($shops);
        // dd(session()->all());
        
        $data['emsFee'] = DB::table('courier_fee')
        ->where('cf_type', '=', '1')
        ->get();
        
        $query = "CAST(cf_weight AS INTEGER) ASC";
        $data['airmailFee'] = DB::table('courier_fee')
        ->where('cf_type', '=', '5')
        ->orderByRaw( $query )
        ->get();

        $data['config'] = $this->configRate();


        $data['annocue'] = Announce::whereIn('announce_type',['main page', 'both'])->where('announce_status','1')->get();


        // $data['borderColor'] = array('border-left-sj-red','border-left-sj-yellow');
        return view('main', $data);
        
    }
}