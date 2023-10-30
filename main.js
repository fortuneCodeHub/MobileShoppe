
$(document).ready(function(){
    $('#top-sale .owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:4
            },
            1400:{
                items:5
            }
        }
    });

    // Initialize the grid class
    var $grid = $(".grid").isotope({
        itemSelector: ".grid-item",
        layoutMode: "fitRows"
    });

    // Create the filter function on button click
    $(".button-group button").on("click", function(){
        var $value = $(this).attr("data-bs-name");
        // console.log("value", value);
        $grid.isotope({
            filter: $value
        })
    })
     
    // New Phones Owl Carousel
    $('#new-phone .owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
    $('#latest-blogs .owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000: {
                items:3
            }
        }
    });

    // Product qty section 
    let $qty_up = $(".qty-up");
    let  $qty_down = $(".qty-down");
    // let $qty__input = $(".qty__input");

    // Click on qty-up button
    $qty_up.click(function(e) {
        let $qty__input = $(`.qty__input[data-id='${$(this).data("id")}']`);
        if($qty__input.val() >= 1 && $qty__input.val()<= 9) {
            $qty__input.val(function(i,oldval){
                return ++oldval;
            })
        }
    });
    $qty_down.click(function(e) {
        let $qty__input = $(`.qty__input[data-id='${$(this).data("id")}']`);
        if ($qty__input.val() <= 10 && $qty__input.val() >= 2) {
            $qty__input.val(function (i,newval) {
                return --newval;
            })
        }
    });
});