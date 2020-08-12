<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $USER;
$asset = Bitrix\Main\Page\Asset::getInstance();
CModule::IncludeModule('nologostudio.main');
$GLOBALS['SELECT_ONLY_NEW'] = array('=PROPERTY_LABELS' => '37235');

if(preg_match('/\?/', $_SERVER['REQUEST_URI']))
{
  $DIR = explode('?', $_SERVER['REQUEST_URI']);
  if($_SERVER['QUERY_STRING']=='')
  {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://".$_SERVER['HTTP_HOST'].$DIR[0]);
  }

  if(preg_match('/^\?+/', $_SERVER['QUERY_STRING']) && preg_match('/[A-Z, a-z, 0-9]/', $_SERVER['QUERY_STRING']))
  {
    $QUERY_STRING = str_replace('?', '', $_SERVER['QUERY_STRING']);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://".$_SERVER['HTTP_HOST'].$DIR[0].'?'.$QUERY_STRING);
  }
  elseif(preg_match('/^\?+/', $_SERVER['QUERY_STRING']))
  {
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://".$_SERVER['HTTP_HOST'].$DIR[0]);
  }

}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<?$APPLICATION->ShowHead();?>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH;?>/favicon.png" />
	<link href="https://fonts.googleapis.com/css2?family=Roboto2&display=swap" rel="stylesheet">
    <title><?php $APPLICATION->ShowTitle();?></title>
    <?
    $asset->addCss(SITE_TEMPLATE_PATH . '/css/plugins/swiper.min.css', true);
    $asset->addCss(SITE_TEMPLATE_PATH . '/css/plugins/fotorama.css', true);
    $asset->addCss(SITE_TEMPLATE_PATH . '/css/styles.css?ver=26', true);
    $asset->addCss(SITE_TEMPLATE_PATH . '/css/fonts.css', true);

	CJSCore::Init(array('jquery'));
	$pathToFile = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . SITE_TEMPLATE_PATH;
	?>
<!-- pay -->
  <script src="https://3dsec.sberbank.ru/payment/docsite/assets/js/ipay.js"></script>
   <script>
     var ipay = new IPAY({api_token: 'n3s5fovqumvkjcmge8s3b26fho'});
   </script>
<!-- /pay -->
	<script src="<?=SITE_TEMPLATE_PATH?>/js/plugins/swiper.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/plugins/fotorama.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/plugins/jquery.cookie.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/plugins/jquery.maskedinput.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/plugins/jquery.selectric.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/main.js?ver=1"></script>
