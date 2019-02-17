@foreach($product->applyings->all() as $applying)
    <span class="car-model-badge">
        {{ $applying->car->name . " " . $applying->car_model->name }} |
        <button class="car-model-delete-ajax-button" data-id="{{ $applying->id }}" data-token="{{ csrf_token() }}">
            <i class="fas fa-plus delete-i"></i>
        </button>
    </span>
@endforeach
