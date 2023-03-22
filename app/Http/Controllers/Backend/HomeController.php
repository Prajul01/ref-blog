<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $route ='admin.category.';
    protected $panel ='Category';
    protected $view ='backend.category.';
    protected $title;
    protected $model;
    function __construct(){
        $this->model = new Category();
    }
    //

    public function index()
    {
        $this->title = 'List';

        return view($this->__loadDataToView($this->view . 'index'));
    }

}
