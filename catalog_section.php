<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<section class="goods goods-part-1">
						<?
global $USER;
if ($USER->IsAdmin()) { if (
    isset($_GET["sort"]) && isset($_GET["method"]) && (
$_GET["sort"] == "name" || 
              $_GET["sort"] == "catalog_PRICE_5" ||
             $_GET["sort"] == "property_PRODUCT_TYPE" ||
             $_GET["sort"] == "timestamp_x")){
       $arParams["ELEMENT_SORT_FIELD"] = $_GET["sort"];
       $arParams["ELEMENT_SORT_ORDER"] = $_GET["method"];
   }

  ?>
	<p class="sort">Сортировать по:
    <a <?if ($_GET["sort"] == "name"):?> class="active" <?endif;?>
       href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=name&method=asc">Названию</a> | 
    <a <?if ($_GET["sort"] == "catalog_PRICE_3"):?> class="active" <?endif;?>
       href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=catalog_PRICE_5&method=asc">Цене</a> | 
    <a <?if ($_GET["sort"] == "timestamp_x"):?> class="active" <?endif;?>
       href="<?=$arResult["SECTION_PAGE_URL"]?>?sort=timestamp_x&method=desc">Дате поступления</a>
</p>
	<? } ?>
<?if(empty($arResult['ITEMS'])):?>
	<div class="default default-center">
		<p>Товары не найдены.</p>
	</div>
<?else:?>
	<?foreach($arResult['ITEMS'] as $arItem):
		?>
		<?
		$APPLICATION->IncludeComponent(
			'bitrix:catalog.item',
			'catalog__item',
			array(
				'RESULT' => array(
					'ITEM' => $arItem,
					'AREA_ID' => "",
					'TYPE' => "",
					'BIG_LABEL' => 'N',
					'BIG_DISCOUNT_PERCENT' => 'N',
					'BIG_BUTTONS' => 'N',
					'SCALABLE' => 'N'
				),
				'PARAMS' => $arParams
			),
			$component,
			array('HIDE_ICONS' => 'Y')
		);
		?>
	<?endforeach;?>
<?endif;?>
</section>
<?if(!empty($arResult['NAV_STRING'])):?>
<div class="pagination__container">
	<?=$arResult['NAV_STRING'];?>
</div>

<?endif;?>
