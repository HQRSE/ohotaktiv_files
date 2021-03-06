<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

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
$arGeoData = $arParams["GEODATA"];
$strMainID = $this->GetEditAreaId($arResult['ID']);
?><section class="product-intro centering">
    <div class="product-intro__images">
        <div class="swiper-container product-intro__slider js-product-intro__slider">
            <div class="swiper-wrapper">
                <? $k = 1;
                foreach($arResult['IMAGES'] as $arPic) :
                    if ($arPic['PIC']['SRC']) : ?>
                <a class="swiper-slide product-intro__slide">
					<?
					if (file_exists($_SERVER["DOCUMENT_ROOT"]."/".$arPic['PIC']['SRC']) == 1) {
					$norm_img = $arPic['PIC']['SRC'];
					} else {
					$norm_img = "/local/templates/ohota2020/img/no_photo.png";
					}
					?>
                    <img class="product-intro__slide-img" src="<?=$norm_img?>" alt="slide-<?=$k?>"/>
                </a>
                <?endif;
                 $k++;
                endforeach;?>
                <?$this->SetViewTarget('product_image');?>
                	<meta property="og:image" content="<?='https://'.$_SERVER['HTTP_HOST'].$arResult['IMAGES'][1]["PIC"]["SRC"]?>"/>
				<?$this->EndViewTarget();?>
            </div>
            <div class="product-intro__status">
                <?foreach($arResult['PROPERTIES']['LABELS']['VALUE_XML_ID'] as $strVal) {
                    switch ($strVal) {
                        case 'NEW':
                            ?><div class="card-prod__status card-prod__status--new">Новинка</div><?
                            break;
                        case 'BESTSELLER':
                            ?><div class="product-intro__status-hit">Хит</div><?
                            break;
                        case 'DISCOUNT':
                            ?><div class="product-intro__status-sale"><?=$arResult['PROPERTIES']['DISCOUNT']['VALUE']?>Скидка</div><?
                            break;
                        case 'COMPLECT':
                            ?><?
                            break;
                        case 'PHOTO':
                            ?><?
                            break;

                        default:
                            # code...
                            break;
                    }
                }
                ?>
            </div>

			<?
			if (!empty($arResult['MODIFIER']['SPECIAL_PRICE'])) {
			?>
   			<div class="product-intro__status">
       		<div class="product-intro__status-sale">Спеццена</div>
   			</div>
			<? } ?>
<?
/* **************************************** */
global $USER;
if ($USER->IsAdmin()) {
	//print_r($arResult['MORE_PHOTO']);
echo "------------------>";
	//print_r($arResult['IMAGES']);
}
/* **************************************** */
?>

            <div class="product-intro__actions">
                <div class="product-intro__actions-fav js-fav-prod" data-tooltip="Добавить в избранное" data-id="<?=$arResult['ID'];?>"></div>
				<?
				global $USER;
				if ($USER->IsAdmin()) { ?>

				<a href="javascript:void(0)"  class="wishbtn  <? if (in_array($arResult["ID"],$arBasketItems )) echo 'in_wishlist '; ?>"
       				onclick="add2wish(
           			'<?=$arResult["ID"]?>',
            		'<?=$arResult["CATALOG_PRICE_ID_1"]?>',
            		'<?=$arResult["CATALOG_PRICE_1"]?>',
            		'<?=$arResult["NAME"]?>',
            		'<?=$arResult["DETAIL_PAGE_URL"]?>',
            		this)">
            	<div class="product-intro__actions-fav js-fav-prod" data-tooltip="Добавить в избранное"></div>
    			</a>

				<? } ?>
                <div class="product-intro__actions-compare js-compare-prod" data-tooltip="Добавить в сравнение" data-id="<?=$arResult['ID'];?>"></div>
            </div>
            <div class="swiper-pagination product-intro__slider-pagination js-product-intro__slider-pagination"></div>
            <div class="swiper-button-prev product-intro__btn-prev">
                <svg class="icon-arrow-slider icon-arrow-slider-prev">
                    <use xlink:href="#icon-arrow-slider-prev"></use>
                </svg>
            </div>
            <div class="swiper-button-next product-intro__btn-next">
                <svg class="icon-arrow-slider icon-arrow-slider-next">
                    <use xlink:href="#icon-arrow-slider-prev"></use>
                </svg>
            </div>
        </div>
        <div class="swiper-container product-intro__slider-thumb js-product-intro__slider-thumb">
            <div class="swiper-wrapper">
                <? $k = 1;
                foreach($arResult['IMAGES'] as $arPic) :
                    if ($arPic['THUMB']['SRC']) : ?>
                <a class="swiper-slide product-intro__slide-thumb">
					<?
					if (file_exists($_SERVER["DOCUMENT_ROOT"]."/".$arPic['THUMB']['SRC']) == 1) {
					$norm_img = $arPic['THUMB']['SRC'];
					} else {
					$norm_img = "/local/templates/ohota2020/img/no_photo.png";
					}
					?>
                    <img class="product-intro__slide-img" src="<?=$norm_img?>" alt="slide-<?=$k?>"/>
                </a>
                <?endif;
                $k++;
                endforeach; ?>
            </div>
        </div>
    </div>
