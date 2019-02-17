@extends('admin.layouts.admin')

@section('title', 'Сторінка запчастини')

@section('page_title')
    <div class="col-3">
        <a href="{{ route('products') }}" class="btn btn-success"><i class="far fa-arrow-alt-circle-left"></i> Назад</a>
    </div>
    <div class="col-6">
        <h2 class="text-center">Сторінка запчастини: {{ $product->name }}</h2>
    </div>
@endsection

@section('content')
    <div class="col-12 col-lg-4">
        <h4 class="admin-h4">Додати застосування:</h4>

        @include('admin.layouts.parts.forms.add-applying')

        <div id="applying-section" style="display: {{ count($product->applyings->all()) > 0 ? 'block' : 'none' }}">
            <p class="admin-h4">Застосування запчастини:</p>
            <div id="product-applyings-container" class="col-12">
                 @include('admin.layouts.parts.applyings')
            </div>
        </div>


        <h4 class="admin-h4" style="margin-top:50px;">Додати модифікацію:</h4>
        <div id="modification-form-container">
            <!-- preload animation for ajax requests -->
            <div class="ajax-on-load">
                <img src="{{ asset('images/main/preloader.gif') }}" class="preloader-gif">
            </div>
            <!-- -->
            <!-- Section for errors-->
            <div id="modification-form-errors-section">
            </div>
            <!-- -->
            @include('admin.layouts.parts.forms.add-product-modification')
        </div>
    </div>
    <div class="col-12 col-lg-8">

        @if(Session::has('success'))
            {!! showInfoBlock(Session::get('success')) !!}
        @endif

        <div id="modifications-section" style="display: {{ count($product->modifications) > 0 ? 'block' : 'none' }}">
            <h4 class="admin-h4">Модифікації запчастини:</h4>

            <div class="table-responsive">
                <table id="modifications-table" class="table table-bordered" style="background:white;">
                    <thead class="thead-dark">
                    <tr class="text-center">
                        <th>Фото</th>
                        <th>Опис</th>
                        <th>Стан</th>
                        <th>Склад</th>
                        <th>Ціна, грн</th>
                        <th>Додано</th>
                        <th>Дії</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($product->modifications as $modification)
                        <tr class="text-center">
                            <td><img width="70" src="{{ $modification->photo }}"></td>
                            <td class="text-left">{{ str_limit($modification->description, 80) }}</td>
                            <td>{{ $modification->condition ? 'нова' : 'б/в' }}</td>
                            <td>{{ $modification->is_sold ? 'продано' : 'в наявності' }}</td>
                            <td>{{ number_format($modification->price, 2, ".", " ") }}</td>
                            <td>{{ $modification->created_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('show.modification', $modification) }}" data-id="{{ $modification->id }}"><i style="color:darkgreen" class="far fa-eye"></i></a>
                                <a href="{{ route('edit.modification', $modification) }}" data-id="{{ $modification->id }}" class="modification-edit-button"><i style="color: royalblue" class="fas fa-pen"></i></a>
                                <button  data-id="{{ $modification->id }}" class="modification-delete-button"><i style="color: darkred" class='fas fa-plus delete-i'></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection