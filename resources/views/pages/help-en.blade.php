<html lang="{{\App::getLocale()}}">
	<head>
		<meta charset="utf-8">

		<title>Canopy Story Slideshow</title>

		<meta name="description" content="A framework for easily creating beautiful presentations using HTML">
		<meta name="author" content="Hakim El Hattab">

		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">

		<link rel="stylesheet" href="{{elixir('css/reveal.css')}}">

		<!--[if lt IE 9]>
		<script src="lib/js/html5shiv.js"></script>
		<![endif]-->
	</head>

	<body>

		<div class="reveal" style="left:-17px; top: -17px;">

			<!-- Any section element inside of this container is displayed as a slide -->
			<div class="slides">
				<section>
					<section>
						<h2>What is {{ config('app.name') }}?</h2>
						<ul>
							<!-- <li class="fragment">Characterize and describethe distribution of large neighborhood trees in the Portland Metropolitan Region.</li> -->
							<li class="fragment">A way to find significant trees in your neighborhood.</li>
							<li class="fragment">A way to tell stories about trees.</li>
							<li class="fragment">Possibly, a way to preserve existing tree canopy.</li>							
						</ul>
					</section>
                    <section data-background-transition="slide" data-transition="slide" 
                        data-background="{{ asset('help_images/hand.jpg') }}">
						<h2 style="background-color:rgba(0,0,0,0.5)">How to Use the Tool:</h2>
						<br>
						<br>
						<p style="background-color:rgba(0,0,0,0.5)">1. Select a neighborhood</p>
					</section>
                    <section data-background-transition="slide" data-transition="slide" 
                        data-background="{{ asset('help_images/hand2.jpg') }}">
						<br>
						<br>
						<br>
						<p style="background-color:rgba(0,0,0,0.5)">2. Once selected, the trees will load.</p>
					</section>
                    <section data-background-transition="slide" data-transition="slide" 
                        data-background="{{ asset('help_images/hand3.jpg') }}">
						<br>
						<br>
						<br>
						<p style="background-color:rgba(0,0,0,0.5)">3. Clicking on an individual tree will reveal more information!</p>
					</section>
					<section>
						<h1 style="text-decoration:underline;">Details</h1>
						<br>
						<div style="text-align:left;">
							<p>1. Only includes trees 50ft or taller</p>
							<p class="fragment">2. Occasionally two points may merge into a single point.</p>
							<p class="fragment">3. Occasionally one point may split into multiple points.</p>
							<p class="fragment">4. Due to the size of the data, expect ~15s loading times on slower connections.</p>
						</div>
					</section>
					<section>
						<h2>Ready to Try?<br><br>Click the Button Below!</h2>
					</section>
				</section>
			</div>
		</div>

		<script src="{{elixir('js/reveal.js')}}"></script>

		<script>

			// Full list of configuration options available at:
			// https://github.com/hakimel/reveal.js#configuration
			Reveal.initialize({
				controls: true,
				progress: true,
				history: true,
				center: true,

				transition: 'slide', // none/fade/slide/convex/concave/zoom
				backgroundTransition: 'fade',
				// Optional reveal.js plugins
				dependencies: [
					{ src: 'lib/js/classList.js', condition: function() { return !document.body.classList; } },
					{ src: 'plugin/markdown/marked.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					{ src: 'plugin/markdown/markdown.js', condition: function() { return !!document.querySelector( '[data-markdown]' ); } },
					{ src: 'plugin/highlight/highlight.js', async: true, condition: function() { return !!document.querySelector( 'pre code' ); }, callback: function() { hljs.initHighlightingOnLoad(); } },
				]
			});

		</script>

	</body>
</html>


