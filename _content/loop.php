<article <?php post_class(); ?> id="post-<?php the_ID(); ?>" role="article">
	<?php the_title( '<h1 class="entry-title name"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h1>' ); ?>
	<?php the_content(); ?>
	<?php wp_link_pages(); ?>
</article>