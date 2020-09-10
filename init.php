<?
define("INCLUDE_DIR", dirname(__FILE__) . "/nologostudio/");
define("PROJECT_NAME", "ОхотАктив");

define("IBLOCK_NEWS_ID", 3);
define("IBLOCK_SHOP_ID", 4);
define("IBLOCK_CITY_ID", 6);
define("IBLOCK_CATALOG_ID", 10);
define("IBLOCK_COMPLECT_ID", 11);
define("IBLOCK_REVIEWS_ID", 12);
define("IBLOCK_SETTINGS_ID", 1);
define("IBLOCK_SALE_ID", 14);

define("AVAILABLE_PROP_ID", 98);
define("LABELS_PROP_ID", 42);
define("ITEMS_PROP_ID", 73);
define("PHOTO_PROP_ID", 26);
define("LABELS_PROP_PHOTO_ID", 37239);
define("LABELS_PROP_COMPLECT_ID", 37238);

define("SELFDELIVERY_ID", 2);

define("FASTORDER_USER_ID", 9);
define("BX_CRONTAB_SUPPORT", false);
define("BASE_PRICE_ID", 1);
define("SUBSCRIBE_RUB_ID", 1);
define("LOG_FILE", "/debug.log");

CModule::IncludeModule('nologostudio.main');
/* *для инициации обмена* */
COption::SetOptionString("catalog", "DEFAULT_SKIP_SOURCE_CHECK", "Y" );
COption::SetOptionString("sale", "secure_1c_exchange", "N" );
/* *** */
require_once INCLUDE_DIR . "functions.php";
require_once INCLUDE_DIR . "CTemplate.php";
require_once INCLUDE_DIR . "CEvents.php";

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("\NLS\CEvents", "OnBeforeIBlockElementUpdate"));
AddEventHandler("sale", "OnBeforeOrderAdd", "CheckCommissionOrder");
AddEventHandler("sale", "OnOrderSave", "NewCommissionOrder");

AddEventHandler("sale", "OnBasketAdd", "AddCommissionBasket");
AddEventHandler("sale", "OnBeforeBasketAdd", "BeforeAddCommissionBasket");

use Bitrix\Sale;

function AddCommissionBasket($id, $arFields) {
    $res = CIBlockElement::GetByID($arFields["PRODUCT_ID"]);
    if($ar_res = $res->GetNext()) {
        if($ar_res["IBLOCK_ID"] === "41") {
            $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
            $basketItem = $basket->getItemById($id);
            $basketPropertyCollection = $basketItem->getPropertyCollection();
            $basketPropertyCollection->setProperty(array(
                array(
                    'NAME' => 'Комиссионный',
                    'CODE' => 'COMMISSION',
                    'VALUE' => 'Y',
                    'SORT' => 100,
                ),
            ));
            $basketPropertyCollection->save();
        }
    }

}

function BeforeAddCommissionBasket($arFields) {
    $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
    foreach ($basket as $item) {
        if((int)$item->getProductId() === $arFields["PRODUCT_ID"]) {
            return false;
        }
    }
    return true;
}

function CheckCommissionOrder(&$arFields)
{
    $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
    foreach ($arFields["BASKET_ITEMS"] as $k => $BASKET_ITEM) {
        $res = CIBlockElement::GetByID($BASKET_ITEM["PRODUCT_ID"]);
        if ($ar_res = $res->GetNext()) {
            if ($ar_res["IBLOCK_ID"] === "41") {
                //это коммиссионка
                $arCommission[] = $BASKET_ITEM["ID"];
            }
        }
    }
    if (count($arCommission) !== count($arFields["BASKET_ITEMS"]) && isset($arCommission)) {
        foreach ($arCommission as $item) {
            $basket->getItemById($item)->delete();
            $basket->save();
        }
        $arFields["PRICE"] = $basket->getPrice();
    }
}

