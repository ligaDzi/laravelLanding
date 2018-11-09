<div style="margin:0px 50px 0px 50px;">   

@if($service)
 
	<table class="table table-hover table-striped">
        <thead>
            <tr>
                <th>№</th>
                <th>Имя</th>
                <th>Иконка</th>
                <th>Текст</th>
                <th>Дата создания</th>
                
                <th>Удалить</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($service as $k => $item)
        
        	<tr>
        	
        		<td>{{ $item->id }}</td>
        		<td>{!! Html::link(route('serviceEdit',['page'=>$item->id]), $item->name, ['alt'=>$item->name]) !!}</td>
        		<td>{{ $item->icon }}</td>
        		<td>{{ $item->text }}</td>
        		<td>{{ $item->created_at }}</td>
        		
        		<td>
	        		{!! 
                        Form::open(['url'=>route('serviceEdit',['service'=>$item->id]), 'class'=>'form-horizontal','method' => 'POST']) 
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

{!! Html::link(route('serviceAdd'),'Новый сервис') !!}
   
</div>