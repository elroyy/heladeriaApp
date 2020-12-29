<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item"><a href="#">Admin</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="container-fluid">
        <!-- Ejemplo de tabla Listado -->
        <div class="card">
            <div class="card-header">
                <h6>
                    <i class="fa fa-group"></i> Gestión de Clientes
                    <button type="button" class="btn btn-success btn-success" data-toggle="modal" @click="abrirModal('guardar')">
                        <i class="icon-plus"></i> &nbsp; Nuevo
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Nombre</option>
                            </select>
                                <input type="text" v-model="buscar" @keypress="listarCliente(1,buscar,criterio);" class="form-control" placeholder="Buscar texto">
                                <button type="submit"  @click="listarCliente(1,buscar,criterio);" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-sm">
                    <thead>
                        <tr>      
                            <th>Documento</th>
                            <th>Número</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>                           
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="objeto in arrayDatos" :key="objeto.id">
                            <td v-text="objeto.tipo_documento"></td>
                            <td v-text="objeto.num_documento"></td>
                            <td v-text="objeto.nombre"></td>
                            <td v-text="objeto.apellido"></td>
                            <td v-text="objeto.direccion"></td>
                            <td v-text="objeto.telefono"></td>
                        
                            <td>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" @click="abrirModal('editar', objeto)">
                                    <i class="icon-pencil"></i>
                                </button> &nbsp;
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" @click="eliminarCliente(objeto)">
                                    <i class="icon-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <nav class="nav">
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
        </div>
        <!-- Fin ejemplo de tabla Listado -->
    </div>
    <!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" id="modalNuevo" :class="{ mostrar: modal }" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-text="titulo"></h4>
                    <button type="button" class="close" @click="cerrarModal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Tipo de documento</label>
                                    <div class="col-md-4">
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="CC">CÉDULA DE CIUDADANÍA</option>
                                            <option value="PA">PASAPORTE</option>
                                            <option value="TI">TARJETA DE IDENTIDAD</option>
                                            <option value="CE">CÉDULA DE EXTRAJERÍA</option>
                                        </select>                                        
                                    </div>
                            <label class="col-md-2 form-control-label" for="text-input">Número de documento</label>
                            <div class="col-md-4">
                                <input type="text" v-model="num_documento" id="num_documento" name="num_documento" class="form-control" placeholder="Número de documento" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-10">
                                <input type="text" v-model="nombre" id="nombre" name="nombre" class="form-control" placeholder="Ingrese el nombre del cliente" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Apellidos</label>
                            <div class="col-md-10">
                                <input type="text" v-model="apellido" id="apellido" name="apellido" class="form-control" placeholder="Ingrese el apellido del cliente" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Dirección</label>
                            <div class="col-md-4">
                                <input type="text" v-model="direccion" id="direccion" name="direccion" class="form-control" placeholder="Dirección" />
                            </div>
                            <label class="col-md-2 form-control-label" for="text-input">Teléfono</label>
                            <div class="col-md-4">
                                <input type="text" v-model="telefono" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" />
                            </div>
                        </div>                        
                        
                        <div v-show="errorCliente" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjCliente" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="cerrarModal" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button v-show="accion == 0" type="button" @click="registrarCliente" class="btn btn-primary">Guardar </button>
                    <button v-show="accion" type="button" @click="actualizarCliente" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
<!-- Inicio del modal Eliminar -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none" aria-hidden="true">
        <div class="modal-dialog modal-danger" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Eliminar Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de eliminaar el registro?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cerrar
                    </button>
                    <button type="button" @click="eliminarCliente" class="btn btn-danger">
                        Eliminar
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- Fin del modal Eliminar -->
</main>
</template>