</head>
<body>
<?php $APPLICATION->ShowPanel();?>
<div class="icons">
    <svg xmlns="http://www.w3.org/2000/svg">
      <symbol id="icon-stock" viewBox="0 0 22 22">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0ZM11 20.5001C5.75327 20.5001 1.49998 16.2468 1.49998 11.0001C1.49998 5.75344 5.75327 1.50014 11 1.50014C16.2467 1.50014 20.5 5.75344 20.5 11.0001C20.5 16.2468 16.2467 20.5001 11 20.5001Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M9.5 8C9.5 6.61929 8.38071 5.5 7 5.5C5.61929 5.5 4.5 6.61929 4.5 8C4.5 9.38071 5.61929 10.5 7 10.5C8.38071 10.5 9.5 9.38071 9.5 8ZM6.0002 7.9999C6.0002 7.44761 6.44791 6.99989 7.0002 6.99989C7.55248 6.99989 8.0002 7.44761 8.0002 7.9999C8.0002 8.55218 7.55248 8.9999 7.0002 8.9999C6.44791 8.9999 6.0002 8.55218 6.0002 7.9999Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M14 12.5C12.6193 12.5 11.5 13.6193 11.5 15C11.5 16.3807 12.6193 17.5 14 17.5C15.3807 17.5 16.5 16.3807 16.5 15C16.5 13.6193 15.3807 12.5 14 12.5ZM14 16.0001C13.4477 16.0001 13 15.5524 13 15.0001C13 14.4478 13.4477 14.0001 14 14.0001C14.5523 14.0001 15 14.4478 15 15.0001C15 15.5524 14.5523 16.0001 14 16.0001Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M16.0302 5.97032C15.7374 5.67786 15.263 5.67786 14.9702 5.97032L5.47017 15.4703C5.26952 15.6573 5.18692 15.9389 5.25479 16.2046C5.32265 16.4703 5.53015 16.6778 5.79588 16.7457C6.06162 16.8136 6.3432 16.731 6.53017 16.5303L16.0302 7.03032C16.3226 6.7375 16.3226 6.26313 16.0302 5.97032Z">
        </path>
      </symbol>
      <symbol id="icon-catalog" viewBox="0 0 20 20">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M7.17949 0H1.53846C0.688793 0 0 0.688793 0 1.53846V7.17949C0 8.02916 0.688793 8.71795 1.53846 8.71795H7.17949C8.02916 8.71795 8.71795 8.02916 8.71795 7.17949V1.53846C8.71795 0.688793 8.02916 0 7.17949 0ZM7.1795 7.17937H1.53847V1.53834H7.1795V7.17937Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M18.4617 0H12.8207C11.971 0 11.2822 0.688793 11.2822 1.53846V7.17949C11.2822 8.02916 11.971 8.71795 12.8207 8.71795H18.4617C19.3114 8.71795 20.0002 8.02916 20.0002 7.17949V1.53846C20.0002 0.688793 19.3114 0 18.4617 0ZM18.4617 7.17937H12.8207V1.53834H18.4617V7.17937Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M7.17949 11.2822H1.53846C0.688793 11.2822 0 11.971 0 12.8207V18.4617C0 19.3114 0.688793 20.0002 1.53846 20.0002H7.17949C8.02916 20.0002 8.71795 19.3114 8.71795 18.4617V12.8207C8.71795 11.971 8.02916 11.2822 7.17949 11.2822ZM7.1795 18.4615H1.53847V12.8205H7.1795V18.4615Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M18.4617 11.2822H12.8207C11.971 11.2822 11.2822 11.971 11.2822 12.8207V18.4617C11.2822 19.3114 11.971 20.0002 12.8207 20.0002H18.4617C19.3114 20.0002 20.0002 19.3114 20.0002 18.4617V12.8207C20.0002 11.971 19.3114 11.2822 18.4617 11.2822ZM18.4617 18.4615H12.8207V12.8205H18.4617V18.4615Z">
        </path>
      </symbol>
      <symbol id="icon-basket" viewBox="0 0 23 19">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M8.03232 12.1776H17.7744C18.3596 12.1779 18.8886 11.8291 19.1188 11.291L22.0414 4.4716C22.2346 4.01999 22.188 3.50153 21.9173 3.09163C21.6467 2.68172 21.1882 2.43522 20.697 2.43551H4.6226C4.34162 2.43914 4.06764 2.5237 3.8335 2.67906L2.85929 0.438392C2.74342 0.172894 2.48164 0.000922351 2.19196 0H0.730654C0.327125 0 0 0.327125 0 0.730654C0 1.13418 0.327125 1.46131 0.730654 1.46131H1.70486L6.1521 11.6223C6.70285 13.2702 6.49971 15.077 5.59681 16.5615C5.59564 17.5528 6.19549 18.446 7.11362 18.8199C8.03174 19.1939 9.08492 18.974 9.77674 18.264C10.4686 17.5539 10.661 16.4954 10.2632 15.5873H15.5483C15.1186 16.572 15.385 17.722 16.2039 18.4176C17.0227 19.1131 18.2007 19.1899 19.1029 18.6066C20.0052 18.0232 20.4186 16.9175 20.1204 15.8853C19.8222 14.8531 18.8828 14.1383 17.8085 14.126H8.14922H8.0518C7.51376 14.126 7.0776 13.6898 7.0776 13.1518C7.0776 12.6137 7.51376 12.1776 8.0518 12.1776H8.03232ZM20.6971 3.89681L17.7745 10.7162H7.54531L4.62269 3.89681H20.6971ZM9.00652 16.5615C9.00652 17.0995 8.57036 17.5357 8.03232 17.5357C7.49428 17.5357 7.05811 17.0995 7.05811 16.5615C7.05811 16.0234 7.49428 15.5873 8.03232 15.5873C8.57036 15.5873 9.00652 16.0234 9.00652 16.5615ZM18.7487 16.5615C18.7487 17.0995 18.3125 17.5357 17.7745 17.5357C17.2364 17.5357 16.8003 17.0995 16.8003 16.5615C16.8003 16.0234 17.2364 15.5873 17.7745 15.5873C18.3125 15.5873 18.7487 16.0234 18.7487 16.5615Z">
        </path>
      </symbol>
      <symbol id="icon-fav" viewBox="0 0 22 21">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M16.5928 0.482422C14.2531 0.482422 12.3823 2.23513 11.2198 3.39557C10.0329 2.24476 8.12789 0.482422 5.79307 0.482422C2.37389 0.482422 0 2.85628 0 6.26057C0 13.6518 9.82282 19.7429 10.2575 19.9885C10.7315 20.2792 11.332 20.2792 11.806 19.9885C12.2211 19.7333 22 13.6133 22 6.26538C21.9658 2.69738 19.9094 0.482422 16.5928 0.482422ZM10.9756 18.7799C10.9756 18.7799 1.43123 12.9536 1.43123 6.26055C1.43123 3.67483 3.13594 1.92694 5.75894 1.92694C8.38194 1.92694 10.7119 5.29752 11.2003 5.29752C11.6888 5.29752 13.9503 1.92694 16.5733 1.92694C19.1963 1.92694 20.481 3.67483 20.481 6.26055C20.5005 12.891 10.9756 18.7799 10.9756 18.7799Z">
        </path>
      </symbol>
      <symbol id="icon-profile" viewBox="0 0 22 22">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M11 0C4.92487 0 0 4.92487 0 11C0 17.0751 4.92487 22 11 22C17.0751 22 22 17.0751 22 11C22 4.92487 17.0751 0 11 0ZM1.49998 11.0001C1.49968 6.83942 4.20689 3.16264 8.18009 1.92761C12.1533 0.692583 16.4678 2.18671 18.8263 5.61441C21.1848 9.04211 21.0384 13.6057 18.465 16.8751C17.3188 15.168 15.6559 13.8731 13.72 13.1801C14.5566 12.2846 15.0152 11.1006 15 9.87514C15 7.37514 13.205 5.37514 11 5.37514C8.79498 5.37514 6.99998 7.37514 6.99998 9.87514C6.98755 11.1443 7.48466 12.3655 8.37998 13.2651C6.43034 13.965 4.78588 15.323 3.72998 17.1051C2.28858 15.3976 1.49854 13.2347 1.49998 11.0001ZM11.25 12.75C10.976 12.7511 10.7024 12.7661 10.43 12.795C9.21313 12.3537 8.42904 11.1674 8.49996 9.875C8.49996 8.22 9.61996 6.875 11 6.875C12.38 6.875 13.5 8.22 13.5 9.875C13.5616 11.1311 12.8241 12.2894 11.66 12.765C11.525 12.76 11.39 12.75 11.25 12.75ZM4.84 18.2501C5.92674 16.1285 7.97909 14.6694 10.34 14.3401C10.8267 14.4351 11.3283 14.4232 11.81 14.3051C14.1433 14.6202 16.2034 15.9874 17.4 18.0151C13.8739 21.2697 8.47022 21.3707 4.825 18.2501H4.84Z">
        </path>
      </symbol>
      <symbol id="icon-arrow-link" viewBox="0 0 11 14">
        <path
          d="M4.46766 14L-2.70245e-07 14L5.53388 7.74446L6.52432 6.61719L5.53388 5.5081L9.53674e-07 -8.08661e-07L4.46766 -5.71075e-07L11 6.61719L4.46766 14Z">
        </path>
      </symbol>
      <symbol id="icon-arrow-slider-prev" viewBox="0 0 10 13">
        <path d="M7.01818 0L10 0L4.05455 5.45325L2.99043 6.5L4.05455 7.52987L10 13L7.01818 13L0 6.5L7.01818 0Z"
          fill="white"></path>
      </symbol>
      <symbol id="icon-callback-btn" viewBox="0 0 26 26">
        <path
          d="M5.26878 17.283C7.84295 20.3485 10.9417 22.7621 14.4784 24.47C15.825 25.1057 17.6258 25.8599 19.6322 25.9892C19.7566 25.9946 19.8755 26 19.9999 26C21.3465 26 22.4281 25.5367 23.3096 24.5831C23.315 24.5777 23.3258 24.5669 23.3312 24.5562C23.6448 24.179 24.0018 23.8396 24.3749 23.4787C24.6291 23.2362 24.8887 22.983 25.1374 22.7244C26.2893 21.5284 26.2893 20.0091 25.1266 18.8508L21.8765 15.6129C21.3249 15.0419 20.6651 14.7402 19.9729 14.7402C19.2807 14.7402 18.6155 15.0419 18.0477 15.6075L16.1116 17.5363C15.9332 17.4339 15.7493 17.3423 15.5763 17.2561C15.3599 17.1484 15.1598 17.046 14.9814 16.9329C13.2184 15.8177 11.6177 14.363 10.0872 12.4936C9.3139 11.5184 8.79474 10.6995 8.43241 9.86448C8.94075 9.40655 9.41665 8.92706 9.87632 8.45835C10.0386 8.29134 10.2062 8.12433 10.3738 7.95731C10.9579 7.37547 11.2716 6.70203 11.2716 6.01782C11.2716 5.33361 10.9633 4.66017 10.3738 4.07833L8.76229 2.47286C8.57301 2.28429 8.39455 2.10112 8.21068 1.91256C7.85376 1.54621 7.48062 1.16908 7.11288 0.829673C6.55586 0.285537 5.90151 0 5.2093 0C4.52249 0 3.86273 0.285537 3.28408 0.83506L1.26152 2.84998C0.526048 3.58268 0.109639 4.47161 0.0231129 5.50062C-0.0796373 6.78823 0.158311 8.15665 0.774812 9.81061C1.7212 12.3697 3.14888 14.7455 5.26878 17.283ZM1.34264 5.61376C1.40754 4.89722 1.68334 4.29921 2.2025 3.78201L4.21424 1.77787C4.5279 1.47617 4.87401 1.31993 5.2093 1.31993C5.53918 1.31993 5.87447 1.47617 6.18272 1.78864C6.54505 2.12267 6.88575 2.47286 7.25348 2.84459C7.43735 3.03315 7.62663 3.22172 7.81591 3.41567L9.42746 5.02114C9.76275 5.35516 9.93581 5.69457 9.93581 6.02859C9.93581 6.36262 9.76275 6.70203 9.42746 7.03605C9.25982 7.20307 9.09217 7.37547 8.92453 7.54248C8.42159 8.0489 7.95111 8.52839 7.43195 8.98632C7.42113 8.9971 7.41572 9.00249 7.40491 9.01326C6.95605 9.46042 7.02635 9.88603 7.13451 10.2093C7.13992 10.2254 7.14533 10.2362 7.15073 10.2524C7.56714 11.2491 8.14579 12.1973 9.04891 13.3286C10.6713 15.322 12.3802 16.8682 14.2621 18.0588C14.4947 18.2097 14.7434 18.3282 14.976 18.4467C15.1923 18.5545 15.3924 18.6569 15.5708 18.77C15.5925 18.7808 15.6087 18.7915 15.6303 18.8023C15.8088 18.8939 15.9818 18.937 16.1549 18.937C16.5875 18.937 16.8687 18.6622 16.9607 18.5707L18.9832 16.5557C19.2969 16.2433 19.6376 16.0763 19.9729 16.0763C20.3839 16.0763 20.7192 16.3295 20.9301 16.5557L24.191 19.799C24.84 20.4455 24.8346 21.1459 24.1748 21.8301C23.9477 22.0725 23.7097 22.3042 23.4556 22.5466C23.077 22.913 22.6822 23.2901 22.3253 23.7157C21.7034 24.3838 20.9625 24.6962 20.0053 24.6962C19.9134 24.6962 19.8161 24.6908 19.7241 24.6855C17.9503 24.5723 16.3009 23.8827 15.0625 23.2955C11.6988 21.6738 8.74607 19.3734 6.29629 16.4534C4.27914 14.0344 2.92175 11.7824 2.02404 9.36883C1.46702 7.88728 1.25612 6.69664 1.34264 5.61376Z"
          fill="white"></path>
      </symbol>
      <symbol id="icon-pagination-btn" viewBox="0 0 10 13">
        <path d="M7.01818 0L10 0L4.05455 5.45325L2.99043 6.5L4.05455 7.52987L10 13L7.01818 13L0 6.5L7.01818 0Z"></path>
      </symbol>
      <symbol id="icon-arrow-pa-menu" viewBox="0 0 8 11">
        <path
          d="M2.77413 11L4.68861e-07 11L4.4271 6.08493L5.21946 5.19922L4.4271 4.32779L1.43051e-06 -6.47865e-07L2.77413 -4.5686e-07L8 5.19922L2.77413 11Z">
        </path>
      </symbol>
      <symbol id="icon-compare" viewBox="0 0 23 20">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M2.22581 19.0909L2.22581 0.90909C2.22581 0.407013 1.72754 -6.16841e-08 1.1129 -3.97376e-08C0.498264 -1.77911e-08 -1.04845e-06 0.407013 -1.02158e-06 0.90909L-4.86466e-08 19.0909C-2.17798e-08 19.593 0.498265 20 1.11291 20C1.72755 20 2.22581 19.593 2.22581 19.0909Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M7.42015 19.0909L7.42015 7.57576C7.42015 7.07368 6.92188 6.66667 6.30724 6.66667C5.6926 6.66667 5.19434 7.07368 5.19434 7.57576L5.19434 19.0909C5.19434 19.593 5.6926 20 6.30724 20C6.92188 20 7.42015 19.593 7.42015 19.0909Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M12.6125 19.0909L12.6125 2.12121C12.6125 1.61914 12.1143 1.21212 11.4996 1.21212C10.885 1.21212 10.3867 1.61914 10.3867 2.12121L10.3867 19.0909C10.3867 19.593 10.885 20 11.4996 20C12.1143 20 12.6125 19.593 12.6125 19.0909Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M17.8078 19.0909L17.8078 3.93939C17.8078 3.43732 17.3096 3.0303 16.6949 3.0303C16.0803 3.0303 15.582 3.43732 15.582 3.93939L15.582 19.0909C15.582 19.593 16.0803 20 16.6949 20C17.3096 20 17.8078 19.593 17.8078 19.0909Z">
        </path>
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M20.7734 0.90909L20.7734 19.0909C20.7734 19.593 21.2717 20 21.8863 20C22.501 20 22.9992 19.593 22.9992 19.0909L22.9992 0.90909C22.9992 0.407013 22.501 -6.16841e-08 21.8863 -3.97376e-08C21.2717 -1.77911e-08 20.7734 0.407013 20.7734 0.90909Z">
        </path>
      </symbol>
    </svg>
 </div>

