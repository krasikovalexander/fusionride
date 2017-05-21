<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypesController extends Controller
{
    public function index()
    {
        return view('admin.types.list', [
            'types' => Type::orderBy('sort', 'ASC')->get(),
            'maxSort' => Type::max('sort'),
            'minSort' => Type::min('sort'),
        ]);
    }

    public function edit(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'passengers' => 'required',
            ]);

            $type = Type::find($id);
            $type->name = $request->input('name');
            $type->passengers = $request->input('passengers');
            $type->active = $request->has('active');
            $type->taxi_available = $request->has('taxi_available');
            $type->protected = $request->has('protected');

            if ($request->hasFile('img')) {
                $type->img = '/img/uploads/'.$request->img->store('', 'types');
            }
            $type->save();
            return redirect()->route('admin.types')->with("notifications", ['success' => "Type '$type->name' updated successfully."]);
        }
        return view('admin.types.edit', ["type" => Type::find($id)]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'passengers' => 'required',
            ]);

            $type = new Type;
            $type->name = $request->input('name');
            $type->passengers = $request->input('passengers');
            $type->active = $request->has('active');
            $type->sort = Type::all()->max('sort')+1;
            $type->taxi_available = $request->has('taxi_available');
            $type->protected = $request->has('protected');

            if ($request->hasFile('img')) {
                $type->img = '/img/uploads/'.$request->img->store('', 'types');
            }
            $type->save();
            return redirect()->route('admin.types')->with("notifications", ['success' => "Type '$type->name' created successfully."]);
        }
        return view('admin.types.edit', ["type" => new Type]);
    }

    public function up(Request $request, $id)
    {
        $type = Type::find($id);
        
        $typeUpper = Type::where('sort', '<', $type->sort)->orderBy('sort', 'DESC')->first();
        if ($typeUpper) {
            $sort = $typeUpper->sort;
            $typeUpper->sort = $type->sort;
            $type->sort = $sort;
            $typeUpper->save();
            $type->save();
        }
        return redirect()->route('admin.types')->with("notifications", ['success' => "Type '$type->name' updated successfully."]);
    }

    public function down(Request $request, $id)
    {
        $type = Type::find($id);
        $typeLower = Type::where('sort', '>', $type->sort)->orderBy('sort', 'ASC')->first();
        if ($typeLower) {
            $sort = $typeLower->sort;
            $typeLower->sort = $type->sort;
            $type->sort = $sort;
            $typeLower->save();
            $type->save();
        }

        return redirect()->route('admin.types')->with("notifications", ['success' => "Type '$type->name' updated successfully."]);
    }
}
