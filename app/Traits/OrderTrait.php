<?php

namespace App\Traits;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


trait OrderTrait {

    /**
     * @param Request $request
     * @return $this|false|string
     */
   public function orderProcess($id)
   {

        $data = Item::where('id', $id)->with('order','user','itemStatus')
        ->where(function($query) {
        $query->where('item_status_id','>=','2');
        })
        ->orderBy('items.created_at', 'DESC')->get();

        foreach($data as $itemCour)
        {
            $itemCour->item_process = json_decode($itemCour->item_process);
            $itemCour->item_process =array_reverse($itemCour->item_process);
            // $itemCour->item_process = Arr::last($itemCour->item_process, function ($value, $key) {
            //     return $value;
            // });
        }

        return $data;
   }

   public function configRate()
   {
    
        $data = DB::table('configs')
                ->where('id','1')
                ->first();

        return $data;
   }

}