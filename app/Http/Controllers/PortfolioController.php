<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Portfolio;

class PortfolioController extends Controller
{
    public function execute(){

        /* Отобразить список работ из БД */

        if(view()->exists('admin.portfolio')){

            $portfolio = Portfolio::all();

            $data = [
                'title'=>'Работы',
                'portfolio'=>$portfolio
            ];

            return view('admin.portfolio', $data);
        }
        else{
            abourt(404);
        }        
    }
}
