<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <h6>
                        <i class="fa fa-align-justify"></i> Gestión de Compras
                        <button type="button" @click="mostrarDetalle()" class="btn btn-success">
                            <i class="fa fa-line-chart"></i>&nbsp;Facturar
                        </button>
                    </h6>
                </div>
                <!-- listado -->
                <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="num_fac">Número de factura</option>
                                        <option value="fecha_hora">Fecha-Hora</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarEntrada(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarEntrada(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>      
                                        <th>Numero Factura</th>
                                        <th>Fecha - Hora</th>
                                        <th>Iva</th>
                                        <th>Total</th>
                                        <th>Proveedor</th>
                                        <th>Usuario</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="entrada in arrayEntrada" :key="entrada.id">
                                        <td v-text="entrada.num_fac"></td>
                                        <td v-text="entrada.fecha_hora"></td>
                                        <td v-text="entrada.iva"></td>
                                        <td v-text="entrada.total"></td>
                                        <td v-text="entrada.nomCom"></td>
                                        <td v-text="entrada.usuario"></td>
                                        <td v-text="entrada.estado"></td>
                                        <td>
                                            <button type="button" @click="obtenerDatos(entrada.id)" class="btn btn-warning btn-sm">
                                                <i class="icon-eye"></i>
                                            </button>&nbsp;
                                            <template v-if="entrada.estado=='Registrada'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarEntrada(entrada.id)">
                                                <i class="icon-close"></i>
                                                </button>
                                            </template>
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template>
                <!-- Fin del listado -->
                <!-- Inicio de detalles -->
                <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                           <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Proveedor(*)</label>                                                                 
                                        <select class="form-control" v-model="id_proveedor">                                         
                                            <option v-for="proveedor in arrayProveedor" :key="proveedor.id" :value="proveedor.id" v-text="proveedor.nomCom">
                                            </option>
                                        </select>                                
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Numero de Factura</label>
                                    <input type="text" class="form-control" v-model="num_fac" placeholder="Ingrese el número de la factura">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Iva </label>
                                    <input type="text" class="form-control" v-model="iva" placeholder="0.19">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorEntrada" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjEntrada" :key="error" v-text="error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Producto <span style="color:red;" v-show="id_producto==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="nombre" @keyup.enter="buscarProducto()" placeholder="Ingrese producto">
                                        <button @click="abrirModal()" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        <input type="text" readonly class="form-control" v-model="producto">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red;" v-show="cantidad==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad" placeholder="Ingrese la cantidad">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio <span style="color:red;" v-show="precio==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="precio" placeholder="Ingrese el precio del producto">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button @click="agregarDetalle()" class="btn btn-primary form-control btnagregar"><i class="icon-plus"></i> Agregar</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Opciones</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle_entradas,index) in arrayDetalle" :key="detalle_entradas.id">
                                            <td v-text="detalle_entradas.producto">
                                            </td>
                                            <td>
                                            <input v-model="detalle_entradas.cantidad" class="form-control" type="number">
                                            </td>
                                            <td>
                                                <input v-model="detalle_entradas.precio" class="form-control" type="number">
                                            </td>
                                            <!-- <td >
                                                $ {{detalle.precio*detalle.cantidad}}
                                            </td> -->
                                            <th > 
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn sm"><i class="icon-trash"></i></button>
                                                
                                            </th>
                                        </tr>   
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Subtotal</strong></td>
                                            <td colspan="2" align="left"> $ {{subTotal=(parseInt(total)-parseInt(totaliva))}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total iva</strong></td>
                                            <td colspan="2" align="left"> $ {{totaliva=((parseInt(subTotal)*iva))}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total</strong></td>
                                            <td colspan="2" align="left"> $ {{total=calcularTotal+parseInt(totaliva)}}</td>
                                        </tr>
                                        <!-- <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"> $ {{subTotal=(precio*cantidad)}}</td>
                                            <td colspan="2" align="left"><strong>Total parcial</strong></td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right">$ {{totaliva=((subTotal*0.19))}}</td>
                                            <td colspan="2" align="left"><strong>Total Iva</strong></td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right">$ {{total=parseInt(totaliva)+parseInt(subTotal)}}</td> 
                                            <td colspan="2" align="left"><strong>Total</strong></td>
                                        </tr> -->
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay productos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row float-right">
                            <div class="col-md-12 ">
                                <button type="button" @click="ocultarDetalle" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarEntrada()">Comprar</button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Fin de detalles -->
                <!-- Ver entrada -->
                <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Proveedor</label>
                                    <p v-text="proveedor"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Numero de Factura</label>
                                    <p v-text="num_fac"></p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Iva</label>
                                    <p v-text="iva"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalle_entradas in arrayDetalle" :key="detalle_entradas.id">
                                            <td v-text="detalle_entradas.producto"></td>
                                            <td v-text="detalle_entradas.cantidad"></td>
                                            <td v-text="detalle_entradas.precio"></td>
                                            <td>
                                            {{detalle_entradas.precio*detalle_entradas.cantidad}}
                                            </td>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total parcial</strong></td>
                                            <td colspan="2" align="left"> $ {{subTotal=(parseInt(total)-parseInt(totaliva))}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total iva</strong></td>
                                            <td colspan="2" align="left"> $ {{totaliva=((parseInt(subTotal)*iva))}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total</strong></td>
                                            <td colspan="2" align="left"> $ {{total=calcularTotal+parseInt(totaliva)}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay productos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row float-right">
                            <div class="col-md-12 ">
                                <button type="button" @click="ocultarDetalle" class="btn btn-secondary">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Fin de entrada -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div> 
        <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document"> 
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titulo"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioA">
                                    <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscarA" @keyup.enter="listarProducto(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProducto(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Marca</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                        <th>Opciones</th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="producto in arrayProducto" :key="producto.id">
                                        <td v-text="producto.nombre"></td>
                                        <td v-text="producto.marca"></td>
                                        <td v-text="producto.precio"></td>
                                        <td v-text="producto.stock"></td>                                        
                                        <td>
                                            <button type="button" @click="agregarDetalleModal(producto)" class="btn btn-success btn-sm">
                                            <i class="fa fa-mouse-pointer"></i>
                                            </button>
                                        </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="accion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="accion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                <!-- /.modal-content -->
                </div>
            <!-- /.modal-dialog -->
            </div>
        <!--Fin del modal-->
    </main>
</template>

<script>

    // import Toasted from 'vue-toasted';
    // import Vue from 'vue'
    // import vSelect from 'vue-select'
    // Vue.use(Toasted)
    // Vue.component('v-select', vSelect)

    export default {
        data ()
        {
            return {
                
                id_entrada:0,
                id_proveedor:0,
                id_producto:0,
                proveedor:'',
                nombre:'',
                num_fac:'',
                iva:0.19,
                totaliva:0,
                total:0,
                precio:0,
                cantidad:0,
                producto:'',
                proveedor:'',
                arrayEntrada:[],
                arrayDetalle:[],
                arrayProveedor:[],
                arrayProducto:[],
                listado:1,
                modal:0,
                titulo:'',
                accion:0,
                errorEntrada:0,
                errorMostrarMsjEntrada:[],
                pagination:{
                    'total':0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0,
                },
                offset:3,
                criterio:'num_fac',
                buscar:'',
                criterioA:'nombre',
                buscarA:'',
            }
        },
        // components: {
        //     vSelect
        // },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }
                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  
                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             
            },
            calcularTotal: function(){ //metodo para calcular el total de los productos agregados
                var resultado=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad) //multiplicacion de datos almacenados en las propiedades
                }
                return resultado;
            },
            //falta arreglar el ultimo resultado
        },
        methods : {
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarEntrada(page,buscar,criterio);
            },
            listarEntrada (page,buscar,criterio){
                let me=this;
                var url= '/entrada?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEntrada = respuesta.entradas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProveedor(){
                let me=this;
                
                var url= '/proveedor/selectProveedor';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    me.arrayProveedor = respuesta.proveedores;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            listarProducto: function (buscarA, criterioA) {
                let me = this;
                var url = "/producto/listarProducto?buscar=" + buscarA + '&criterio=' + criterioA;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayProducto = respuesta.productos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            buscarProducto(){
                let me=this;
                var url= '/producto/buscarProducto?filtro=' + me.nombre;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos;
                    if (me.arrayProducto.length>0){
                        me.producto=me.arrayProducto[0]['nombre'];
                        me.id_producto=me.arrayProducto[0]['id'];
                    }
                    else{
                        me.producto='No existe este producto';
                        me.id_producto=0;
                    }
                }).catch(function (error) {
                    console.log(error);
                });
            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        Swal.fire({
                            icon:'error',
                            title: 'Error',
                            text:'Este producto ya se agrego...'
                        })
                    }
                    else{
                        me.arrayDetalle.push({
                            id_producto: data['id'],
                            producto: data['nombre'],
                            cantidad: 0,
                            precio: 0,
                        }); 
                    }
            },
            encuentra(id){
                var dy=0
                for(var i=0;i<this.arrayDetalle.length;i++){ //blucle para recorrer todos los indices del array y comprobar si es igual y si existee
                if(this.arrayDetalle[i].id_producto==id){//si se encuentra el produc. que estoy recorriendo con el array la variable pasa a ser true
                    dy=true;
                    }
                }
                return dy;
            },
            agregarDetalle(){
                let me=this;
                if(me.id_producto==0 || me.cantidad==0 || me.precio==0){ //Para no hacer ninunga accion en caso de que este en cero
                }
                else{
                    if(me.encuentra(me.id_producto)){ //metodo para revisar si el artiuculo ya se encuentra en el detalle 
                        Swal.fire({
                            icon:'error',
                            title: 'Error',
                            text:'Este producto ya se agrego...'
                        })
                    }
                    else{
                    me.arrayDetalle.push({
                        id_producto: me.id_producto,
                        producto: me.producto,
                        cantidad: me.cantidad,
                        precio: me.precio
                    }); //Condicion para borrar datos de los input cuando se agreguen
                        
                        me.id_producto=0;
                        me.producto="";
                        me.cantidad=0;
                        me.precio=0; 
                    // this.mensajeToast();
                    }
                }
            },
            eliminarDetalle(index){ //Elimina producto agregado el index se agrega  en la tabla en la directiva v for
                let me = this;
                me.arrayDetalle.splice(index, 1);  //elimina uno solo
            },
            registrarEntrada(){
                if (this.validarEntrada()){
                    return;
                }
                let me = this;
                axios.post('/entrada/registrar',{
                    'num_fac' : this.num_fac,
                    'iva' : this.iva,
                    'total' : this.total,
                    'id_proveedor': this.id_proveedor,
                    'data': this.arrayDetalle
                }).then(function (response) {
                    me.listado=1;
                    me.listarEntrada(1,'','num_fac');
                    me.id_proveedor=0;
                    me.num_fac='';
                    me.iva=0.19;
                    me.total=0.0;
                    me.id_producto=0;
                    me.producto='';
                    me.cantidad=0;
                    me.precio=0;
                    me.arrayDetalle=[];
                    me.mensaje("¡Se facturo correctamente!");

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarEntrada(){
                this.errorEntrada=0;
                this.errorMostrarMsjEntrada =[];
                if (this.id_proveedor==0) this.errorMostrarMsjEntrada.push("Seleccione un Proveedor");
                if (this.num_fac==0) this.errorMostrarMsjEntrada.push("Ingrese el número de la factura");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjEntrada.push("Ingrese detalles");
                if (this.errorMostrarMsjEntrada.length) this.errorEntrada = 1;

                return this.errorEntrada;
            },
            abrirModal: function(){
                // this.arrayProducto=[];
                this.modal = 1;
                this.titulo = "Selecione uno o varios productos";
            },
            cerrarModal(){
                this.modal = 0;
                this.titulo = "";
            },
            mostrarDetalle(){ //Para borrar datos despues de cerrar
                let me=this
                me.listado=0;
                me.id_proveedor=0;
                me.num_fac=0;
                me.total=0;
                me.id_producto=0;
                me.producto='';
                me.cantidad=0;
                me.precio=0;
                me.arrayDetalle=[]; 
            },
            ocultarDetalle(){
                this.listado=1;
            },
            obtenerDatos(id){
                let me = this;
                me.listado=2;
                var arrayEntradaT=[];
                var url= '/entrada/obtenerDatos?id=' + id;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayEntradaT = respuesta.entradas;
                    me.proveedor=me.arrayEntradaT[0]['nombre'];
                    me.num_fac=me.arrayEntradaT[0]['num_fac'];
                    me.iva=me.arrayEntradaT[0]['iva'];
                    me.total=me.arrayEntradaT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });
                        
                var urld= '/entrada/obtenerDetalles?id=' + id;
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalle_entradas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            desactivarEntrada(id){
                Swal.fire({
                title: '¿Está seguro de anular esta compra?',
                text: '¡No podrá revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '¡No, cancelar!',
                confirmButtonText: '¡Si, anular!',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/entrada/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEntrada(1,'','num_fac');
                        Swal.fire(
                        '¡Anulada!',
                        'La compra ha sido anulado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.fire.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            mensaje(msj) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: msj,
                    showConfirmButton: false,
                    timer: 2000
                });
            },
            // mensajeToast() {
            //     let toast = this.$toasted.show(
            //         'Producto agregado', {
            //             theme: "bubble",
            //             duration :5000
            //         });
            // },
        },
        mounted() {
            this.listarEntrada(1,this.buscar,this.criterio);
            this.selectProveedor();
            this.listarProducto(this.buscarA,this.criterioA);
            
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 1.8rem;
        }
    }
</style>