<header class="header" id="he_hei">
   <!-- --
<div class="attention"><span>На сайте ведутся технические работы. Воспользуйтесь поиском, чтобы найти интересующий товар, либо звоните по телефону</span>&ensp;<a href="tel:88007008256" class="attention__phone">8 (800) 700 82 56</a></div>   -->
    <div class="header-mob">
        <div class="header-mob__inner centering">
            <div class="header__top">
                <?$APPLICATION->IncludeComponent(
          "bxmaker:geoip.city",
          "header__mobile",
          array(
              "BTN_EDIT" => "Выберите город",
              "CACHE_TIME" => "0",
              "CACHE_TYPE" => "A",
              "CITY_COUNT" => "30",
              "CITY_LABEL" => "",
              "CITY_SHOW" => "Y",
              "COMPONENT_TEMPLATE" => "header__mobile",
              "COMPOSITE_FRAME_MODE" => "A",
              "COMPOSITE_FRAME_TYPE" => "AUTO",
              "FAVORITE_SHOW" => "Y",
              "FID" => "1",
              "INFO_SHOW" => "N",
              "INFO_TEXT" => "",
              "INPUT_LABEL" => "Найдите свой город",
              "MSG_EMPTY_RESULT" => "Ничего не найдено",
              "POPUP_LABEL" => "Выбрать город",
              "QUESTION_SHOW" => "Y",
              "QUESTION_TEXT" => "Ваш город<br/>#CITY#?",
              "RELOAD_PAGE" => "N",
              "SEARCH_SHOW" => "Y"
          ),
          false
      );?>
                <a class="header__phone" href="tel:88007008256">8 (800) 700 82 56</a>
            </div>
            <div class="header__bottom">
                <div class="btn-nav js-btn-nav">
                    <span></span>
                </div>
                <a class="logo-link js-logo" href="/"></a>
                <?$APPLICATION->IncludeComponent(
    "api:search.page",
    "search__mobile",
    array(
        "BUTTON_TEXT" => "",
        "CONVERT_CURRENCY" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "FILEMAN_ON" => "Y",
        "IBLOCK_10_ACTIVE" => "Y",
        "IBLOCK_10_DETAIL_URL" => "https://ohotaktiv.ru/catalog/#SECTION_CODE#/#ELEMENT_ID#",
        "IBLOCK_10_EXCLUDE" => array(
            0 => "KLYUCHEVYE_SLOVA_1",
        ),
        "IBLOCK_10_FIELD" => array(
            0 => "NAME",
            1 => "TAGS",
            2 => "PREVIEW_TEXT",
            3 => "DETAIL_TEXT",
        ),
        "IBLOCK_10_PROPERTY" => array(
            0 => "SEO_NAIMENOVANIE",
            1 => "KLYUCHEVYE_SLOVA_1",
            2 => "CML2_ARTICLE",
            3 => "CML2_ATTRIBUTES",
        ),
        "IBLOCK_10_REGEX" => "",
        "IBLOCK_10_SECTION" => array(
            0 => "",
            1 => "",
        ),
        "IBLOCK_10_SECTION_URL" => "https://ohotaktiv.ru/catalog/#SECTION_CODE#",
        "IBLOCK_10_SHOW_BRAND" => "BRAND",
        "IBLOCK_10_SHOW_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_10_SHOW_PROPERTY" => array(
        ),
        "IBLOCK_10_SHOW_SECTION" => "N",
        "IBLOCK_10_TITLE" => "Основной каталог товаров",
        "IBLOCK_14_ACTIVE" => "Y",
        "IBLOCK_14_DETAIL_URL" => "https://ohotaktiv.ru/sale/#SECTION_CODE#/#ELEMENT_ID#",
        "IBLOCK_14_EXCLUDE" => "",
        "IBLOCK_14_FIELD" => array(
            0 => "NAME",
        ),
        "IBLOCK_14_PROPERTY" => "",
        "IBLOCK_14_REGEX" => "",
        "IBLOCK_14_SECTION_URL" => "https://ohotaktiv.ru/sale/#SECTION_CODE#",
        "IBLOCK_14_SHOW_BRAND" => "ITEMS",
        "IBLOCK_14_SHOW_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_14_SHOW_PROPERTY" => "",
        "IBLOCK_14_SHOW_SECTION" => "N",
        "IBLOCK_14_TITLE" => "Акции",
        "IBLOCK_25_ACTIVE" => "Y",
        "IBLOCK_25_DETAIL_URL" => "https://ohotaktiv.ru/#SECTION_CODE#/#ELEMENT_ID#",
        "IBLOCK_25_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_25_REGEX" => "",
        "IBLOCK_25_SECTION_URL" => "https://ohotaktiv.ru/#SECTION_CODE#",
        "IBLOCK_25_SHOW_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_25_SHOW_SECTION" => "N",
        "IBLOCK_25_TITLE" => "Новости",
        "IBLOCK_3_ACTIVE" => "Y",
        "IBLOCK_3_DETAIL_URL" => "https://ohotaktiv.ru/news/#SECTION_CODE#/#ELEMENT_CODE#",
        "IBLOCK_3_EXCLUDE" => "",
        "IBLOCK_3_FIELD" => array(
            0 => "NAME",
            1 => "TAGS",
            2 => "PREVIEW_TEXT",
            3 => "DETAIL_TEXT",
        ),
        "IBLOCK_3_PROPERTY" => "",
        "IBLOCK_3_REGEX" => "",
        "IBLOCK_3_SECTION_URL" => "https://ohotaktiv.ru/news/#SECTION_CODE#",
        "IBLOCK_3_SHOW_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_3_SHOW_PROPERTY" => "",
        "IBLOCK_3_SHOW_SECTION" => "N",
        "IBLOCK_3_TITLE" => "Новости и статьи",
        "IBLOCK_ID" => array(
            0 => "10",
        ),
        "IBLOCK_TYPE" => array(
            0 => "1c_catalog",
        ),
        "INCLUDE_CSS" => "N",
        "INCLUDE_JQUERY" => "N",
        "INPUT_PLACEHOLDER" => "Поиск по сайту",
        "ITEMS_LIMIT" => "4",
        "KEYBOARD_ON" => "Y",
        "MORE_BUTTON_CLASS" => "api-button",
        "MORE_BUTTON_TEXT" => "",
        "PAGER_DESC_NUMBERING" => "Y",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Результаты поиска",
        "PICTURE" => array(
            0 => "PREVIEW_PICTURE",
        ),
        "PRICE_CODE" => array(
            0 => "Сайт (Цена базовая)",
        ),
        "PRICE_EXT" => "Y",
        "PRICE_VAT_INCLUDE" => "Y",
        "RESIZE_PICTURE" => "64x64",
        "RESULT_LIMIT" => "4",
        "RESULT_NOT_FOUND" => "По вашему запросу ничего не найдено...",
        "SEARCH_MODE" => "JOIN",
        "SORT_BY1" => "HAS_PREVIEW_PICTURE",
        "SORT_BY2" => "",
        "SORT_BY3" => "",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "DESC",
        "SORT_ORDER3" => "ASC",
        "THEME" => "block",
        "TRUNCATE_LENGTH" => "50",
        "USE_CURRENCY_SYMBOL" => "N",
        "USE_TITLE_RANK" => "Y",
        "COMPONENT_TEMPLATE" => "search__mobile"
    ),
    false
);
?>
            </div>
            <div class="nav-bar js-nav-bar">
                <div class="nav-bar__body js-nav-bar__body">
                    <?$APPLICATION->IncludeComponent("bitrix:menu", "header__mobile", array(
                        "ROOT_MENU_TYPE" => "top",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "fck-menu",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                        "COMPONENT_TEMPLATE" => "",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "MENU_THEME" => "site"
                    ),
                        false
                    );?>
                    <div class="social">
                        <p class="social__desc">Мы в социальных сетях:</p>
                        <div class="social__items">
                            <?if(CNLSMainSettings::GetSiteSetting('nls_social_vk')):?>
                                <a target="_blank" rel="nofollow" class="social__item social__item--vk" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_vk')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
                            <?endif?>
                            <?if(CNLSMainSettings::GetSiteSetting('nls_social_fb')):?>
                                <a target="_blank" rel="nofollow" class="social__item social__item--fb" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_fb')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
                            <?endif?>
                            <?if(CNLSMainSettings::GetSiteSetting('nls_social_yt')):?>
                                <a target="_blank" rel="nofollow" class="social__item social__item--yt" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_yt')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
                            <?endif?>
                            <a rel="nofollow" class="social__item social__item--inst" href="https://www.instagram.com/ohotaktiv/" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;" target="_blank"></a>
                        </div>
                    </div>
					<div class="search-list js-search-list-mobile"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-desk">
        <div class="header-desk__inner">
            <div class="header-desk__top--bg">
                <div class="header-desk__top centering">
                    <a class="header-desk__logo" href="/"></a>
                    <div class="header-desk__contacts">
						<?$APPLICATION->IncludeComponent(
          "bxmaker:geoip.city",
          "header__desktop",
          array(
              "BTN_EDIT" => "Выберите город",
              "CACHE_TIME" => "0",
              "CACHE_TYPE" => "A",
              "CITY_COUNT" => "30",
              "CITY_LABEL" => "",
              "CITY_SHOW" => "Y",
              "COMPONENT_TEMPLATE" => "header__desktop",
              "COMPOSITE_FRAME_MODE" => "A",
              "COMPOSITE_FRAME_TYPE" => "AUTO",
              "FAVORITE_SHOW" => "Y",
              "FID" => "1",
              "INFO_SHOW" => "N",
              "INFO_TEXT" => "",
              "INPUT_LABEL" => "Найдите свой город",
              "MSG_EMPTY_RESULT" => "Ничего не найдено",
              "POPUP_LABEL" => "Выбрать город",
              "QUESTION_SHOW" => "Y",
              "QUESTION_TEXT" => "Ваш город<br/>#CITY#?",
              "RELOAD_PAGE" => "N",
              "SEARCH_SHOW" => "Y"
          ),
          false
      );?>
                        <a class="header__phone" href="tel:88007008256">8 (800) 700 82 56</a>
                    </div>
                    <?$APPLICATION->IncludeComponent("bitrix:menu", "header__desktop", Array(
                        "ROOT_MENU_TYPE" => "top",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "fck-menu",
                        "USE_EXT" => "N",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                        "COMPONENT_TEMPLATE" => "",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "MENU_THEME" => "site"
                    ),
                        false
                    );?>
                    <div class="header-desk__socials">
                        <div class="social__items">
                            <?if(CNLSMainSettings::GetSiteSetting('nls_social_vk')):?>
                                <a target="_blank" rel="nofollow" class="social__item social__item--vk" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_vk')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
                            <?endif?>
                            <?if(CNLSMainSettings::GetSiteSetting('nls_social_fb')):?>
                                <a target="_blank" rel="nofollow" class="social__item social__item--fb" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_fb')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
                            <?endif?>
                            <?if(CNLSMainSettings::GetSiteSetting('nls_social_yt')):?>
                                <a target="_blank" rel="nofollow" class="social__item social__item--yt" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_yt')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
                            <?endif?>
                            <a rel="nofollow" class="social__item social__item--inst" href="https://www.instagram.com/ohotaktiv/" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;" target="_blank"></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-desk__bottom--bg">
                <div class="header-desk__bottom centering">
                    <a class="header-desk__menu-item js-open-catalog" href="/catalog/">
                        <svg class="header-desk__menu-icon header-desk__menu-icon--catalog">
                            <use xlink:href="#icon-catalog"></use>
                        </svg>
                        <span class="header-desk__menu-item-name">Каталог товаров</span>
                    </a>
					<?$APPLICATION->IncludeComponent(
    "api:search.page",
    "search__desktop",
    array(
        "BUTTON_TEXT" => "",
        "CONVERT_CURRENCY" => "N",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "FILEMAN_ON" => "Y",
        "IBLOCK_10_ACTIVE" => "Y",
        "IBLOCK_10_DETAIL_URL" => "https://ohotaktiv.ru/catalog/#SECTION_CODE#/#ELEMENT_ID#",
        "IBLOCK_10_EXCLUDE" => array(
            0 => "KLYUCHEVYE_SLOVA_1",
        ),
        "IBLOCK_10_FIELD" => array(
            0 => "NAME",
            1 => "TAGS",
            2 => "PREVIEW_TEXT",
            3 => "DETAIL_TEXT",
        ),
        "IBLOCK_10_PROPERTY" => array(
            0 => "SEO_NAIMENOVANIE",
            1 => "KLYUCHEVYE_SLOVA_1",
            2 => "CML2_ARTICLE",
            3 => "CML2_ATTRIBUTES",
        ),
        "IBLOCK_10_REGEX" => "",
        "IBLOCK_10_SECTION" => array(
            0 => "",
            1 => "",
        ),
        "IBLOCK_10_SECTION_URL" => "https://ohotaktiv.ru/catalog/#SECTION_CODE#",
        "IBLOCK_10_SHOW_BRAND" => "BRAND",
        "IBLOCK_10_SHOW_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_10_SHOW_PROPERTY" => array(
        ),
        "IBLOCK_10_SHOW_SECTION" => "N",
        "IBLOCK_10_TITLE" => "Основной каталог товаров",
        "IBLOCK_14_ACTIVE" => "Y",
        "IBLOCK_14_DETAIL_URL" => "https://ohotaktiv.ru/sale/#SECTION_CODE#/#ELEMENT_ID#",
        "IBLOCK_14_EXCLUDE" => "",
        "IBLOCK_14_FIELD" => array(
            0 => "NAME",
        ),
        "IBLOCK_14_PROPERTY" => "",
        "IBLOCK_14_REGEX" => "",
        "IBLOCK_14_SECTION_URL" => "https://ohotaktiv.ru/sale/#SECTION_CODE#",
        "IBLOCK_14_SHOW_BRAND" => "ITEMS",
        "IBLOCK_14_SHOW_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_14_SHOW_PROPERTY" => "",
        "IBLOCK_14_SHOW_SECTION" => "N",
        "IBLOCK_14_TITLE" => "Акции",
        "IBLOCK_25_ACTIVE" => "Y",
        "IBLOCK_25_DETAIL_URL" => "https://ohotaktiv.ru/#SECTION_CODE#/#ELEMENT_ID#",
        "IBLOCK_25_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_25_REGEX" => "",
        "IBLOCK_25_SECTION_URL" => "https://ohotaktiv.ru/#SECTION_CODE#",
        "IBLOCK_25_SHOW_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_25_SHOW_SECTION" => "N",
        "IBLOCK_25_TITLE" => "Новости",
        "IBLOCK_3_ACTIVE" => "Y",
        "IBLOCK_3_DETAIL_URL" => "https://ohotaktiv.ru/news/#SECTION_CODE#/#ELEMENT_CODE#",
        "IBLOCK_3_EXCLUDE" => "",
        "IBLOCK_3_FIELD" => array(
            0 => "NAME",
            1 => "TAGS",
            2 => "PREVIEW_TEXT",
            3 => "DETAIL_TEXT",
        ),
        "IBLOCK_3_PROPERTY" => "",
        "IBLOCK_3_REGEX" => "",
        "IBLOCK_3_SECTION_URL" => "https://ohotaktiv.ru/news/#SECTION_CODE#",
        "IBLOCK_3_SHOW_FIELD" => array(
            0 => "PREVIEW_TEXT",
        ),
        "IBLOCK_3_SHOW_PROPERTY" => "",
        "IBLOCK_3_SHOW_SECTION" => "N",
        "IBLOCK_3_TITLE" => "Новости и статьи",
        "IBLOCK_ID" => array(
            0 => "10",
        ),
        "IBLOCK_TYPE" => array(
            0 => "1c_catalog",
        ),
        "INCLUDE_CSS" => "N",
        "INCLUDE_JQUERY" => "N",
        "INPUT_PLACEHOLDER" => "Поиск по сайту",
        "ITEMS_LIMIT" => "4",
        "KEYBOARD_ON" => "Y",
        "MORE_BUTTON_CLASS" => "api-button",
        "MORE_BUTTON_TEXT" => "",
        "PAGER_DESC_NUMBERING" => "Y",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
        "PAGER_SHOW_ALL" => "Y",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => ".default",
        "PAGER_TITLE" => "Результаты поиска",
        "PICTURE" => array(
            0 => "PREVIEW_PICTURE",
        ),
        "PRICE_CODE" => array(
            0 => "Сайт (Цена базовая)",
        ),
        "PRICE_EXT" => "Y",
        "PRICE_VAT_INCLUDE" => "Y",
        "RESIZE_PICTURE" => "64x64",
        "RESULT_LIMIT" => "4",
        "RESULT_NOT_FOUND" => "По вашему запросу ничего не найдено...",
        "SEARCH_MODE" => "JOIN",
        "SORT_BY1" => "HAS_PREVIEW_PICTURE",
        "SORT_BY2" => "",
        "SORT_BY3" => "",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "DESC",
        "SORT_ORDER3" => "ASC",
        "THEME" => "block",
        "TRUNCATE_LENGTH" => "50",
        "USE_CURRENCY_SYMBOL" => "N",
        "USE_TITLE_RANK" => "Y",
        "COMPONENT_TEMPLATE" => "search__desktop"
    ),
    false
);
?>
                    <a class="header-desk__menu-item" href="/personal/favorite/">
                        <svg class="header-desk__menu-icon header-desk__menu-icon--fav">
                            <use xlink:href="#icon-fav"></use>
                        </svg>
                        <span class="header-desk__menu-item-counter header-desk__menu-item-counter--fav header-desk__menu-item-counter--empty"></span>
                        <span class="header-desk__menu-item-name">Избранное</span>
                    </a>
                    <a class="header-desk__menu-item" href="/catalog/compare.php?action=COMPARE">
                        <svg class="header-desk__menu-icon header-desk__menu-icon--compare">
                            <use xlink:href="#icon-compare"></use>
                        </svg>
						<?if(empty($_SESSION['CATALOG_COMPARE_LIST'][10]['ITEMS'])):?>
                        <span class="header-desk__menu-item-counter header-desk__menu-item-counter--compare header-desk__menu-item-counter--empty"></span>
						<?else:?>
                        <span class="header-desk__menu-item-counter header-desk__menu-item-counter--compare"><?=count($_SESSION['CATALOG_COMPARE_LIST'][10]['ITEMS']);?></span>
						<?endif;?>
                        <span class="header-desk__menu-item-name">Сравнение</span>
                    </a>
						<?if($USER->IsAuthorized()):?>
                    <a class="header-desk__menu-item" href="/personal/">
                        <svg class="header-desk__menu-icon header-desk__menu-icon--profile">
                            <use xlink:href="#icon-profile"></use>
                        </svg>
                        <span class="header-desk__menu-item-counter header-desk__menu-item-counter--profile header-desk__menu-item-counter--empty"></span>
                        <span class="header-desk__menu-item-name" >Личный кабинет</span>
                    </a>
						<?else:?>
                    <div class="header-desk__menu-item">
						<a class="pa-login__login--clean" href="/auth/">
                        <svg class="header-desk__menu-icon header-desk__menu-icon--profile">
                            <use xlink:href="#icon-profile"></use>
                        </svg>
						</a>
                        <span class="header-desk__menu-item-counter header-desk__menu-item-counter--profile header-desk__menu-item-counter--empty"></span>
						<a class="header-desk__menu-item-name pa-login__login--clean" href="/auth/">Вход</a>
                        <span>/</span>
						<a class="header-desk__menu-item-name pa-login__register" href="/auth/reg.php">Регистрация</a>
                    </div>
						<?endif;?>

					<a class="header-desk__menu-item js-open-basket" href="/cart/cart.php">

                        <svg class="header-desk__menu-icon header-desk__menu-icon--basket">
                            <use xlink:href="#icon-basket"></use>
                        </svg>
                        <span class="header-desk__menu-item-counter header-desk__menu-item-counter--basket header-desk__menu-item-counter--empty"></span>
                        <span class="header-desk__menu-item-name">Корзина</span>
                    </a>
                    <div class="header-desk__nav">
                        <?$APPLICATION->IncludeComponent("bitrix:menu", "header__desktop--catalog", array(
                            "ROOT_MENU_TYPE" => "left",
                            "MAX_LEVEL" => "3",
                            "CHILD_MENU_TYPE" => "fck-menu",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => "",
                            "COMPONENT_TEMPLATE" => "",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO",
                            "MENU_THEME" => "site"
                        ),
                            false
                        );?>
                    </div>
					<div class="background-menu-popup"></div>
                    <div class="search-list js-search-list-desktop"></div>
                    <div class="basket-popup" id="light-cart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="menu-mob">
        <div class="menu-mob__items">
            <a class="menu-mob__item" href="/sale/"  onclick="ym(42989679,'reachGoal','knopakcii')">
                <svg class="menu-mob__item-icon menu-mob__item-icon--stock">
                    <use xlink:href="#icon-stock"></use>
                </svg>
                <span class="menu-mob__item-name">Акции</span>
            </a>
            <a class="menu-mob__item" href="/catalog/">
                <svg class="menu-mob__item-icon menu-mob__item-icon--catalog">
                    <use xlink:href="#icon-catalog"></use>
                </svg>
                <span class="menu-mob__item-name">Каталог</span>
            </a>
			<a class="menu-mob__item" href="/cart/cart.php">
                <svg class="menu-mob__item-icon menu-mob__item-icon--basket">
                    <use xlink:href="#icon-basket"></use>
                </svg>
                <span class="menu-mob__item-counter menu-mob__item-counter--basket menu-mob__item-counter--empty"></span>
                <span class="menu-mob__item-name">Корзина</span>
            </a>
            <a class="menu-mob__item" href="/personal/favorite/">
                <svg class="menu-mob__item-icon menu-mob__item-icon--fav">
                    <use xlink:href="#icon-fav"></use>
                </svg>
                <span class="menu-mob__item-counter menu-mob__item-counter--fav menu-mob__item-counter--empty"></span>
                <span class="menu-mob__item-name">Избранное</span>
            </a>
