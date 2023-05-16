<template>
  <div class="container">
    <div class="row d-flex justify-content-between mt-3 mb-4">
      <div class="col-md-2" style="margin-top: auto; margin-bottom: auto; text-align: end;">
        <select name="" id="" class="form-select searchInput" v-model="sortValue">
          <option value="default" disabled selected>--- Роль ---</option>
          <option value="all">Все</option>
          <option value="admin">admin</option>
          <option value="user">user</option>
          <option value="guide">guide</option>
        </select>
      </div>

      <div class="col-md-9" style="margin-top: auto; margin-bottom: auto;">
        <div class="input-group">
          <input type="text" class="form-control searchInput" placeholder="Введите имя" aria-describedby="button-addon2"  v-model.trim="searchText">
          <button class="btn searchButton" type="button" id="button-addon2"><i class="fas fa-search"></i></button>
        </div>
      </div>

      <div class="col-md-1" style="margin-top: auto; margin-bottom: auto; text-align: end;">
        <button class="btn btn-outline-primary addButton" @click="showModal = true, city_id = '1', name = '', description = '', duration = ''"><i class="fas fa-plus"></i></button>
      </div>
    </div>

    <div>
      <h5>Количество пользователей: {{ pagination.total }}</h5>
    </div>

    <!-- Карточка городов -->
    <div class="card ps-1 pe-1 mb-3" v-for="item in filteredData" :key="item.id">
      <div class="card-body row">
        <div class="col-1" style="align-self: center;">
          <h3>id: {{ item.id }}</h3>
        </div>
        <div class="col-11">
          <h5 class="card-title" v-html="highlightText('Имя: '+item.name)"></h5>
          <span class="card-text" v-html="highlightText('Роль: '+item.role)"></span><br>
          <span class="card-text">Email: {{ item.email }}</span>
          <div class="d-flex justify-content-end">
            <span v-if="item.blocked_until != null" class="card-text text-danger me-2">Заблокирован до: {{ item.blocked_until }}</span>
            <a href="#" class="card-link" @click="blockUser(item.id, item.name), showModalBlock = true" v-if="!item.is_blocked">Заблокировать</a>
            <a href="#" class="card-link" @click="unlockUser(item.id, item.name)" v-if="item.is_blocked">Разблокировать</a>
            <a href="#" class="card-link" @click="showModalEditingFunc( item.id ), showModalEditing = true">Изменить</a>
            <a href="#" class="card-link" @click="deleteItem( item.id )">Удалить</a>
          </div>
        </div>
      </div>
    </div>



    <!-- Модальное окно для добавления -->
    <div class="outerModal">
      <div class="modal" tabindex="-1" role="dialog" v-if="showModal" style="display: block; background-color: rgba(0, 0, 0, 0.64);">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Создание нового пользователя</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="showModal = false"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label for="route-name">Имя</label>
                  <input type="text" class="form-control" id="route-name" placeholder="Введите имя пользователя" v-model="name" :class="{'is-invalid': v$.name.$error}">
                  <span class="invalid-feedback" v-if="v$.name.$error">Поле обязательно для заполнения</span>
                </div>
                <div class="mb-3">
                  <label for="route-city">Выберите роль пользователя</label>
                  <select class="form-select" id="route-city" v-model="role">
                    <option value="admin">admin</option>
                    <option value="user" selected>user</option>
                    <option value="guide">guide</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="route-description">Email</label>
                  <input class="form-control" type="text" id="route-description" placeholder="Введите email пользователя" v-model="email" :class="{'is-invalid': v$.email.$error}">
                  <span class="invalid-feedback" v-if="v$.email.$error">Введите правильный email</span>
                </div>
                <div class="mb-3">
                  <label for="route-duration">Пароль</label>
                  <input type="password" class="form-control" id="route-duration" placeholder="Введите пароль" v-model="password" :class="{'is-invalid': v$.password.$error}">
                  <span class="invalid-feedback" v-if="v$.password.$error">Пароль должен быть не короче 6 символов</span>
                </div>
                <div class="mb-3">
                  <label for="route-duration">Подтверждение пароля</label>
                  <input type="password" class="form-control" id="route-duration" placeholder="Подтвердите пароль" v-model="confirm_password" :class="{'is-invalid': v$.confirm_password.$error}">
                  <span class="invalid-feedback" v-if="v$.confirm_password.$error">Пароли не совпадают</span>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="showModal = false">Закрыть</button>
              <button type="button" class="btn btn-primary" @click="add">Добавить</button>
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
              <h5 class="modal-title">Изменить пользователя</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="showModalEditing = false, email = '', name = '', id = ''"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label for="route-name">Имя</label>
                  <input type="text" class="form-control" id="route-name" placeholder="Введите название маршрута" v-model="name" :class="{'is-invalid': v$.name.$error}">
                  <span class="invalid-feedback" v-if="v$.name.$error">Поле обязательно для заполнения</span>
                </div>
                <div class="mb-3">
                  <label for="route-city">Выберите роль пользователя</label>
                  <select class="form-select" id="route-city" v-model="role">
                    <option value="admin">admin</option>
                    <option value="user" selected>user</option>
                    <option value="guide">guide</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="route-description">Email</label>
                  <input class="form-control" type="text" id="route-description" placeholder="Введите описание маршрута" v-model="email" :class="{'is-invalid': v$.email.$error}">
                  <span class="invalid-feedback" v-if="v$.email.$error">Введите правильный email</span>
                </div>
                 <div class="d-flex justify-content-start mb-3">
                    <div>
                      <label class="switch">
                      <input type="checkbox" @change="showPasswordInput = !showPasswordInput">
                      <span class="slider round"></span>
                    </label>
                    </div>
                    <div style="align-self: center;">
                      <span class="text-switch ms-3"><strong>Редактировать пароль</strong></span>
                    </div>
                  </div>
                <div class="mb-3" v-if="showPasswordInput">
                  <label for="route-duration">Пароль</label>
                  <input type="password" class="form-control" id="route-duration" placeholder="Пароль" v-model="password">
                  <span class="invalid-feedback">Пароль должен быть не короче 6 символов</span>
                </div>
                 <div class="mb-3" v-if="showPasswordInput">
                  <label for="route-duration">Подтверждение пароля</label>
                  <input type="password" class="form-control" id="route-duration" placeholder="Подтверждение пароля" v-model="confirm_password">
                  <span class="invalid-feedback">Пароли не совпадают</span>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="showModalEditing = false, email = '', name = '', id = ''">Закрыть</button>
              <button type="button" class="btn btn-primary" @click="saveUpdates(this.id), showPasswordInput = false">Сохранить</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- пагинация -->
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

    <!-- Модальное окно для блокировки -->
    <div class="outerModal">
      <div class="modal" tabindex="-1" role="dialog" v-if="showModalBlock" style="display: block; background-color: rgba(0, 0, 0, 0.64);">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Блокировка пользователя</h5>
              <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close" @click="showModalBlock = false, checkSelectedInput = false, file = ''"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label for="route-name">Имя</label>
                  <input type="text" class="form-control" id="route-name" placeholder="" v-model="blockUserName" disabled>
                </div>
                 <div class="mb-3">
                  <label for="route-description">Дата окончания блокировки</label>
                  <input class="form-control" :min="tomorrow.toISOString().slice(0, 10)" type="date" id="route-description" v-model="dateEnd" :value="tomorrow.toISOString().slice(0, 10)">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="showModalBlock = false, checkSelectedInput = false, fileName = ''">Закрыть</button>
              <button type="button" class="btn btn-danger" :disabled="!isDisabledBlock" @click="block(this.id), showModalBlock = false">Блокировать</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required, email, minLength, sameAs } from '@vuelidate/validators'

