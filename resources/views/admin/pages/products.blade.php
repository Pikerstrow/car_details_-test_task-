@extends('admin.layouts.admin')

@section('title', 'Запчастини')

@section('page_title')
    <div class="col-12">
        <h2 class="text-center">Запчастини</h2>
    </div>
@endsection

@section('content')
    <!-- info-block-section -->
    <di class="col-12">
        @if(Session::has('success'))
            {!! showInfoBlock(Session::get('success')) !!}
        @elseif(count($errors) > 0)
            {!! showInfoBlock('форма містить помилки', 'error', $errors->all())  !!}
        @endif
    </di>
    <!-- info-block-section -->

    <div class="col-12 col-lg-2">

        @if($editedProduct)
            @include('admin.layouts.parts.forms.edit-product')
        @else
            @include('admin.layouts.parts.forms.add-product')
        @endif

    </div>
    <div class="col-12 col-lg-10">
        <h4 class="admin-h4">Вже додані запчастини, їх застосування та модифікації</h4>

        <div class="table-responsive">
            <table class="table table-bordered cars-list-table" style="background:white;">
                <thead class="thead-dark">
                <tr>
                    <th class="text-center" style="width: 200px;">Назва</th>
                    <th class="text-center" style="width: 90px;">Дії</th>
                    <th class="text-center" style="width: 300px;">Застосування</th>
                    <th class="text-center">Модифікації</th>
                </tr>
                </thead>
                <tbody>
                @if(count($products) > 0)
                    @foreach($products as $product)
                        <tr>
                            <td><a href="{{ route('show.product', $product) }}">{{ $product->name }}</a></td>
                            <td>
                                <a href="{{ route('show.product', $product) }}" data-id="{{ $product->id }}"><i style="color:darkgreen" class="far fa-eye"></i></a>
                                <a href="{{ route('edit.product', $product->id) }}" data-id="{{ $product->id }}" class="product-edit-button"><i style="color: royalblue" class="fas fa-pen"></i></a>
                                {{ Form::open(['method'=>'delete', 'class'=>'delete-product-form', 'action' => ['ProductsController@destroy', $product]]) }}
                                <div class="form-group text-right">
                                    {!! Form::button('<i style="color: darkred" class="fas fa-plus delete-i"></i>', ['type' => 'submit', 'class'=>'btn btn-danger product-delete-button']) !!}
                                </div>
                                {{ Form::close() }}
                            </td>
                            <td style="max-width: 500px;">
                                @foreach($product->applyings as $applying)
                                    <span class="car-model-badge">
                                    {{ $applying->car->name . " " . $applying->car_model->name }} |
                                    {{ Form::open(['method' => 'delete', 'action' => ['ApplyingsController@destroy', $applying], 'class'=>'delete-car-model-form']) }}
                                        <div class="form-group">
                                            {!! Form::button('<i class="fas fa-plus delete-i"></i>', ['type' => 'submit', 'class'=>'car-model-delete-button']) !!}
                                        </div>
                                    {{ Form::close() }}
                                </span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($product->modifications as $key => $modification)
                                    @if($key == (count($product->modifications)-1))
                                        <a href=""><img width="40" src="{{ $modification->photo }}"> {{ str_limit($modification->description, 20) }}</a>
                                    @else
                                        <a href=""><img width="40" src="{{ $modification->photo }}"> {{ str_limit($modification->description, 20) }} </a> |
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4" class="text-center">Запчастини відсутні</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                {{ $products->render() }}
            </div>
        </div>
    </div>
@endsection