<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <title>Library</title>
</head>
<body>
  <div id="app">
    <template>
      <v-app id="inspire">
        <v-navigation-drawer
          v-model="drawer"
          app
          absolute
          temporary
        >
        <v-list>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="font-weight-bold">Menú</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      <v-divider></v-divider>
          <v-list-item
            v-for="item in items"
            :key="item.title"
            link
          >
            <v-list-item-icon>
              <v-icon color="#9d7a13">{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content @click="seteaMenu(item.opt)">
              <v-list-item-title class="font-weight-medium">{{ item.title }}</v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list>
        </v-navigation-drawer>

        <v-app-bar app color="#1b396a" dark>
          <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>

          <v-toolbar-title>Library</v-toolbar-title>
        </v-app-bar>

        <v-main>
          <v-container>
          <!--Panel Inicial-->
          <v-row align="start" fluid v-show="viewerPanel">
            <v-container fluid>
              <v-row dense>
                <v-row
                  align="center"
                  justify="center">
                  <img src="https://www3.gobiernodecanarias.org/medusa/edublog/ceipprincipefelipe/wp-content/uploads/sites/486/2020/09/kisspng-book-reading-library-icon-books-vector-5aa978ed348ca0-3216120615210559812153.png" width="50%" height="100%">
                </v-row>
              </v-row>
            </v-container>
          </v-row>
          <!--Fin Panel Inicial -->
          <!--Panel Usuarios-->
          <v-row align="start" v-show="viewerUsuarios">
            <v-flex md12>
                <v-card>
                  <v-card-title>
                    <v-icon color="#9d7a13" size="25">mdi-account</v-icon> 
                    Catálogo de Usuarios
                    <v-divider
                      class="mx-4"
                      inset
                      vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                      v-model="searchUsuario"
                      append-icon="mdi-magnify"
                      label="Buscador"
                      hint="Puedes buscar por cualquier dato del usuario"
                    ></v-text-field>
                  </v-card-title>
                  <v-col cols="12">
                  <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn small
                          color="success"
                          class="white--text"
                          v-on="on"
                          @click="dialogAddUsuario = true"
                        >
                        <v-icon left dark>mdi-plus-circle</v-icon>
                          Agregar
                        </v-btn>
                      </template>
                      <span>Agregar Usuario</span>
                    </v-tooltip>
                    &nbsp;
                    <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn small
                          color="#607D8B"
                          class="white--text"
                          v-on="on"
                          @click="getListUsuarios"
                        >
                        <v-icon left dark>mdi-refresh</v-icon>
                          Actualizar
                        </v-btn>
                      </template>
                      <span>Actualizar</span>
                    </v-tooltip>
                  </v-col>
                  <v-data-table
                    :headers="headerUsuario"
                    :items="rowDataUsuario"
                    :search="searchUsuario"
                  >
                    <template v-slot:item.actions="{ item }">
                      <v-tooltip right>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon
                            class="mr-2"
                            color="#1b396a"
                            v-on="on"
                            @click="openModalUpdateUsuario(item)"
                          >
                            mdi-pencil
                          </v-icon>
                        </template>
                        <span>Editar</span>
                      </v-tooltip>
                      <v-tooltip right>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon
                          class="mr-2"
                          color="red"
                          v-on="on"
                          @click="openDeleteUsuario(item)"
                          >
                            mdi-delete
                          </v-icon>
                        </template>
                        <span>Eliminar Usuario</span>
                      </v-tooltip>
                    </template>
                  </v-data-table>
                </v-card>
            </v-flex>
          </v-row>

          <v-dialog v-model="dialogAddUsuario" persistent max-width="40%">
            <v-card>
              <v-card-title class="blue-grey darken-1 py-4 white--text">
                <span style="font-size: 1em" v-show="idUsuario == null">
                  <v-icon left dark>mdi-plus-circle</v-icon> Agregar Usuario
                </span>
                <span style="font-size: 1em" v-show="idUsuario != null">
                <v-icon left dark>mdi-pencil</v-icon> Editar Usuario
                </span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field label="Nombre del Usuario" prepend-icon="mdi-account" v-model="nombreUsuario" counter="250" maxlength="250" :rules="onlyLetter"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field label="Email" prepend-icon="mdi-email" v-model="mailUser" counter="250" maxlength="250" :rules="validaMail"></v-text-field>
                    </v-col>             
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" text @click="closeModalAddUsuario">Cerrar</v-btn>
                  <v-btn color="success" text @click="saveUsuario" v-show="idUsuario == null">
                    <span>Guardar</span>
                  </v-btn>
                  <v-btn color="success" text @click="updateUsuario" v-show="idUsuario != null">
                    <span>Guardar Cambios</span>
                  </v-btn>
              </v-card-actions>
              </v-card>
          </v-dialog>

          <!-- Fin Panel Usuarios-->

          <!--Panel Categorias-->
          <v-row align="start" v-show="viewerCategorias">
            <v-flex md12>
                <v-card class="mt-3">
                  <v-card-title>
                  <v-icon color="#9d7a13" size="25">mdi-bookshelf</v-icon>
                    Catálogo de Categorias 
                    <v-divider
                      class="mx-4"
                      inset
                      vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                      v-model="searchCategoria"
                      append-icon="mdi-magnify"
                      label="Buscador"
                      hint="Puedes buscar por cualquier dato de la categoria"
                    ></v-text-field>
                  </v-card-title>
                  <v-col cols="12">
                    <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn small
                          color="success"
                          class="white--text"
                          v-on="on"
                          @click="dialogAddCategoria = true"
                        >
                        <v-icon left dark>mdi-plus-circle</v-icon>
                          Agregar
                        </v-btn>
                      </template>
                      <span>Agregar Categoria</span>
                    </v-tooltip>
                    &nbsp;
                    <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn small
                          color="#607D8B"
                          class="white--text"
                          v-on="on"
                          @click="getListCategorias"
                        >
                        <v-icon left dark>mdi-refresh</v-icon>
                          Actualizar
                        </v-btn>
                      </template>
                      <span>Actualizar</span>
                    </v-tooltip>
                    </v-col>
                  <v-data-table
                    :headers="headerCategorias"
                    :items="rowDataCategorias"
                    :search="searchCategoria"
                  >
                    <template v-slot:item.actions="{ item }">
                      <v-tooltip right>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon
                            class="mr-2"
                            color="#1b396a"
                            v-on="on"
                            @click="openModalUpdateCategoria(item)"
                          >
                            mdi-pencil
                          </v-icon>
                        </template>
                        <span>Editar</span>
                      </v-tooltip>
                      <v-tooltip right>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon
                          class="mr-2"
                          color="red"
                          v-on="on"
                          @click="openDeleteCategoria(item)"
                          >
                            mdi-delete
                          </v-icon>
                        </template>
                        <span>Eliminar Materia</span>
                      </v-tooltip>
                    </template>
                  </v-data-table>
                </v-card>
            </v-flex>
          </v-row>

          <v-dialog v-model="dialogAddCategoria" persistent max-width="40%">
            <v-card>
              <v-card-title class="blue-grey darken-1 py-4 white--text">
                <span style="font-size: 1em" v-show="idCategoria == null">
                  <v-icon left dark>mdi-plus-circle</v-icon> Agregar Categoria
                </span>
                <span style="font-size: 1em" v-show="idCategoria != null">
                <v-icon left dark>mdi-pencil</v-icon> Editar Categoria
                </span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field label="Nombre" prepend-icon="mdi-bookshelf" v-model="nombreCategoria" counter="250" maxlength="250" :rules="onlyLetter"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field label="Descripción" prepend-icon="mdi-card-text" v-model="descripcionCategoria" counter="250" maxlength="250"></v-text-field>
                    </v-col>            
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" text @click="closeModalAddCategoria">Cerrar</v-btn>
                  <v-btn color="success" text @click="saveCategoria" v-show="idCategoria == null">
                    <span>Guardar</span>
                  </v-btn> 
                  <v-btn color="success" text @click="updateCategoria" v-show="idCategoria != null">
                    <span>Guardar Cambios</span>
                  </v-btn>
              </v-card-actions>
              </v-card>
          </v-dialog>
          <!-- Fin Panel Categorias-->

          <!--Panel Libros-->
          <v-row align="start" v-show="viewerLibros">
            <v-flex md12>
                <v-card class="mt-3">
                  <v-card-title>
                  <v-icon color="#9d7a13" size="25">mdi-book-open-blank-variant</v-icon> Libros
                  <v-divider
                      class="mx-4"
                      inset
                      vertical
                    ></v-divider>
                    <v-spacer></v-spacer>
                    <v-text-field
                      v-model="searchALibros"
                      append-icon="mdi-magnify"
                      label="Buscador"
                      hint="Puedes buscar por cualquier dato de los libros"
                    ></v-text-field>
                  </v-card-title>
                  <v-col cols="12">
                  <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn small
                          color="success"
                          class="white--text"
                          v-on="on"
                          @click="dialogAddLibro = true"
                        >
                        <v-icon left dark>mdi-plus-circle</v-icon>
                          Agregar
                        </v-btn>
                      </template>
                      <span>Agregar Asignación</span>
                    </v-tooltip>
                    &nbsp;
                    <v-tooltip top>
                      <template v-slot:activator="{ on, attrs }">
                        <v-btn small
                          color="#607D8B"
                          class="white--text"
                          v-on="on"
                          @click="getList"
                        >
                        <v-icon left dark>mdi-refresh</v-icon>
                          Actualizar
                        </v-btn>
                      </template>
                      <span>Actualizar</span>
                    </v-tooltip>
                  </v-col>
                  <v-data-table
                    :headers="headerLibro"
                    :items="rowDataLibros"
                    :search="searchALibros"
                  >
                    <template v-slot:item.actions="{ item }">
                      <v-tooltip right>
                        <template v-slot:activator="{ on, attrs }">
                          <v-icon
                          class="mr-2"
                          color="red"
                          v-on="on"
                          @click="openDeleteLibro(item)"
                          >
                            mdi-delete
                          </v-icon>
                        </template>
                        <span>Eliminar Asignación</span>
                      </v-tooltip>
                    </template>
                  </v-data-table>
                </v-card>
            </v-flex>
          </v-row>
          <!-- Fin Panel Libros-->

          <v-dialog v-model="dialogAddLibro" persistent max-width="40%">
            <v-card>
              <v-card-title class="blue-grey darken-1 py-4 white--text">
                <span style="font-size: 1em" >
                  <v-icon left dark>mdi-plus-circle</v-icon> Agregar Libro
                </span>
              </v-card-title>
              <v-card-text>
                <v-container>
                  <v-row>
                  <v-col cols="12" sm="12" md="12">
                      <v-text-field label="Nombre" prepend-icon="mdi-bookshelf" v-model="nombreLibro" counter="250" maxlength="250" :rules="onlyLetter"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-text-field label="Autor" prepend-icon="mdi-bookshelf" v-model="autor" counter="250" maxlength="250" :rules="onlyLetter"></v-text-field>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-autocomplete placeholder="Categoria" :items="rowDataCategorias"  item-text="name" item-value="id" prepend-icon="mdi-account" v-model="idCategoria"></v-autocomplete>
                    </v-col>
                    <v-col cols="12" sm="12" md="12">
                      <v-menu
                        v-model="menu2"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        transition="scale-transition"
                        offset-y
                        min-width="auto"
                      >
                        <template v-slot:activator="{ on, attrs }">
                          <v-text-field
                            v-model="date"
                            label="Fecha de Publicación"
                            prepend-icon="mdi-calendar"
                            readonly
                            v-bind="attrs"
                            v-on="on"
                          ></v-text-field>
                        </template>
                        <v-date-picker
                          v-model="date"
                          @input="menu2 = false"
                          locale="es"
                        ></v-date-picker>    
                    </v-col> 
                    <v-col cols="12" sm="12" md="12">
                      <v-autocomplete placeholder="Usuario Que Prestó el libro" :items="rowDataUsuario"  item-text="name" item-value="id" prepend-icon="mdi-bookshelf" v-model="idUsuario"></v-autocomplete>
                    </v-col>  
                  </v-row>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="red" text @click="closeModalAddLibro">Cerrar</v-btn>
                  <v-btn color="success" text @click="saveLibro">
                    <span>Guardar</span>
                  </v-btn>     
              </v-card-actions>
              </v-card>
          </v-dialog>
          
          </v-container>
          <v-snackbar
            v-model="snackbar"
            top
            :color="colorSnack"
            :timeout="timeout"
          >
            {{ textSnack }}

            <template v-slot:action="{ attrs }">
              <v-btn
                color="re"
                text
                v-bind="attrs"
                @click="snackbar = false"
              >
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </template>
          </v-snackbar>
          <v-dialog v-model="dialogMensajeUsuario" persistent max-width="290">
            <v-card>
              <v-card-title class="headline">Eliminar Usuario</v-card-title>
                <v-card-text>El Usuario # {{idUsuario}} será eliminado ¿Desea Continuar?</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red" text @click="closeModalEstatusUsuario">Cancelar</v-btn>
                    <v-btn color="green" text @click="deleteUsuario">Aceptar</v-btn>
                  </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogMensajeCategoria" persistent max-width="290">
            <v-card>
              <v-card-title class="headline">Eliminar Categoria</v-card-title>
                <v-card-text>La Categoria # {{idCategoria}} será eliminada ¿Desea Continuar?</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red" text @click="closeModalEstatusCategoria">Cancelar</v-btn>
                    <v-btn color="green" text @click="deleteCategoria">Aceptar</v-btn>
                  </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogMensajeLibro" persistent max-width="290">
            <v-card>
              <v-card-title class="headline">Eliminar Libro</v-card-title>
                <v-card-text>El libro # {{idLibro}} será eliminada ¿Desea Continuar?</v-card-text>
                  <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red" text @click="closeModalEstatusLibro">Cancelar</v-btn>
                    <v-btn color="green" text @click="deleteLibros">Aceptar</v-btn>
                  </v-card-actions>
            </v-card>
          </v-dialog>
        </v-main>
      </v-app>
    </template>
  </div>

 
  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>

  <script>
    new Vue({
      el: '#app',
      vuetify: new Vuetify(),
      data: () => ({
        drawer: false,
        items: [
          { title: 'Usuarios', icon: 'mdi-account', opt: 1 },
          { title: 'Categorias', icon: 'mdi-bookshelf', opt: 2  },
          { title: 'Libros', icon: 'mdi-book-open-blank-variant', opt: 3  },
        ],
        viewerPanel: true,
        viewerUsuarios: false,
        viewerCategorias: false,
        viewerLibros: false,
        urlRoot: 'http://localhost/library/index.php/',
        dialogAddUsuario: false,
        date: (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10),
        menu2: false,
        mailUser: null,
        nombreUsuario: null,
        validaMail: [ v => /.+@.+/.test(v) || 'Ingrese un correo válido' ],
        onlyLetter: [v => /[a-zA-Z]+$/.test(v) || 'Ingrese solo letras'],
        dialogAddCategoria: false,
        nombreCategoria: null,
        descripcionCategoria: null,
        headerUsuario: [
          {text: 'ID',align: 'start', value: 'id', class: ['blue-grey darken-1', 'white--text']},
          { text: 'NOMBRE', value: 'name', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'EMAIL', value: 'email', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'OPCIONES', value: 'actions', sortable: false, class: ['blue-grey darken-1', 'white--text'] }
        ],
        rowDataUsuario: [],
        searchUsuario: '',
        idUsuario: null,
        dialogMensajeUsuario: false,
        headerCategorias: [
          {text: 'ID',align: 'start', value: 'id', class: ['blue-grey darken-1', 'white--text']},
          { text: 'NOMBRE', value: 'name', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'DESCRIPCION', value: 'description', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'OPCIONES', value: 'actions', sortable: false, class: ['blue-grey darken-1', 'white--text'] }
        ],
        rowDataCategorias: [],
        searchCategoria: '',
        idCategoria: null,
        dialogMensajeCategoria: false,
        headerLibro: [
          {text: 'ID',align: 'start', value: 'id', class: ['blue-grey darken-1', 'white--text']},
          { text: 'NOMBRE', value: 'name', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'AUTOR', value: 'author', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'CATEGORIA', value: 'categoria', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'FECHA PUBLICACIÓN', value: 'publish_date', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'ESTATUS', value: 'estatus_text', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'USUARIO', value: 'usuario', class: ['blue-grey darken-1', 'white--text'] },
          { text: 'OPCIONES', value: 'actions', sortable: false, class: ['blue-grey darken-1', 'white--text'] }
        ],
        rowDataLibros: [],
        searchALibros: '',
        dialogAddLibro: false,
        dialogMensajeLibro: false,
        idLibro: null,
        nombreLibro: null,
        autor: null,
        /////////////////////////
        snackbar: false,
        colorSnack: '',
        textSnack: '',
        timeout: 3000
      }),
      methods: {
        seteaMenu(opt) {
          if(opt == 1){
            vm.viewerPanel = false
            vm.viewerUsuarios = true
            vm.viewerCategorias = false
            vm.viewerLibros = false
            vm.drawer = false
          }
          if(opt == 2){
            vm.viewerPanel = false
            vm.viewerUsuarios = false
            vm.viewerCategorias = true
            vm.viewerLibros = false
            vm.drawer = false
          }
          if(opt == 3){
            vm.viewerPanel = false
            vm.viewerUsuarios = false
            vm.viewerCategorias = false
            vm.viewerLibros = true
            vm.drawer = false
          }
        },
        closeModalAddUsuario(){
          vm.dialogAddUsuario = false
          vm.mailUser = null
          vm.nombreUsuario =  null
          vm.idUsuario = null
        },
        closeModalAddCategoria(){
          vm.dialogAddCategoria = false
          vm.nombreCategoria = null,
          vm.descripcionCategoria = null
          vm.idCategoria = null
        },
       
        saveUsuario(){
          if(vm.nombreUsuario == null || vm.nombreUsuario == '' || vm.nombreUsuario.length > 250){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese un nombre válido'
            vm.snackbar = true
            return false
          }
          if(vm.mailUser == null || vm.mailUser == '' || vm.mailUser.length > 250){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese un email válido'
            vm.snackbar = true
            return false
          }
          axios.post(vm.urlRoot+'save/usuarios', {
            name: vm.nombreUsuario,
            email: vm.mailUser
          }).then(response => {
            vm.openSnackbar('green','Usuario Guardado con éxito')
            vm.closeModalAddUsuario()
            vm.getListUsuarios()
          }).catch(e => {
            console.log(e);
          });
        },
        updateUsuario(){
          if(vm.nombreUsuario == null || vm.nombreUsuario == '' || vm.nombreUsuario.length > 250){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese un nombre válido'
            vm.snackbar = true
            return false
          }
          if(vm.mailUser == null || vm.mailUser == '' || vm.mailUser.length > 250){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese un email válido'
            vm.snackbar = true
            return false
          }
          axios.post(vm.urlRoot+'update/usuarios', {
            name: vm.nombreUsuario,
            email: vm.mailUser,
            id: vm.idUsuario
          }).then(response => {
            vm.openSnackbar('green','Usuario Actualizado con éxito')
            vm.closeModalAddUsuario()
            vm.getListUsuarios()
          }).catch(e => {
            console.log(e);
          });
        },
        getListUsuarios(){
          axios.get(vm.urlRoot+'get/usuarios', {}).then(function (res) {
              vm.overlay = false
          if (res.status == 200) {
            vm.rowDataUsuario = res.data
          }
          }).catch(function (err) {
                console.log(err)
          })
        },
        openModalUpdateUsuario(item){
          vm.idUsuario = item.id
          vm.mailUser = item.email
          vm.nombreUsuario = item.name
          vm.dialogAddUsuario = true
        },
        openDeleteUsuario(item){
          vm.idUsuario = item.id
          vm.dialogMensajeUsuario = true
        },
        closeModalEstatusUsuario(){
          vm.idUsuario = null
          vm.dialogMensajeUsuario = false
        },
        deleteUsuario(){
          axios.post(vm.urlRoot+'delete/usuarios', {
            id: vm.idUsuario
          }).then(response => {
            vm.openSnackbar('green','Usuario eliminado con éxito')
            vm.closeModalEstatusUsuario()
            vm.getListUsuarios()
          }).catch(e => {
            vm.closeModalEstatusUsuario()
            vm.openSnackbar('red',e.response.data.msj)
          });
        },
        getListCategorias(){
          axios.get(vm.urlRoot+'get/categorias', {}).then(function (res) {
              vm.overlay = false
          if (res.status == 200) {
            vm.rowDataCategorias = res.data
          }
          }).catch(function (err) {
                console.log(err)
          })
        },
        saveCategoria(){
          if(vm.nombreCategoria == null || vm.nombreCategoria == '' || vm.nombreCategoria > 250){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese un Nombre de Categoria válido'
            vm.snackbar = true
            return false
          }
          if(vm.descripcionCategoria == null || vm.descripcionCategoria == '' || vm.descripcionCategoria.length > 250){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese una Descripción válida'
            vm.snackbar = true
            return false
          }
          axios.post(vm.urlRoot+'save/categorias', {
            nombre: vm.nombreCategoria,
            descripcion: vm.descripcionCategoria
          }).then(response => {
            vm.openSnackbar('green','Categoria Generada con éxito')
            vm.closeModalAddCategoria()
            vm.getListCategorias()
          }).catch(e => {
            console.log(e);
          });
        },
        openModalUpdateCategoria(item){
          vm.idCategoria = item.id
          vm.nombreCategoria = item.name
          vm.descripcionCategoria = item.description
          vm.dialogAddCategoria = true
        },
        updateCategoria(){
          if(vm.nombreCategoria == null || vm.nombreCategoria == '' || vm.nombreCategoria > 250){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese un Nombre de Categoria válido'
            vm.snackbar = true
            return false
          }
          if(vm.descripcionCategoria == null || vm.descripcionCategoria == '' || vm.descripcionCategoria.length > 250){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese una Descripción válida'
            vm.snackbar = true
            return false
          }
          axios.post(vm.urlRoot+'update/categorias', {
            nombre: vm.nombreCategoria,
            descripcion: vm.descripcionCategoria,
            id: vm.idCategoria
          }).then(response => {
            vm.openSnackbar('green','Materia Actualizada con éxito')
            vm.closeModalAddCategoria()
            vm.getListCategorias()
          }).catch(e => {
            console.log(e);
          });
        },
        openDeleteCategoria(item){
          vm.idCategoria = item.id
          vm.dialogMensajeCategoria = true
        },
        closeModalEstatusCategoria(){
          vm.idCategoria = null
          vm.dialogMensajeCategoria = false
        },
        openSnackbar(color,texto){
          vm.snackbar = true
          vm.colorSnack = color
          vm.textSnack = texto
        },
        deleteCategoria(){
          axios.post(vm.urlRoot+'delete/categorias', {
            id: vm.idCategoria
          }).then(response => {
            vm.openSnackbar('green','Materia eliminada con éxito')
            vm.closeModalEstatusCategoria()
            vm.getListCategorias()
          }).catch(e => {
            vm.closeModalEstatusCategoria()
            vm.openSnackbar('red',e.response.data.msj)
          });
        },
        closeModalAddLibro(){
          vm.dialogAddLibro = false
          vm.nombreLibro = null
          vm.autor = null
          vm.idUsuario = null
          vm.idCategoria = null
        },
        saveLibro(){
          if(vm.nombreLibro == null || vm.nombreLibro == ''){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese un nombre válido'
            vm.snackbar = true
            return false
          }

          if(vm.autor == null || vm.autor == ''){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese un autor válido'
            vm.snackbar = true
            return false
          }

          if(vm.date == null || vm.date == ''){
            vm.colorSnack = 'red'
            vm.textSnack = 'Ingrese una Fecha válida'
            vm.snackbar = true
            return false
          }

          if(vm.idUsuario == null || vm.idUsuario == ''){
            vm.colorSnack = 'red'
            vm.textSnack = 'Seleccione un Usuario'
            vm.snackbar = true
            return false
          }
          if(vm.idCategoria == null || vm.idCategoria == ''){
            vm.colorSnack = 'red'
            vm.textSnack = 'Seleccione una categoria'
            vm.snackbar = true
            return false
          }
          axios.post(vm.urlRoot+'save/Libro', {
            nombreLibro: vm.nombreLibro,
            autor: vm.autor,
            date: vm.date,
            idUsuario: vm.idUsuario,
            idCategoria: vm.idCategoria
          }).then(response => {
            vm.openSnackbar('green','Libro Generada con éxito')
            vm.closeModalAddLibro()
            vm.getListLibros()
          }).catch(e => {
            console.log(e);
          });
        },
        getListLibros(){
          axios.get(vm.urlRoot+'get/Libros', {}).then(function (res) {
              vm.overlay = false
          if (res.status == 200) {
            vm.rowDataLibros = res.data
          }
          }).catch(function (err) {
                console.log(err)
          })
        },
        openDeleteLibro(item){
          vm.idLibro = item.id
          vm.dialogMensajeLibro = true
        },
        closeModalEstatusLibro(){
          vm.idLibro = null
          vm.dialogMensajeLibro = false
        },
        deleteLibros(){
          axios.post(vm.urlRoot+'delete/Libros', {
            id: vm.idLibro
          }).then(response => {
            vm.openSnackbar('green','Libro eliminado con éxito')
            vm.closeModalEstatusLibro()
            vm.getListLibros()
          }).catch(e => {
            console.log(e);
          });
        },

      },
      mounted() {
        window.vm = this
        vm.getListUsuarios()
        vm.getListCategorias()
        vm.getListLibros()
      }
    })
  </script>
</body>
</html>