<?if($USER->IsAuthorized()):?>
			<a class="menu-mob__item" href="/personal/">
                <svg class="menu-mob__item-icon menu-mob__item-icon--profile">
                    <use xlink:href="#icon-profile"></use>
                </svg>
                <span class="menu-mob__item-counter menu-mob__item-counter--profile menu-mob__item-counter--empty"></span>
                <span class="menu-mob__item-name">Профиль</span>
            </a>
<?else:?>
<a class="menu-mob__item" href="/auth/index.php">
                <svg class="menu-mob__item-icon menu-mob__item-icon--profile">
                    <use xlink:href="#icon-profile"></use>
                </svg>
                <span class="menu-mob__item-counter menu-mob__item-counter--profile menu-mob__item-counter--empty"></span>
                <span class="menu-mob__item-name">Профиль</span>
            </a>
<?endif;?>
        </div>
    </div>
</header>

#WORK_AREA#	<footer class="footer">
        <div class="footer__inner centering">
            <div class="footer__contacts">
                <a class="footer__phone" href="tel:88007008256">8 (800) 700 82 56</a>
                <div class="footer__work-time">Ежедневно, с 9:00 до 18:00</div>
            </div>
            <div class="footer-nav-mob">
                <ul class="list">
                    <li class="list__item list__root-item">Каталог
                    <?$APPLICATION->IncludeComponent("bitrix:menu", "footer__mobile--left", Array(
                        "ROOT_MENU_TYPE" => "leftfooter",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "fck-menu",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                        "COMPONENT_TEMPLATE" => "",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "MENU_THEME" => "site"
                    ),
                        false
                    );?>
                    </li>
                </ul>
                <ul class="list">
                    <li class="list__item list__root-item">Информация для покупателей
                    <?$APPLICATION->IncludeComponent("bitrix:menu", "footer__mobile--right", Array(
                        "ROOT_MENU_TYPE" => "rightfooter",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "fck-menu",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                        "COMPONENT_TEMPLATE" => "",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "MENU_THEME" => "site"
                    ),
                        false
                    );?>
                    </li>
                </ul>
            </div>
            <div class="footer-nav-desk">
                <div class="footer-nav-desk__catalog">
                    <h4>Каталог</h4>
                    <div class="footer-nav-desk__catalog-inner">
                    <?$APPLICATION->IncludeComponent("bitrix:menu", "footer__desktop--left", Array(
                        "ROOT_MENU_TYPE" => "leftfooter",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "fck-menu",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                        "COMPONENT_TEMPLATE" => "",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "MENU_THEME" => "site"
                    ),
                        false
                    );?>
                    </div>
                </div>
                <div class="footer-nav-desk__info">
                    <h4>Информация для покупателей</h4>
                    <div class="footer-nav-desk__info-inner">
                    <?$APPLICATION->IncludeComponent("bitrix:menu", "footer__desktop--right", Array(
                        "ROOT_MENU_TYPE" => "rightfooter",
                        "MAX_LEVEL" => "1",
                        "CHILD_MENU_TYPE" => "fck-menu",
                        "USE_EXT" => "Y",
                        "DELAY" => "N",
                        "ALLOW_MULTI_SELECT" => "N",
                        "MENU_CACHE_TYPE" => "A",
                        "MENU_CACHE_TIME" => "3600",
                        "MENU_CACHE_USE_GROUPS" => "Y",
                        "MENU_CACHE_GET_VARS" => "",
                        "COMPONENT_TEMPLATE" => "horizontal_multilevel",
                        "COMPOSITE_FRAME_MODE" => "A",
                        "COMPOSITE_FRAME_TYPE" => "AUTO",
                        "MENU_THEME" => "site"
                    ),
                        false
                    );?>
                    </div>
                </div>
            </div>
            <div class="footer-desk__info">
                <div class="footer__contacts">
                    <a class="footer__phone" href="tel:88007008256">8 (800) 700 82 56</a>
                    <div class="footer__work-time">Ежедневно, с 9:00 до 18:00</div>
                </div>
                <div class="social">
                    <p class="social__desc">Мы в социальных сетях:</p>
                    <div class="social__items">
						<?if(CNLSMainSettings::GetSiteSetting('nls_social_vk')):?>
							<a target="_blank" rel="nofollow" class="social__item social__item--vk" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_vk')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
						<?endif?>
						<?if(CNLSMainSettings::GetSiteSetting('nls_social_fb')):?>
							<a target="_blank" rel="nofollow" class="social__item social__item--fb" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_fb')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
						<?endif?>
						<?if(CNLSMainSettings::GetSiteSetting('nls_social_yt')):?>
							<a target="_blank" rel="nofollow" class="social__item social__item--yt" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_yt')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
						<?endif?>
						<a rel="nofollow" class="social__item social__item--inst" href="https://www.instagram.com/ohotaktiv/" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;" target="_blank"></a>
				</div>
			</div>
		</div>
		<div class="social">
			<p class="social__desc">Мы в социальных сетях:</p>
			<div class="social__items">
				<?if(CNLSMainSettings::GetSiteSetting('nls_social_vk')):?>
					<a target="_blank" rel="nofollow" class="social__item social__item--vk" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_vk')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
				<?endif?>
				<?if(CNLSMainSettings::GetSiteSetting('nls_social_fb')):?>
					<a target="_blank" rel="nofollow" class="social__item social__item--fb" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_fb')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
				<?endif?>
				<?if(CNLSMainSettings::GetSiteSetting('nls_social_yt')):?>
					<a target="_blank" rel="nofollow" class="social__item social__item--yt" href="<?=CNLSMainSettings::GetSiteSetting('nls_social_yt')?>" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;"></a>
				<?endif?>
				<a rel="nofollow" class="social__item social__item--inst" href="https://www.instagram.com/ohotaktiv/" onclick="ga('send', 'event', 'soc_media', 'click'); yaCounter42989679.reachGoal('soc_media'); return true;" target="_blank"></a>
			</div>
		</div>
		<div class="footer__copy">
			<div class="footer__own">© 2015 — <?=date('Y');?> ОхотАктив.
