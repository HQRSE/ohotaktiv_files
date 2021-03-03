<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("PRICE MAGIC");
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
/* *** */
$price_guid_1 = '06bbab18-4bff-11e5-80d3-001e67babba3';
$price_guid_5 = '834215fd-f164-11e8-80fa-001e67babba1';
$price_guid_6 = 'f9cc5119-5915-11e8-80e8-001e67babba2';
$price_guid_13 = 'abb2d90c-951d-11ea-8128-001e67babba1'; 
//$price_guides = array($price_guid_1, $price_guid_5, $price_guid_6, $price_guid_13);
/* *** */

if ($_GET['truncate']) {
	$tr_tb1 = 'TRUNCATE TABLE price_magic';
	$clear = $DB->Query($tr_tb1);
}

/*if ($_GET['gotobprice']) {
	$tr_tb = 'TRUNCATE TABLE b_catalog_price';
	$clear = $DB->Query($tr_tb);
	$merge_tables = 'INSERT INTO b_catalog_price (PRODUCT_ID, CATALOG_GROUP_ID, PRICE)
	SELECT REAL_ID, PRICE_ID, VALUE
	FROM price_magic';
	$start_merge = $DB->Query($merge_tables);
}*/

$file_count = $_GET['file_c'];

$h_counter = $_GET['h_counter']; // start h_counter = 0
$glob = glob("/var/www/sibirix2/data/www/ohotaktiv.ru/obmen_files/quantity/prices/big/*.xml");

echo "<br><br><br><br><br><br><a class='file_count' href='/12dev/prices/index.php?h_counter=0&file_c=0&truncate=yes'>>>> BEGIN (!!! BEFORE_TRUNCATE_TEMP_TABLES !!!) <<<</a><br><br><br>";

if ($file_count >= $all_files) { ?><br><br><br>
	<a class="file_count" href="/12dev/prices/gotobprice.php">!!! GO TO B_PRICE BEFORE TRUNCATE B_CATALOG_PRICE !!!</a>
<br><br><br><? }

$xml = new XMLReader();
$q_file = $glob[$file_count];
$xml->open($q_file);
$assoc = xml2assoc($xml);
//print_r($assoc);


echo "<p class='file_count'>file_count: ".count($glob)."</p><br>";
echo "<p class='file_name'>file: ".$q_file."</p>";
/* *** */
$load_time_start = mktime();

$all_items = count($assoc[0]['val']);
$all_files = count($glob);

$end = $all_items;
$step = 3000; // 4000; // 200

echo "<p class='all_items'>all items: ".$all_items."</p>";
$sql = '';
$sql = 'INSERT INTO price_magic (GUID,PRICE_ID,VALUE) VALUES ';
$code_go_sql = [];

while ($h_counter < $end) { 

	$guid_xml = str_replace(' ', '', $assoc[0]['val'][$h_counter]['atr']['GUID']);
	$code_go_sql[] = $guid_xml;
	$file_c = 0;
	while (count($assoc[0]['val'][$h_counter]['val'][0]['val']) > $file_c) {
		$value = 	$assoc[0]['val'][$h_counter]['val'][0]['val'][$file_c]['atr']['Value']; //
		$price_guid = $assoc[0]['val'][$h_counter]['val'][0]['val'][$file_c]['atr']['GUID'];
		if ($price_guid == $price_guid_5) {
			$price_guid = 5;
		} elseif ($price_guid == $price_guid_13) {
			$price_guid = 13;
		} elseif ($price_guid == $price_guid_1) {
			$price_guid = 1;
		} elseif ($price_guid == $price_guid_6) {
			$price_guid = 6;
		} 
		if ($value > 0) {
			$sql .=  '("'.$guid_xml.'",'.$price_guid.','.$value.'),';
		}
		$file_c++;
	}

	$z = $h_counter % $step;
	if ($z == 0) {
		$h_counter++;
		echo "<p class='h_counter'>h_counter_bla: ".$h_counter."</p>";
		header("refresh: 2; url=/12dev/prices/index.php?h_counter=$h_counter&file_c=$file_count");
		break;
	} 
	$h_counter++;
}
	$ins_sql = substr($sql,0,-1);
	echo "<br>ins_SQL: hide<br>"; /*$ins_sql*/
	$tb_insert = $DB->Query($ins_sql);

	/* *** */

   $arSelect = array(
      "ID","XML_ID"
   );
	//WHERE
   $arFilter = array(
	  "ACTIVE" => "Y", // Убираем если нужны и не активные товары
      "IBLOCK_ID" => 10,
      "ACTIVE_DATE" => "Y",
      "CHECK_PERMISSIONS" => "Y",
	  "XML_ID" => $code_go_sql
	);
	//ORDER BY
	$arSort = array(
      "ID" => "DESC",
   );

	$arResult["ITEMS"] = array();

	if ($code_go_sql) {
		$rsElements = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect);
		$full = array();
		$sql_u = '';
		$sql_u_n = '';
		$cur_code_ar = [];

   		while ($obElement = $rsElements->GetNextElement())
   		{
			$arItem = $obElement->GetFields();
			$cur_code_ar[] = $arItem['XML_ID'];
			$cur_code = $arItem['XML_ID'];
			$sql_u_n .= 'WHEN "'.$cur_code.'" THEN '.$arItem['ID'].' ';
   		}

		if ($cur_code_ar) {
			$sql_u .= 'UPDATE price_magic SET REAL_ID = CASE GUID ';
			$sql_u .= $sql_u_n;
			$sql_u .= 'ELSE REAL_ID END ';
			//$sql_u .= 'WHERE GUID IN ('.implode(",", $cur_code_ar).')'; 
			$tb_update = $DB->Query($sql_u);
			$sql_trash = 'DELETE FROM price_magic WHERE REAL_ID = "0"';
			$tb_trash = $DB->Query($sql_trash);
		}


	}
	echo '<br>UPD_SQL: hide<br><br><br>'; // *$sql_u*

	if ($h_counter >= $end && $file_count < $all_files) {
		$file_count++;
		header("refresh: 2; url=/12dev/prices/index.php?h_counter=0&file_c=$file_count");
	}

/*if ($file_count >= $all_files) {
	//$tr_tb = 'TRUNCATE TABLE b_catalog_price'; // this fckn shit!

	/* *dont*touch*me* */
/*	$arFilter = array(
		'IBLOCK_ID' => 41,
	);
	$res = CIBlockElement::GetList(array(), $arFilter, false, false, array('ID'));
	$ids = [];
	while ($element = $res->GetNext()) {
		$ids[] = $element['ID'];
	}
	$implode = implode(',',$ids);
	$del = 'delete from b_catalog_price where PRODUCT_ID not in ($implode)';
	$go_delete = $DB->Query($del);
	/* *** */
	//$clear = $DB->Query($tr_tb);
/*	$merge_tables = 'INSERT INTO b_catalog_price (PRODUCT_ID, CATALOG_GROUP_ID, PRICE)
	SELECT REAL_ID, PRICE_ID, VALUE
	FROM price_magic';
	$start_merge = $DB->Query($merge_tables);
	$scale_tb = 'UPDATE b_catalog_price CPR
	INNER JOIN b_catalog_currency CC ON CC.CURRENCY = CPR.CURRENCY
	SET CPR.PRICE_SCALE = CPR.PRICE*CC.CURRENT_BASE_RATE';
	$start_scale = $DB->Query($scale_tb);
	/* *** */
/*	$staticHtmlCache = \Bitrix\Main\Data\StaticHtmlCache::getInstance();
	$staticHtmlCache->deleteAll();
}*/

?>

</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
