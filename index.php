<?php get_header(); ?>

<main class="container">

<?php if ( $starter_display_options['layout'] == 3 && is_active_sidebar('sidebar-left') ): ?>
<ul class="five columns sidebar" id="sidebar-left" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<?php dynamic_sidebar('sidebar-left'); ?>
</ul>
<?php endif; ?>

<div class="<?php starter_layout_class(); ?>" id="content" role="main">

	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( '_content/loop', '' ); ?>
		<?php endwhile; ?>
	<?php endif; ?>

	<?php starter_pagination(); ?>

</div>

<?php if ( $starter_display_options['layout'] == 1 && is_active_sidebar('sidebar-right') ) : ?>
<ul class="five columns sidebar" id="sidebar-right" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<?php dynamic_sidebar('sidebar-right'); ?>
</ul>
<?php endif; ?>

</main>

<?php get_footer(); ?>