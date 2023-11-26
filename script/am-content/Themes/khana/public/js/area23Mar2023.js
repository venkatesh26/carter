(function ($) {
"use strict";
var baseurl= $('#baseurl').val();
var id= $('#location_id').val();
var next_page_url='';
var last_page_url='';
var categories=[];
var resturentdata=[];
var requesturl=baseurl+'/areainfo/'+id;
var catid=[];
$('.cat:checked').each(function(i){
    catid[i] = $(this).val();
});
var data={cats:catid};
categories=data;

getallresturent();

$('#next_page_url').on('click',function(){
    requesturl=next_page_url;
    getallresturent();
});

$('#last_page_url').on('click',function(){
    requesturl=last_page_url;
    getallresturent();
});


function getallresturent() {

   $.ajax({
    type: 'GET',
    url:  requesturl,
    data: {cats:categories,order:$('#order').val()},
    dataType: 'json',
    beforeSend: function() {
        $('.res').remove();
        $('.loader-main-area').removeClass('d-none');

    },
    success: function(response){
        $('.loader-main-area').addClass('d-none');
        $('.res').remove();
        resturentdata = response.data;
        $('#total_resurent').html(response.total);
        renderResturents();
        // basicmap();
        $('.resturant-pagination').show()
        $('#total').html(response.total);
        $('#from').html(response.from);
        $('#to').html(response.to);
        if (response.prev_page_url != null) {
            $('#last_page_url').show();
            last_page_url = response.prev_page_url;
        }
        else{
            $('#last_page_url').hide();
        }
        if (response.next_page_url != null) {
            $('#next_page_url').show();
            next_page_url = response.next_page_url;
        }
        else{
            $('#next_page_url').hide();
        }

    },
    error: function(){
        getallresturent();
    }

});
}



$('.cat').on('change',function(){
    var catid=[];
    $('.cat:checked').each(function(i){
        catid[i] = $(this).val();
    });
    var data={cats:catid};
    categories=data;
    getallresturent();

})

$('.area').on('change',function(){

   if( $(this).is(":checked") ){
    var val = $(this).val();
    id = val;

    $.ajax({
        type: 'GET',
        url:  baseurl+'/areadata/'+id,
        data: {cats:categories,order:$('#order').val()},
        dataType: 'json',
        beforeSend: function() {
            $('.res').remove();
            $('.loader-main-area').removeClass('d-none');
        },
        success: function(response){
            $('.loader-main-area').addClass('d-none');
            $('.res').remove();
            resturentdata = response.data.data;
            current_lat=response.lat;
            current_long=response.long;
            current_zoom=response.zoom;
            $('#total_resurent').html(response.data.total)

            renderResturents();
            // basicmap();

            $('.resturant-pagination').show()
            $('#total').html(response.data.total);
            $('#from').html(response.data.from);
            $('#to').html(response.data.to);
            if (response.data.prev_page_url != null) {
                $('#last_page_url').show();
                last_page_url = response.data.prev_page_url;
            }
            else{
                $('#last_page_url').hide();
            }
            if (response.next_page_url != null) {
                $('#next_page_url').show();
                next_page_url = response.data.next_page_url;
            }
            else{
                $('#next_page_url').hide();
            }

        },
        error: function(){
            getallresturent();
        }

    });
}





})


$('#order').on('change',function(){
    getallresturent()

})
function renderResturents() {
     console.log(resturentdata);

  $.each(resturentdata, function(index, value){



    var usercat=value.users.shopcategory;
    if (value.users.avg_ratting == null) {
        var avg_ratting = 0;
    }
    else{
        var avg_ratting = value.users.avg_ratting.content;
    }

    if (value.users.ratting == null) {
        var total_ratting = 0;
    }
    else{
        var total_ratting = value.users.ratting.content;
    }

    if (value.users.delivery == null) {
        var delivery_time = 60;
    }
    else{
        var delivery_time = value.users.delivery.content;

    }
    var preview = '';

    // if(value.users.preview.content == null){
    //     var preview = default_image;
    // }
    // else{
    //     var preview = resize(value.users.preview.content,'medium');
    // }

    if(value.users.coupons != null){
        var offercode = '<span>COUPON: '+value.users.coupons.title+'</span>';
        var offer = '<span>'+value.users.coupons.count+'% OFF</span>';
    }
    else{
     var offer = '';
     var offercode = '';
 }

// <div class="col-md-12 col-sm-12">
// <img src="img/recipie/1.jpg" alt="">
// <div class="rc-info">
// <h4>Recipe Name here</h4>
// <div class="rc-ratings">
// <span class="fa fa-star"></span>
// <span class="fa fa-star active"></span>
// <span class="fa fa-star active"></span>
// <span class="fa fa-star active"></span>
// <span class="fa fa-star active"></span>
// </div>
// <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard.</p>
// </div>
// </div>

console.log(avg_ratting);
var starRating  = '';

starRating +='<span class="fa fa-star"></span>';
starRating +='<span class="fa fa-star"></span>';
starRating +='<span class="fa fa-star"></span>';
starRating +='<span class="fa fa-star"></span>';
starRating +='<span class="fa fa-star"></span>';



 $('#resturent_area').append("<div class='col-lg-12 mb-30 res mt-3'> <div class='single-restaturants row'> <div class='col-lg-4'><a href='"+baseurl+'/store/'+value.users.slug+"'> <img src="+value.users.business_logo_file+" alt="+value.users.name+"></a></div><div class='col-lg-5'> <p class='mt-2 mb-0'><span class='ratings-component'>"+starRating+"<span class='count'>("+total_ratting+")</span></span></p><div class='restaturants-content mt-0 px-0'> <div class='name-rating'> <h4>"+value.users.business_disp_name+"</h4> </div><p>Specialities in "+value.users.specialities+"</p></div></div><div class='col-lg-3' style='display:flex;align-items:center;'> <p><a class='btn' href='"+baseurl+'/store/'+value.users.slug+"'>View Menu</a></p></div></div></a></div>");

 $.each(usercat,function(i,v){
    if (i==4) {
        return false;
    }
    $('#tagar'+index).append("<li class='text-dark'>"+v.name+"</li>");

})

});
}


if ($('#contact-map').length != 0) {
    // google.maps.event.addDomListener(window, 'load', basicmap);

}

function basicmap()
{
        // Map options

        var options = {
            zoom: current_zoom,
            center: { lat: current_lat, lng: current_long },
            styles: [{"featureType":"landscape.natural","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"landscape.natural","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi.park","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"visibility":"on"}]},{"featureType":"road","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"simplified"}]}]
        }

        // New map
        var map = new google.maps.Map(document.getElementById('contact-map'), options);
        // Array of markers
        var markers = [];
        var baseurl = $('#baseurl').val();
        var location_id = $('#location_id').val();
        var baseurl= $('#baseurl').val();

        $.each(resturentdata, function(index, value){

        console.log(value);

         var usercat=value.users.shopcategory;
         if (value.users.avg_ratting == null) {
            var avg_ratting = 0;
        }
        else{
            var avg_ratting = value.users.avg_ratting.content;
        }

        if (value.users.ratting == null) {
            var total_ratting = 0;
        }
        else{
            var total_ratting = value.users.ratting.content;
        }

        if (value.users.delivery == null) {
            var delivery_time = 60;
        }
        else{
            var delivery_time = value.users.delivery.content;

        }
        var preview = '';
        // if(value.users.preview.content == null){
        //     var preview = default_image;
        // }
        // else{
        //     var preview = resize(value.users.preview.content,'medium');
        // }

        if(value.users.coupons != null){
            var offercode = '<span>COUPON: '+value.users.coupons.title+'</span>';
            var offer = '<span>'+value.users.coupons.count+'% OFF</span>';
        }
        else{
         var offer = '';
         var offercode = '';
     }




     let v =  {
        coords: { lat: parseFloat(value.latitude), lng: parseFloat(value.longitude) },
        iconImage: resturent_icon,
        content: '<div class="filter_map_area"><a href="'+baseurl+'/store/'+value.users.slug+'"><div class="single-restaturants"> <img src="'+preview+'" ><div class="badges">'+offercode+offer+'</div><div class="total-min"> <span>'+delivery_time+'</span><span>min</span></div><div class="restaturants-content"><div class="name-rating"><h4>'+value.users.name+'</h4> <span class="ratings-component"><span class="stars"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"><path fill="#FF3252" d="M9 7.02L9.7 11 6 9.12 2.3 11 3 7.02 0 4.2l4.14-.58L6 0l1.86 3.62L12 4.2z"></path></svg></span> <span class="rating"><b>'+avg_ratting+'</b>/ 5</span><span class="count"> ('+total_ratting+')</span></span></div><div class="category-summery"> <nav> </nav></div></div></div></a></div>'
    }

    markers.push(v);
});


        // Loop through markers
        for (var i = 0; i < markers.length; i++) {
            // Add marker
            addMarker(markers[i]);
        }

        function addMarker(props) {
            var marker = new google.maps.Marker({
                position: props.coords,
                map: map,

            });

            // Check for customicon
            if (props.iconImage) {
                // Set icon image
                marker.setIcon(props.iconImage);
            }

            // Check content
            if (props.content) {
                var infoWindow = new google.maps.InfoWindow({
                    content: '<div class="scrollFix">'+props.content+'</div>',
                });



                marker.addListener('mouseover', function() {
                    infoWindow.open(map, marker);
                });

            }
        }


    }

})(jQuery);