function NewCommissionOrder($ID, $arFields, $orderFields, $isNew)
{
    if ($isNew) {
        $basket = Sale\Basket::loadItemsForFUser(Sale\Fuser::getId(), Bitrix\Main\Context::getCurrent()->getSite());
        foreach ($orderFields["BASKET_ITEMS"] as $k => $BASKET_ITEM) {
            $res = CIBlockElement::GetByID($BASKET_ITEM["PRODUCT_ID"]);
            if ($ar_res = $res->GetNext()) {
                if ($ar_res["IBLOCK_ID"] === "41") {
                    //не нужен этот товар
                    $arCommission[] = $BASKET_ITEM["PRODUCT_ID"];
                }
            }
        }
        if (count($arCommission) !== count($orderFields["BASKET_ITEMS"]) && isset($arCommission)) {
            addCommissionOrder($arCommission, $orderFields);

            $order = Sale\Order::load($ID);
            $paymentCollection = $order->getPaymentCollection();
            foreach ($paymentCollection as $payment)  {
                $payment->setField("SUM", $order->getPrice());
            }
            $order->save();
        }
    }
}
use Bitrix\Main\Context,
    Bitrix\Currency\CurrencyManager,
    Bitrix\Sale\Order,
    Bitrix\Sale\Basket,
    Bitrix\Sale\Delivery,
    Bitrix\Sale\PaySystem;
function addCommissionOrder($arProduct, $arFields)
{
    global $USER;

    Bitrix\Main\Loader::includeModule("sale");
    Bitrix\Main\Loader::includeModule("catalog");

// Допустим некоторые поля приходит в запросе
    $request = Context::getCurrent()->getRequest();
    $productId = $request["PRODUCT_ID"];
    $phone = $request["PHONE"];
    $name = $request["NAME"];
    $comment = $request["COMMENT"];


// Создаёт новый заказ
    $order = Order::create($arFields["SITE_ID"], $arFields["USER_ID"]);
    $order->setPersonTypeId($arFields["PERSON_TYPE_ID"]);
    $order->setField('CURRENCY', $arFields["CURRENCY"]);
    if ($comment) {
        $order->setField('USER_DESCRIPTION', $comment); // Устанавливаем поля комментария покупателя
    }

// Создаём корзину с одним товаром
    $basket = Basket::create($arFields["SITE_ID"]);

    // Создаём одну отгрузку и устанавливаем способ доставки - "Cамовывоз"
    $shipmentCollection = $order->getShipmentCollection();
    $shipment = $shipmentCollection->createItem();
    $service = Delivery\Services\Manager::getById(2);
    $shipment->setFields(array(
        'DELIVERY_ID' => $service['ID'],
        'DELIVERY_NAME' => $service['NAME'],
    ));
    $shipmentItemCollection = $shipment->getShipmentItemCollection();

    foreach ($arProduct as $item) {
        $item = $basket->createItem('catalog', $item);
        $item->setFields(array(
            'QUANTITY' => 1,
            'CURRENCY' => $arFields["CURRENCY"],
            'LID' => $arFields["SITE_ID"],
            'PRODUCT_PROVIDER_CLASS' => '\CCatalogProductProvider',
        ));

        $shipmentItem = $shipmentItemCollection->createItem($item);
        $shipmentItem->setQuantity($item->getQuantity());
    }
    $order->setBasket($basket);


// Создаём оплату со способом #1
    $paymentCollection = $order->getPaymentCollection();
    $payment = $paymentCollection->createItem();
    $paySystemService = PaySystem\Manager::getObjectById(1);
    $payment->setFields(array(
        'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
        'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
    ));

// Устанавливаем свойства
    $propertyCollection = $order->getPropertyCollection();
    $location = $propertyCollection->getItemByOrderPropertyId(1);
    $location->setValue($arFields["ORDER_PROP"][1]);
    $email = $propertyCollection->getItemByOrderPropertyId(2);
    $email->setValue($arFields["ORDER_PROP"][2]);
    $name = $propertyCollection->getItemByOrderPropertyId(4);
    $name->setValue($arFields["ORDER_PROP"][4]);
    $address = $propertyCollection->getItemByOrderPropertyId(5);
    $address->setValue($arFields["ORDER_PROP"][5]);
    $phone = $propertyCollection->getItemByOrderPropertyId(12);
    $phone->setValue($arFields["ORDER_PROP"][12]);
// Сохраняем
    $order->doFinalAction(true);
    $result = $order->save();
    $orderId = $order->getId();
}

//ORM
require_once INCLUDE_DIR . "ORM_ohota_favorite_items.php";
require_once INCLUDE_DIR . "ORM_ohota_items_rests.php";

require_once(dirname(__FILE__) . '/include/seo/filterMeta.php');
require_once(__DIR__ . "/include/functions.php");
// poddomenator class
// работа с поддоменами
include $_SERVER['DOCUMENT_ROOT'] . "/local/php_interface/include/seo/poddomenator.php";

//устанавливаем переменную поддомена
poddomenator::DomenSet();


