 <?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
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

$glob = "/var/www/sibirix2/data/www/ohotaktiv.ru/12dev/catalog_update_machine/Tree.xml";
//$all_files = count($glob);
$IBLOCK = 10;
//$group_ids = [];

	/* *** */
	$xml = new XMLReader();
	//$q_file = $glob[$file_count];
	$xml->open($glob);
	$assoc = xml2assoc($xml);

$all_items = count($assoc[0]['val']);
$end = $all_items;

//print_r($assoc);

//$sql = '';
//$sql = 'INSERT INTO price_magic (GUID,PRICE_ID,VALUE) VALUES ';
$section_not_found_xml = [];
	/* *** */

	$h_counter = 0;
	while ($h_counter < $end) { 

	$section_head_parent_xml = $assoc[0]['val'][$h_counter]['atr']['GUID'];
	$section_head_parent_name = $assoc[0]['val'][$h_counter]['atr']['Name'];
	/* search_id */
	$db_list = CIBlockSection::GetList(Array(), $arFilter = Array("IBLOCK_ID"=>$IBLOCK, "XML_ID"=>$section_head_parent_xml));
   	if ($ar_result = $db_list->GetNext()) {
		$section_head_id = $ar_result['ID']; // 1 lvl_id
	}
	/* /search_id */
	echo $section_head_parent_xml." --- ".$section_head_parent_name."<br>";
/* LVL 1 */
		$parent_count_depth_0 = 0;
		while (count($assoc[0]['val'][$h_counter]['val']) > $parent_count_depth_0) {

			$section_head_child_xml = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['atr']['GUID'];
			$section_head_child_name = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['atr']['Name'];
			if ($section_head_child_xml) {
				/* search_id */
				$db_list = CIBlockSection::GetList(Array(), $arFilter = Array("IBLOCK_ID"=>$IBLOCK, "XML_ID"=>$section_head_child_xml));
				$bs = new CIBlockSection;
				$arFields = Array(
					//"ACTIVE" => "Y",
					"IBLOCK_SECTION_ID" => $section_head_id, // parent_id
					"IBLOCK_ID" => $IBLOCK,
					"NAME" => $section_head_child_name
				);
   				if ($ar_result_l1 = $db_list->GetNext()) {
					$section_head_child_id_l1 = $ar_result_l1['ID']; // 2 lvl_id
					//$res = $bs->Update($ID, $arFields);
				} else {
					//$section_head_child_id_l1 = $bs->Add($arFields);
					//$res = ($section_head_child_id_l1>0);
					$section_not_found_xml[] = $section_head_child_xml;
				}
				/* /search_id */
				echo "---- ".$section_head_child_xml." --- ".$section_head_child_name."<br>";
			}
/* LVL 2 */
			$parent_count_depth_1 = 0;
			while (count($assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val']) > $parent_count_depth_1) {
				$section_head_child_depth_1_xml = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['atr']['GUID'];
				$section_head_child_depth_1_name = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['atr']['Name'];
				if ($section_head_child_depth_1_xml) {
					/* search_id */
					$db_list = CIBlockSection::GetList(Array(), $arFilter = Array("IBLOCK_ID"=>$IBLOCK, "XML_ID"=>$section_head_child_depth_1_xml));
					$bs = new CIBlockSection;
					$arFields = Array(
						//"ACTIVE" => "Y",
						"IBLOCK_SECTION_ID" => $section_head_child_id_l1, // _id
						"IBLOCK_ID" => $IBLOCK,
						"NAME" => $section_head_child_depth_1_name
					);
   					if ($ar_result_l2 = $db_list->GetNext()) {
						$section_head_child_id_l2 = $ar_result_l2['ID']; // section_head_child_id_l2
						//$res = $bs->Update($ID, $arFields);
					} else {
						//$section_head_child_id_l2 = $bs->Add($arFields);
						//$res = ($section_head_child_id_l2>0);
						$section_not_found_xml[] = $section_head_child_depth_1_xml;
					}
					/* /search_id */
					echo "-------- ".$section_head_child_depth_1_xml." --- ".$section_head_child_depth_1_name."<br>";
/* LVL 3 */
					$parent_count_depth_2 = 0;
					while (count($assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['val']) > $parent_count_depth_2) {
						$section_head_child_depth_2_xml = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['val'][$parent_count_depth_2]['atr']['GUID'];
						$section_head_child_depth_2_name = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['val'][$parent_count_depth_2]['atr']['Name'];
						if ($section_head_child_depth_2_xml) {
							/* search_id */
							$db_list = CIBlockSection::GetList(Array(), $arFilter = Array("IBLOCK_ID"=>$IBLOCK, "XML_ID"=>$section_head_child_depth_2_xml));
							$bs = new CIBlockSection;
							$arFields = Array(
								//"ACTIVE" => "Y",
								"IBLOCK_SECTION_ID" => $section_head_child_id_l2, // _id
								"IBLOCK_ID" => $IBLOCK,
								"NAME" => $section_head_child_depth_2_name
							);
   							if ($ar_result_l3 = $db_list->GetNext()) {
								$section_head_child_id_l3 = $ar_result_l3['ID']; // section_head_child_id_l3
								//$res = $bs->Update($ID, $arFields);
							} else {
								//$section_head_child_id_l3 = $bs->Add($arFields);
								//$res = ($section_head_child_id_l3>0);
								$section_not_found_xml[] = $section_head_child_depth_2_xml;
							}
							/* /search_id */
							echo "---------------- ".$section_head_child_depth_2_xml." --- ".$section_head_child_depth_2_name."<br>";
/* LVL 4 */
							$parent_count_depth_3 = 0;
							while (count($assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['val'][$parent_count_depth_2]['val']) > $parent_count_depth_3) {
								$section_head_child_depth_3_xml = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['val'][$parent_count_depth_2]['val'][$parent_count_depth_3]['atr']['GUID'];
								$section_head_child_depth_3_name = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['val'][$parent_count_depth_2]['val'][$parent_count_depth_3]['atr']['Name'];
								if ($section_head_child_depth_3_xml) {
									/* search_id */
									$db_list = CIBlockSection::GetList(Array(), $arFilter = Array("IBLOCK_ID"=>$IBLOCK, "XML_ID"=>$section_head_child_depth_3_xml));
									$bs = new CIBlockSection;
									$arFields = Array(
										//"ACTIVE" => "Y",
										"IBLOCK_SECTION_ID" => $section_head_child_id_l3, // _id
										"IBLOCK_ID" => $IBLOCK,
										"NAME" => $section_head_child_depth_3_name
									);
   									if ($ar_result_l4 = $db_list->GetNext()) {
										$section_head_child_id_l4 = $ar_result_l4['ID']; // section_head_child_id_l1
										//$res = $bs->Update($ID, $arFields);
									} else {
										//$section_head_child_id_l4 = $bs->Add($arFields);
										//$res = ($section_head_child_id_l4>0);
										$section_not_found_xml[] = $section_head_child_depth_3_xml;
									}
									/* /search_id */
									echo "-------------------------------- ".$section_head_child_depth_3_xml." --- ".$section_head_child_depth_3_name."<br>";
/* LVL 5 */
									$parent_count_depth_4 = 0;
									while (count($assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['val'][$parent_count_depth_2]['val'][$parent_count_depth_3]['val']) > $parent_count_depth_4) {
										$section_head_child_depth_4_xml = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['val'][$parent_count_depth_2]['val'][$parent_count_depth_3]['val'][$parent_count_depth_4]['atr']['GUID'];
										$section_head_child_depth_4_name = $assoc[0]['val'][$h_counter]['val'][$parent_count_depth_0]['val'][$parent_count_depth_1]['val'][$parent_count_depth_2]['val'][$parent_count_depth_3]['val'][$parent_count_depth_4]['atr']['Name'];
										if ($section_head_child_depth_4_xml) {
											/* search_id */
											$db_list = CIBlockSection::GetList(Array(), $arFilter = Array("IBLOCK_ID"=>$IBLOCK, "XML_ID"=>$section_head_child_depth_4_xml));
											$bs = new CIBlockSection;
											$arFields = Array(
												//"ACTIVE" => "Y",
												"IBLOCK_SECTION_ID" => $section_head_child_id_l4, // _id
												"IBLOCK_ID" => $IBLOCK,
												"NAME" => $section_head_child_depth_4_name
											);
   											if ($ar_result_l5 = $db_list->GetNext()) {
												$section_head_child_id_l5 = $ar_result_l5['ID']; // section_head_child_id_l1
												//$res = $bs->Update($ID, $arFields);
											} else {
												//$section_head_child_id_l5 = $bs->Add($arFields);
												//$res = ($section_head_child_id_l5>0);
												$section_not_found_xml[] = $section_head_child_depth_4_xml;
											}
											/* /search_id */
											echo "---------------------------------------------------------------- ".$section_head_child_depth_4_xml." --- ".$section_head_child_depth_4_name."<br>";
										}
									$parent_count_depth_4++;
									}
								}
							$parent_count_depth_3++;
							}
						}
					$parent_count_depth_2++;
					}
				}
			$parent_count_depth_1++;
			}

			$parent_count_depth_0++;
		}

	$h_counter++;
	}

echo "<br><br>";
print_r($section_not_found_xml);

?>

</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