<!-- end images -->

    <h1 class="product-intro__title"><?=$arResult['NAME']?></h1>
    <div class="product-intro__features-and-buy">
        <div class="product-intro__features">
            <div class="product-intro__features-inner">
                <p class="product-intro__features-desc">Артикул: <?=$arResult['PROPERTIES']['CML2_ARTICLE']['VALUE']?></p>
                <p class="product-intro__features-desc product-intro__feature-desc--desk">Модель: <?=$arResult['PROPERTIES']['MODEL']['VALUE']?></p>
                <p class="product-intro__features-desc product-intro__feature-desc--desk">Серия: TG2</p>
                <p class="product-intro__features-desc product-intro__feature-desc--desk">Калибр: <?=$arResult['PROPERTIES']['KALIBR']['VALUE']?></p>
            </div><a class="product-intro__features-link" href="#product-info">Все характеристики</a>
        </div>
        <div class="product-intro__buy">
            <div class="product-intro__counter">
                	<?
					$pid = $arResult['ID'];
					$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
    				'filter' => array('=PRODUCT_ID'=>$pid,'STORE.ACTIVE'=>'Y'),
					));

					$real_amount = 0;
					while($arStoreProduct=$rsStoreProduct->fetch())
					{
					$real_amount += $arStoreProduct['AMOUNT'];
					}?>
					<div class="real_aviable_info">
						<h3>Наличие</h3>
						<?if($real_amount <= 0 && $arResult['MODIFIER']['MAX'] <= 0) {?>
                    		<span class="prod-counter__label noaviable">Товар временно недоступен</span>
						<?} elseif ($real_amount > 0) {?>
							<div class="product-intro__features">
							<span class="prod-counter__label">В наличии <a class="real-stock-link" href="#availability">в магазинах</a></span>
							</div>
						<?} if ($arResult['MODIFIER']['MAX'] > 0) {
						if ($arResult['MODIFIER']['MAX'] > 0 && $arResult['MODIFIER']['MAX'] < 10) {$count_class = 'malo';$count_value = 30;}
						if ($arResult['MODIFIER']['MAX'] > 10 && $arResult['MODIFIER']['MAX'] < 70) {$count_class = 'sredny';$count_value = 65;}
						if ($arResult['MODIFIER']['MAX'] > 70) {$count_class = 'mnogo';$count_value = 99;}
						?>
							<div class="product-intro__features">
								<span class="prod-counter__label">В наличии на складе <span class="count_avi"><?=$count?></span><?if ($USER->IsAdmin()) {?>

<?}?></span><progress id="progressbar" value="<?=$count_value?>" max="100" class="<?=$count_class?>"></progress>
							</div>
						<?}?>
					</div>
				<div class="prod-counter__box">
					<div class="prod-counter-less-btn js-counter-minus-btn"></div>
						<input type="number" min="1" step="1" max="9999" class="amount-basket js-amount-value" value="1"></input>
						<!--  <span class="amount-basket js-amount-value">1</span> -->
						<div class="prod-counter-more-btn js-counter-plus-btn"></div>
				</div>
				<div class="avi_detail">
					<span class="avi_info_detail">Для уточнения наличия товара в вашем городе звоните по телефону <a href="tel:tel:88007008256">8 (800) 700 82 56</a></span>
				</div>
				<?
				global $USER;
				if ($USER->IsAdmin()) {
				?>
<!--
				<div class="prod-counter__box">
					<a href="javascript:void(0)" onclick="BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>').value--;" class="prod-counter-less-btn js-counter-minus-btn"></a>
						<input type="number" min="1" step="1" max="9999" class="amount-basket js-amount-value" value="1"></input>
					<a href="javascript:void(0)" onclick="BX('<?echo $arParams["PRODUCT_QUANTITY_VARIABLE"]?>').value++;" class="prod-counter-more-btn js-counter-plus-btn"></a>
				</div>
-->
				<? } ?>
            </div>
            <div class="product-intro__price">
			<? if($real_amount <= 0) : ?>
                <h4 class="product-intro__price-title">Цена последней поставки</h4>
			<? else:?>
				<h4 class="product-intro__price-title">Цена:</h4>
			<? endif; ?>

			<script>
				function add2wish(p_id, pp_id, p, name, dpu, th){
            	$.ajax({
                type: "POST",
                url: "/local/ajax/wishlist.php",
                data: "p_id=" + p_id + "&pp_id=" + pp_id + "&p=" + p + "&name=" + name + "&dpu=" + dpu,
                		success: function(html){
                    		$(th).addClass('in_wishlist');
                    	$('#wishcount').html(html);
                		}
            			});
        		};
			</script>

                <div class="product-intro__price-group">
					<? if (!empty($arResult['MODIFIER']['PRICE']) && empty($arResult['MODIFIER']['SPECIAL_PRICE'])) { ?>
					<span class="product-intro__price-current"><?=$arResult['MODIFIER']['PRICE'];?><span class="rub">₽</span></span>
					<? } elseif (!empty($arResult['MODIFIER']['SPECIAL_PRICE'])) { ?>
					<span class="product-intro__price-current"><?=$arResult['MODIFIER']['SPECIAL_PRICE'];?><span class="rub">₽</span></span>
					<? } ?>
					<?if(!empty($arResult['MODIFIER']['OLD_PRICE'])):?>
					<span class="product-intro__price-old"><?=$arResult['MODIFIER']['OLD_PRICE'];?><span class="rub">₽</span></span>
					<?endif;?>
                </div>
            </div>
			<!-- end price -->

            <div class="product-intro__btns">
				<a class="card-prod" style="width: unset !important;"
					data-id="<?=$arResult['ID']?>"
					data-quantity="1"
					data-name="<?=$arResult['NAME'];?>"
					data-img="<?=$arResult['PREVIEW_PICTURE']['SRC'];?>"
					data-current="<?=$arResult['MODIFIER']['PRICE'];?>"
					data-old="<?=$arResult['MODIFIER']['OLD_PRICE'];?>"
					data-delivery="0"
					data-license="<?=$arResult['MODIFIER']['LICENSE'];?>"
					data-max="<?=$arResult['MODIFIER']['MAX'];?>"
					data-url="<?=$arResult['DETAIL_PAGE_URL'];?>"
				>

				<?
					if (!empty($arResult['MODIFIER']['PRICE']) && empty($arResult['MODIFIER']['SPECIAL_PRICE'])) {
						$current_price = $arResult['MODIFIER']['PRICE'];
					} elseif (!empty($arResult['MODIFIER']['SPECIAL_PRICE'])) {
						$current_price = $arResult['MODIFIER']['SPECIAL_PRICE'];
					}
					if(!empty($arResult['MODIFIER']['OLD_PRICE']))
						$old_price = $arResult['MODIFIER']['OLD_PRICE'];
				?>

				<?if($real_amount <= 0 && $arResult['MODIFIER']['MAX'] <= 0) {?>
						<button type="button" class="product-intro__btn-add mybuttonlol_cart show_me_order_form" id="<?=$arResult['ID'];?>"
						data-url="<?=$arResult['DETAIL_PAGE_URL'];?>"
						data-id="<?=$arResult['ID']?>"
						data-current-price="<?=$current_price?>"
						data-old-price="<?=$old_price?>"
						data-name="<?=$arResult['NAME'];?>"
						>
							Заказать
						</button>
						<?} else {?>
						<button name="<?echo $arParams["ACTION_VARIABLE"]."ADD2BASKET"?>" class="product-intro__btn-add js-btn-add-basket card-prod__add mybuttonlol real_order" id="<?=$arResult['ID'];?>" data-url="<?=$arResult['DETAIL_PAGE_URL'];?>" onclick="ym(42989679,'reachGoal','basket');">
							В корзину
						</button>
				<?
				}
				?>
				</a>
				<!-- end buttons buy/order -->

				<? if($real_amount <= 0 && $arResult['MODIFIER']['MAX'] <= 0) : ?>
					<button class="product-intro__btn-add product-intro__btn-add--click" disabled="disabled">Купить в 1 клик</button>
				<?else:?>
					<button class="product-intro__btn-add product-intro__btn-add--click" onclick="openForm()">Купить в 1 клик</button>
				<?endif;?>

				<!-- modal one click -->
				<div class="one-click-bg" id="full-click" style="display:none;">
					<div class="form-popup-one-click" id="myForm">
						<form action="" class="form-container">
    						<div class="aboc-modal-header">Заказ в 1 клик</div>
								<div class="product-info">
									<div class="api-product">
										<div class="api-name"><?=$arResult['NAME']?></div>
											<div class="api-prices">
												<div class="api-info-left">
													<div class="api-price"><span style="font-weight: 400;">Цена: </span>
													<? if (!empty($arResult['MODIFIER']['PRICE']) && empty($arResult['MODIFIER']['SPECIAL_PRICE'])) { ?>
														<span class="product-intro__price-current"><?=$arResult['MODIFIER']['PRICE'];?><span class="rub">₽</span></span>
													<? } elseif (!empty($arResult['MODIFIER']['SPECIAL_PRICE'])) { ?>
														<span class="product-intro__price-current"><?=$arResult['MODIFIER']['SPECIAL_PRICE'];?><span class="rub">₽</span></span>
													<? } ?>
													<?if(!empty($arResult['MODIFIER']['OLD_PRICE'])):?>
														<span class="product-intro__price-old"><?=$arResult['MODIFIER']['OLD_PRICE'];?><span class="rub">₽</span></span>
													<?endif;?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="aboc-modal-close aboc-close" onclick="closeForm()"></div>
									<div class="aboc-modal-text-before">Оставьте пожалуйста свои контактные данные.<br>
										Наши менеджеры свяжутся с вами для уточнения деталей заказа.</div>
										<div class="aboc-form-field">
    										<input type="tel" placeholder="8-(___)-___-__-__" class="one_phone" name="phone" required>
										</div>
											<input type="hidden" name="id" value="<?=$arResult['ID'];?>">
										<div class="aboc-form-row aboc-form-submit">
    										<input type="submit" class="btn-click" value="Отправить">
										</div>
    									<!-- <button type="button" class="btn cancel" onclick="closeForm()">Закрыть</button> -->
										<div class="aboc-modal-text-after">
											<p class="quick-order__confidential">Нажимая на кнопку «Отправить заявку» вы даёте <a class="quick-order__confidential-link" target="_blank" href="/politika-konfidentsialnosti/">согласие на обработку своих персональных данных</a></p>
										</div>
  						</form>
					</div>
				</div>

				<script>
					$(".form-container").submit(function (e) { // Устанавливаем событие отправки для формы с id=form
           			e.preventDefault();
            		var form_data = $(this).serialize(); // Собираем все данные из формы
					$('.btn-click').val('Оформляю заказ...').prop('disabled', true);
            		$.ajax({
                			type: "POST", // Метод отправки
                			url: "/12dev/new_click/", // Путь до php файла отправителя
                			data: form_data,
                			success: function () {
                    			$('.form-popup-one-click').html("<div id='message'></div>");
								$('#message').html('<h2>Спасибо!<br>Ваш заказ принят</h2><div class="aboc-modal-close aboc-close" onclick="closeForm()"></div><div class="info">Ожидайте звонка оператора, в ближайшее время он свяжется с Вами для уточнения даты доставки и необходимых деталей.<br><br>Если заказ оформлен в ночное время, оператор свяжется с Вами после 9-00 по МСК</div>');
                			}
            			});
        			});

					function openForm() {
    					document.getElementById("full-click").style.display = "block";
					}

					function closeForm() {
    					document.getElementById("full-click").style.display = "none";
					}
					$('.one_phone').on('input', function() {
    				$(this).val($(this).val().replace(/[A-Za-zА-Яа-яЁё]/, ''))
					});
				</script>
            </div>
			<!-- end modal forms -->

            <p class="product-intro__warning">Наличие и цена могут отличаться от указанных на сайте. Пожалуйста, уточняйте информацию у менеджеров клиентского обслуживания.</p>
        </div>
		<!-- end product-intro__buy -->
    </div>
	<!-- end product-intro__features-and-buy -->

    <div class="product-intro__buy-info">
        <div class="buy-info__item buy-info__item--grey-bg"><span class="buy-info__item-title">Оплата </span>
            <p class="buy-info__item-desc">Наличными, банковской картой</p>
        </div>

		<? if ($arResult["PROPERTIES"]["PRODAZHAPOLITSENZIIFIZLITSAM"]['VALUE']) : ?>
		<div class="buy-info__item buy-info__item--grey-bg"><span class="buy-info__item-title">Возврат</span>
			<p class="buy-info__item-desc">Товар надлежащего качества <a class="no_return_link" href="#">возврату не подлежит</a></p>
		</div>
		<?else:?>
        <div class="buy-info__item buy-info__item--grey-bg"><span class="buy-info__item-title">Возврат</span>
            <p class="buy-info__item-desc">Товар обмену и возврату доступен</p>
        </div>
		<?endif;?>

            <?if($arResult["SECTION"]["PATH"][0]['ID']==1104):?>
		<div class="buy-info__item buy-info__item--gift"><span class="buy-info__item-title">Таблица размеров</span>
            <p class="buy-info__item-desc"><a class="tablesize-button" target="_blank" href="/faq/sizes.php">Смотреть</a></p>
        </div>
            <? endif; ?>
    </div>

    <? if ($arResult["PROPERTIES"]["PRODAZHAPOLITSENZIIFIZLITSAM"]['VALUE']) : ?>
		<p class="product-intro__buy-attention">Внимание, для покупки данного товара необходима <a class="license__link" href="/license2/">лицензия</a></p>
    <? endif; ?>
