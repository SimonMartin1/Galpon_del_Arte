

(function($) {

const IMAGENES_URL = '/Galpon_del_Arte/back/getImagenes.php'
const DESTACADO_URL = '/Galpon_del_Arte/back/getDestacado.php'



	var	$window = $(window),
		$body = $('body'),
		$wrapper = $('#page-wrapper'),
		$banner = $('#banner'),
		$header = $('#header'),
		$icono = $("#icono");

	// Breakpoints.
		breakpoints({
			xlarge:   [ '1281px',  '1680px' ],
			large:    [ '981px',   '1280px' ],
			medium:   [ '737px',   '980px'  ],
			small:    [ '481px',   '736px'  ],
			xsmall:   [ null,      '480px'  ]
		});

	// Play initial animations on page load.
		$window.on('load', function() {
			window.setTimeout(function() {
				$body.removeClass('is-preload');
			}, 500);
		});

	// Mobile?
		if (browser.mobile)
			$body.addClass('is-mobile');
		else {

			breakpoints.on('>medium', function() {
				$body.removeClass('is-mobile');
			});

			breakpoints.on('<=medium', function() {
				$body.addClass('is-mobile');
			});

		}

	// Scrolly.
		$('.scrolly')
			.scrolly({
				speed: 1500,
				offset: $header.outerHeight()
			});

	// Menu.
		$('#menu')
			.append('<a href="#menu" class="close"></a>')
			.appendTo($body)
			.panel({
				delay: 500,
				hideOnClick: true,
				hideOnSwipe: true,
				resetScroll: true,
				resetForms: true,
				side: 'right',
				target: $body,
				visibleClass: 'is-menu-visible'
			});

	// Header.
		if ($banner.length > 0
		&&	$header.hasClass('alt')) {

			$window.on('resize', function() { $window.trigger('scroll'); });

			$banner.scrollex({
				bottom:		$header.outerHeight() + 1,
				terminate:	function() { $header.removeClass('alt');
				$icono.toggleClass("icono2") 
				$icono.addClass("navegacion");
			},
				enter:		function() { $header.addClass('alt');
										$icono.removeClass("navegacion") 
										$icono.addClass("icono2");},
				leave:		function() { $header.removeClass('alt');
				$icono.removeClass("icono2") 
				$icono.addClass("navegacion"); }
			});

		}

async function listar(URL){
    try {
        let data=null;
        const res = await fetch(URL)
		data = await res.json();
        return data; 
    } catch (err) {
        console.error('Error al listar', err.message);
    }
}

async function galeria() {
	const data = await listar(IMAGENES_URL);
	const data_filtered= data.filter(i => i.destacada == 0);
	$('.contenedor-galeria').empty();
	data_filtered.forEach(element => {
	const img = $('<img>')
        .attr('src', `assets/images/${element.imagen_path}`)
		.attr('alt', `${element.titulo}`)
		.addClass('img-galeria')
	$('.contenedor-galeria').append(img);
	});
}

async function listar_imagenes(){
	const data = await listar(IMAGENES_URL);
	$('#select-img').empty();
	data.forEach(element => {
	const el = $('<option>').text(`${element.imagen_path}`);
	$('#select-img').append(el);
	});
}

async function listar_item(){
	const data = await listar(DESTACADO_URL);
	$('#select-item').empty();
	const defaultOption = $('<option value="0" selected disabled>--Seleccionar--</option>');
	$('#select-item').append(defaultOption);
	data.forEach(e=>{
		const el = $('<option>')
		.attr('value',e.id)
		.text(e.id+'- '+e.titulo);
		$('#select-item').append(el);
	});
}


async function listar_contenido(){
	const data = await listar(DESTACADO_URL);
	const selectedOption= $('#select-item').find('option:selected');
	const data_filter= data.filter(e => e.id == selectedOption.attr('value'));
	$('#selected-titt').empty();
	$('#selected-description').empty();
	$('#selected-titt').val(data_filter[0].titulo);
	$('#selected-description').text(data_filter[0].descripcion);
	listar_imagenes();
	$('#response').removeClass('hide');
}

async function mostrar_destacado(){
	const data = await listar(DESTACADO_URL);
	data.forEach(e=> {
		$('#'+feature-tittle+e.id).empty()
		$('#'+feature-tittle+e.id).text(e.titulo)
		$('#'+feature-text+e.id).empty()
		$('#'+feature-text+e.id).text(e.descripcion)
	});
}


$(document).on('click', '.img-galeria', async function(){
	const src = $(this).attr('src');
	$('#mostrar').attr('src', src);
		setTimeout(() => {$('.img-light').addClass('show');
		$('#header').addClass('hide');
		$('.agregar-imagen').addClass('showImage');
	}, 200);
});


$(document).on('click', '.close2, .img-light', function(e){
	if ($(e.target).hasClass('agregar-imagen')) return;
	$('.img-light').removeClass('show');
	setTimeout(() => {
		$('.agregar-imagen').removeClass('showImage').attr('src','')
		$('#header').removeClass('hide');
	}, 200);
});

$('#select-item').on('change', async()=>{
	listar_contenido()
});

	mostrar_destacado();
	galeria()
	listar_item();

})(jQuery);




