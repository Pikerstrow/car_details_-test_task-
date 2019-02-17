@extends('admin.layouts.admin')

@section('title', 'Рудагування модифікації')

@section('page_title')
    <div class="col-12">
        <h2 class="text-center">Редагування модифікації</h2>
    </div>
@endsection

@section('content')
    <div class="col-12 col-md-10 col-lg-8 col-xl-6 mt-2">

        @if(count($errors) > 0)
            {!! showInfoBlock('форма містить помилки', 'error', $errors->all())  !!}
        @endif

        @include('admin.layouts.parts.forms.edit-product-modification')

        <div class="row d-flex justify-content-between mt-4">
            <div class="col-3">
                <a href="{{ route('show.product', $modification->product_id) }}" class="btn btn-success"><i class="far fa-arrow-alt-circle-left"></i> Назад</a>
            </div>
            <div class="col-3">
                {{-- Deleting modification --}}
                {{ Form::open(['method'=>'delete', 'action' => ['ModificationsController@destroy', $modification]]) }}
                    <div class="form-group text-right">
                        {!! Form::button('<i class="fas fa-trash-alt"></i> Видалити', ['type' => 'submit', 'class'=>'btn btn-danger']) !!}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection