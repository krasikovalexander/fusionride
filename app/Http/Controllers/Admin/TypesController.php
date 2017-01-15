<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Type;
use Illuminate\Http\Request;

class TypesController extends Controller
{
    public function index() {
        return view('admin.types.list', ["types" => Type::all()]);
    }

    public function edit(Request $request, $id) {
    	if ($request->isMethod('post')) {
    		$this->validate($request, [
		        'name' => 'required',
		        'passengers' => 'required',
		    ]);

    		$type = Type::find($id);
    		$type->name = $request->input('name');
    		$type->passengers = $request->input('passengers');
    		$type->active = $request->has('active');

    		if ($request->hasFile('img')) {
    			$type->img = '/img/uploads/'.$request->img->store('', 'types');
    		}
			$type->save();
    		return redirect()->route('admin.types')->with("notifications", ['success' => "Type '$type->name' updated successfully."]);
    	}
        return view('admin.types.edit', ["type" => Type::find($id)]);
    }

    public function create(Request $request) {
    	if ($request->isMethod('post')) {
    		$this->validate($request, [
		        'name' => 'required',
		        'passengers' => 'required',
		    ]);

    		$type = new Type;
    		$type->name = $request->input('name');
    		$type->passengers = $request->input('passengers');
    		$type->active = $request->has('active');

    		if ($request->hasFile('img')) {
    			$type->img = '/img/uploads/'.$request->img->store('', 'types');
    		}
			$type->save();
    		return redirect()->route('admin.types')->with("notifications", ['success' => "Type '$type->name' created successfully."]);
    	}
        return view('admin.types.edit', ["type" => new Type]);
    }
}