</section>

<section class="product-info centering">
    <div class="product-info__tabs">
		<?/*if (!empty($arResult['DETAIL_TEXT'])) :*/?>
        <div class="product-info__tab" id="detail_description">
            <h3 class="product-info__tab-name product-info__tab-name--is-active" style="cursor:pointer;">Описание</h3>
        </div>
		<?/*endif;*/?>
	<? unset($arResult['PROPERTIES'][0]);
/*if ($arResult['PROPERTIES']) :*/?>
        <div class="product-info__tab" id="product-info-name">
            <h3 class="product-info__tab-name" style="cursor:pointer;">Характеристики</h3>
        </div>
		<?/*endif;*/?>
		<? if($real_amount > 0) : ?>
        <div class="product-info__tab" id="availability-name">
            <h3 class="product-info__tab-name" style="cursor:pointer;">Наличие в магазинах</h3>
        </div>
		<?endif;?>
		<? if (!empty($arResult['PROPERTIES']['YOUTUBELINK']['VALUE'])): ?>
		<div class="product-info__tab" id="video-name">
			<h3 class="product-info__tab-name">Видео</h3>
		</div>
		<?endif;?>
		<?if(!empty($arResult['PROPERTIES']['CERF']['VALUE'])):?>
        <div class="product-info__tab" id="product-documents-name">
            <h3 class="product-info__tab-name" style="cursor:pointer;">Документы</h3>
        </div>
		<?endif;?>
        <div class="product-info__tab" id="product-review-name">
            <h3 class="product-info__tab-name" style="cursor:pointer;">Отзывы</h3>
        </div>

        <div class="product-info__tab-body product-info__tab-body--descr" id="body-visible">

