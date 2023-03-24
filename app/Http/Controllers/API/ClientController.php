<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Client::all();
        return response()->json([
            "success" => true,
            "message" => "Clients   List",
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
        if ($data['row']) {
            $imageFiles = $request->file('image_file');
            $attribute_value = $request->input('name');
            for ($i = 0; $i < count($imageFiles); $i++) {
                $image = $imageFiles[$i];
                $image_name = rand(6785, 9814) . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/images/clients/'), $image_name);
                $imageArray['image'] = $image_name;
                $imageArray['name'] = $attribute_value[$i];
                Client::create($imageArray);
            }
            if ($data['row']) {
                $resp['success'] = true;
                $resp['message'] = 'Client saved successfully ';
                $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
            } else {
                $resp = [
                    'success' => false,
                    'message' => 'Client Couldnot be Saved'
                ];
            }
            return response()->json($resp);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Client = Client::findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Client = Client::findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $delete = Client::where('id', $id)->pluck('image');
        unlink(public_path('uploads\images\clients/'.$delete[0]));
        $file = $request->file('image_file');
        if ($request->hasFile("image_file")) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/clients/'), $fileName);
            $request->request->add(['image' => $fileName]);
        }


        $data['row'] =Client::findOrFail($id);
        if(!$data ['row']){
            $resp = [
                'success' => false,
                'message' => 'Client Could not be updated'
            ];
        }
        if ($data['row']->update($request->all())) {
            $resp['success'] = true;
            $resp['message'] = 'Client Updated  successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Client Could not be updated'
            ];
        }
        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Client::where('id', $id)->pluck('image');

        unlink(public_path('uploads\images\clients/'.$delete[0]));

        $Clinet = Client::find($id);

        $Clinet->delete();
        return response()->json([
            "success" => true,
            "message" => "Clinet   Deleted",
            "data" => $Clinet
        ]);
    }
}
