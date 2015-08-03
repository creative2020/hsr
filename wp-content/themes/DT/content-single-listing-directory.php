<?php
/* 
* Theme: PREMIUMPRESS CORE FRAMEWORK FILE
* Url: www.premiumpress.com
* Author: Mark Fail
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $post, $CORE, $userdata; $canShowMap = false; $canShowLink = false;

// CAN WE DISPLAY THE GOOGLE MAP BOX ?
if( get_post_meta($post->ID,'showgooglemap',true) == "yes"){
	$canShowMap = true;
}

// CAN WE DISPLAY LINK BOX
if( get_post_meta($post->ID,'url',true) != ""){
	$canShowLink = true;
}

ob_start();
?>



<a name="toplisting"></a>

<div class="panel panel-default">

	<div class="row"> 
    
        <div class="col-md-8" id="imagesblock">
        
            <div class="inner">
            
                [IMAGES]
            
            </div>
        
        </div>
        
         <div class="col-md-4" id="actionblock">
            
            <div class="inner">
            
                <h1>[TITLE]</h1>
                
               <div class="ratingbit"> 
               
               <span class="pull-right">[hits] <?php echo $CORE->_e(array('single','19')); ?></span>
               
               [RATING] [FEEDBACK] </div>        
                 
            
                <div class="small_desc"> [EXCERPT size=320] <a href="#readmore"><?php echo strtolower($CORE->_e(array('button','40'))); ?></a> </div>
          
                <hr /> 
                
                
                <?php if($canShowLink){ ?>
                
                <a href="<?php echo home_url(); ?>/out/<?php echo $post->ID; ?>/url/" rel="noindex" class="btn btn-primary" target="_blank"><?php echo $CORE->_e(array('button','12')); ?></a>
                
                <?php } ?>
                 
                [FAVS]                   
                 
                [CONTACT style=1]
            
           </div>
            
       </div>
    
    </div> 

</div>


<?php if($canShowMap){ ?>

<div class="panel panel-default">
[GOOGLEMAP]
</div>

<?php } ?>



<div class="row"> 
    
        <div class="col-md-8">
 
        
        <ul class="nav nav-tabs" id="Tabs">
        
        <li class="active"><a href="#t1" data-toggle="tab">{Description}</a></li>
        
        <li><a href="#t2" data-toggle="tab">{Details}</a></li>
        
        <li><a href="#t4" data-toggle="tab" > <?php echo $CORE->_e(array('single','37')); ?> </a></li>
        
        </ul>
 
       <div class="tab-content">
        
        <div class="tab-pane active" id="t1"><a name="readmore"></a> [TOOLBOX]   [CONTENT] </div>
        
        <div class="tab-pane" id="t2">[FIELDS hide="map"]</div>
        
        <div class="tab-pane fade" id="t4">[COMMENTS tab=0]</div>
        
        </div>
        
        </div>
        
        <div class="col-md-4">        
        
        <?php dynamic_sidebar('Listing Page'); ?>
        
        </div>
        
</div>

<?php $SavedContent = ob_get_clean(); 
echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_content_single_listing($SavedContent)));

?>