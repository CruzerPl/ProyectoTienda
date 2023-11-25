
$(document).ready(function(){

    //Modal Form add product
    $('.add_product').click(function(e){
        e.preventDefault();
        var producto = $(this).attr('product');
        var action = 'infoProducto';
 
        

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async : true,
            data: {action:action,producto:producto},

            success: function(response){

                    if(response != 'error'){
                        info = JSON.parse(JSON.stringify(response));
                        $('#producto_id').val(info.codproducto);
                        $('.nameProducto').html(info.descripcion);

                        /*$('.bodyModal').html('<form action="" method="post" name="form_add_product" id="form_add_product" onsubmit="event.preventDefault(); sendDataProduct();">'+
                                '<h1><i class="fa fas-cubes" style="font-size: 45pt;"></i><br> Agregar Producto</h1>'+
                                '<h2 class="nameProducto">'+info.descripcion+'</h2> <br>'+
                                '<input type="number" name="cantidad" id="txtCantidad" placeholder="cantidad del producto" required> <br>'+
                                '<input type="text" name="precio" id="txtPrecio" placeholder="Precio del producto" required> <br>'+
                                '<input type="hidden" name="producto_id" id="producto_id" value="'+info.codproducto+'" required> '+
                                '<input type="hidden" name="action" value="addProduct" required>'+ 
                                    '<div class="alert alertAddProduct"></div>'+
                                        '<button type="submit" class="btn_new"><i class="fas-fa-plus"></i>Agregar</button>'+
                                        '<a href="#" class="btn_ok closeModal" onclick="coloseModal();"><i class="fas fa-ban"></i>Cerrar</a>'+
                                        '</form>');*/
                    }
            },

            error: function(error){
                console.log(response);
            }
        });

  
        $('.modal').fadeIn();
    });

    //buscar Cliente

    $('#nit_cliente').keyup(function(e){

        var cl = $(this).val();
        var action = 'searchCliente';

        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async : true,
            data: {action:action,cliente:cl},

            success: function(response){

                if(response == 0)
                {
                    $('#idcliente').val('');
                    $('#nom_cliente').val('');
                    $('#tel_cliente').val('');
                    $('#dir_cliente').val('');

                    //mostrar boton agregar
                    $('.btn_new_cliente').slideDown();
                }else{
                    var data = $.parseJSON(response);
                    $('#idcliente').val(data.idcliente);
                    $('#nom_cliente').val(data.nombre);
                    $('#tel_cliente').val(data.telefono);
                    $('#dir_cliente').val(data.direccion);

                    //ocultar boton agregar
                    $('.btn_new_cliente').slideUp();

                    //bloque campos
                    $('#nom_cliente').attr('disabled','disabled');
                    $('#tel_cliente').attr('disabled','disabled');
                    $('#dir_cliente').attr('disabled','disabled');

                    //ocultar Boton Guardar
                    $('#div_registro_cliente').slideUp();
                }

            },
            error : function(error){

            }
        });

    });


    //Buscar producto
    $('#txt_cod_producto').keyup(function(e){
        e.preventDefault();

        var producto = $(this).val();
        var action = 'infoProducto';

        if(producto != '')
        {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async : true,
                data: {action:action,producto:producto},
    
                success: function(response){
                    if(response != 'error')
                    {
                        var info = JSON.parse(response);
                        $('#txt_descripcion').html(info.descripcion);
                        $('#txt_existencia').html(info.existencia);
                        $('#txt_cant_producto').val('1');
                        $('#txt_precio').html(info.precio);
                        $('#txt_precio_total').html(info.precio);

                        //Activar cantidad
                        $('#txt_cant_producto').removeAttr('disabled');

                         //mostrar boton agregar
                         $('#add_product_venta').slideDown();
                        
                    }else{
                        $('#txt_descripcion').html('-');
                        $('#txt_existencia').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');
                       
                        //bloquear cantidad
                        $('#txt_cant_producto').attr('disabled','disabled');
                        //ocultar boton agregar
                        $('#add_product_venta').slideUp();
                    }
                    
                },
                error : function(error){
    
                }
            });
        }
      

    });

    //Validar cantidad del producto
    $('#txt_cant_producto').keyup(function(e){
        e.preventDefault();
        var precio_total = $(this).val() * $('#txt_precio').html();
        var existencia = parseInt($('#txt_existencia').html());
        $('#txt_precio_total').html(precio_total);

        //oculta boton agregar si la cantidad es menor que 1
        if( ($(this).val() < 1 || isNaN($(this).val())) || ($(this).val() > existencia)  )
        {
            $('#add_product_venta').slideUp();
        }else{
            $('#add_product_venta').slideDown();
        }


    });

  //anular venta
  $('#btn_anular_venta').click(function(e){
    e.preventDefault();

    var rows    = $('#detalle_venta tr').length;
    if(rows > 0)
    {

        var action = 'anularVenta';

        $.ajax({
            url: 'ajax.php',
            type: "POST",
            async : true,
            data: {action:action},

            success: function(response)
            {
                console.log('error');
                if(response != 'error')
                {
                    location.reload();
                }
            },
            error: function(error){
            }
        });
    }
});


    //Agregar producto al detalle
    $('#add_product_venta').click(function(e){
        e.preventDefault();
        if($('#txt_cant_producto').val() > 0)
        {
            var codproducto = $('#txt_cod_producto').val();
            var cantidad = $('#txt_cant_producto').val();
            var action = 'addProductoDetalle';

            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async : true,
                data: {action:action,producto:codproducto,cantidad:cantidad},

                success: function(response)
                {
                    if(response != 'error')
                    {
                        var info = JSON.parse(response);
                        $('#detalle_venta').html(info.detalle);
                        $('#detalle_totales').html(info.totales);

                        $('#txt_cod_producto').val('');
                        $('#txt_descripcion').html('-');
                        $('#txt_existencia').html('-');
                        $('#txt_cant_producto').val('0');
                        $('#txt_precio').html('0.00');
                        $('#txt_precio_total').html('0.00');

                        //bloquear cantidad
                        $('#txt_cant_producto').attr('disabled','disabled');

                        //ocultar boton agregar
                        $('#add_product_venta').slideUp();

                    }else{
                        console.log('no data');
                    }
                    viewProcesar();
                },
                error: function(error)
                {
                }
                    
            });
        }

    
    });
        //Facturar Venta
    $('#btn_facturar_venta').click(function(e){
        e.preventDefault();
    
        var rows  = $('#detalle_venta tr').length;
        if(rows > 0)
        {
    
            var action = 'procesarVenta';
            var codcliente = $('#idcliente').val();
            $.ajax({
                url: 'ajax.php',
                type: "POST",
                async : true,
                data: {action:action,codcliente:codcliente},
    
                success: function(response)
                {
                    if(response != 'error')
                    {
                        var info = JSON.parse(response);
                        generarPDF(info.codcliente,info.nofactura);

                        location.reload();
                    }
                },
                error: function(error){
                }
            });
        }else{
            console.log('no hay rows');
        }
    });
  

});//FIN DEL READY




