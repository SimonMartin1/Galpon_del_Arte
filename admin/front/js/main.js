

(function($) {

const IMAGENES_URL = '/Galpon_del_Arte/back/getImagenes.php'
const DESTACADO_URL = '/Galpon_del_Arte/back/getDestacado.php'


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



async function listar_item(){
    const data = await listar(DESTACADO_URL);
	$('#select-item').empty();
	const defaultOption = $('<option value="0" selected disabled>--Seleccionar--</option>');
	$('#select-item').append(defaultOption);
	data.forEach(e=>{
		const el = $('<option>')
		.attr('value',e.id)
		.text(e.id+' - '+e.titulo);
		$('#select-item').append(el);
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


$('#select-item').on('change', async()=>{
	listar_contenido()
});

$('#log-out').on('click', async () => {
        await fetch('/Galpon_del_Arte/admin/back/logout.php');
        window.location.href = '/Galpon_del_Arte/admin/front/login.html';
    });


listar_item();

})(jQuery);




