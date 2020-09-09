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
$GLOBALS['SUBSECTION_SALE_BANNER'] = array('=PROPERTY_SECTION_UPPER' => '42079842');
$GLOBALS['SUBSECTION_SALE_SIDEBAR'] = array('=PROPERTY_SECTION_FILTER' => '42079844');
$GLOBALS['FILTER_SECTION_NEW'] = array('=PROPERTY_LABELS' => '37235', '=SECTION_ID' => $arResult['VARIABLES']['SECTION']['ID']);
$GLOBALS['FILTER_SECTION_SALE'] = array('=PROPERTY_SACTIONPRODUCT' => '42079827', '=SECTION_ID' => $arResult['VARIABLES']['SECTION']['ID']);
if(!empty($arResult['VARIABLES']['SECTION']['UF_TITLE'])){
	$APPLICATION->SetPageProperty('title', $arResult['VARIABLES']['SECTION']['UF_TITLE']);
}
if(!empty($arResult['VARIABLES']['SECTION']['UF_H1_SEO'])){
	$APPLICATION->SetTitle($arResult['VARIABLES']['SECTION']['UF_H1_SEO']);
}
$APPLICATION->SetPageProperty('description', $arResult['VARIABLES']['SECTION']['UF_DESCR']);
$APPLICATION->SetPageProperty('keywords', $arResult['VARIABLES']['SECTION']['UF_KEYWR']);
?>

<?if($arResult['VARIABLES']['SECTION']['DEPTH_LEVEL'] == 1):?>
<main class="catalog-page category-catalog-page" id="start">
	<div class="callback-btn js-callback-btn">
		<svg class="icon-callback-btn">
			<use xlink:href="#icon-callback-btn"></use>
		</svg>
	</div>
	<div class="breadcrumbs__container centering 123">
		<?$APPLICATION->IncludeComponent(
			"bitrix:breadcrumb",
			"breadcrumbs__breadcrumbs",
			array(
				"PATH" => "",
				"SITE_ID" => SITE_ID,
				"START_FROM" => "0"
			)
		);?>
	</div>
	<section class="category-seo centering">
		<h1 class="category-seo__title"><?=$APPLICATION->ShowTitle(false);?></h1>
	</section>
  <?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"catalog__subsections",
		array(
			"ADD_SECTIONS_CHAIN" => "Y",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"COUNT_ELEMENTS" => "Y",
			"IBLOCK_ID" => $arParams["IBLOCK_ID"],
			"IBLOCK_TYPE" => "1c_catalog",
			"SECTION_CODE" => $arResult['VARIABLES']['SECTION_CODE'],
			"SECTION_FIELDS" => array(
				0 => "PICTURE",
				1 => "DETAIL_PICTURE",
			),
			"SECTION_ID" => $_REQUEST["SECTION_ID"],
			"SECTION_URL" => "",
			"SECTION_USER_FIELDS" => array(
				0 => "",
				1 => "",
			),
			"SHOW_PARENT_NAME" => "Y",
			"TOP_DEPTH" => "1",
			"VIEW_MODE" => "LINE",
			"COMPONENT_TEMPLATE" => ""
		),
		$component
	); ?>

	<section class="category-catalog centering">
		<sidebar class="category-catalog__sidebar">
			<?
