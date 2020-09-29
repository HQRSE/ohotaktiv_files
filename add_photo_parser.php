<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пакетная загрузка фото");
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
?>
<main class="catalog-page category-catalog-page quantity_page_style centering" id="start">
<?
$IBLOCK = 10;
$PROPERTY_CODE = 'MORE_PHOTO';

$glob_dir = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/*/', GLOB_ONLYDIR); // после pics надо любой каталог типа
if ($glob_dir) {
	$d = 0;
	while (count($glob_dir) > $d) {
		$code_dir = basename($glob_dir[$d]);
		echo "basename_dir_".$d.": ".$code_dir."<br>";
		$full_codes[] = $code_dir;
	$d++;
	}
}

$glob_file = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/*.{jpg,png,gif,PNG,JPG,GIF,bmp,BMP,jpeg,JPEG}', GLOB_BRACE);
if ($glob_file) {
	$minus_array = array(".","jpg","png","gif","PNG","JPG","GIF","bmp","BMP","jpeg","JPEG");
	$f = 0;
	while (count($glob_file) > $f) {
		$code_file = str_replace($minus_array, "", basename($glob_file[$f]));
		echo "basename_file_".$f.": ".$code_file."<br>";
		$full_codes[] = $code_file;
	$f++;
	}
}

print_r($full_codes);

$count = count($full_codes);
$i = 0;
while ($i < $count) {
$code = $full_codes[$i];
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
						$glob_dir = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/'.$code.'/*.{jpg,png,gif,PNG,JPG,GIF,bmp,BMP,jpeg,JPEG}', GLOB_BRACE); // после pics надо любой каталог типа
						if ($glob_dir) {
							$d = 0;
							while (count($glob_dir) > $d) {
								$pic = CFile::MakeFileArray($glob_dir[$d]);
								CIBlockElement::SetPropertyValueCode($el, $PROPERTY_CODE, $pic);
							$d++;
							}
						} 
						$glob_file = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/'.$code.'.{jpg,png,gif,PNG,JPG,GIF,bmp,BMP,jpeg,JPEG}', GLOB_BRACE);
						if ($glob_file) {
							$pic = CFile::MakeFileArray($glob_file[0]);
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
