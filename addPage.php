<?php 
/*
Plugin Name: Add Page
Description: Plugin for creating a wordpress page
Version: 1.0
Author: Testing Developer
*/
 require_once ABSPATH . "wp-includes/functions.php";
 include_once  ABSPATH . "wp-config.php";
 include_once  ABSPATH . "wp-load.php";
 include_once  ABSPATH . "wp-includes/wp-db.php";
  
 /*-----------Add a menu to the admin dashboard-----------------------------*/
 add_action('admin_menu', 'add_the_menu');
 function add_the_menu(){
    add_menu_page( 'addPage', 'addPage', '10', 'add-page', 'addPage_form' );
 }
/*---------Create a form to save page to the datapase----------------------*/
 function addPage_form(){
      echo '<style>';
	  echo 'label{width: 150px;float: left;line-height: 35px;}';
	  echo 'input[type="text"],input[type="url"]{width: 400px;}';
	  echo 'textarea{width: 400px; height:120px;}';
	  echo '</style>';
	  echo '<script>';
		  echo 'function checkForm(){ 
		         if(document.getElementById("url").value==""){
				   alert("Please fill the URL."); 
				   document.getElementById("url").focus(); 
				   return false;
				  } 
				  if(document.getElementById("title").value==""){
				    alert("Please fill the title."); 
					document.getElementById("title").focus(); 
					return false;
				  }
				  if(document.getElementById("descr").value==""){
				    alert("Please fill the description."); 
					document.getElementById("descr").focus(); 
					return false;
				  }
				 }';
		  echo '</script>';
      if(isset($_POST['save'])){
	   $msg = '';
	   $page = array(
          'comment_status' => 'closed',
          'ping_status' =>  'closed',
          'post_author' => 1,
          'post_name' => sanitize_title_with_dashes($_POST['title'],'','save'),
		  'post_content' => $_POST['descr'],
          'post_status' => 'publish',
          'post_title' => $_POST['title'],
          'post_type' => 'page',
       );  
	     $post_id = wp_insert_post( $page, false );//create a page
		 update_post_meta( $post_id, 'url', $_POST['url'] );//save url ot wp-meta table
		 $msg = 'Page has been saved successfully.....';
	  }
     echo '<div class="wrap">';
	 echo '<h1>Provide a page title to save directly to the database</h1><br/>';
	   if($msg!=''){
		    echo '<div><label>&nbsp;</label><b class="alert alert-primary">'.$msg.'</b></div><br/>';
		  }
	  echo '<form action="" method="post" onsubmit="return checkForm()">';
                 echo '<div><label>URL :</label> <input type="url" name="url" id="url" /></div><br/>';
				 echo '<div><label>Title :</label> <input type="text" name="title" id="title" /></div><br/>'; 
			echo '<div><label>Description :</label> <textarea name="descr" id="descr">Dummy content here</textarea></div><br/>'; 
	echo '<div><label>&nbsp;</label><input type="submit" class="button button-primary button-large" name="save" value="SAVE" /></div>'; 			
     echo '</form>';
	echo '</div>';
 }