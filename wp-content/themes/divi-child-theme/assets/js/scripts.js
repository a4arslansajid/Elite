jQuery(function ($) {
    $('.js-filter select').on('change',function () {
    var cat=$('#cat').val()
    select_emirate =$('#select_country').val();
    
    var data ={
        action:'filter_posts',
        cat:cat,
        select_emirate: select_emirate,
    }
    $.ajax({
        url: variables.ajax_url,
        type:'POST',
        data: data,
        success: function(response){
            $('.js-locations').html(response);
        }
    })
    
    });
});