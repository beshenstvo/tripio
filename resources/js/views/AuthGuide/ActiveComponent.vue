<template>
<div>
  <div class="row d-flex justify-content-between mt-3 mb-4">
    <div class="col-md-12" style="margin-top: auto; margin-bottom: auto;">
      <div class="input-group">
        <input type="text" class="form-control searchInput" placeholder="Введите имя или сообщение" aria-describedby="button-addon2" v-model.trim="searchText">
        <button class="btn searchButton" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
      </div>
    </div>
  </div>

  <div class="card" v-for="request in filteredData" :key="request.id">
    <div class="card-header pt-2 pb-2 ps-3 pe-3">
    <h4  v-html="highlightText('Имя: '+request.client_name)"></h4>
    <button class="btn btn-outline-secondary" @click="addToArchive(request.id, request.service_id, request.client_name, request.client_phone, request.message)" title="Добавить в архив"><i class="fas fa-archive me-2"></i>Добавить в архив</button>
    </div>
    <div class="card-body pt-2 pb-2 ps-3 pe-3">
    <p class="card-text" v-html="highlightText('Номер телефона: '+request.client_phone)"></p>
    <p class="card-text">Сообщение: {{ request.message }}</p>
    <p class="card-text">Название экскурсии: {{ request.service.name }}</p>
     <p class="card-text">Описание экскурсии: {{ $filters.truncate(request.service.description) }}</p>
    </div>
    <div class="card-footer pt-2 pb-2 ps-3 pe-3">
    <button class="btn btn-outline-danger" @click="deleteCard(request.id)" title="Удалить"><i class="fas fa-trash me-2"></i>Удалить</button>
    </div>
  </div>

  <div class="alert alert-danger" role="alert" v-if="errored">
    Ошибка загрузки данных!
  </div>

  <!-- прогресс бар -->
  <div class="text-center" v-if="loading">
    <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
  </div>
  

   <nav>
      <ul class="pagination">
      <li class="page-item" v-if="pagination.current_page > 1">
          <a class="page-link" href="#" @click.prevent="getRequests(pagination.current_page - 1)">
              <span>Prev</span>
          </a>
      </li>
      <li class="page-item" v-for="page in pagination.last_page" :key="page" :class="[page == pagination.current_page ? 'active' : '']">
          <a class="page-link" href="#" @click.prevent="getRequests(page)">
              <span>{{ page }}</span>
          </a>
      </li>
      <li class="page-item" v-if="pagination.current_page < pagination.last_page">
          <a class="page-link" href="#" @click.prevent="getRequests(pagination.current_page + 1)">
              <span>Next</span>
          </a>
      </li>
    </ul>
  </nav>

</div>

</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      loading: true,
      errored: false,
      data: '',
      showModal: false, 
      id: '',
      client_name: '',
      client_phone: '',
      message: '',
      searchText: '',
      pagination: '',
      currentUser: ''
    }
  },
  mounted() {
    this.getRequests();
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
    axios.get('api/user').then((response) => {
        this.currentUser = response.data;
    })
  }, 
  computed: {
    filteredData() {
      return this.$options.filters.searchFilter(this.data, this.searchText);
    },
  },
  filters: {
    searchFilter(data, searchText) {
      if (!searchText) return data;
      return data.filter(function(item) {
        return (
          item.client_name.toLowerCase().indexOf(searchText.toLowerCase()) !== -1 ||
          item.client_phone.toLowerCase().indexOf(searchText.toLowerCase()) !== -1
        );
      });
    },
  },
  methods: {
      getRequests(page = 1) {
        axios.get('/api/requests', {
          params: {
            page: page,
            archive: 0
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
      deleteCard(id) {
         console.log(id);
          axios.post('/api/requests/'+id, {
              _method: 'DELETE'
          })
          .catch( error => {
              console.log(error);
              this.errored = true;
          })
          this.getRequests()
      },
      highlightText(text) {
        if (!this.searchText) return text;
        const regex = new RegExp(`(${this.searchText})`, 'gi');
        return text.replace(regex, '<mark>$1</mark>');
      },
      addToArchive(id, service_id, client_name, client_phone, message) {
        axios.post('/api/requests/' + id, {
          _method: 'PUT',
          archive: 1, 
          service_id: service_id,
          client_name: client_name,
          client_phone: client_phone,
          message: message
        })
        .catch(error => {
          console.log(error.response.data);
        });

        this.getRequests()
      }
  }
}
</script>

<style scoped>
.card {
  width: 100%;
  margin-bottom: 20px;
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  border: none;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #ffffff;
  padding: 20px;
  border-bottom: 1px solid #ddd;
}

.card-header h4 {
  margin: 0;
}

.card-body {
  padding: 20px;
}

.card-footer {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  background-color: #ffffff;
  padding: 20px;
  border-top: 1px solid #ddd;
}
</style>