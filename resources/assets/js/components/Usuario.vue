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
                        <h6><i class="fa fa-user-circle"></i> Gestión de Empleados
                        <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-success">
                            <i class="icon-plus"></i>&nbsp;Agregar
                        </button>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                        <option value="nombre">Nombre</option>
                                        <option value="num_documento">Documento</option>
                                        <option value="email">Email</option>
                                        <option value="telefono">Teléfono</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>      
                                    <th>Nombre</th>
                                    <th>Documento</th>
                                    <th>Número</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Sucursal</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td v-text="persona.nombre"></td>
                                    <td v-text="persona.tipo_documento"></td>
                                    <td v-text="persona.num_documento"></td>
                                    <td v-text="persona.direccion"></td>
                                    <td v-text="persona.telefono"></td>
                                    <td v-text="persona.email"></td>
                                    <td v-text="persona.usuario"></td>
                                    <td v-text="persona.rol"></td>
                                    <td v-text="persona.sucursal"></td>
                                    <td>
                                        <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm">
                                            <i class="icon-pencil"></i>
                                        </button>&nbsp;
                                        <button type="button" class="btn btn-danger btn-sm" @click="eliminarPersona(persona)"><i class="icon-trash"></i>
                                        </button>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
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
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">Nombre (*)</label>
                                    <div class="col-md-10">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la persona">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">Tipo Documento</label>
                                    <div class="col-md-4">
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="CC">CÉDULA DE CIUDADANÍA</option>
                                            <option value="PA">PASAPORTE</option>
                                            <option value="TI">TARJETA DE IDENTIDAD</option>
                                            <option value="CE">CÉDULA DE EXTRAJERÍA</option>
                                        </select>                                    
                                    </div>                        
                                    <label class="col-md-2 form-control-label" for="text-input">Número</label>
                                    <div class="col-md-4">
                                        <input type="text" v-model="num_documento" class="form-control" placeholder="Número de documento">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="email-input">Dirección</label>
                                    <div class="col-md-10">
                                        <input type="text" v-model="direccion" class="form-control" placeholder="Dirección">
                                    </div>
                                </div>                            
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="email-input">Teléfono</label>
                                    <div class="col-md-10">
                                        <input type="text" v-model="telefono" class="form-control" placeholder="Teléfono">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="email-input">Email</label>
                                    <div class="col-md-10">
                                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="email-input">Rol (*)</label>
                                    <div class="col-md-4">
                                        <select class="form-control" v-model="id_rol">                                        
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre">
                                            </option>
                                        </select>
                                    </div>
                                    <label class="col-md-2 form-control-label" for="email-input">Sucursal (*)</label>
                                    <div class="col-md-4">
                                        <select class="form-control" v-model="id_sucursal">                                         
                                            <option v-for="sucursal in arraySucursal" :key="sucursal.id" :value="sucursal.id" v-text="sucursal.nombre">
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="email-input">Usuario (*)</label>
                                    <div class="col-md-10">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Nombre de usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="email-input">Password (*)</label>
                                    <div class="col-md-10">
                                        <input type="password" v-model="password" class="form-control" placeholder="Password de acceso">
                                    </div>
                                </div>
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Eliminar User</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>¿Estás seguro de eliminar el registro?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Cerrar
                            </button>
                            <button type="button" @click="eliminarPersona" class="btn btn-danger">
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
        data (){
            return {
                id_persona: 0,
                nombre : '',
                tipo_documento : '',
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                usuario : '',
                password : '',
                id_rol : 0,
                id_sucursal:0,
                arrayPersona : [],
                arrayRol : [],
                arraySucursal : [],
                modal : 0,
                titulo : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
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

            }
        },
        methods : {
            listarPersona (page,buscar,criterio){
                let me=this;
                var url= '/user?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectRol(){
                let me=this;
                var url= '/rol/selectRol';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectSucursal(){
                let me=this;
                var url= '/sucursal/selectSucursal';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySucursal = respuesta.sucursales;
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
                me.listarPersona(page,buscar,criterio);
            },
            registrarPersona(){
                if (this.validarPersona()){
                    return;
                }
                let me = this;
                axios.post('/user/registrar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'id_rol' : this.id_rol,
                    'id_sucursal' : this.id_sucursal,
                    'usuario': this.usuario,
                    'password': this.password
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                    me.mensaje("¡Se registró correctamente!");
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPersona(){
                if (this.validarPersona()){
                    return;
                }                
                let me = this;
                axios.put('/user/actualizar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'id_rol' : this.id_rol,
                    'id_sucursal' : this.id_sucursal,
                    'usuario': this.usuario,
                    'password': this.password,
                    'id': this.id_persona
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                    me.mensaje("¡Se actualizó correctamente!");
                }).catch(function (error) {
                    console.log(error);
                }); 
            },           
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.nombre) this.errorMostrarMsjPersona.push("El nombre de la persona no puede estar vacío.");
                if (!this.usuario) this.errorMostrarMsjPersona.push("El nombre de usuario no puede estar vacío.");
                if (!this.password) this.errorMostrarMsjPersona.push("El password no puede estar vacío.");
                if (this.id_rol==0) this.errorMostrarMsjPersona.push("Debes seleccionar un rol para el usuario.");

                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            abrirModal(modelo, accion, data = []){
                this.selectRol();
                  this.selectSucursal();
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.titulo = 'Registrar Usuario';
                                this.nombre= '';
                                this.tipo_documento='';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.usuario='';
                                this.password='';
                                this.id_rol=0;   
                                this.id_sucursal=0;                         
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.titulo='Actualizar Usuario';
                                this.tipoAccion=2;
                                this.id_persona=data['id'];
                                this.nombre = data['nombre'];
                                this.tipo_documento = data['tipo_documento'];
                                this.num_documento = data['num_documento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                this.usuario = data['usuario'];
                                // this.password = data['password'];
                                this.id_rol = data['id_rol'];
                                 this.id_sucursal = data['id_sucursal'];
                                break;
                            }
                        }
                    }
                }
            },
            cerrarModal(){
                this.modal=0;
                this.titulo='';
                this.nombre='';
                this.tipo_documento='';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.usuario='';
                this.password='';
                this.id_rol=0;
                this.id_sucursal=0;
                this.errorPersona=0;
            },
        limpiar() {
            this.nombre = "";
            this.num_documento = "";
            this.apellidos = "";
            this.direccion = "";
            this.telefono = "";
            this.email = "";
            this.tipo_documento = "";
            this.id_rol = "";
             this.id_sucursal="";
            this.password = "";
            this.usuario = "";
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
        eliminarPersona(data = []) {
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
        }).then(result => {
            if (result.isConfirmed) {
                var url = "/user/eliminar";
                axios
                    .post(url, {
                        id: data["id"]
                    })
                    .then(function (response) {
                        me.listarPersona(1, '', 'nombre');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                Swal.fire(
                    "¡Eliminado!",
                    "El dato ha sido eliminado.",
                    "success")
                }
            })
        },
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
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
</style>
