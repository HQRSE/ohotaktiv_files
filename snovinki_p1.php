<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>

<?
/* *** */


/* *** */
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");

// Текущее время:
$cur_date = date('Y-m-d\TH:i:s');
echo $cur_date."<br>";

$iblock_id = 10; // основной инфоблок

// перебираем все активные элементы нашего инфоблока
$resItem = CIBlockElement::GetList(
	array("PROPERTY_SNOVINKI"=>"asc"), // Order
	array( "ACTIVE"=>"Y", "IBLOCK_ID"=>$iblock_id, /*">PROPERTY_SNOVINKI"=>"0"*/), // Filter
	false, // GroupBy
	false, // NavStartParams
	array("ID", "IBLOCK_ID", "PROPERTY_SNOVINKI") // SelectFields
);
while($arItem = $resItem->Fetch())
{
	//if ($cur_date > $arItem['PROPERTY_SNOVINKI_VALUE']) {
	//CIBlockElement::SetPropertyValuesEx($arItem['ID'], false, array("SNOVINKI" => ""));
	//}

	echo "id: ".$arItem['ID']." - s: ".$arItem['PROPERTY_SNOVINKI_VALUE']."<br>";
	//print_r($arItem);
}

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
