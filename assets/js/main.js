;(function($){

   /**
    * Testimonial Slider
    */
   $(window).on("elementor/frontend/init", function () {
      elementorFrontend.hooks.addAction("frontend/element_ready/Unitek-Elementor-Addon.default", function (scope, $) {
         $(scope).find("#unitek-testimonial-slider").slick({
            dots: false,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 5000,
            fade: true,
            cssEase: 'linear',
            lazyLoad: 'ondemand',
            prevArrow:"<button type='button' class='slick-prev pull-left'><span class='dashicons dashicons-arrow-left-alt'></span></button>",
            nextArrow:"<button type='button' class='slick-next pull-right'><span class='dashicons dashicons-arrow-right-alt'></span></button>"
         });
      });
  });

          
})(jQuery);


