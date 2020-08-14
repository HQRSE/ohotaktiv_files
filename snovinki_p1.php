<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Очистка старых дат");
/* Очищает свойство sНовинка, если там указана старая дата */
/* Работает в паре с snovinki_p2.php */
?>

<?
// Текущее время
$cur_date = date('Y-m-d\TH:i:s');
	echo "cur_date: ".$cur_date."<br>";
$iblock_id = 10; // Основной инфоблок 
 
// Перебираем товары где есть SNOVINKI
$resItem = CIBlockElement::GetList(
	array(/*"PROPERTY_SNOVINKI"=>"asc"*/), // Order
	array( "ACTIVE"=>"Y", "IBLOCK_ID"=>$iblock_id, ">PROPERTY_SNOVINKI"=>"0"/*, "ID"=>14509*/), // Filter
	false, // GroupBy
	false, // NavStartParams
	array("ID", "PROPERTY_SNOVINKI") // SelectFields
);
while($arItem = $resItem->Fetch())
{
	$ELEMENT_ID = $arItem['ID'];
	if ($cur_date > $arItem['PROPERTY_SNOVINKI_VALUE']) { // Если установленная дата уже старая
		CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array("SNOVINKI" => "")); // Удаляем ее
		/* Где-то моя механика не будет уже ставить бейдж. Я не смог найти файл, где определена эта функция */
		/* Она смотрит на SNOVINKI и если там что-то есть, то она ставит бейдж "Новинка" */
	}
}

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
