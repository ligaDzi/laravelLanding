<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Page;

class PagesEditController extends Controller
{
    public function execute(Page $page, Request $req){

        $old = $page->toArray();

        if($req->isMethod('delete')){

            /* Удаление записи из БД */            
            if($page->delete()){
                return redirect('admin')->with('status','Страница удалена');
            }
        }
        
        if($req->isMethod('post')){

            /* Сохранение отредактированной страницы в БД */
            $input = $req->except('_token');

            /* Проверка введенных данных в форме */
            $validator = $this->validatePage($input);

            /* Если ошибка, то редирект на маршрут-'pagesEdit', сохранение ошибки и введенных данных в сесси*/
            if($validator->fails()){
                return redirect()->route('pagesEdit',['page'=>$input['id']])->withErrors($validator)->withInput();
            }

            /* Загрузка изображения на сервер */
            /* В массив $input['images'], который будет сохраняться в БД в таблице 'pages', записать только имя файла */
            $input['images'] = $this->saveImage($req, $input['old_images']);

            /* Обновление записи в БД в таблице 'pages' */
            $isSave = $this->updatePage($page, $input);

            if($isSave){
                return redirect('admin')->with('status','Страница обновлена');                
            }
            
        }

        if(view()->exists('admin.pages_edit')){

            $data = [
                'title'=>'Редактирование страницы - '.$old['name'],
                'data'=>$old
            ];
            return view('admin.pages_edit', $data);
        }
        else{
            abourt(404);
        } 
    }

    /* Проверка введенных данных в форме */
    private function validatePage($input){

        /* (здесь пример ручной валидаации, т.к. проверяется массив а не объект запроса) */
        /*
            Т.к. здесь редактируются данные из БД, а не добавляются новые,
            то эта запись:
                unique:pages,alias,'.$input['id'] 
            говорит валидатору что поле 'alias' должно быть уникальным, 
            но исключает из проверки уникальности 'alias' редактируемой записи. 
        */
        $rules = [
            'name'=>'required|max:255',
            'alias'=>'required|max:255|unique:pages,alias,'.$input['id'],
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

    /* Обновление записи в БД в таблице 'pages' */
    private function updatePage($page, $input){

        /* Удаление лишней информации в массиве $input[] */
        unset($input['old_images']);

        $page->fill($input);

        return $page->update();
    }
}
