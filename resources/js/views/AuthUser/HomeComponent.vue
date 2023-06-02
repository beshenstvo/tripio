<template>
  <div class="home text-center">
    <!-- search
    <div class="img" id="img">
      <div class="input-group search pt-5 pb-5">
        <input type="search" class="form-control rounded" placeholder="Поиск города" aria-label="Search" aria-describedby="search-addon" />
        <button type="button" class="btn btn-outline-dark">поиск</button>
      </div>
      <div id="pentagon"></div>
    </div> -->


   <div class="main-container">
    <div class="overlay">
      <form>
        <p class="slogan">Открой Россию с нами - путешествуй по-новому!</p>
        <p class="pod-slogan">Насладись бескрайними просторами, захватывающими приключениями и впечатлениями, которые оставят твои сердце греться навсегда.</p>
        <input type="text" class="search-container" placeholder="В какой город едем?">
      </form>
    </div>
  </div>


    <!-- Популярные города -->
    
    <div class="container mt-3 mb-3">
      <div class="text-center p-3"> 
        <h2>Начните вашу поездку</h2>
        <p>с самых посещаемых городов</p>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="card cardstyle card1 p-4">
            <div class="card-body">
              <h5 class="card-title card-title-style text-light fw-bold">Москва</h5>
              <p class="card-text card-text-style text-light">Окунись в атосмеформу бесконечной суеты.</p>
              <a href="#" class="btn btn-light btnstyle">Подробнее</a>
            </div>
          </div>
          <!-- <div class="card-footer p-3">
            <i class="fas fa-map-marker-alt me-2"></i><span>Название </span>
          </div> -->
        </div>
        <div class="col-sm-6">
          <div class="card cardstyle card2 p-4">
            <div class="card-body">
              <h5 class="card-title card-title-style text-light fw-bold">Казань</h5>
              <p class="card-text card-text-style text-light">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-light btnstyle">Подробнее</a>
            </div>
          </div>
          <!-- <div class="card-footer p-3">
            <i class="fas fa-map-marker-alt me-2"></i><span>Название </span>
          </div> -->
        </div>
        <div class="col-sm-6 mt-4">
          <div class="card cardstyle card3 p-4">
            <div class="card-body">
              <h5 class="card-title card-title-style text-light fw-bold">Самара</h5>
              <p class="card-text card-text-style text-light">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-light btnstyle">Подробнее</a>
            </div>
          </div>
          <!-- <div class="card-footer p-3">
            <i class="fas fa-map-marker-alt me-2"></i><span>Название </span>
          </div> -->
        </div>
        <div class="col-sm-6 mt-4">
          <div class="card cardstyle card4 p-4">
            <div class="card-body">
              <h5 class="card-title card-title-style text-light fw-bold">Санкт-Петербург</h5>
              <p class="card-text card-text-style text-light">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#" class="btn btn-light btnstyle">Подробнее</a>
            </div>
          </div>
          <!-- <div class="card-footer p-3">
            <i class="fas fa-map-marker-alt me-2"></i><span>Название </span>
          </div> -->
        </div>

      </div>
    </div>
    

    <!-- Популярные направления для любителей природы -->
    
     <div class="container mt-5 mb-5">
      <h2 class="mt-4" style="text-align: left;"></h2>
      <div class="text-center p-3"> 
        <h2>Начните вашу поездку</h2>
        <p>с самых посещаемых городов</p>
      </div>
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


    <!--Start of Tawk.to Script-->
    <div id="tawkchat-component"></div>
    <!--End of Tawk.to Script-->

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
    const script = document.createElement('script');
    script.src = 'https://embed.tawk.to/6476035a74285f0ec46e81a0/1h1mfq705';
    script.async = true;
    script.setAttribute('crossorigin', '*');
    document.head.appendChild(script);
    if(this.isLoggedIn) {
        window.axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        axios.get('api/user').then((response) => {
          this.currentUser = response.data;
          console.log(this.currentUser);
        })
      }
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

.pod-slogan {
  color: rgb(255, 255, 255);
  font-family: inherit;
  width: 50%;
  font-size: 1.2em;
  margin-left: auto;
  margin-right: auto;
}
.slogan {
  color: rgb(196, 160, 201);
  font-family: inherit;
  font-size: 3.5em;
}
.main-container {
  min-height: 94vh;
  background-blend-mode: multiply;
  background-image: url('http://127.0.0.1:8000/storage/fon2.jpg');
  background-color: rgba(0, 0, 0, 0.2);
  background-size: cover;
  display: flex;
  align-items: center;
  background-position: center;
  background-repeat: no-repeat;
  justify-content: center;
  position: relative;
  width: 100%;
  top: 0;
}

.search-container {
  position: relative;
  width: 1000px;
  max-width: 50%;
  background-color: rgba(0, 0, 0, 0.5);
  border: 1px solid rgb(194, 147, 216);
  border-radius: 10px !important;
  padding: 0.7rem;
  color: white !important;
}

::placeholder {
  color: rgb(194, 147, 216);
}

.search-container::before {
  content: '\f002'; /* код иконки поиска в Font Awesome */
  font-family: 'Font Awesome 5 Free';
  font-weight: 900;
  font-size: 16px;
  color: #ffffff;
  position: absolute;
  top: 50%;
  left: 8px;
  transform: translateY(-50%);
  z-index: 1;
}
</style>