/* *** */
if(empty($arResult["VARIABLES"]["SMART_FILTER_PATH"])){
$re = '/^\/.*\/filter\/(.*)\/apply\//';
$str = Bitrix\Main\Context::getCurrent()->getRequest()->getRequestedPage();
preg_match($re, $str, $matches);
$arResult["VARIABLES"]["SMART_FILTER_PATH"] =$matches[1];
}
/* *** */
				$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"real_catalog_filter",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $_REQUEST["ACTIVE_CATID"] ? intval($_REQUEST["ACTIVE_CATID"]) : $arResult['VARIABLES']['SECTION']['ID'],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"PRICE_CODE" => array("Диапазон цен"),
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SAVE_IN_SESSION" => "N",
					"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
					"XML_EXPORT" => "Y",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
					"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					"SEF_MODE" => $arParams["SEF_MODE"],
					"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"], // "/catalog/filter/#SMART_FILTER_PATH#/apply/", // $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
					"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"], // $_REQUEST["SMART_FILTER_PATH"], // $arResult["VARIABLES"]["SMART_FILTER_PATH"],
					"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
					"INSTANT_RELOAD" => 'Y',
					'SHOW_ALL_WO_SECTION' => 'Y',
					"SET_STATUS_404" => "Y",
					"SHOW_404" => "Y",
				),
				$component,
				array('HIDE_ICONS' => 'Y')
			);?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"subsection__sidebar",
				Array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "N",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "N",
					"CACHE_FILTER" => "Y",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "N",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array("NAME", "DATE_ACTIVE_FROM", "DATE_ACTIVE_TO", ""),
					"FILTER_NAME" => "SUBSECTION_SALE_SIDEBAR",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => "19",
					"IBLOCK_TYPE" => "content",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"INCLUDE_SUBSECTIONS" => "Y",
					"MEDIA_PROPERTY" => "",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "2",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array("LINK", "WIDTH", "INDEX_SLIDER_LEFT", "INDEX_SLIDER_RIGHT", "INDEX_SALE_LIST", "SECTION_LIST", "SECTION_UPPER", "SECTION_FILTER", ""),
					"SEARCH_PAGE" => "/search/",
					"SET_BROWSER_TITLE" => "N",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "N",
					"SHOW_404" => "N",
					"SLIDER_PROPERTY" => "",
					"SORT_BY1" => "SORT",
					"SORT_BY2" => "ACTIVE_FROM",
					"SORT_ORDER1" => "ASC",
					"SORT_ORDER2" => "DESC",
					"STRICT_SECTION_CHECK" => "N",
					"TEMPLATE_THEME" => "blue",
					"USE_RATING" => "N",
					"USE_SHARE" => "N"
				)
			);?>
		</sidebar>
		<div class="category-catalog__inner">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"subsection__banner",
			Array(
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "N",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array("NAME", "DATE_ACTIVE_FROM", "DATE_ACTIVE_TO", ""),
				"FILTER_NAME" => "SUBSECTION_SALE_BANNER",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => "19",
				"IBLOCK_TYPE" => "content",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "Y",
				"MEDIA_PROPERTY" => "",
				"MESSAGE_404" => "",
				"NEWS_COUNT" => "1",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Новости",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => array("LINK", "WIDTH", "INDEX_SLIDER_LEFT", "INDEX_SLIDER_RIGHT", "INDEX_SALE_LIST", "SECTION_LIST", "SECTION_UPPER", "SECTION_FILTER", "PICTURE_WIDE_MOBILE", "PICTURE_WIDE_TABLET", "PICTURE_WIDE_DESKTOP"),
				"SEARCH_PAGE" => "/search/",
				"SET_BROWSER_TITLE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SLIDER_PROPERTY" => "",
				"SORT_BY1" => "SORT",
				"SORT_BY2" => "ACTIVE_FROM",
				"SORT_ORDER1" => "ASC",
				"SORT_ORDER2" => "DESC",
				"STRICT_SECTION_CHECK" => "N",
				"TEMPLATE_THEME" => "blue",
				"USE_RATING" => "N",
				"USE_SHARE" => "N"
			)
		);?>
			<div class="filter-display">
				<div class="filter-open js-filter-open">
					<span class="filter-open__desc">Фильтры</span>
					<span class="filter-status filter-status--is-empty"></span>
						<svg class="filter_logo" data-v-469cfe6c="" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
							<g data-v-469cfe6c="" fill="none" fill-rule="evenodd"><path data-v-469cfe6c="" d="M0 0h24v24H0z"></path><path data-v-469cfe6c="" d="M4.126 6a4.002 4.002 0 017.748 0H22a1 1 0 010 2H11.874a4.002 4.002 0 01-7.748 0H2a1 1 0 110-2h2.126zm8 10a4.002 4.002 0 017.748 0H22a1 1 0 010 2h-2.126a4.002 4.002 0 01-7.748 0H2a1 1 0 010-2h10.126zM16 19a2 2 0 100-4 2 2 0 000 4zM8 9a2 2 0 100-4 2 2 0 000 4z" fill="currentColor" fill-rule="nonzero"></path></g>
						</svg>
				</div>
			</div>
<?
$sortField = 'HAS_PREVIEW_PICTURE'; // поле сортировки по умолчанию
$sortOrder = 'DESC'; // направление сортировки по умолчанию

