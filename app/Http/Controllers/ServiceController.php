<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service;

class ServiceController extends Controller
{
    public function execute(){

        /* Отобразить список сервисов из БД */

        if(view()->exists('admin.service')){

            $service = Service::all();

            $data = [
                'title'=>'Сервисы',
                'service'=>$service
            ];

            return view('admin.service', $data);
        }
        else{
            abourt(404);
        }        
    }
}
