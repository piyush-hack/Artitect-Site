$(document).ready(
  $(function () {
    let apifilter = "Front Page";
    let apidata = { dataType: true, filter: apifilter };
    $.ajax({
      url: "./api/getPosts.php",
      type: "GET",
      data: apidata,
      headers: {
        Token: "PK,4y}^(apz%8in!.8IzgpoOQ,KVG&lfVAPT()3[WzXdX-Z",
      },
      dataType: "json",
      success: function (data) {
        console.log(data);
        setSlider(data);
      },
      error: function (error) {
        console.error(error);
      },
    });
  })
);

function setSlider(params) {
  $(".swiper-wrapper").html("");
  for (let i = 0; i < params.res.length; i++) {
    const element = params.res[i];
    var slide = swiperSlide(element, i);
    $(".swiper-wrapper").html(slide + $(".swiper-wrapper").html());
    // $(".swiper-wrapper").html(slide);
  }
  $.getScript("js/main.js");
}
