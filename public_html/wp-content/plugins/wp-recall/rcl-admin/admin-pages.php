<?php
function rcl_options_panel(){
    $need_update = get_option('rcl_addons_need_update');
    $cnt = count($need_update);
    $notice = ($cnt)? ' <span class="update-plugins count-'.$cnt.'"><span class="plugin-count">'.$cnt.'</span></span>': '';
    add_menu_page(__('WP-RECALL','wp-recall').$notice, __('WP-RECALL','wp-recall').$notice, 'manage_options', 'manage-wprecall', 'rcl_global_options');
    add_submenu_page( 'manage-wprecall', __('SETTINGS','wp-recall'), __('SETTINGS','wp-recall'), 'manage_options', 'manage-wprecall', 'rcl_global_options');
    $hook = add_submenu_page( 'manage-wprecall', __('Add-ons','wp-recall').$notice, __('Add-ons','wp-recall').$notice, 'manage_options', 'manage-addon-recall', 'rcl_render_addons_manager');
    add_action( "load-$hook", 'rcl_add_options_addons_manager' );
    add_submenu_page( 'manage-wprecall', __('Repository','wp-recall'), __('Repository','wp-recall'), 'manage_options', 'rcl-repository', 'rcl_repository_page');
    add_submenu_page( 'manage-wprecall', __('Documentation','wp-recall'), __('Documentation','wp-recall'), 'manage_options', 'manage-doc-recall', 'rcl_doc_manage');
}

function rcl_doc_manage(){
    echo '<h2>'.__('Documentation for the plugin WP-RECALL','wp-recall').'</h2>
    <ol>
	<li><a href="http://codeseller.ru/ustanovka-plagina-wp-recall-na-sajt/" target="_blank">Установка плагина </a></li>
	<li><a href="http://codeseller.ru/obnovlenie-plagina-wp-recall-i-ego-dopolnenij/" target="_blank">Обновление плагина и его дополнений</a></li>
	<li><a href="http://codeseller.ru/nastrojki-plagina-wp-recall/" target="_blank">Настройки плагина</a></li>
	<li><a href="http://codeseller.ru/shortkody-wp-recall/" target="_blank">Используемые шорткоды Wp-Recall</a></li>
	<li><a href="http://codeseller.ru/obshhie-svedeniya-o-dopolneniyax-wp-recall/" target="_blank">Общие сведения о дополнениях Wp-Recall</a></li>
	<li><a href="http://codeseller.ru/post-group/poryadok-dobavleniya-funkcionala-grupp-s-pomoshhyu-plagina-wp-recall/">Порядок добавления функционала групп</a></li>
	<li><a href="http://codeseller.ru/prodcat/dopolneniya-wp-recall/" target="_blank">Все дополнения Wp-Recall</a></li>
	<li><a title="Произвольные поля Wp-Recall" href="http://codeseller.ru/proizvolnye-polya-wp-recall/" target="_blank">Произвольные поля профиля Wp-Recall</a></li>
	<li><a title="Произвольные поля формы публикации Wp-Recall" href="http://codeseller.ru/proizvolnye-polya-formy-publikacii-wp-recall/" target="_blank">Произвольные поля формы публикации Wp-Recall</a></li>
	<li><a href="http://codeseller.ru/post-group/sozdaem-svoe-dopolnenie-dlya-wp-recall-vyvodim-svoyu-vkladku-v-lichnom-kabinete/" target="_blank">Пример создания своего дополнения Wp-Recall</a></li>
	<li><a href="http://codeseller.ru/xuki-i-filtry-wp-recall/" target="_blank">Функции и хуки Wp-Recall для разработки</a></li>
	<li><a href="http://codeseller.ru/api-rcl/" target="_blank">API WP-Recall</a></li>
	<li><a href="http://codeseller.ru/groups/obnovleniya/" target="_blank">История обновлений Wp-Recall</a></li>
	<li><a title="Используемые библиотеки и ресурсы" href="http://codeseller.ru/ispolzuemye-biblioteki-i-resursy/">Используемые библиотеки и ресурсы</a></li>
	<li><a href="http://codeseller.ru/forum/problemi-i-reshenia-na-localnom-servere/">Проблемы и решения на локальном сервере</a></li>
	<li><a href="http://codeseller.ru/faq/" target="_blank">FAQ</a></li>
    </ol>';
}

if (is_admin()) add_action('admin_init', 'rcl_postmeta_post');
function rcl_postmeta_post() {
    add_meta_box( 'recall_meta', __('Settings Wp-Recall','wp-recall'), 'rcl_options_box', 'post', 'normal', 'high'  );
    add_meta_box( 'recall_meta', __('Settings Wp-Recall','wp-recall'), 'rcl_options_box', 'page', 'normal', 'high'  );
}

