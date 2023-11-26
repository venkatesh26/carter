(function ($) {
"use strict";
var baseurl= $('#baseurl').val();
var id= $('#location_id').val();
var next_page_url='';
var last_page_url='';
var categories=[];
var resturentdata=[];
// var requesturl=baseurl+'/areainfo/'+id;
var requesturl=baseurl+'/areainfo/0';
var catid=[];
$('.cat:checked').each(function(i){
    catid[i] = $(this).val();
});
var data={cats:catid};
categories=data;
var delivery = [];

$('.delivery:checked').each(function(i){
    delivery[i] = $(this).val();
});

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

    const params = new Proxy(new URLSearchParams(window.location.search), {
      get: (searchParams, prop) => searchParams.get(prop),
    });
    // Get the value of "some_key" in eg "https://example.com/?some_key=some_value"
    let postalcode = params.postalcode; // "some_value"

   $.ajax({
    type: 'GET',
    url:  requesturl,
    data: {cats:categories,order:$('#order').val(),delivery:delivery,postalcode:postalcode},
    dataType: 'json',
    beforeSend: function() {
        $('.res').remove();
        $('.loader-main-area').removeClass('d-none');

    },
    success: function(response){
        // console.log("test 1",response);
        $('.loader-main-area').addClass('d-none');
        $('.res').remove();
        resturentdata = response.data;
        // console.log(response);
        $('#total_resurent').html(response.total);
        renderResturents(resturentdata);
        // basicmap();
        $('.resturant-pagination').show()
        // $('#total').html(response.total);
        // $('#from').html(response.from);
        // $('#to').html(response.to);
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
    error: function(response){
        // console.log(response.responseText);
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

$('.delivery').on('change',function(){
    var del=[];
    $('.delivery:checked').each(function(i){
        del[i] = $(this).val();
    });
    delivery = {del:del};
    getallresturent();

});

// $('.area').on('change',function(){

//    if( $(this).is(":checked") ){
//     var val = $(this).val();
//     id = val;

//     $.ajax({
//         type: 'GET',
//         url:  baseurl+'/areadata/'+id,
//         data: {cats:categories,order:$('#order').val(),delivery:del},
//         dataType: 'json',
//         beforeSend: function() {
//             $('.res').remove();
//             $('.loader-main-area').removeClass('d-none');
//         },
//         success: function(response){
//             $('.loader-main-area').addClass('d-none');
//             $('.res').remove();
//             resturentdata = response.data.data;
//             current_lat=response.lat;
//             current_long=response.long;
//             current_zoom=response.zoom;
//             $('#total_resurent').html(response.data.total)

//             renderResturents();
//             // basicmap();

//             $('.resturant-pagination').show()
//             $('#total').html(response.data.total);
//             $('#from').html(response.data.from);
//             $('#to').html(response.data.to);
//             if (response.data.prev_page_url != null) {
//                 $('#last_page_url').show();
//                 last_page_url = response.data.prev_page_url;
//             }
//             else{
//                 $('#last_page_url').hide();
//             }
//             if (response.next_page_url != null) {
//                 $('#next_page_url').show();
//                 next_page_url = response.data.next_page_url;
//             }
//             else{
//                 $('#next_page_url').hide();
//             }

//         },
//         error: function(response){
//             console.log(response);
//             getallresturent();
//         }

//     });
// }
// })


$('#order').on('change',function(){
    getallresturent()

})
function renderResturents(renderResturents1) {
     // console.log(baseurl, resturentdata);
  
  let TotalRes = 0;
  console.log("test",renderResturents1);
  // if(renderResturents1.length>0){

  $.each(renderResturents1, function(index, value){

    
    if(value != null){
        TotalRes++;

        var usercat=value.shopcategory;
        if (value.avg_ratting == null) {
            var avg_ratting = 0;
        }
        else{
            var avg_ratting = value.avg_ratting.content;
        }

        if (value.ratting == null) {
            var total_ratting = 0;
        }
        else{
            var total_ratting = value.ratting.content;
        }

        if (value.delivery == null) {
            var delivery_time = 60;
        }
        else{
            var delivery_time = value.delivery.content;

        }
        var preview = '';

        // if(value.users.preview.content == null){
        //     var preview = default_image;
        // }
        // else{
        //     var preview = resize(value.users.preview.content,'medium');
        // }

        // if(value.users.coupons != null){
        //     var offercode = '<span>COUPON: '+value.users.coupons.title+'</span>';
        //     var offer = '<span>'+value.users.coupons.count+'% OFF</span>';
        // }
        // else{
        //  var offer = '';
        //  var offercode = '';
        // }

        var offer = '';
        var offercode = '';
       
        var starRating  = '';

        starRating +='<span class="fa fa-star"></span>';
        starRating +='<span class="fa fa-star"></span>';
        starRating +='<span class="fa fa-star"></span>';
        starRating +='<span class="fa fa-star"></span>';
        starRating +='<span class="fa fa-star"></span>';


        let logoPath = (value.business_logo_file)?value.business_logo_file:baseurl+"/uploads/restaurant-icon.png";

         $('#resturent_area').append("<div class='col-lg-12 mb-30 res mt-3'> <div class='single-restaturants row'> <div class='col-lg-4'><a href='"+baseurl+'/store/'+value.slug+"'> <img src="+logoPath+" alt="+value.name+"></a></div><div class='col-lg-5'> <p class='mt-2 mb-0'><span class='ratings-component'>"+starRating+"<span class='count'>("+total_ratting+")</span></span></p><div class='restaturants-content mt-0 px-0'> <div class='name-rating'> <h4>"+value.business_disp_name+"</h4> </div><p>Specialities in "+value.specialities+"</p></div></div><div class='col-lg-3' style='display:flex;align-items:center;'> <p><a class='btn' href='"+baseurl+'/store/'+value.slug+"'>View Menu</a></p></div></div></a></div>");

        //  $.each(usercat,function(i,v){
        //     if (i==4) {
        //         return false;
        //     }
        //     $('#tagar'+index).append("<li class='text-dark'>"+v.name+"</li>");

        // })
    }
    
});
  console.log(renderResturents1.length);
    if(renderResturents1.length==0){
        $('#resturent_area').append("<div class='col-lg-12 mb-30 res mt-3'>No restaurant found</div>"); 
    }
  // $('#total').html(TotalRes);
// }
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