function generarPDF(cliente,factura){

    // Variables define el alto de la ventana para mostrar
    var ancho = 1000;
    var alto = 800;

    // Calcular posocion x,y para centrar la ventana
    var x = parseInt((window.screen.width/2) - (ancho / 2));
    var y = parseInt((window.screen.height/2) - (alto / 2));

    $url = 'factura/generaFactura.php?cl='+cliente+'&f='+factura;
    // Posciones
    window.open($url,"Factura","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si,location=no,resizable=si,menubar=no");
}



//mostrar ocultar boton procesar
function viewProcesar(){
    if($('#detalle_venta tr').length > 0){

        $('#btn_facturar_venta').show();
    }else{
        $('btn_facturar_venta').hide();
    }
}

function del_product_detalle(correlativo){
    var action ='delProductoDetalle';
    var id_detalle = correlativo;


    $.ajax({


        url :'ajax.php',
        type: "POST",
        async: true,
        data: {action:action,id_detalle:id_detalle},
            
        success: function(response)
        {
            if(response != 'error'){
                var info = JSON.parse(response);

                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);

                $('#txt_cod_producto').val('');
                $('#txt_descripcion').html('-');
                $('#txt_existencia').html('-');
                $('#txt_cant_producto').val('0');
                $('#txt_precio').html('0.00');
                $('#txt_precio_total').html('0.00');

                //bloquear cantidad
                $('#txt_cant_producto').attr('disabled','disabled');

                //ocultar boton agregar
                $('#add_product_venta').slideUp();

            }else{
                $('#detalle_venta').html('');
                $('#detalle_totales').html('');
            }
            viewProcesar();
           
        },
        error : function(error){
            console.log('no data');
        }
    });
}

function searchForDetalle(id){
    var action ='searchForDetalle';
    var user = id;


    $.ajax({


        url :'ajax.php',
        type: "POST",
        async: true,
        data: {action:action,user:user},
            
        success: function(response){

            if(response != 'error')
            {
                var info = JSON.parse(response);
                $('#detalle_venta').html(info.detalle);
                $('#detalle_totales').html(info.totales);

            }else{
                console.log('no data');
            }
            viewProcesar();
        },
        error : function(error){
            console.log('no data');
        }

    }); 

}

function sendDataProduct(){
    $('.alertAddProduct').html('');

    $.ajax({
        url: 'ajax.php',
        type: "POST",
        async : true,
        data: $('#form_add_product').serialize(),

        success: function(response){

                console.log(response);
        },

        error: function(error){

        }
    });
}

function coloseModal(){
    $('.alertAddProduct').html('');
    $('#txtCantidad').val('');
    $('#txtPrecio').val('');
    $('.modal').fadeOut();
}