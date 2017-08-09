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
						<h2>¿Que es {{ config('app.name') }}?</h2>
						<ul>
                            <li class="fragment">
                                Es una manera de encontrar árboles importantes en su vecindario.
                            </li>
                            <li class="fragment">
                                Es un espacio para contar historias acerca de árboles.
                            </li>
                            <li class="fragment">
                                Posiblemente es un método de conservación de los árboles existentes.
                            </li>
						</ul>
					</section>
                    <section data-background-transition="slide" data-transition="slide" 
                        data-background="{{ asset('help_images/hand.jpg') }}">
						<h2 style="background-color:rgba(0,0,0,0.5)">Cómo usar la herramienta:</h2>
						<br>
						<br>
                        <p style="background-color:rgba(0,0,0,0.5)">
                            1. Seleccione un barrio
                        </p>
					</section>
                    <section data-background-transition="slide" data-transition="slide" 
                        data-background="{{ asset('help_images/hand2.jpg') }}">
						<br>
						<br>
						<br>
                        <p style="background-color:rgba(0,0,0,0.5)">
                            2. Cuando lo selecciona, los árboles se cargarán.
                        </p>
					</section>
                    <section data-background-transition="slide" data-transition="slide" 
                        data-background="{{ asset('help_images/hand3.jpg') }}">
						<br>
						<br>
						<br>
                        <p style="background-color:rgba(0,0,0,0.5)">
                            3. Al hacer clic en un árbol individual, ¡se mostrará más información!
                        </p>
					</section>
					<section>
						<h1 style="text-decoration:underline;">Detalles</h1>
						<br>
						<div style="text-align:left;">
                            <p>
                                1. Sólo incluye árboles que son 50 pies o más altos.
                            </p>
                            <p class="fragment">
                                2. Ocasionalmente dos puntos cercanos pueden aparecer como un solo punto.
                            </p>
                            <p class="fragment">
                                3. Algunos árboles muy grandes pueden haber sido divididos en múltiples puntos.
                            </p>
                            <p class="fragment">
                                4. Debido al tamaño de los datos, espere 15 segundos de tiempo de carga en conexiones más lentas.
                            </p>
						</div>
					</section>
					<section>
						<h2>¿Listo para probar?<br><br>¡Haga clic en el botón abajo!</h2>
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


