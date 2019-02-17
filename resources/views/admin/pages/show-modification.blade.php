@extends('admin.layouts.admin')

@section('title', 'Перегляд модифікації')

@section('page_title')
    <div class="col-12">
        <h2 class="text-center">Перегляд модифікації</h2>
    </div>
@endsection

@section('content')
    <div class="col-12 col-md-6 col-lg-4">
        @include('admin.layouts.parts.modification-card')
    </div>
@endsection