<span>Данный сайт носит исключительно информационный характер и ни при каких условиях не является договором публичной оферты.<br>Для уточнения информации о наличии, стоимости товаров и (или) услуг, а так же иной информации, пожалуйста, обращайтесь к менеджерам клиентского обслуживания.</span>
			</div>

		</div>
    </footer>
    <div class="callback">
        <div class="callback__body">
		<?$APPLICATION->IncludeComponent(
			"bitrix:form.result.new",
			"footer__feedback",
			array(
				"AJAX_MODE" => "Y",
				"AJAX_OPTION_SHADOW" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"AJAX_OPTION_HISTORY" => "N",
				"AJAX_OPTION_ADDITIONAL" => "feedback",
				"CACHE_TIME" => "3600",
				"CACHE_TYPE" => "A",
				"CHAIN_ITEM_LINK" => "",
				"CHAIN_ITEM_TEXT" => "",
				"EDIT_URL" => "",
				"IGNORE_CUSTOM_TEMPLATE" => "N",
				"LIST_URL" => "",
				"SEF_MODE" => "N",
				"SUCCESS_URL" => "",
				"USE_EXTENDED_ERRORS" => "N",
				"VARIABLE_ALIASES" => array(
					"RESULT_ID" => "",
					"WEB_FORM_ID" => ""
				),
				"WEB_FORM_ID" => "3"
			)
		);?>
        </div>
    </div>
	<?$APPLICATION->IncludeComponent(
	"bitrix:system.auth.form",
	"footer__login",
	Array(
		"AJAX_MODE" => "Y",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"FORGOT_PASSWORD_URL" => SITE_DIR."/auth/index.php?forgot_password=yes",
		"PROFILE_URL" => SITE_DIR."personal/",
		"REGISTER_URL" => SITE_DIR."/auth/reg.php",
		"SHOW_ERRORS" => "Y"
	)
);?>