global $actionFilter, $actionFooterFilter, $sectionFooterFilter, $newsFilter, $arViewedFilter, $arMainBestFilter, $arCatalogFilter;
$actionFilter = array(
    'ACTIVE' => 'Y',
    'PROPERTY_SHOW_ON_MAIN_VALUE' => 'Y',
    'TAGS' => '%акция%',
);
$actionFooterFilter = array(
    'ACTIVE' => 'Y',
    'TAGS' => '%акция%',
);
$sectionFooterFilter = array();

$newsFilter = array(
    'ACTIVE' => 'Y',
    'PROPERTY_SHOW_ON_MAIN_VALUE' => 'Y',
    '!TAGS' => ['%акция%']
);

$arMainBestFilter = array(
    'ACTIVE' => 'Y',
    'PROPERTY_LABELS' => 37236
);
$arCatalogFilter = array(
    '!CATALOG_PRICE_1' => false
);
$arViewed = unserialize($APPLICATION->get_cookie("VIEWED_ITEMS"));
if (!is_array($arViewed) or count($arViewed) == 0) {
    $arViewed = false;
}
$arViewedFilter = array(
    'ID' => $arViewed
);
global $arShopFilter;
$arShopFilter = array();

AddEventHandler('iblock', 'OnBeforeIBlockElementAdd', 'IBElementCreateHandler');

function IBElementCreateHandler(&$arFields)
{
    $SITE_ID = 's1';                         // идентификатор сайта
    $IBLOCK_ID = 8;                         // ID нужного инфоблока
    $EVENT_TYPE = 'WF_NEW_IBLOCK_ELEMENT'; // тип почтового шаблона
    if ($arFields['IBLOCK_ID'] == $IBLOCK_ID) {
        $arMailFields = array(
            "NAME" => $arFields['NAME'],
            "PREVIEW_TEXT" => $arFields["PREVIEW_TEXT"],
            "EMAIL" => $arFields["CODE"]
        );
        CEvent::Send($EVENT_TYPE, $SITE_ID, $arMailFields);
    }

    if ($arFields['IBLOCK_ID'] == 41) {
        $arFilter = array(
            'IBLOCK_ID' => 41,
            'CODE' => 'FILES',
        );
        $res = CIBlockProperty::GetList(array(), $arFilter);
        $field = $res->Fetch();
        if(is_null($arFields["DETAIL_PICTURE"])) {
            $img = $arFields["PROPERTY_VALUES"][(int)$field["ID"]]["n0"]["VALUE"];
            $arFields["DETAIL_PICTURE"] = $img;
        }
    }
}

function NLSSettings_GetSettings()
{
    return array(
        "TEMPLATE" => array(
            "NAME" => "Шаблон",
            "VARS" => array(
                "nls_header_img_default" => array(
                    "NAME" => "Шаблон: Фон заголовка по умолчанию",
                    "TYPE" => "FILE",
                    "DEFAULT" => ""
                ),
            )
        ),
        "NEWS" => array(
            "NAME" => "Новости",
            "VARS" => array(
                "nls_news_tags_cnt" => array(
                    "NAME" => "Новости: Количество тегов",
                    "DEFAULT" => ""
                ),
                "nls_news_recommendation_cnt" => array(
                    "NAME" => "Новости: Количество похожих новостей на детальной",
                    "DEFAULT" => ""
                ),
                "nls_news_widget_share" => array(
                    "NAME" => "Новости: Виджет шары",
                    "TYPE" => "TEXTAREA",
                    "DEFAULT" => ""
                ),
                "nls_news_widget_comments" => array(
                    "NAME" => "Новости: Виджет комментариев",
                    "TYPE" => "TEXTAREA",
                    "DEFAULT" => ""
                ),
            )
        ),
        "SOCIAL" => array(
            "NAME" => "Ссылки на социальные сети",
            "VARS" => array(
                "nls_social_fb" => array(
                    "NAME" => "Facebook",
                    "DEFAULT" => ""
                ),
                "nls_social_vk" => array(
                    "NAME" => "ВКонтакте",
                    "DEFAULT" => ""
                ),
                "nls_social_yt" => array(
                    "NAME" => "YouTube",
                    "DEFAULT" => ""
                ),
            )
        ),
        "MAIN" => array(
            "NAME" => "Главная страница",
            "VARS" => array(
                "nls_main_title" => array(
                    "NAME" => "Акция по умолчанию: Заголовок",
                    "DEFAULT" => ""
                ),
                "nls_main_text" => array(
                    "NAME" => "Акция по умолчанию: Текст",
                    "TYPE" => "TEXTAREA",
                    "DEFAULT" => ""
                ),
                "nls_main_image" => array(
                    "NAME" => "Акция по умолчанию: Изображение",
                    "TYPE" => "FILE",
                    "DEFAULT" => ""
                ),
            )
        ),
    );
}

