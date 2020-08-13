<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
?>

<?
$iblock_id = 10; // основной инфоблок
$ELEMENT_ID = 14509;

// перебираем все активные элементы нашего инфоблока
$resItem = CIBlockElement::GetList(
	array(), // Order
	array( "ACTIVE"=>"Y", "IBLOCK_ID"=>$iblock_id, ">PROPERTY_LABELS"=>0), // Filter
	false, // GroupBy
	false, // NavStartParams
	array("ID", "IBLOCK_ID", "PROPERTY_LABELS") // SelectFields
);
while($arItem = $resItem->Fetch())
{
	if (37235 == $arItem['PROPERTY_LABELS_ENUM_ID']) {
		//CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array("SNOVINKI" => ""));
	//}

	echo "id: ".$arItem['ID']." - s: ".$arItem['PROPERTY_LABELS_ENUM_ID']."<br>";
	}
	//print_r($arItem);
}
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
