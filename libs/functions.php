<?php
function getAPIReqHis($req_his_cd)
{
    // $json    = $this->inputJson("req_his", "aws");
    $json = '
                {
                    "req_his":{
                        "data":[
                            {"name":"req_his_cd","value":%s,"operator":"="},
                        ],
                        "fields":"user_cd,users,req_his_cd,print_ymd,req_syu_kb,req_syu_nm,req_his_sumi_fg,req_his_sumi_nm,seikyu",
                        "sort":"print_ymd desc",
                    },
                    "req_his_d":{
                        "data":[
                            {"name":"un_syu_kb","value":"1,2,3","operator":"in"}
                        ],
                        "fields":"req_his_dno,un_syu_kb,un_syu_nm,hs_ymd,d_no,dm_no,ushin_cd,shin_nm,uri_tan,uri_su,hon_kin,zei_kin,zei_ritu"
                    },
                }
            ';
    $json = sprintf($json, $req_his_cd);

    $req_his = GetAPIData("req_his", $json, "GET");
    // $req_his = TFP::GetAPIDataAWS("req_his", $json, "GET");


    if ( $req_his["count"] == 0 ) {
        return "";
    }

    return $req_his;
}

function numberFormat($number): string
{
    return (Int)$number ? number_format($number) : "0";
}

function insertHyphen($user_cd): string {
    return $user_cd ? preg_replace('/(\d{4})(\d{6})(\d)/', '$1-$2-$3', $user_cd) : "";
}

function formatDate($dateTimeString, $changeFormat = "Y-m-d", $flag = false){
    $date = new DateTime($dateTimeString);
    $date = $date->format($changeFormat);

    return $flag ? changeFormat($date, $changeFormat) : $date;


}

function changeFormat($date, $changeFormat) {
    switch ($changeFormat) {
        case 'Y-m-d':
        case 'Y/m/d':
            return preg_replace('/^((((19|[2-9]\d)\d{2}).+(0[13578]|1[02]).+(0[1-9]|[12]\d|3[01]))|(((19|[2-9]\d)\d{2}).+(0[13456789]|1[012])\/(0[1-9]|[12]\d|30))|(((19|[2-9]\d)\d{2})\/02\/(0[1-9]|1\d|2[0-8]))|(((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))\/02\/29))$/', '$3年$5月$6日', $date);            
        case 'd-m-Y':
        case 'd/m/Y':
            return preg_replace('/^(((0[1-9]|[12]\d|3[01]).+(0[13578]|1[02]).+((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30).+(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/', '$3日$4月$5年', $date);
    }
    return $date;
}

function calculatorTax($req_his_d)
{
    $listDuplicate = [];
    $listSum       = [];
    $listSpectify  = [];

    $sum_hon_kin            = [];
    $sum_zei_ritu           = [];
    $listSum["sum_hon_kin"] = 0;
    $listSum["sum_zei_kin"] = 0;

    foreach ( $req_his_d as $key => $value ) {
        $zei_ritu = $value["zei_ritu"];

        if ( in_array($zei_ritu, $listDuplicate) ) {
            $listDuplicate[]         = $zei_ritu;
            $sum_hon_kin[$zei_ritu] += $value["hon_kin"];
            $sum_zei_ritu[$zei_ritu] += $value["zei_kin"];

        } else {
            $listDuplicate[]         = $zei_ritu;
            $sum_hon_kin[$zei_ritu]  = $value["hon_kin"];
            $sum_zei_ritu[$zei_ritu] = $value["zei_kin"];

        }
        $listSpectify[$zei_ritu]["sum_spectify_hon_kin"] = $sum_hon_kin[$zei_ritu];
        $listSpectify[$zei_ritu]["sum_spectify_zei_kin"] = $sum_zei_ritu[$zei_ritu];
        $listSpectify[$zei_ritu]["zei_kin"]              = $zei_ritu;

        $listSum["sum_hon_kin"] += $value["hon_kin"];
        $listSum["sum_zei_kin"] += $value["zei_kin"];
    }

    $listSum["sum"]          = $listSum["sum_zei_kin"] + $listSum["sum_hon_kin"];
    $listSum["sum_spectify"] = $listSpectify;
    return $listSum;
}

function testCalculatorTax1($req_his_d): array
{
    $zei_ritu     = $req_his_d[0]["zei_ritu"];
    $listReq      = [];
    $sum_hon_kin  = 0;
    $sum_zei_ritu = 0;
    $listSum      = [];
    //list zei_ritu
    $list_zei_ritu = array_map(function ($val) {
        return $val["zei_ritu"];
    }, $req_his_d);
    $unique        = array_unique($list_zei_ritu);


    $list_zei_rituTest = array_map(function ($val) {
        $arr             = [];
        $arr["zei_ritu"] = $val["zei_ritu"];
        $arr["hon_kin"] = $val["hon_kin"];
        $arr["zei_kin"] = $val["zei_kin"];

        return $arr;
    }, $req_his_d);

    $listSum["sum_hon_kin"] = 0;
    $listSum["sum_zei_kin"] = 0;
    foreach ( $unique as $key1 => $value1 ) {
        $sum_hon_kin = 0;
        $sum_zei_kin = 0;

        foreach ( $list_zei_rituTest as $key2 => $value2 ) {
            if ( $value2["zei_ritu"] == $value1 ) {
                $sum_hon_kin += $value2["hon_kin"];
                $sum_zei_kin += $value2["zei_kin"];
            }
        }
        $listSum["sum_hon_kin"] += $sum_hon_kin;
        $listSum["sum_zei_kin"] += $sum_zei_kin;

        $listSum[$key1]["sum_spectify_hon_kin"] = $sum_hon_kin;
        $listSum[$key1]["sum_spectify_zei_kin"] = $sum_zei_kin;
        $listSum[$key1]["zei_ritu"]             = $value1;
        // $listReq[] = $value["zei_ritu"];
    }
    $listSum["sum"] = $listSum["sum_hon_kin"] + $listSum["sum_zei_kin"];

    return $listSum;
}