<?
	$html = $arResult['DETAIL_TEXT'];
	$html = htmlspecialchars_decode($html);
//$html = preg_replace("/(<p).*?(>)/i", '\\1\\2', $html);
	$html = preg_replace('#<st yle(.*?)>(.*?)</style>#is', '', $html);
	$html = str_replace('&nbsp;', '', $html);
	$html = preg_replace('/<br[^>]*>/', '', $html);
	$html = preg_replace("/ {2,}/", " ", $html);
	$html = preg_replace('/<(\w+)(?:([\'"]).*?\2|.)*?>/',"<$1>",$html);
	echo $html;
?>

        </div>

        <div class="product-info__tab-body" id="product-info">
            <ul class="product-info__tab-records">
                <? foreach ($arResult['DISPLAY_PROPERTIES'] as $prop) : ?>
                <li class="product-info__tab-record">
                    <span class="product-info__tab-record-name"><?=$prop['NAME']?>:</span>
					<?
					$section_id = $arResult['SECTION']['ID'];
					$res = CIBlockSection::GetByID($section_id);
					if($ar_res = $res->GetNext())
						$section_code =  $ar_res['CODE'];
						$section_name = $ar_res['NAME'];
						$start_value = $prop['DISPLAY_VALUE'];
						$arParams = array("replace_space"=>"_","replace_other"=>"_");
						$real_value = Cutil::translit($start_value,"ru",$arParams);
					?>
					<?
						$unset_prop = array('VES','CML2_ARTICLE','DLINA_OBSHCHAYA','KOMPLEKTATSIYA','TIP_STVOLA_1','EMKOST_MAGAZINA','SKOROST_POLETA');
						$prop_code = $prop['CODE'];
						if (in_array($prop_code, $unset_prop)) {
					?>
							<span class="product-info__tab-record-value no_line"><?=$prop['DISPLAY_VALUE']?></span>
					<?
						} else {
					?>
					<a href="https://ohotaktiv.ru/catalog/<?=$section_code?>/filter/<?=strtolower($prop["CODE"])?>-is-<?=$real_value?>/apply/">
						<span class="product-info__tab-record-value"><?=$prop['DISPLAY_VALUE']?></span>
					</a>
					<?
	   					}
					?>
                </li>
                <? endforeach; ?>
				<li class="product-info__tab-record">
					<span class="product-info__tab-record-name">Группа</span>
					<a href="/catalog/<?=$section_code?>" target="_blank">
						<span class="product-info__tab-record-value"><?=$section_name?></span>
					</a>
				</li>
            </ul>
        </div>
