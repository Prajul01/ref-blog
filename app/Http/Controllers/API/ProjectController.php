<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {

        $data['row'] = Project::all();
        $projectImages = ProjectImage::whereIn('project_id', $data['row']->pluck('id'))->get();

// Create a new associative array to map project IDs to their corresponding images
        $imageMap = [];
        foreach ($projectImages as $image) {
            $imageMap[$image->project_id][] = $image;
        }

// Loop through the project array and add the corresponding images to each project
        foreach ($data['row'] as $project) {
            $project->images = $imageMap[$project->id] ?? [];
        }

        return response()->json([
            "success" => true,
            "message" => "Projects List",
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
        $model->client = $request->input('client');
        $contributors = [
            [
                'name' => $request->input('contributor_name'),
                'github' => $request->input('contributor_github'),
                'linkedin' => $request->input('contributor_linkedin'),
                'role' => $request->input('role')
            ],
        ];
        $model->contributors = json_encode($contributors);
        $links=[
            [
                'links'=>$request->input('links'),
                'playstore'=>$request->input('playstore'),
                'appstore'=>$request->input('appstore')
        ],
        ];
        $model->links = json_encode($links);
        $file = $request->file('image_file');
        if ($request->hasFile('image_file')) {

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/images/project/'), $fileName);

            $request->request->add(['images' => $fileName]);
            $model->image = $fileName;

        }

        $model->save();
        $imageArray['project_id'] = $model->id;
        $imageFiles = $request->file('img');
        $projectImages = []; // Create an empty array to store the newly created ProjectImage objects
        for ($i = 0; $i < count($imageFiles); $i++) {
            $image = $imageFiles[$i];
            $image_name = rand(6785, 9814) . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/images/project/multiple'), $image_name);
            $imageArray['image'] = $image_name;
            $projectImage = ProjectImage::create($imageArray);
            $projectImages[] = $projectImage; // Push the newly created ProjectImage object into the array
        }
        if ($model) {
            $resp['success'] = true;
            $resp['message'] = 'Project saved successfully ';
            $resp['data']=$model;
            $resp['project_images']=$projectImages; // Add the array of ProjectImage objects to the response
        }
        else {
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
        $response=Project::findOrFail($id);
        $projectImages = ProjectImage::where('project_id',  $response->first()->id)->get();
        if ($response) {
            $resp['success'] = true;
            $resp['message'] = 'Project list ';
            $resp['data']=$response;
            $resp['data']['project_images'] = $projectImages;
        }
        else {
            $resp = [
                'success' => false,
                'message' => 'Project not Found'
            ];
        }

        return response()->json($resp);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $response=Project::findOrFail($id);
//        dd($data['row']);
        return response()->json(["data" => $response]);
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
        $model->client = $request->input('client');
        $model->thumbnail = $request->input('thumbnail');
        $contributors = [
            [
                'name' => $request->input('contributor_name'),
                'github' => $request->input('contributor_github'),
                'linkedin' => $request->input('contributor_linkedin'),
                'role' => $request->input('role')
            ],
        ];
        $model->contributors = json_encode($contributors);
        $links=[
            [
                'link'=>$request->input('link'),
                'playstore'=>$request->input('playstore'),
                'appstore'=>$request->input('appstore')
            ],
        ];
        $model->links = json_encode($links);

        $file = $request->file('image_file');
        $delete = Project::where('id', $id)->pluck('image');
        unlink(public_path('uploads\images\project/'.$delete[0]));
        if ($request->hasFile('image_file')) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/project/'), $fileName);
            $request->request->add(['image' => $fileName]);
            $model->image = $fileName;
        }
        $model->save();

        $imageArray['project_id'] = $id;
        $imageFiles = $request->file('img');
        $delete=ProjectImage::where('project_id',$id)->pluck('image');
        foreach ($delete as $delt){
            unlink(public_path('uploads/images/project/multiple/'.$delt));
        }
        ProjectImage::where('project_id',$id)->delete();
        for ($i = 0; $i < count($imageFiles); $i++) {
            $image = $imageFiles[$i];
            $image_name = rand(6785, 9814) . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/images/project/multiple'), $image_name);
            $imageArray['image'] = $image_name;
            ProjectImage::create($imageArray);

        }

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

        $delete=ProjectImage::where('project_id',$id)->pluck('image');
        foreach ($delete as $delt){
            unlink(public_path('uploads/images/project/multiple/'.$delt));
        }


        $multiple = ProjectImage::where('project_id', $id)->get();

        $multiple->each(function($image) {
            $image->delete();
        });
       $project=Project::findorfail($id);
        $project->delete();
        return response()->json([
            "success" => true,
            "message" => "Project  Deleted",
            "data" => $project
        ]);
    }
}
