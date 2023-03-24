<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comment = Comment::with('blog')->get();
        return response()->json([
            "success" => true,
            "message" => "Comments   List",
            "data" => $comment
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
        $data['row']=Comment::create($request->all());
            if ($data['row']) {
                $resp['success'] = true;
                $resp['message'] = 'Comment saved successfully ';
                $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
            } else {
                $resp = [
                    'success' => false,
                    'message' => 'Comment Couldnot be Saved'
                ];
            }
            return response()->json($resp);

        }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Client = Comment::with('blog')->findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $Client = Comment::with('blog')->findOrFail($id);
        $response = $Client;
        return response()->json(["data" => $response]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {



        $data['row'] =Comment::findOrFail($id);
        if(!$data ['row']){
            $resp = [
                'success' => false,
                'message' => 'Comments not found'
            ];
        }
        if ($data['row']->update($request->all())) {
            $resp['success'] = true;
            $resp['message'] = 'Comments Updated  successfully ';
            $resp['data']=$data['row'];
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Comments Could not be updated'
            ];
        }
        return response()->json($resp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        $Clinet = Comment::find($id);

        $Clinet->delete();
        return response()->json([
            "success" => true,
            "message" => "Comment   Deleted",
            "data" => $Clinet
        ]);
    }
}