<!-- not aviable Order form -->
<div class="custom_order_form">
<div class="form_order_order">
<div class="order_close btn-close"></div>
<h3>Заказ отсутствующего товара</h3>
	<div class="order_thy"></div>
	<div class="order_info">
	<form action="/12dev/email_send/email_send.php" method="post" class="form_form_order">
		<span class="message-order-for"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="exclamation-circle" class="svg-inline--fa fa-exclamation-circle fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path></svg>Товар, который вы хотите получить распродан. Чтобы получить уведомление о поступлении товара на склад заполните данную форму</span>
		<input class="product_id" type="hidden" name="product_id" value="">
		<input class="product_title" type="hidden" name="order_product" value="">
		<input class="product_url" type="hidden" name="order_url" value="">
		<span class="product_name"></span>
				<div class="order_product_price">
					<span class="order_product_price_current"><span class="rub">₽</span></span>
					<span class="order_product_price_old"><span class="rub">₽</span></span>
				</div>
		<input class="order_user_name" type="text" name="order_name" value="" placeholder="Имя" required>
		<input class="order_phone_user" type="text" name="order_phone" value="" placeholder="Телефон" required>
		<input class="order_email_user" type="text" name="order_email" value="" placeholder="email" required>
		<button class="order_btn" type="submit">Заказать</button>

	</form>
