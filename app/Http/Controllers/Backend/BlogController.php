<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class BlogController extends BackendBaseController
{
    protected $route ='admin.blog.';
    protected $panel ='Blog';
    protected $view ='backend.blog.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new Blog();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->title = 'List';
        $data['row'] = Blog::all();
        return view($this->__loadDataToView($this->view . 'index'),compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->title = 'Create';
        $data['category']=Category::pluck('name','id');
//        dd($data['category']);

        return view($this->__loadDataToView($this->view . 'create'),compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $data['row'] = $request->all();
        $file = $request->file('image_file');
        if ($request->hasFile("image_file")) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/blog/'), $fileName);
            $request->request->add(['image' => $fileName]);

        }
        $data['row']=$this->model->create($request->all());
        if ($data['row']) {
            request()->session()->flash('success', $this->panel . 'Created Successfully');
        } else {
            request()->session()->flash('error', $this->panel . 'Creation Failed');
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
//        $delete = TeamMember::where('id', $id)->pluck('image');
//        unlink(public_path('uploads\images\team/'.$delete[0]));
//        $file = $request->file('image_file');
//        if ($request->hasFile("image_file")) {
//            $fileName = time() . '_' . $file->getClientOriginalName();
//            $file->move(public_path('uploads/images/team/'), $fileName);
//            $request->request->add(['image' => $fileName]);
//        }
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
//        $delete = TeamMember::where('id', $id)->pluck('image');
//
//        unlink(public_path('uploads\images\team/'.$delete[0]));

        $this->model->findorfail($id)->delete();
        return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');
    }
}