add_filter('rcl_post_options','rcl_gallery_options',10,2);
function rcl_gallery_options($options,$post){
    $mark_v = get_post_meta($post->ID, 'recall_slider', 1);
    $options .= '<p>'.__('Pictures record the withdrawal in the gallery Wp-Recall?','wp-recall').':
        <label><input type="radio" name="wprecall[recall_slider]" value="" '.checked( $mark_v, '',false ).' />'.__('No','wp-recall').'</label>
        <label><input type="radio" name="wprecall[recall_slider]" value="1" '.checked( $mark_v, '1',false ).' />'.__('Yes','wp-recall').'</label>
    </p>';
    return $options;
}

function rcl_options_box( $post ){
    $content = '';
	echo apply_filters('rcl_post_options',$content,$post); ?>
	<input type="hidden" name="rcl_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	<?php
}

function rcl_postmeta_update( $post_id ){
    if(!isset($_POST['rcl_fields_nonce'])) return false;
    if ( !wp_verify_nonce($_POST['rcl_fields_nonce'], __FILE__) ) return false;
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE  ) return false;
    if ( !current_user_can('edit_post', $post_id) ) return false;

    if( !isset($_POST['wprecall']) ) return false;

    $POST = $_POST['wprecall'];
    
    foreach($POST as $key=>$value ){
        if(!is_array($value)) $value = trim($value);
        if($value=='') delete_post_meta($post_id, $key);
        else update_post_meta($post_id, $key, $value);
    }
    return $post_id;
}

