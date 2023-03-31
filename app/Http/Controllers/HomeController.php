<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;

class HomeController extends BackendBaseController
{
    protected $route ='admin.home.';
    protected $panel ='Home';
    protected $view ='home';
    protected $title;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->title = 'Main Page';
        $user = auth()->user();
//        dd($user);

        return view($this->__loadDataToView($this->view ),compact('user'));
    }
}
