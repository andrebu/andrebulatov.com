<div class="scribe-keyword-research-meta-box-container">
	
	<div class="scribe-keyword-research-meta-box-statistics misc-pub-section">
		<?php esc_html_e('Evaluations left: ', 'scribeseo'); ?><strong><span class="scribe-keyword-research-evaluations-remaining"><?php echo number_format_i18n($remaining_evaluations); ?></span> <?php printf( esc_html__('as of %s', 'scribeseo'), date('F j, Y')); ?></strong>
	</div>
	
	<div id="scribe-keyword-research-meta-box-input" class="scribe-keyword-research-meta-box-input misc-pub-section">
		<input class="scribe-default" type="text" id="scribe-keyword-research-term" name="scribe-keyword-research-term" data-default="<?php esc_attr_e('Enter a keyword', 'scribeseo'); ?>" value="" tabindex="40003" />
		<input class="scribe-keyword-research-search-button button button-primary" type="button" tabindex="40004" value="<?php esc_attr_e('Research', 'scribeseo'); ?>" />
		
		<div class="alignright">
			<img id="scribe-keyword-research-ajax-feedback" alt="" title="" class="scribe-ajax-feedback" src="<?php  echo esc_url(admin_url('images/wpspin_light.gif')); ?>" style="visibility: hidden;">
		</div>
			
		<input type="hidden" id="scribe-keyword-research-url-placeholder" value="<?php scribe_the_upload_iframe_src('scribe-keyword-suggestions', null, array('scribe-keyword' => 'KEYWORD_PLACEHOLDER')); ?>" />
		
		<a title="<?php esc_attr_e('Previous Keyword Research', 'scribeseo'); ?>" data-previous-count="<?php echo esc_attr( count( $previous_keywords ) ); ?>" href="<?php scribe_the_upload_iframe_src('scribe-keyword-suggestions', null, array('scribe-previous-keywords' => 'true')); ?>" class="scribe-keyword-research-meta-box-previous-keyword-suggestions thickbox"><small><?php esc_html_e('Previous Keyword Suggestions', 'scribeseo'); ?></small></a>
	</div>
	
	<div class="scribe-keyword-research-meta-box-target">
		<h4><?php esc_html_e('Target Term', 'scribeseo'); ?></h4>
		<em class="scribe-keyword-research-meta-box-target-text"><?php echo esc_html( $target_term ); ?></em>
		(<a class="scribe-clear-target-term" href="<?php echo wp_nonce_url( add_query_arg( array( 'action' => 'scribe_clear_target_term', 'scribe-post-id' => (int)$post->ID ), admin_url( 'admin-ajax.php' ) ), 'scribe-clear-target-term' ); ?>"><?php esc_html_e('clear', 'scribeseo'); ?></a>)
	</div>
	
	<?php wp_nonce_field('scribe-research-keyword', 'scribe-research-keyword-nonce'); ?>
	
</div>