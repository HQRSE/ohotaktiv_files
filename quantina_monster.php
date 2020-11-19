<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("QUANTINA");
?>
  <style>
   .quantity_page_style { 
    font-size: 12px; 
    color: #333366; 
   }
   .file_count, .sh_guid, .sh_qty__ins, .step_time {
    color: #f0f; 
   }
   .file_name, .id_prod, .sh_id {
    color: #00f; 
   }
   .all_items, .sh_qty, .h_counter {
    color: #c30; 
   }
   .repeat {
    margin-top: 20px;
    color: #0f0; 
    font-weight: 600;
    font-size: 14px; 
    float: left;
   }
  </style>

<main class="catalog-page category-catalog-page quantity_page_style centering" id="start">

<?
function xml2assoc(&$xml){
    $assoc = array();
    $n = 0;
    while($xml->read()){
        if($xml->nodeType == XMLReader::END_ELEMENT) break;
        if($xml->nodeType == XMLReader::ELEMENT and !$xml->isEmptyElement){
            $assoc[$n]['name'] = $xml->name;
            if($xml->hasAttributes) while($xml->moveToNextAttribute()) $assoc[$n]['atr'][$xml->name] = $xml->value;
            $assoc[$n]['val'] = xml2assoc($xml);
            $n++;
        }
        else if($xml->isEmptyElement){
            $assoc[$n]['name'] = $xml->name;
            if($xml->hasAttributes) while($xml->moveToNextAttribute()) $assoc[$n]['atr'][$xml->name] = $xml->value;
            $assoc[$n]['val'] = "";
            $n++;               
        }
        else if($xml->nodeType == XMLReader::TEXT) $assoc = $xml->value;
    }
    return $assoc;
}

$glob = glob("/var/www/sibirix2/data/www/ohotaktiv.ru/obmen_files/quantity/*.xml");

echo "<br><br><br><a class='file_count' href='/12dev/quantity/qua_visual.php?h_counter=0&file_c=0&truncate=yes'>>>> BEGIN (!!!BEFORE_TRUNCATE_TWO_TABLES!!!) <<<</a><br><br><br>";

echo "<p class='file_count'>file_count: ".count($glob)."</p><br>";

if ($_GET['truncate']) {
$tr_tb1 = 'TRUNCATE TABLE quantina';
$tr_tb2 = 'TRUNCATE TABLE b_catalog_store_product';
	$clear = $DB->Query($tr_tb1);
	$clear2 = $DB->Query($tr_tb2);
}

$file_count = $_GET['file_c'];

$h_counter = $_GET['h_counter']; // start h_counter = 0

$xml = new XMLReader();

$q_file = $glob[$file_count];

$xml->open($q_file);
$assoc = xml2assoc($xml);

//print_r($assoc);

echo "<p class='file_name'>file: ".$q_file."</p>";
/* *** */
$load_time_start = mktime();

$all_items = count($assoc[0]['val']);
$all_files = count($glob);

$end = $all_items;
$step = 150; // 200

$the_word = "IZ-";

