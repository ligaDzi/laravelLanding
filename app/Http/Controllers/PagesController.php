<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;


class PagesController extends Controller
{
    public function execute(){

        /* Отобразить список страниц из БД */

        if(view()->exists('admin.pages')){

            $pages = Page::all();

            $data = [
                'title'=>'Страницы',
                'pages'=>$pages
            ];

            return view('admin.pages', $data);
        }
        else{
            abourt(404);
        }        
    }
}