function deleteOldBaskets()
{
    if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog")) {
        global $DB;
        $nDays = 10; // сроком старше 10дней
        $nDays = IntVal($nDays);
        $strSql =
            "SELECT f.ID " .
            "FROM b_sale_fuser f " .
            "LEFT JOIN b_sale_order o ON (o.USER_ID = f.USER_ID) " .
            "WHERE " .
            "   TO_DAYS(f.DATE_UPDATE)<(TO_DAYS(NOW())-" . $nDays . ") " .
            "   AND o.ID is null " .
            "   AND f.USER_ID is null " .
            "LIMIT 3000";
        $db_res = $DB->Query($strSql, false, "File: " . __FILE__ . "<br>Line: " . __LINE__);
        while ($ar_res = $db_res->Fetch()) {
            CSaleBasket::DeleteAll($ar_res["ID"], false);
            CSaleUser::Delete($ar_res["ID"]);
        }
    }
    return "deleteOldBaskets();";
}

// horse // horse // horse // horse // horse // horse // horse // horse // horse // horse // horse // horse

// Убираю выгрузку описаний и наименований товаров из 1С
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "DoNotUpdate");
function DoNotUpdate(&$arFields)
{
    if ($_REQUEST['mode'] === 'import') {
        unset($arFields['NAME']);
        unset($arFields['PREVIEW_TEXT']);
        unset($arFields['DETAIL_TEXT']);
    }
}

/* AddEventHandler("iblock", "OnBeforeIBlockElementAdd","DoNotAdd");
function DoNotAdd(&$arFields)
{
   if ($arFields['NAME'] !== '') {

   }
} */

//Товар в нескольких категориях

//AddEventHandler("iblock", "OnBeforeIBlockElementUpdate","SaveMySection");
/*function SaveMySection(&$arFields)
{
    if (@$_REQUEST['mode']=='import') // 1C?
    {
        $db_old_groups = CIBlockElement::GetElementGroups($arFields['ID'], true);
        while($ar_group = $db_old_groups->Fetch())
        {
           if(!in_array($ar_group['ID'],$arFields['IBLOCK_SECTION']))
            $arFields['IBLOCK_SECTION'][]=$ar_group['ID'];
        }
    }
}*/

// canonicals
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "Canonicals");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "Canonicals");

function Canonicals(&$arFields)
{

    CModule::IncludeModule("iblock");
    CModule::IncludeModule("catalog");
    CModule::IncludeModule('sale');

    /*$el = new CIBlockElement; */

    $arFilter = Array(
        "IBLOCK_ID" => 10, "ACTIVE" => "Y", "!PROPERTY_SRODITELKHARAKTERISTIKIDLYASAYTA" => false, "ID" => $arFields['ID']
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, Array("ID", "PROPERTY_SRODITELKHARAKTERISTIKIDLYASAYTA"));
    $ar_fields = $res->GetNext();
    $property_enums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => 10, "ID" => $ar_fields['PROPERTY_SRODITELKHARAKTERISTIKIDLYASAYTA_ENUM_ID'], "CODE" => "SRODITELKHARAKTERISTIKIDLYASAYTA"));
    $enum_fields = $property_enums->GetNext();

    $arFilter2 = Array(
        "IBLOCK_ID" => 10, "ACTIVE" => "Y", "XML_ID" => $enum_fields['XML_ID']
    );
    $res = CIBlockElement::GetList(Array(), $arFilter2, Array("ID", "PARENT")); // получил предка
    $ar_fields = $res->GetNext();

    $el_res = CIBlockElement::GetByID($ar_fields['ID']);
    $el_arr = $el_res->GetNext();

    $arLoadProductArray = Array(
        "PROPERTY_VALUES" => array(
            "CANONICAL" => $el_arr['DETAIL_PAGE_URL'],
        ),
    );

    if ($arFields['ID'] !== $ar_fields['ID']) {
        CIBlockElement::SetPropertyValuesEx($arFields['ID'], 10, array('CANONICAL' => $el_arr['DETAIL_PAGE_URL'])); // поставил каноникал текучке
        CIBlockElement::SetPropertyValuesEx($ar_fields['ID'], 10, array('CANONICAL' => $el_arr['DETAIL_PAGE_URL'])); // поставил каноникал паренту
        /*$res = $el->Update($arFields['ID'], $arLoadProductArray);
        $res = $el->Update($ar_fields['ID'], $arLoadProductArray);*/
    }

    /* ************option********** */
    /*$enum_list = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID"=>10, "CODE"=>"SRODITELKHARAKTERISTIKIDLYASAYTA", "XML_ID"=>$enum_fields['XML_ID']));

    $arEnumIsMain = $enum_list->GetNext();
    $EnumID = $arEnumIsMain ["ID"];

    $arFilter3 = Array(
    "IBLOCK_ID"=>10, "ACTIVE"=>"Y", array("PROPERTY"=>array("SRODITELKHARAKTERISTIKIDLYASAYTA"=>$EnumID)) // Все товары с таким enum
    );

    $res = CIBlockElement::GetList(Array(), $arFilter3, Array("ID"));

    while ($ar_fields = $res->GetNext()) {
    if ($ar_fields['ID'] != $arFields['ID']) // Кроме себя самого 2
    $child_string .= $ar_fields['ID'].", ";
    }

    CIBlockElement::SetPropertyValuesEx($arFields['ID'], 10, array('PARENT' => $child_string)); // поставил предка ребенку

    $arLoadProductArrayParent = Array(
    "PROPERTY_VALUES"=>array(
    "PARENT"=>$child_string,
    ),
      );
*/
    /*$res = $el->Update($arFields['ID'], $arLoadProductArrayParent);*/

}


