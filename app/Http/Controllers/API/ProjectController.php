<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {

        $data['row'] = Project::all();

        return response()->json([
            "success" => true,
            "message" => "Projects   List",
            "data" => $data['row']
        ], 201);




    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $model = new Project();
        $model->title = $request->input('title');
        $model->description = $request->input('description');
        $model->excerpt = $request->input('excerpt');
        $model->thumbnail = $request->input('thumbnail');
        $contributors = [
            [
                'name' => $request->input('contributor_name'),
                'facebook' => $request->input('contributor_facebook'),
                'linkedin' => $request->input('contributor_linkedin')
            ],
        ];
        $model->contributors = json_encode($contributors);
        // To store array data in database, you can use the `serialize()` function to convert the array into a string
        $model->links = json_encode($request->input('links'));
        $file = $request->file('image_file');
        if ($request->hasFile('image_file')) {

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/images/project/'), $fileName);

            $request->request->add(['image' => $fileName]);
            $model->image = $fileName;

        }
        $model->save();
        if ($model) {
            $resp['success'] = true;
            $resp['message'] = 'Project saved successfully ';
            $resp['data']=$model;
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Project Couldnot be Saved'
            ];
        }
        return response()->json($resp);

    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->title= 'View';
        $data['row']=$this->model->findOrFail($id);
        return view($this->__loadDataToView($this->view . 'view'),compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   $this->title= 'Edit';
        $data['row']=$this->model->findOrFail($id);
//        dd($data['row']);
        return view($this->__loadDataToView($this->view . 'edit'),compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $model = Project::find($id);
// Update the record with the new values
        $model->title = $request->input('title');
        $model->description = $request->input('description');
        $model->excerpt = $request->input('excerpt');
        $model->thumbnail = $request->input('thumbnail');
        $contributors = [
            [
                'name' => $request->input('contributor_name'),
                'facebook' => $request->input('contributor_facebook'),
                'linkedin' => $request->input('contributor_linkedin')
            ],
        ];
        $model->contributors = json_encode($contributors);
        $model->links = json_encode($request->input('links'));

        $file = $request->file('image_file');
        $delete = $this->model->where('id', $id)->pluck('image');

        unlink(public_path('uploads\images\project/'.$delete[0]));
        if ($request->hasFile('image_file')) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/project/'), $fileName);
            $request->request->add(['image' => $fileName]);
            $model->image = $fileName;
        }
        $model->save();

        if ($model) {
            $resp['success'] = true;
            $resp['message'] = 'Project saved successfully ';
            $resp['data']=$model;
//                $resp['id']=$data['row']->id;
        } else {
            $resp = [
                'success' => false,
                'message' => 'Project Couldnot be Saved'
            ];
        }
        return response()->json($resp);

//        return redirect()->route($this->__loadDataToView($this->route . 'index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = Project::where('id', $id)->pluck('image');

        unlink(public_path('uploads\images\project/'.$delete[0]));

       $project=Project::findorfail($id);
        $project->delete();
        return response()->json([
            "success" => true,
            "message" => "Project  Deleted",
            "data" => $project
        ]);
    }
}