if (isset($_GET["sort"]) && isset($_GET["method"]) && (
	$_GET["sort"] == "name" || 
    $_GET["sort"] == "CATALOG_PRICE_5" ||
    $_GET["sort"] == "timestamp_x")) {
      $sortField = $_GET["sort"];
      $sortOrder = $_GET["method"];
}
global $noZeroAr;
$noZeroAr = Array(">CATALOG_PRICE_1" => 0, ">CATALOG_PRICE_5" => 0);
?>
			<? if ($_REQUEST["ACTIVE_CATID"]) $GLOBALS[$arParams["FILTER_NAME"]]["SECTION_ID"] = intval($_REQUEST["ACTIVE_CATID"]); ?>
			<? $intSectionID = $APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"catalog__section",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => $sortField, // $arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => $sortOrder, // $arParams["ELEMENT_SORT_ORDER"],
					"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
					"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
					"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
					"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
					"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
					"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
					"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_FILTER" => $arParams["CACHE_FILTER"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SET_TITLE" => $arParams["SET_TITLE"],
					"MESSAGE_404" => $arParams["MESSAGE_404"],
					"SET_STATUS_404" => $arParams["SET_STATUS_404"],
					"SHOW_404" => $arParams["SHOW_404"],
					"FILE_404" => $arParams["FILE_404"],
					"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
					"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
					"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
					"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
					"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
					"PAGER_TITLE" => $arParams["PAGER_TITLE"],
					"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
					"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
					"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
					"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
					"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
					"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
					"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
					"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
					"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
					"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
					"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
					"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
					"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
					"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
					"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
					"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
					"SECTION_ID" => $_REQUEST["ACTIVE_CATID"] ? false : $arResult["VARIABLES"]["SECTION_ID"],
					"SECTION_CODE" => $_REQUEST["ACTIVE_CATID"] ? false : $arResult["VARIABLES"]["SECTION_CODE"],
					"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
					"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
					"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
					'LABEL_PROP' => $arParams['LABEL_PROP'],
					'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
					'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
					'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
					'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
					'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
					'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
					'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
					'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
					'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
					'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
					'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
					'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
					'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
					"ADD_SECTIONS_CHAIN" => "N",
					'ADD_TO_BASKET_ACTION' => $basketAction,
					'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
					'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
					'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
					'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
					'SHOW_ALL_WO_SECTION' => 'Y'
				),
				$component
			); ?>
			<? if (!preg_match("#PAGEN_#", $_SERVER["REQUEST_URI"]) && !preg_match("#/filter/#", $_SERVER["REQUEST_URI"])): ?>
				<section class="seo">
					<div class="seo__inner centering">
						<?/*<h4 class="seo__title"><?=$arResult['VARIABLES']['SECTION']['NAME'];?></h4>*/?>
						<?if(!empty($arResult['VARIABLES']['SECTION']['DESCRIPTION'])):?>
							<div class="category-seo__desc"><?=$arResult['VARIABLES']['SECTION']['DESCRIPTION'];?></div>
							<button class="btn-more js-btn-more">Читать дальше</button>
						<?endif;?>
					</div>
				</section>
			<? endif ?>
			<? if ($_REQUEST['bxajaxid'] && $_REQUEST['bxajaxid'] == 'catalog-products') {
				die();
			}
			?>
			<div class="banner-help" id="request-help">
				<div class="banner-help__body">
					<div class="banner-help__info">
						<h4 class="banner-help__title">Нужна помощь в подборе товара?</h4>
						<p class="banner-help__desc">Поможем разобраться и подберем товар для вас, заполните заявку и наш специалист свяжется с вами</p>
					</div>
