<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Очистка старых дат");
/* Очищает свойство sНовинка, если там указана старая дата */
/* Затем снимает бейдж "Новинка" */
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
	array("ID", "PROPERTY_SNOVINKI", "PROPERTY_LABELS") // SelectFields
);
while($arItem = $resItem->Fetch())
{
	$ELEMENT_ID = $arItem['ID'];
	if ($cur_date > $arItem['PROPERTY_SNOVINKI_VALUE']) { // Если установленная дата старая
		CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array("SNOVINKI" => "")); // Удаляем ее
		/* Где-то моя механика не будет уже ставить бейдж */
		/* Вчера она работала, а сегодня нет, так что я допилил тут до конца */
		$VALUES = array();
		$res = CIBlockElement::GetProperty($iblock_id, $ELEMENT_ID, "sort", "asc", array("CODE" => "LABELS"));
		while ($ob = $res->GetNext())
		{
			$VALUES[] = $ob['VALUE'];
		}
		//print_r($VALUES);
		unset($VALUES[0]); // Убираем из массива значение "Новинка" (бейдж)
		CIBlockElement::SetPropertyValuesEx( // Сохраняем
		$ELEMENT_ID,
		$IBLOCK_ID,
		array(
			"LABELS" => $VALUES,
		)
		);
	} else {
		$VALUES = array();
		$res = CIBlockElement::GetProperty($iblock_id, $ELEMENT_ID, "sort", "asc", array("CODE" => "LABELS"));
		while ($ob = $res->GetNext())
		{
			$VALUES[] = $ob['VALUE'];
		}
		$VALUES[] = '37235'; // Добавляем в массив значение "Новинка" (бейдж)
		//print_r($VALUES);
		CIBlockElement::SetPropertyValuesEx( // Сохраняем
		$ELEMENT_ID,
		$IBLOCK_ID,
		array(
			"LABELS" => $VALUES,
		)
		);
	}
	//print_r($arItem);
}

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
