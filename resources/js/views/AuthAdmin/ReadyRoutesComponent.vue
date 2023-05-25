<template>
  <div class="container">
    <div class="row d-flex justify-content-between mt-3 mb-4">
      <div class="col-md-11" style="margin-top: auto; margin-bottom: auto;">
        <div class="input-group">
          <input type="text" class="form-control searchInput" placeholder="Введите название экскурсии или города" aria-describedby="button-addon2" v-model.trim="searchText">
          <button class="btn searchButton" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
        </div>
      </div>

      <div class="col-md-1" style="margin-top: auto; margin-bottom: auto; text-align: end;">
        <button class="btn btn-outline-primary addButton" @click="showModal = true, city_id = '1', name = '', description = '', duration = ''"><i class="fas fa-plus"></i></button>
      </div>
    </div>

    <!-- карточка роута -->
    <div class="row">
      <div class="col-md-12 mb-4" v-for="route in filteredData" :key="route.id">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 outimg">
                <!-- <img class="innerimg" src="https://via.placeholder.com/250" alt="Изображение"> -->
                <img class="innerimg" :src="'/api/image/public/'+route.photo" alt="Изображение">
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-9">
                    <h4 class="card-title" v-html="highlightText(route.name)"></h4>
                    <p class="card-text" v-html="highlightText( $filters.truncate(route.description))"></p>
                  </div> 
                  <div class="col-md-3">
                    <p class="card-text"> <i class="fas fa-clock me-2"></i>Длительность: {{ route.duration }}</p>
                    <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>Город: {{ route.city.name }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <a class="btn btn-outline-primary" @click="showModalEditingFunc( route.id ), name = '', file = '', description = '', duration = ''"><i class="fas fa-edit"></i><span class="ms-1">Изменить</span></a>
            <a class="btn btn-outline-danger mr-2" v-on:click="deleteRoute( route.id )"><i class="fas fa-trash"></i><span class="ms-1">Удалить</span></a>
          </div>
        </div>
      </div>

      <div class="alert alert-danger" role="alert" v-if="errored">
        Ошибка загрузки данных!
      </div>

        <!-- прогресс бар -->
        <div class="d-flex align-items-center" v-if="loading">
          <strong>Loading...</strong>
          <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
        </div>
    </div>

    <nav>
       <ul class="pagination">
        <li class="page-item" v-if="pagination.current_page > 1">
            <a class="page-link" href="#" @click.prevent="getReadyRoutes(pagination.current_page - 1)">
                <span>Prev</span>
            </a>
        </li>
        <li class="page-item" v-for="page in pagination.last_page" :key="page" :class="[page == pagination.current_page ? 'active' : '']">
            <a class="page-link" href="#" @click.prevent="getReadyRoutes(page)">
                <span>{{ page }}</span>
            </a>
        </li>
        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
            <a class="page-link" href="#" @click.prevent="getReadyRoutes(pagination.current_page + 1)">
                <span>Next</span>
            </a>
        </li>
      </ul>
    </nav>
   

    <!-- Модальное окно для добавления -->
    <div class="outerModal">
      <div class="modal" tabindex="-1" role="dialog" v-if="showModal" style="display: block; background-color: rgba(0, 0, 0, 0.64);">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Добавить новый маршрут</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="showModal = false"></button>
            </div>
            <div class="modal-body">

              <!-- Форма для добавления маршрута -->
              <form>
                <div class="mb-3">
                  <label for="route-city">Выберите город маршрута</label>
                  <select class="form-select" id="route-city" v-model="city_id">
                    <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="route-name">Название маршрута</label>
                  <input type="text" class="form-control" id="route-name" placeholder="Введите название маршрута" v-model.trim="v$.name.$model" :class="{'is-invalid': v$.name.$error}">
                  <span class="invalid-feedback" v-if="v$.name.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.name.minLength.$invalid">Поле должно содержать количество символов больше 15</span>
                </div>
                <div class="mb-3">
                  <label for="route-description">Описание маршрута</label>
                  <textarea class="form-control" id="route-description" rows="3" placeholder="Введите описание маршрута" v-model.trim="v$.description.$model" :class="{'is-invalid': v$.description.$error}"></textarea>
                  <span class="invalid-feedback" v-if="v$.description.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.description.minLength.$invalid">Поле должно содержать количество символов больше 30</span>
                </div>
                <div class="mb-3">
                  <label for="route-duration">Длительность маршрута</label>
                  <input type="text" class="form-control" id="route-duration" placeholder="Введите длительность маршрута" v-model.trim="v$.duration.$model" :class="{'is-invalid': v$.duration.$error}">
                  <span class="invalid-feedback" v-if="v$.duration.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.duration.minLength.$invalid">Поле должно содержать количество символов больше 4</span>
                </div>
                <div class="mb-3">
                  <label for="formFile" class="form-label">Изображение</label>
                  <input class="form-control" type="file" id="formFile" @change="handleFileChange" @click="checkSelectedImage = true" :class="{'is-invalid': errorFile}">
                  <span class="invalid-feedback" v-if="errorFile">Изображение должно иметь размер меньше 1 Мб и должно иметь формат png, jpeg, jpg, svg</span>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="showModal = false">Закрыть</button>
              <button type="button" class="btn btn-primary" :disabled="!isDisabled" @click="add">Сохранить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Модальное окно для изменения -->
    <div class="outerModal">
      <div class="modal" tabindex="-1" role="dialog" v-if="showModalEditing" style="display: block; background-color: rgba(0, 0, 0, 0.64);">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Изменить маршрут</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="showModalEditing = false, checkSelectedInput = false, file = ''"></button>
            </div>
            <div class="modal-body">
              <!-- Форма для добавления маршрута -->
              <form>
                <div class="mb-3">
                  <label for="route-city">Выберите город маршрута</label>
                  <select class="form-select" id="route-city" v-model="city_id">
                    <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="route-name">Название маршрута</label>
                  <input type="text" class="form-control" id="route-name" placeholder="Введите название маршрута" v-model.trim="v$.name.$model" :class="{'is-invalid': v$.name.$error}">
                  <span class="invalid-feedback" v-if="v$.name.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.name.minLength.$invalid">Поле должно содержать количество символов больше 15</span>
                </div>
                <div class="mb-3">
                  <label for="route-description">Описание маршрута</label>
                  <textarea class="form-control" id="route-description" rows="3" placeholder="Введите описание маршрута" v-model.trim="v$.description.$model" :class="{'is-invalid': v$.description.$error}"></textarea>
                  <span class="invalid-feedback" v-if="v$.description.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.description.minLength.$invalid">Поле должно содержать количество символов больше 30</span>
                </div>
                <div class="mb-3">
                  <label for="route-duration">Длительность мероприятия</label>
                  <input type="text" class="form-control" id="route-duration" placeholder="Введите длительность мероприятия" v-model.trim="v$.duration.$model" :class="{'is-invalid': v$.duration.$error}">
                  <span class="invalid-feedback" v-if="v$.duration.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.duration.minLength.$invalid">Поле должно содержать количество символов больше 4</span>
                </div>
                <div class="mb-3">
                  <label for="formFile" class="form-label">Изображение</label>
                  <div class="text-center mb-2">
                    <img v-if="fileName && !checkSelectedInput" class="innerimg" style="width: 50%" :src="'/api/image/public/'+fileName" alt="">
                  </div>
                  <input v-if="!checkSelectedInput" type="text" id='photo' name="photo" :value="fileName"  class="form-control mb-2" disabled>
                  <input class="form-control" type="file" id="formFile" @change="handleFileChange"  @click="checkSelectedImage = true" :class="{'is-invalid': errorFile}">
                  <span class="invalid-feedback" v-if="errorFile">Изображение должно иметь размер меньше 1 Мб и должно иметь формат png, jpeg, jpg, svg</span>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="showModalEditing = false, checkSelectedInput = false, fileName = ''">Закрыть</button>
              <button type="button" class="btn btn-primary" :disabled="!isDisabledEdit" @click="saveUpdates(this.id)">Сохранить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script scoped>
import axios from 'axios';
import { useVuelidate } from '@vuelidate/core'
import { required, minLength, integer } from '@vuelidate/validators'
import { maxSize, validFormat } from '../../validationsForImage'

export default {
  setup () {
    return { v$: useVuelidate() }
  },
  data() {
    return {
      loading: true,
      errored: false,
      data: '',
      key: 1, 
      showModal: false, 
      showModalEditing: false,
      id: '',
      city_id: '1',
      name: '',
      description: '',
      duration: '',
      file: null,
      cities: '',
      searchText: '',
      checkSelectedInput: false,
      pagination: '',
      selectImg: false,
      fileName: '',
      originalRoute: {
        city_id: '',
        photo: '',
        name: '',
        description: '',
        duration: ''
      }, 
      errorFile: false
    }
  },
  validations: {
    name: { required, minLength: minLength(15) },
    description: { required, minLength: minLength(30) },
    duration: { required, minLength: minLength(4)}
  },
  mounted() {
    this.getReadyRoutes();
    this.getCities();
  }, 
  computed: {
    isDisabled() {
      return this.name !== '' && this.description !== '' && this.duration !== '' && this.file !== '' && this.city_id !== '' && this.selectImg;
    },
    isDisabledEdit() {
      return this.name !== '' && this.description !== '' && this.duration !== '' && this.city_id !== '';
    },
    filteredData() {
      return this.$options.filters.searchFilter(this.data, this.searchText);
    },
  },
  filters: {
    searchFilter(data, searchText) {
      if (!searchText) return data;
      return data.filter(function(item) {
        return (
          item.name.toLowerCase().indexOf(searchText.toLowerCase()) !== -1 ||
          item.description.toLowerCase().indexOf(searchText.toLowerCase()) !== -1
        );
      });
    },
  },
  methods: {
      getReadyRoutes(page = 1) {
        axios.get('/api/routes', {
          params: {
            page: page
          }
        })
        .then( response => {
          console.log(response.data.data)
          this.data = response.data.data;
          this.pagination = response.data.meta;
        })
        .catch( error => {
            this.errored = true;
        })
        .finally( () => {
            this.loading = false;
        }); 
      },
      getCities() {
        axios.get('/api/cities')
        .then( response => {
          console.log(response.data.data)
          this.cities = response.data.data;
        })
        .catch( error => {
            this.errored = true;
        })
      },
      deleteRoute(id) {
         console.log(id);
          axios.post('/api/routes/'+id, {
              _method: 'DELETE'
          })
          .catch( error => {
              console.log(error);
              this.errored = true;
          })
          this.getReadyRoutes()
      },
      handleFileChange(e) {
        this.file = e.target.files[0];
        this.checkSelectedInput = true;
        this.selectImg = true;
      },
      add() {
        this.v$.$touch();
        if(this.v$.$anyError) {
          return;
        }
        if(!validFormat(this.file) || !maxSize(1024)(this.file)) {
          this.errorFile = true;
          return;
        }
        if (!this.v$.$invalid) {
          let formData = new FormData();
          formData.append('city_id', this.city_id);
          formData.append('name', this.name);
          formData.append('description', this.description);
          formData.append('duration', this.duration);
          formData.append('photo', this.file);

          axios.post('/api/routes/', formData)
            .then(response => {
              console.log(response.status);
              if(response.status == 200) {
                this.showModal = false
                this.checkSelectedInput = false
                this.errorFile = false
                alert('Данные созданы')
              }
              this.getReadyRoutes()
            })
            .catch( error => {
                console.log(error);
                this.errored = true;
            })
        }
      },
      async saveUpdates(id) {
        this.v$.$touch();
        if(this.v$.$anyError) {
          return;
        }
        if (!this.v$.$invalid) {
          await axios.get('api/routes/'+id).then(response => {
            this.originalRoute.city_id = response.data.data.city_id
            this.originalRoute.name = response.data.data.name
            this.originalRoute.description = response.data.data.description
            this.originalRoute.duration = response.data.data.duration
            this.originalRoute.photo = response.data.data.photo
          })
          
          if (
            this.city_id == this.originalRoute.city_id &&
            this.name == this.originalRoute.name &&
            this.description == this.originalRoute.description &&
            this.duration == this.originalRoute.duration &&
            this.fileName == this.originalRoute.photo &&
            !this.checkSelectedImage
          ) {
            this.showModalEditing = false;
            return;
          }

          let formData = new FormData();
          formData.append('_method', 'PUT');
          formData.append('city_id', this.city_id);
          formData.append('name', this.name);
          formData.append('description', this.description);
          formData.append('duration', this.duration);

          if((this.file !== null)) {
            if(!validFormat(this.file) || !maxSize(1024)(this.file)) {
              this.errorFile = true;
              return;
            }
            formData.append('photo', this.file);
          }

          axios.post('/api/routes/'+id, formData)
          .then(response => {
            console.log(response.status);
            if(response.status == 200) {
              this.getReadyRoutes()
              alert('Данные обновлены')
              this.showModalEditing = false
              this.errorFile = false
              return
            }
            this.getReadyRoutes()
          })
          .catch( error => {
              console.log(error);
              this.errored = true;
          })
        }
      },
      showModalEditingFunc(id) {
        this.showModalEditing = true;
        axios.get('/api/routes/'+id)
          .then(response => {
            this.id = response.data.data.id;
            this.name = response.data.data.name;
            this.description = response.data.data.description;
            this.city_id = response.data.data.city_id;
            this.duration = response.data.data.duration;
            this.fileName = response.data.data.photo;
            console.log(this.file)
          })
          .catch( error => {
              console.log(error);
              this.errored = true;
          })

      }, 
      highlightText(text) {
        if (!this.searchText) return text;
        const regex = new RegExp(`(${this.searchText})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
      },
  }
}
</script>