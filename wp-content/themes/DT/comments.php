<?php

global $CORE;

function html5_comment( $comment, $depth, $args ) { global $CORE, $post;

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li'; $STAR = "";
		
		// GET COMMENT SCORE
		$score = get_post_meta($comment->comment_ID, 'score', true);
		
		// STAR RATING
		if($score != ""){
		$STAR = " <div id='wlt_star_".$comment->comment_ID."' class='wlt_starrating'></div>
				<script>jQuery(document).ready(function(){ 
				jQuery('#wlt_star_".$comment->comment_ID."').raty({
				path: '".FRAMREWORK_URI."img/rating/',
				score: ".$score.",
				size: 16,
			 
				readOnly : true,
				}); }); </script>";
		}

?> 
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>


<article id="div-comment-<?php comment_ID(); ?>" class="comment-body clearfix">
    

<div class="col-md-2 col-sm-2 col-xs-2">

	<a href="<?php echo get_author_posts_url( $comment->user_id ); ?>"><?php echo str_replace("avatar ","avatar img-responsive ",get_avatar( $comment ) ); ?></a>
    
</div>


<div class="col-md-10 col-sm-10 col-xs-10">
	
    <?php echo $STAR; ?>
    
    <?php printf( __( '%s <span class="says">'.$CORE->_e(array('author','26a')).' '.hook_date( $comment->comment_date ).':</span>' ), sprintf( '<b class="fn">%s</b>', get_comment_author_link() ) ); ?>
    
    <hr />
    
	<?php comment_text(); ?>
    
    <?php comment_reply_link( $args, $comment, $post ); ?> 

</div>
 

</article><!-- .comment-body -->
<?php
	}


if ( post_password_required() ) {
	return;
}
?>

<?php if ( have_comments() ) : ?>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'premiumpress' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'premiumpress' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'premiumpress' ) ); ?></div>
	</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<ol class="commentlist">
		<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 34,
				'format'     => 'html5',
				'callback' => 'html5_comment'
			) );
		?>
	</ol><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'premiumpress' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'premiumpress' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'premiumpress' ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>

	<?php if ( ! comments_open() ) : ?>
	<p class="no-comments"><?php _e( 'Comments are closed.' ); ?></p>
	<?php endif; ?>

<?php endif; // have_comments() ?>

<?php 



$fields =  array(

  'author' =>
    '<p>  ' .
  
    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' placeholder="' . __( 'Name', 'domainreference' ) . '" class="form-control" /></p>',

  'email' =>
    '<p>  ' .

    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' placeholder="' . __( 'Email', 'domainreference' ) . '" class="form-control" /></p>',

  'url' =>
    '<p>' .
    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
    '" size="30" placeholder="' . __( 'Website', 'domainreference' ) . '" class="form-control" /></p>',
  
	
);
 

$comments_args = array(
        // change the title of send button 
        'label_submit'=>'Send',
		 'comment_notes_before' => '',
        // change the title of the reply section
        'title_reply'=> $CORE->_e(array('comment','8'))." <hr />",
        // remove "Text or HTML to be displayed after the set of comment fields"
        'comment_notes_after' => '',
        // redefine your own textarea (the comment body)
        'comment_field' => '<p><textarea id="comment" name="comment" aria-required="true" placeholder="' . _x( 'Comment', 'noun' ) . '" class="form-control"></textarea></p>',
		'logged_in_as' => '',
		// FIELDS
 		'fields' => apply_filters( 'comment_form_default_fields', $fields ),
);
 
?>

<div class='text-center'><a class='btn btn-lg btn-success' href="javascript:void(0);" onclick="jQuery('#wlt_comments_form').show(); jQuery('#wlt_comments_form_lc').hide();" id="wlt_comments_form_lc"><?php echo $CORE->_e(array('single','46')); ?></a></div>
<div style="display:none;" id="wlt_comments_form">
<a class='badge pull-right' href="javascript:void(0);" onclick="jQuery('#wlt_comments_form').hide(); jQuery('#wlt_comments_form_lc').show();"><?php echo $CORE->_e(array('single','14')); ?></a>
<?php comment_form($comments_args); ?>
</div>