<h4 class="admin-h4">Редагувати запчастину</h4>
{{ Form::model($editedProduct, ['method' => 'patch', 'action' => ['ProductsController@update', $editedProduct->id], 'class' => 'form-inline', 'id' => 'add-product-form']) }}
    {{ csrf_field() }}

    <div class="input-group">
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'введіть назву']) !!}
        <div class="input-group-append">
            <button class="btn btn-success add-product-btn" type="submit" disabled="disabled"><i class="fas fa-pen"></i></button>
        </div>
    </div>
{!! Form::close() !!}