<? if($real_amount > 0) : ?>
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.store.amount",
			"element__amount",
			Array(
				"STORES" => array(),
				"ELEMENT_ID" => $arResult['ID'],
				"ELEMENT_CODE" => $arResult['CODE'],
				"OFFER_ID" => "",
				"STORE_PATH" => "/store/store_detail.php",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000",
				"MAIN_TITLE" => "Наличие товара на складах",
				"USER_FIELDS" => array("",""),
				"FIELDS" => array("TITLE","ADDRESS","PHONE","SCHEDULE",""),
				"SHOW_EMPTY_STORE" => "Y",
				"USE_MIN_AMOUNT" => "Y",
				"SHOW_GENERAL_STORE_INFORMATION" => "N",
				"MIN_AMOUNT" => "0"
			),
			$component
		);?>
<?endif;?>
<? if ($arResult['PROPERTIES']['YOUTUBELINK']['VALUE']) : ?>
        <div class="product-info__tab-body" id="product-video">
            <div class="product-info__tab-docs">
				<? /*foreach ($arResult['PROPERTIES']['CERF']['VALUE'] as $key => $value) : ?>
          			<a class="tab-body__doc" target="_blank" href="<?=$value['SRC']?>"><?=$value['DESCRIPTION']?> // Mabe docs
                        <span class="tab-body__doc-weight"><?=$value['SIZE']?> кБт</span>
                    </a>
				<? endforeach; */?>
			<!-- -- -->
            <div class="product-info__tab-videos">
                <div class="tab-videos fotorama" data-nav="thumbs" data-thumbwidth="145" data-thumbheight="78" data-fit="cover" data-width="100%" data-maxwidth="915px" data-maxheight="459px" data-thumbmargin="10px 10px 0 0" data-thumbborderwidth="0" data-ratio="800/600">
                    <a href="https://www.youtube.com/watch?v=<?=$arResult['PROPERTIES']['YOUTUBELINK']['VALUE']?>"></a>
                    	<? if ($arResult['PROPERTIES']['YOUTUBELINK_2']['VALUE']) : ?>
                    		<a href="https://www.youtube.com/watch?v=<?=$arResult['PROPERTIES']['YOUTUBELINK_2']['VALUE']?>"></a>
                    	<? endif; ?>
                    	<? if ($arResult['PROPERTIES']['YOUTUBELINK_3']['VALUE']) : ?>
                        	<a href="https://www.youtube.com/watch?v=<?=$arResult['PROPERTIES']['YOUTUBELINK_3']['VALUE']?>"></a>
                    	<? endif; ?>
                    	<? if ($arResult['PROPERTIES']['YOUTUBELINK_4']['VALUE']) : ?>
                        	<a href="https://www.youtube.com/watch?v=<?=$arResult['PROPERTIES']['YOUTUBELINK_4']['VALUE']?>"></a>
                    	<? endif; ?>
                </div>
            </div>
			<!-- -- -->
            </div>
        </div>
