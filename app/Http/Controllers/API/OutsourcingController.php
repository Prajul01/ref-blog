<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Outsourcing;
use Illuminate\Http\Request;

class OutsourcingController extends Controller
{
    public function index()
    {
        $contact = Outsourcing::all();
        return response()->json([
            "success" => true,
            "message" => "Outsourcing   List",
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
        $data['row']=Outsourcing::create($request->all());
        if ($data['row']) {
            $resp['success'] = true;
            $resp['message'] = 'Outsourcing saved successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Outsourcing Could not be Saved'
            ];
        }
        return response()->json($resp);

    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact= Outsourcing::findOrFail($id);
        $response = $contact;
        return response()->json(["data" => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Client = Outsourcing::findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data['row'] =Outsourcing::findOrFail($id);
        if(!$data ['row']){
            $resp = [
                'success' => false,
                'message' => 'Outsourcing not found'
            ];
        }
        if ($data['row']->update($request->all())) {
            $resp['success'] = true;
            $resp['message'] = 'Outsourcing Updated  successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Outsourcing Could not be updated'
            ];
        }
        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Clinet = Outsourcing::find($id);
        $Clinet->delete();
        return response()->json([
            "success" => true,
            "message" => "Outsourcing   Deleted",
            "data" => $Clinet
        ]);
    }
}
