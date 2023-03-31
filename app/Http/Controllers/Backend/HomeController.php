<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class HomeController extends BackendBaseController
{
    protected $route ='admin.hme.';
    protected $panel ='Home';
    protected $view ='home.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new Category();
    }
    //

    public function index()
    {
        $this->title = 'List';
        dd("wc");


        return view($this->__loadDataToView($this->view . 'index'));
    }



}
