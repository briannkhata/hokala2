

$("#refreshSale").on("click", function () {
  $("table#cart tbody tr").each(function () {
    var quantity = $(this).find(".quantity").val();
    var cartId = $(this).find("input[name='cart_id[]']").val();
    $.ajax({
      url: "Sale/update_cart",
      type: "POST",
      data: { cart_id: cartId, qty: quantity },
      dataType: "json",
      success: function (response) {
        load_cart();
        console.log(response);
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
      },
    });
  });
});

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



$("#clearCart").click(function (e) {
  var confirmed = confirm("Are you sure you want to CLEAR CART?");
  if (confirmed) {
    cancel();
  } else {
    e.preventDefault();
  }
});

$("#finish").click(function (e) {
  finish();
});

$("#tendered").on("input", function () {
  var tenderedAmount = parseFloat(
    $(this)
      .val()
      .replace(/[^\d.]/g, "")
  );
  var totalBill = parseFloat(
    $("#totalBill")
      .text()
      .replace(/[^\d.]/g, "")
  );
  if (tenderedAmount > 0) {
    var change = tenderedAmount - totalBill;
    change = Math.round(change * 100) / 100;
    var formattedChange = change
      .toFixed(2)
      .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    $("#change").text("CHANGE: " + formattedChange);
    $("#change").show();
  } else {
    $("#change").hide();
  }
});

function finish() {
  var tenderedAmount = $("#tendered").val();
  tenderedAmount = parseFloat(tenderedAmount.replace(/[^\d.-]/g, ""));

  if (!tenderedAmount || isNaN(tenderedAmount)) {
    alert("Please enter a valid tendered amount.");
    return;
  }

  $.post("Sale/finish_sale", {
    tendered: tenderedAmount,
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.log("AJAX Error:", textStatus, errorThrown);
    alert("An error occurred while processing your request.");
  });
}



function search() {
  $.post(
    "Sale/refresh_cart",
    {
      barcode: $("#barcode").val(),
    },
    function (data) {
      if (data.success) {
        $("#barcode").val("");
        load_cart();
      } else {
        alert(data.message);
        $("#barcode").val("");
      }
    },
    "json"
  ).fail(function (jqXHR, textStatus, errorThrown) {
    console.log("AJAX Error:", textStatus, errorThrown);
    alert("An error occurred while processing your request.");
    $("#barcode").val("");
  });
}

function total_bill() {
  var sum = 0;
  $("#cart tbody tr").each(function () {
    var total = parseFloat($(this).find("td:eq(4)").text());
    sum += total;
  });
  $("#totalSum").html(sum);
}

function cancel() {
  $("#loader").show();
  $("#overlay").show();
  $.post(
    "Sale/cancel",
    {},
    function (data) {
      if (data.success) {
        alert(data.message);
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
  $.post("Sale/refreshCart", function (htmlData) {
    $("#list").html(htmlData);
    refresh_total_bill();
    refresh_sub_total();
    refresh_vat_total();
    //$('#change').text('');
    $("#tendered").val("");
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}

function refresh_total_bill() {
  $.post("Sale/refresh_total_bill", function (htmlData) {
    $("#totalBill").html(htmlData);
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}

function refresh_sub_total() {
  $.post("Sale/refresh_sub_total_bill", function (htmlData) {
    $("#sub").html(htmlData);
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}

function refresh_vat_total() {
  $.post("Sale/refresh_total_vat", function (htmlData) {
    $("#vat").html(htmlData);
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}

function delete_cart(cart_id) {
  $.post("Sale/delete_cart", { cart_id: cart_id }, function (htmlData) {
    load_cart();
    refresh_total_bill();
    refresh_sub_total();
    refresh_vat_total();
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}
