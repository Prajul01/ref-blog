<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ServicesController extends BackendBaseController
{
    protected $route ='admin.services.';
    protected $panel ='Services';
    protected $view ='backend.services.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new Service();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->title = 'List';
        $url = env('API_URL') . '/services';

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
        $url = env('API_URL') . '/services';
        $imageFile = $request->file('image_file');

        $data['row'] = $client->request('POST', $url, [
            'multipart' => [
                [
                    'name' => 'image_file',
                    'contents' => fopen($imageFile->getRealPath(), 'r'),
                    'filename' => $imageFile->getClientOriginalName(),
                ],
                [
                    'name'     => 'title',
                    'contents' => $request->input('title')
                ],
                [
                    'name'     => 'excerpt',
                    'contents' => $request->input('excerpt')

                ],
                [
                    'name'     => 'description',
                    'contents' => $request->input('description')
                ]

            ]
        ]);
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
        $this->title = 'View';
        $url = env('API_URL') . '/services/';
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
        $url = env('API_URL') . '/services/';
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
    public function update(Request $request, string $id)
    {
        $client = new \GuzzleHttp\Client();
        $imageFile = $request->file('image_file');

        $url = env('API_URL') . '/services/';
        $data['row'] = $client->request('Post', $url . $id . '/?_method=PUT' , [
            'multipart' => [
                [
                    'name' => 'image_file',
                    'contents' => fopen($imageFile->getRealPath(), 'r'),
                    'filename' => $imageFile->getClientOriginalName(),
                ],
                [
                    'name'     => 'title',
                    'contents' => $request->input('title')
                ],
                [
                    'name'     => 'excerpt',
                    'contents' => $request->input('excerpt')

                ],
                [
                    'name'     => 'description',
                    'contents' => $request->input('description')
                ]

            ]
        ]);
        if ($data['row']) {
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
        $url = env('API_URL') . '/services/';

        $response = $client->request('DELETE', $url . $id);

        if ($response->getStatusCode() == 200) {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');

        } else {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('error',$this->panel .' Deleted Could noot be deleted');

        }
    }
}
