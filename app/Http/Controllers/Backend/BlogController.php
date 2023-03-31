<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $url = env('API_URL') . '/blog';

        $data['row'] = Http::get($url)['data'];
        return view($this->__loadDataToView($this->view . 'index'),compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->title = 'Create';
        $data['category']=Category::pluck('name','id');
        return view($this->__loadDataToView($this->view . 'create'),compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $client = new \GuzzleHttp\Client();
        $url = env('API_URL') . '/blog';
        $imageFile = $request->file('image_file');
        $data['row'] = $client->request('POST', $url, [
            'multipart' => [
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

                ],
                [
                    'name'     => 'category_id',
                    'contents' => $request->input('category_id')
                ],
                [
                    'name' => 'image_file',
                    'contents' => fopen($imageFile->getRealPath(), 'r'),
                    'filename' => $imageFile->getClientOriginalName(),
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
        $url = env('API_URL') . '/blog/';
        $response = Http::get($url.$id);
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
        $this->title= 'Edit';
        $data['category']=Category::pluck('name','id');

        $url = env('API_URL') . '/blog/';
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
        $url = env('API_URL') . '/blog/';
        $imageFile = $request->file('image_file');
        $data['row'] = $client->request('POST', $url. $id. '?_method=PUT' , [

            'multipart' => [
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

                ],
                [
                    'name'     => 'category_id',
                    'contents' => $request->input('category_id')
                ],
                [
                    'name' => 'image_file',
                    'contents' => fopen($imageFile->getRealPath(), 'r'),
                    'filename' => $imageFile->getClientOriginalName(),
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = env('API_URL') . '/blog/';

        $response = $client->request('DELETE', $url . $id);

        if ($response->getStatusCode() == 200) {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');

        } else {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('error',$this->panel .' Deleted Could noot be deleted');

        }
    }
}
