<template>
    <div>
        <h1>
            Favorite movies
        </h1>

        <div class="row row-cols-1 row-cols-md-3">
            <div class="col mb-4" v-for= "(faveMovie, index) in faveMovies" v-bind:key="index">
                <div class="card">
                <img :src="faveMovie.poster" class="card-img-top image" alt="...">
                    <div class="card-body" style="text-align: center">
                        <p class="card-text">{{ faveMovie.title }}</p>
                    </div>
                <button class="btn btn-danger" :value="faveMovie.id" @click="remove">Remove</button>
                </div>
            </div>
        </div>
        
        <p>
            <input type="submit" @click="showFavoriteMovie" value="show" class="btn btn-primary">
        </p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            key: 'value',
            faveMovies: [],
        }
    },
   
    methods: {
        showFavoriteMovie(ev){
            ev.preventDefault();
          
            if (localStorage.getItem('favorites')) {
                var storage = JSON.parse(localStorage.getItem('favorites'));
                this.faveMovies = storage;
            }
        },
        remove(ev) {
            ev.preventDefault();
            
            if (localStorage.getItem('favorites')) {
                var storage = JSON.parse(localStorage.getItem('favorites'));
                this.faveMovies = storage;
            }

//             for (var i =0; i< faveMovies.length; i++) {
//                 var faveMovies = JSON.parse(faveMovies[i]);
//                 if (items.itemId == 3) {
//                     items.splice(i, 1);
//                 }
// }

            
        }
    }
}
</script>