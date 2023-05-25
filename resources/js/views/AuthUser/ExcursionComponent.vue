<template>
  <div class="container">
    <div class="row d-flex justify-content-between mt-3 mb-4">
      <div class="col-md-12" style="margin-top: auto; margin-bottom: auto;">
        <div class="input-group">
          <input type="text" class="form-control searchInput" placeholder="Введите название или описание услуги" aria-describedby="button-addon2" v-model.trim="searchText">
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
            <router-link class="btn btn-outline-primary"  :to="{ name: 'MoreAboutExcursion', params: { id: service.id } }"><i class="fas fa-info-circle"></i><span class="ms-1">Подробнее</span></router-link>
            <a class="btn btn-outline-success mr-2" @click="showModal = true, service_id = service.id"><i class="fas fa-file-alt"></i><span class="ms-1">Оставить заявку</span></a>
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

    <!-- пагинация -->
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

    <!-- Модальное окно для оставления заявки -->
    <div class="outerModal">
      <div class="modal" tabindex="-1" role="dialog" v-if="showModal" style="display: block; background-color: rgba(0, 0, 0, 0.64);">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Оставьте заявку</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="showModal = false"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <input type="hidden" class="form-control" id="city_id" :value="city_id">
                </div>
                <div class="mb-3">
                  <input type="hidden" class="form-control" id="city_id" :value="currentUser">
                </div>
                <div class="mb-3">
                  <label for="route-city">Ваше имя</label>
                  <input type="text" class="form-control" id="name" placeholder="Иван" v-model.trim="v$.name.$model" :class="{'is-invalid': v$.name.$error}" required>
                  <span class="invalid-feedback" v-if="v$.name.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.name.minLength.$invalid && !v$.name.required.$invalid">Поле должно содержать количество символов меньше 2</span>
                  <span class="invalid-feedback" v-if="v$.name.maxLength.$invalid && !v$.name.required.$invalid">Поле должно содержать количество символов больше 50</span>
                  <span class="invalid-feedback" v-if="v$.name.customRegex.$invalid && !v$.name.required.$invalid">Поле должно содержать только буквы, пробелы и тире</span>
                </div>
                <div class="mb-3">
                  <label for="route-name">Введите телефон</label>
                  <input type="text" class="form-control" id="phone" v-mask="'+7(###) ###-##-##'" placeholder="+7(999)999-99-99" v-model.trim="v$.phone.$model" :class="{'is-invalid': v$.phone.$error}" required>
                  <span class="invalid-feedback" v-if="v$.phone.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.phone.minLength.$invalid && !v$.phone.required.$invalid">Поле должно содержать полный номер телефона</span>
                </div>
                 <div class="mb-3">
                  <label for="route-name">Введите сообщение</label>
                  <textarea class="form-control" id="phone" placeholder="Сообщение" v-model.trim="v$.message.$model" :class="{'is-invalid': v$.message.$error}"></textarea>
                  <span class="invalid-feedback" v-if="v$.message.required.$invalid">Поле обязательно для заполнения</span>
                  <span class="invalid-feedback" v-if="v$.message.minLength.$invalid && !v$.message.required.$invalid">Поле должно содержать количество символов меньше 10</span>
                  <span class="invalid-feedback" v-if="v$.message.maxLength.$invalid && !v$.message.required.$invalid">Поле должно содержать количество символов больше 100</span>
                </div>
                
    
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="showModal = false">Закрыть</button>
              <button type="button" class="btn btn-success" :disabled="!isDisabled" @click="send">Отправить</button> 
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
</template>

<script scoped>
import { useVuelidate } from '@vuelidate/core'
import { required, minLength, maxLength } from '@vuelidate/validators'

function customRegex (value) {
  const regex = /^[a-zA-ZА-Яа-я\s-]+$/;
  return regex.test(value)
}
export default {
  setup () {
    return { v$: useVuelidate() }
  },
  data() {
    return {
      loading: true,
      errored: false,
      showModal: false,
      data: '',
      key: 1, 
      id: '',
      city_id: 1,
      service_id: '',
      name: '',
      phone: '',
      message: '',
      file: null,
      cities: '',
      searchText: '',
      pagination: '',
      currentUser: '',
      fileName: '', 
      isLoggedIn: localStorage.getItem("isLoggedIn")
    }
  },
  validations: {
    name: { required, minLength: minLength(2), maxLength: maxLength(50), customRegex },
    message: { required, minLength: minLength(10), maxLength: maxLength(100)},
    phone: { required, minLength: minLength(17)}
  },
  mounted() {
    this.getServices();
    this.getCities();
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
    if(this.isLoggedIn) {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
      axios.get('api/user').then((response) => {
        this.currentUser = response.data;
        console.log(this.currentUser);
      })
    }
  }, 
  computed: {
    isDisabled() {
      return this.name !== '' && this.phone !== '';
    },
    filteredData() {
      return this.$options.filters.searchFilter(this.data, this.searchText);
    }
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
    }
  },
  methods: {
      getServices(page = 1) {
        axios.get('/api/servicesAll', {
          params: {
            page: page
          }
        })
        .then( response => {
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
          this.cities = response.data.data;
        })
        .catch( error => {
            this.errored = true;
        })
      },
      highlightText(text) {
        if (!this.searchText) return text;
        const regex = new RegExp(`(${this.searchText})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
      },
      send() {
        this.v$.$touch();
        if(this.v$.$anyError) {
          return;
        }
        if (!this.v$.$invalid) {
          let formData = new FormData();
          formData.append('service_id', this.service_id);
          formData.append('client_phone', this.phone);
          formData.append('client_name', this.name);
          formData.append('message', this.message);

          console.log(formData.get('service_id'))
          console.log(formData.get('client_phone'))
          console.log(formData.get('client_name'))
          console.log(formData.get('message'))

          axios.post('/api/requests', {
            service_id: this.service_id,
            client_phone: this.phone,
            client_name: this.name,
            message: this.message
          })
          .catch( error => {
            console.log(error);
            this.errored = true;
          })
          .finally( () => {
            this.showModal = false
            alert('Ваша заявка отправлена!')
          })
        }
      }
  }
}
</script>