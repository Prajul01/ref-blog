<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends BackendBaseController
{
    protected $route ='admin.client.';
    protected $panel ='Client';
    protected $view ='backend.client.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new Client();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->title = 'List';
        $data['row'] = Client::all();
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
    public function store(ClientRequest $request)
    {
        $data['row'] = $request->all();
        if ($data['row']){
            $imageFiles = $request->file('image_file');
        $attribute_value = $request->input('name');
            for ($i = 0; $i < count($imageFiles); $i++){
                $image      = $imageFiles[$i];
                $image_name = rand(6785, 9814).'_'.$image->getClientOriginalName();
                $image->move(public_path('uploads/images/clients/'), $image_name);
                $imageArray['image'] = $image_name;
                $imageArray['name'] = $attribute_value[$i];
                 Client::create($imageArray);
            }
        if ($data['row']) {
            request()->session()->flash('success', $this->panel . 'Created Successfully');
        } else {
            request()->session()->flash('error', $this->panel . 'Creation Failed');
        }
        return redirect()->route($this->__loadDataToView($this->route . 'index'));

    }
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
//        'uploads/images/clients/'.$event->image

        $delete = Client::where('id', $id)->pluck('image');
        unlink(public_path('uploads\images\clients/'.$delete[0]));
        $file = $request->file('image_file');
        if ($request->hasFile("image_file")) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/images/clients/'), $fileName);
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
    public function destroy($id)
    {
        $delete = Client::where('id', $id)->pluck('image');

        unlink(public_path('uploads\images\clients/'.$delete[0]));

        $this->model->findorfail($id)->delete();
        return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');
    }
}