function GetAPIDataBK($api, $json, $request)
{
    $STFSApiAccessURI = "https://api.ot.tf-dev.sorimachi.me";
    $STFSApiAccessID  = "hp_api_id";
    $STFSApiAccessPW  = "hp_api_pass";
    $port = (strpos($STFSApiAccessURI, ":") !== false) ? explode(":", $STFSApiAccessURI)[1] : "80";
    $port = (strpos($port, "/") !== false) ? explode("/", $STFSApiAccessURI)[0] : $port;

    $curl = curl_init();
    curl_setopt_array(
        $curl,
        array(
            CURLOPT_PORT           => $port,
            CURLOPT_URL            => $STFSApiAccessURI . "/api/" . $api,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $request,
            CURLOPT_POSTFIELDS     => $json,
            CURLOPT_HTTPHEADER     => array(
                "Accept: */*",
                "Cache-Control: no-cache",
                "Content-Type: application/json",
                "Host: " . str_replace(array( "http://", "https://" ), "", $STFSApiAccessURI),
                "X-Authorization: " . base64_encode($STFSApiAccessID . ":" . $STFSApiAccessPW)
            ),
            "X-HTTP-Method-Override: " . $request
        )
    );

    $response = json_decode(curl_exec($curl), true);
    $err      = curl_error($curl);
    curl_close($curl);
    return ($err) ? "Error #:" . $err : $response;
}

function GetAPIData($api, $json, $request) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://www.hp-sorizo.apn.mym.sorimachi.biz/TFP/test1.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array(
            'api'  => $api,
            'json' => $json,
            'method' => $request,
        )),
        CURLOPT_CONNECTTIMEOUT => 0,
        CURLOPT_TIMEOUT => 4000,
        CURLOPT_HTTPHEADER => array(
            "Accept: */*",
            "Cache-Control: no-cache",
            "Content-Type: application/json",
            "X-HTTP-Method-Override: POST"
    )));

    $response = curl_exec($curl);
    $response = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response);
    $response = json_decode($response, true);
    curl_close($curl);

    return $response;
}
function GetFirstByField($res, $field, $parr = "")
{
    if (
        ($field == "error" || $field == "err_msg") &&
        $parr == "" && count($res) == 2 && $res["message"] != ""
    ) {
        return $res["message"];
    }
    if ( $parr == $field ) {
        return $res;
    }
    foreach ( $res as $key => $val ) {
        if ( is_array($val) ) {
            $parr = ($key == "0") ? $parr : $key;
            $val  = GetFirstByField($val, $field, $parr);
            if ( $val != "" ) {
                return $val;
            }
        } elseif ( $key == $field ) {
            return $val;
        }
    }
    return "";
}

function GetYMD($res, $field, $parr = "", &$count = 0, &$arr = [])
{
    $tmp = "";
    if (($field == "error" || $field == "err_msg") &&
        $parr == "" && count($res) == 2 && $res["message"] != ""
    ) {
        return $res["message"];
    }
    if ($parr == $field) {
        return $res;
    }
    foreach ($res as $key => $val) {
        if (is_array($val)) {
            $parr = ($key == "0") ? $parr : $key;
            $val = GetYMD($val, $field, $parr, $count, $arr);
            if ($val != "") {
                return $val;
            }
        }elseif ($key == $field) {
            // print_r("key: " . $val);
            $arr[] = $val;
            $count += 1;
        }
    }
    return "";
}
function MaxYMD(&$arrYMD)
{
    usort($arrYMD, function($a, $b) {
        $dateTimestamp1 = strtotime($a);
        $dateTimestamp2 = strtotime($b);
    
        return $dateTimestamp1 < $dateTimestamp2 ? -1: 1;
    });
}

function setPrice($list)
{
    $price = "";
    foreach ( $list as $key => $val ) {
        $price .= '<tr>
                            <td style="" colspan="4"></td>
                            <td style="background-color: #F2F2F2" align="center" class="">' . $val["zei_kin"] . '％対象分</td>
                            <td align="right" class="">' . numberFormat($val["sum_spectify_hon_kin"]) . ' 円</td>
                        </tr>';
    }
    return $price;
}

function setTax($list)
{
    $tax = "";
    foreach ( $list as $key => $val ) {
        $tax .= '<tr>
                        <td style="" colspan="4"></td>
                        <td style="background-color: #F2F2F2" align="center" class="">' . $val["zei_kin"] . '％対象分</td>
                        <td align="right" class="">' . numberFormat($val["sum_spectify_zei_kin"]) . ' 円</td>
                    </tr>';
    }
    return $tax;
}

function createRow($list){
    $row = "";
    foreach ( $list as $key => $val ) {
        $row .= '<tr>
                    <td class="solid-left solid-right">'. formatDate($val["hs_ymd"], "Y/m/d") .'</td>
                    <td class="table__row-1 solid-right">'. $val["d_no"] .'</td>
                    <td class="table__row-1 solid-left solid-right">'. $val["shin_nm"] .'</td>
                    <td align="right" class="table__row-1 solid-left solid-right">'. $val["uri_su"] .'</td>
                    <td align="right" class="table__row-1 solid-left solid-right">'. numberFormat($val["uri_tan"]) .' 円</td>
                    <td align="right" class="table__row-1 solid-right">'. numberFormat($val["hon_kin"]) .' 円</td>
                </tr>';
    }
    return $row;
}
?>
