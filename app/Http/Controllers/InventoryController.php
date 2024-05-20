<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Weapon;
use Illuminate\Http\Request;

class InventoryController extends Controller

{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 5;
    
        if (!empty($keyword)) {
            $inventories = Inventory::whereHas('weapon', function ($query) use ($keyword) {
                $query->where('weapon_name', 'LIKE', "%$keyword%")
                      ->orWhere('weapon_type', 'LIKE', "%$keyword%");
            })->latest()->paginate($perPage);
        } else {
            $inventories = Inventory::with('weapon')->latest()->paginate($perPage);
        }
    
        return view('inventory.index', ['inventories' => $inventories])->with('i', (request()->input('page', 1) - 1) * 5);
    }



    public function create (){
        $weapons = Weapon::all();
        return view('inventory.create', compact('weapons'));
    }
    public function store(Request $request){
        
        $request->validate([
            'weapon_id' => 'required|int|max:11',
            'quantity' => 'required|integer|min:0',
            'condition' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            // 'category' => 'required|string|max:255',
            // 'quantity' => 'required|integer|min:0',
            // 'price' => 'required|numeric|min:0',
        ]);

        $inventory = new Inventory;
        $inventory->weapon_id = $request->weapon_id;
        $inventory->quantity = $request->quantity;
        $inventory->condition = $request->condition;
        $inventory->price = $request->price;
        // $product->category = $request->category;
        // $product->quantity = $request->quantity;
        // $product->price = $request->price;
        $inventory->save();
        return redirect()->route('inventory.index')->with('success', 'Weapon Added into Inventory Successfully');
    }

    

    // public function edit($inventory_id){
    //     $inventories = Inventory::findOrFail($inventory_id);
    //     return view('inventory.edit',['inventories' => $inventories ], compact('weapons'));
    // }

    // public function update (Request $request, Inventory $inventory){
    //     $request->validate([
    //         'weapon_id' => 'required'
    //     ]);
    
        
    //     $inventory = Inventory::find($request->hidden_id);
    //     $inventory->weapon_id = $request->weapon_id;
    //     $inventory->quantity = $request->quantity;
    //     $inventory->condition = $request->condition;
    //     $inventory->price = $request->price;
    //     $inventory->save();
    //     return redirect()->route('inventory.index')->with('success', 'Inventory Updated Successfully');
    // }

    public function destroy($inventory_id) 
    {
        $inventory = Inventory::findOrFail($inventory_id);
        $inventory->delete();
        return redirect()->route('inventory.index')->with('success', 'Weapon deleted Successfully');
    }

}