<a class="help_me_btn">Сделай заказ</a>
				</div>
			</div>
		</div>
	</section>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.top",
		"section__new",
		array(
			"ACTION_VARIABLE" => "action",
			"ADD_PICT_PROP" => "-",
			"ADD_PROPERTIES_TO_BASKET" => "Y",
			"ADD_TO_BASKET_ACTION" => "ADD",
			"BASKET_URL" => "/personal/basket.php",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
			"COMPATIBLE_MODE" => "Y",
			"CONVERT_CURRENCY" => "N",
			"CUSTOM_FILTER" => "",
			"DETAIL_URL" => "",
			"DISPLAY_COMPARE" => "N",
			"ELEMENT_COUNT" => "9",
			"ELEMENT_SORT_FIELD" => "sort",
			"ELEMENT_SORT_FIELD2" => "id",
			"ELEMENT_SORT_ORDER" => "asc",
			"ELEMENT_SORT_ORDER2" => "desc",
			"ENLARGE_PRODUCT" => "STRICT",
			"FILTER_NAME" => "FILTER_SECTION_NEW",
			"HIDE_NOT_AVAILABLE" => "Y",
			"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
			"IBLOCK_ID" => "10",
			"IBLOCK_TYPE" => "1c_catalog",
			"LABEL_PROP" => array("LABELS"),
			"LABEL_PROP_MOBILE" => array("LABELS"),
			"LABEL_PROP_POSITION" => "top-left",
			"LINE_ELEMENT_COUNT" => "3",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_COMPARE" => "Сравнить",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"OFFERS_LIMIT" => "9",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"PRICE_CODE" => array("Сайт (Цена базовая)"),
			"PRICE_VAT_INCLUDE" => "Y",
			"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_PROPERTIES" => array("LABELS"),
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'6','BIG_DATA':false}]",
			"PRODUCT_SUBSCRIPTION" => "N",
			"PROPERTY_CODE" => array("LABELS", ""),
			"PROPERTY_CODE_MOBILE" => array(),
			"SECTION_URL" => "",
			"SEF_MODE" => "N",
			"SHOW_CLOSE_POPUP" => "N",
			"SHOW_DISCOUNT_PERCENT" => "N",
			"SHOW_MAX_QUANTITY" => "N",
			"SHOW_OLD_PRICE" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"SHOW_SLIDER" => "N",
			"SLIDER_INTERVAL" => "3000",
			"SLIDER_PROGRESS" => "N",
			"TEMPLATE_THEME" => "blue",
			"USE_ENHANCED_ECOMMERCE" => "N",
			"USE_PRICE_COUNT" => "N",
			"USE_PRODUCT_QUANTITY" => "N",
			"VIEW_MODE" => "SECTION"
		)
	);?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.top",
		"section__sale",
		array(
			"ACTION_VARIABLE" => "action",
			"ADD_PICT_PROP" => "-",
			"ADD_PROPERTIES_TO_BASKET" => "Y",
			"ADD_TO_BASKET_ACTION" => "ADD",
			"BASKET_URL" => "/personal/basket.php",
			"CACHE_FILTER" => "Y",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"COMPARE_NAME" => "CATALOG_COMPARE_LIST",
			"COMPATIBLE_MODE" => "Y",
			"CONVERT_CURRENCY" => "N",
			"CUSTOM_FILTER" => "",
			"DETAIL_URL" => "",
			"DISPLAY_COMPARE" => "N",
			"ELEMENT_COUNT" => "9",
			"ELEMENT_SORT_FIELD" => "sort",
			"ELEMENT_SORT_FIELD2" => "id",
			"ELEMENT_SORT_ORDER" => "asc",
			"ELEMENT_SORT_ORDER2" => "desc",
			"ENLARGE_PRODUCT" => "STRICT",
			"FILTER_NAME" => "FILTER_SECTION_SALE",
			"HIDE_NOT_AVAILABLE" => "Y",
			"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
			"IBLOCK_ID" => "10",
			"IBLOCK_TYPE" => "1c_catalog",
			"LABEL_PROP" => array("LABELS"),
			"LABEL_PROP_MOBILE" => array("LABELS"),
			"LABEL_PROP_POSITION" => "top-left",
			"LINE_ELEMENT_COUNT" => "3",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_COMPARE" => "Сравнить",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"OFFERS_LIMIT" => "9",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"PRICE_CODE" => array("Сайт (Цена базовая)"),
			"PRICE_VAT_INCLUDE" => "Y",
			"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_PROPERTIES" => array("LABELS"),
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'6','BIG_DATA':false}]",
			"PRODUCT_SUBSCRIPTION" => "N",
			"PROPERTY_CODE" => array("LABELS", ""),
			"PROPERTY_CODE_MOBILE" => array(),
			"SECTION_URL" => "",
			"SEF_MODE" => "N",
			"SHOW_CLOSE_POPUP" => "N",
			"SHOW_DISCOUNT_PERCENT" => "N",
			"SHOW_MAX_QUANTITY" => "N",
			"SHOW_OLD_PRICE" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"SHOW_SLIDER" => "N",
			"SLIDER_INTERVAL" => "3000",
			"SLIDER_PROGRESS" => "N",
			"TEMPLATE_THEME" => "blue",
			"USE_ENHANCED_ECOMMERCE" => "N",
			"USE_PRICE_COUNT" => "N",
			"USE_PRODUCT_QUANTITY" => "N",
			"VIEW_MODE" => "SECTION"
		)
	);?>
      <?$APPLICATION->IncludeComponent(
		"bitrix:catalog.products.viewed",
		"subsection__viewed",
		array(
			"ACTION_VARIABLE" => "action_cpv",
			"ADDITIONAL_PICT_PROP_10" => "-",
			"ADDITIONAL_PICT_PROP_11" => "-",
			"ADDITIONAL_PICT_PROP_26" => "-",
			"ADDITIONAL_PICT_PROP_27" => "-",
			"ADDITIONAL_PICT_PROP_30" => "-",
			"ADDITIONAL_PICT_PROP_31" => "-",
			"ADD_PROPERTIES_TO_BASKET" => "N",
			"ADD_TO_BASKET_ACTION" => "ADD",
			"BASKET_URL" => "/personal/basket.php",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"CART_PROPERTIES_10" => array(""),
			"CART_PROPERTIES_11" => array("",""),
			"CART_PROPERTIES_26" => array(""),
			"CART_PROPERTIES_27" => array("",""),
			"CART_PROPERTIES_30" => array(""),
			"CART_PROPERTIES_31" => array(""),
			"CONVERT_CURRENCY" => "N",
			"DEPTH" => "2",
			"DISPLAY_COMPARE" => "N",
			"ENLARGE_PRODUCT" => "STRICT",
			"HIDE_NOT_AVAILABLE" => "Y",
			"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
			"IBLOCK_ID" => "10",
			"IBLOCK_MODE" => "single",
			"IBLOCK_TYPE" => "1c_catalog",
			"LABEL_PROP_10" => array(""),
			"LABEL_PROP_26" => array(""),
			"LABEL_PROP_30" => array(""),
			"LABEL_PROP_31" => array(""),
			"LABEL_PROP_MOBILE_10" => array(),
			"LABEL_PROP_MOBILE_26" => array(),
			"LABEL_PROP_MOBILE_30" => array(),
			"LABEL_PROP_MOBILE_31" => array(),
			"LABEL_PROP_POSITION" => "top-left",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_BTN_SUBSCRIBE" => "Подписаться",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"OFFER_TREE_PROPS_11" => array(),
			"OFFER_TREE_PROPS_27" => array(),
			"PAGE_ELEMENT_COUNT" => "6",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"PRICE_CODE" => array("Диапазон цен", "Сайт (Цена базовая)"),
			"PRICE_VAT_INCLUDE" => "Y",
			"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
			"PRODUCT_ID_VARIABLE" => "id",
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PRODUCT_QUANTITY_VARIABLE" => "quantity",
			"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'6','BIG_DATA':false}]",
			"PRODUCT_SUBSCRIPTION" => "N",
			"PROPERTY_CODE_10" => array(""),
			"PROPERTY_CODE_11" => array("",""),
			"PROPERTY_CODE_26" => array(""),
			"PROPERTY_CODE_27" => array("",""),
			"PROPERTY_CODE_30" => array(""),
			"PROPERTY_CODE_31" => array(""),
			"PROPERTY_CODE_MOBILE_10" => array(""),
			"PROPERTY_CODE_MOBILE_26" => array(""),
			"PROPERTY_CODE_MOBILE_30" => array(""),
			"PROPERTY_CODE_MOBILE_31" => array(""),
			"SECTION_CODE" => "",
			"SECTION_ELEMENT_CODE" => "",
			"SECTION_ELEMENT_ID" => "",
			"SECTION_ID" => "",
			"SHOW_CLOSE_POPUP" => "N",
			"SHOW_DISCOUNT_PERCENT" => "N",
			"SHOW_FROM_SECTION" => "N",
			"SHOW_MAX_QUANTITY" => "N",
			"SHOW_OLD_PRICE" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"SHOW_SLIDER" => "N",
			"SLIDER_INTERVAL" => "3000",
			"SLIDER_PROGRESS" => "N",
			"TEMPLATE_THEME" => "blue",
			"USE_ENHANCED_ECOMMERCE" => "N",
			"USE_PRICE_COUNT" => "N",
			"USE_PRODUCT_QUANTITY" => "N"
		)
	);?>
	<?$APPLICATION->IncludeComponent("bitrix:subscribe.form",
	  "footer__subscription", array(
		"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"PAGE" => "#SITE_DIR#personal/subscribe/",
			"SHOW_HIDDEN" => "N",
			"USE_PERSONALIZATION" => "Y",
			"COMPONENT_TEMPLATE" => ".default"
		),
		$component
	);?>
	<a class="btn-up__link" href="#start">Наверх</a>
