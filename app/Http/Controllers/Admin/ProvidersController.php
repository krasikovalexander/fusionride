<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Provider;
use App\State;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvidersController extends Controller
{
    public function index() {
        return view('admin.providers.list', ['drafts' => false, 'providers' => Provider::whereDraft(0)->with(['types', 'state'])->get()]);
    }

    public function drafts() {
        return view('admin.providers.list', ['drafts' => true, 'providers' => Provider::whereDraft(1)->with(['types', 'state'])->get()]);
    }

 	public function edit(Request $request, $id) {
 		$provider = Provider::find($id);

    	if ($request->isMethod('post')) {
    		$this->validate($request, [
		        'name' => 'required',
		        'city' => 'required',
		        'state_id' => 'required|exists:states,id',
                'email' => 'required|email'
		    ]);

    		$data = $request->all();
    		$data['draft'] = $request->has('draft');

    		$provider->fill($data);
    		$provider->save();
            $provider->types()->sync((array)$request->get('type'));

    		return redirect()->route('admin.'.($provider->draft ? 'drafts' : 'providers'))->with("notifications", ['success' => "Provider '$provider->name' updated successfully."]);
    	}
        return view('admin.providers.edit', ["provider" => $provider, 'states' => State::all(), 'types' => Type::all()]);
    }

    public function create(Request $request) {
    	if ($request->isMethod('post')) {
    		$this->validate($request, [
		        'name' => 'required',
		        'city' => 'required',
		        'state_id' => 'required|exists:states,id',
                'email' => 'required|email'
		    ]);

    		$data = $request->all();
    		$data['draft'] = $request->has('draft');

    		$provider = Provider::create($data);
            $provider->types()->sync((array)$request->get('type'));

    		return redirect()->route('admin.'.($provider->draft ? 'drafts' : 'providers'))->with("notifications", ['success' => "Provider '$provider->name' created successfully."]);
    	}

        return view('admin.providers.edit', ["provider" => new Provider, 'states' => State::all(), 'types' => Type::all()]);
    }

    public function search(Request $request) {
    	$results = [];
    	switch ($request->get('field')) {
    		case "city":
    			$cities = DB::table('providers')
    				->distinct()
    				->orderBy('city')
    				->whereStateId($request->get('state'))
    				->pluck('city');
    			foreach ($cities as $key => $value) {
    				$results[] = ["id" => $key, "label"=> $value];
    			}
    			break;

    	}
    	return response()->json($results);
    }
}