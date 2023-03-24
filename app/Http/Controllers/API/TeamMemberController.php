<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = TeamMember::all();
        return response()->json([
            "success" => true,
            "message" => "Team   List",
            "data" => $client
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data['row'] = $request->all();
        $file = $request->file('image_file');
        if ($request->hasFile("image_file")) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/team/'), $fileName);
            $request->request->add(['image' => $fileName]);

        }
        $data['row']=TeamMember::create($request->all());
            if ($data['row']) {
                $resp['success'] = true;
                $resp['message'] = 'Team saved successfully ';
                $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
            } else {
                $resp = [
                    'success' => false,
                    'message' => 'Team Could not be Saved'
                ];
            }
            return response()->json($resp);

        }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Client = TeamMember::findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Client = TeamMember::findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $delete = TeamMember::where('id', $id)->pluck('image');
        unlink(public_path('uploads\images\team/'.$delete[0]));
        $file = $request->file('image_file');
        if ($request->hasFile("image_file")) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/team/'), $fileName);
            $request->request->add(['image' => $fileName]);
        }


        $data['row'] =TeamMember::findOrFail($id);
        if(!$data ['row']){
            $resp = [
                'success' => false,
                'message' => 'Team Could not be updated'
            ];
        }
        if ($data['row']->update($request->all())) {
            $resp['success'] = true;
            $resp['message'] = 'Team Updated  successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Team Could not be updated'
            ];
        }
        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = TeamMember::where('id', $id)->pluck('image');

        unlink(public_path('uploads\images\team/'.$delete[0]));

        $Clinet = TeamMember::find($id);

        $Clinet->delete();
        return response()->json([
            "success" => true,
            "message" => "Team  Deleted",
            "data" => $Clinet
        ]);
    }
}
