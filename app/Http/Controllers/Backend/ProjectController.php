<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Project;
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
//        foreach ($data['row'] as $cont) {
//            $cont = unserialize($cont->contributors);
//
//        }
//


        return view($this->__loadDataToView($this->view . 'index'),compact('data'));
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
    $model->links = serialize($request->input('links'));

        $file = $request->file('image_file');
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
        $delete = $this->model->where('id', $id)->pluck('image');
        unlink(public_path('uploads\images\project/'.$delete[0]));
        $file = $request->file('image_file');
        if ($request->hasFile("image_file")) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/project/'), $fileName);
            $request->request->add(['image' => $fileName]);
        }
        $data['row'] =$this->model->findOrFail($id);
        if(!$data ['row']){
            request()->session()->flash('error','Invalid Request');
            return redirect()->route($this->__loadDataToView($this->route . 'index'));
        }
        if ($data['row']->update($request->all())) {
            $request->session()->flash('success', $this->panel .' Update Successfully');
        } else {
            $request->session()->flash('error', $this->panel .' Update failed');

        }
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
