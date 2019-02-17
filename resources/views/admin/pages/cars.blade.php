@extends('admin.layouts.admin')

@section('title', 'Автомобілі та їх моделі')

@section('page_title')
    <div class="col-12">
        <h2 class="text-center">Автомобілі</h2>
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

    <div class="col-12 col-lg-4">
        <h4 class="admin-h4">Додати модель</h4>
        @include('admin.layouts.parts.forms.add-car-model')
    </div>

    <div class="col-12 col-lg-8">
        <h4 class="admin-h4">Вже додані марки автомобілі та їх моделі</h4>

        <div class="table-responsive">
            <table class="table table-bordered cars-list-table" style="background:white;">
                <thead class="thead-dark">
                <tr>
                    <th style="width:150px;">Марка</th>
                    <th>Модельний ряд</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cars as $car)
                    <tr>
                        <td>{{ $car->name }}</td>
                        <td>
                            @foreach($car->models as $model)
                                <span class="car-model-badge">
                            {{ $model->name }} |
                            {{ Form::open(['method' => 'delete', 'action' => ['CarModelsController@destroy', $model], 'class'=>'delete-car-model-form']) }}
                                <div class="form-group">
                                    {!! Form::button('<i class="fas fa-plus delete-i"></i>', ['type' => 'submit', 'class'=>'car-model-delete-button']) !!}
                                </div>
                            {{ Form::close() }}
                        </span>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection