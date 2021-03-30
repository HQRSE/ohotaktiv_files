<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("CATALOG UPDATE MACHINE");
?>
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
$glob = glob("/var/www/sibirix2/data/www/ohotaktiv.ru/obmen_files/quantity/catalog/ВыгрузкаНоменклатуры*.xml");
$all_files = count($glob);

$file_count = 0; 
while ($file_count < $all_files) {

$xml = new XMLReader();
$q_file = $glob[$file_count];
$xml->open($q_file);
$assoc = xml2assoc($xml);

/* *** */
//$selected_array = array('00114530','00114531','00115380','00115381','00115382','00115383','00115384','00120936','00135921','00135922','00135923','00151130','00151131','00153280','00153281','00153282','00153283','00153284','00153285','00153286','00153287','00153288','00153289','00153290','00153291','00153292','00153701','00171284','00171285','00171286','00171295');
$all_items = count($assoc[0]['val']);
$end = $all_items;

$h_counter = 0; 
while ($h_counter < $end) { 
/* ***************************************************************PARSE************************************ */
	$guid_xml = str_replace(' ', '', $assoc[0]['val'][$h_counter]['atr']['GUID']);
	$code_xml = str_replace(' ', '', $assoc[0]['val'][$h_counter]['atr']['Kod']);
	$article = str_replace(' ', '', $assoc[0]['val'][$h_counter]['val'][2]['val'][0]['val']);
	$amount = str_replace(' ', '', $assoc[0]['val'][$h_counter]['val'][3]['val'][0]['val']); 

/* **************************************************************GROUPS************************************ */
	$gr_c = 0;
	$group_ids = [];
	while (count($assoc[0]['val'][$h_counter]['val'][4]['val']) > $gr_c) {
		$group = str_replace(' ', '', $assoc[0]['val'][$h_counter]['val'][4]['val'][$gr_c]['atr']['GUID']); 
		/* *** */
		$db_list = CIBlockSection::GetList(Array(), $arFilter = Array("IBLOCK_ID"=>$IBLOCK, "XML_ID"=>$group));
   		if ($ar_result = $db_list->GetNext()) {
			$group_ids[] = $ar_result['ID'];
		}
	$gr_c++;
	}
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
   		if ($obElement = $rsElements->GetNextElement()) {
			$arItem = $obElement->GetFields();
			//echo "id: ".$arItem['ID']."<br>";
			$PRODUCT_ID = $arItem['ID']; // ID here

/* **************************************************************GROUPS************************************ */
			if ($group_ids) {
				$el = new CIBlockElement;
				$arLoadGroupsArray = Array(
					//"IBLOCK_SECTION_ID" => 141,
  					"IBLOCK_SECTION" => $group_ids
				);
				$update_sections = $el->Update($PRODUCT_ID, $arLoadGroupsArray);
			}

/* *******************************************BEGIN*ADD*TO*CATALOG******************************************* */
		} else {
		/* *** */
			$name = $assoc[0]['val'][$h_counter]['val'][0]['val'][0]['val']; 
			$code_xml = str_replace(' ', '', $assoc[0]['val'][$h_counter]['atr']['Kod']);
        	$arParams = array("replace_space"=>"-","replace_other"=>"-");
        	$trans = Cutil::translit($name,"ru",$arParams);
			/* *** */
			$el = new CIBlockElement;
			$PROP = array();
			//$PROP['CML2_ARTICLE'] = $article; // Article
			$arLoadProductArray = Array(
				"MODIFIED_BY"    => 4307, // $USER->GetID(),
				"IBLOCK_SECTION" => $group_ids, // multivars need!
				"IBLOCK_ID"      => $IBLOCK,
				"PROPERTY_VALUES"=> $PROP,
				"NAME"           => $name,
				"ACTIVE"         => "Y",
				//"PREVIEW_TEXT"   => "текст для списка элементов",
				//"DETAIL_TEXT"    => "текст для детального просмотра",
				//"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif"),
				"XML_ID" => $guid_xml,
				"CODE" => $trans,
  			);

			if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
				/* *** CODE *** */
				$PROPERTY_CODE = "CML2_TRAITS";
				$PROPERTY_VALUE = array(
  					0 => array("VALUE"=>$code_xml,"DESCRIPTION"=>"Код")
				);
				CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, $IBLOCK, array($PROPERTY_CODE => $PROPERTY_VALUE));
				/* *** */
				//echo "id: ".$PRODUCT_ID."<br>";
			} else {
				//echo "Error!<br>Не удалось создать елемент для GUID: ".$guid_xml."<br>Ошибка: ".$el->LAST_ERROR."<br>";
			}
		/* *** */
		}
/* ******************************************************PROPERTIES****************************************** */
				CCatalogProduct::Add(Array("ID"=>$PRODUCT_ID,"QUANTITY"=>$amount));
/* **************************************************************ARTICLE************************************* */
	//if (!empty($article)) {
				$arArticleArchive = Array( // if !empty
					"CML2_ARTICLE" => $article,
					"MODIFIED_BY"    => 4307, // $USER->GetID()
				);
				CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, false, $arArticleArchive);
	//}
/* ********************************************************************************************************** */
			$file_c = 0;
			while (count($assoc[0]['val'][$h_counter]['val'][5]['val']) > $file_c) {
				$property = str_replace(' ', '', $assoc[0]['val'][$h_counter]['val'][5]['val'][$file_c]['atr']['GUID']); 
				$property_value = str_replace(' ', '', $assoc[0]['val'][$h_counter]['val'][5]['val'][$file_c]['val'][0]['val']); // 0 replace $x when multilist
				/* *** */
				$arFilter = array(
    				'IBLOCK_ID' => $IBLOCK,
    				'XML_ID' => $property,
				);
				$res = CIBlockProperty::GetList(array(), $arFilter);
				if ($field = $res->Fetch()) {

/* ***********************************************************TYPE*PROPERTY********************************* */
					$property_type = $field['PROPERTY_TYPE'];
					$property_code = $field['CODE'];
					$property_multiple = $field['MULTIPLE'];
					if ($property_type == 'L') {
            			$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID" => $IBLOCK, "CODE" => $property_code));
            			while($enum_fields = $property_enums->GetNext()) {
							if ($enum_fields["XML_ID"] == $property_value) {
								$val_id = $enum_fields["ID"];
								$arPropertyArchive = Array(
								$property_code => $enum_fields["ID"],
								);
							}
            			}
					CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, false, $arPropertyArchive);
					} elseif ($property_type == 'S' || $property_multiple == 'Y') {
						$arPropertyArchive = Array(
							$property_code => $property_value,
						);
					CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, false, $arPropertyArchive);
					} elseif ($property_type == 'S' || $property_multiple == 'N') {
						$arPropertyArchive = Array(
							$property_code => $property_value,
						);					
					CIBlockElement::SetPropertyValuesEx($PRODUCT_ID, $IBLOCK, $arPropertyArchive);
					}
/* *********************************************************************************************************** */
				}
			/* *** */
			$file_c++;
			}

/* ********************************************** END*PROPERTIES ******************************************** */

	$h_counter++;
	}
/* *** */
	$file_count++;
}

?>

</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
