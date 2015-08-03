<?php
/*
| ----------------------------------------------------
| File        : class-widgets.php
| Project     : Special Recent Posts PRO Edition plugin for Wordpress
| Version     : 2.5.2
| Description : This is the widget main class.
| Author      : Luca Grandicelli
| Author URL  : http://www.lucagrandicelli.com
| Plugin URL  : http://www.specialrecentposts.com
| Copyright (C) 2011-2012 Luca Grandicelli
| ----------------------------------------------------
*/

class WDG_SpecialRecentPostsPro extends WP_Widget {

	// Declaring global plugin values.
	private $plugin_args;

/*
| ---------------------------------------------
| CLASS CONSTRUCTOR & DECONSTRUCTOR
| ---------------------------------------------
*/
	// Class Constructor.
	// In this section we define the widget global values.
	function WDG_SpecialRecentPostsPro() {
	
		// Setting up widget options.
        $widget_ops = array (
            'classname'   => 'widget_specialrecentpostsPro',
            'description' => __('The Special Recent Posts PRO Edition widget. Drag to configure.', SRP_TRANSLATION_ID)
        );
		
        // Assigning widget options.
		$this->WP_Widget('WDG_SpecialRecentPostsPro', 'Special Recent Posts PRO', $widget_ops);
		
		// Assigning global plugin option values to local variable.
		$this->plugin_args = get_option('srp_plugin_options');
	}

/*
| ---------------------------------------------
| WIDGET FORM DISPLAY METHOD
| ---------------------------------------------
*/
	// Main form widget method.
	function form($instance) {
	
		// Outputs the options form on widget panel.
		$this->buildWidgetForm($instance);
	}

/*
| ---------------------------------------------
| WIDGET UPDATE & MAIN METHODS
| ---------------------------------------------
*/
	// Main method for widget update process.
	function update($new_instance, $old_instance) {
	
		// Declaring global plugin values.
		global $srp_default_widget_values;
		
		// Processes widget options to be saved.
		$instance = SpecialRecentPostsPro::srp_version_map_check($old_instance);
		
		// Looping through the entire list of plugin options.
		foreach($srp_default_widget_values as $k => $v) {
			
			// Switching through each option.
			switch($k) {
			
				case "post_title_above_thumb":
				case "post_random":
				case "post_include_sub":
				case "post_link_excerpt":
				case "author_archive_link":
				case "post_noimage_skip":
				case "thumbnail_link":
				case "category_title":
				case "post_title_nolink":
				case "post_current_hide":
				case "post_date":
				case "post_author":
				case "post_category":
				case "post_author_url":
				case "post_category_link":
				case "post_tags":
				case "author_autofilter":
				case "widget_title_hide":
				case "nofollow_links":
				case "targetblank_links":
				case "string_break_link":
				case "date_timeago":
				case "vf_home":
				case "vf_allposts":
				case "vf_allpages":
				case "vf_everything":
				case "vf_allcategories":
				case "vf_allarchives":
				case "category_autofilter":
				case "category_autofilter_single":
				case "category_include_exclusive":
					
					// Fix all the NULL values coming from unchecked checkboxes.
					$instance[$k] = (!isset($new_instance[$k])) ? "no" : $new_instance[$k];
				break;
				
				case "thumbnail_width":
				case "thumbnail_height":
				
					// Checking if the new value is numeric. Then assign it.
					if (is_numeric($new_instance[$k])) $instance[$k] = trim($new_instance[$k]);
				break;
				
				case "post_limit":
				case "post_content_length":
				case "post_title_length":
				case "layout_num_cols":
				
					// Checking if the new value is numeric and is not zero. Then assign it.
					if ( (is_numeric($new_instance[$k])) && ($new_instance[$k] != 0) ) $instance[$k] = trim($new_instance[$k]);
				break;
				
				case "post_offset":
					
					// Checking if the new value is numeric and is > of zero. Then assign it.
					$instance[$k] = ( (is_numeric($new_instance[$k])) && ($new_instance[$k] > 0) ) ? trim($new_instance[$k]) : 0;
				break;
				
				case "shortcode_generator_area":
				case "phpcode_generator_area":
				
					// Delete these values because they could get the whole plugin into trouble.
					unset($new_instance[$k]);
				break;

				default:
				
					// Default behaviour: for all the other options, assign the new value.
					$instance[$k] = $new_instance[$k];
				break;
			}
		}

		// Return new widget instance.
		return $instance;
	}
	
	/*
	| ---------------------------------------------
	| Main widget method. Main logic lies here.
	| ---------------------------------------------
	*/
	function widget($args, $instance) {
	
		// Checking Visualization filter.
		if (SpecialRecentPostsPro::visualizationCheck($instance, 'widget')) {
		
			// Extracting arguments.
			extract($args, EXTR_SKIP);
			
			// Printing pre-widget stuff.
			echo $before_widget;
			
			// Creating an instance of Special Recent Posts Class.
			$srp = new SpecialRecentPostsPro($instance, $this->id);
			
			// Displaying posts.
			if (is_object($srp)) $srp->displayPosts(true, 'print');
			
			// Printing after widget stuff.
			echo $after_widget;
		}
	}
	
	/*
	| --------------------------------------------------
	| This method generates the shortcode and PHP code
	| from the current widget values.
	| --------------------------------------------------
	*/
	function srp_generate_code($instance, $code_mode) {
	
		// Switching between "shortcode" or "php code".
		switch($code_mode) {
		
			case "shortcode":
			
				// Defining global widget values.
				global $srp_default_widget_values;
				
				// Opening shortcode.
				$shortcode_code = "[srp";				
				
				// Looping through list of available widget values.
				foreach($instance as $key=>$value) {
				
					// Checking if the current set value is different than the default one.
					if (($srp_default_widget_values[$key] != $value)) {
					
						// If it's so, put the new key=>value in the shortcode.
						$shortcode_code .= " " . $key . "=\"" . $value . "\"";
					}
				}
				
				// Closing shortcode.
				$shortcode_code .= "]";
				
				// Return the shortcode.
				return $shortcode_code;
			break;
			
			case "php":
			
				// Defining global widget values.
				global $srp_default_widget_values;
				
				// Opening PHP code.
				$phpcode_code = "&lt;?php\n";
				
				// Building PHP $args.
				$phpcode_code .= "\$args = array(\n";		
				
				// Looping through list of available widget values.
				foreach($instance as $key=>$value) {
				
					// Checking if the current set value is different than the default one.
					if (($srp_default_widget_values[$key] != $value)) {
					
						// If it's so, put the new key=>value in the PHP code.
						$phpcode_code .= "\"" . $key . "\" => \"" . $value . "\",";
					}
				}
				
				// Right trimming the last comma from the $args list.
				$phpcode_code = rtrim($phpcode_code, ',');
				
				// Closing PHP code.
				$phpcode_code .= ");\n";
				$phpcode_code .= "special_recent_posts(\$args);\n";
				$phpcode_code .= "?&gt;\n";
				
				// Return PHP code.
				return $phpcode_code;
			break;
		}
	}
	
