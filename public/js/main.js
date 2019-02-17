$(document).ready(function(){

    /*SELECT CAR MODELS FOR SELECT OPTIONS ON PRODUCT PAGE*/
    $('#car_mark').change(()=>{
        let carId = $('#car_mark').val();

        $.ajax({
            url: '/car_marks/' + carId,
            type: 'GET',
            beforeSend(){
                $('#car_mark').attr('disabled', 'disabled');
            },
            success(data) {
                let select = "<select class='form-control' name='car_model_id' id='car_model'>";
                for(key in data){
                    select += "<option value='" + key + "'>" + data[key] + "</option>";
                }
                select += "</select>";
                $('#car_model_select_applyings').html(select);
                $('#car_mark').removeAttr('disabled');
                $('#add_applying_button').removeAttr('disabled');
            },
            error(){
                $('#ajax-request-error').html("<span>Помилка передачі даних <span style='cursor:pointer; border: 1px solid red' class='remove-get-model-error'>X</span></span>");
                $('#car_mark').removeAttr('disabled');
                $('#add_applying_button').attr('disabled', 'disabled');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    })


    /*ADD NEW PRODUCT APPLYING*/
    $('#add_applying_form').on('submit', (e)=>{
        e.preventDefault();
        let formData = new FormData($('#add_applying_form')[0]);
        let productId = window.location.pathname.split('/')[2];

        $.ajax({
            url: '/products/' + productId + '/applyings',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend(){
                $('#car_mark').attr('disabled', 'disabled');
                $('#car_model').attr('disabled', 'disabled');
            },
            success(data) {
                let csrfToken = $('meta[name="csrf-token"]').attr('content');

                let applying = "<span class='car-model-badge'>";
                    applying += data.car_mark + " " + data.car_model + " | ";
                    applying += "<button class='car-model-delete-ajax-button' data-id='" + data.id + "' data-token='" + csrfToken + "'>";
                    applying += "<i class='fas fa-plus delete-i'></i></button>";

                $('#product-applyings-container').append(applying);

                $('#car_mark').removeAttr('disabled');
                $('#car_mark').val('');
                $("#car_mark option:first-child").attr('selected', true);
                $('#car_model').remove();
                $('#add_applying_button').attr('disabled', 'disabled');
                checkApplyingsSection();
            },
            error(error){
                $('#ajax-request-error').html("<span>Помилка передачі даних <span class='remove-get-model-error'>x</span></span>");
                $('#car_mark').removeAttr('disabled');
                $('#car_mark').val('');
                $("#car_mark option:first-child").attr('selected', true);
                $('#car_model').remove();
                $('#add_applying_button').attr('disabled', 'disabled');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $('#ajax-request-error').on('click', '.remove-get-model-error', () => {
        $('#ajax-request-error').html('');
    });


    /*DELETE PRODUCT APPLYING*/
    $('#product-applyings-container').on('click', '.car-model-delete-ajax-button', function(e){
        e.preventDefault();

        let id = $(this).data("id");
        let token = $('meta[name="csrf-token"]').attr('content');

        const applying = $(this).closest('.car-model-badge');

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/applyings/' + id,
            type: 'POST',
            data: {
                'id': id,
                '_token': token,
                '_method': 'DELETE'
            },
            success(data) {
                if(data == 'deleted'){
                    $(applying).remove();
                }
                checkApplyingsSection();
            },
            error(error) {
                //console.log("error" + error);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*SHOW APPLYINGS SECTION IF THERE IS AT LEAST ONE APPLYING*/
    checkApplyingsSection();

    function checkApplyingsSection() {
        let applyingsSection = $('#applying-section');

        if ($(applyingsSection).find('.car-model-badge').length > 0) {
            $(applyingsSection).css('display', 'block');
        } else {
            $(applyingsSection).css('display', 'none');
        }
    }


    /*STORE PHOTO FOR MODIFICATIONS ADD FORM PREVIEW*/
    $('#add_modification_form input[type="file"]').on('change', () => {
        let formData = new FormData($('#add_modification_form')[0]);
            formData.append('_method', 'POST');

        $.ajax({
            url: '/products/modifications/photo',
            type: 'POST',
            data: formData,
            beforeSend(){
                $(this).attr('disabled', 'disabled');
            },
            success(data) {
                let preview = "<span style='color:darkblue'>Вибране фото:</span></br>"
                    preview += "<img src='" + data + "'>";
                $('#photo-preview').html();
                $('#photo-preview').html(preview);
            },
            error(xhr){

                let error = xhr.responseJSON.errors ? xhr.responseJSON.errors.photo["0"] : 'Помилка завантаження файлу';

                console.log(error);

                $('#photo-preview').html()
                $('#photo-preview').html(error);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });



    /*ADD NEW MODIFICATIONS*/
    /*Watch all inputs is filled and enable submit button*/
    $('#add_modification_form').on('keyup change paste', 'textarea, input', function(){
        if($('#add_modification_form input[name="photo"]').val() && $('#add_modification_form input[name="price"]').val() && $('#add_modification_form textarea').val()){
            $('#add_modification_button').removeAttr('disabled');
        }
    });

    /*Send data to controller*/
    $('#add_modification_button').on('click', function(e){
        e.preventDefault();

        let formData = new FormData($('#add_modification_form')[0]);
        let productId = window.location.pathname.split('/')[2];

        $.ajax({
            url: '/products/' + productId + '/modifications',
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend(){
                $(this).attr('disabled', 'disabled');
                $('.ajax-on-load').css('display', 'flex');
            },
            success(data) {

                $('#photo-preview').html('');
                $('#add_modification_form input[type="file"]').val('');
                $('#add_modification_form textarea').val('');
                $('#add_modification_form input[type="text"]').val('');
                $('.ajax-on-load').css('display', 'none');

                /*if table with modification has modifications - add new one to the top. If doesn't - just insert like common html*/
                if($('#modifications-table tbody tr').length > 0){
                    $('#modifications-table tbody tr:first-child').before(data);
                } else {
                    $('#modifications-table tbody').html(data);
                }

                $('#add_modification_button').attr('disabled', true);

                checkModficationsSection();
            },
            error(xhr){
                let errors = xhr.responseJSON.errors ? xhr.responseJSON.errors : {};

                let notification = "<div id='modification-form-errors-section' class='alert alert-danger alert-dismissible fade show' role='alert'>";
                    notification += "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                    notification += "<span aria-hidden='true'>&times;</span></button>";

                if(Object.keys(errors).length > 0){
                    notification += "<ul>";

                    for (let key in errors) {
                        switch(key) {
                            case "description":
                                notification += "<li>Поле 'ОПИС' містить недопустиме значення</li>";
                                break;
                            case "photo":
                                notification += "<li>Поле 'ФОТО' містить недопустиме значення</li>";
                                break;
                            case "condition":
                                notification += "<li>Поле 'СТАН' містить недопустиме значення</li>";
                                break;
                            case "is_sold":
                                notification += "<li>Поле 'ПРОДАНО' містить недопустиме значення</li>";
                                break;
                            case "price":
                                notification += "<li>Поле 'ЦІНА' містить недопустиме значення</li>";
                                break;
                            default:
                                notification += "<li>Помилка передачі даних</li>";
                        }
                    }

                    notification += "</ul></div>";
                    $('#modification-form-errors-section').append(notification);

                } else {
                    notification += "<span>Помилка передачі даних</span></div>";
                    $('#modification-form-errors-section').append(notification);

                }

                $('.ajax-on-load').css('display', 'none');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    /*DELETE MODIFICATION*/
    $('#modifications-table').on('click', '.modification-delete-button', function(e){
        e.preventDefault();

        $('#myModal').modal('show');

        let id = $(this).data("id");
        let token = $('meta[name="csrf-token"]').attr('content');
        const applying = $(this).closest('tr');

        $('.modal_delete_link').on('click', function(e){
            e.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/modifications/' + id,
                type: 'POST',
                data: {
                    'id': id,
                    '_token': token,
                    '_method': 'DELETE'
                },
                success(data) {
                    if(data){
                        $(applying).remove();
                    }
                    checkModficationsSection();
                },
                error(error) {
                    //console.log(error);
                },
                cache: false,
                contentType: false,
                processData: false
            });

            $('#myModal').modal('hide');
        });
    });


    /*SHOW MODIFICATIONS SECTION IF THERE IS AT LEAST ONE MODIFICATION*/
    checkModficationsSection();

    function checkModficationsSection() {
        let modificationsSection = $('#modifications-section');

        console.log($(modificationsSection).find('table#modifications-table tbody tr').length);

        if ($(modificationsSection).find('table#modifications-table tbody tr').length > 0) {
            $(modificationsSection).css('display', 'block');
        } else {
            $(modificationsSection).css('display', 'none');
        }
    }


    /*SHOW MODAL ON DELETE PRODUCT*/
    $('.product-delete-button').on('click', (e) => {
        e.preventDefault();
        $('#myModal').modal('show');

        const form = $('.delete-product-form');

        $('.modal_delete_link').on('click', () => {
            $(form).submit();
        });
    });

    /*ENABLE ADD CAR-MODEL and ADD-PRODUCT BUTTONS ON INPUT CHANGE*/
    enableButton('#add-product-form', 'input[name="name"]', '.add-product-btn');
    enableButton('#add-car-model-form', 'input[name="name"]', '.add-car-model-btn');

});




/*PAGINATION FOR TABLE WITH MODIFICATIONS*/
$(document).ready(function () {
    $('#modifications-table').after("<div id='table_nav'><button class='a-prev btn btn-primary btn-sm'><i class=\"fas fa-backward\"></i> </button> <button class='a-next btn btn-primary btn-sm'><i class=\"fas fa-forward\"></i> </button> <span class='pages-descr'>Сторінка <span class='page-num'> </span> із <span class='total_pages'> </span></span></div>");

    $('button.a-prev').prop('disabled', true);

    var rows_to_show = 8;
    var total_rows_quantity = $('#modifications-table tbody').find('tr').length;
    var pages_quantity = Math.ceil(total_rows_quantity / rows_to_show);

    if (pages_quantity == 1 || pages_quantity == 0) {
        $('button.a-next').prop('disabled', true);
    }

    $('#modifications-table tbody').find('tr').hide();
    $('#modifications-table tbody').find('tr').slice(0, rows_to_show).show();

    var current_page = 0;

    $('#table_nav .a-next').bind('click', function () {
        $('button.a-prev').prop('disabled', false);
        if (current_page < pages_quantity - 1) {
            current_page++;
        }
        if (current_page == pages_quantity - 1) {
            $(this).prop('disabled', true);
        }

        var start = current_page * rows_to_show;
        var end = start + rows_to_show;

        $('#modifications-table tbody').find('tr').css('opacity', '0.0').hide().slice(start, end).css('display', 'table-row').animate({'opacity': 1}, 300);
        $('span.page-num').text(current_page + 1);
    });

    $('#table_nav .a-prev').bind('click', function () {
        $('button.a-next').prop('disabled', false);

        if (current_page > 0) {
            current_page--;
        }
        if (current_page == 0) {
            $(this).prop('disabled', true);
        }

        var start = current_page * rows_to_show;
        var end = start + rows_to_show;

        $('#modifications-table tbody').find('tr').css('opacity', '0.0').hide().slice(start, end).css('display', 'table-row').animate({'opacity': 1}, 300);
        $('span.page-num').text(current_page + 1);
    });

    if(pages_quantity == 1 || pages_quantity == 0){
        $('span.total_pages').text('1');
    } else {
        $('span.total_pages').text(pages_quantity);
    }
    $('span.page-num').text(current_page + 1);
    //$('span.total_pages').text(pages_quantity);

});


function enableButton(formId, inputName, btnClass){
    $(formId).find(inputName).on('keyup', () => {
        $(btnClass).removeAttr('disabled');
    });

    if($(formId).find(inputName).val()){
        $(btnClass).removeAttr('disabled');
    }
}