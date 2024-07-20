<?php

$distrik = $_POST["distrik"];

$curl = curl_init();

curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=154&destination=" . $distrik . "&weight=500&courier=jne",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: c6f96e6df4f2ab96e494256a62fb2a13"
        ),
    )
);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    // echo $response;
    $array_response = json_decode($response, true);
    $data_paket = $array_response['rajaongkir']['results']['0']['costs'];

    // echo "<pre>";
    // print_r($data_paket);
    // echo "<pre/>";

    echo "<option>Pilih Jasa Pengiriman</option>";

    foreach ($data_paket as $key => $value) {
        echo "<option
        paket='" . $value["service"] . "'
        ongkir='" . $value["cost"]["0"]["value"] . "'
        estimasi='" . $value["cost"]["0"]["etd"] . "'
        >";
        echo $value["service"] . " ";
        echo number_format($value["cost"]["0"]["value"]) . " ";
        echo $value["cost"]["0"]["etd"] . " hari";
        echo "</option>";
    }
}