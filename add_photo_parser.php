<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Товары без фото");
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
$arSelect = Array("NAME", "ID", "DETAIL_PAGE_URL", "SECTION_ID");
// 48, 36, 486, 477, 947, 1148, 69, 1104, 1115, 161, 205, 146, 349, 1765, 57, 210, 68, 154, 2613 - все кроме зипа и рыбалки
// 
$arFilter = Array("IBLOCK_ID"=>10, "SECTION_ID"=>'861', "INCLUDE_SUBSECTIONS" => "Y", "PREVIEW_PICTURE" => false);
$res = CIBlockElement::GetList(Array("NAME"=>"ASC"), $arFilter, false, Array("nPageSize"=>5000), $arSelect);
?>
<div class="container centering">
<?
//echo count($res['arResult']);
//print_r($res);
$res->NavStart(0);
$i = 0;
while($ob = $res->GetNextElement())
{
$arFields = $ob->GetFields();
{?>
<?=$arFields['ID']?> - <a target="_blank" href="<?=$arFields['DETAIL_PAGE_URL']?>"><?=$arFields['NAME']?></a> <!-- - Подраздел №<?=$arFields['IBLOCK_SECTION_ID']?>  --> </br>
<?
$i++;
}

}
echo "--> ".$i."<br>";
$navStr = $res->GetPageNavStringEx($navComponentObject, "Страницы:", ".default");
echo $navStr;
?>
</div>
<br><br><br><br>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