</div>
	</div>
</div>
<!-- not aviable Order form -->

<!-- Help me form -->
	<div class="help_me_buy">
<div class="form_order_order">
<div class="order_close btn-close"></div>
<h3>Помощь в подборе товара</h3>
	<div class="order_thy_help"></div>
<div class="order_info_help">
	<form action="/12dev/email_send/email_send_help.php" method="post" class="form_form_order_help">

		<input class="order_user_name" type="text" name="order_name" value="" placeholder="Имя" required>
		<input class="order_phone_user" type="phone" name="order_phone" value="" placeholder="Телефон" required>
		<input class="order_email_user" type="email" name="order_email" value="" placeholder="email" required>
		<button class="order_btn" type="submit">Отправить заявку</button>

	</form>
</div>
	</div>
</div>
<!-- Help me form -->

    <?include_once(__DIR__ . '/sale/template.php');?>
	<?$pathToFile = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . SITE_TEMPLATE_PATH; ?>
    <script src="<?=SITE_TEMPLATE_PATH;?>/sale/handlebars.min.js"></script>
    <script src="<?=SITE_TEMPLATE_PATH;?>/sale/events.js?<?=filemtime($pathToFile . '/sale/events.js');?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH;?>/sale/promo.js?<?=filemtime($pathToFile . '/sale/promo.js');?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH;?>/sale/session.js?<?=filemtime($pathToFile . '/sale/session.js');?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH;?>/sale/cart.js?<?=filemtime($pathToFile . '/sale/cart.js');?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH;?>/sale/note.js?<?=filemtime($pathToFile . '/sale/note.js');?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH;?>/js/favorite.js?<?=filemtime($pathToFile . '/js/favorite.js');?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH;?>/js/compare.js?<?=filemtime($pathToFile . '/js/compare.js');?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH;?>/js/register.js?<?=filemtime($pathToFile . '/js/register.js');?>"></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/goals.js?<?=filemtime($pathToFile . '/js/register.js');?>"></script>

	<?if ($APPLICATION->GetCurPage(true) !== '/index.php'):?>
	    <script>document.querySelector("body .header").style.position = "fixed";</script>
	<?endif;?>

	<?if (!isset($_GET['no_metrics'])):?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-92403222-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'UA-92403222-1');
		</script>

		<!-- Yandex.Metrika counter -->
		<script type="text/javascript" async>
			(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
			m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
			(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

			ym(42989679, "init", {
					clickmap:true,
					trackLinks:true,
					accurateTrackBounce:true,
					webvisor:true,
					ecommerce:"dataLayer"
			});
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/42989679" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->

		<!-- Begin Verbox {literal} -->
		<script type='text/javascript' async>
			(function(d, w, m) {
				window.supportAPIMethod = m;
				var s = d.createElement('script');
				s.type ='text/javascript'; s.id = 'supportScript'; s.charset = 'utf-8';
				s.async = true;
				var id = '272a7d9dd0c4f04c75ec4839be48024d';
				s.src = 'https://admin.verbox.ru/support/support.js?h='+id;
				var sc = d.getElementsByTagName('script')[0];
				w[m] = w[m] || function() { (w[m].q = w[m].q || []).push(arguments); };
				if (sc) sc.parentNode.insertBefore(s, sc);
				else d.documentElement.firstChild.appendChild(s);
			})(document, window, 'Verbox');
		</script>
		<!-- {/literal} End Verbox -->
	<?endif;?>

</body>
</html>