<script>
export default {
    data() {
        return {
            arrayDatos: [],
            id_cliente: 0,
            nombre: "",
            num_documento: "",
            tipo_documento:"",
            direccion: "",
            telefono: "",           
            apellido:"",           
            modal: 0,
            accion: 0,
            titulo: "",
            buscar: "",
            errorCliente:"",
            errorMostrarMsjCliente:"",
            pagination : {
                'total' : 0,
                'current_page' : 0,
                'per_page' : 0,
                'last_page' : 0,
                'from' : 0,
                'to' : 0,
            },
            offset : 3,
            criterio : 'nombre',
            buscar : ''
        }
    },
    methods: {
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Va a la pagina actual
            me.pagination.current_page = page;
            //metodo para traer los datos
            me.listarCliente(page, buscar, criterio);
        },
        listarCliente: function (page, buscar, criterio) {
            let me = this;
            var url = "/cliente?page=" + page + '&buscar='+ buscar + '&criterio='+ criterio;
            axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayDatos = respuesta.clientes.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },       
        registrarCliente(){
            if (this.validarCliente()){
                return;
            }
            
            let me = this;
            axios.post('/cliente/registrar',{
                'nombre': this.nombre,
                'tipo_documento': this.tipo_documento,
                'num_documento' : this.num_documento,
                'direccion' : this.direccion,
                'telefono' : this.telefono,
                'email' : this.email,
                'apellido' : this.apellido,
            }).then(function (response) {
                me.cerrarModal();
                me.listarCliente(1,'','nombre');
                me.mensaje("¡Se registró correctamente!");
            }).catch(function (error) {
                console.log(error);
            });
        },
        actualizarCliente(){
            if (this.validarCliente()){
                return;
            }
            let me = this;
            axios.put('/cliente/actualizar',{
                'nombre': this.nombre,
                'tipo_documento': this.tipo_documento,
                'num_documento' : this.num_documento,
                'direccion' : this.direccion,
                'telefono' : this.telefono,              
                'apellido' : this.apellido,
                'id': this.id_cliente,
            }).then(function (response) {
                me.cerrarModal();
                me.listarCliente(1,'','nombre');
                me.mensaje("¡Se actualizó correctamente!");
            }).catch(function (error) {
                console.log(error);
            }); 
        },
        eliminarCliente(data = []) {
        let me = this;
        Swal.fire({
                title: '¿Está seguro de eliminarlo?',
                text: '¡No podrás revertir esto!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '¡No, cancelar!',
                confirmButtonText: '¡Si, eliminar!',
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "/cliente/eliminar";
                axios
                    .post(url, {
                        id: data["id"],
                    })
                    .then(function (response) {
                        me.listarCliente(1, '', 'nombre');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                Swal.fire("¡Eliminado!", "El registro ha sido eliminado.", "success");
            }
        });
        },            
        validarCliente(){
            this.errorCliente=0;
            this.errorMostrarMsjCliente =[];
            if (!this.nombre) this.errorMostrarMsjCliente.push("El nombre del Cliente no puede estar vacío.");
            if (this.errorMostrarMsjCliente.length) this.errorCliente = 1;
            return this.errorCliente;
        },
        abrirModal(accion, data = []) {
            switch (accion) {
                case "guardar":
                    this.titulo = "Registrar Cliente";
                    this.accion = 0;
                    this.nombre= "";
                    this.tipo_documento="";
                    this.num_documento="";
                    this.direccion="";
                    this.telefono="";                                       
                    this.apellido="";
                    this.limpiar();
                    break;
                case "editar":
                    this.titulo = "Editar Cliente";
                    this.accion = 1;
                    this.id_cliente = data["id"];
                    this.num_documento = data["num_documento"];
                    this.nombre = data["nombre"];
                    this.direccion = data["direccion"];
                    this.telefono = data["telefono"];                   
                    this.tipo_documento = data["tipo_documento"];
                    this.apellido = data["apellido"];
                    break;
                default:
                    break;
            }
            this.modal = 1;
        },
        cerrarModal() {
            this.modal = 0;
            this.titulo='';
            this.nombre='';
            this.tipo_documento='';
            this.num_documento='';
            this.direccion='';
            this.telefono='';
            this.email='';
            this.apellido='',
            this.errorCliente=0;
        },
        limpiar() {
            this.nombre = "";
            this.id_cliente = "";
            this.num_documento = "";
            this.apellidos = "";
            this.direccion = "";
            this.telefono = "";           
            this.tipo_documento = "";
            this.apellido = "";
        },
        mensaje(msj) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: msj,
                showConfirmButton: false,
                timer: 2000
            });
        }
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        //Calcula los elementos de la paginación
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + this.offset * 2;
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },
    mounted() {
        console.log("Component mounted.");
        this.listarCliente(1, this.buscar, this.criterio);

    }
};
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
</style>
