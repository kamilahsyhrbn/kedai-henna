// RAJA ONGKIR
$(document).ready(function () {
  $.ajax({
    url: "data-provinsi.php",
    type: "POST",
    success: function (data_provinsi) {
      $("select[name=provinsi]").html(data_provinsi);
    },
  });

  $("select[name=provinsi]").on("change", function () {
    var id_provinsi = $("option:selected", this).attr("id_provinsi");

    $.ajax({
      url: "data-distrik.php",
      type: "POST",
      data: "id_provinsi=" + id_provinsi,
      success: function (data_distrik) {
        $("select[name=distrik]").html(data_distrik);
      },
    });
  });

  $("select[name=ekspedisi]").on("change", function () {
    var dataDistrik = $("option:selected", "select[name=distrik]").attr(
      "id_distrik"
    );

    $.ajax({
      url: "data-paket.php",
      type: "POST",
      data: "distrik=" + dataDistrik,
      success: function (data_paket) {
        $("select[name=paket]").html(data_paket);
      },
    });
  });

  $("select[name=distrik]").on("change", function () {
    var prov = $("option:selected", this).attr("nama_provinsi");
    var dist = $("option:selected", this).attr("nama_distrik");
    var type = $("option:selected", this).attr("type_distrik");
    var pos = $("option:selected", this).attr("kode_pos");

    $("input[name=nama_provinsi]").val(prov);
    $("input[name=nama_distrik]").val(dist);
    $("input[name=type_distrik]").val(type);
    $("input[name=kode_pos]").val(pos);
  });

  $("select[name=paket]").on("change", function () {
    var paket = $("option:selected", this).attr("paket");
    var ongkir = $("option:selected", this).attr("ongkir");
    var etd = $("option:selected", this).attr("estimasi");

    $("input[name=paket]").val(paket);
    $("input[name=ongkir]").val(ongkir);
    $("input[name=estimasi]").val(etd);

    var formattedOngkir = ongkir
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $("#ongkir").text("ONGKOS KIRIM: Rp " + formattedOngkir);

    var totalPrice = document.getElementById("total-harga").value;
    totalPrice = parseInt(totalPrice) + parseInt(ongkir);
    var formattedTotalPrice = totalPrice
      .toString()
      .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    $("#total").text("TOTAL : Rp " + formattedTotalPrice);

    $("input[name=bayar]").val(totalPrice);
  });
});
