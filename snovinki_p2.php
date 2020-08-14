<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Удаление значения множественного свойства типа список у всех товаров");
/* Удалится бейдж "Новинка" у всех товаров */
/* Работает попарно с механикой SNOVINKI - snovinki_p1.php */
?>

<?
$iblock_id = 10; // Основной инфоблок
// Перебираем LABELS
$resItem = CIBlockElement::GetList(
	array(/*"PROPERTY_SNOVINKI"=>"asc"*/), // Order
	array( "ACTIVE"=>"Y", "IBLOCK_ID"=>$iblock_id, ">PROPERTY_LABELS"=>"0"/*, "ID"=>14509*/), // Filter
	false, // GroupBy
	false, // NavStartParams
	array("ID", "PROPERTY_LABELS") // SelectFields
);
while($arItem = $resItem->Fetch())
{
	$ELEMENT_ID = $arItem['ID'];
	$VALUES = array();
	$res = CIBlockElement::GetProperty($iblock_id, $ELEMENT_ID, "sort", "asc", array("CODE" => "LABELS"));
	while ($ob = $res->GetNext())
	{
		$VALUES[] = $ob['VALUE'];
	}
	//print_r($VALUES);
	unset($VALUES[0]); // Убираем из массива значение "Новинка"
	CIBlockElement::SetPropertyValuesEx( // Сохраняем
		$ELEMENT_ID,
		$IBLOCK_ID,
		array(
			"LABELS" => $VALUES,
		)
	);
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
