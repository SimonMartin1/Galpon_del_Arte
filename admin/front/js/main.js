

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

// Funcionalidad de carga de imágenes
$('#file-input').on('change', function() {
    const files = this.files;
    const previewContainer = $('#preview-container');
    const imagePreview = $('#image-preview');
    const uploadBtn = $('#upload-btn');

    imagePreview.empty();

    if (files.length > 0) {
        previewContainer.show();
        uploadBtn.prop('disabled', false);

        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = $('<div class="col-3 col-6-xsmall col-12-xxsmall">');
                    const img = $('<img>').attr('src', e.target.result).css({
                        'width': '100%',
                        'height': 'auto',
                        'border-radius': '5px',
                        'margin-bottom': '10px'
                    });
                    const removeBtn = $('<button>').text('Eliminar').addClass('button small').css('margin-bottom', '10px');
                    removeBtn.on('click', function() {
                        imgDiv.remove();
                        // Actualizar files array (simulado)
                        const dt = new DataTransfer();
                        const input = $('#file-input')[0];
                        Array.from(input.files).forEach((f, i) => {
                            if (i !== index) dt.items.add(f);
                        });
                        input.files = dt.files;
                        if (input.files.length === 0) {
                            previewContainer.hide();
                            uploadBtn.prop('disabled', true);
                        }
                    });
                    imgDiv.append(img).append(removeBtn);
                    imagePreview.append(imgDiv);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        previewContainer.hide();
        uploadBtn.prop('disabled', true);
    }
});

$('#upload-btn').on('click', async function() {
    const files = $('#file-input')[0].files;
    const formData = new FormData();

    Array.from(files).forEach(file => {
        formData.append('images[]', file);
    });

    try {
        const response = await fetch('/Galpon_del_Arte/admin/back/uploadImages.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();
        if (response.ok) {
            alert('Imágenes subidas correctamente');
            $('#file-input').val('');
            $('#preview-container').hide();
            $('#upload-btn').prop('disabled', true);
            // Opcional: recargar lista de imágenes
            listar_imagenes();
        } else {
            alert('Error al subir imágenes: ' + result.error);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al subir imágenes');
    }
});

listar_item();

})(jQuery);




