{!! Form::open(['method'=>'POST', 'action'=>['ApplyingsController@storeWithAjax', $product], 'class' => 'form-row align-items-center', 'id' => 'add_applying_form']) !!}
    {{ csrf_field() }}

    <div id="car_mark_select_applyings" class="col-4 mb-2 form-group">
        <span id="ajax-request-error" style="color:red; display: block; width: 400px;"></span>
        {!! Form::select('car_id', array(''=>'Виберіть марку автомобіля') + $cars , null, ['class'=>'form-control', 'id' => 'car_mark', 'disabled' => false]) !!}
    </div>

    <!-- filled by JS -->
    <div id="car_model_select_applyings" class="form-group mb-2"></div>

    <div class="form-group col-4 mb-2">
        {!! Form::button('<i class="fas fa-plus-circle fa-lg"></i>', ['type' => 'submit', 'class'=>'btn btn-primary', 'id'=>'add_applying_button', 'disabled'=>true]) !!}
    </div>
{!! Form::close() !!}