echo "<p class='all_items'>all items: ".$all_items."</p>";
$sql = '';
$sql = 'INSERT INTO quantina (CODE,SHOP,QUANTITY) VALUES ';
$code_go_sql = [];
while ($h_counter < $end) { 

	$code_xml = str_replace(' ', '', $assoc[0]['val'][$h_counter]['atr']['GUID']);

	//if(strpos($code_xml, $the_word) !== false) { continue; } else {

	$code = $code_xml;
	$code_go_sql[] = $code;

	$file_c = 0;
	while (count($assoc[0]['val'][$h_counter]['val'][0]['val']) > $file_c) {
		$qty = 	$assoc[0]['val'][$h_counter]['val'][0]['val'][$file_c]['atr']['Quantity']; //
		$shop_guid = $assoc[0]['val'][$h_counter]['val'][0]['val'][$file_c]['atr']['GUID'];
		//echo "guid: ".$shop_guid."<<< <br>";
		if ($shop_guid == '3934afd9-db2e-4e40-be95-232d6c1c8947') {
			$shop_id = 5;
		} elseif ($shop_guid == '84d58d66-88c5-11e8-80e4-c86000606f92') {
			$shop_id = 6;
		} elseif ($shop_guid == '88abc5c0-b724-11e8-80eb-c86000606f92') {
			$shop_id = 8;
		} elseif ($shop_guid == '69cb9bd8-ecac-11e3-0196-c86000606f92') {
			$shop_id = 9;
		} elseif ($shop_guid == '17f7624a-09fb-11ea-8101-c86000606f92') {
			$shop_id = 10;
		} elseif ($shop_guid == '1c9db366-3069-4d75-bcfd-6e2f7852e042') {
			$shop_id = 11;
		} elseif ($shop_guid == '64b50e98-3d94-11e4-0e9c-c86000606f92') {
			$shop_id = 12;
		} elseif ($shop_guid == 'e1997b58-e49b-11e3-178c-c86000606f92') {
			$shop_id = 13;
		} elseif ($shop_guid == 'c8b911ce-74b1-11e4-2090-c86000606f92') {
			$shop_id = 15;
		} elseif ($shop_guid == '23bee1ba-8f4d-11e4-2f98-c86000606f92') {
			$shop_id = 16;
		} elseif ($shop_guid == 'ba9b7b20-31a1-11e4-4c86-c86000606f92') {
			$shop_id = 17;
		} elseif ($shop_guid == '3427d668-7992-11e4-509f-c86000606f92') {
			$shop_id = 19;
		} elseif ($shop_guid == '73c7e84c-8173-11e4-509f-c86000606f92') {
			$shop_id = 20;
		} elseif ($shop_guid == '280b2abe-905a-4641-80d5-58b957fc4033') {
			$shop_id = 21;
		} elseif ($shop_guid == '7381a6fa-7aff-4568-8149-a27171ea92b0') {
			$shop_id = 143;
		} elseif ($shop_guid == 'c73c0bbe-12b4-4e88-9545-b589fad8eede') {
			$shop_id = 144;
		} elseif ($shop_guid == '1e8bba16-ea1f-11e3-869e-c86000606f92') {
			$shop_id = 146;
		} elseif ($shop_guid == '149e973f-418e-4fe1-8908-a88317ebbdcb') {
			$shop_id = 147;
		} elseif ($shop_guid == 'cf74acc9-ebb2-41a4-897c-2d457b19dd53') {
			$shop_id = 148;
		} elseif ($shop_guid == '5166c33d-2959-4323-8be2-a17b6c0674cf') {
			$shop_id = 149;
		} elseif ($shop_guid == '74fb13f9-f548-430e-8ce2-e45600a1db84') {
			$shop_id = 150;
		} elseif ($shop_guid == 'c62fd75f-c258-4abf-8fc7-bbb4651ab21c') {
			$shop_id = 151;
		} elseif ($shop_guid == '58c9e24a-457c-45f6-9190-6cf199580af7') {
			$shop_id = 153;
		} elseif ($shop_guid == 'd00ba26b-dcd4-4f1b-9660-93dd6b946832') {
			$shop_id = 155;
		} elseif ($shop_guid == '2ed648c5-017b-4750-9e93-82cc6a767e62') {
			$shop_id = 159;
		} elseif ($shop_guid == '778dc3b1-c46a-4123-a09d-0c0df6ddd12f') {
			$shop_id = 160;
		} elseif ($shop_guid == '871af989-f6ec-4076-a22f-fbbe2219264d') {
			$shop_id = 162;
		} elseif ($shop_guid == 'd3700ac8-c61e-4bf2-a3ec-7d8c09974689') {
			$shop_id = 163;
		} elseif ($shop_guid == 'ce3d89a0-3070-4d76-a53e-09fa3fc1f4d5') {
			$shop_id = 164;
		} elseif ($shop_guid == '5b7c4c8c-6314-4644-a8e7-0e76b7824bff') {
			$shop_id = 166;
		} elseif ($shop_guid == '0954ba84-314b-451b-aac4-7757a12da5e4') {
			$shop_id = 168;
		} elseif ($shop_guid == '382554df-51a5-47fe-ac69-d07839d91950') {
			$shop_id = 169;
		} elseif ($shop_guid == '4b3688d8-10af-11e8-80db-c86000606f92') {
			$shop_id = 170;
		} elseif ($shop_guid == '8f1edb2e-53a5-11e4-1997-c86000606f92') {
			$shop_id = 171;
		} elseif ($shop_guid == '31ca54a4-b398-4c1e-b04a-18e3ee73750e') {
			$shop_id = 172;
		} elseif ($shop_guid == 'e515df40-89e7-4823-b26b-c3e4ceaee961') {
			$shop_id = 174;
		} elseif ($shop_guid == '350ffe62-84b0-43af-b2c7-adf8366871d3') {
			$shop_id = 175;
		} elseif ($shop_guid == '1de35f32-0cee-11e4-b397-c86000606f92') {
			$shop_id = 176;
		} elseif ($shop_guid == 'ac6b7bf7-f4eb-4bcb-b3be-a71abe2c4e11') {
			$shop_id = 177;
		} elseif ($shop_guid == '1d387d1c-05f2-4123-b459-21a1e792f258') {
			$shop_id = 178;
		} elseif ($shop_guid == 'e365450a-488e-4e36-b56b-7ea3b2823e2b') {
			$shop_id = 179;
		} elseif ($shop_guid == 'bbb810af-6041-41f0-bb5f-9d8a4d1b0afd') {
			$shop_id = 181;
		} elseif ($shop_guid == '3729a1d9-5a06-492e-bb72-7998c52107c4') {
			$shop_id = 183;
		} elseif ($shop_guid == 'cfe0370c-3cf1-416d-bbcc-81175ee29548') {
			$shop_id = 184;
		} elseif ($shop_guid == '9e6471ab-3d71-4ff1-bfb4-67242783e299') {
			$shop_id = 187;
		} elseif ($shop_guid == '3c37c690-1c65-11e4-eb90-c86000606f92') {
			$shop_id = 188;
		} elseif ($shop_guid == 'bc124ef8-4d25-11e4-fc93-c86000606f92') {
			$shop_id = 189;
		} elseif ($shop_guid == 'e2d59019-086b-44ac-b757-c5867e708ad5') {
			$shop_id = 190;
		} elseif ($shop_guid == '1dfab4e7-7f71-4550-9c0d-faea216db82e') {
			$shop_id = 191;
		} elseif ($shop_guid == '133f2de2-c0e0-11e1-8380-50e549b397c6') {
			$shop_id = 192;
		} elseif ($shop_guid == '8d39edce-2f94-4158-af09-7890183ccd6f') {
			$shop_id = 193;
		} elseif ($shop_guid == 'ad7e7966-cd7f-11e1-4d85-50e549b397c6') {
			$shop_id = 194;
		} elseif ($shop_guid == '179f74ac-ea1c-11e3-9d8e-c86000606f92') {
			$shop_id = 197;
		} elseif ($shop_guid == '8f85ce56-646a-11ea-8106-c86000606f92') {
			$shop_id = 198;
		} else {
			$shop_id = 0;
		}

	$sql .=  '("'.$code.'",'.$shop_id.','.$qty.'),';
	$file_c++;
	}
		//}
	$z = $h_counter % $step;
	//echo "z: ".$z."<br>";
	if ($z == 0) {
		$h_counter++;
		echo "<p class='h_counter'>h_counter_bla: ".$h_counter."</p>";
		header("refresh: 2; url=/12dev/quantity/qua_visual.php?h_counter=$h_counter&file_c=$file_count");
		break;
	} 
		$h_counter++;
}
	$ins_sql = substr($sql,0,-1);
	echo "ins_SQL: ".$ins_sql."<br>";

