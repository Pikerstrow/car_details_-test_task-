{!! Form::open(['method'=>'POST', 'action'=>['ModificationsController@storeWithAjax', $product], 'files'=>true, 'id' => 'add_modification_form']) !!}
    {{ csrf_field() }}

    <div class="form-group">
        <div style="color:red; margin: 5px; width:200px;" id="photo-preview"></div>
        {!! Form::label('photo', 'Фото') !!}
        </br>
        {!! Form::file('photo', null, ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Опис') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control', 'rows' => '3']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('price', 'Ціна') !!}
        {!! Form::text('price', null, ['class'=>'form-control']) !!}
    </div>

    <div class="row d-flex justify-content-start">
        <div class="col-6 col-lg-6 col-xl-4" style="padding-right: 0;">
            <div class="form-group">
                <h5>Стан</h5>
                {!! Form::label('condition', 'б/в') !!}
                {!! Form::radio('condition', '0', true) !!}
                {!! Form::label('condition', 'нова') !!}
                {!! Form::radio('condition', '1') !!}
            </div>
        </div>
        <div class="col-6 col-lg-6 col-xl-4">
            <div class="form-group">
                <h5 >Продано</h5>
                {!! Form::label('is_sold', 'так') !!}
                {!! Form::radio('is_sold', '1') !!}
                {!! Form::label('is_sold', 'ні') !!}
                {!! Form::radio('is_sold', '0', true) !!}
            </div>
        </div>

        <div class="col-12 col-lg-12 col-xl-4">
            <div class="form-group mt-1">
                {!! Form::button('<i class="fas fa-plus-circle fa-lg"></i> Додати', ['type' => 'submit', 'class'=>'btn btn-primary col-12', 'id'=>'add_modification_button', 'disabled' => true]) !!}
            </div>
        </div>
    </div>


{!! Form::close() !!}