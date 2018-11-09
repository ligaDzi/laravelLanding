<div style="margin:0px 50px 0px 50px;">   

@if($portfolio)
 
	<table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>Имя</th>
                <th>Фильтер</th>
                <th>Дата создания</th>
                
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($portfolio as $k => $item)
        
        	<tr>
        	
        		<td>{{ $item->id }}</td>
        		<td>{!! Html::link(route('portfolioEdit',['portfolio'=>$item->id]), $item->name, ['alt'=>$item->name]) !!}</td>
        		<td>{{ $item->filter }}</td>
        		<td>{{ $item->created_at }}</td>
        		
        		<td>
	        		{!! 
                        Form::open([
                            'url'=>route('portfolioEdit',['portfolio'=>$item->id]), 
                            'class'=>'form-horizontal',
                            'method' => 'POST'
                        ]) 
                    !!}
	        			
	        			{!! Form::hidden('_method','delete') !!}
	        			{!! Form::button('Удалить',['class'=>'btn btn-danger','type'=>'submit']) !!}
	        			
	        		{!! Form::close() !!}
        		</td>
        	</tr>
        
        @endforeach
        
		
        </tbody>
    </table>
@endif 

{!! Html::link(route('portfolioAdd'),'Новая работа') !!}
   
</div>