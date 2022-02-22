$(document).ready(
    $(function () {
      let apidata = { };
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
          setGridSizer(data);
        },
        error: function (error) {
          console.error(error);
        },
      });
    })
  );
  
  function setGridSizer(params) {
    $(".mry-grid-sizer").html(" ");
    for (let i = 0; i < params.res.length; i++) {
      const element = params.res[i];
      var slide = gridSizer(element, i);
      $(".mry-grid-sizer").html(slide + $(".mry-grid-sizer").html());
      // $(".swiper-wrapper").html(slide);
    }
    $.getScript("js/main.js");
  }
  