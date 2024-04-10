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
  e.preventDefault();
  if (confirm("Are you sure you want to clear the cart?")) {
    cancel();
  } else {
    console.log("Clear cart canceled.");
  }
});

$("#finish_move").click(function (e) {
  finish_moving();
});

function finish_moving() {
  var move_to = $("#move_to").val();
  var receiver = $("#receiver").val();

  $("#loader").show();
  $("#overlay").show();

  var from_shop = $("#from_shop").val();
  var to_shop = $("#to_shop").val();
  var from_wh = $("#from_wh").val();
  var to_wh = $("#to_wh").val();
  var description = $("#description").val();

  $.post("Move/finish_moving", {
    move_to: move_to,
    from_shop: from_shop,
    to_shop: to_shop,
    from_wh: from_wh,
    to_wh: to_wh,
    receiver: receiver,
    description: description,
    receiver: receiver
  })
    .done(function (data) {
      alert("Moving the stock done successfully");
      load_cart();
      $("#loader").hide();
      $("#overlay").hide();
    })
    .fail(function (jqXHR, textStatus, errorThrown) {
      console.log("AJAX Error:", textStatus, errorThrown);
      alert("An error occurred while processing your request." + errorThrown);
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