</main>
<?else:?>
<?

if(
	!empty($arResult['VARIABLES']['PARENT']['NAME'])
	&& !empty($arResult['VARIABLES']['PARENT']['SECTION_PAGE_URL'])
	){
	//$APPLICATION->AddChainItem($arResult['VARIABLES']['PARENT']['NAME'], $arResult['VARIABLES']['PARENT']['SECTION_PAGE_URL']); // Включит задвоение категорий в ХК
}
if(
	!empty($arResult['VARIABLES']['SECTION']['NAME'])
	&& !empty($arResult['VARIABLES']['SECTION']['SECTION_PAGE_URL'])
	){
	//$APPLICATION->AddChainItem($arResult['VARIABLES']['SECTION']['NAME'], $arResult['VARIABLES']['SECTION']['SECTION_PAGE_URL']); // Включит задвоение категорий в ХК
}
?>
<main class="category-catalog-page" id="start">
	<div class="callback-btn js-callback-btn">
		<svg class="icon-callback-btn">
			<use xlink:href="#icon-callback-btn"></use>
		</svg>
	</div>
	<div class="breadcrumbs__container centering qwe">
		<?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb",
	"breadcrumbs__breadcrumbs",
	array(
		"PATH" => "",
		"SITE_ID" => "s1",
		"START_FROM" => "0",
		"COMPONENT_TEMPLATE" => "breadcrumbs__breadcrumbs"
	),
	false
);?>
	</div>
	<section class="category-seo centering">
		<h1 class="category-seo__title"><? $APPLICATION->ShowTitle(false) //=$arResult['VARIABLES']['SECTION']['NAME'];?></h1>
	</section>
<?
/* *** */

