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
                    <h6> <i class="icon-calculator"></i> Gestión de Ventas
                    <button type="button" @click="mostrarDetalle()" class="btn btn-success">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                    </h6>
                </div>
                <!-- Listado-->
                <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="num_fac">Número Factura</option>
                                        <option value="fecha_hora">Fecha-Hora</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarFactura(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarFactura(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>      
                                        <th>Usuario</th>
                                        <th>Cliente</th>
                                        <th>Número Factura</th>
                                        <th>Fecha Hora</th>
                                        <th>Total</th>
                                        <th>Iva</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="factura in arrayFactura" :key="factura.id">
                                        <td v-text="factura.usuario"></td>
                                        <td v-text="factura.nomCom"></td>
                                        <td v-text="factura.num_fac"></td>
                                        <td v-text="factura.fecha_hora"></td>
                                        <td v-text="factura.total"></td>
                                        <td v-text="factura.iva"></td>
                                        <td v-text="factura.estado"></td>
                                        <td>
                                            <button type="button" @click="verFactura(factura.id)" class="btn btn-warning btn-sm">
                                            <i class="icon-eye"></i>
                                            </button>&nbsp;
                                            <template v-if="factura.estado=='Registrado'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarFactura(factura.id)">
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
                <!--Fin Listado-->
                <!-- Detalle-->
                <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Cliente(*)</label>                                                                 
                                        <select class="form-control" v-model="id_cliente">                                         
                                            <option v-for="cliente in arrayCliente" :key="cliente.id" :value="cliente.id" v-text="cliente.nombre">
                                            </option>
                                        </select>                                
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Numero de Factura(*)</label>
                                    <input type="text" class="form-control" v-model="num_fac" placeholder="Número de factura">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="">Iva(*)</label>
                                <input type="text" class="form-control" v-model="iva">
                            </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorFactura" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjFactura" :key="error" v-text="error">
                                        </div>
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
                                        <button @click="abrirModal()" class="btn btn-primary"> <i class="fa fa-search"></i> </button>
                                        <input  type="text" readonly class="form-control col-md-4" v-model="producto">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad <span style="color:red;" v-show="cantidad==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidad">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio <span style="color:red;" v-show="precio==0">(*Ingrese)</span></label>
                                    <input type="number" value="0" step="any" class="form-control" v-model="precio">
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
                                            <th>Subtotal</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalles,index) in arrayDetalle" :key="detalles.id">
                                            <td v-text="detalles.producto">
                                            </td>
                                            <td>
                                            <input v-model="detalles.cantidad" class="form-control" type="number">
                                            </td>
                                            <td>
                                                <input v-model="detalles.precio" class="form-control" type="number">
                                            </td>
                                            <td >
                                                $ {{detalles.precio*detalles.cantidad}}
                                            </td>
                                            <th > 
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn sm"><i class="icon-trash"></i></button>                                            
                                            </th>
                                        </tr>   
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
                                            <td colspan="6">
                                                No hay productos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row float-right">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarFactura()">Registrar Venta</button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Fin Detalle-->
                <!-- Ver ingreso -->
                <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Fecha-Hora:</label>
                                    <p v-text="fecha_hora"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Número Factura:</label>
                                    <p v-text="num_fac"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Cliente:</label>
                                    <p v-text="cliente"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Iva:</label>
                                <p v-text="iva"></p>
                            </div>        
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Facturado por:</label>
                                    <p v-text="usuario"></p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="detalles in arrayDetalle" :key="detalles.id">
                                            <td v-text="detalles.producto"></td>
                                            <td v-text="detalles.precio"></td>                                
                                            <td v-text="detalles.cantidad"></td>                                       
                                            <td>
                                                {{detalles.precio*detalles.cantidad}}
                                                </td>
                                            </tr>
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
                                                NO hay productos agregados
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class=" float-right form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar <i class="fa fa-remove"></i> </button>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- fin ver ingreso -->
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
                                <span aria-hidden="true">×</span>
                        </button>
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
        data (){
            return {
                id_factura:0,
                id_cliente:0,
                cliente:'',
                num_fac:'',
                iva:0.19,
                usuario:'',
                fecha_hora:'',
                total:0,
                precio:0,
                cantidad:0,
                totaliva:0,
                subTotal:0,
                arrayFactura:[],
                arrayCliente:[],
                arrayDetalle:[],                
                arrayProducto:[],
                listado:1,
                id_producto:0,
                producto: '',
                cantidad:0,
                nombre:'',
                stock:0,
                modal : 0,
                titulo : '',
                accion : 0,
                errorFactura : 0,
                errorMostrarMsjFactura : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'num_fac',
                buscar : '',
                criterioA:'nombre',
                buscarA: '',
            }
        },
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
        },
        methods : {
            listarFactura (page,buscar,criterio){
                let me=this;
                var url= '/factura?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayFactura = respuesta.facturas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCliente(){
                let me=this;

                var url= '/cliente/selectCliente';
                axios.get(url).then(function (response) {
                    let respuesta = response.data;

                    me.arrayCliente=respuesta.clientes;
                    // loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
                if(me.arrayCliente.length>0){
                    me.cliente=me.arrayCliente[0]['nombre'];
                } 
            },
            buscarProducto(){
                let me=this;
                var url= '/producto/buscarProductoVenta?filtro=' + me.nombre;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos;
                    if (me.arrayProducto.length>0){
                        me.producto=me.arrayProducto[0]['nombre'];
                        me.id_producto=me.arrayProducto[0]['id'];
                        me.precio=me.arrayProducto[0]['precio'];
                        me.stock=me.arrayProducto[0]['stock'];
                        me.marca=me.arrayProducto[0]['marca'];
                    }
                    else{
                        me.producto='No existe producto';
                        me.id_producto=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarFactura(page,buscar,criterio);
            },
            encuentra(id){
                var dy=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].id_producto==id){
                        dy=true;
                    }
                }
                return dy;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){
                let me=this;
                if(me.id_producto==0 || me.cantidad==0 || me.precio==0){
                }
                else{
                    if(me.encuentra(me.id_producto)){
                         Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Ese producto ya se encuentra agregado!',
                            })
                    }
                    else{
                        if(me.cantidad>me.stock){
                         Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'NO hay stock disponible!',
                            })
                        } 
                        else{
                            me.arrayDetalle.push({
                                id_producto: me.id_producto,
                                producto: me.producto,
                                cantidad: me.cantidad,
                                precio: me.precio,
                                stock: me.stock
                            });
                            me.id_producto=0;
                            me.producto="";
                            me.cantidad=0;
                            me.precio=0;
                            me.stock=0
                            // this.mensajeToast();
                        }
                    }
                    
                }
            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                         Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Ese producto ya se encuentra agregado!',
                            })
                    }
                    else{
                        me.arrayDetalle.push({
                            id_producto: data['id'],
                            producto: data['nombre'],
                            cantidad: 1,
                            precio: data['precio'],
                            stock:data['stock']
                        }); 
                    }
            },
            listarProducto (buscarA,criterioA){
                let me=this;
                var url= '/producto/listarProductoVenta?buscar='+ buscarA + '&criterio='+ criterioA;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarFactura(){
                if (this.validarFactura()){
                    return;
                }
                let me = this;
                axios.post('/factura/registrar',{
                    'num_fac' : this.num_fac,
                    'iva' : this.iva,
                    'total' : this.total,
                    'id_cliente': this.id_cliente,
                    'data': this.arrayDetalle
                }).then(function (response) {
                    me.listado=1;
                    me.listarFactura(1,'','num_fac');
                    me.id_cliente=0;
                    me.num_fac='';
                    me.iva=0.19;
                    me.total=0;
                    me.id_producto=0;
                    me.producto='';
                    me.cantidad=0;
                    me.precio=0;
                    me.stock=0;
                    me.arrayDetalle=[];
                    me.mensaje("¡Se facturo correctamente!");
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarFactura(){
                let me=this;
                me.errorFactura=0;
                me.errorMostrarMsjFactura =[];
                var prod;
                me.arrayDetalle.map(function(x){
                    if (x.cantidad>x.stock){
                        prod=x.producto + " con stock insuficiente";
                        me.errorMostrarMsjFactura.push(prod);
                    }
                });
                if (!me.id_cliente) me.errorMostrarMsjFactura.push("Seleccione un Cliente");
                if (!me.num_fac) me.errorMostrarMsjFactura.push("Ingrese el número de la factura");
                if (!me.iva) me.errorMostrarMsjFactura.push("Ingrese el iva de compra");            
                if (me.arrayDetalle.length<=0) me.errorMostrarMsjFactura.push("Ingrese detalles");
                if (me.errorMostrarMsjFactura.length) me.errorFactura = 1;
                return me.errorFactura;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;
                me.id_proveedor=0;
                me.num_fac='';
                me.iva=0.19;
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
            verFactura(id){
                let me=this;
                me.listado=2;
                //Obtener los datos del ingreso
                var arrayFacturaT=[];
                var url= '/factura/obtenerDatos?id=' + id;        
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayFacturaT = respuesta.facturas;
                    me.cliente = me.arrayFacturaT[0]['nombre'];
                    me.num_fac=me.arrayFacturaT[0]['num_fac'];
                    me.iva=me.arrayFacturaT[0]['iva'];
                    me.total=me.arrayFacturaT[0]['total'];
                    me.usuario=me.arrayFacturaT[0]['usuario'];
                    me.fecha_hora=me.arrayFacturaT[0]['fecha_hora'];
                })
                .catch(function (error) {
                    console.log(error);
                });
                var url= '/factura/obtenerDetalles?id=' + id;
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
            cerrarModal(){
                this.modal=0;
                this.titulo='';
            }, 
            abrirModal:function () {            
                // this.arrayProducto=[];
                this.modal = 1;
                this.titulo = 'Seleccione uno o varios productos';
            },
            desactivarFactura(id){
               Swal.fire({
                title: '¿Está seguro de anular esta factura?',
                text: '¡No podrás revertir esto!',
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
                    axios.put('/factura/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarFactura(1,'','num_fac');
                        Swal.fire(
                        'Anulado!',
                        'La factura ha sido anulada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });                                    
                } else if (                  
                    result.dismiss === swal.DismissReason.cancel
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
            this.listarFactura(1,this.buscar,this.criterio);
            this.selectCliente();
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
