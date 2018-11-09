<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Service;

class ServiceEditController extends Controller
{
    public function execute(Service $service, Request $req){

        $old = $service->toArray();

        if($req->isMethod('delete')){

            /* Удаление записи из БД */            
            if($service->delete()){
                return redirect('admin')->with('status','Сервис удален');
            }
        }
                
        if($req->isMethod('post')){

            /* Сохранение отредактированного сервиса в БД */
            $input = $req->except('_token');

            /* Проверка введенных данных в форме */
            $validator = $this->validateService($input);

            /* Если ошибка, то редирект на маршрут-'serviceEdit', сохранение ошибки и введенных данных в сесси*/
            if($validator->fails()){
                return redirect()->route('serviceEdit',['service'=>$input['id']])->withErrors($validator)->withInput();
            }

            /* Обновление записи в БД в таблице 'service' */
            $isSave = $this->updateService($service, $input);

            if($isSave){
                return redirect('admin')->with('status','Сервис обновлен');                
            }            
        }

        if(view()->exists('admin.service_edit')){

            $data = [
                'title'=>'Редактирование сервиса - '.$old['name'],
                'data'=>$old
            ];
            return view('admin.service_edit', $data);
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
    
    /* Обновление записи в БД в таблице 'service' */
    private function updateService($service, $input){

        $service->fill($input);

        return $service->update();
    }
}
