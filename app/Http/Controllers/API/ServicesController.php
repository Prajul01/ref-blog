<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $client = Service::all();
        return response()->json([
            "success" => true,
            "message" => "Services   List",
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
            $file->move(public_path('uploads/images/services/'), $fileName);
            $request->request->add(['icon' => $fileName]);

        }
        $data['row']=Service::create($request->all());
        if ($data['row']) {
            $resp['success'] = true;
            $resp['message'] = 'Service saved successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Service Could not be Saved'
            ];
        }
        return response()->json($resp);

    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $services = Service::findOrFail($id);
        $response = $services;
        return response()->json(["data" => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $services = Service::findOrFail($id);
        $response = $services;
        return response()->json(["data" => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $delete = Service::where('id', $id)->pluck('icon');
        unlink(public_path('uploads\images\services/'.$delete[0]));
        $file = $request->file('image_file');
        if ($request->hasFile("image_file")) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/services/'), $fileName);
            $request->request->add(['icon' => $fileName]);
        }


        $data['row'] =Service::findOrFail($id);
        if(!$data ['row']){
            $resp = [
                'success' => false,
                'message' => 'Service Could not be updated'
            ];
        }
        if ($data['row']->update($request->all())) {
            $resp['success'] = true;
            $resp['message'] = 'Service Updated  successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Service Could not be updated'
            ];
        }
        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Service::where('id', $id)->pluck('icon');

        unlink(public_path('uploads\images\services/'.$delete[0]));

        $Clinet = Service::find($id);

        $Clinet->delete();
        return response()->json([
            "success" => true,
            "message" => "Service  Deleted",
            "data" => $Clinet
        ]);
    }
}
