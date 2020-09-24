<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пакетная загрузка фото");
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

// 48, 36, 486, 477, 947, 1148, 69, 1104, 1115, 161, 205, 146, 349, 1765, 57, 210, 68, 154, 2613 - все кроме зипа и рыбалки
// 861 - рыбалка

// Коды из имен файлов/папок: 00195076, 00195077
// Их ID: 272450, 272452
?>
<main class="catalog-page category-catalog-page quantity_page_style centering" id="start">
<?
/* *** */
$PROPERTY_CODE = 'MORE_PHOTO';
$arr_code = array('00001867'); // real
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

						$glob = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/'.$code.'/*.{jpg,png,gif,PNG,JPG,GIF,bmp,BMP,jpeg,JPEG}', GLOB_BRACE); // после pics надо любой каталог типа
						if ($glob) {
							//$arFiles = array();
							$c = 0;
							while (count($glob) > $c) {
								//print_r($glob);
									$arVal[] = array("VALUE" => CFile::MakeFileArray('https://ohotaktiv.ru/12dev/add_photo_parser/pics/logo.png'));
								//echo $glob[$c]."<br>";
							$c++;
							}
							//CIBlockElement::SetPropertyValueCode($el, $PROPERTY_CODE, $arVal);
							//print_r($arVal);
							//echo $arFiles[0];
						} else {
							$glob = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/'.$code.'*.{jpg,png,gif,PNG,JPG,GIF,bmp,BMP,jpeg,JPEG}', GLOB_BRACE);
							//print_r($glob);
						}
						

						/* of search photo */
					}
				}
				//echo "<p class='id_prod'>ID PROD: ".$el."</p>";
				//CIBlockElement::SetPropertyValueCode($el, $PROPERTY_CODE, $arFiles);
			}
		}
$i++;
}
/* *** */
$arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/12dev/add_photo_parser/pics/logo.png");
CIBlockElement::SetPropertyValueCode(15769, "MORE_PHOTO", $arFile);
//print_r($arFile);
//CIBlockElement::SetPropertyValueCode($el, $PROPERTY_CODE, $arFile);
?>

</main>

<br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
