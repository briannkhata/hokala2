// $("#refreshReceive").on("click", function () {
//   $("table#cart tbody tr").each(function () {
//     var quantity = $(this).find(".quantity").val();
//     var cartId = $(this).find("input[name='cart_id[]']").val();
//     $.ajax({
//       url: "Receive/update_cart",
//       type: "POST",
//       data: { cart_id: cartId, qty: quantity },
//       dataType: "json",
//       success: function (response) {
//         load_cart();
//         console.log(response);
//       },
//       error: function (xhr, status, error) {
//         console.error(xhr.responseText);
//       },
//     });
//   });
// });

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

// function finish() {
//   var tenderedAmount = $("#tendered").val();
//   var client_id = $("#client_id").val();
//   var payment_type_id = $("#payment_type_id").val();
//   var details = $("#details").val();
//   tenderedAmount2 = parseFloat(tenderedAmount.replace(/,/g, ""));

//   if (!tenderedAmount2 || isNaN(tenderedAmount2)) {
//     alert("Please enter a valid tendered amount.");
//     return;
//   }
//   $.post("Receive/finish_Receive", {
//     tendered: tenderedAmount2,
//     client_id: client_id,
//     payment_type_id: payment_type_id,
//     details: details,
//   }).fail(function (jqXHR, textStatus, errorThrown) {
//     console.log("AJAX Error:", textStatus, errorThrown);
//     alert("An error occurred while processing your request.");
//   });
// }

function finish() {
  var tenderedAmount = $("#tendered").val();
  var client_id = $("#client_id").val();
  var payment_type_id = $("#payment_type_id").val();
  var details = $("#details").val();
  tenderedAmount2 = parseFloat(tenderedAmount.replace(/,/g, ""));

  if (!tenderedAmount2 || isNaN(tenderedAmount2)) {
    alert("Please enter a valid tendered amount.");
    return;
  }
  $.post("Receive/finish_Receive", {
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
    "Receive/refresh_cart",
    {
      barcode: $("#barcode").val()
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
    //console.log("AJAX Error:", errorThrown);
    $("#barcode").val("");
  });
}



function cancel() {
  $.post(
    "Receive/cancel",
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
  $.post(
    "Receive/refreshCart",
    function (htmlData) {
      $("#list").html(htmlData);
      refresh_total_bill();
      //refresh_sub_total();
      //refresh_vat_total();
      //$('#change').text('');
      //$("#tendered").val("");
    }
  ).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}

function refresh_total_bill() {
  $.post(
    "Receive/refresh_total_bill",
    function (htmlData) {
      $("#totalBill").html(htmlData);
    }
  ).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}

// function refresh_sub_total() {
//   $.post(
//     "Receive/refresh_sub_total_bill",
//     { client_id: $("#client_id").val() },
//     function (htmlData) {
//       $("#sub").html(htmlData);
//     }
//   ).fail(function (jqXHR, textStatus, errorThrown) {
//     console.error("AJAX Error:", textStatus, errorThrown);
//   });
// }

// function refresh_vat_total() {
//   $.post(
//     "Receive/refresh_total_vat",
//     { client_id: $("#client_id").val() },
//     function (htmlData) {
//       $("#vat").html(htmlData);
//     }
//   ).fail(function (jqXHR, textStatus, errorThrown) {
//     console.error("AJAX Error:", textStatus, errorThrown);
//   });
// }

function delete_cart(cart_id) {
  $.post("Receive/delete_cart", { cart_id: cart_id }, function (htmlData) {
    load_cart();
    refresh_total_bill();
  }).fail(function (jqXHR, textStatus, errorThrown) {
    console.error("AJAX Error:", textStatus, errorThrown);
  });
}
