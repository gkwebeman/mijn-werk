<template>
    <div class="card mb-3" style="max-width: 100%;">
        <div class="row no-gutters">
            <div class="col-md-4">
            <img :src="movie.poster" alt="" class="card-img">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ movie.title }}</h5>
                    <p class="card-text">{{ movie.plot }}</p>
                    <p class="card-text"><span class="bold">Rating:</span> {{ movie.rating }} stars</p>
                    <p class="card-text"><small class="text-muted">{{ movie.year }}</small></p>
                    <p>
                        <button type="submit" class="btn btn-primary" @click="save">Save</button>
                    </p>
                </div>
            </div>
        </div>        
    </div>
</template>

<script>
export default {
    props: {
        movie: Object,
    },

    data() {
        return {
            key: 'value',
            faveMovies: [],
        }
    },
   
    methods: {
        save(ev){
            ev.preventDefault();
          
            if (localStorage.getItem('favorites')) {
                var storage = JSON.parse(localStorage.getItem('favorites'));

                storage.push(this.movie);

                localStorage.setItem('favorites', JSON.stringify(storage));

                this.faveMovies = storage;
            } else {
                this.faveMovies.push(this.movie);
                let stringMovie = JSON.stringify(this.faveMovies);
                localStorage.setItem('favorites', stringMovie);
                window.console.log(this.movie);
            }
        },
    }
}
</script>