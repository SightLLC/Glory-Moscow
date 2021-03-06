<?php
rcl_enqueue_style('rmag',__FILE__);

function rmag_global_unit(){
    if(defined('RMAG_PREF')) return false;
    global $wpdb,$rmag_options,$user_ID;

    if(!isset($_SESSION['return_'.$user_ID]))
            $_SESSION['return_'.$user_ID] = (isset($_SERVER['HTTP_REFERER']))? $_SERVER['HTTP_REFERER']: '/';
    
    $rmag_options = get_option('primary-rmag-options');
    define('RMAG_PREF', $wpdb->prefix."rmag_");
}
add_action('init','rmag_global_unit',10);

if (!session_id()) { session_start(); }

require_once("functions.php");
require_once("admin-pages.php");
require_once("functions/shortcodes.php");
require_once("functions/ajax-func.php");

add_action('init','rcl_tab_orders');
function rcl_tab_orders(){
    rcl_tab('orders','rcl_orders','Заказы',array('ajax-load'=>true,'class'=>'fa-shopping-cart','order'=>30,'path'=>__FILE__));
}

function rcl_orders($author_lk){
    global $wpdb,$user_ID,$rmag_options,$rcl_options,$order;

	if($user_ID!=$author_lk) return false;

        $block = apply_filters('content_order_tab','');

	if(isset($_GET['order-id'])){

                $order = rcl_get_order($_GET['order-id']);

                if($order->order_author!=$user_ID) return false;

                $status = $order->order_status;
                $order_id = $order->order_id;
                $price = $order->order_price;

                $block .= '<a class="recall-button view-orders" href="'.rcl_format_url(get_author_posts_url($author_lk),'orders').'">Смотреть все заказы</a>';

                $block .= '<h3>Заказ №'.$order_id.'</h3>';
                
                $postdata = rcl_encode_post(array(
                    'callback'=>'rcl_trash_order',
                    'order_id'=>$order_id
                ));

                $block .= '<div id="manage-order">';
                if($status == 1||$status == 5) 
                    $block .= '<div class="remove-order">'
                        . '<input class="remove_order recall-button rcl-ajax" data-post="'.$postdata.'" type="button" value="Удалить">'
                        . '</div>';
                if($status==1&&function_exists('rcl_payform')){
                    $type_pay = $rmag_options['type_order_payment'];
                    if($type_pay==1||$type_pay==2){
                        $block .= rcl_payform(array('id_pay'=>$order_id,'summ'=>$price,'type'=>2));
                    }else{
                        $block .= '<input class="pay_order recall-button" onclick="rcl_pay_order_private_account(this);return false;" type="button" name="pay_order" data-order="'.$order_id.'" value="Оплатить">';
                    }
                }
                $block .= '</div>';

                $block .= '<div class="redirectform"></div>';

		$block .= rcl_get_include_template('order.php',__FILE__);

	}else{

		global $orders;

		$orders = rcl_get_orders(array('user_id'=>$user_ID,'status_not_in'=>6));

		if(!$orders) $block .= '<p>У вас пока не оформлено ни одного заказа.</p>';
		else $block .= rcl_get_include_template('orders-history.php',__FILE__);

	}

	return $block;
}

add_filter('rcl_functions_js','rcl_magazine_functions_js');
function rcl_magazine_functions_js($string){
    global $rmag_options;
    
    $cart_url = (isset($rmag_options['basket_page_rmag']))? get_permalink($rmag_options['basket_page_rmag']): '#';
    
    $ajaxdata = "type: 'POST', data: dataString, dataType: 'json', url: Rcl.ajaxurl,";

    $string .= "
        /* Удаляем заказ пользователя в корзину */
        function rcl_trash_order(e,data){       
            jQuery('#manage-order, table.order-data').remove();
            jQuery('.redirectform').html(data.result);
        }
        /* Увеличиваем количество товара в большой корзине */
        function rcl_cart_add_product(e){
            rcl_preloader_show('#cart-form > table');
            var id_post = jQuery(e).parent().data('product');
            var number = 1;
            var dataString = 'action=rcl_add_cart&id_post='+ id_post+'&number='+ number;
            dataString += '&ajax_nonce='+Rcl.nonce;
            jQuery.ajax({
            ".$ajaxdata."
            success: function(data){
                rcl_preloader_hide();
                if(data['recall']==100){
                    jQuery('.cart-summa').text(data['data_sumprice']);
                    jQuery('#product-'+data['id_prod']+' .sumprice-product').text(data['sumproduct']);
                    jQuery('#product-'+data['id_prod']+' .number-product').text(data['num_product']);
                    jQuery('.cart-numbers').text(data['allprod']);
                }
                if(data['recall']==200){
                    alert('Отрицательное значение!');
                }
            }
            });
            return false;
        }
        /* Уменьшаем товар количество товара в большой корзине */
        function rcl_cart_remove_product(e){
            rcl_preloader_show('#cart-form > table');
            var id_post = jQuery(e).parent().data('product');
            var number = 1;
            if(number>0){
                var dataString = 'action=rcl_remove_product_cart&id_post='+ id_post+'&number='+ number;
                dataString += '&ajax_nonce='+Rcl.nonce;
                jQuery.ajax({
                ".$ajaxdata."
                success: function(data){
                    rcl_preloader_hide();
                    if(data['recall']==100){
                        jQuery('.cart-summa').text(data['data_sumprice']);
                        jQuery('#product-'+data['id_prod']+' .sumprice-product').text(data['sumproduct']);

                        var numprod = data['num_product'];
                        if(numprod>0){
                            jQuery('#product-'+data['id_prod']+' .number-product').text(data['num_product']);
                        }else{
                            var numberproduct = 0;
                            jQuery('#product-'+data['id_prod']).remove();
                        }
                        if(data['allprod']==0) jQuery('.confirm').remove();

                        jQuery('.cart-numbers').text(data['allprod']);
                    }
                    if(data['recall']==200){
                        alert('Отрицательное значение!');
                    }
                    if(data['recall']==300){
                        alert('Вы пытаетесь удалить из корзины больше товара чем там есть!');
                    }
                }
                });
            }
            return false;
        }
        /* Кладем товар в малую корзину */
        function rcl_add_cart(e){            
            var id_post = jQuery(e).data('product');
            rcl_preloader_show('#product-'+id_post+' > div');
            var id_custom_prod = jQuery(e).attr('name');
            if(id_custom_prod){
                var number = jQuery('#number-custom-product-'+id_custom_prod).val();
            }else{
                var number = jQuery('#number_product').val();
            }
            var dataString = 'action=rcl_add_minicart&id_post='+id_post+'&number='+number+'&custom='+id_custom_prod;
            dataString += '&ajax_nonce='+Rcl.nonce;
            jQuery.ajax({
            ".$ajaxdata."
            success: function(data){
                rcl_preloader_hide();
                if(data['recall']==100){
                    rcl_close_notice('#rcl-notice > div');
                    jQuery('.empty-basket').replaceWith(data['empty-content']);
                    jQuery('.cart-summa').html(data['data_sumprice']);
                    jQuery('.cart-numbers').html(data['allprod']);
                    rcl_notice('Добавлено в корзину!<br>В корзине товаров: '+data['allprod']+' шт<br><a style=\"text-decoration:underline;\" href=\"".$cart_url."\">Перейти в корзину</a>','success');
                }
                if(data['recall']==200){
                    alert('Отрицательное значение!');
                }
            }
            });
            return false;
        }
        ";
    return $string;
}