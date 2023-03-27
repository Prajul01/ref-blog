<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;

class ProjectController extends BackendBaseController
{
    protected $route ='admin.project.';
    protected $panel ='Project';
    protected $view ='backend.project.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new Project();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->title = 'List';
        $data['row'] = $this->model->all();
        $projectImages = ProjectImage::where('project_id',  $data['row']->first()->id)->get();

//        foreach ($data['row'] as $cont) {
//            $cont = unserialize($cont->contributors);
//
//        }
//


        return view($this->__loadDataToView($this->view . 'index'),compact('data','projectImages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->title = 'Create';

        return view($this->__loadDataToView($this->view . 'create'));
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
//    $model->thumbnail = $request->input('thumbnail');
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
        $imageArray['project_id'] = $model->id;
        $imageFiles = $request->file('img');
        for ($i = 0; $i < count($imageFiles); $i++) {
            $image = $imageFiles[$i];
            $image_name = rand(6785, 9814) . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/images/project/multiple'), $image_name);
            $imageArray['image'] = $image_name;
            ProjectImage::create($imageArray);
        }

        return redirect()->route($this->__loadDataToView($this->route . 'index'));

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

        return redirect()->route($this->__loadDataToView($this->route . 'index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $delete = $this->model->where('id', $id)->pluck('image');

        unlink(public_path('uploads\images\project/'.$delete[0]));

        $this->model->findorfail($id)->delete();
        return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');
    }
}
