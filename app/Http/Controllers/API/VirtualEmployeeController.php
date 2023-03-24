<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\VirtualEmployee;
use Illuminate\Http\Request;

class VirtualEmployeeController extends Controller
{
    public function index()
    {
        $contact = VirtualEmployee::all();
        return response()->json([
            "success" => true,
            "message" => "VirtualEmployee   List",
            "data" => $contact
        ], 201);
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
        $data['row']=VirtualEmployee::create($request->all());
        if ($data['row']) {
            $resp['success'] = true;
            $resp['message'] = 'VirtualEmployee saved successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'VirtualEmployee Could not be Saved'
            ];
        }
        return response()->json($resp);

    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact= VirtualEmployee::findOrFail($id);
        $response = $contact;
        return response()->json(["data" => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Client = VirtualEmployee::findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data['row'] =VirtualEmployee::findOrFail($id);
        if(!$data ['row']){
            $resp = [
                'success' => false,
                'message' => 'VirtualEmployee not found'
            ];
        }
        if ($data['row']->update($request->all())) {
            $resp['success'] = true;
            $resp['message'] = 'VirtualEmployee Updated  successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'VirtualEmployee Could not be updated'
            ];
        }
        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Clinet = VirtualEmployee::find($id);
        $Clinet->delete();
        return response()->json([
            "success" => true,
            "message" => "VirtualEmployee   Deleted",
            "data" => $Clinet
        ]);
    }
}
