<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);
?>
<?if(!empty($arResult['ITEM'])):?>
<? if (empty($arResult['ITEM']['MODIFIER']['PRICE']) && empty($arResult['ITEM']['MODIFIER']['OLD_PRICE'])) $none='none'; ?>
<a class="swiper-slide card-prod card-prod-new new-prod__slide <?=$none;?>" href="<?=$arResult['ITEM']['DETAIL_PAGE_URL'];?>"
   data-id="<?=$arResult['ITEM']['ID'];?>"
   data-quantity="1"
   data-name="<?=$arResult['ITEM']['NAME'];?>"
   data-img="<?=$arResult['ITEM']['PREVIEW_PICTURE']['SRC'];?>"
   data-current="<?=$arResult['ITEM']['MODIFIER']['PRICE'];?>"
   data-old="<?=$arResult['ITEM']['MODIFIER']['OLD_PRICE'];?>"
   data-delivery="0"
   data-license="<?=$arResult['ITEM']['MODIFIER']['LICENSE'];?>"
   data-max="<?=$arResult['ITEM']['MODIFIER']['MAX'];?>"
   data-url="<?=$arResult['ITEM']['DETAIL_PAGE_URL'];?>"
>
		<div class="card-prod__top">
			<img data-original="<?=$arResult['ITEM']['PREVIEW_PICTURE']['SRC'];?>" alt="<?=$arResult['ITEM']['NAME'];?>" class="lazy"/>
                	<? 
					$pid = $arResult['ITEM']['ID'];
					$rsStoreProduct = \Bitrix\Catalog\StoreProductTable::getList(array(
    				'filter' => array('=PRODUCT_ID'=>$pid,'STORE.ACTIVE'=>'Y'),
					));

					$real_amount = 0;
					while($arStoreProduct=$rsStoreProduct->fetch())
					{
					$real_amount += $arStoreProduct['AMOUNT'];
					}
					if($real_amount <= 0) {
						$class = 'red';
						$aviable_hint = 'Товар временно недоступен'; 
					} else {
						$class = 'green';
						$aviable_hint = 'В наличии'; 
					}
					?>
					<div class="aviable_status">
						<div class="<?=$class;?>" data-tooltip="<?=$aviable_hint;?>"></div>
					</div>
					<div class="card-prod__status-container">
						<?foreach($arResult['ITEM']['PROPERTIES']['LABELS']['VALUE_XML_ID'] as $label):?>
							<?if($label == 'NEW'):?>
								<div class="card-prod__status card-prod__status--new">Новинка</div>
							<?endif;?>
							<?if($label == 'DISCOUNT'):?>
								<div class="card-prod__status card-prod__status--sale">Акция</div>
							<?endif;?>
							<?if($label == 'BESTSELLER'):?>
								<div class="card-prod__status card-prod__status--hit">Хит</div>
							<?endif;?>
						<?endforeach;?>
					<? if (!empty($arResult['ITEM']['MODIFIER']['SPECIAL_PRICE'])) { ?>
						<div class="card-prod__status card-prod__status--sale">Спеццена</div>
					<? } ?>
					</div>
				<div class="card-prod__fav js-fav-prod" data-tooltip="Добавить в избранное" data-id="<?=$arResult['ITEM']['ID'];?>"></div>
		</div>
		<div class="card-prod__info">
		<!--<div class="card-prod_info_container">-->
			<p class="card-prod__desc"><?=$arResult['ITEM']['MODIFIER']['NAME'];?></p>
			<?
			global $USER;
			if ($USER->IsAdmin()) {
				echo '<p class="card-prod__desc full">'.$arResult['ITEM']['NAME'].'</p>';
			}
			?>
			<div class="card-prod__price">
				<? if (!empty($arResult['ITEM']['MODIFIER']['PRICE']) && empty($arResult['ITEM']['MODIFIER']['SPECIAL_PRICE'])) { ?>
				<span class="card-prod__price-new"><?=$arResult['ITEM']['MODIFIER']['PRICE'];?><span class="rub">₽</span></span>
				<? } elseif (!empty($arResult['ITEM']['MODIFIER']['SPECIAL_PRICE'])) { ?>
				<span class="card-prod__price-new"><?=$arResult['ITEM']['MODIFIER']['SPECIAL_PRICE'];?><span class="rub">₽</span></span>
				<? } ?>
				<?if(!empty($arResult['ITEM']['MODIFIER']['OLD_PRICE'])):?>
				<span class="card-prod__price-old"><?=$arResult['ITEM']['MODIFIER']['OLD_PRICE'];?><span class="rub">₽</span></span>
				<?endif;?>
			</div>
			<?
			if($real_amount <= 0) {
				if (!empty($arResult['ITEM']['MODIFIER']['PRICE']) && empty($arResult['ITEM']['MODIFIER']['SPECIAL_PRICE'])) { 
					$current_price = $arResult['ITEM']['MODIFIER']['PRICE'];
				} elseif (!empty($arResult['ITEM']['MODIFIER']['SPECIAL_PRICE'])) { 
					$current_price = $arResult['ITEM']['MODIFIER']['SPECIAL_PRICE'];
				} 
			if(!empty($arResult['ITEM']['MODIFIER']['OLD_PRICE']))
				$old_price = $arResult['ITEM']['MODIFIER']['OLD_PRICE'];
			?>
				<button type="button" class="product-intro__btn-add mybuttonlol show_me_order_form" id="<?=$arResult['ITEM']['ID'];?>" 
				data-url="<?=$arResult['ITEM']['DETAIL_PAGE_URL'];?>" 
				data-id="<?=$arResult['ITEM']['ID']?>" 
				data-current-price="<?=$current_price?>" 
				data-old-price="<?=$old_price?>" 
				data-name="<?=$arResult['ITEM']['NAME'];?>"
				>
				Заказать
				</button>
			<? } else { ?>
				<button class="mybuttonlol card-prod__add" id="<?=$arResult['ITEM']['ID'];?>" data-url="<?=$arResult['ITEM']['DETAIL_PAGE_URL'];?>" onclick="ym(42989679,'reachGoal','basket');">В корзину</button>
			<? } ?>
		</div>	
</a>
<?endif;?>
