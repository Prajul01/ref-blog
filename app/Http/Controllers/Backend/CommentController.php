<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends BackendBaseController
{
    protected $route ='admin.comment.';
    protected $panel ='Comments';
    protected $view ='backend.comments.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new Comment();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->title = 'List';
        $data['row'] = $this->model->all();
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
        $data['row'] = $request->all();
        if ($data['row']) {
            $this->model->create($request->all());
        }
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


        return view($this->__loadDataToView($this->view . 'edit'),compact('data'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
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
    public function destroy($id)
    {


        $this->model->findorfail($id)->delete();
        return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');
    }
}
