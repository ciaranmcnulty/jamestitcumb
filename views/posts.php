<?php require_once('header.php'); ?>

<?php foreach ($posts as $slug => $post): ?>
<article style="margin-bottom: 60px;">
	<div class="article-header">
		<h1><a href="/posts/<?php echo $slug; ?>"><?php echo $post['title']; ?></a></h1>
		<p style="font-weight: bold; font-style: italic;">Posted on <?php echo date('jS F Y', strtotime($post['date'])); ?></p>
	</div>
	<hr />
	<div class="article-body">
		<?php echo $post['content']; ?>
	</div>

	<?php if ($post['active']): ?>
		<hr />

		<div id="disqus_thread"></div>
		<script type="text/javascript">
			/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
			var disqus_shortname = 'asgrim'; // required: replace example with your forum shortname

			/* * * DON'T EDIT BELOW THIS LINE * * */
			(function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
		</script>
		<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
		<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
	<?php endif; ?>

</article>
<?php endforeach; ?>

<?php require_once('footer.php'); ?>