AddEventHandler("main", "OnAfterUserAdd", "OnAfterUserRegisterHandler");
AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");
function OnAfterUserRegisterHandler(&$arFields)
{
    if (intval($arFields["ID"]) > 0) {
        $toSend = Array();
        $toSend["PASSWORD"] = $arFields["USER_CONFIRM_PASSWORD"];
        $toSend["EMAIL"] = $arFields["EMAIL"];
        $toSend["USER_ID"] = $arFields["ID"];
        $toSend["USER_IP"] = $arFields["USER_IP"];
        $toSend["USER_HOST"] = $arFields["USER_HOST"];
        $toSend["LOGIN"] = $arFields["LOGIN"];
        $toSend["NAME"] = (trim($arFields["NAME"]) == "") ? $toSend["NAME"] = htmlspecialchars('<Не указано>') : $arFields["NAME"];
        $toSend["LAST_NAME"] = (trim($arFields["LAST_NAME"]) == "") ? $toSend["LAST_NAME"] = htmlspecialchars('<Не указано>') : $arFields["LAST_NAME"];
        CEvent::SendImmediate("HORSE_USER_REGISTER", SITE_ID, $toSend);
    }
    return $arFields;
}

AddEventHandler("main", "OnBeforeUserRegister", Array("LoginEtoEmail", "OnBeforeUserRegisterHandler"));
AddEventHandler("main", "OnBeforeUserAdd", Array("LoginEtoEmail", "OnBeforeUserRegisterHandler"));

class LoginEtoEmail
{
    function OnBeforeUserRegisterHandler(&$arFields)
    {
        //$arFields["LOGIN"] = $arFields["EMAIL"];
    }
}


//регистрация пользователя будет записана в аналитику
AddEventHandler("main", "OnAfterUserRegister", "OnUserEmailLoginRegisterHandler");

function OnUserEmailLoginRegisterHandler(&$arFields)
{

    if (CModule::IncludeModule("statistic") && intval($_SESSION["SESS_SEARCHER_ID"]) <= 0) {
        $event1 = "register";
        $event2 = "new_user";
        $event3 = $arFields["EMAIL"];
        CStatistic::Set_Event($event1, $event2, $event3);
    }
    return $arFields;
}

// Причина отмены в заказ из 1С и на почту юзеру

//AddEventHandler("main", "OnSaleCancelOrder", "SaleOrderHorse");  //Надо все же попробовать повесить на событие

function SaleOrderHorse()
{

    foreach (glob("/var/www/sibirix2/data/www/ohotaktiv.ru/upload/1c_exchange/Documents*.xml") as $file) { //маска искомого имени файла

        echo "xml: " . $file . "<br><br>";

    }

    $xml = simplexml_load_file("$file"); //загрузить этот файл

    foreach ($xml->Документ as $item) { //ищем верхний тег

        $or_id = $item->Ид; //ищем нижний тег

        $or_reason = $item->ПричинаОтмены; //ищем еще глубже

        echo "id: " . $or_id . '<br>';

        echo "reason: " . $or_reason . "<br>";

        if (!empty($or_reason)) {

            CSaleOrder::CancelOrder($or_id, "Y", $or_reason);

        }

    }

}

