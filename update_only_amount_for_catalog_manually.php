<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("CATALOG UPDATE MACHINE");
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
$IBLOCK = 10;
$glob = glob("/var/www/sibirix2/data/www/ohotaktiv.ru/obmen_files/quantity/catalog/*.xml");

$file_count = $_GET['file_c'];
$h_counter = $_GET['h_counter']; // <-----------------------------------------------------------------------------------------------

$xml = new XMLReader();
$q_file = $glob[$file_count];
$xml->open($q_file);
$assoc = xml2assoc($xml);
/* ***************************** *** *** *** *** ********************************** */
/* ***************************** *** *** *** *** ********************************** */
/* ***************************** */ /*print_r($assoc);*/ /* *********************** */
/* ***************************** *** *** *** *** ********************************** */
/* ***************************** *** *** *** *** ********************************** */
echo "<p class='file_count'>file_count: ".count($glob)."</p><br>";
echo "<p class='file_name'>file: ".$q_file."</p>";
/* *** */
$end = $all_items;
$step = 2000; // 
$all_items = count($assoc[0]['val']);
$all_files = count($glob);
$end = $all_items;
echo "<p class='all_items'>all items: ".$all_items."</p>";

//$h_counter = 0; // <------------------------------------------------------------------------------------------------
//UPDATE b_catalog_product SET QUANTITY = CASE WHEN 10250 THEN 25 END
while ($h_counter < $end) { 
/* ***************************************************************PARSE************************************ */
	$guid_xml = $assoc[0]['val'][$h_counter]['atr']['GUID'];
	$amount = $assoc[0]['val'][$h_counter]['val'][3]['val'][0]['val']; 
	//echo "guid_xml: ".$guid_xml."<br>";
	//echo "amount: ".$amount."<br>";
/* ******************************************************************************************************** */
	$arSelect = array(
		"ID","XML_ID"
	);
	//WHERE
	$arFilter = array(
		//"ACTIVE" => "Y", // Only active
		"IBLOCK_ID" => $IBLOCK,
		//"ACTIVE_DATE" => "Y",
		//"CHECK_PERMISSIONS" => "Y",
		"XML_ID" => $guid_xml
	);
	//ORDER BY
	$arSort = array(
		"ID" => "DESC",
	);
	$rsElements = CIBlockElement::GetList($arSort, $arFilter, false, false, $arSelect); // Begin update ID
	//$PRODUCT_IDS = [];
	//$sql_u = '';
	//$sql_u_n = '';
   		if ($obElement = $rsElements->GetNextElement()) {
			$arItem = $obElement->GetFields();
			//echo "id: ".$arItem['ID']."<br>";
			//echo "amount: ".$amount."<br>";
			$cur_id = $arItem['ID'];
			$sql_u_n .= ' WHEN '.$cur_id.' THEN '.$amount.' ';
		}
/* ********************************************** END*PROPERTIES ******************************************** */
	$z = $h_counter % $step;
	if ($z == 0) {

		BXClearCache(true, "/");
		$h_counter++;
		echo "<p class='h_counter'>h_counter_bla: ".$h_counter."</p>";
		header("refresh: 2; url=/12dev/catalog_update_machine/only_q.php?h_counter=$h_counter&file_c=$file_count");
		break;
}

	$h_counter++;
}
/* *** */

/* ********************************************************AMOUNT******************************************** */
		$sql_u = '';
		$sql_u .= 'UPDATE b_catalog_product SET QUANTITY = CASE ID ';
		$sql_u .= $sql_u_n;
		$sql_u .= ' ELSE QUANTITY END';
		$tb_update = $DB->Query($sql_u);
//$f ='UPDATE b_catalog_product SET QUANTITY = CASE WHEN 10250 THEN 25 END';
//$tb_update = $DB->Query($f);
//echo $sql_u."<br>";
//echo $sql_u_n."<br>";
/* ***************** */


if ($h_counter >= $end && $file_count < $all_files) {
	$file_count++;
	header("refresh: 2; url=/12dev/catalog_update_machine/only_q.php?h_counter=0&file_c=$file_count");
}

?>

</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
