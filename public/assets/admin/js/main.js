$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#keywords_row").delegate( ".remove-keyword", "click", function() {
        //ajax script
        var word = $(this);
        var id = $(this).attr('itemid');
        $.ajax({
            type: "POST",
            url: "/admin/keyword/delete/"+id,
            dataType: "json",
            success: function ( data ) {
                console.log(data);
                console.log($(this));
                word.parent().parent().remove();
            },
        });
    });

    $(".delete_slider").on('click', function(event) {
        event.preventDefault();
        //ajax script
        var word = $(this);
        var id = $(this).attr('itemid');
        $.ajax({
            type: "POST",
            url: "/admin/slider/delete",
            dataType: "json",
            data: {
                id: id,
            },
            success: function ( data ) {
                console.log(data);
                console.log($(this));
                word.parent().parent().remove();
                alert('Удалено!');
            },
        });
    });
    $(".delete_vacancy").on('click', function(event) {
        event.preventDefault();
        //ajax script
        var word = $(this);
        var id = $(this).attr('itemid');
        $.ajax({
            type: "POST",
            url: "/admin/vacancy/delete",
            dataType: "json",
            data: {
                id: id,
            },
            success: function ( data ) {
                console.log(data);
                console.log($(this));
                word.parent().parent().remove();
                alert('Удалено!');
            },
        });
    });
    function viewCreatedKeyword(data)
    {
        var text = '';
        text = '<div class="col-md-2">' +
            '<div class="bg-dark dark pv20 text-white fw600 text-center keyword-div"><a href="#" itemid="'+data.id+'" class="remove-keyword"><i class="glyphicon glyphicon-remove"></i></a>'+data.name+'</div>'+
            '</div>';
        $('#keywords_row').append(text);
    }
    $('#check_keyword').on('click',function(){
        var form = $('#create_keyword_form');
        var data = form.serializeArray();
        console.log(data);
        $.ajax({
            type: "POST",
            url: "/admin/keyword/check",
            dataType: "json",
            data: {
                name: data[1].value, keywordable_id: data[2].value,  keywordable: data[3].value,
            },
            success: function ( data ) {
                if(typeof data.exist_in !== "undefined" )
                {
                    $('#keyword_hint').html('Данное ключевое слово уже есть!');
                }
                if(typeof data.data !== "undefined" )
                {
                    $('#anyway-text').html(data.data);
                    $('#confirm-anyway').removeClass('hidden');
                    $('#main-keyword').addClass('hidden')
                }
                if(typeof data.success !== "undefined")
                {
                    $('#keyword_hint').html('');
                    $('#add-keyword-modal').modal('hide');
                    $('#anyway-text').html('');
                    $('#confirm-anyway').addClass('hidden');
                    $('#main-keyword').removeClass('hidden');
                    alert('Успешно!');
                    viewCreatedKeyword(data.keyword);
                }
                if(typeof data.error !== "undefined")
                {
                    $('#keyword_hint').html(data.error);
                }
            },
        });
    });
    $('#add_keyword').on('click',function(){
        var form = $('#create_keyword_form');
        var data = form.serializeArray();
        console.log(data);
        $.ajax({
            type: "POST",
            url: "/admin/keyword/create",
            dataType: "json",
            data: {
                name: data[1].value, keywordable_id: data[2].value,  keywordable: data[3].value,
            },
            success: function ( data ) {
                if(typeof data.success !== "undefined") {
                    $('#keyword_hint').html('');
                    $('#add-keyword-modal').modal('hide');
                    $('#anyway-text').html('');
                    $('#confirm-anyway').addClass('hidden');
                    $('#main-keyword').removeClass('hidden');
                    alert('Успешно!');
                    viewCreatedKeyword(data.keyword);
                }
                if(typeof data.error !== "undefined")
                {
                    $('#anyway-text').html(data.error);
                }
            },
        });
    });
    $('#cancel_keyword').on('click',function(){
        $('#confirm-anyway').addClass('hidden');
        $('#main-keyword').removeClass('hidden');
        $('#new-name').val('');

    });
});