AddEventHandler('main', 'OnEndBufferContent', 'controller404', 1001);
function _Check404Error()
{
    if (defined('ERROR_404') && ERROR_404 == 'Y' || CHTTP::GetLastStatus() == "404 Not Found") {
        GLOBAL $APPLICATION;
        $APPLICATION->RestartBuffer();
        require $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/header.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/404.php';
        require $_SERVER['DOCUMENT_ROOT'] . SITE_TEMPLATE_PATH . '/footer.php';
    }
}

AddEventHandler("main", "OnEndBufferContent", "includeCssInline");

function includeCssInline(&$content)
{
    if (\Bitrix\Main\Context::getCurrent()->getRequest()->isAdminSection() || $GLOBALS['APPLICATION']->GetProperty("save_kernel") == "Y")
        return;

    if (!preg_match_all("/<link href=\"([^\"\?]+)(\?\d+)?\"[^>]+>/", $content, $matches))
        return;

    $paths = $matches[1];
    $remove = [];

    $hash = sha1(array_reduce($paths, function ($str, $path) {
        return $str . $path;
    }));

    $cache = $_SERVER['DOCUMENT_ROOT'] . "/bitrix/cache/css/s1/pages/$hash";

    if (!is_file(dirname($cache))) {
        mkdir(dirname($cache));
    }

    if (is_file($cache)) {
        $css = file_get_contents($cache);
        $remove = $matches[0];
    } else {
        $css = "";

        foreach ($paths as $i => $path) {
            $url = "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $path;

            if ($part = file_get_contents($url)) {
                $part = preg_replace_callback(
                    "/url\([\"\']?(?P<char>(?!(http:\/\/)|(\/)|(https:\/\/)|(data:image)|(\')|(\")).)/",
                    function ($matches) use ($url) {
                        return "url(" . dirname($url) . "/" . $matches['char'];
                    },
                    $part
                );

                $css .= $part;
                $remove[] = $matches[0][$i];
            }
        }

        file_put_contents($cache, $css);
    }

    $content = str_replace($remove, "", $content);
    $content = str_replace("<body>", "<body><style>$css</style>", $content);
}

//controller for down
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", Array("MyClass", "OnBeforeIBlockElementUpdateHandler"));

class MyClass
{
    function OnBeforeIBlockElementUpdateHandler(&$arFields)
    {
        global $DB, $USER;
        $username = $USER->GetID();
        $text = $arFields['DETAIL_TEXT'];
        $prev_pic = $row['PREVIEW_PICTURE'];
        $detail_pics = $row['DETAIL_PICTURE'];

        $prod_id = $arFields['ID'];
        $url = $arFields['ID'];

        $before = $DB->Query("SELECT DETAIL_PICTURE, PREVIEW_PICTURE, DETAIL_TEXT,TIMESTAMP_X FROM b_iblock_element WHERE ID = '{$prod_id}'");

        while ($row = $before->Fetch()) {
            $rrr = $row['DETAIL_TEXT'];

            $new_prev_pic = $row['PREVIEW_PICTURE'];
            $new_detail_pics = $row['DETAIL_PICTURE'];

            $rrr = preg_replace('/\s?<style[^>]*?>.*?<\/style>\s?/si', ' ', $rrr);
            $rrr = preg_replace('/\s?<script[^>]*?>.*?<\/script>\s?/si', ' ', $rrr);
            $rrr = preg_replace('/\s?<span[^>]*?>.*?<\/span>\s?/si', ' ', $rrr);

            $text = preg_replace('/\s?<style[^>]*?>.*?<\/style>\s?/si', ' ', $text);
            $text = preg_replace('/\s?<script[^>]*?>.*?<\/script>\s?/si', ' ', $text);
            $text = preg_replace('/\s?<span[^>]*?>.*?<\/span>\s?/si', ' ', $text);

            $date_edit = $row['TIMESTAMP_X'];

            if ($username = 13692) {
                $results = $DB->Query("INSERT INTO Reports VALUES ('', '{$username}', '{$url}', '{$date_edit}', '{$detail_pics}','{$new_detail_pics}')");
            } else {
                $results = $DB->Query("INSERT INTO Reports VALUES ('', '{$username}', '{$url}', '{$date_edit}', '{$rrr}','{$text}')");
            }
        }
    }
}

/* Склонение существительного в зависимости от числительного */
if (!function_exists('getPluralForm')) {
    function getPluralForm($number, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($number % 100 > 4 && $number % 100 < 20) ? 2 : $cases[min($number % 10, 5)]];
    }
}