//Настройки плагина в админке
function rcl_global_options(){
    global $rcl_options;
    
    include_once RCL_PATH.'functions/rcl_options.php';
    $fields = new Rcl_Options();

    $rcl_options = get_option('rcl_global_options');

    $content = '<h2>'.__('Configure the plugin Wp-Recall and additions','wp-recall').'</h2>
        <div id="recall" class="left-sidebar wrap">
	<form method="post" id="rcl-options-form" onsubmit="rcl_update_options();return false;" action="">
	'.wp_nonce_field('update-options-rcl','_wpnonce',true,false).'
	<span class="title-option active"><span class="wp-menu-image dashicons-before dashicons-admin-generic"></span> '.__('General settings','wp-recall').'</span>
	<div class="wrap-recall-options" style="display:block;">';

                $args = array(
                    'selected'   => $rcl_options['lk_page_rcl'],
                    'name'       => 'global[lk_page_rcl]',
                    'show_option_none' => '<span style="color:red">'.__('Not selected','wp-recall').'</span>',
                    'echo'       => 0
                );

                $content .= $fields->option_block(array(
                    $fields->title(__('Personal office','wp-recall')),
                    $fields->label(__('The order of withdrawal of the personal Cabinet','wp-recall')),
                    $fields->option('select',array(
                            'name'=>'view_user_lk_rcl',
                            'parent'=>true,
                            'options'=>array(
                                __('On the archive page of the author','wp-recall'),
                                __('Using the shortcode [wp-recall]','wp-recall'))
                        )),
                    $fields->child(
                        array(
                            'name'=>'view_user_lk_rcl',
                            'value'=>1
                        ),
                        array(
                            $fields->label(__('The host page the shortcode','wp-recall')),
                            wp_dropdown_pages( $args ),
                            $fields->label(__('The formation of links to personal account','wp-recall')),
                            $fields->option('text',array('name'=>'link_user_lk_rcl')),
                            $fields->notice(__('The link is formed by a principle "/slug_page/?get=ID". The parameter "get" can be set here. By default user','wp-recall'))
                        )
                    ),
                    $fields->label(__('Download tabs','wp-recall')),
                    $fields->option('select',array(
                        'name'=>'tab_newpage',
                        'options'=>array(
                            __('Downloads all','wp-recall'),
                            __('On a separate page','wp-recall'),
                            __('Ajax loading','wp-recall'))
                    )),
                    $fields->label(__('Inactivity timeout','wp-recall')),
                    $fields->option('number',array('name'=>'timeout')),
                    $fields->notice(__('Specify the time in minutes after which the user will be considered offline if you did not show activity on the website. The default is 10 minutes.','wp-recall'))
                ));


                $roles = array(
                    10=>__('only Administrators','wp-recall'),
                    7=>__('Editors and older','wp-recall'),
                    2=>__('Authors and older','wp-recall'),
                    1=>__('Participants and older','wp-recall'),
                    0=>__('All users','wp-recall'));

                $content .= $fields->option_block(array(
                    $fields->title(__('Access to the console','wp-recall')),
                    $fields->label(__('Access to the site is permitted console','wp-recall')),
                    $fields->option('select',array(
                            'default'=>7,
                            'name'=>'consol_access_rcl',
                            'options'=>$roles
                    )),
                    $fields->notice(__('If the selected archive page of the author, in the right place template author.php paste the code if(function_exists(\'wp_recall\')) wp_recall();','wp-recall')),

                ));

		$filecss = (file_exists(RCL_UPLOAD_PATH.'css/minify.css'))? '<a href="'.RCL_URL.'css/getcss.php">'.__('Download the current style file for editing','wp-recall').'</a>':'';
                $content .= $fields->option_block(
                    array(
			$fields->title(__('Making','wp-recall')),
                        
                        $fields->label(__('Primary color','wp-recall')),                       
                        $fields->option('text',array('name'=>'primary-color','default'=>'#4C8CBD')),

			$fields->label(__('The placement of the buttons sections','wp-recall')),
                        $fields->option('select',array(
                            'name'=>'buttons_place',
                            'options'=>array(
                                __('Top','wp-recall'),
                                __('Left','wp-recall'))
                        )),

			rcl_theme_list(),

                        $fields->label(__('Pause Slider','wp-recall')),
                        $fields->option('number',array('name'=>'slide-pause')),
                        $fields->notice(__('The value of the pause between slide transitions in seconds. Default value is 0 - the slide show is not made','wp-recall')),

                    )
                );
                
                $content .= $fields->option_block(
                    array(
			$fields->title(__('Caching','wp-recall')),
                        
                        $fields->label(__('Cache','wp-recall')),
                        $fields->option('select',array(
                            'name'=>'use_cache',
                            'parent'=>true,
                            'options'=>array(
                                __('Disabled','wp-recall'),
                                __('Included','wp-recall'))
                        )),
                        
                        $fields->child(
                             array(
                                 'name'=>'use_cache',
                                 'value'=>1
                             ),
                             array(
                                 $fields->label(__('Time cache (seconds)','wp-recall')),
                                 $fields->option('number',array('name'=>'cache_time','default'=>3600)),
                                 $fields->notice(__('Default','wp-recall').': 3600'),
                                 $fields->label(__('Cache output','wp-recall')),
                                 $fields->option('select',array(
                                    'name'=>'cache_output',
                                    'options'=>array(
                                        __('All users','wp-recall'),
                                        __('Only guests','wp-recall'))
                                ))
                             )
                        ),

                        $fields->label(__('Minimization of style files','wp-recall')),
                        $fields->option('select',array(
                            'name'=>'minify_css',
                            'parent'=>true,
                            'options'=>array(
                                __('Disabled','wp-recall'),
                                __('Included','wp-recall'))
                        )),
                        $fields->notice(__('Minimization of style files only works against the style files Wp-Recall and additions that support this feature','wp-recall'))			
                    )
                );

                $content .= $fields->option_block(
                    array(
                        $fields->title(__('Login and register','wp-recall')),
                        $fields->label(__('The order','wp-recall')),
                        $fields->option('select',array(
                            'name'=>'login_form_recall',
                            'parent'=>true,
                            'options'=>array(
                                __('Floating form','wp-recall'),
                                __('On a separate page','wp-recall'),
                                __('Form Wordpress','wp-recall'),
                                __('The form in the widget','wp-recall'))
                        )),
                        $fields->child(
                            array(
                              'name' => 'login_form_recall',
                              'value' => 1
                            ),
                            array(
                                $fields->label(__('ID of the page with the shortcode [loginform]','wp-recall')),
                                wp_dropdown_pages( array(
                                        'selected'   => $rcl_options['page_login_form_recall'],
                                        'name'       => 'global[page_login_form_recall]',
                                        'show_option_none' => __('Not selected','wp-recall'),
                                        'echo'             => 0 )
                                )
                            )
                        ),
                        $fields->label(__('A registration confirmation by the user','wp-recall')),
                        $fields->option('select',array(
                            'name'=>'confirm_register_recall',
                            'options'=>array(
                                __('Not used','wp-recall'),
                                __('Used','wp-recall'))
                        )),
                        $fields->label(__('Redirect user after login','wp-recall')),
                        $fields->option('select',array(
                            'name'=>'authorize_page',
                            'parent'=>1,
                            'options'=>array(
                                __('The user profile','wp-recall'),
                                __('Current page','wp-recall'),
                                __('Arbitrary URL','wp-recall'))
                        )),
                        $fields->child(
                            array(
                              'name' => 'authorize_page',
                              'value' => 2
                            ),
                            array(
                                $fields->label(__('URL','wp-recall')),
                                $fields->option('text',array('name'=>'custom_authorize_page')),
                                $fields->notice(__('Enter your URL below, if you select an arbitrary URL after login','wp-recall'))
                            )
                        ),
                        $fields->label(__('Field repeat password','wp-recall')),
                        $fields->option('select',array(
                            'name'=>'repeat_pass',
                            'options'=>array(__('Disabled','wp-recall'),__('Displayed','wp-recall'))
                        )),
                        $fields->label(__('Indicator password complexity','wp-recall')),
                        $fields->option('select',array(
                            'name'=>'difficulty_parole',
                            'options'=>array(__('Disabled','wp-recall'),__('Displayed','wp-recall'))
                        ))
                    )
                );

                $content .= $fields->option_block(
                    array(
                        $fields->title(__('Recallbar','wp-recall')),
                        $fields->label(__('Conclusion the panel recallbar','wp-recall')),
                        $fields->option('select',array(
                            'name'=>'view_recallbar',
                            'options'=>array(__('Disabled','wp-recall'),__('Included','wp-recall'))
                        ))
                    )
                );

                $content .= $fields->option_block(
                    array(
                        $fields->title(__('Your gratitude','wp-recall')),
                        $fields->label(__('To display a link to the developer`s site (Thank you, if you decide to show)','wp-recall')),
                        $fields->option('select',array(
                               'name'=>'rcl_footer_link',
                               'type'=>'local',
                               'options'=>array(__('No','wp-recall'),__('Yes','wp-recall'))
                        ))
                    )
                );

    $content .= '</div>';

    $content = apply_filters('admin_options_wprecall',$content);

    $content .= '<div class="submit-block">
    <p><input type="submit" class="button button-primary button-large right" name="rcl_global_options" value="'.__('Save settings','wp-recall').'" /></p>
    </div></form></div>';

    echo $content;
}

