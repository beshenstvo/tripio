<template>
  <div class="container">
    <div class="row d-flex justify-content-between mt-3 mb-4">
      <div class="col-md-12" style="margin-top: auto; margin-bottom: auto;">
        <div class="input-group">
          <input type="text" class="form-control searchInput" placeholder="Введите название или описание услуги" aria-describedby="button-addon2" v-model="searchText">
          <button class="btn searchButton" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
        </div>
      </div>
    </div>

    <!-- карточка роута -->
    <div class="row">
      <div class="col-md-12 mb-4" v-for="service in filteredData" :key="service.id">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4 outimg">
                <!-- <img class="innerimg" src="https://via.placeholder.com/250" alt="Изображение"> -->
                <img class="innerimg" :src="'/api/image/public/'+service.photo" alt="Изображение">
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-9">
                    <h4 class="card-title" v-html="highlightText(service.name)"></h4>
                    <p class="card-text" v-html="highlightText( $filters.truncate(service.description) )"></p>
                  </div> 
                  <div class="col-md-3">
                    <p class="card-text"> <i class="fas fa-clock me-2"></i>Длительность: {{ service.duration }}</p>
                    <p class="card-text"><i class="fas fa-ruble-sign me-2"></i>Стоимость: {{ service.price }}</p>
                    <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>Город: {{ service.city.name }}</p>
                    <p class="card-text"><i class="fas fa-binoculars me-2"></i>Тип: {{ service.type }}</p>
                    <p class="card-text"><i class="fas fa-mountain me-2"></i>Вид: {{ service.kind }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <a class="btn btn-outline-primary" @click="showModalEditingFunc( service.id )"><i class="fas fa-edit"></i><span class="ms-1">Изменить</span></a>
            <a class="btn btn-outline-danger mr-2" v-on:click="deleteService( service.id )"><i class="fas fa-trash"></i><span class="ms-1">Удалить</span></a>
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
            <a class="page-link" href="#" @click.prevent="getServices(pagination.current_page - 1)">
                <span>Prev</span>
            </a>
        </li>
        <li class="page-item" v-for="page in pagination.last_page" :key="page" :class="[page == pagination.current_page ? 'active' : '']">
            <a class="page-link" href="#" @click.prevent="getServices(page)">
                <span>{{ page }}</span>
            </a>
        </li>
        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
            <a class="page-link" href="#" @click.prevent="getServices(pagination.current_page + 1)">
                <span>Next</span>
            </a>
        </li>
      </ul>
    </nav>
   
    
    <!-- Модальное окно для изменения -->
    <div class="outerModal">
      <div class="modal" tabindex="-1" role="dialog" v-if="showModalEditing" style="display: block; background-color: rgba(0, 0, 0, 0.64);">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Изменить маршрут</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="showModalEditing = false, checkSelectedInput = false, fileName = ''"></button>
            </div>
            <div class="modal-body">
              <!-- Форма для изменения услуги -->
              <form>
                <div class="mb-3">
                  <label for="route-city">Выберите город маршрута</label>
                  <select class="form-control" id="route-city" v-model="city_id">
                    <option v-for="city in cities" :key="city.id" :value="city.id">{{ city.name }}</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="route-name">Название маршрута</label>
                  <input type="text" class="form-control" id="route-name" placeholder="Введите название маршрута" v-model="name">
                </div>
                <div class="mb-3">
                  <label for="route-description">Описание маршрута</label>
                  <textarea class="form-control" id="route-description" rows="3" placeholder="Введите описание маршрута" v-model="description"></textarea>
                </div>
                <div class="mb-3">
                  <label for="route-duration">Длительность мероприятия</label>
                  <input type="text" class="form-control" id="route-duration" placeholder="Введите длительность мероприятия" v-model="duration">
                </div>

                <div class="mb-3">
                  <label for="price">Стоимость услуги</label>
                  <input type="text" class="form-control" id="price" placeholder="Введите стоимость услуги" v-model="price">
                </div>
                <div class="mb-3">
                  <label for="type">Тип услуги</label>
                  <select class="form-select" id="type" v-model="type">
                    <option value="Индивидуальный">Индивидуальный</option>
                    <option value="Групповой">Групповой</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="kind">Вид услуги</label>
                   <select class="form-select" id="kind" v-model="kind">
                    <option value="Городской">Городской</option>
                    <option value="Загородный">Загородный</option>
                    <option value="Производственный">Производственный</option>
                    <option value="Музейный">Музейный</option>
                    <option value="Комплексный">Комплексный</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label for="formFile" class="form-label">Текущее изображение</label>
                  <div class="text-center mb-2">
                    <img v-if="fileName && !checkSelectedInput" class="innerimg" style="width: 50%" :src="'/api/image/public/'+fileName" alt="">
                  </div>
                  <input v-if="!checkSelectedInput" type="text" id='photo' name="photo" :value="fileName"  class="form-control mb-2" disabled>
                  <input class="form-control" type="file" id="formFile" @change="handleFileChange" @click="checkSelectedImage = true">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="showModalEditing = false, checkSelectedInput = false, fileName = ''">Закрыть</button>
              <button type="button" class="btn btn-primary" :disabled="!isDisabled" @click="saveUpdates(this.id), showModalEditing = false">Сохранить</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script scoped>
import axios from 'axios';
export default {
  data() {
    return {
      loading: true,
      errored: false,
      data: '',
      key: 1, 
      showModal: false, 
      showModalEditing: false,
      id: '',
      city_id: 1,
      name: '',
      description: '',
      duration: '',
      file: null,
      cities: '',
      searchText: '',
      checkSelectedInput: false,
      pagination: '',
      price: '',
      type: 'Групповой',
      kind: 'Городской', 
      currentUser: '',
      checkSelectedImage: false,
      originalService: {
        city_id: '',
        user_id: '',
        photo: '',
        name: '',
        description: '',
        duration: '',
        price: '',
        type: '',
        kind: ''
      }, 
      fileName: ''
    }
  },
  mounted() {
    this.getServices();
    this.getCities();
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
    axios.get('api/user').then((response) => {
        this.currentUser = response.data;
    })
  }, 
  computed: {
    isDisabled() {
      return this.name !== '' && this.description !== '' && this.duration !== '' && this.city_id !== '' && this.price !== '' && this.type !== '' && this.kind !== '';
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
      getServices(page = 1) {
        axios.get('/api/servicesAll', {
          params: {
            page: page
          }
        })
        .then( response => {
          console.log(response.data.data)
          this.data = response.data.data;
          this.pagination = response.data.meta;
          console.log(this.pagination)
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
      deleteService(id) {
         console.log(id);
          axios.post('/api/services/'+id, {
              _method: 'DELETE'
          })
          .catch( error => {
              console.log(error);
              this.errored = true;
          })
          this.getServices()
      },
      handleFileChange(e) {
        this.file = e.target.files[0];
        this.checkSelectedInput = true;
        console.log(this.file);
      },
      async saveUpdates(id) {
        await axios.get('api/services/'+id).then(response => {
          this.originalService.city_id = response.data.data.city_id
          this.originalService.user_id = response.data.data.user_id
          this.originalService.name = response.data.data.name
          this.originalService.description = response.data.data.description
          this.originalService.duration = response.data.data.duration
          this.originalService.type = response.data.data.type
          this.originalService.kind = response.data.data.kind
          this.originalService.price = response.data.data.price
          this.originalService.photo = response.data.data.photo
        })
        
        if (
          this.city_id == this.originalService.city_id &&
          this.currentUser.id == this.originalService.user_id &&
          this.name == this.originalService.name &&
          this.description == this.originalService.description &&
          this.duration == this.originalService.duration &&
          this.type == this.originalService.type &&
          this.kind == this.originalService.kind &&
          this.price == this.originalService.price &&
          !this.checkSelectedImage &&
          this.fileName == this.originalService.photo
        ) {
          this.showModalEditing = false;
          return;
        }

        let formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('city_id', this.city_id);
        formData.append('user_id', this.currentUser.id);
        formData.append('name', this.name);
        formData.append('description', this.description);
        formData.append('duration', this.duration);
        formData.append('type', this.type);
        formData.append('kind', this.kind);
        formData.append('price', this.price);
        if((this.file !== null)) {
          formData.append('photo', this.file);
          console.log('!==')
        }

        axios.post('/api/services/'+id, formData)
          .then(response => {
            console.log(response.status);
            if(response.status == 200) {
              this.getServices()
              alert('Данные обновлены')
              this.showModalEditing = false
              return
            }
            this.getServices()
          })
          .catch( error => {
              console.log(error);
              this.errored = true;
          })
      },
      showModalEditingFunc(id) {
        this.showModalEditing = true;
        axios.get('/api/services/'+id)
          .then(response => {
            this.id = response.data.data.id;
            this.name = response.data.data.name;
            this.description = response.data.data.description;
            this.city_id = response.data.data.city_id;
            this.duration = response.data.data.duration;
            this.price = response.data.data.price;
            this.type = response.data.data.type;
            this.kind = response.data.data.kind;
            this.fileName = response.data.data.photo;
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