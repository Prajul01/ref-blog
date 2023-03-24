<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = Blog::with('category')->get();

        return response()->json([
            "success" => true,
            "message" => "Blog  List",
            "data" => $client,
//

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
            $file->move(public_path('uploads/images/blog/'), $fileName);
            $request->request->add(['image' => $fileName]);

        }
        $data['row']=Blog::create($request->all());
        if ($data['row']) {
            $resp['success'] = true;
            $resp['message'] = 'Blog successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Blog Could not be Saved'
            ];
        }
        return response()->json($resp);

    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Blog::with('category')->findOrFail($id);
        $response = $client;
        return response()->json(["data" => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Client = Blog::with('category')->findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $delete = Blog::where('id', $id)->pluck('image');
        unlink(public_path('uploads\images\blog/'.$delete[0]));
        $file = $request->file('image_file');
        if ($request->hasFile("image_file")) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/blog/'), $fileName);
            $request->request->add(['image' => $fileName]);
        }


        $data['row'] =Blog::findOrFail($id);
        if(!$data ['row']){
            $resp = [
                'success' => false,
                'message' => 'Blog Could not be updated'
            ];
        }
        if ($data['row']->update($request->all())) {
            $resp['success'] = true;
            $resp['message'] = 'Blog Updated  successfully ';
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
        $delete = Blog::where('id', $id)->pluck('image');

        unlink(public_path('uploads\images\blog/'.$delete[0]));

        $Clinet = Blog::find($id);

        $Clinet->delete();
        return response()->json([
            "success" => true,
            "message" => "Blog  Deleted",
            "data" => $Clinet
        ]);
    }
}