$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"catalog__subsections",
		array(
			"ADD_SECTIONS_CHAIN" => "Y",
			"CACHE_GROUPS" => "Y",
			"CACHE_TIME" => "36000000",
			"CACHE_TYPE" => "A",
			"COUNT_ELEMENTS" => "Y",
			"IBLOCK_ID" => "10",
			"IBLOCK_TYPE" => "1c_catalog",
			"SECTION_CODE" => $arResult['VARIABLES']['SECTION_CODE'],
			"SECTION_FIELDS" => array(
				0 => "PICTURE",
				1 => "DETAIL_PICTURE",
			),
			"SECTION_ID" => $_REQUEST["SECTION_ID"],
			"SECTION_URL" => "",
			"SECTION_USER_FIELDS" => array(
				0 => "",
				1 => "",
			),
			"SHOW_PARENT_NAME" => "Y",
			"TOP_DEPTH" => "1",
			"VIEW_MODE" => "LINE",
			"COMPONENT_TEMPLATE" => ""
		),
		$component
	);

/* *** */
?>

	<section class="category-catalog centering">
		<sidebar class="category-catalog__sidebar">
			<?$APPLICATION->IncludeComponent(
				"bitrix:catalog.smart.filter",
				"real_catalog_filter",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $_REQUEST["ACTIVE_CATID"] ? intval($_REQUEST["ACTIVE_CATID"]) : $arResult['VARIABLES']['SECTION']['ID'],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"PRICE_CODE" => array("Диапазон цен"),
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SAVE_IN_SESSION" => "N",
					"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
					"XML_EXPORT" => "Y",
					"SECTION_TITLE" => "NAME",
					"SECTION_DESCRIPTION" => "DESCRIPTION",
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
					"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					"SEF_MODE" => $arParams["SEF_MODE"],
					"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
					"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
					"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
					"INSTANT_RELOAD" => 'Y',
					'SHOW_ALL_WO_SECTION' => 'Y',
					"SET_STATUS_404" => "Y",
					"SHOW_404" => "Y",
				),
				$component,
				array('HIDE_ICONS' => 'Y')
			);?>
			<?$APPLICATION->IncludeComponent(
				"bitrix:news.list",
				"subsection__sidebar",
				Array(
					"ACTIVE_DATE_FORMAT" => "d.m.Y",
					"ADD_SECTIONS_CHAIN" => "N",
					"AJAX_MODE" => "N",
					"AJAX_OPTION_ADDITIONAL" => "",
					"AJAX_OPTION_HISTORY" => "N",
					"AJAX_OPTION_JUMP" => "N",
					"AJAX_OPTION_STYLE" => "N",
					"CACHE_FILTER" => "Y",
					"CACHE_GROUPS" => "Y",
					"CACHE_TIME" => "36000000",
					"CACHE_TYPE" => "A",
					"CHECK_DATES" => "N",
					"DETAIL_URL" => "",
					"DISPLAY_BOTTOM_PAGER" => "N",
					"DISPLAY_DATE" => "Y",
					"DISPLAY_NAME" => "Y",
					"DISPLAY_PICTURE" => "Y",
					"DISPLAY_PREVIEW_TEXT" => "Y",
					"DISPLAY_TOP_PAGER" => "N",
					"FIELD_CODE" => array("NAME", "DATE_ACTIVE_FROM", "DATE_ACTIVE_TO", ""),
					"FILTER_NAME" => "SUBSECTION_SALE_SIDEBAR",
					"HIDE_LINK_WHEN_NO_DETAIL" => "N",
					"IBLOCK_ID" => "19",
					"IBLOCK_TYPE" => "content",
					"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
					"INCLUDE_SUBSECTIONS" => "Y",
					"MEDIA_PROPERTY" => "",
					"MESSAGE_404" => "",
					"NEWS_COUNT" => "2",
					"PAGER_BASE_LINK_ENABLE" => "N",
					"PAGER_DESC_NUMBERING" => "N",
					"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
					"PAGER_SHOW_ALL" => "N",
					"PAGER_SHOW_ALWAYS" => "N",
					"PAGER_TEMPLATE" => ".default",
					"PAGER_TITLE" => "Новости",
					"PARENT_SECTION" => "",
					"PARENT_SECTION_CODE" => "",
					"PREVIEW_TRUNCATE_LEN" => "",
					"PROPERTY_CODE" => array("LINK", "WIDTH", "INDEX_SLIDER_LEFT", "INDEX_SLIDER_RIGHT", "INDEX_SALE_LIST", "SECTION_LIST", "SECTION_UPPER", "SECTION_FILTER", ""),
					"SEARCH_PAGE" => "/search/",
					"SET_BROWSER_TITLE" => "N",
					"SET_LAST_MODIFIED" => "N",
					"SET_META_DESCRIPTION" => "N",
					"SET_META_KEYWORDS" => "N",
					"SET_STATUS_404" => "N",
					"SET_TITLE" => "N",
					"SHOW_404" => "N",
					"SLIDER_PROPERTY" => "",
					"SORT_BY1" => "SORT",
					"SORT_BY2" => "ACTIVE_FROM",
					"SORT_ORDER1" => "ASC",
					"SORT_ORDER2" => "DESC",
					"STRICT_SECTION_CHECK" => "N",
					"TEMPLATE_THEME" => "blue",
					"USE_RATING" => "N",
					"USE_SHARE" => "N"
				)
			);?>
		</sidebar>
		<div class="category-catalog__inner">
		<?$APPLICATION->IncludeComponent(
			"bitrix:news.list",
			"subsection__banner",
			Array(
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"ADD_SECTIONS_CHAIN" => "N",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_ADDITIONAL" => "",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_DATES" => "N",
				"DETAIL_URL" => "",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"DISPLAY_TOP_PAGER" => "N",
				"FIELD_CODE" => array("NAME", "DATE_ACTIVE_FROM", "DATE_ACTIVE_TO", ""),
				"FILTER_NAME" => "SUBSECTION_SALE_BANNER",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"IBLOCK_ID" => "19",
				"IBLOCK_TYPE" => "content",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"INCLUDE_SUBSECTIONS" => "Y",
				"MEDIA_PROPERTY" => "",
				"MESSAGE_404" => "",
				"NEWS_COUNT" => "1",
				"PAGER_BASE_LINK_ENABLE" => "N",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => ".default",
				"PAGER_TITLE" => "Новости",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"PREVIEW_TRUNCATE_LEN" => "",
				"PROPERTY_CODE" => array("LINK", "WIDTH", "INDEX_SLIDER_LEFT", "INDEX_SLIDER_RIGHT", "INDEX_SALE_LIST", "SECTION_LIST", "SECTION_UPPER", "SECTION_FILTER", "PICTURE_WIDE_MOBILE", "PICTURE_WIDE_TABLET", "PICTURE_WIDE_DESKTOP"),
				"SEARCH_PAGE" => "/search/",
				"SET_BROWSER_TITLE" => "N",
				"SET_LAST_MODIFIED" => "N",
				"SET_META_DESCRIPTION" => "N",
				"SET_META_KEYWORDS" => "N",
				"SET_STATUS_404" => "N",
				"SET_TITLE" => "N",
				"SHOW_404" => "N",
				"SLIDER_PROPERTY" => "",
				"SORT_BY1" => "SORT",
				"SORT_BY2" => "ACTIVE_FROM",
				"SORT_ORDER1" => "ASC",
				"SORT_ORDER2" => "DESC",
				"STRICT_SECTION_CHECK" => "N",
				"TEMPLATE_THEME" => "blue",
				"USE_RATING" => "N",
				"USE_SHARE" => "N"
			)
		);?>
			<div class="filter-display">
				<div class="filter-open js-filter-open">
					<span class="filter-open__desc">Фильтры</span>
					<span class="filter-status filter-status--is-empty"></span>
				</div>
			</div>

			<? if ($_REQUEST["ACTIVE_CATID"]) $GLOBALS[$arParams["FILTER_NAME"]]["SECTION_ID"] = intval($_REQUEST["ACTIVE_CATID"]); ?>
			<? $intSectionID = $APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"catalog__section",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
					"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
					"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
					"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
					"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
					"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
					"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
					"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_FILTER" => $arParams["CACHE_FILTER"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SET_TITLE" => $arParams["SET_TITLE"],
					"MESSAGE_404" => $arParams["MESSAGE_404"],
					"SET_STATUS_404" => $arParams["SET_STATUS_404"],
					"SHOW_404" => $arParams["SHOW_404"],
					"FILE_404" => $arParams["FILE_404"],
					"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
					"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
					"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
					"PRICE_CODE" => $arParams["PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],
					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],
					"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
					"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
					"PAGER_TITLE" => $arParams["PAGER_TITLE"],
					"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
					"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
					"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
					"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
					"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
					"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
					"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
					"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
					"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
					"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
					"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
					"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
					"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
					"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
					"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
					"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],
					"SECTION_ID" => $_REQUEST["ACTIVE_CATID"] ? false : $arResult["VARIABLES"]["SECTION_ID"],
					"SECTION_CODE" => $_REQUEST["ACTIVE_CATID"] ? false : $arResult["VARIABLES"]["SECTION_CODE"],
					"SECTION_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["section"],
					"DETAIL_URL" => $arResult["FOLDER"] . $arResult["URL_TEMPLATES"]["element"],
					"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
					'LABEL_PROP' => $arParams['LABEL_PROP'],
					'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
					'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
					'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
					'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
					'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
					'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
					'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
					'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
					'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
					'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
					'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
					'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],
					'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
					"ADD_SECTIONS_CHAIN" => "N",
					'ADD_TO_BASKET_ACTION' => $basketAction,
					'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
					'COMPARE_PATH' => $arResult['FOLDER'] . $arResult['URL_TEMPLATES']['compare'],
					'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
					'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : ''),
					'SHOW_ALL_WO_SECTION' => 'Y'
				),
				$component
			); ?>
			<? if ($_REQUEST['bxajaxid'] && $_REQUEST['bxajaxid'] == 'catalog-products') {
				die();
			}
			?>
			<div class="banner-help" id="request-help">
				<div class="banner-help__body">
					<div class="banner-help__info">
						<h4 class="banner-help__title">Нужна помощь в подборе товара?</h4>
						<p class="banner-help__desc">Поможем разобраться и подберем товар для вас, заполните заявку и наш специалист свяжется с вами</p>
					</div>
				<a class="help_me_btn">Сделай заказ</a>
				</div>
			</div>
		</div>
	</section>
      <?$APPLICATION->IncludeComponent(
	"bitrix:catalog.products.viewed",
	"subsection__viewed",
	array(
		"ACTION_VARIABLE" => "action_cpv",
		"ADDITIONAL_PICT_PROP_10" => "-",
		"ADDITIONAL_PICT_PROP_11" => "-",
		"ADDITIONAL_PICT_PROP_26" => "-",
		"ADDITIONAL_PICT_PROP_27" => "-",
		"ADDITIONAL_PICT_PROP_30" => "-",
		"ADDITIONAL_PICT_PROP_31" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CART_PROPERTIES_10" => array(
		),
		"CART_PROPERTIES_11" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_26" => array(
		),
		"CART_PROPERTIES_27" => array(
			0 => "",
			1 => "",
		),
		"CART_PROPERTIES_30" => array(
		),
		"CART_PROPERTIES_31" => array(
		),
		"CONVERT_CURRENCY" => "N",
		"DEPTH" => "2",
		"DISPLAY_COMPARE" => "N",
		"ENLARGE_PRODUCT" => "STRICT",
		"HIDE_NOT_AVAILABLE" => "Y",
		"HIDE_NOT_AVAILABLE_OFFERS" => "Y",
		"IBLOCK_ID" => "10",
		"IBLOCK_MODE" => "single",
		"IBLOCK_TYPE" => "1c_catalog",
		"LABEL_PROP_10" => array(
		),
		"LABEL_PROP_26" => array(
		),
		"LABEL_PROP_30" => array(
		),
		"LABEL_PROP_31" => array(
		),
		"LABEL_PROP_MOBILE_10" => "",
		"LABEL_PROP_MOBILE_26" => "",
		"LABEL_PROP_MOBILE_30" => "",
		"LABEL_PROP_MOBILE_31" => "",
		"LABEL_PROP_POSITION" => "top-left",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFER_TREE_PROPS_11" => "",
		"OFFER_TREE_PROPS_27" => "",
		"PAGE_ELEMENT_COUNT" => "6",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
			0 => "Диапазон цен",
			1 => "Сайт (Цена базовая)",
			2 => "АкцииИнтернетМагазина",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons,compare",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'6','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE_10" => array(
		),
		"PROPERTY_CODE_11" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE_26" => array(
		),
		"PROPERTY_CODE_27" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE_30" => array(
		),
		"PROPERTY_CODE_31" => array(
		),
		"PROPERTY_CODE_MOBILE_10" => array(
		),
		"PROPERTY_CODE_MOBILE_26" => array(
		),
		"PROPERTY_CODE_MOBILE_30" => array(
		),
		"PROPERTY_CODE_MOBILE_31" => array(
		),
		"SECTION_CODE" => "",
		"SECTION_ELEMENT_CODE" => "",
		"SECTION_ELEMENT_ID" => "",
		"SECTION_ID" => "",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "subsection__viewed"
	),
	false
);?>
	<?$APPLICATION->IncludeComponent("bitrix:subscribe.form",
		  "footer__subscription", array(
			"CACHE_TIME" => "3600",
				"CACHE_TYPE" => "A",
				"PAGE" => "#SITE_DIR#personal/subscribe/",
				"SHOW_HIDDEN" => "N",
				"USE_PERSONALIZATION" => "Y",
				"COMPONENT_TEMPLATE" => ".default"
			),
			$component
	);?>
	<? if (!preg_match("#PAGEN_#", $_SERVER["REQUEST_URI"]) && !preg_match("#/filter/#", $_SERVER["REQUEST_URI"])): ?>
		<section class="seo">
			<div class="seo__inner centering">
				<?/*<h4 class="seo__title"><?=$arResult['VARIABLES']['SECTION']['NAME'];?></h4>*/?>
				<?if(!empty($arResult['VARIABLES']['SECTION']['DESCRIPTION'])):?>
					<div class="category-seo__desc"><?=$arResult['VARIABLES']['SECTION']['DESCRIPTION'];?></div>
					<button class="btn-more js-btn-more">Читать дальше</button>
				<?endif;?>
			</div>
		</section>
	<? endif ?>
	<a class="btn-up__link" href="#start">Наверх</a>
</main>
<?endif;?>
