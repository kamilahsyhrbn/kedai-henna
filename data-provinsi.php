<?php

$curl = curl_init();

curl_setopt_array(
    $curl,
    array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
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
    $array_response = json_decode($response, true);
    $data_provinsi = $array_response['rajaongkir']['results'];

    echo "<option>Pilih Provinsi</option>";

    foreach ($data_provinsi as $key => $value) {
        echo "<option value='" . $value["province_id"] . "' id_provinsi='" . $value["province_id"] . "'>";
        echo $value["province"];
        echo "</option>";
    }
}

?>