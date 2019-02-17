<div class="card mt-4" style="width: 100%;">
    <img class="card-img-top" src="{{ $modification->photo }}" alt="Card image cap">
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><b>Модифікація №:</b> {{ $modification->id }} </li>
            <li class="list-group-item"><b>Опис:</b> {{ $modification->description }} </li>
            <li class="list-group-item"><b>Стан:</b> {{ $modification->condition ? 'нова' : 'б/в' }} </li>
            <li class="list-group-item"><b>Склад:</b> {{ $modification->is_sold ? 'продано' : 'в наявності' }}</li>
            <li class="list-group-item"><b>Ціна, грн:</b> {{ number_format($modification->price, 2, ".", " ") }} </li>
            <li class="list-group-item"><b>Додано:</b> {{ $modification->created_at->diffForHumans() }}</li>
        </ul>
        <div class="row d-flex justify-content-between mt-4">
            <div class="col-3">
                <a href="{{ route('show.product', $modification->product_id) }}" class="btn btn-success"><i class="far fa-arrow-alt-circle-left"></i> Назад</a>
            </div>
            <div class="col-3">
                <a href="{{ route('edit.modification', $modification) }}" class="btn btn-primary"><i class="fas fa-pen"></i> Редагувати</a>
            </div>
            <div class="col-3">
                {{ Form::open(['method'=>'delete', 'action' => ['ModificationsController@destroy', $modification]]) }}
                    <div class="form-group text-right">
                        {!! Form::button('<i class="fas fa-trash-alt"></i> Видалити', ['type' => 'submit', 'class'=>'btn btn-danger']) !!}
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>