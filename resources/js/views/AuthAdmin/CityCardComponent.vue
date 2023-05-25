<template>
  <div class="container">
    <div class="row d-flex justify-content-between mt-3 mb-4">
      <div class="col-md-11" style="margin-top: auto; margin-bottom: auto;">
        <div class="input-group">
          <input type="text" class="form-control searchInput" placeholder="Введите название города" aria-describedby="button-addon2" v-model.trim="searchText">
          <button class="btn searchButton" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
        </div>
      </div>

       <div class="col-md-1" style="margin-top: auto; margin-bottom: auto; text-align: end;">
        <button class="btn btn-outline-primary addButton" @click="showModal = true, name = '', description = '', duration = ''"><i class="fas fa-plus"></i></button>
      </div>
    </div>

    <!-- карточка роута -->
    <div class="row">
      <div class="col-md-12 mb-4" v-for="item in filteredData" :key="item.id">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 outimg">
                <!-- <img class="innerimg" src="https://via.placeholder.com/250" alt="Изображение"> -->
                <img class="innerimg" :src="'/api/image/public/'+item.photo" alt="Изображение">
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-9">
                    <h4 class="card-title" v-html="highlightText(item.name)"></h4>
                    <p class="card-text" v-html="highlightText( $filters.truncate(item.description) )"></p>
                  </div> 
                  <div class="col-md-3">
                    <!-- <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>Город: {{ item.city.name }}</p> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <a class="btn btn-outline-primary" @click="showModalEditingFunc( item.id )"><i class="fas fa-edit"></i><span class="ms-1">Изменить</span></a>
            <a class="btn btn-outline-danger mr-2" @click="deleteItem( item.id )"><i class="fas fa-trash"></i><span class="ms-1">Удалить</span></a>
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
            <a class="page-link" href="#" @click.prevent="getData(pagination.current_page - 1)">
                <span>Prev</span>
            </a>
        </li>
        <li class="page-item" v-for="page in pagination.last_page" :key="page" :class="[page == pagination.current_page ? 'active' : '']">
            <a class="page-link" href="#" @click.prevent="getData(page)">
                <span>{{ page }}</span>
            </a>
        </li>
        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
            <a class="page-link" href="#" @click.prevent="getData(pagination.current_page + 1)">
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
              <h5 class="modal-title">Добавить новую карточку города</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="showModal = false"></button>
            </div>
            <div class="modal-body">
              <!-- Форма для добавления маршрута -->
              <form v-if="cities.length > 0">
                <div class="mb-3">
                  <label for="route-city">Выберите город</label>
                  <select class="form-control" id="route-city" v-model="city_id" :class="{'is-invalid': city_id == ''}">
                    <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                  </select>
                  <span class="invalid-feedback" v-if="city_id == ''">Поле обязательно для заполнения</span>
                </div>
                <div class="mb-3">
                  <label for="route-name">Название карточки</label>
                  <input type="text" class="form-control" id="route-name" placeholder="Введите название маршрута" v-model.trim="v$.name.$model" :class="{'is-invalid': v$.name.$error}">
                  <span class="invalid-feedback" v-if="v$.name.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.name.minLength.$invalid">Поле должно содержать количество символов больше 15</span>
                </div>
                <div class="mb-3">
                  <label for="route-description">Описание карточки</label>
                  <textarea class="form-control" id="route-description" rows="3" placeholder="Введите описание маршрута" v-model.trim="v$.description.$model" :class="{'is-invalid': v$.description.$error}"></textarea>
                  <span class="invalid-feedback" v-if="v$.description.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.description.minLength.$invalid">Поле должно содержать количество символов больше 30</span>
                </div>
                <div class="mb-3">
                  <label for="formFile" class="form-label">Изображение</label>
                  <input class="form-control" type="file" id="formFile" @change="handleFileChange" @click="checkSelectedImage = true" :class="{'is-invalid': errorFile}">
                  <span class="invalid-feedback" v-if="errorFile">Изображение должно иметь размер меньше 1 Мб и должно иметь формат png, jpeg, jpg, svg</span>
                </div>
              </form>
              <div v-if="cities.length == 0">
                У всех городов есть карточки.
              </div>
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
              <h5 class="modal-title">Изменить карточку города</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="showModalEditing = false, checkSelectedInput = false, fileName = ''"></button>
            </div>
            <div class="modal-body">
              <!-- Форма для изменения услуги -->
              <form>
                <div class="mb-3">
                  <label for="route-city">Выберите город</label>
                  <select class="form-control" id="route-city" v-model.trim="city_id">
                    <option v-for="city in citiesForEditing" :key="city.id" :value="city.id">{{ city.name }}</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="route-name">Название карточки</label>
                  <input type="text" class="form-control" id="route-name" placeholder="Введите название маршрута"  v-model.trim="v$.name.$model" :class="{'is-invalid': v$.name.$error}">
                  <span class="invalid-feedback" v-if="v$.name.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.name.minLength.$invalid">Поле должно содержать количество символов больше 15</span>
                </div>
                <div class="mb-3">
                  <label for="route-description">Описание карточки </label>
                  <textarea class="form-control" id="route-description" rows="3" placeholder="Введите описание маршрута" v-model.trim="v$.description.$model" :class="{'is-invalid': v$.description.$error}"></textarea>
                  <span class="invalid-feedback" v-if="v$.description.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.description.minLength.$invalid">Поле должно содержать количество символов больше 30</span>
                </div>
                <div class="mb-3">
                  <label for="formFile" class="form-label">Текущее изображение</label>
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
      data: [],
      key: 1, 
      showModal: false, 
      showModalEditing: false,
      id: '',
      city_id: '',
      name: '',
      description: '',
      file: null,
      cities: '',
      citiesForEditing: '',
      searchText: '',
      selectImg: false,
      checkSelectedInput: false,
      pagination: '',
      currentUser: '',
      checkSelectedImage: false,
      originalService: {
        city_id: '',
        photo: '',
        name: '',
        description: ''
      }, 
      fileName: '',
      errorFile: false
    }
  },
   validations: {
    name: { required, minLength: minLength(15) },
    description: { required, minLength: minLength(30) }
  },
  mounted() {
    this.getData()
    .then(() => this.getCities())
    .catch((error) => console.error(error))
  }, 
  computed: {
    isDisabled() {
      return this.name !== '' && this.description !== '' && this.city_id !== '' && this.file != null;
    },
    isDisabledEdit() {
      return this.name !== '' && this.description !== '' && this.city_id !== '';
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
    async getData(page = 1) {
      try {
        const response = await axios.get('/api/citycards/', {
          params: {
            page: page
          }
        });
        this.data = response.data.data;
        this.pagination = response.data.meta;
      } catch (error) {
          this.errored = true;
      } finally {
          this.loading = false;
      }
    },

    async getCities() {
      try {
        const response = await axios.get('/api/cities/');
        const allCities = response.data.data;
        this.citiesForEditing = response.data.data;
        const usedCityIds = this.data.map(city => city.city_id); // получаем массив id городов, которые уже есть в this.data
        this.cities = allCities.filter(city => !usedCityIds.includes(city.id)); // фильтруем массив городов и оставляем только те, которых еще нет в this.data
        this.city_id = this.cities.length > 0 ? this.cities[0].id : null
        console.log('get city id '+ this.city_id)
      } catch (error) {
        console.error(error);
      }
    },

    deleteItem(id) {
      console.log(id);
      axios.post('/api/citycards/'+id, {
          _method: 'DELETE'
      })
      .catch( error => {
          console.log(error);
          this.errored = true;
      })
      this.getData()
      this.getCities()
    },
      handleFileChange(e) {
        this.file = e.target.files[0];
        this.checkSelectedInput = true;
        this.selectImg = true;
        console.log(this.file);
      },
      async saveUpdates(id) {
        this.v$.$touch();
        if(this.v$.$anyError) {
          return;
        }
        if (!this.v$.$invalid) { 
          await axios.get('api/citycards/'+id).then(response => {
          console.log(response.data)
          this.originalService.city_id = response.data.city_id
          this.originalService.name = response.data.name
          this.originalService.description = response.data.description
          this.originalService.photo = response.data.photo
        })
        
        if (
          this.city_id == this.originalService.city_id &&
          this.name == this.originalService.name &&
          this.description == this.originalService.description &&
          !this.checkSelectedImage &&
          this.fileName == this.originalService.photo
        ) {
          this.showModalEditing = false;
          return;
        }

        let formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('city_id', this.city_id);
        formData.append('name', this.name);
        formData.append('description', this.description);

        if((this.file !== null)) {
          if(!validFormat(this.file) || !maxSize(1024)(this.file)) {
            this.errorFile = true;
            return;
          }
          formData.append('photo', this.file);
        }

        axios.post('/api/citycards/'+id, formData)
          .then(response => {
            console.log(response.status);
            if(response.status == 200) {
              this.getData()
              alert('Данные обновлены')
              this.showModalEditing = false
              return
            }
            this.getData()
          })
          .catch( error => {
              console.log(error);
              this.errored = true;
          })
        }
      },
      showModalEditingFunc(id) {
        this.showModalEditing = true;
        axios.get('/api/citycards/'+id)
          .then(response => {
            console.log(response.data)
            this.id = response.data.id;
            this.name = response.data.name;
            this.description = response.data.description;
            this.city_id = response.data.city_id;
            this.fileName = response.data.photo;
          })
          .catch( error => {
              console.log(error);
              this.errored = true;
          })

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
          formData.append('photo', this.file);

          axios.post('/api/citycards/', formData)
            .then(response => {
              console.log(response.data);
              if(response.status == 200) {
                this.showModal = false
                this.checkSelectedInput = false
                alert('Данные созданы')
              }
              this.getData()
              this.getCities()
            })
            .catch( error => {
                console.log(error);
                this.errored = true;
            })
        }
      },
      highlightText(text) {
        if (!this.searchText) return text;
        const regex = new RegExp(`(${this.searchText})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
      },
  }
}
</script>