<? endif; ?>
<!-- --- -->
<div class="product-info__tab-body" id="review">
<!-- -- -->
<?
$arSelect = Array("ID", "NAME", "PROPERTY_ITEM_ID", "PREVIEW_TEXT", "PROPERTY_AUTHOR_NAME", "DATE_CREATE"); 
$item =$arResult['ID'];
$arFilter_old = Array(
	"IBLOCK_ID"=>12,
	"PROPERTY_ITEM_ID" => $item,
	"ACTIVE" => "Y",
); 
$res = CIBlockElement::GetList(Array(), $arFilter_old, false, Array("nPageSize"=>50), $arSelect);
while($ob = $res->GetNextElement()) { 
	$arRtem[] = $ob->GetFields();
}
$i = 0;
while (count($arRtem) > $i) {?>
<div class="author-review">
	<div class="author-name">
		<?=$arRtem[$i]["PROPERTY_AUTHOR_NAME_VALUE"]?>
	</div>
	<div class="preview-text">
		<?=$arRtem[$i]["PREVIEW_TEXT"]?>
	</div>
	<div class="date-review">
		<?=$arRtem[$i]["DATE_CREATE"]?>
	</div>
<?$i++;?>
</div>
<?}?>
<!-- -- -->
<?
global $USER;
if ($USER->IsAuthorized()) {
	if (!empty($USER->GetParam("EMAIL"))) {
		$m = $USER->GetParam("EMAIL");
	}
	if (!empty($USER->GetParam("NAME"))) {
		$n = $USER->GetParam("NAME");
	}?>
<form action="" method="post" enctype="multipart/form-data" class="form-review">
	<input type="hidden" name="URL" class="text" value="<?=$arResult['DETAIL_PAGE_URL']?>">
	<input type="hidden" name="QAWSEDDER" class="text" value="">
	<input type="hidden" name="PRODUCT" class="text" value="<?=$arResult['ID']?>">
	<input type="hidden" name="PRODUCT_NAME" class="text" value="<?=$arResult['NAME']?>">
	<input type="text" placeholder="Имя" value="<?=$n?>" name="NAME" class="real-reviw-name" required><br>
	<input type="text" placeholder="email" value="<?=$m?>" name="EMAIL" class="real-reviw-mail" required><br>
	<textarea placeholder="Ваш отзыв" name="REVIEW" class="real-reviw-text" required></textarea><br>
	<input type="submit" class="real-reviw-submit" value="Отправить" name="OK">
</form>
<?} else {?>
<div class="please_authorize">
	<span><a class="auth_link" href="/auth/" target="_blank">Войдите на сайт</a> для того, чтобы оставить отзыв</span>
</div>
<?}?>
</div>
				<script>
					$(".form-review").submit(function (e) { // Устанавливаем событие отправки для формы с id=form
           			e.preventDefault();
            		var form_data = $(this).serialize(); // Собираем все данные из формы
					$('.submit-review').val('Отправляю отзыв...').prop('disabled', true);
            		$.ajax({
                			type: "POST", // Метод отправки
                			url: "/reviews/add.php", // Путь до php файла отправителя
                			data: form_data,
                			success: function () {
                    			$('.form-review').html("<div id='message'></div>");
								$('#message').html('<h2>Спасибо!<br>Ваш отзыв принят</h2><div class="aboc-modal-close aboc-close" onclick="closeForm()"></div><div class="info">Отзыв появится здесь после проверки.</div>');
                			}
            			});
        			});
				</script>
    </div>
