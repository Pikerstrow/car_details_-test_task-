{!! Form::open(['method'=>'POST', 'action'=>'CarModelsController@store', 'class' => 'form-row align-items-center', 'id' => 'add-car-model-form']) !!}
    {{ csrf_field() }}

    <div class="col-6 mb-2">
        {!! Form::select('car_id', array(''=>'Виберіть марку автомобіля') + $carsForSelectOptions , null, ['class'=>'form-control']) !!}
    </div>

    <div class="col-6 mb-2">
        <div class="input-group">
            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'введіть модель']) !!}
            <div class="input-group-append">
                <button class="btn btn-success add-car-model-btn" type="submit" disabled="disabled"><i class="fas fa-plus-circle fa-lg"></i></button>
            </div>
        </div>
    </div>
{!! Form::close() !!}