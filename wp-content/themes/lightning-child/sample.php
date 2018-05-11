<ul　class="list">
<?php $posts = get_posts('numberposts=4&category=9'); global $post; ?>
<?php if($posts): foreach($posts as $post): setup_postdata($post); ?>
<li><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>
<?php endforeach; endif; ?>
</ul>
