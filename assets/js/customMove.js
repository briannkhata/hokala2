$("#barcode").keypress(function (event) {
  if (event.which === 13) {
    var barcode = $("#barcode").val();
    if (barcode.trim() === "") {
      alert("Barcode is required!!!!");
    } else {
      search();
    }
  }
});

$("#clear_cart").click(function (e) {
  cancel();
});

// $("#finish").click(function (e) {
//   finish();
// });

function finish_moving() {
  var tenderedAmount = $("#move_to").val();
  var client_id = $("#client_id").val();
  var payment_type_id = $("#payment_type_id").val();
  var details = $("#details").val();
  tenderedAmount2 = parseFloat(tenderedAmount.replace(/,/g, ""));

  if (!tenderedAmount2 || isNaN(tenderedAmount2)) {
    alert("Please enter a valid tendered amount.");
    return;
  }
  $.post("Sale/finish_sale", {
    tendered: tenderedAmount2,
    client_id: client_id,
    payment_type_id: payment_type_id,
    details: details,
  })
    .done(function (data) {
      $("#receipt-container").html(data);
      //window.print();
      console.log(data)
      load_cart();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      // This function will run if there is an error with the AJAX request
      console.log("AJAX Error:", textStatus, errorThrown);
      alert("An error occurred while processing your request.");
    });
}

function search() {
  $.post(
    "Move/refresh_cart",
    {
      barcode: $("#barcode").val(),
    },
    function (data) {
      if (data.success) {
        console.log(data.message);
        load_cart();
      } else {
        console.log(data.message);
        alert(data.message);
        $("#barcode").val("");
      }
    },
    "json"
  ).fail(function (jqXHR, textStatus, errorThrown) {
    $("#barcode").val("");
  });
}

function cancel() {
  $.post(
    "Move/cancel",
    {},
    function (data) {
      if (data.success) {
        load_cart();
      } else {
        alert(data.message);
      }
    },
    "json"
  )
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.error("AJAX Error:", textStatus, errorThrown);
      alert("An error occurred while processing your request.");
    })
    .always(function () {
      $("#loader").hide();
      $("#overlay").hide();
    });
}

function load_cart() {
  $.post("Move/refreshCart", function (htmlData) {
    $("#list").html(htmlData);
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}

function delete_cart(cart_id) {
  $.post("Move/delete_cart", { cart_id: cart_id }, function (htmlData) {
    load_cart();
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}
