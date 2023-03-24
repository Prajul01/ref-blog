<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return response()->json([
            "success" => true,
            "message" => "Category   List",
            "data" => $category
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

            $attribute_value = $request->input('name');
            for ($i = 0; $i < count($attribute_value); $i++) {
                $attributeArray['name'] = $attribute_value[$i];
                Category::create($attributeArray);
            }
            if ($data['row']) {
                $resp['success'] = true;
                $resp['message'] = 'Category saved successfully ';
                $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
            } else {
                $resp = [
                    'success' => false,
                    'message' => 'Category Couldnot be Saved'
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
        $Client = Category::findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Client = Category::findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {



        $data['row'] =Category::findOrFail($id);
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
//        $delete = Category::where('id', $id)->pluck('image');
//
//        unlink(public_path('uploads\images\clients/'.$delete[0]));

        $Category = Category::find($id);

        $Category->delete();
        return response()->json([
            "success" => true,
            "message" => "Category   Deleted",
            "data" => $Category
        ]);
    }
}
