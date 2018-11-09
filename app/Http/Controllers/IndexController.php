<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\People;
use App\Portfolio;
use App\Service;
use Mail;
use DB;

class IndexController extends Controller
{
    protected $menu = [];

    public function execute(Request $req){

        if($req->isMethod('post')){

            /* Отправка mail */
            $result = $this->sendMail($req);

            if($result){                
                session(['status' => 'email OK']);                
                return redirect()->route('home');                
            }
        }

        $pages = Page::all();
        $portfolios = Portfolio::all();
        $services = Service::all();
        $peoples = People::all();

		$tags = DB::table('portfolios')->distinct()->select('filter')->get();
		
        /* Создание главного меню */
        $this->creationMenu($pages);

        return view(
            'site.index',
            [
                'menu'=>$this->menu,
                'pages'=>$pages,
                'portfolios'=>$portfolios,
                'services'=>$services,
                'peoples'=>$peoples,
                'tags'=>$tags
            ]
        );
	}

	/* Отправка mail */
	private function sendMail($request){

        /* Проверка введенных данных в форме */
        $rules = [
            'name'=>'required|max:255',
            'email'=>'required|email',
            'text'=>'required'
        ];
        $messages =[
            'required'=>'Поле :attribute обязательно к заполнению',
            'email'=>'Поле :attribute должно соответствовать email-адрессу'
        ];
        $this->validate($request, $rules, $messages);

		$data = $request->all();
		
		/* Отправка mail */
        return Mail::send('site.email', ['data'=>$data], function($message) use ($data){
            $mailAdmin = env('MAIL_ADMIN');
            $message->from($data['email'], $data['name']);
            $message->to($mailAdmin)->subject('Question');
        });
	}

	/* Создание главного меню */
    private function creationMenu($pages){
        
        foreach ($pages as $page) { 
            $this->addMenu($page->name, $page->alias);
        }
        $items = [
            ['title'=>'Service', 'alias'=>'service'],
            ['title'=>'Portfolio', 'alias'=>'Portfolio'],
            ['title'=>'Team', 'alias'=>'team'],
            ['title'=>'Contact', 'alias'=>'contact']
        ];
        foreach ($items as $item) {
            $this->addMenu($item['title'], $item['alias']);
        }
    }

    private function addMenu($title, $alias){
                       
        $item = [
            'title'=>$title,
            'alias'=>$alias
        ];
        array_push($this->menu, $item);
    }

}
