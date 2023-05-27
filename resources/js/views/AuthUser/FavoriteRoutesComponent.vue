<template>
  <div>
    <div class="text-center p-4 fs-2" v-show="filteredData.length == 0">
      Нет данных
    </div>
     <div class="col-md-12 mb-4" v-for="route in filteredData" :key="route.route.id">
        <div class="card">
          <div class="card-body">
            <div class="row d-flex justify-content-between">
              <div class="col-md-4 outimg">
                <img class="innerimg" :src="'/api/image/public/'+route.route.photo" alt="Изображение">
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-9">
                    <h4 class="card-title"> {{ route.route.name }}</h4>
                    <p class="card-text" v-html="$filters.truncate(route.route.description)"></p>
                  </div> 
                  <div class="col-md-3">
                    <div class="text-end" v-show="currentUser">
                      <button class="btn btn-favorite" @click="toggleFavorite(route)">
                        <i class="far fa-heart fa-lg"
                          :class="{'red fas': route.isLiked }"
                          ></i>
                         
                      </button>
                    </div>
                    <p class="card-text"> <i class="fas fa-clock me-2"></i>Длительность: {{ route.route.duration }}</p>
                    <p class="card-text"><i class="fas fa-map-marker-alt me-2"></i>Город: {{ route.route.cities.name }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between">
            <a></a>
            <!-- <a class="btn btn-outline-primary mr-2" v-on:click="more( route.id )"></a> -->
            <router-link class="btn btn-outline-primary mr-2" :to="{ name: 'MoreAboutRoute', params: { id: route.route.id } }"><i class="fas fa-info-circle"></i><span class="ms-1">Подробнее</span></router-link>
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

      const filteredData = filteredArray.filter(route => route.user_id == this.currentUser.id)

      // Устанавливаем начальное значение isLiked для каждого объекта route
      filteredData.forEach(route => {
        route.isLiked = this.isFavorite(route);
      });
      console.log(filteredData);

      return filteredData;
    },
  },
  methods: {
    getData() {
      axios.get('/api/favorite_routes')
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
    toggleFavorite(route) {
      console.log(route)
      const favoriteId = route ? route.id : '';
      const isLiked = route && route.user_id === this.currentUser.id;

      console.log(this.currentUser.id)
      console.log(isLiked)
      if(isLiked) { 
        axios.post('/api/favorite_routes/'+favoriteId, {
          _method: 'DELETE'
        })
        .then((response) => {
          if(response.status == 204) {
          route.isLiked = false;
          this.getData()
          }
        })
        .catch((error) => {
          console.error('Failde to unlike: ', error)
        })
      } else { 
        axios.post('/api/favorite_routes', {
          user_id: this.currentUser.id,
          ready_routes_id: route.id
        })
        .then((response) => {
          route.isLiked = true;
          this.getData()
        })
        .catch((error) => {
          console.error('Failed to like:', error);
        });
      }
    },
    isFavorite(route) {
      console.log(route)
      const isLiked = (route.user_id == this.currentUser.id) ? true : false;

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