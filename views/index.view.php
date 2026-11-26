<?php require 'partials/head.php'; ?>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="/css/styles.css">
<?php require 'partials/header.php'; ?>
<main class="relative flex flex-col items-center justify-center h-96 md:h-[32rem] px-6 text-center xl:h-[36rem] w-full">
    <video autoplay muted loop class="absolute inset-0 w-full h-full object-cover">
        <source src="images/video1.mp4" type="video/mp4">
        Tu navegador no soporta el elemento de video.
    </video>
    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
    <h1 class="text-4xl z-10 drop-shadow-lg text-background-50 md:text-5xl xl:text-6xl font-semibold px-4">
        Bienvenido a Hotel Oasis Resort
    </h1>
    
    <p class="mt-2 z-10 drop-shadow-lg text-text-200 text-sm md:text-base px-4">
        Disfruta de la mejor experiencia en nuestro hotel y resort de lujo en las playas de Ecuador
    </p>
</main>

<section class="relative flex flex-col items-center px-6 py-16 text-center md:px-12 bg-neutral-200">
	<h1 class="text-4xl md:text-5xl">¡Bienvenidos a OASIS Hotel & Resort!</h1>
	<p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl">
		Tu destino de ensueño donde la comodidad y la excelencia se fusionan para crear 
		experiencias inolvidables! En nuestra página, te invitamos a sumergirte en un mundo 
		de posibilidades, donde cada clic te acerca a un viaje lleno de placer y descanso.
	</p>
	<br>
	<h1 class="text-3xl md:text-4xl">Qué ofrecemos?</h1>
	<p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl">
		Hotel Oasis Resort ofrece una variedad de servicios para que disfrutes de tu estancia al máximo
		aquí en nuestras instalaciones. Desde habitaciones de lujo hasta servicios de spa y restaurantes
		con la mejor comida de la región. ¡Descubre todo lo que tenemos para ti!
	</p>
	<div class="relative grid grid-cols-3 gap-x-8 md:gap-x-16 mt-16">
		<?php foreach ($services as $service) {
			require 'partials/index_card.php';
		} ?>
	</div>
	<br>
	<h1 class="text-3xl md:text-4xl">Reservaciones</h1>
	<p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl">
		Elige la suite, nosotros nos encargamos de los detalles.
	</p>
	
	<br><br>

	<div class="ofertas-container">
		<div class="oferta">
			<div class="image-container">
				<img src="images/hab1.jpg" alt="Simple">
			
				<div class="overlay">
					<span>Habitación Sencilla</span>
				</div>
			</div>
			<div class="oferta-info">
				<ul>
					<li>- Una cama King Size, baño privado.</li>
					<li>- Escritorio, TV por cable y WIFI.</li>
					<li>- Precio: $60.</li>
				</ul>
			</div>
		</div>
	
		<div class="oferta">
			<div class="image-container">
				<img src="images/hab2.jpg" alt="Doble">
						
				<div class="overlay">
					<span>Habitación Doble</span>
				</div>
			</div>
			<div class="oferta-info">
			
				<ul>
					<li>- Dos camas King Size, baño privado.</li>
					<li>- Escritorio, TV por cable y WIFI.</li>
					<li>- Precio: $80.</li>
				</ul>
			</div>
		</div>
	
		<div class="oferta">
			<div class="image-container">
				<img src="images/hab3.jpeg" alt="Beneficios Ocasiones Especiales">

				<div class="overlay">
					<span >Habitación triple</span>
				</div>

			</div>
			<div class="oferta-info">
				<ul>
					<li>- Una cama King Size, dos camas Twin Size.</li>
					<li>- Baño privado, TV por cable y WIFI.</li>
					<li>- Precio: $150.</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="button-container" style="position: relative;">
		<button class="reservar" onclick="window.location.href='reservas'">Reservar Ahora</button>
	</div>
</section>

<section class="relative flex flex-col items-center px-6 py-16 text-center md:px-12" >
	<h1 class="text-4xl md:text-5xl">¡OASIS Hotel & Resort!</h1>
	<p>Sumérgete en una experiencia única y relajante donde cada detalle está diseñado 
		para que vivas las mejores vacaciones de tu vida. Disfruta de nuestro lujo, 
		confort y atención personalizada para crear recuerdos inolvidables en un entorno paradisíaco.
	</p>
</section>
<div class="button-container" style="position: relative;">
		<button class="reservar" onclick="window.location.href='contacto'">Registrate Ahora</button>
	</div>
<section class="relative flex flex-col items-center px-6 py-16 text-center md:px-12">
	<h1 class="text-3xl md:text-4xl">Encuéntranos!</h1>
	<p class="mt-4 leading-7 max-w-md md:max-w-2xl lg:max-w-3xl xl:max-w-4xl">
		Estamos ubicados en la provincia de Pichicha, en la ciudad de Quito. Ven y disfruta de nuestras
		instalaciones y servicios de lujo en la mejor playa de Ecuador.
	</p>
	<div class="relative mt-12 h-full w-full flex items-center justify-center">
	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7983374916876!2d-78.50927844643593!3d-0.18133848433556615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91d59af7b026fbab%3A0x882d0bf879fdb538!2sUniversidad%20UTE%20-%20Campus%20Occidental!5e0!3m2!1ses-419!2sec!4v1718599575699!5m2!1ses-419!2sec" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>
</section>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
<?php require 'partials/footer.php'; ?>
<?php require 'partials/end.php'; ?>