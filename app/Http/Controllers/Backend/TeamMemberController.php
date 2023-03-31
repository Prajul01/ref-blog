<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TeamMemberController extends BackendBaseController
{
    protected $route ='admin.team.';
    protected $panel ='Team Member';
    protected $view ='backend.teamMember.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new TeamMember();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->title = 'List';
        $url = env('API_URL') . '/team';

        $data['row'] = Http::get($url)['data'];
//        dd( $data['row']);
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
//       dd('hi');

        $client = new \GuzzleHttp\Client();
        $url = env('API_URL') . '/team';
        $imageFile = $request->file('image_file');
        $data['row'] = $client->request('POST', $url, [
            'multipart' => [
                [
                    'name'     => 'name',
                    'contents' => $request->input('name')
                ],
                [
                    'name'     => 'github',
                    'contents' => $request->input('github')
                ],
                [
                    'name'     => 'designation',
                    'contents' => $request->input('designation')

                ],
                [
                    'name'     => 'linkedin',
                    'contents' => $request->input('linkedin')
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
        $url = env('API_URL') . '/team/';
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
        $this->title= 'Edit';
        $url = env('API_URL') . '/team/';
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
        $url = env('API_URL') . '/team/';
        $imageFile = $request->file('image_file');
        $data['row'] = $client->request('POST', $url. $id. '?_method=PUT' , [
            'multipart' => [
                [
                    'name'     => 'name',
                    'contents' => $request->input('name')
                ],
                [
                    'name'     => 'github',
                    'contents' => $request->input('github')
                ],
                [
                    'name'     => 'designation',
                    'contents' => $request->input('designation')

                ],
                [
                    'name'     => 'linkedin',
                    'contents' => $request->input('linkedin')
                ],
                [
                    'name' => 'image_file',
                    'contents' => fopen($imageFile->getRealPath(), 'r'),
                    'filename' => $imageFile->getClientOriginalName(),
                ]
            ]
        ]);
        if(!$data ['row']){
            request()->session()->flash('error','Invalid Request');
            return redirect()->route($this->__loadDataToView($this->route . 'index'));
        }
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
    public function destroy(string $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = env('API_URL') . '/team/';

        $response = $client->request('DELETE', $url . $id);

        if ($response->getStatusCode() == 200) {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('success',$this->panel .' Deleted Successfully');

        } else {
            return redirect()->route($this->__loadDataToView($this->route . 'index'))->with('error',$this->panel .' Deleted Could noot be deleted');

        }
    }
}
