$("#loginform").submit(function (e) {
  e.preventDefault();

  const barcode = $("#barcode").val();
  var url = "https://metro.rdfmis.ph/metro/api/tripTicket.php?id=" + barcode;

  $.ajax({
    type: "GET",
    url: url,

    beforeSend: function () {
      $("#loading").append("<h2 class='text-center'>Loading...</h2>");
      $("#inputs").hide();
      $("#text-error").html("");
    },
    success: function (response) {
      console.log(response);
      $("#table-content").show();
      $("#loading").html("");

      $.each(response.records, function (key, value) {
        var html =
          "<tr>" +
          "<td>" +
          value.plate_no +
          "</td>" +
          "<td>" +
          value.status +
          "</td>" +
          "<td>" +
          value.destination +
          "</td>" +
          "<td><button class='btn btn-success btn-xs'><i class='mdi mdi-check'></i></button></td>" +
          "</tr>";

        $("#table-masterloc tr").first().after(html);
        console.log(value);
      });
    },
    error: function (response) {
      $("#loading").html("");
      $("#inputs").show();
      $("#text-error").html(response.responseJSON.message);
    },
  });
});