/* Получение списка избранного */
if (!function_exists('getFavorite')) {
    function getFavorite()
    {
        global $USER;
        $rsUser = CUser::GetByID($USER->GetID());
        $arUser = $rsUser->Fetch();
        return empty($arUser['UF_FAVORITE']) ? '' : $arUser['UF_FAVORITE'];
    }
}
/* Обновление списка избранного */
if (!function_exists('updateFavorite')) {
    function updateFavorite($productList)
    {
        global $USER;
        if (is_array($productList)) {
            $user = new CUser;
            $user->Update($USER->GetID(), array('UF_FAVORITE' => json_encode($productList)));
            return false;
        } else {
            die('Передан неправильный тип данных.');
        }
    }
}

/* Проверка идентичности старого и нового паролей */
AddEventHandler('main', 'OnBeforeUserUpdate', 'checkAgainstOldPassword');

if (!function_exists('checkAgainstOldPassword')) {
    function checkAgainstOldPassword(&$arFields)
    {
        global $USER;
        global $APPLICATION;
        $idUser = $USER->GetID();
        $rsUser = CUser::GetByID($idUser);
        $userData = $rsUser->Fetch();
        $oldPassword = $userData['PASSWORD'];
        $salt = substr($oldPassword, 0, (strlen($oldPassword) - 32));
        $newPassword = $salt . md5($salt . $arFields['PASSWORD']);
        if ($oldPassword == $newPassword) {
            $APPLICATION->throwException('Новый пароль идентичен старому. Пожалуйста выберите другой новый пароль.');
            return false;
        }
    }
}

//склонение - declination(10, 'день', 'дня', 'дней')
function declination($num, $one, $ed, $mn, $full = true) {
    if ((int) $num == 0)
        return '';
    if ($full)
        if (($num == "0") or (($num >= "5") and ($num <= "20")) or preg_match("|[056789]$|", $num))
            return $mn;
    if (preg_match("|[1]$|", $num))
        return $one;
    if (preg_match("|[234]$|", $num))
        return $ed;
    return '';
}

function closeCommission() {
    CModule::IncludeModule('iblock');
    $arSelect = array("ID", "ACTIVE_TO");
    $arResult = array();
    $now = new DateTime();
    $res = CIBlockElement::GetList(Array("sort" => "desc"), array("IBLOCK_ID" => 41, "ACTIVE" => "Y", "<ACTIVE_TO" => $now->format('d.m.Y')), false, false, $arSelect);
    while($ob = $res->GetNext())
    {
       if(!is_null($ob["ACTIVE_TO"])) {
//           $iBlockElement = new CIBlockElement();
//
//           $arLoadProductArray = Array(
//               "ACTIVE"         => "N",
//           );
//           $PRODUCT_ID = $iBlockElement->Update($ob["ID"], $arLoadProductArray);
           CIBlockElement::SetPropertyValuesEx($ob["ID"], false, array("STATUS" => 42148659, "STATUS_COMMENT" => "Срок объявления истек"));
           sendEmailOnChangeStatusCommission($ob["ID"]);
       }
    }
}

AddEventHandler('sale', 'OnSaleStatusOrder', 'closeCommissionAfterOrder');

function closeCommissionAfterOrder($id, $val) {
    if($val === "CF") {
        $order = Sale\Order::load($id);
        $basket = $order->getBasket();
        $basketItems = $basket->getBasketItems();
        foreach ($basketItems as $BASKET_ITEM) {
            $res = CIBlockElement::GetByID($BASKET_ITEM->getProductId());
            if ($ar_res = $res->GetNext()) {
                if ($ar_res["IBLOCK_ID"] === "41") {
                    CModule::IncludeModule('iblock');
                    //это коммиссионка
//                    $iBlockElement = new CIBlockElement();
//
//                    $arLoadProductArray = Array(
//                        "ACTIVE"         => "N",
//                    );
//                    $PRODUCT_ID = $iBlockElement->Update($BASKET_ITEM->getProductId(), $arLoadProductArray);
                    CIBlockElement::SetPropertyValuesEx($BASKET_ITEM->getProductId(), false, array("STATUS" => 42148659, "STATUS_COMMENT" => "Товар заказан"));
                    sendEmailOnChangeStatusCommission($BASKET_ITEM->getProductId());
                }
            }
        }
    }

}

AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "changeStatusCommissionAfter");
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "changeStatusCommissionBefore");

