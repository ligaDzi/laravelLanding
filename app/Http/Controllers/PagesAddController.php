<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Page;

class PagesAddController extends Controller
{
    public function execute(Request $req){

        if($req->isMethod('post')){

            /* Добавление новой страницы в БД */            
            $input = $req->except('_token');

            /* 
                Проверка введенных данных в форме 
                (здесь пример ручной валидаации, т.к. проверяется массив а не объект запроса) 
            */
            $validator = $this->validatePage($input);
            
            /* Если ошибка, то редирект на маршрут-'pagesAdd', сохранение ошибки и введенных данных в сесси*/
            if($validator->fails()){
                return redirect()->route('pagesAdd')->withErrors($validator)->withInput();
            }

            /* Загрузка изображения на сервер */            
            /* В массив $input['images'], который будет сохраняться в БД в таблице 'pages', записать только имя файла */
            $input['images'] = $this->saveImage($req);

            /* Сохранение новой записи в БД в таблице 'pages' */
            $isSave = $this->savePage($input); 

            if($isSave) {            
                return redirect('admin')->with('status','Страница добавлена');
            }
        }

        if(view()->exists('admin.pages_add')){

            $data = [
                'title'=>'Новая страница'
            ];

            return view('admin.pages_add', $data);
        }
        else{
            abourt(404);
        }        
    }

    /* Проверка введенных данных в форме */
    private function validatePage($input){

        /* (здесь пример ручной валидаации, т.к. проверяется массив а не объект запроса) */
        $rules = [
            'name'=>'required|max:255',
            'alias'=>'required|unique:pages|max:255',
            'text'=>'required'
        ];
        $messages =[
            'required'=>'Поле :attribute обязательно к заполнению',
            'unique'=>'Поле :attribute должно быть уникальным'
        ];
        $validator = Validator::make($input, $rules, $messages);

        return $validator;
    }

    /* Загрузка изображения на сервер */
    private function saveImage($request){

        if($request->hasFile('images')){

            /* Получить объект файла, загруженного в поле формы name="images" */
            $file = $request->file('images');
            
            /* Определить имя изображения */
            $nameImage = $file->getClientOriginalName();
            
            /* Копирование файла на сервер в конкретную папку "public/img/имя_файла" */
            $file->move(public_path().'/img', $nameImage);

            return $nameImage;
        }
    }

    /* Сохранение новой записи в БД в таблице 'pages' */
    private function savePage($input){

        $page = new Page();                    
        $page->fill($input);

        return $page->save();             
    }
}
