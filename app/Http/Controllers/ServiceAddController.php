<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Service;

class ServiceAddController extends Controller
{
    public function execute(Request $req){
        
        if($req->isMethod('post')){

            /* Добавление нового сервиса в БД */            
            $input = $req->except('_token');

            /* 
                Проверка введенных данных в форме 
                (здесь пример ручной валидаации, т.к. проверяется массив а не объект запроса) 
            */
            $validator = $this->validateService($input);
            
            /* Если ошибка, то редирект на маршрут-'serviceAdd', сохранение ошибки и введенных данных в сесси*/
            if($validator->fails()){
                return redirect()->route('serviceAdd')->withErrors($validator)->withInput();
            }

            /* Сохранение новой записи в БД в таблице 'service' */
            $isSave = $this->saveService($input); 

            if($isSave) {            
                return redirect('admin')->with('status','Сервис добавлен');
            }
        }
            
        if(view()->exists('admin.service_add')){

            $data = [
                'title'=>'Новый сервис'
            ];

            return view('admin.service_add', $data);
        }
        else{
            abourt(404);
        }    
    }
    
    /* Проверка введенных данных в форме */
    private function validateService($input){

        /* (здесь пример ручной валидаации, т.к. проверяется массив а не объект запроса) */
        $rules = [
            'name'=>'required|max:50',
            'icon'=>'required',
            'text'=>'required|max:255'
        ];
        $messages =[
            'required'=>'Поле :attribute обязательно к заполнению',
            'max'=>'Поле :attribute должно быть не больше :max символов'
        ];
        $validator = Validator::make($input, $rules, $messages);

        return $validator;
    }

    /* Сохранение новой записи в БД в таблице 'service' */
    private function saveService($input){

        $service = new Service();                    
        $service->fill($input);

        return $service->save();             
    }

}