$tb_insert = $DB->Query($ins_sql);

   $arSelect = array(
      "ID","PROPERTY_CML2_TRAITS"
   );
	//WHERE
   $arFilter = array(
	"ACTIVE" => "Y",
      "IBLOCK_ID" => 10,
      "ACTIVE_DATE" => "Y",
      "ACTIVE" => "Y",
      "CHECK_PERMISSIONS" => "Y",
	  "PROPERTY_CML2_TRAITS" => $code_go_sql
	);
	//echo "==========================<br>";
	//print_r($arFilter);
	//echo "==========================<br>";
	//ORDER BY
	$arSort = array(
      "ID" => "DESC",
   );

	$arResult["ITEMS"] = array();

	if ($code_go_sql) {
		$rsElements = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
		$full = array();
		//$h = 0;
		$sql_u = '';
		$sql_u_n = '';
		$cur_code_ar = [];

   	while ($obElement = $rsElements->GetNextElement())
   	{
		$arItem = $obElement->GetFields();
		$cur_code_ar[] = $arItem['PROPERTY_CML2_TRAITS_VALUE'];
		$cur_code = $arItem['PROPERTY_CML2_TRAITS_VALUE'];
		$sql_u_n .= 'WHEN '.$cur_code.' THEN '.$arItem['ID'].' ';
	   /* *** */
	   //print_r($arItem);
	   /* *** */
	   //$h++;
   }

	if ($cur_code_ar) {
		$sql_u .= 'UPDATE quantina SET REAL_ID = CASE CODE ';
		$sql_u .= $sql_u_n;
		$sql_u .= 'ELSE REAL_ID END ';
		$sql_u .= 'WHERE CODE IN ('.implode(",", $cur_code_ar).')'; 
		$tb_update = $DB->Query($sql_u);
	}

}
/* ******************************************************************************************************************************************** */
//print_r($code_go_sql);
//echo "fcK: ".implode(",", $code_go_sql)."<br>";
	echo "<br>**********************************************************************************************************************************<br>";
	//SELECT

echo '<br>UPD_SQL: '.$sql_u.' <-- SQL_2<br>';

/* ********************************************************* */



/* *** */
if ($h_counter >= $end && $file_count < $all_files) {
	$file_count++;
	$sql_trash = 'DELETE FROM quantina WHERE REAL_ID = "0"';
	$tb_trash = $DB->Query($sql_trash);
	$merge_sql = 'REPLACE INTO b_catalog_store_product (ID, PRODUCT_ID, AMOUNT, STORE_ID) SELECT ID, REAL_ID, QUANTITY, SHOP FROM quantina';
	$tb_merge = $DB->Query($merge_sql);

	header("refresh: 2; url=/12dev/quantity/qua_visual.php?h_counter=0&file_c=$file_count");
}

echo "<p class='h_counter'>h_counter_end: ".$h_counter."</p>";

?>

</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