import axios from 'axios';
export default {
  setup () {
    return { v$: useVuelidate() }
  },
  data() {
    return {
      data: '',
      showModalEditing: false,
      showModal: false,
      role: 'user',
      searchText: '',
      name: '',
      email: '',
      password: '',
      confirm_password: '',
      errored: false,
      pagination: '',
      showPasswordInput: false,
      showModalBlock: false,
      dateEnd: '',
      id: '',
      blockUserName: '',
      sortValue: 'default',
      originalUser: {
        name: '',
        email: '',
        role: ''
      },
      currentRole: localStorage.getItem('role'),
      tomorrow: new Date(),
    }
  },
  validations() {
    return {
       name: {
      required,
    },
    email: {
      required,
      email,
    },
    password: {
      required,
      minLength: minLength(6)
    },
    confirm_password: {
      sameAsPassword: sameAs(this.password),
    },
    }
  },
  mounted() {
    this.tomorrow.setDate(this.tomorrow.getDate() + 1);
    this.getData()
  },
  computed: {
    isDisabledEdit() {
      if(this.showPasswordInput) {
        return this.name !== '' && this.email !== '' && this.role !== '' && this.password !== '' && this.confirm_password !== '';
      } else {
        return this.name !== '' && this.email !== '' && this.role !== '';
      }
    },
    isDisabledBlock() {
      return this.dateEnd !== '';
    },
    isDisabled() {
      return this.name !== '' && this.email !== '' && this.role !== '' && this.password !== '' && this.confirm_password !== '';
    },
    filteredData() {
      let data = this.$options.filters.searchFilter(this.data, this.searchText);
      data = this.$options.filters.sortFilter(data, this.sortValue);
      return data;
    },
  },
  filters: {
    searchFilter(data, searchText) {
      if (!searchText) return data;
      return data.filter(function(item) {
        return (
          item.name.toLowerCase().indexOf(searchText.toLowerCase()) !== -1 ||
          item.email.toLowerCase().indexOf(searchText.toLowerCase()) !== -1
        );
      });
    },
    sortFilter(data, sortValue) {
      if (!sortValue || sortValue == 'all' || sortValue == 'default') return data;
      return data.filter(function(item) {
        return item.role === sortValue;
      }).sort(function(a, b) {
        return a.name.localeCompare(b.name);
      });
    }
  },
  methods: {
    getData(page = 1) {
      axios.get('/api/users', {
          params: {
            page: page
          }
        })
      .then((response) => {
        console.log(response.data)
        this.data = response.data.data;
        this.pagination = response.data.meta;
        console.log(this.pagination)
      })
    },
    highlightText(text) {
      if (!this.searchText) return text;
      const regex = new RegExp(`(${this.searchText})`, 'gi');
      return text.replace(regex, '<mark style="padding: 0.2em 0 0.2em 0">$1</mark>');
    },
    add() {
      this.v$.$touch();
      if(this.v$.$anyError) {
        return;
      }
      if (!this.v$.$invalid) {
        let formData = new FormData();
        formData.append('name', this.name);
        formData.append('email', this.email);
        formData.append('password', this.password);
        formData.append('role', this.role);

        console.log(this.role, this.name, this.email, this.password)

        axios.post('/api/users/', formData)
        .then(response => {
          console.log(response.data);
          if(response.status == 200) {
            this.showModal = false
            alert('Данные созданы')
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
      axios.get('/api/users/'+id)
      .then(response => {
        this.id = response.data.data.id;
        this.name = response.data.data.name;
        this.email = response.data.data.email;
        this.role = response.data.data.role;
        
        console.log(this.file)
      })
      .catch( error => {
          console.log(error);
          this.errored = true;
      })
    },
    async saveUpdates(id) {
      this.v$.$touch();
      if(this.v$.$anyError) {
        return;
      }
      if (!this.v$.name.$error && !this.v$.email.$error) {
        await axios.get('api/users/'+id).then(response => {
          this.originalUser.name = response.data.data.name
          this.originalUser.email = response.data.data.email
          this.originalUser.role = response.data.data.role
        })
        
        if (
          this.name == this.originalUser.name &&
          this.email == this.originalUser.email &&
          this.role == this.originalUser.role &&
          !this.showPasswordInput
        ) {
          this.showModalEditing = false;
          return;
        }

        let formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('name', this.name);
        formData.append('email', this.email);
        formData.append('role', this.role);

        if(this.showPasswordInput) {
          formData.append('password', this.password);
          formData.append('password_confirmation', this.confirm_password);
        }

        axios.post('/api/users/'+id, formData)
        .then(response => {
          console.log(response.data);
          if(response.status == 200) {
            this.getData()
            this.showModalEditing = false
            alert('Данные обновлены')
          }
        })
        .catch( error => {
            console.log(error);
            this.errored = true;
        })
        }
    },
    blockUser(id, name) {
      this.id = id;
      this.blockUserName = name;
    },
    deleteItem(id) {
      axios.post('/api/users/'+id, {
          _method: 'DELETE'
      })
      .then(() => {
        alert('Пользователь удален!');
      })
      .catch( error => {
          console.log(error);
          this.errored = true;
      })
      this.getData()
    }, 
    block() {
      console.log(this.id, this.dateEnd, this.currentRole)
      axios.post('/api/users/' + this.id + '/block/' + this.dateEnd + '/' + this.currentRole, {
        method: 'PUT',
      })
      .then(response => {
          console.log(response.data);
          if(response.data.success == true) {
            this.getData();
            alert(`Пользователь ${this.blockUserName} заблокирован!`);
          }
      })
      .catch(error => {
          console.error(error);
      });
    },
    unlockUser(id, name) {
      console.log(id, this.currentRole)
      axios.post(`/api/users/${id}/unlock/${this.currentRole}`, {
         method: 'PUT',
      })
      .then(response => {
        if(response.data.success == true) {
            this.getData();
            alert(`Пользователь ${name} разблокирован!`);
          }
      })
    }
  }
};
</script>

<style scoped>
/* Переключатель - коробка вокруг ползунка */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Скрыть флажок HTML по умолчанию */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* Ползунок */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Закругленные ползунки */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

mark, .mark {
  background-color: #2196F3 !important;
  padding: 0% !important;
}

</style>