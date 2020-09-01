<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("> Discount <");
?>

<?
$item_id = array ('230609', '230618' );
//$item_id = 230609;

CModule::IncludeModule('sale');
//получим список товаров в правиле работы с корзиной:
$new_ids = [];
$new_ids[] = unserialize(CSaleDiscount::GetByID(44)['ACTIONS'])['CHILDREN'][0]['CHILDREN'][0]['DATA']['value'];

//$new_ids[] = $item_id;
$new_ids = array_merge($new_ids, $item_id);
print_r( $new_ids );

?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
