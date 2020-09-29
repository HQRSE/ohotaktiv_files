<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Пакетная загрузка фото");
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
?>
<main class="catalog-page category-catalog-page quantity_page_style centering" id="start">
<?
$glob_dir = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/*/', GLOB_ONLYDIR); // после pics надо любой каталог типа
if ($glob_dir) {
	$d = 0;
	while (count($glob_dir) > $d) {
		$code_dir = basename($glob_dir[$d]);
		//echo "basename_dir_".$d.": ".$code_dir."<br>";
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
		//echo "basename_file_".$f.": ".$code_file."<br>";
		$full_codes[] = $code_file;
	$f++;
	}
}
/* ***************************** */
//print_r($full_codes);

$IBLOCK = 10;
$PROPERTY_CODE = 'MORE_PHOTO';
$step = 2;
$count = count($full_codes);
$h_counter = $_GET['h_counter']; // - start h_counter = 0

while ($h_counter < 6) {
$code = $full_codes[$h_counter];
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
								//CIBlockElement::SetPropertyValueCode($el, $PROPERTY_CODE, $pic);
								echo "code_dir_".$d.": ".basename($glob_dir[$d])."<br>";
							$d++;
							}
						} 
						$glob_file = glob(Bitrix\Main\Application::getDocumentRoot().'/12dev/add_photo_parser/pics/'.$code.'.{jpg,png,gif,PNG,JPG,GIF,bmp,BMP,jpeg,JPEG}', GLOB_BRACE);
						if ($glob_file) {
							$pic = CFile::MakeFileArray($glob_file[0]);
							echo "code_file: ".basename($glob_file[0])."<br>";
							//CIBlockElement::SetPropertyValueCode($el, $PROPERTY_CODE, $pic);
						}
						/* off search photo */
					}
				}
			}
		}
	/*$z = $h_counter % $step;
	if ($z == 0) {
		$h_counter++;
		header("refresh: 2; url=/12dev/add_photo_parser/index.php?h_counter=$h_counter");
		break;
}*/
	$h_counter++;
}

?>

</main>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
