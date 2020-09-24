<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пакетная загрузка фото");
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
$arSelect = Array("NAME", "ID", "DETAIL_PAGE_URL");

// 48, 36, 486, 477, 947, 1148, 69, 1104, 1115, 161, 205, 146, 349, 1765, 57, 210, 68, 154, 2613 - все кроме зипа и рыбалки
// 861 - рыбалка

// Коды из имен файлов/папок: 00195076, 00195077
// Их ID: 272450, 272452
?>
<main class="catalog-page category-catalog-page quantity_page_style centering" id="start">
<?
/* *** */
$PROPERTY_CODE = 'MORE_PHOTO';
$arr_code = array('00195076');
$count = count($arr_code);
$i = 0;
while ($i < $count) {
$code = $arr_code[$i];
	$results = $DB->Query("SELECT IBLOCK_ELEMENT_ID FROM b_iblock_element_property WHERE VALUE='$code' AND DESCRIPTION='Код'");
		if ($row = $results->Fetch())
		{
		$arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM");
		$res = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 10, 'ID' => $row['IBLOCK_ELEMENT_ID'], $arSelect));
        $item = $res->Fetch();
			if ($item['ACTIVE'] = 'Y') { 
				$el = $item['ID']; 
				$db_props = CIBlockElement::GetProperty(10, $el, "sort", "asc", Array("CODE"=>$PROPERTY_CODE));
				if($ar_props = $db_props->Fetch()) {
					if ($ar_props['VALUE'] == '') {
						/* go search photo */

						/* of search photo */
					}
				}
				//echo "<p class='id_prod'>ID PROD: ".$el."</p>";
				$arFile = array(
					0 => array("VALUE" => CFile::MakeFileArray("https://ohotaktiv.ru/12dev/add_photo_parser/pics/logo.png"),"DESCRIPTION"=>""),
					1 => array("VALUE" => CFile::MakeFileArray("https://ohotaktiv.ru/12dev/add_photo_parser/pics/23.jpg"),"DESCRIPTION"=>"")
				);
				//CIBlockElement::SetPropertyValueCode($el, $PROPERTY_CODE, $arFile);
			}
		}
$i++;
}
/* *** */
?>

</main>

<br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