function changeStatusCommissionAfter($arFields) {
    if($arFields["IBLOCK_ID"] === "41") {
        $db_props = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array("sort" => "asc"), Array("CODE"=>"STATUS"));
        if($ar_props = $db_props->Fetch()) {
            if($_SESSION["OLD_STATUS"] !== $ar_props["VALUE"]) {
                sendEmailOnChangeStatusCommission($arFields["ID"]);
            }
        }
    }
}

function changeStatusCommissionBefore($arFields) {
    if($arFields["IBLOCK_ID"] === 41) {
        $db_props = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], array("sort" => "asc"), Array("CODE"=>"STATUS"));
        if($ar_props = $db_props->Fetch()) {
            session_start();
            $_SESSION["OLD_STATUS"] = $ar_props["VALUE"];
        }
    }
}

function sendEmailOnChangeStatusCommission($id) {
    CModule::IncludeModule('iblock');
    $arSelect = Array("ID", "ACTIVE_FROM", "PROPERTY_EMAIL_USER", "PROPERTY_STATUS");
    $arFilter = Array("IBLOCK_ID" => 41, "ID" => $id);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    if($ob = $res->GetNext()) {
        $arFields = array(
            "ID" => $ob["ID"],
            "DATE" => $ob["ACTIVE_FROM"],
            "STATUS" => $ob["PROPERTY_STATUS_VALUE"],
            "EMAIL" => $ob["PROPERTY_EMAIL_USER_VALUE"],
        );
    }

    CEvent::SendImmediate("ChangeStatusCommission", "s1", $arFields);
}

// Обновление свойства IS_AVAILABLE - доступность на складах для сортировки
AddEventHandler("catalog", "OnBeforeProductAdd", "OnBeforeIBlockElement");
AddEventHandler("catalog", "OnBeforeProductUpdate", "OnBeforeIBlockElement");
function OnBeforeIBlockElement($ID, $arFields = false)
{

if(is_array($ID))
{
$arFields = $ID;
$ELEMENT_ID = $arFields["ID"];                    
}
elseif(is_int($ID) && is_array($arFields) && isset($arFields["PROPERTY_IS_AVAILABLE"]))
{
$ELEMENT_ID = $ID;                    
}
/* *** */                    
                    $rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
                    'filter' => array('=PRODUCT_ID'=>$ELEMENT_ID,'STORE.ACTIVE'=>'Y'),
                    ));
                    $real_amount = 0;
                    while($arStoreProduct=$rsStoreProduct->fetch())
                    {
                    $real_amount += $arStoreProduct['AMOUNT'];
                    }
                    if ($real_amount > 0) {
                    $is_aviable = 1;
                    } else {
                    $is_aviable = 0;    
                    }
/* *** */
CIBlockElement::SetPropertyValuesEx($ELEMENT_ID, false, array("IS_AVAILABLE" => $is_aviable));

}

/* Уведомление когда добавлен комиссионный товар */
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("OnAfterArticleAdd", "OnAfterIBlockElementAddHandlerLast"));
class OnAfterArticleAdd {
    function OnAfterIBlockElementAddHandlerLast(&$arFields) {
        if ($arFields["IBLOCK_ID"] == 41) {

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $ad_id = $arFields['ID'];
            $message = 'Название: '.$arFields['NAME'].'<br>'.'ID: '.$ad_id."<br><a href='https://ohotaktiv.ru/bitrix/admin/cat_product_edit.php?IBLOCK_ID=41&type=1c_catalog&ID=".$ad_id."&lang=ru&find_section_section=-1&WF=Y'>Посмотреть объявление</a>";
            mail('ohotaktiv@list.ru', 'Добавлено объявление', $message, $headers);
        }
    }
}

/* Уведомление когда добавлен овый отзыв на товар */
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("OnAfterReviewAdd", "OnAfterIBlockElementAddHandlerLast"));
class OnAfterReviewAdd {
    function OnAfterIBlockElementAddHandlerLast(&$arFields) {
        if ($arFields["IBLOCK_ID"] == 12) {

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $review_id = $arFields['ID'];
            $message = 'Отзыв: '.$arFields['PREVIEW_TEXT'].'<br>'.'Товар: '.$review_id."<br><a href='https://ohotaktiv.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=12&type=1c_catalog&ID=".$review_id."&lang=ru&find_section_section=-1&WF=Y'>Посмотреть отзыв</a>";
            mail('ohotaktiv@list.ru', 'Добавлен отзыв на товар', $message, $headers);
        }
    }
}
