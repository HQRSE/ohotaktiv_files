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
$IBLOCK = 10;
$PROPERTY_CODE = 'MORE_PHOTO';
$arr_code = array('00001867'); // real
$count = count($arr_code);
$i = 0;
while ($i < $count) {
$code = $arr_code[$i];
	$results = $DB->Query("SELECT IBLOCK_ELEMENT_ID FROM b_iblock_element_property WHERE VALUE='$code' AND DESCRIPTION='Код'");
		while ($row = $results->Fetch())
		{
		$res = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 10, 'ID' => $row['IBLOCK_ELEMENT_ID'], ['ACTIVE'] => 'Y'));
			if ($item = $res->Fetch()) { 
				$el = $item['ID']; 
				$db_props = CIBlockElement::GetProperty($IBLOCK, $el, "sort", "asc", Array("CODE"=>$PROPERTY_CODE));
				if($ar_props = $db_props->Fetch()) {
					if (empty($ar_props['VALUE'])) {
						/* go search photo */
						$glob = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/'.$code.'/*.{jpg,png,gif,PNG,JPG,GIF,bmp,BMP,jpeg,JPEG}', GLOB_BRACE); // после pics надо любой каталог типа
						if ($glob) {
							$c = 0;
							while (count($glob) > $c) {
								$pic = CFile::MakeFileArray($glob[$c]);
								CIBlockElement::SetPropertyValueCode($el, $PROPERTY_CODE, $pic);
							$c++;
							}
						} else {
							$glob = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/'.$code.'.{jpg,png,gif,PNG,JPG,GIF,bmp,BMP,jpeg,JPEG}', GLOB_BRACE);
							//print_r($glob);
							$pic = CFile::MakeFileArray($glob[0]);
							CIBlockElement::SetPropertyValueCode($el, $PROPERTY_CODE, $pic);
						}
						/* off search photo */
					}
				}
			}
		}
$i++;
}
/* *** */

?>

</main>
<br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
