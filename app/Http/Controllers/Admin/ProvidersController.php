<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Provider;
use App\State;
use App\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use App\Mail\InviteToProvider;
use Illuminate\Support\Facades\Mail;

class ProvidersController extends Controller
{
    public function index()
    {
        return view('admin.providers.list', ['drafts' => false, 'providers' => Provider::whereDraft(0)->with(['types', 'state'])->get()]);
    }

    public function drafts()
    {
        return view('admin.providers.list', ['drafts' => true, 'providers' => Provider::whereDraft(1)->with(['types', 'state'])->get()]);
    }

    public function edit(Request $request, $id)
    {
        $provider = Provider::withTrashed()->find($id);

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'city' => 'required',
                'state_id' => 'required|exists:states,id',
                'email' => 'required|email'
            ]);

            $data = $request->all();
            $data['draft'] = $request->has('draft');

            if ($request->get('action') == 'clone') {
                $provider = new Provider;
                $data['draft'] = true;
            }
            
            $oldProvider = $provider;
            
            $provider->fill($data);
            $provider->phone_numbers = $provider->phone ? preg_replace("/[^0-9]/", "", $provider->phone) : "";
            $provider->save();
            $provider->types()->sync((array)$request->get('type'));

            if ($request->get('action') == 'clone') {
                return redirect()->route('admin.providers.edit', [$provider->id])->with("notifications", ['success' => "Provider '$provider->name' created successfully."]);
            }

            //return redirect()->route('admin.'.($provider->draft ? 'drafts' : 'providers'))->with("notifications", ['success' => "Provider '$provider->name' updated successfully."]);

            return redirect()->route('admin.providers.edit', [$provider->id])->with("notifications", ['success' => "Provider '$provider->name' updated successfully."]);
        }
        return view('admin.providers.edit', [
            'provider' => $provider,
            'states' => State::all(),
            'types' => Type::all(),
            'providers' => $provider->duplicates
        ]);
    }

    public function create(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'name' => 'required',
                'city' => 'required',
                'state_id' => 'required|exists:states,id',
                'email' => 'required|email'
            ]);

            $data = $request->all();
            $data['draft'] = $request->has('draft');
            $data['phone_numbers'] = preg_replace("/[^0-9]/", "", $request->get('phone', ""));
            $data['subscription_key'] = base64_encode(Hash::make(str_random(64)));

            $provider = Provider::create($data);
           
            $provider->save();

            $provider->types()->sync((array)$request->get('type'));

            //return redirect()->route('admin.'.($provider->draft ? 'drafts' : 'providers'))->with("notifications", ['success' => "Provider '$provider->name' created successfully."]);
            
            return redirect()->route('admin.providers.edit', [$provider->id])->with("notifications", ['success' => "Provider '$provider->name' created successfully."]);
        }

        return view('admin.providers.edit', ["provider" => new Provider, 'states' => State::all(), 'types' => Type::all()]);
    }

    public function search(Request $request)
    {
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

    public function trash(Request $request, $id)
    {
        $provider = Provider::find($id);
        $provider->delete();
        return redirect()->back()->with("notifications", ['warning' => "Provider '$provider->name' deleted successfully."]);
    }

    public function restore(Request $request, $id)
    {
        $provider = Provider::withTrashed()->find($id);
        $provider->restore();
        return redirect()->back()->with("notifications", ['warning' => "Provider '$provider->name' restored successfully."]);
    }

    public function deleted()
    {
        return view('admin.providers.deleted', ['providers' => Provider::onlyTrashed()->with(['types', 'state'])->get()]);
    }

    public function invite(Request $request, $id)
    {
        $provider = Provider::find($id);
        if (!$provider) {
            redirect()->back()->with("notifications", ['warning' => "Provider not found"]);
        }

        if (in_array($provider->subscription_status, ['none', 'pending', 'unsubscribed'])) {
            $provider->subscription_status = 'pending';
            $provider->save();
        }

        Mail::to($provider->email)
            ->queue(new InviteToProvider($provider));
          
        return redirect()->back()->with("notifications", ['success' => "Invite sent to '$provider->name'"]);
    }
}
