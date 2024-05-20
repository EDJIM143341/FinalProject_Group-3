<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Weapon;

class WeaponController extends Controller
{
    public function index(Request $request){
        $keyword = $request->get('search');
        $perPage = 5;
        if(!empty($keyword)){
            $weapons = Weapon::where('name', 'LIKE', "%$keyword%")
                    ->orWhere('category','LIKE', "%$keyword%")
                    ->latest()->paginate($perPage);
        }else
            $weapons = Weapon::latest()->paginate($perPage);

            return view('weapons.index', ['weapons' =>$weapons])->with('i',(request()->input('page',1)-1)*5);
    }

    public function create (){
        return view('weapons.create');
    }
    public function store(Request $request){
        
        $request->validate([
            'weapon_name' => 'required|string|max:255',
            'weapon_type' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'category' => 'required|string|max:255',
            // 'quantity' => 'required|integer|min:0',
            // 'price' => 'required|numeric|min:0',
        ]);

        $weapon = new Weapon;
        $file_name = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('images'), $file_name);

        
        $weapon->weapon_name = $request->weapon_name;
        $weapon->weapon_type = $request->weapon_type;
        $weapon->manufacturer = $request->manufacturer;
        $weapon->image = $file_name;
        // $product->category = $request->category;
        // $product->quantity = $request->quantity;
        // $product->price = $request->price;

        $weapon->save();

        return redirect()->route('weapons.index')->with('success', 'Weapon Added Successfully');
    }

    

    public function edit($id){
        $weapon = Weapon::findOrFail($id);
        return view('weapons.edit',['weapon' => $weapon]);
    }

    public function update (Request $request, Weapon $weapon){
        $request->validate([
            'weapon_name' => 'required'
        ]);

        $file_name = $request->hidden_product_image;

        if($request->image != ''){
            $file_name = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $file_name);
        }
        
        $weapon= Weapon::find($request->hidden_id);

        $weapon->weapon_name = $request->weapon_name;
        $weapon->weapon_type = $request->weapon_type;
        $weapon->manufacturer = $request->manufacturer;
        $weapon->image = $file_name;


        $weapon->save();

        return redirect()->route('weapons.index')->with('success', 'Weapon Updated Successfully');
    }

    public function destroy($id)
{
    $weapon = Weapon::findOrFail($id);
    $image_path = public_path()."/images";
    $image = $image_path. $weapon->image;
    if(file_exists($image)){
        unlink($image);
    }
    $weapon->delete();
    return redirect()->route('weapons.index')->with('success', 'Weapon deleted Successfully');

}

}