</section>

<div class="add-basket js-popup-licens">
	<div class="add-basket__body">
		<div class="add-basket__top">
			<p class="add-basket__desc">Лицензия</p>
			<div class="btn-close btn-close--add-basket js-btn-close--popup-licens">
			</div>
		</div>
		<div class="default default-center">
			<p>Для получения лицензии на оружие необходимо предоставить необходимый перечень документов.
			</p>
			<ul>
				<li>Заявление, в котором помимо паспортных данных нужно указать, имеется ли в наличии оружие.</li>
				<li>Ксерокопия паспорта.</li>
				<li>2 фотографии 3×4.</li>
				<li>Справка об отсутствии медицинских противопоказаний к владению оружием из следующих учреждений: психиатрический и наркологический диспансеры, участковая поликлиника, за которой вы закреплены по месту прописки.</li>
				<li>Копия охотничьего билета (если лицензия оформляется на охотничье оружие)</li>
				<li>Рапорт за подписью участкового, который проводил проверку на наличие у вас сейфа.</li>
				<li>Квитанция об оплате госпошлины.</li>
			</ul>
		</div>
	</div>
</div>
<div class="no_return js-popup-no_return">
	<div class="add-basket__body">
		<div class="add-basket__top">
			<p class="no_return__desc">Постановление Правительства РФ от 19.01.1998 N 55 (ред. от 16.05.2020) "Об утверждении Правил продажи отдельных видов товаров, перечня товаров длительного пользования, на которые не распространяется требование покупателя о безвозмездном предоставлении ему на период ремонта или замены аналогичного товара, и перечня непродовольственных товаров надлежащего качества, не подлежащих возврату или обмену на аналогичный товар других размера, формы, габарита, фасона, расцветки или комплектации"</p>
			<div class="btn-close btn-close--add-basket js-btn-close--popup-no_return">
			</div>
		</div>
		<blockquote>Утвержден<br>
Постановлением Правительства<br>
Российской Федерацииот 19 января 1998 г. N 55</blockquote>
		<div>
			<p class="no_return_text">ПЕРЕЧЕНЬ
НЕПРОДОВОЛЬСТВЕННЫХ ТОВАРОВ НАДЛЕЖАЩЕГО КАЧЕСТВА,
НЕ ПОДЛЕЖАЩИХ ВОЗВРАТУ ИЛИ ОБМЕНУ НА АНАЛОГИЧНЫЙ
ТОВАР ДРУГИХ РАЗМЕРА, ФОРМЫ, ГАБАРИТА, ФАСОНА,
РАСЦВЕТКИ ИЛИ КОМПЛЕКТАЦИИ
			</p>
			<p class="no_return_ul">Гражданское оружие, основные части гражданского и служебного огнестрельного оружия, патроны к нему
(п. 12 введен Постановлением Правительства РФ от 20.10.1998 N 1222)</p>
		</div>
	</div>
</div>
