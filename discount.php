<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("> Discount <");
?>

<?
/* Входящие данные */
$code_fiochi = array(
'00183326',
'00185583',
'00185592',
'00185584',
'00185585',
'00185586',
'00185587',
'00185588',
'00009113',
'00009114',
'00009115',
'00009116',
'00009117',
'00009118',
'00009119',
'00009120'
);
foreach ($code_fiochi as $code) {
	$results = $DB->Query("SELECT IBLOCK_ELEMENT_ID FROM b_iblock_element_property WHERE VALUE='$code' AND DESCRIPTION='Код'");
		while ($row = $results->Fetch())
		{
		$res = CIBlockElement::GetList(array(), array('IBLOCK_ID' => 10, 'ID' => $row['IBLOCK_ELEMENT_ID'], 'SITE_ID' => "s1"));
        $item = $res->Fetch();
			if ($item['ACTIVE'] = 'Y') { 
				$el_xls[] = $item['ID']; //сбор массива товаров
			}
		}
}
/* Работа с правилом */
$new_item_ids = $el_xls;
CModule::IncludeModule('sale');
//получим список товаров в правиле работы с корзиной:
$full_ids = [];
$full_ids[] = unserialize(CSaleDiscount::GetByID(44)['ACTIONS'])['CHILDREN'][0]['CHILDREN'][0]['DATA']['value'];

//добавим еще товары в правило
$full_ids = array_merge($full_ids, $new_item_ids);
//print_r( $full_ids );
/* *** */
$upd = [
  'ACTIVE'=>'Y',
  'ACTIONS'=>[
    'CLASS_ID' => 'CondGroup',
    'DATA' => ['All'=>'AND'],
    'CHILDREN' =>[
      [
        'CLASS_ID'=>'ActSaleBsktGrp',
		         'DATA'=> [
					 'Type'=>'Discount', //это потом меняю руками в правиле на нужные значения
          'Value'=>10,
          'Unit'=>'Perc',
          'Max'=>0,
          'All'=>'AND',
          'True'=>'True'
],
        'CHILDREN'=>[
          [
            'CLASS_ID'=>'CondIBElement',
            'DATA'=>[
              'logic'=>'Equal',
              'value'=>$full_ids
            ]
          ]
        ]
      ]
    ]
  ]
];
/* *** */
CSaleDiscount::Update( 44, $upd );
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
