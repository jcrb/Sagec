</div>
	</div>
	<div id="footer_area">
		<div id="footer_area_content">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(3) ) : ?>
		<div class="box">
			<?php WP_Widget_Recent_Posts::widget(array('before_title'=>'<h3>', 'after_title'=>'</h3>', 'before_widget'=>'<div class="box_content">', 'after_widget'=>'</div>'), array("title" => __('Recent Entry', 'techified'), "number" => 5)); ?>
		</div>
		
		<div class="box">
			<?php WP_Widget_Recent_Comments::widget(array('before_title'=>'<h3>', 'after_title'=>'</h3>', 'before_widget'=>'<div class="box_content">', 'after_widget'=>'</div>'), array("title" => __('Recent Comments', 'techified'), "number" => 5)); ?>
		</div>
		
		<div class="box">
			<h3><?php _e('Most Popular Posts', 'techified'); ?></h3>
			<div class="box_content">
				<?php if(function_exists("akpc_most_popular")) : ?>
				<ul>
					<?php akpc_most_popular(5); ?>
				</ul>
				<?php else: ?>
					<?php _e('Please install popularity contest plugin.', 'techified'); ?>
				<?php endif; ?>
			</div>
		</div>
					
		<div class="box">
			<h3><?php _e('About Author', 'techified'); ?></h3>
			<div class="box_content">
				<?php echo stripslashes(get_option('techified_about_us')); ?>
			 </div>
		</div>
		<?php endif; ?>
</div>   
		</div>
	<div id="footer_bottom">
		<div id="footer_bottom_content"><?php
	      //$blog_name = '<a href="'.get_bloginfo('url').'">'.get_bloginfo('name').'</a>';
	      //printf(__(' Traduction du th&egrave;me par <a href="http://www.wpthemes.ch"> WP Themes</a>, ', 'techified'), '&copy;', date('Y'), $blog_name); 
?> <?php
	      if(get_option ( 'techified_customize_stats_icon' )) echo stripslashes( get_option ( 'techified_customize_stats_icon' ) );
?>
	      </div>
	</div> 
</div>
<?php wp_footer(); ?>
<?php
if(get_option ( 'techified_customize_stats' )) echo stripslashes( get_option ( 'techified_customize_stats' ) );
?>

</body>
</html>