	/*
	| --------------------------------------------------
	| This method builds the widget admin form.
	| --------------------------------------------------
	*/
	function buildWidgetForm($instance) {
	
		// Loading default widget values.
		global $srp_default_widget_values;
		
		// Loading default plugin settings.
		$plugin_args = get_option('srp_plugin_options');
		
		// Merging default values with instance array, in case this is empty.
		$instance = wp_parse_args( (array) SpecialRecentPostsPro::srp_version_map_check($instance), $srp_default_widget_values);
?>

	<!-- BOF Widget accordion -->
	<img class="srp_accordion_widget_header_image" src="<?php echo SRP_PLUGIN_URL . SRP_WIDGET_HEADER; ?>" alt="Special Recent Posts PRO Edition v<?php echo SRP_PLUGIN_VERSION;?>"/>
	<dl class="srp-wdg-accordion">
	
		<!-- BOF Basic options -->
		<dt class="srp-widget-optionlist-dt-basic">
			<a class="srp-wdg-accordion-item accordion-active-link" href="#1" title="<?php _e('Basic Options', SRP_TRANSLATION_ID); ?>" name="1"><?php _e('Basic Options', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-basic">
			<ul class="srp-widget-optionlist-basic srp-widget-optionlist">

				<!-- BOF Widget title Option. -->
				<li>
					<label for="<?php echo $this->get_field_id('widget_title'); ?>" class="srp-widget-label"><?php _e('Widget title', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter the text for the main widget title.',SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('widget_title'); ?>" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo htmlspecialchars($instance["widget_title"], ENT_QUOTES); ?>" size="30" class="fullwidth" />
				</li>
				<!-- EOF Widget title Option. -->
				
				<!-- BOF Widget title link option. -->
				<li>
					<label for="<?php echo $this->get_field_id('widget_title_link'); ?>" class="srp-widget-label"><?php _e('Widget title URL', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('If you want to link the widget title to a custom URL, please type it here. Leave blank for no linking.',SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('widget_title_link'); ?>" name="<?php echo $this->get_field_name('widget_title_link'); ?>" value="<?php echo htmlspecialchars($instance["widget_title_link"], ENT_QUOTES); ?>" size="30" class="fullwidth" />
				</li>
				<!-- EOF Widget title link option. -->

				<!-- BOF Post type display. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_type'); ?>" class="srp-widget-label"><?php _e('Display posts or pages?', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select whether to display posts or pages.',SRP_TRANSLATION_ID); ?></small><br />
					<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" class="srp-widget-select">
						<option value="post" <?php selected($instance["post_type"], 'post'); ?>><?php _e('Posts', SRP_TRANSLATION_ID); ?></option>
						<option value="page" <?php selected($instance["post_type"], 'page'); ?>><?php _e('Pages', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Post type display. -->
				
				<!-- BOF Max number of posts option. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_limit'); ?>" class="srp-widget-label"><?php _e('Max number of posts/pages to display?', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter the maximum number of posts/pages to display.', SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_limit'); ?>" name="<?php echo $this->get_field_name('post_limit'); ?>" value="<?php echo stripslashes($instance['post_limit']); ?>" size="5" />
				</li>
				<!-- EOF Max number of posts option. -->
				
				<!-- BOF Widget CSS ID -->
				<li>
					<label for="<?php echo $this->get_field_id('widget_css_id'); ?>" class="srp-widget-label"><?php _e('Widget CSS ID', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter a unique CSS ID selector for this widget instance.',SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('widget_css_id'); ?>" name="<?php echo $this->get_field_name('widget_css_id'); ?>" value="<?php echo stripslashes($instance['widget_css_id']); ?>" size="30" class="fullwidth"/>
				</li>
				<!-- EOF Widget CSS ID -->
				
				<!-- BOF Widget additional classes -->
				<li>
					<label for="<?php echo $this->get_field_id('widget_additional_classes'); ?>" class="srp-widget-label"><?php _e('Additional CSS classes', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter a space separated list of additional css classes for this widget instance.',SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('widget_additional_classes'); ?>" name="<?php echo $this->get_field_name('widget_additional_classes'); ?>" value="<?php echo stripslashes($instance['widget_additional_classes']); ?>" size="30" class="fullwidth"/>
				</li>
				<!-- EOF Widget additional classes -->
				
				<!-- BOF Visualization filter -->
				<li>
					<label for="<?php echo $this->get_field_id('visualization_filter'); ?>" class="srp-widget-label"><?php _e('Visualization filter', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Choose where this widget should appear:',SRP_TRANSLATION_ID); ?></small><br />
					
					<input type="checkbox" id="<?php echo $this->get_field_id('vf_everything'); ?>" name="<?php echo $this->get_field_name('vf_everything'); ?>" value="yes" <?php checked($instance["vf_everything"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('vf_everything'); ?>" class="srp-widget-label-inline"><?php _e('Everywhere', SRP_TRANSLATION_ID); ?></label><br />
					
					<input type="checkbox" id="<?php echo $this->get_field_id('vf_home'); ?>" name="<?php echo $this->get_field_name('vf_home'); ?>" value="yes" <?php checked($instance["vf_home"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('vf_home'); ?>" class="srp-widget-label-inline"><?php _e('Home page', SRP_TRANSLATION_ID); ?></label><br />
					
					<input type="checkbox" id="<?php echo $this->get_field_id('vf_allposts'); ?>" name="<?php echo $this->get_field_name('vf_allposts'); ?>" value="yes" <?php checked($instance["vf_allposts"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('vf_allposts'); ?>" class="srp-widget-label-inline"><?php _e('All posts', SRP_TRANSLATION_ID); ?></label><br />
					
					<input type="checkbox" id="<?php echo $this->get_field_id('vf_allpages'); ?>" name="<?php echo $this->get_field_name('vf_allpages'); ?>" value="yes" <?php checked($instance["vf_allpages"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('vf_allpages'); ?>" class="srp-widget-label-inline"><?php _e('All pages', SRP_TRANSLATION_ID); ?></label><br />
					
					<input type="checkbox" id="<?php echo $this->get_field_id('vf_allcategories'); ?>" name="<?php echo $this->get_field_name('vf_allcategories'); ?>" value="yes" <?php checked($instance["vf_allcategories"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('vf_allcategories'); ?>" class="srp-widget-label-inline"><?php _e('All categories', SRP_TRANSLATION_ID); ?></label><br />
					
					<input type="checkbox" id="<?php echo $this->get_field_id('vf_allarchives'); ?>" name="<?php echo $this->get_field_name('vf_allarchives'); ?>" value="yes" <?php checked($instance["vf_allarchives"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('vf_allarchives'); ?>" class="srp-widget-label-inline"><?php _e('All archives', SRP_TRANSLATION_ID); ?></label><br />
				</li>
				<!-- EOF Visualization filter -->
			</ul>
		</dd>
		<!-- EOF Basic options -->
		
		<!-- BOF Thumbnails options -->
		<dt class="srp-widget-optionlist-dt-thumbnails">
			<a class="srp-wdg-accordion-item" href="#2" title="<?php _e('Thumbnails Options', SRP_TRANSLATION_ID); ?>" name="2"><?php _e('Thumbnails Options', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-thumbnails">
			<ul class="srp-widget-optionlist-thumbnails srp-widget-optionlist">
				
				<!-- BOF Thumbnail option. -->
				<li>
					<label for="<?php echo $this->get_field_id('display_thumbnail'); ?>" class="srp-widget-label"><?php _e('Display thumbnails?', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select if thumbnails should be displayed or not.', SRP_TRANSLATION_ID); ?></small><br />
					<select id="<?php echo $this->get_field_id('display_thumbnail'); ?>" name="<?php echo $this->get_field_name('display_thumbnail'); ?>" class="srp-widget-select">
						<option value="yes" <?php selected($instance["display_thumbnail"], 'yes'); ?>><?php _e('Yes', SRP_TRANSLATION_ID); ?></option>
						<option value="no" <?php selected($instance["display_thumbnail"], 'no'); ?>><?php _e('No', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Thumbnail option. -->

				<!-- BOF Thumbnail type. -->
				<li>
					<label for="<?php echo $this->get_field_id('thumbnail_type'); ?>" class="srp-widget-label"><?php _e('Select thumbnail type', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select which kind of thumbnail should be displayed:',SRP_TRANSLATION_ID); ?></small><br />
					<select id="<?php echo $this->get_field_id('thumbnail_type'); ?>" name="<?php echo $this->get_field_name('thumbnail_type'); ?>" class="srp-widget-select">
						<option value="thumb-post" <?php selected($instance["thumbnail_type"], 'thumb-post'); ?>><?php _e('Post thumbnail (default)', SRP_TRANSLATION_ID); ?></option>
						<option value="thumb-author" <?php selected($instance["thumbnail_type"], 'thumb-author'); ?>><?php _e('Author avatar', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Thumbnail type. -->

				<!-- BOF Author post archive link. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('author_archive_link'); ?>" name="<?php echo $this->get_field_name('author_archive_link'); ?>" value="yes" <?php checked($instance["author_archive_link"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('author_archive_link'); ?>" class="srp-widget-label-inline"><?php _e('Link author avatar to the author post archive?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to link the author avatar image to the relative post archive.',SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Author post archive link. -->
				
				<!-- BOF Thumbnail width. -->
				<li>
					<label for="<?php echo $this->get_field_id('thumbnail_width'); ?>" class="srp-widget-label"><?php _e('Thumbnail width', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter the thumbnail width in pixel:',SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('thumbnail_width'); ?>" name="<?php echo $this->get_field_name('thumbnail_width'); ?>" value="<?php echo htmlspecialchars($instance["thumbnail_width"], ENT_QUOTES); ?>" size="8" />px
				</li>
				<!-- EOF Thumbnail width. -->
				
				<!-- BOF Thumbnail height. -->
				<li>
					<label for="<?php echo $this->get_field_id('thumbnail_height'); ?>" class="srp-widget-label"><?php _e('Thumbnail height', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter the thumbnail height in pixel:',SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('thumbnail_height'); ?>" name="<?php echo $this->get_field_name('thumbnail_height'); ?>" value="<?php echo htmlspecialchars($instance["thumbnail_height"], ENT_QUOTES); ?>" size="8" />px
				</li>
				<!-- EOF Thumbnail height. -->
				
				<!--BOF Thumbnail link mode -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('thumbnail_link'); ?>" name="<?php echo $this->get_field_name('thumbnail_link'); ?>" value="yes" <?php checked($instance["thumbnail_link"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('thumbnail_link'); ?>" class="srp-widget-label-inline"><?php _e('Link thumbnail to post', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to link the thumbnail to the related post/page.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!--EOF Thumbnail link mode -->
				
				<!-- BOF Thumbnail from custom field. -->
				<li>
					<label for="<?php echo $this->get_field_id('thumbnail_custom_field'); ?>" class="srp-widget-label"><?php _e('Thumbnail custom field', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('If you\'re using a custom field to specify the thumbnail image source, put its key name here.<br />ATTENTION: Provide an already resized image, because SRP won\'t do any resize at all on it.',SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('thumbnail_custom_field'); ?>" name="<?php echo $this->get_field_name('thumbnail_custom_field'); ?>" value="<?php echo htmlspecialchars($instance["thumbnail_custom_field"], ENT_QUOTES); ?>" size="30" class="fullwidth" />
				</li>
				<!-- EOF Thumbnail from custom field. -->
				
				<!-- BOF Thumbnail display mode. -->
				<li>
					<label for="<?php echo $this->get_field_id('thumbnail_rotation'); ?>" class="srp-widget-label"><?php _e('Rotate thumbnail?', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select the thumbnails rotation mode:',SRP_TRANSLATION_ID); ?></small>
					<select id="<?php echo $this->get_field_id('thumbnail_rotation'); ?>" name="<?php echo $this->get_field_name('thumbnail_rotation'); ?>" class="srp-widget-select">
						<option value="no" <?php selected($instance["thumbnail_rotation"], 'adaptive'); ?>><?php _e('No rotation (default)', SRP_TRANSLATION_ID); ?></option>
						<option value="rotate-cw" <?php selected($instance["thumbnail_rotation"], 'rotate-cw'); ?>><?php _e('Rotate CW', SRP_TRANSLATION_ID); ?></option>
						<option value="rotate-ccw" <?php selected($instance["thumbnail_rotation"], 'rotate-ccw'); ?>><?php _e('Rotate CCW', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Thumbnail display mode. -->

				<!-- BOF Thumbnail index -->
				<li>
					<label for="<?php echo $this->get_field_id('post_thumbnail_index_basic'); ?>" class="srp-widget-label"><?php _e('Select thumbnail index', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select the index of which image should be picked up within the post content when no featured image is available.', SRP_TRANSLATION_ID); ?></small>
					<select id="<?php echo $this->get_field_id('post_thumbnail_index_basic'); ?>" name="<?php echo $this->get_field_name('post_thumbnail_index_basic'); ?>" class="srp-widget-select">
						<option value="first" <?php selected($instance["post_thumbnail_index_basic"], 'first'); ?>><?php _e('First image (default)', SRP_TRANSLATION_ID); ?></option>
						<option value="last" <?php selected($instance["post_thumbnail_index_basic"], 'last'); ?>><?php _e('Last image', SRP_TRANSLATION_ID); ?></option>
						<option value="random" <?php selected($instance["post_thumbnail_index_basic"], 'random'); ?>><?php _e('Random image', SRP_TRANSLATION_ID); ?></option>
					</select><br />
					<small><?php _e('Or enter a specific index number. (This will override the previous settings - Leave blank for no specific indexing).'); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_thumbnail_index_adv'); ?>" name="<?php echo $this->get_field_name('post_thumbnail_index_adv'); ?>" value="<?php echo htmlspecialchars($instance["post_thumbnail_index_adv"], ENT_QUOTES); ?>" size="8" />
				</li>
				<!-- EOF Thumbnail index -->
			</ul>
		</dd>
		<!-- EOF Thumbnails options -->
		
		<!-- BOF Post options -->
		<dt class="srp-widget-optionlist-dt-posts">
			<a class="srp-wdg-accordion-item" href="#3" title="<?php _e('Posts Options', SRP_TRANSLATION_ID); ?>" name="3"><?php _e('Posts Options', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-posts">
			<ul class="srp-widget-optionlist-posts srp-widget-optionlist">
			
				<!-- BOF Title max text size. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_title_length'); ?>" class="srp-widget-label"><?php _e('Cut title text after:', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select after how many characters or words every post title should be cut:',SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_title_length'); ?>" name="<?php echo $this->get_field_name('post_title_length'); ?>" value="<?php echo htmlspecialchars($instance["post_title_length"], ENT_QUOTES); ?>" size="4" />
					<select id="<?php echo $this->get_field_id('post_title_length_mode'); ?>" name="<?php echo $this->get_field_name('post_title_length_mode'); ?>" class="srp-widget-select">
						<option value="words" <?php selected($instance["post_title_length_mode"], 'words'); ?>><?php _e('Words', SRP_TRANSLATION_ID); ?></option>
						<option value="chars" <?php selected($instance["post_title_length_mode"], 'chars'); ?>><?php _e('Characters', SRP_TRANSLATION_ID); ?></option>
						<option value="fulltitle" <?php selected($instance["post_title_length_mode"], 'fulltitle'); ?>><?php _e('Use full title (no cut)', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Title max text size. -->
				
				<!-- BOF Post content type. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_content_type'); ?>" class="srp-widget-label"><?php _e('Select post content type', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select if you wish to display the normal post content or the post excerpt:',SRP_TRANSLATION_ID); ?></small><br />
					<select id="<?php echo $this->get_field_id('post_content_type'); ?>" name="<?php echo $this->get_field_name('post_content_type'); ?>" class="srp-widget-select">
						<option value="content" <?php selected($instance["post_content_type"], 'content'); ?>><?php _e('Post content', SRP_TRANSLATION_ID); ?></option>
						<option value="excerpt" <?php selected($instance["post_content_type"], 'excerpt'); ?>><?php _e('Post excerpt', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Post content type. -->
				
				<!-- BOF Post excerpt max text size. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_content_length'); ?>" class="srp-widget-label"><?php _e('Cut post content after:', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select after how many characters or words every post content should be cut:',SRP_TRANSLATION_ID); ?></small><br />					
					<input type="text" id="<?php echo $this->get_field_id('post_content_length'); ?>" name="<?php echo $this->get_field_name('post_content_length'); ?>" value="<?php echo htmlspecialchars($instance["post_content_length"], ENT_QUOTES); ?>" size="4" />
					<select id="<?php echo $this->get_field_id('post_content_length_mode'); ?>" name="<?php echo $this->get_field_name('post_content_length_mode'); ?>" class="srp-widget-select">
						<option value="words" <?php selected($instance["post_content_length_mode"], 'words'); ?>><?php _e('Words', SRP_TRANSLATION_ID); ?></option>
						<option value="chars" <?php selected($instance["post_content_length_mode"], 'chars'); ?>><?php _e('Characters', SRP_TRANSLATION_ID); ?></option>
						<option value="fullcontent" <?php selected($instance["post_content_length_mode"], 'fullcontent'); ?>><?php _e('Use the full content', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Post excerpt max text size. -->
				
				<!-- BOF Post order display option. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_order'); ?>" class="srp-widget-label"><?php _e('Select posts/pages order:', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select the posts/pages display order:',SRP_TRANSLATION_ID); ?></small><br />
					<select id="<?php echo $this->get_field_id('post_order'); ?>" name="<?php echo $this->get_field_name('post_order'); ?>" class="srp-widget-select">
						<option value="DESC" <?php selected($instance["post_order"], 'DESC'); ?>><?php _e('Latest first (DESC)', SRP_TRANSLATION_ID); ?></option>
						<option value="ASC" <?php selected($instance["post_order"], 'ASC'); ?>><?php _e('Oldest first (ASC)', SRP_TRANSLATION_ID); ?></option>
						<option value="alphab" <?php selected($instance["post_order"], 'alphab'); ?>><?php _e('Sort alphabetically', SRP_TRANSLATION_ID); ?></option>
						<option value="modified" <?php selected($instance["post_order"], 'modified'); ?>><?php _e('Last updated first', SRP_TRANSLATION_ID); ?></option>
						<option value="comment_count" <?php selected($instance["post_order"], 'comment_count'); ?>><?php _e('Most commented first', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Post order display option. -->
				
				<!-- BOF Post title link option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('post_title_nolink'); ?>" name="<?php echo $this->get_field_name('post_title_nolink'); ?>" value="yes" <?php checked($instance["post_title_nolink"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('post_title_nolink'); ?>" class="srp-widget-label-inline"><?php _e('Disable links in post titles', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to unlink the post titles from the related post/page.',SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Post title link option. -->
				
				<!-- BOF Random posts option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('post_random'); ?>" name="<?php echo $this->get_field_name('post_random'); ?>" value="yes" <?php checked($instance["post_random"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('post_random'); ?>" class="srp-widget-label-inline"><?php _e('Enable random mode', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to randomize the posts order.',SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Random posts option. -->
				
				<!-- BOF Post no image skip option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('post_noimage_skip'); ?>" name="<?php echo $this->get_field_name('post_noimage_skip'); ?>" value="yes" <?php checked($instance["post_noimage_skip"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('post_noimage_skip'); ?>" class="srp-widget-label-inline"><?php _e('Skip posts without images', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to skip the posts without images.',SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Post no image skip option. -->
				
				<!-- BOF Linked post excerpt option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('post_link_excerpt'); ?>" name="<?php echo $this->get_field_name('post_link_excerpt'); ?>" value="yes" <?php checked($instance["post_link_excerpt"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('post_link_excerpt'); ?>" class="srp-widget-label-inline"><?php _e('Link post content', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to link the entire post content to the related post/page.',SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Linked post excerpt option. -->
				
				<!-- BOF Display content option. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_content_mode'); ?>" class="srp-widget-label"><?php _e('Content display mode', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select the content type that should appear on each post:',SRP_TRANSLATION_ID); ?></small><br />
					<select id="<?php echo $this->get_field_id('post_content_mode'); ?>" name="<?php echo $this->get_field_name('post_content_mode'); ?>" class="srp-widget-select">
						<option value="thumbonly" <?php selected($instance["post_content_mode"], 'thumbonly'); ?>><?php _e('Thumbnail only', SRP_TRANSLATION_ID); ?></option>
						<option value="titleonly" <?php selected($instance["post_content_mode"], 'titleonly'); ?>><?php _e('Title + Thumbnail', SRP_TRANSLATION_ID); ?></option>
						<option value="titleexcerpt" <?php selected($instance["post_content_mode"], 'titleexcerpt'); ?>><?php _e('Title + Thumbnail + Post text', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Display content option. -->
			</ul>
		</dd>
		<!-- EOF Post options -->
		
		<!-- BOF Advanced post options 1 -->
		<dt class="srp-widget-optionlist-dt-advposts">
			<a class="srp-wdg-accordion-item" href="#4" title="<?php _e('Advanced Posts Options 1', SRP_TRANSLATION_ID); ?>" name="4"><?php _e('Advanced Posts Options 1', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-advposts">
			<ul class="srp-widget-optionlist-advposts srp-widget-optionlist">
				
				<!-- BOF No posts message. -->
				<li>
					<label for="<?php echo $this->get_field_id('noposts_text'); ?>" class="srp-widget-label"><?php _e('No posts default text', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter the default text to display when there are no posts available:',SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('noposts_text'); ?>" name="<?php echo $this->get_field_name('noposts_text'); ?>" value="<?php echo stripslashes($instance['noposts_text']); ?>" size="30" class="fullwidth"/>
				</li>
				<!-- EOF No posts message. -->
				
				<!-- BOF Current post hide option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('post_current_hide'); ?>" name="<?php echo $this->get_field_name('post_current_hide'); ?>" value="yes" <?php checked($instance["post_current_hide"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('post_current_hide'); ?>" class="srp-widget-label-inline"><?php _e('Hide current post from list?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to hide the current viewed post/page.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Current post hide option. -->
				
				<!-- BOF Posts offset option.. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_offset'); ?>" class="srp-widget-label"><?php _e('Post offset', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter the number of post/pages to skip from the beginning:', SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_offset'); ?>" name="<?php echo $this->get_field_name('post_offset'); ?>" value="<?php echo stripslashes($instance['post_offset']); ?>" size="5" />
				</li>
				<!-- EOF Posts offset option.. -->
				
				<!-- BOF Title string break option. -->
				<li>
					<label for="<?php echo $this->get_field_id('title_string_break'); ?>" class="srp-widget-label"><?php _e('Title string break', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter the text to be displayed as string break just after the end of the post/page title:', SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('title_string_break'); ?>" name="<?php echo $this->get_field_name('title_string_break'); ?>" value="<?php echo stripslashes($instance['title_string_break']); ?>" size="30" class="fullwidth" />
				</li>
				<!-- EOF Title string break option. -->
				
				<!-- BOF Post string break option. -->
				<li>
					<label for="<?php echo $this->get_field_id('string_break'); ?>" class="srp-widget-label"><?php _e('Post string break', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter the text to be displayed as string break just after the end of the post/page content:', SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('string_break'); ?>" name="<?php echo $this->get_field_name('string_break'); ?>" value="<?php echo stripslashes($instance['string_break']); ?>" size="30" class="fullwidth" />
				</li>
				<!-- EOF Post string break option. -->
				
				<!-- BOF Image string break option. -->
				<li>
					<label for="<?php echo $this->get_field_id('image_string_break'); ?>" class="srp-widget-label"><?php _e('Image string break', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter the absolute URL of a custom image to use as string break:', SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('image_string_break'); ?>" name="<?php echo $this->get_field_name('image_string_break'); ?>" value="<?php echo stripslashes($instance['image_string_break']); ?>" size="30" class="fullwidth" /><br />
				</li>
				<!-- EOF Image string break option. -->
				
				
				<!-- BOF String break link option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('string_break_link'); ?>" name="<?php echo $this->get_field_name('string_break_link'); ?>" value="yes" <?php checked($instance["string_break_link"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('string_break_link'); ?>" class="srp-widget-label-inline"><?php _e('Link string/image break to post?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to link the string/image break to the related post/page.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF String break link option. -->
				
				<!-- BOF Allowed tags option. -->
				<li>
					<label for="<?php echo $this->get_field_id('allowed_tags'); ?>" class="srp-widget-label"><?php _e('Post allowed tags', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter a list of allowed HTML tags to be rendered in the post content visualization. Leave blank for clean text without any markup.', SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('allowed_tags'); ?>" name="<?php echo $this->get_field_name('allowed_tags'); ?>" value="<?php echo stripslashes($instance['allowed_tags']); ?>" size="30" class="fullwidth" /><br />
					<small><?php _e(htmlspecialchars('E.G: <a><p><strong>'), SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Allowed tags option. -->
			</ul>
		</dd>
		<!-- EOF Advanced posto options 1 -->

		<!-- BOF Advanced post options 2 -->
		<dt class="srp-widget-optionlist-dt-advposts">
			<a class="srp-wdg-accordion-item" href="#5" title="<?php _e('Advanced Posts Options 2', SRP_TRANSLATION_ID); ?>" name="5"><?php _e('Advanced Posts Options 2', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-advposts">
			<ul class="srp-widget-optionlist-advposts srp-widget-optionlist">
				<!-- BOF No-Follow option link switcher. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('nofollow_links'); ?>" name="<?php echo $this->get_field_name('nofollow_links'); ?>" value="yes" <?php checked($instance["nofollow_links"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('nofollow_links'); ?>" class="srp-widget-label-inline"><?php _e('Add no-follow attribute?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to use the \'rel=nofollow\' attribute on every post/page link.', SRP_TRANSLATION_ID); ?>
					<a href="http://en.wikipedia.org/wiki/Nofollow" title="nofollow" target="_blank"><?php _e('Learn more', SRP_TRANSLATION_ID); ?></a></small>
				</li>
				<!-- EOF No-Follow option link switcher. -->

				<!-- BOF "target=_blank" option link switcher. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('targetblank_links'); ?>" name="<?php echo $this->get_field_name('targetblank_links'); ?>" value="yes" <?php checked($instance["targetblank_links"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('targetblank_links'); ?>" class="srp-widget-label-inline"><?php _e('Open widget links in a new window?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to open all links in a new window.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF "target=_blank" option link switcher. -->

				<!-- BOF Meta data. -->
				<li>
					<label for="<?php echo $this->get_field_id('meta_data'); ?>" class="srp-widget-label"><?php _e('Choose post meta to display', SRP_TRANSLATION_ID); ?></label>
					<input type="checkbox" id="<?php echo $this->get_field_id('post_author'); ?>" name="<?php echo $this->get_field_name('post_author'); ?>" value="yes" <?php checked($instance["post_author"], 'yes'); ?> />
					<small><?php _e('Display post author', SRP_TRANSLATION_ID); ?></small><br />
					<input type="checkbox" id="<?php echo $this->get_field_id('post_category'); ?>" name="<?php echo $this->get_field_name('post_category'); ?>" value="yes" <?php checked($instance["post_category"], 'yes'); ?> />
					<small><?php _e('Display post category', SRP_TRANSLATION_ID); ?></small><br />
					<input type="checkbox" id="<?php echo $this->get_field_id('post_date'); ?>" name="<?php echo $this->get_field_name('post_date'); ?>" value="yes" <?php checked($instance["post_date"], 'yes'); ?> />
					<small><?php _e('Display post date', SRP_TRANSLATION_ID); ?></small><br />
					<input type="checkbox" id="<?php echo $this->get_field_id('post_tags'); ?>" name="<?php echo $this->get_field_name('post_tags'); ?>" value="yes" <?php checked($instance["post_tags"], 'yes'); ?> />
					<small><?php _e('Display post tags', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Meta data. -->
				
				<!-- BOF Extra meta data. -->
				<li>
					<label for="<?php echo $this->get_field_id('meta_data_extra'); ?>" class="srp-widget-label"><?php _e('Advanced post meta', SRP_TRANSLATION_ID); ?></label>
					
					<input type="checkbox" id="<?php echo $this->get_field_id('post_author_url'); ?>" name="<?php echo $this->get_field_name('post_author_url'); ?>" value="yes" <?php checked($instance["post_author_url"], 'yes'); ?> />
					<small><?php _e('Enable post author URL link', SRP_TRANSLATION_ID); ?></small><br />
					
					<input type="checkbox" id="<?php echo $this->get_field_id('post_category_link'); ?>" name="<?php echo $this->get_field_name('post_category_link'); ?>" value="yes" <?php checked($instance["post_category_link"], 'yes'); ?> />
					<small><?php _e('Enable post category link', SRP_TRANSLATION_ID); ?></small><br />
					
					<small><?php _e('Insert post date prefix:', SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_date_prefix'); ?>" name="<?php echo $this->get_field_name('post_date_prefix'); ?>" value="<?php echo stripslashes($instance['post_date_prefix']); ?>" size="30" class="fullwidth"/><br />

					<small><?php _e('Insert post author prefix:', SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_author_prefix'); ?>" name="<?php echo $this->get_field_name('post_author_prefix'); ?>" value="<?php echo stripslashes($instance['post_author_prefix']); ?>" size="30" class="fullwidth"/><br />
					
					<small><?php _e('Insert post category prefix:', SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_category_prefix'); ?>" name="<?php echo $this->get_field_name('post_category_prefix'); ?>" value="<?php echo stripslashes($instance['post_category_prefix']); ?>" size="30" class="fullwidth"/><br />
					
					<small><?php _e('Insert post tags prefix:', SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_tags_prefix'); ?>" name="<?php echo $this->get_field_name('post_tags_prefix'); ?>" value="<?php echo stripslashes($instance['post_tags_prefix']); ?>" size="30" class="fullwidth"/><br />
					
					<small><?php _e('Separate category names with:', SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_category_separator'); ?>" name="<?php echo $this->get_field_name('post_category_separator'); ?>" value="<?php echo stripslashes($instance['post_category_separator']); ?>" size="10" /><br />
					
					<small><?php _e('Separate tags names with:', SRP_TRANSLATION_ID); ?></small><br />
					<input type="text" id="<?php echo $this->get_field_id('post_tags_separator'); ?>" name="<?php echo $this->get_field_name('post_tags_separator'); ?>" value="<?php echo stripslashes($instance['post_tags_separator']); ?>" size="10" />
				</li>
				<!-- EOF Extra meta data. -->
				
				<!-- BOF Date content option. -->
				<li>
					<label for="<?php echo $this->get_field_id('date_format'); ?>" class="srp-widget-label"><?php _e('Post date format (*)', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Type here the coded format of post dates:',SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('date_format'); ?>" name="<?php echo $this->get_field_name('date_format'); ?>" value="<?php echo stripslashes($instance['date_format']); ?>" size="30" class="fullwidth" /><br />
					<small><?php _e('*(F = Month name | j = Day of the month | S = ordinal suffix for the day of the month | Y = Year)', SRP_TRANSLATION_ID); ?></small><br />
					<small><a href="http://php.net/manual/en/function.date.php" title="Date formatting" target="_blank"><?php _e('Learn more about date formatting', SRP_TRANSLATION_ID); ?></a></small>
				</li>
				<li>
					<label for="<?php echo $this->get_field_id('date_timeago'); ?>" class="srp-widget-label"><?php _e('Use the \'Time Ago\' mode', SRP_TRANSLATION_ID); ?></label>
					<input type="checkbox" id="<?php echo $this->get_field_id('date_timeago'); ?>" name="<?php echo $this->get_field_name('date_timeago'); ?>" value="yes" <?php checked($instance["date_timeago"], 'yes'); ?> />
					<small><?php _e('Eg. Published: 2 days ago.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Date content option. -->
			</ul>
		</dd>
		<!-- EOF Advanced post options 2 -->

		<!-- BOF Filtering options 1-->
		<dt class="srp-widget-optionlist-dt-filtering">
			<a class="srp-wdg-accordion-item" href="#6" title="<?php _e('Filtering Options 1', SRP_TRANSLATION_ID); ?>" name="6"><?php _e('Filtering Options 1', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-filtering">
			<ul class="srp-widget-optionlist-filtering srp-widget-optionlist">
				
				<!-- BOF Category auto filter option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('category_autofilter'); ?>" name="<?php echo $this->get_field_name('category_autofilter'); ?>" value="yes" <?php checked($instance["category_autofilter"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('category_autofilter'); ?>" class="srp-widget-label-inline"><?php _e('Enable auto category filtering?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to automatically change the recent posts according to the current viewed category archive. It will override any category filtering option.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Category auto filter option. -->

				<!-- BOF Single post category auto filter option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('category_autofilter_single'); ?>" name="<?php echo $this->get_field_name('category_autofilter_single'); ?>" value="yes" <?php checked($instance["category_autofilter_single"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('category_autofilter_single'); ?>" class="srp-widget-label-inline"><?php _e('Enable auto category filtering on single posts/pages?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to automatically change the recent posts according to the category of the current viewed post. It will override any category filtering option.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Single post category auto filter option. -->

				<!-- BOF Author auto filter option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('author_autofilter'); ?>" name="<?php echo $this->get_field_name('author_autofilter'); ?>" value="yes" <?php checked($instance["author_autofilter"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('author_autofilter'); ?>" class="srp-widget-label-inline"><?php _e('Enable auto author filtering?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to automatically change the recent posts according to the author of the current viewed post. It will override any category filtering option.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Author Aauto filter option. -->

				<!-- BOF Post status mode. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_status'); ?>" class="srp-widget-label"><?php _e('Filter by post status', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select how to filter displayed posts/pages based on their status:'); ?></small><br />
					<select id="<?php echo $this->get_field_id('post_status'); ?>" name="<?php echo $this->get_field_name('post_status'); ?>" class="srp-widget-select">
						<option value="publish" <?php selected($instance["post_status"], 'publish'); ?>><?php _e('Published (default)', SRP_TRANSLATION_ID); ?></option>
						<option value="private" <?php selected($instance["post_status"], 'private'); ?>><?php _e('Private', SRP_TRANSLATION_ID); ?></option>
						<option value="inherit" <?php selected($instance["post_status"], 'inherit'); ?>><?php _e('Inherit', SRP_TRANSLATION_ID); ?></option>
						<option value="pending" <?php selected($instance["post_status"], 'pending'); ?>><?php _e('Pending', SRP_TRANSLATION_ID); ?></option>
						<option value="future" <?php selected($instance["post_status"], 'future'); ?>><?php _e('Future', SRP_TRANSLATION_ID); ?></option>
						<option value="draft" <?php selected($instance["post_status"], 'draft'); ?>><?php _e('Draft', SRP_TRANSLATION_ID); ?></option>
						<option value="trash" <?php selected($instance["post_status"], 'trash'); ?>><?php _e('Trash', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Post status mode. -->
				
				<!-- BOF Include categories option. -->
				<li>
					<label for="<?php echo $this->get_field_id('category_include'); ?>" class="srp-widget-label"><?php _e('Include categories', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter a comma separated list of numeric categories IDs to include. Leave blank for no specific inclusion. <strong>ATTENTION:</strong> including specific categories will automatically exclude all the others.', SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('category_include'); ?>" name="<?php echo $this->get_field_name('category_include'); ?>" value="<?php echo htmlspecialchars($instance["category_include"], ENT_QUOTES); ?>" class="fullwidth" />
				</li>
				<!-- EOF Include categories option. -->

				<!-- BOF Include exclusive categories option. -->
				<li>
					<label for="<?php echo $this->get_field_id('category_include_exclusive'); ?>" class="srp-widget-label-inline"><?php _e('Exclusive filter', SRP_TRANSLATION_ID); ?></label><br />
					<input type="checkbox" id="<?php echo $this->get_field_id('category_include_exclusive'); ?>" name="<?php echo $this->get_field_name('category_include_exclusive'); ?>" value="yes" <?php checked($instance["category_include_exclusive"], 'yes'); ?> />
					<small><?php _e('Check this box if you want to display posts that belong exclusively to all the categories listed above. (two or more)', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Include exclusive categories option. -->
				
				<!-- BOF Exclude categories option. -->
				<li>
					<label for="<?php echo $this->get_field_id('category_exclude'); ?>" class="srp-widget-label"><?php _e('Exclude categories', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter a comma separated list of numeric categories IDs to exclude. Leave blank for no specific exclusion.', SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('category_exclude'); ?>" name="<?php echo $this->get_field_name('category_exclude'); ?>" value="<?php echo htmlspecialchars($instance["category_exclude"], ENT_QUOTES); ?>" class="fullwidth" />
				</li>
				<!-- EOF Exclude categories option. -->
				
				<!-- BOF Category title option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('category_title'); ?>" name="<?php echo $this->get_field_name('category_title'); ?>" value="yes" <?php checked($instance["category_title"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('category_title'); ?>" class="srp-widget-label-inline"><?php _e('Use category title?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to use the category name as widget title when a category filter is on.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Category title option. -->
			</ul>
		</dd>
		<!-- EOF Filtering options 1 -->

		<!-- BOF Filtering options 2-->
		<dt class="srp-widget-optionlist-dt-filtering">
			<a class="srp-wdg-accordion-item" href="#7" title="<?php _e('Filtering Options 2', SRP_TRANSLATION_ID); ?>" name="7"><?php _e('Filtering Options 2', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-filtering">
			<ul class="srp-widget-optionlist-filtering srp-widget-optionlist">

				<!-- BOF Include posts option. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_include'); ?>" class="srp-widget-label"><?php _e('Include posts/pages IDs', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter a comma separated list of numeric posts/pages IDs to include. Leave blank for no specific inclusion. <strong>ATTENTION:</strong> including specific posts will automatically exclude all the others.', SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('post_include'); ?>" name="<?php echo $this->get_field_name('post_include'); ?>" value="<?php echo htmlspecialchars($instance["post_include"], ENT_QUOTES); ?>" class="fullwidth" />
				</li>
				<!-- EOF Include posts option. -->

				<!-- BOF Include subposts/pages. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('post_include_sub'); ?>" name="<?php echo $this->get_field_name('post_include_sub'); ?>" value="yes" <?php checked($instance["post_include_sub"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('post_include_sub'); ?>" class="srp-widget-label-inline"><?php _e('Include subpages?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to include eventual subpages/subposts when filtering by IDs.', SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Include subposts/pages. -->
				
				<!-- BOF Exclude posts option. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_exclude'); ?>" class="srp-widget-label"><?php _e('Exclude posts/pages IDs', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter a comma separated list of numeric posts/pages IDs to exclude. Leave blank for no exclusion.', SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('post_exclude'); ?>" name="<?php echo $this->get_field_name('post_exclude'); ?>" value="<?php echo htmlspecialchars($instance["post_exclude"], ENT_QUOTES); ?>" class="fullwidth" />
				</li>
				<!-- EOF Exclude posts option. -->
				
				<!-- BOF Tags include option. -->
				<li>
					<label for="<?php echo $this->get_field_id('tags_include'); ?>" class="srp-widget-label"><?php _e('Filter posts by tags', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter a comma separated list of tags to filter posts by. Leave blank for no filtering.', SRP_TRANSLATION_ID); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('tags_include'); ?>" name="<?php echo $this->get_field_name('tags_include'); ?>" value="<?php echo htmlspecialchars($instance["tags_include"], ENT_QUOTES); ?>" class="fullwidth" />
				</li>
				<!-- EOF Tags include option. -->
				
				<!-- BOF Custom post types option. -->
				<li>
					<label for="<?php echo $this->get_field_id('custom_post_type'); ?>" class="srp-widget-label"><?php _e('Filter posts by custom post type', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Type here the name of a custom post type you wish to filter posts by:'); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('custom_post_type'); ?>" name="<?php echo $this->get_field_name('custom_post_type'); ?>" value="<?php echo stripslashes($instance['custom_post_type']); ?>" class="fullwidth" /><br />
					<small><?php _e('NOTICE: if you specify a custom post type, all previous posts options will be overrided.'); ?></small>
				</li>
				<!-- EOF Custom Post Types Option. -->
				
				<!-- BOF Custom field post filtering. -->
				<li>
					<label for="<?php echo $this->get_field_id('post_meta_key'); ?>" class="srp-widget-label"><?php _e('Filter posts by custom field', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Type here the meta key or meta value you wish to filter posts by.', SRP_TRANSLATION_ID); ?></small><br />
					<strong><?php _e('Meta Key', SRP_TRANSLATION_ID); ?></strong><br />
					<input type="text" id="<?php echo $this->get_field_id('post_meta_key'); ?>" name="<?php echo $this->get_field_name('post_meta_key'); ?>" value="<?php echo stripslashes($instance['post_meta_key']); ?>" class="fullwidth" /><br />
					<strong><?php _e('Meta Value', SRP_TRANSLATION_ID); ?></strong><br />
					<input type="text" id="<?php echo $this->get_field_id('post_meta_value'); ?>" name="<?php echo $this->get_field_name('post_meta_value'); ?>" value="<?php echo stripslashes($instance['post_meta_value']); ?>" class="fullwidth" />
				</li>
				<!-- EOF Custom field post filtering. -->
			</ul>
		</dd>
		<!-- EOF Filtering options 2 -->
		
		<!-- BOF Layout options -->
		<dt class="srp-widget-optionlist-dt-layout">
			<a class="srp-wdg-accordion-item" href="#8" title="<?php _e('Layout Options', SRP_TRANSLATION_ID); ?>" name="8"><?php _e('Layout Options', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-layout">
			<ul class="srp-widget-optionlist-layout srp-widget-optionlist">
				
				<!-- BOF Widget title header -->
				<li>
					<label for="<?php echo $this->get_field_id('widget_title_header'); ?>" class="srp-widget-label"><?php _e('Widget title header', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Select the type of HTML header to be used to enclose the widget title:'); ?></small><br />
					<select id="<?php echo $this->get_field_id('widget_title_header'); ?>" name="<?php echo $this->get_field_name('widget_title_header'); ?>" class="srp-widget-select">
						<option value="h1" <?php selected($instance["widget_title_header"], 'h1'); ?>><?php _e('H1', SRP_TRANSLATION_ID); ?></option>
						<option value="h2" <?php selected($instance["widget_title_header"], 'h2'); ?>><?php _e('H2', SRP_TRANSLATION_ID); ?></option>
						<option value="h3" <?php selected($instance["widget_title_header"], 'h3'); ?>><?php _e('H3 (default)', SRP_TRANSLATION_ID); ?></option>
						<option value="h4" <?php selected($instance["widget_title_header"], 'h4'); ?>><?php _e('H4', SRP_TRANSLATION_ID); ?></option>
						<option value="h5" <?php selected($instance["widget_title_header"], 'h5'); ?>><?php _e('H5', SRP_TRANSLATION_ID); ?></option>
						<option value="h6" <?php selected($instance["widget_title_header"], 'h6'); ?>><?php _e('H6', SRP_TRANSLATION_ID); ?></option>
					</select>
				</li>
				<!-- EOF Widget title header -->

				<!-- BOF Widget title header classes -->
				<li>
					<label for="<?php echo $this->get_field_id('widget_title_header_classes'); ?>" class="srp-widget-label"><?php _e('Additional widget title header classes', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Enter a space separated list of additional css classes for this widget title header:'); ?></small>
					<input type="text" id="<?php echo $this->get_field_id('widget_title_header_classes'); ?>" name="<?php echo $this->get_field_name('widget_title_header_classes'); ?>" value="<?php echo stripslashes($instance['widget_title_header_classes']); ?>" class="fullwidth" /><br />
					<small><?php _e('Example: class1 class2 class3 ...'); ?></small>
				</li>
				<!-- EOF Widget title header classes -->

				<!-- BOF Widget title hide option. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('widget_title_hide'); ?>" name="<?php echo $this->get_field_name('widget_title_hide'); ?>" value="yes" <?php checked($instance["widget_title_hide"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('widget_title_hide'); ?>" class="srp-widget-label-inline"><?php _e('Hide widget title', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to hide the widget title.',SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Widget title hide option. -->

				<!-- BOF Widget title above thumb. -->
				<li>
					<input type="checkbox" id="<?php echo $this->get_field_id('post_title_above_thumb'); ?>" name="<?php echo $this->get_field_name('post_title_above_thumb'); ?>" value="yes" <?php checked($instance["post_title_above_thumb"], 'yes'); ?> />
					<label for="<?php echo $this->get_field_id('post_title_above_thumb'); ?>" class="srp-widget-label-inline"><?php _e('Post title above thumbnail?', SRP_TRANSLATION_ID); ?></label><br />
					<small><?php _e('Check this box if you want to display the post title on top of the thumbnail.',SRP_TRANSLATION_ID); ?></small>
				</li>
				<!-- EOF Widget title above thumb. -->

				<!-- BOF Layout mode option. -->
				<li>
					<label for="<?php echo $this->get_field_name('layout_mode'); ?>" class="srp-widget-label"><?php _e('Choose layout mode', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('Choose between three different layout styles. Additional CSS rules might be needed to suite your needs.', SRP_TRANSLATION_ID); ?></small><br />
					<input type="radio" name="<?php echo $this->get_field_name('layout_mode'); ?>" value="single_column" <?php checked($instance["layout_mode"], 'single_column'); ?>> <?php _e('Single Column', SRP_TRANSLATION_ID); ?><br />
					<input type="radio" name="<?php echo $this->get_field_name('layout_mode'); ?>" value="single_row" <?php checked($instance["layout_mode"], 'single_row'); ?>> <?php _e('Single Row', SRP_TRANSLATION_ID); ?><br />
					<input type="radio" name="<?php echo $this->get_field_name('layout_mode'); ?>" value="multi_column" <?php checked($instance["layout_mode"], 'multi_column'); ?>> <?php _e('Multiple Columns', SRP_TRANSLATION_ID); ?>
				</li>
				<!-- EOF Layout mode option. -->
				
				<!-- BOF Multi column layout options. -->
				<li>
				<label for="<?php echo $this->get_field_name('layout_num_cols'); ?>" class="srp-widget-label"><?php _e('Multiple columns options', SRP_TRANSLATION_ID); ?></label>
				<small><?php _e('In order for the multiple columns layout mode to work, you must provide a total number of columns to display.', SRP_TRANSLATION_ID); ?></small><br />
				<input type="text" id="<?php echo $this->get_field_id('layout_num_cols'); ?>" name="<?php echo $this->get_field_name('layout_num_cols'); ?>" value="<?php echo htmlspecialchars($instance["layout_num_cols"], ENT_QUOTES); ?>" size="5" /> <?php _e('Cols', SRP_TRANSLATION_ID); ?>
				</li>
				<!-- EOF Multi column layout options. -->
			</ul>
		</dd>
		<!-- EOF Layout options -->
		
		<!-- BOF Code generator -->
		<dt class="srp-widget-optionlist-dt-codegenerator">
			<a class="srp-wdg-accordion-item" href="#9" title="<?php _e('Code Generator', SRP_TRANSLATION_ID); ?>" name="9"><?php _e('Code Generator', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-codegenerator">
			<ul class="srp-widget-optionlist-codegenerator srp-widget-optionlist">
				
				<!-- BOF Shortcode generator. -->
				<li>
					<label for="<?php echo $this->get_field_name('shortcode_generator_btn'); ?>" class="srp-widget-label"><?php _e('Generated shortcode', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('This is the shortcode generated from all saved options of this widget instance. Copy it and paste it inside a post/page.', SRP_TRANSLATION_ID); ?></small><br />
					<textarea id="<?php echo $this->get_field_id('shortcode_generator_area'); ?>" name="<?php echo $this->get_field_name('shortcode_generator_area'); ?>" class="fullwidth"><?php echo $this->srp_generate_code($instance, 'shortcode')?></textarea>
				</li>
				<!-- EOF Shortcode generator. -->
				
				<!-- BOF PHP code generator. -->
				<li>
					<label for="<?php echo $this->get_field_name('phpcode_generator_btn'); ?>" class="srp-widget-label"><?php _e('Generated PHP code', SRP_TRANSLATION_ID); ?></label>
					<small><?php _e('This is the PHP code generated from all saved options of this widget instance. Copy it and paste it inside a post/page.', SRP_TRANSLATION_ID); ?></small><br />
					<textarea id="<?php echo $this->get_field_id('phpcode_generator_area'); ?>" name="<?php echo $this->get_field_name('phpcode_generator_area'); ?>" class="fullwidth"><?php echo $this->srp_generate_code($instance, 'php')?></textarea>
				</li>
				<!-- EOF PHP code generator. -->
			</ul>
		</dd>
		<!-- EOF Code generator -->
		
		<!-- BOF Credits options -->
		<dt class="srp-widget-optionlist-dt-credits">
			<a class="srp-wdg-accordion-item" href="#10" title="<?php _e('Credits', SRP_TRANSLATION_ID); ?>" name="10"><?php echo _e('Credits', SRP_TRANSLATION_ID); ?></a>
		</dt>
		<dd class="srp-widget-optionlist-dd-credits">
			<ul class="srp-widget-optionlist-credits srp-widget-optionlist">
				
				<!-- BOF Credits text. -->
				<li>
					<?php _e('<p>The <strong>Special Recent Posts PRO Edition</strong> plugin is created, developed and supported by <a href="http://www.lucagrandicelli.com" title="Luca Grandicelli Website" target="_blank">Luca Grandicelli</a></p>', SRP_TRANSLATION_ID); ?>
						<strong><?php _e('SRP Version: ' . SRP_PLUGIN_VERSION . '</strong>', SRP_TRANSLATION_ID); ?>
				</li>
				<li>
					<p>
						<strong>Plugin Homepage</strong><br />
						<a href="http://www.specialrecentposts.com" target="_blank">specialrecentposts.com</a>
					</p>
					<p>
						<strong>SRP Help Desk</strong><br />
						<a href="http://www.specialrecentposts.com/support/" target="_blank">specialrecentposts.com/support</a>
					</p>
					<p>
						<strong>SRP on Twitter</strong><br />
						<a href="http://twitter.com/srpplugin" target="_blank">@srpplugin</a>
					</p>
					<p>
						<strong>SRP on Facebook</strong><br />
						<a href="http://www.facebook.com/SpecialRecentPosts" target="_blank">Special Recent Posts</a>
					</p>
						
				</li>
				<!-- EOF Credits text. -->
			</ul>
		</dd>
		<!-- EOF Credits options. -->
	</dl>
	<!-- EOF Widget accordion. -->
<?php
	}
}