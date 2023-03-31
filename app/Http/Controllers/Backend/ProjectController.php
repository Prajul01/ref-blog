<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contributor;
use App\Models\Project;
use App\Models\ProjectContributors;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $url = env('API_URL') . '/project/';

        $data['row'] = Http::get($url)['data'];
        return  $data;
        return view($this->__loadDataToView($this->view . 'index'),compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->title = 'Create';
        $contributors=Contributor::all();
//        dd($contributors);


        return view($this->__loadDataToView($this->view . 'create'),compact('contributors'));
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
        $links=[
            [
                'link'=>$request->input('link'),
                'playstore'=>$request->input('playstore'),
                'appstore'=>$request->input('appstore')
            ],
        ];
        $model->links = json_encode($links);
        $file = $request->file('image_file');
    if ($request->hasFile('image_file')) {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/images/project/'), $fileName);
         $request->request->add(['image' => $fileName]);
        $model->image = $fileName;
    }
    $model->save();
    $cont['project_id']=$model->id;
    $contributors = $request->input('contributors_id');
    for($i=0;$i< count($contributors);$i++){
        $contributors_id=$contributors[$i];
        $cont['contributor_id']=$contributors_id;
        ProjectContributors::create($cont);
    }

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
//        dd($data['row']);
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
                'link'=>$request->input('link'),
                'playstore'=>$request->input('playstore'),
                'appstore'=>$request->input('appstore')
            ],
        ];
        $model->links = json_encode($links);

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
