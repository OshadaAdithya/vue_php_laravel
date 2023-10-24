<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;

class ItemsController extends Controller
{
    //
    

    public function getItems()
    {
        $allItems= Items::all();

        return response()-> json([
            'items' => $allItems,200]); 

    }

    public function addItem(Request $request ){
        $item= new Items();


        $item->task= $request->input('name');
        $item->status= $request->input('status');
        $item->save();

        return response()->json(['message' => 'Item added successfully' . ' ' . json_encode($item)], 201);
    }

    public function deleteItem($id)
    {
        $item_to_delete= Items::find($id);

        if (!$item_to_delete){
            return response()->json(['error'=> "item not found". ' ' . json_encode($id)], 404);
        }

        $item_to_delete->delete();
        return response()->json(['sucess'=> "item deleted successfully" . ' ' . json_encode($id)], 201);

    }

    public function updateItem(Request $request, $id){

        $item_to_edit= Items::find($id);

        if (!$item_to_edit){
            return response()->json(['error'=> "item not found". ' ' . json_encode($id)], 404);
        }

        $item_to_edit->task= $request->input('name');
        $item_to_edit->status= $request->input('status');
        $item_to_edit->save();
        
        return response()->json(['sucess'=> "item deleted successfully" . ' ' . json_encode($id)], 201);
    }



    

}
