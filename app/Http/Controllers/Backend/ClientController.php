<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
//use GuzzleHttp\Client;

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
        $url = env('API_URL') . '/client/';

        $data['row'] = Http::get($url)['data'];
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
        $client = new \GuzzleHttp\Client();
        $url = env('API_URL') . '/client';
        $nameArray = $request->input('name'); // Retrieve the array of name inputs from the form
        $imageFileArray = $request->file('image_file'); // Retrieve the array of image file inputs from the form

        $multipart = [];

        foreach ($nameArray as $index => $name) {
            $multipart[] = [
                'name' => 'name[]',
                'contents' => $name,
            ];

            $multipart[] = [
                'name' => 'image_file[]',
                'contents' => fopen($imageFileArray[$index]->getRealPath(), 'r'),
                'filename' => $imageFileArray[$index]->getClientOriginalName(),
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

        $this->title = 'View';
        $url = env('API_URL') . '/client/';
        $response = Http::get($url.$id);
        //dd($response);
        if ($response->successful()) {
            $data['row'] = $response['data'];
            return view($this->__loadDataToView($this->view . 'view'), compact('data'));
        } else {
            // handle error
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->title = 'View';
        $url = env('API_URL') . '/client/';
        $response = Http::get($url.$id. '/edit');

        if ($response->successful()) {
            $data['row'] = $response['data'];
            return view($this->__loadDataToView($this->view . 'edit'), compact('data'));
        } else {
            // handle error
            abort(404);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = env('API_URL') . '/client/';

        $name = $request->input('name');
        $imageFile = $request->file('image_file');

        $multipart = [
            [
                'name' => 'name',
                'contents' => $name,
            ],
            [
                'name' => 'image_file',
                'contents' => fopen($imageFile->getRealPath(), 'r'),
                'filename' => $imageFile->getClientOriginalName(),
            ],
        ];

        $response = $client->request('Post', $url . $id . '?_method=PUT' , [
            'multipart' => $multipart,
        ]);

        if ($response) {
            request()->session()->flash('success', $this->panel . 'Updated Successfully');
        } else {
            request()->session()->flash('error', $this->panel . 'Update Failed');
        }

        return redirect()->route($this->__loadDataToView($this->route . 'index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = new \GuzzleHttp\Client();

        $response = $client->request('DELETE', 'http://192.168.18.160:8000/api/client/' . $id);

        if ($response->getStatusCode() == 200) {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');

        } else {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('error',$this->panel .' Deleted Could noot be deleted');

        }
    }
}
