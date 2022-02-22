$(document).ready(
  $(function () {
    $(".bcontent").wysihtml5({
      toolbar: {
        image: false,
      },
    });

    $(document).on("change", ".btn-file :file", function () {
      var input = $(this);
      var numFiles = input.get(0).files ? input.get(0).files.length : 1;
      console.log(input.get(0).files);
      var label = input.val().replace(/\\/g, "/").replace(/.*\//, "");
      input.trigger("fileselect", [numFiles, label]);
    });

    $(".btn-file :file").on("fileselect", function (event, numFiles, label) {
      var input = $(this).parents(".input-group").find(":text");
      var log = numFiles > 1 ? numFiles + " files selected" : label;

      if (input.length) {
        input.val(log);
      } else {
        if (log) {
          alert(log);
        }
      }
    });


    $(".linkInserter").on("click", function () {
      console.log("here");
      $(".bootstrap-wysihtml5-insert-link-modal").toggleClass("show");
      // $(".bootstrap-wysihtml5-insert-link-modal").css("display" , "block !important");

    });

    function getFormData($form) {
      var unindexed_array = $form.serializeArray();
      var indexed_array = {};

      $.map(unindexed_array, function (n, i) {

        if(indexed_array[n["name"]]){
          indexed_array[n["name"]] +="," + n["value"] ;
        }else{
          indexed_array[n["name"]] = n["value"];
        }
      });

      // console.log(indexed_array)
      return indexed_array;
    }

    $("#form").on("submit", function (e) {
      e.preventDefault();

      var $form = $("#form");
      var apidata = getFormData($form);
      var selected = $('#category').val();
      $.ajax({
        url: "./api/createPost.php",
        type: "post",
        data: apidata,
        headers: {
          Token: "PK,4y}^(apz%8in!.8IzgpoOQ,KVG&lfVAPT()3[WzXdX-Z",
        },
        dataType: "json",
        success: function (data) {
          console.info(data);
        },
        error: function (error) {
          console.error(error);
        },
      });
    });
  })
);
