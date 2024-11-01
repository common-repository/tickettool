<?php
/*
Plugin Name: TicketTool
Plugin URI: https://tickettool.net/en/index/instr/wordpress-event-ticketing-plugin
Description: Event ticketing plugin. Use it to import and manage events from TicketTool.net.
Version: 1.0.6
Author: Viacheslav Kremeshnyi
Author URI: http://tickettool.net/
*/
 
function tickettool_options() {
	
	switch( $_GET['tickettool_page'] ){
	    default:
		tickettool_options_display();
		break;
	}
}

function tickettool_options_display(){
        if( $_GET['tickettool_page'] == 'list')tickettool_import_list();
	if( count($_POST) ){
	        update_option('wp_ticketool_blank', $_POST['wp_ticketool_blank']);
	        update_option('wp_ticketool_expired', $_POST['wp_ticketool_expired']);
		update_option('wp_ticketool_key', $_POST['wp_ticketool_key']);
		update_option('wp_ticketool_thumbnail', $_POST['wp_ticketool_thumbnail']);
		update_option('wp_ticketool_thumbnail_width', $_POST['wp_ticketool_thumbnail_width']);
		update_option('wp_ticketool_iframe', $_POST['wp_ticketool_iframe']);
		update_option('wp_ticketool_iframe_width', $_POST['wp_ticketool_iframe_width']);
		update_option('wp_ticketool_iframe_height', $_POST['wp_ticketool_iframe_height']);
		update_option('wp_ticketool_map', $_POST['wp_ticketool_map']);
		update_option('wp_ticketool_map_width', $_POST['wp_ticketool_map_width']);
		update_option('wp_ticketool_map_height', $_POST['wp_ticketool_map_height']);		
		update_option('wp_ticketool_cat', $_POST['cat']);
		update_option('wp_ticketool_button_title', $_POST['wp_ticketool_button_title']);
		update_option('wp_ticketool_lang', $_POST['wp_ticketool_lang']);
		echo '<div id="message" class="updated fade"><p><strong>Saved</strong></p></div>';
	}
	$lang = get_option('wp_ticketool_lang');
	$langs = array('en' => 'English', 'de' => 'German', 'ru' => 'Russian', 'es' => 'Spanish');
	foreach($langs as $key=>$value){
		$selected_lang = '';
		if($lang == $key)$selected_lang = 'selected';
		$lang_select .= "<option value='".$key."' ".$selected_lang.">".$value."</option>";
	}
	
	$checked = '';
	if( get_option('wp_ticketool_iframe') == 1)$checked = 'checked';
	$checked_thumbnail = '';
	if( get_option('wp_ticketool_thumbnail') == 1)$checked_thumbnail = 'checked';
	$checked_expired = '';
	if( get_option('wp_ticketool_expired') == 1)$checked_expired = 'checked';
	$checked_blank = '';
	if( get_option('wp_ticketool_blank') == 1)$checked_blank = 'checked';
	$checked_map = '';
	if( get_option('wp_ticketool_map') == 1)$checked_map = 'checked';	
	$button_title = get_option('wp_ticketool_button_title');
	if( !$button_title ) $button_title = 'Buy tickets';
	$select = wp_dropdown_categories('hide_empty=0&echo=0&show_option_none=Select category&orderby=name&selected='.get_option('wp_ticketool_cat'));
	$import_text = "";
	if(get_option('wp_ticketool_key'))$import_text = "<h3>TicketTool events import</h3><form method='post' action='".$_SERVER['PHP_SELF']."?page=tickettool/index.php&tickettool_page=list'><input id='bottom_import' type='submit' class='button-primary' value='Import events'></form><br><br>";
	echo "<div class='wrap'>
	<h2>TicketTool Plugin Settings</h2>
	".$import_text."
	<form method='post' action='".$_SERVER['PHP_SELF']."?page=tickettool/index.php&amp;update=true'>
	
        <p>To get import key, plese register on <a href='https://tickettool.net/' target='_blank'>TicketTool.net</a>, and visit &ldquo;Import&ldquo; page in admin panel.
	 
	<div style='margin-bottom:4px;float:left;height:210px;width:350px;'>
	       <h3>Import key</h3>
	       <div style='width:100px;float:left;'>Key:</div>
	       <input style='width:230px;' class='regular-text' type='text' name='wp_ticketool_key' value='".get_option('wp_ticketool_key')."'>
	       <p>Test key: 1021c966b4144c5c9bfdc13c982647d6
	       <h3>Category to save event pages:</h3>	
	       <div style='width:100px;float:left;'>Category:</div>
	       ".$select."
	       <div style='margin-bottom:10px;'>
		       <div style='width:100px;float:left;clear:both;'>Import expired events:</div>
		       <input ".$checked_expired." type='checkbox' value='1' name='wp_ticketool_expired'>
	       </div>
	</div>
	
	
	<div style='margin-bottom:4px;float:left;height:210px;width:350px;'>
	       <h3>Buy button title:</h3>
	       <div style='margin-bottom:10px;'>
		  <div style='width:100px;float:left;clear:both;'>Open event on blank page:</div>
		  <input ".$checked_blank." type='checkbox' value='1' name='wp_ticketool_blank'><br>
	       </div>
	       
		   <div style='width:100px;float:left;clear:both;'>Button title:</div>
		   <input value='".$button_title."' style='width:230px;' class='regular-text' type='text' name='wp_ticketool_button_title'>
	       
	       <div style='margin-top:10px;'>
	       <h3>Thumbnail options:</h3>
	       <div style='margin-bottom:10px;'>
	       	  <div style='width:100px;float:left;clear:both;'>Display:</div>
		  <input ".$checked_thumbnail." type='checkbox' value='1' name='wp_ticketool_thumbnail'>
	       </div>	  
	       
		  <div style='width:100px;float:left;clear:both;'>Thumbnail width:</div>
		  <input value='".get_option('wp_ticketool_thumbnail_width')."' style='width:230px;' class='regular-text' type='text' name='wp_ticketool_thumbnail_width'>
	       </div>	  
	       
	</div>
	
	<div style='clear:both'></div>
	

      <div style='margin-bottom:4px;float:left;height:150px;width:350px;'>
      
	 <h3>IFrame options:</h3>
	 <div style='margin-bottom:10px;'>
		 <div style='width:100px;float:left;clear:both;'>Display:</div>
		 <input ".$checked." type='checkbox' value='1' name='wp_ticketool_iframe'>
	 </div>
	 <div style='margin-bottom:4px;'>
		 <div style='width:100px;float:left;clear:both;'>Width:</div>
		 <input value='".get_option('wp_ticketool_iframe_width')."' style='width:230px;' class='regular-text' type='text' name='wp_ticketool_iframe_width'>
	 </div>
	 <div style='margin-bottom:4px;'>
		 <div style='width:100px;float:left;'>Height:</div>
		 <input value='".get_option('wp_ticketool_iframe_height')."' style='width:230px;' class='regular-text' type='text' name='wp_ticketool_iframe_height'>
	 </div>
	 
      </div>	
	
      <div style='margin-bottom:4px;float:left;height:150px;width:350px;'>
      
	<h3>Map options:</h3>
	<div style='margin-bottom:10px;'>
		<div style='width:100px;float:left;clear:both;'>Display:</div>
		<input ".$checked_map." type='checkbox' value='1' name='wp_ticketool_map'>
	</div>
	<div style='margin-bottom:4px;'>
		<div style='width:100px;float:left;clear:both;'>Width:</div>
		<input value='".get_option('wp_ticketool_map_width')."' style='width:230px;' class='regular-text' type='text' name='wp_ticketool_map_width'>
	</div>
	<div style='margin-bottom:4px;'>
		<div style='width:100px;float:left;clear:both;'>Height:</div>
		<input value='".get_option('wp_ticketool_map_height')."' style='width:230px;' class='regular-text' type='text' name='wp_ticketool_map_height'>
	</div>
      </div>     
      
      <div style='clear:both'></div>
      
      <div style='margin-bottom:4px;float:left;height:150px;width:350px;'>
      
	 <h3>Interface language:</h3>
	 <div style='margin-bottom:4px;'>
		 <div style='width:100px;float:left;'>Interface language:</div>
		 <select style='width:230px;' class='regular-text' type='text' name='wp_ticketool_lang'>
		 ".$lang_select."
		 </select>
	 </div>
	 
      </div>      
      <div style='clear:both'></div>
      
	<br><input class='button-primary' type='submit' value='Save'>
	</form>
	</div>";
}

