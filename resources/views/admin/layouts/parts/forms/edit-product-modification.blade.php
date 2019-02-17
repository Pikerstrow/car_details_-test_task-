{!! Form::model($modification, ['method'=>'PATCH', 'action'=>['ModificationsController@update', $modification->id], 'files'=>true, 'id' => 'add_modification_form']) !!}
    {{ csrf_field() }}

    <div class="form-group">
        <div id="photo-preview">
            <img src="{{ $modification->photo }}">
        </div>
        {!! Form::label('photo', 'Вибрати інше фото') !!}
        </br>
        {!! Form::file('photo', null, ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Опис') !!}
        {!! Form::textarea('description', null, ['class'=>'form-control', 'rows' => '2']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('price', 'Ціна') !!}
        {!! Form::text('price', null, ['class'=>'form-control']) !!}
    </div>

    <div class="row d-flex justify-content-start">
        <div class="col-12 col-md-4">
            <div class="form-group">
                <h5>Стан</h5>
                {!! Form::label('condition', 'б/в') !!}
                {!! Form::radio('condition', '0', true) !!}
                {!! Form::label('condition', 'нова') !!}
                {!! Form::radio('condition', '1') !!}
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="form-group">
                <h5 >Продано</h5>
                {!! Form::label('is_sold', 'так') !!}
                {!! Form::radio('is_sold', '1') !!}
                {!! Form::label('is_sold', 'ні') !!}
                {!! Form::radio('is_sold', '0', true) !!}
            </div>
        </div>
    </div>

    <div class="form-group text-center">
        {!! Form::button('<i class="fas fa-pen"></i> Редагувати', ['type' => 'submit', 'class'=>'btn btn-primary edit_modification_submit col-12']) !!}
    </div>
{!! Form::close() !!}