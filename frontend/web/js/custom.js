$(document).ready(function() {
    var form = $('#subscribeNewsletter');

    form.find('button[type="submit"]').hide();

    var buttonHtml = '<div class="input-group-append">' +
                        '<button type="submit" class="btn btn-outline-secondary" style="background-color: rgba(0, 0, 0, 1); color: rgba(255, 255, 255, 1)">MĂ ABONEZ</button>' +
                     '</div>';

    form.find('.form-group').append(buttonHtml);
    var checkboxHtml = '<div class="form-check">' +
                          '<input class="form-check-input" type="checkbox" id="termsCheckbox" required>' +
                          '<label class="form-check-label" for="termsCheckbox">' +
                              'Doresc sa ma abonez la newsletter pentru a primi toate ofertele. Am citit și sunt de acord cu <a href="/termeni-si-conditii">termenii și condițiile</a> și cu <a href="/politica-de-confidentialitate">politica de confidențialitate</a>.' +
                          '</label>' +
                      '</div>';

    form.find('.form-group').append(checkboxHtml);
    // form.on('submit', function(event) {
    //     event.preventDefault(); 

    //     var isChecked = $('#termsCheckbox').prop('checked');
    //     if (!isChecked) {
    //         alert('Te rugăm să bifezi că ai citit și ești de acord cu termenii și condițiile și politica de confidențialitate.');
    //         return;
    //     }

    // });

    

});


$(document).ready(function () {
    $("div.module-gallery").slick({
        slidesToShow: 6, 
        slidesToScroll: 1,
        centerMode: false,
        arrows: false,
        dots: false,
        speed: 300,
        infinite: true,
        autoplaySpeed: 2000,
        autoplay: true,
        pauseOnHover: false,
        // prevArrow:
        //   '<button class="prev-arrow arrows"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15 8H1" stroke="#FBFBFB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 1L1 8L8 15" stroke="#FBFBFB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
        // nextArrow:
        //   '<button class="next-arrow arrows"><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1 8H15" stroke="#FBFBFB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 1L15 8L8 15" stroke="#FBFBFB" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>',
    });
    // $("<div class='slick-arrows'></div>").insertAfter(".slider-inner .slick-list");
    // $("<div class='slick-arrows-inner'></div>").appendTo(".slider-inner .slick-arrows");
    // $(".slider-inner .module-gallery .slick-arrow").appendTo(".slider-inner .slick-arrows-inner");
    // $(".slider-inner .module-gallery .slick-dots").appendTo(".slider-inner .slick-arrows");

    // $(window).on("resize", () => {
    //   $(".hero-inner .slider-inner .module-gallery .slick-arrow").appendTo(".hero-inner .slider-inner .slick-dots");
    // });
});



//   $(".pagination-slider").appendTo(".slider-inner .module-gallery");
// $(".slider-inner .module-gallery .slick-arrow").appendTo(".slick-dots");


$(document).ready(function(){
    $('.products-slider .categories-grid').slick({
      infinite: true,
      slidesToShow: 1,
      dots: true,
      arrows: true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: true
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });

    $('.news .categories-grid').slick({
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        dots: true,
        speed: 1000,
        arrows: true,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
        ]
      });
});
  

//   $(document).ready(function(){
//     $.ajax({
//         url: '/frontend/views/site/products.php',
//         type: 'GET',
//         success: function(data) {
//             $('.short-desc').append(data);
//         },
//         error: function() {
//             console.error("Nu s-a putut obține datele.");
//         }
//     });
// });

