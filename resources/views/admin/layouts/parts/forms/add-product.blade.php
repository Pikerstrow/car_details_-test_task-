<h4 class="admin-h4">Додати запчастину</h4>
{{ Form::open(['method' => 'post', 'action' => 'ProductsController@store', 'class' => 'form-inline', 'id' => 'add-product-form']) }}
    {{ csrf_field() }}

    <div class="input-group">
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'введіть назву']) !!}
        <div class="input-group-append">
            <button class="btn btn-success add-product-btn" type="submit" disabled="disabled"><i class="fas fa-plus-circle fa-lg"></i></button>
        </div>
    </div>
{!! Form::close() !!}