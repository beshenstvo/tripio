<template>
  <div>
    <div class="text-center p-4 fs-2" v-show="filteredData.length == 0">
      Нет данных
    </div>
     <div class="col-md-12 mb-4" v-for="service in filteredData" :key="service.service.id">
        <div class="card">
          <div class="card-body">
            <div class="row d-flex justify-content-between">
              <div class="col-md-4 outimg">
                <img class="innerimg" :src="'/api/image/public/'+service.service.photo" alt="Изображение">
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-9">
                    <h4 class="card-title"> {{ service.service.name }}</h4>
                    <p class="card-text" v-html="$filters.truncate(service.service.description)"></p>
                  </div> 
                  <div class="col-md-3">
                    <div class="text-end" v-show="currentUser">
                      <button class="btn btn-favorite" @click="toggleFavorite(service)">
                        <i class="far fa-heart fa-lg"
                          :class="{'red fas': service.isLiked }"
                          ></i>
                         
                      </button>
                    </div>
                    <p class="card-text"> <i class="fas fa-clock me-2"></i>Длительность: {{ service.service.duration }}</p>
                    <p class="card-text"><i class="fas fa-ruble-sign me-2"></i>Стоимость: {{ service.service.price }}</p>
                    <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>Город: {{ service.service.cities.name }}</p>
                    <p class="card-text"><i class="fas fa-binoculars me-2"></i>Тип: {{ service.service.type }}</p>
                    <p class="card-text"><i class="fas fa-mountain me-2"></i>Вид: {{ service.service.kind }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <a></a>
            <!-- <a class="btn btn-outline-primary mr-2" v-on:click="more( route.id )"></a> -->
            <router-link class="btn btn-outline-primary mr-2" :to="{ name: 'MoreAboutExcursion', params: { id: service.service.id } }"><i class="fas fa-info-circle"></i><span class="ms-1">Подробнее</span></router-link>
          </div>
        </div>
      </div>

    <div class="alert alert-danger" role="alert" v-if="errored">
      Ошибка загрузки данных!
    </div>

    <!-- прогресс бар -->
    <div class="text-center" v-if="loading">
      <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      loading: true,
      errored: false,
      data: '',
      currentUser: '',
      isLoggedIn: localStorage.getItem('isLoggedIn'),
    }
  },
  mounted() {
    this.getData();
    if(this.isLoggedIn) {
      window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
      axios.get('api/user').then((response) => {
        this.currentUser = response.data;
        console.log(this.currentUser);
      })
    }
  }, 
  computed: {
    filteredData() {
      const filteredArray = Array.from(this.data);

      const filteredData = filteredArray.filter(service => service.user_id == this.currentUser.id)

      // Устанавливаем начальное значение isLiked для каждого объекта service
      filteredData.forEach(service => {
        service.isLiked = this.isFavorite(service);
      });
      console.log(filteredData);

      return filteredData;
    },
  },
  methods: {
    getData() {
      axios.get('/api/favorite_exc')
      .then( response => {
        this.data = response.data.data;
      })
      .catch( error => {
          this.errored = true;
      })
      .finally( () => {
          this.loading = false;
      }); 
    }, 
    toggleFavorite(service) {
      console.log(service)
      const favoriteId = service ? service.id : '';
      const isLiked = service && service.user_id === this.currentUser.id;

      console.log(this.currentUser.id)
      console.log(isLiked)
      if(isLiked) { 
        axios.post('/api/favorite_exc/'+favoriteId, {
          _method: 'DELETE'
        })
        .then((response) => {
          if(response.status == 204) {
          service.isLiked = false;
          this.getData()
          }
        })
        .catch((error) => {
          console.error('Failde to unlike: ', error)
        })
      } else { 
        axios.post('/api/favorite_exc', {
          user_id: this.currentUser.id,
          service_id: service.id
        })
        .then((response) => {
          service.isLiked = true;
          this.getData()
        })
        .catch((error) => {
          console.error('Failed to like:', error);
        });
      }
    },
    isFavorite(service) {
      console.log(service)
      const isLiked = (service.user_id == this.currentUser.id) ? true : false;

      return isLiked; 
    },
  }
}
</script>

<style scoped>
.btn-favorite{
  border: none;
}
.red {
  color: red;
}
</style>