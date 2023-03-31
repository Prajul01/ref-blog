<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends BackendBaseController
{
    protected $route ='admin.category.';
    protected $panel ='Category';
    protected $view ='backend.category.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new Category();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->title = 'List';
        $url = env('API_URL') . '/category';
        $data['row'] = Http::get($url)['data'];
//        $data['row'] = Client::all();
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
        dd($request->all());
        $client = new \GuzzleHttp\Client();
        $url = env('API_URL') . '/category';
        $nameArray = $request->input('name'); // Retrieve the array of name inputs from the form

        $multipart = [];

        foreach ($nameArray as $index => $name) {
            $multipart[] = [
                'name' => 'name[]',
                'contents' => $name,
            ];


        }

        $response = $client->request('POST', $url, [
            'multipart' => $multipart,
        ]);
        if ($response) {
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
        $url = env('API_URL') . '/category/';
        $response = Http::get($url. $id);
        if ($response->successful()) {
            $data['row'] = $response['data'];
            return view($this->__loadDataToView($this->view . 'view'), compact('data'));
        } else {
            // handle error
            abort(404);
        }
        return view($this->__loadDataToView($this->view . 'view'),compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   $this->title= 'Edit';
        $this->title= 'View';
        $url = env('API_URL') . '/category/';
        $response = Http::get($url. $id .'/edit');
        if ($response->successful()) {
            $data['row'] = $response['data'];
            return view($this->__loadDataToView($this->view . 'edit'), compact('data'));
        } else {
            // handle error
            abort(404);
        }


        return view($this->__loadDataToView($this->view . 'edit'),compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = env('API_URL') . '/category/';
        $response = $client->request('POST', $url.$id.'?_method=PUT' , [
            'multipart' => [
                [
                    'name'     => 'name',
                    'contents' => $request->input('name')
                ]
                ]
        ]);
        if ($response) {
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

        $client = new \GuzzleHttp\Client();
        $url = env('API_URL') . '/category/';

        $response = $client->request('DELETE', $url . $id);

        if ($response->getStatusCode() == 200) {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');

        } else {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('error',$this->panel .' Deleted Could noot be deleted');

        }
    }
}
