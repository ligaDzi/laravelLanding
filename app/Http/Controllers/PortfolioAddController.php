<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Portfolio;

class PortfolioAddController extends Controller
{
    public function execute(Request $req){

        if($req->isMethod('post')){

            /* Добавление новой работы в БД */            
            $input = $req->except('_token');

            /* 
                Проверка введенных данных в форме 
                (здесь пример ручной валидаации, т.к. проверяется массив а не объект запроса) 
            */
            $validator = $this->validatePortfolio($input);
            
            /* Если ошибка, то редирект на маршрут-'portfolioAdd', сохранение ошибки и введенных данных в сесси*/
            if($validator->fails()){
                return redirect()->route('portfolioAdd')->withErrors($validator)->withInput();
            }

            /* Загрузка изображения на сервер */            
            /* В массив $input['images'], который будет сохраняться в БД в таблице 'portfolio', записать только имя файла */
            $input['images'] = $this->saveImage($req);

            /* Сохранение новой записи в БД в таблице 'portfolio' */
            $isSave = $this->savePortfolio($input); 

            if($isSave) {            
                return redirect('admin')->with('status','Работа добавлена');
            }
        }

        if(view()->exists('admin.portfolio_add')){

            $data = [
                'title'=>'Новая работа'
            ];

            return view('admin.portfolio_add', $data);
        }
        else{
            abourt(404);
        }  
    }
    
    /* Проверка введенных данных в форме */
    private function validatePortfolio($input){

        /* (здесь пример ручной валидаации, т.к. проверяется массив а не объект запроса) */
        $rules = [
            'name'=>'required|max:255',
            'filter'=>'required|max:50'
        ];
        $messages =[
            'required'=>'Поле :attribute обязательно к заполнению',
            'max'=>'Поле :attribute должно быть не больше :max символов'
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

    /* Сохранение новой записи в БД в таблице 'portfolio' */
    private function savePortfolio($input){

        $portfolio = new Portfolio();                    
        $portfolio->fill($input);

        return $portfolio->save();             
    }
    
}