function tickettool_import_list() {
	$lang = get_option('wp_ticketool_lang');
        $exp = get_option('wp_ticketool_expired');
	$key = get_option('wp_ticketool_key');
	$blank = get_option('wp_ticketool_blank');
	$wp_ticketool_thumbnail = get_option('wp_ticketool_thumbnail');
	$iframe = get_option('wp_ticketool_iframe');
	$map = get_option('wp_ticketool_map');
	$url = "https://tickettool.net/".$lang."/index/import/".$key;
	$events = file_get_contents($url);
	$eventsList = json_decode($events);
	if(count($eventsList)){
	    echo '<div id="message" class="updated fade"><p><strong>Imported</strong></p></div>';
	} else {
	    echo '<div id="message" class="updated fade"><p><strong>Import error. Please check if you have any events, if import key is valid or internet connection.</strong></p></div>';
	}
	 if(count($eventsList)){
	   foreach($eventsList as $item){
		     $expired = false;
		     if($item->time_start < time() && !$exp ) $expired = true;
		     if(!$expired){
			$posts = get_posts ("meta_key=tickettool_event_id&meta_value=" . $item->event_id );
			@$size = getimagesize($item->preview->url);
			$img = '';
			if ($size) {
				$w = $size[0];
				$h = $size[1];
				$new_w = get_option('wp_ticketool_thumbnail_width');
				$new_h = round($new_w*$h/$w);
				if($wp_ticketool_thumbnail)$img = '<img id="tickettool_event_poster" height="'.$new_h.'" width="'.$new_w.'" src="'.$item->preview->url.'">';	
			}
			$post_content = '<div id="tickettool_info"><div><h3>'.$item->hall_name.', '.$item->adres.'</h3></div>
			<p>'.$img.$item->description.'</p></div>';
			$target = '';
			if($blank)$target = 'target="_blank"';
			if( $iframe == 1 ){
			   $post_content .= '<iframe style="width:'.get_option('wp_ticketool_iframe_width').'px;height:'.get_option('wp_ticketool_iframe_height').'px;" frameborder="0" src="https://tickettool.net/'.$lang.'/index/eventpopup/'.$item->event_id.'"></iframe>';
			} else {
			   $post_content .= '<div><a id="tickettool_button" '.$target.' href="https://tickettool.net/'.$lang.'/index/eventpopup/'.$item->event_id.'">'.get_option('wp_ticketool_button_title').'</a></div>';
			}
			if( $map == 1 )$post_content .= '<div style="clear:both;"></div><iframe id="tickettool_map"  src="http://maps.google.com/maps?q='.urlencode($item->adres).'&ie=UTF8&om=1&output=embed&z=14" width="'.get_option('wp_ticketool_map_width').'" height="'.get_option('wp_ticketool_map_height').'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>';
			$date = date("d F Y H:i",$item->time_start);
			if($lang == 'ru')$date = ruMonths($date);
			$defaults = array(
			  'post_title'    => $item->name.', '.$date,
			  'post_content'  => $post_content,
			  'post_status'   => 'publish',
			  'post_type'             => 'post',
			  'post_author'           => $user_ID,
			  'ping_status'           => get_option('default_ping_status'), 
			  'post_parent'           => 0,
			  'menu_order'            => 0,
			  'to_ping'               =>  '',
			  'pinged'                => '',
			  'post_password'         => '',
			  'guid'                  => '',
			  'post_content_filtered' => '',
			  'post_excerpt'          => '',
			  'import_id'             => 0,
			  'post_thumbnail'	  => $item->preview->url,
			  'post_category' => array( get_option('wp_ticketool_cat') )
			  
			);
			if(!$posts[0]->ID){
			   $post_id = wp_insert_post( $defaults );
			   add_post_meta($post_id, 'tickettool_event_id', $item->event_id, true);
			} else {
			   $post_id = $posts[0]->ID;
			   $defaults['ID'] = $post_id;
			   wp_update_post( $defaults );
			}
			$image_url = $item->preview->url;
			
			$upload_dir = wp_upload_dir();
			@$image_data = file_get_contents($image_url);
			if (strlen($image_data) > 1) {
				$filename = basename($image_url);
				if(wp_mkdir_p($upload_dir['path']))
				    $file = $upload_dir['path'] . '/' . $filename;
				else
				    $file = $upload_dir['basedir'] . '/' . $filename;
				file_put_contents($file, $image_data);
				
				$wp_filetype = wp_check_filetype($filename, null );
				$attachment = array(
				    'post_mime_type' => $wp_filetype['type'],
				    'post_title' => sanitize_file_name($filename),
				    'post_content' => '',
				    'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
				require_once(ABSPATH . 'wp-admin/includes/image.php');
				$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
				wp_update_attachment_metadata( $attach_id, $attach_data );
				
				set_post_thumbnail( $post_id, $attach_id );				
			}
		     }   
		  
	   }
	 }
}
 function ruMonths($str) {
	$en_months = array(
			1 => 'January', 
			2 => 'February',
			3 => 'March', 
			4 => 'April',
			5 => 'May', 
			6 => 'June',
			7 => 'July', 
			8 => 'August',
			9 => 'September', 
			10 => 'October',
			11 => 'November', 
			12 => 'December');	
	$months = array(
			1 => 'Января', 
			2 => 'Февраля',
			3 => 'Марта', 
			4 => 'Апреля',
			5 => 'Мая', 
			6 => 'Июня',
			7 => 'Июля', 
			8 => 'Августа',
			9 => 'Сентября', 
			10 => 'Октября',
			11 => 'Ноября', 
			12 => 'Декабря'); 
	foreach($en_months as $num=>$month){
		$str = str_replace($month,$months[$num],$str);
	}
	return $str;

}

function tickettool_setup_menu() {
	add_options_page('TicketTool options', 'TicketTool options', 10, __FILE__, 'tickettool_options');
}

add_action('admin_menu', 'tickettool_setup_menu');

function prefix_add_my_stylesheet() {
    wp_register_style( 'tickettool-style', plugins_url('style.css', __FILE__) );
    wp_enqueue_style( 'tickettool-style' );
}

add_action( 'wp_enqueue_scripts', 'prefix_add_my_stylesheet' );