add_action('wp_ajax_rcl_update_options', 'rcl_update_options');
function rcl_update_options(){
    global $rcl_options;
    
    if( !wp_verify_nonce( $_POST['_wpnonce'], 'update-options-rcl' ) ){
        $result['result'] = 0;
        $result['notice'] = __('Error','wp-recall');
        echo json_encode($result);
        exit;
    }

    $POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    if($POST['global']['login_form_recall']==1&&!isset($POST['global']['page_login_form_recall'])){
            $POST['global']['page_login_form_recall'] = wp_insert_post(array('post_title'=>__('Login and register','wp-recall'),'post_content'=>'[loginform]','post_status'=>'publish','post_author'=>1,'post_type'=>'page','post_name'=>'login-form'));
    }

    foreach((array)$POST['global'] as $key => $value){
        $value = apply_filters('rcl_global_option_value',$value,$key);
        $options[$key] = $value;
    }

    if(isset($rcl_options['users_page_rcl'])) 
        $options['users_page_rcl'] = $rcl_options['users_page_rcl'];

    update_option('rcl_global_options',$options);

    if(isset($POST['local'])){
        foreach((array)$POST['local'] as $key => $value){
            $value = apply_filters('rcl_local_option_value',$value,$key);
            update_option($key,$value);
        }
    }

    $rcl_options = $options;

    if( current_user_can('edit_plugins') ){
        rcl_update_scripts();
        rcl_minify_style();
    }

    $result['result'] = 1;
    $result['notice'] = __('Options saved!','wp-recall');

    echo json_encode($result);
    exit;

}

function rcl_theme_list(){
    global $rcl_options;

    if(!isset($rcl_options['color_theme'])) $color_theme = 1;
    else $color_theme = $rcl_options['color_theme'];
    $dirs   = array(RCL_PATH.'css/themes',RCL_TAKEPATH.'themes');
    $t_list = '';
    foreach($dirs as $dir){
        //echo $dir;
        if(!file_exists($dir)) continue;
        $ts = scandir($dir,1);

        foreach((array)$ts as $t){
                if ( false == strpos($t, '.css') ) continue;
                $name = str_replace('.css','',$t);
                $t_list .= '<option value="'.$name.'" '.selected($color_theme,$name,false).'>'.$name.'</option>';
        }
    }
    if($t_list){
            $content = '<label>'.__('Used template','wp-recall').'</label>';
            $content .= '<select name="global[color_theme]" size="1">
                <option value="">'.__('Not connected','wp-recall').'</option>
                    '.$t_list.'
            </select>';

        return $content;
    }
    return false;
}

function wp_enqueue_theme_rcl($url){
    wp_enqueue_style( 'theme_rcl', $url );
}

add_action('admin_notices', 'my_plugin_admin_notices');
function my_plugin_admin_notices() {
    if(isset($_GET['page'])&&(
            $_GET['page']=='manage-wprecall'||
            $_GET['page']=='rcl-repository'||
            $_GET['page']=='manage-doc-recall'||
            $_GET['page']=='manage-addon-recall'
    ))
      echo "<div class='updated is-dismissible notice'><p>Понравился плагин WP-Recall? Поддержите развитие плагина, оставив положительный отзыв на его странице в <a target='_blank' href='https://wordpress.org/plugins/wp-recall/'>репозитории</a>!</p></div>";
}

include 'repository.php';