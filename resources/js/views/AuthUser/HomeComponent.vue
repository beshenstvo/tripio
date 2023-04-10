<template>
  <div class="home text-center py-4">
    <!-- <p>{{ currentUser.email }}</p> -->
    <!-- search -->
    <div class="img" id="img">
      <div class="input-group search pt-5 pb-5">
        <input type="search" class="form-control rounded" placeholder="Поиск города" aria-label="Search" aria-describedby="search-addon" />
        <button type="button" class="btn btn-outline-dark">поиск</button>
      </div>
      <div id="pentagon"></div>
    </div>

    <!-- Популярные города -->
    
    <div class="container mt-3 mb-3">
      <h2 style="text-align: left;">Популярные города</h2>
      <div class="row">
        <div class="col-sm-6">
          <div class="card cardstyle card1 pt-4 mt-2 pb-4">
            <div class="card-body">
              <h5 class="card-title card-title-style text-light fw-bold">Москва</h5>
              <p class="card-text card-text-style text-light">Окунись в атосмеформу бесконечной суеты.</p>
              <a href="#" class="btn btn-light btnstyle">Подробнее</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card cardstyle card2 pt-4 mt-2 pb-4">
            <div class="card-body">
              <h5 class="card-title card-title-style text-light fw-bold">Казань</h5>
              <p class="card-text card-text-style text-light">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-light btnstyle">Подробнее</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card cardstyle card3 pt-4 mt-4 pb-4">
            <div class="card-body">
              <h5 class="card-title card-title-style text-light fw-bold">Самара</h5>
              <p class="card-text card-text-style text-light">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-light btnstyle">Подробнее</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card cardstyle card4 pt-4 mt-4 pb-4">
            <div class="card-body">
              <h5 class="card-title card-title-style text-light fw-bold">Санкт-Петербург</h5>
              <p class="card-text card-text-style text-light">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-light btnstyle">Подробнее</a>
            </div>
          </div>
        </div>

      </div>
    </div>
    

    <!-- Популярные направления для любителей природы -->
    
     <div class="container mt-5 mb-5">
      <h2 class="mt-4" style="text-align: left;">Популярные направления для любителей природы</h2>
      <div class="row">
        <div class="col-sm-4">
          <div class="card mb-3">
            <img src="https://mdbcdn.b-cdn.net/img/new/slides/041.webp" class="card-img-top" alt="Wild Landscape"/>
            <div class="card-body" style="text-align: left;">
              <h5 class="card-title">Вулкан Шивелуч, Камчатка</h5>
              <p class="card-text">
                <small class="text-muted"><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i> 5/5 (678)</small>
              </p>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card mb-3">
            <img src="https://mdbcdn.b-cdn.net/img/new/slides/041.webp" class="card-img-top" alt="Wild Landscape"/>
            <div class="card-body" style="text-align: left;">
              <h5 class="card-title">Вулкан Шивелуч, Камчатка</h5>
              <p class="card-text">
                <small class="text-muted"><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i> 5/5 (678)</small>
              </p>
            </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="card mb-3">
            <img src="https://mdbcdn.b-cdn.net/img/new/slides/041.webp" class="card-img-top" alt="Wild Landscape"/>
            <div class="card-body" style="text-align: left;">
              <h5 class="card-title">Вулкан Шивелуч, Камчатка</h5>
              <p class="card-text">
                <small class="text-muted"><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i><i class="fa-solid fa-star" style="color: #a04eff;"></i> 5/5 (678)</small>
              </p>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "Home",
   data() {
    return {
      currentUser: "",
      token: localStorage.getItem("token")
    };
  },
  methods: {
    
  }, 
  mounted() {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
    axios.get('api/user').then((response) => {
      this.currentUser = response.data;
    })
  }
};
</script>

<style scoped>
.img { 
  width: 100%; 
  /* height: 300px;  */
  object-fit: cover; 
  object-position: bottom; 
  /* fallback for old browsers */
  background: #6a11cb;

  /* Chrome 10-25, Safari 5.1-6 */
  background: -webkit-linear-gradient(to right, rgba(106, 17, 203, .5), rgba(37, 117, 252, .5));

  /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  background: linear-gradient(to right, rgba(106, 17, 203, .5), rgba(37, 117, 252, .5));
  /* background-image: url('http://127.0.0.1:8000/storage/bajkal-zimoj.jpg'); */
  background-size: cover;
  /* background-position: center; */
  background-position: top right 10px, bottom left, top left;
  background-repeat: no-repeat, repeat-x, repeat-x ;
  box-shadow: 1px 1px 7px 1px rgba(0, 0, 0, .2);
}
.search {
  width: 60%;
  margin-left: auto;
  margin-right: auto;
}
input {
  border-radius: 4px 0px 0px 4px !important;
  /* border: solid black 1px; */
  padding: .5rem;
  box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5);
}
.cardstyle {
  object-fit: cover; 
  object-position: bottom; 
  background-size: cover;
  background-position: center;
  border: none;
  background-blend-mode: multiply;
  box-shadow: 1px 1px 7px 1px rgba(0, 0, 0, .3);
  transition: all 0.5s ease-in;
  overflow: hidden;
  width: auto;
  height: 100%
}
.card2 {
  background-image: url('http://127.0.0.1:8000/storage/05fab50966ea5bb084ad00821d7c9dfa.webp');
}
.card1 {
  background-image: url('http://127.0.0.1:8000/storage/pexelsvierro3629813.webp');
}
.card3 {
  background-image: url('http://127.0.0.1:8000/storage/1661439903_10-celes-club-p-vidi-samari-instagram-10.jpg');
  background-position: center;
}
.card4 {
  background-image: url('http://127.0.0.1:8000/storage/Санкт-Петербург-1200x778.jpg');
}
.card-title-style, .card-text-style {
  transition: all 0.4s ease-in;
  transform: translateY(-1.5in);
}
.btnstyle {
  transition: all 0.4s ease-in;
  transform: translateY(1.5in);
}
.cardstyle:hover {
  background-color: rgba(0, 0, 0, 0.31);
}
.cardstyle:hover .card-title-style {
  transform: translateY(0in);
}
.cardstyle:hover .card-text-style {
  transform: translateY(0in);
}
.cardstyle:hover .btnstyle {
  transform: translateY(0in);
}
.btn-outline-dark {
  box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5);
  background-color: white;
  border: none;
  transition: all 0.4s ease-out;
}


.btn-outline-dark:hover {
  background-color: #5599FF;
}

</style>