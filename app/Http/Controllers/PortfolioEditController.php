<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Portfolio;

class PortfolioEditController extends Controller
{
    public function execute(Portfolio $portfolio, Request $req){

        $old = $portfolio->toArray();

        if($req->isMethod('delete')){

            /* Удаление записи из БД */            
            if($portfolio->delete()){
                return redirect('admin')->with('status','Работа удалена');
            }
        }

        if($req->isMethod('post')){

            /* Сохранение отредактированной работы в БД */
            $input = $req->except('_token');

            /* Проверка введенных данных в форме */
            $validator = $this->validatePortfolio($input);

            /* Если ошибка, то редирект на маршрут-'portfolioEdit', сохранение ошибки и введенных данных в сесси*/
            if($validator->fails()){
                return redirect()->route('portfolioEdit',['portfolio'=>$input['id']])->withErrors($validator)->withInput();
            }

            /* Загрузка изображения на сервер */
            /* В массив $input['images'], который будет сохраняться в БД в таблице 'portfolio', записать только имя файла */
            $input['images'] = $this->saveImage($req, $input['old_images']);

            /* Обновление записи в БД в таблице 'portfolio' */
            $isSave = $this->updatePortfolio($portfolio, $input);

            if($isSave){
                return redirect('admin')->with('status','Работа обновлена');                
            }
            
        }

        if(view()->exists('admin.portfolio_edit')){

            $data = [
                'title'=>'Редактирование работы - '.$old['name'],
                'data'=>$old
            ];
            return view('admin.portfolio_edit', $data);
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
    private function saveImage($request, $oldName){

        if($request->hasFile('images')){

            /* Получить объект файла, загруженного в поле формы name="images" */
            $file = $request->file('images');

            /* Определить имя изображения */
            $nameImage = $file->getClientOriginalName();

            /* Копирование файла на сервер в конкретную папку "public/img/имя_файла" */
            $file->move(public_path().'/img', $nameImage);

            return $nameImage;
        }
        else {
            /*
                Если нового изображения не было добавленно, 
                то в $input['images'] записать имя старого изображения.
            */
            return $oldName;
        }
    }

    /* Обновление записи в БД в таблице 'portfolio' */
    private function updatePortfolio($portfolio, $input){

        /* Удаление лишней информации в массиве $input[] */
        unset($input['old_images']);

        $portfolio->fill($input);

        return $portfolio->update();
    }
}
