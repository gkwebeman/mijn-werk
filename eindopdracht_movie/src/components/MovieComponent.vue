<template>
    <div>
        <MovieFormComponent @getData="getData"/>
        
        <MovieCardComponent
            v-for="(movie, index) in movieData" 
            v-bind:index="index"
            v-bind:movie="movie"
            v-bind:key="index"
        />

        <FavoriteMovieComponent />

    </div>
</template>

<script>
    import MovieFormComponent from './MovieFormComponent'
    import MovieCardComponent from './MovieCardComponent'
    import FavoriteMovieComponent from './FavoriteMovieComponent'
    export default {
        name: "MovieComponent", 
        components : {
            MovieFormComponent,
            MovieCardComponent,
            FavoriteMovieComponent
        },
        props: {}, 
        data() {
            return {
                key: 'value',
                movies: [],
                movieData: []
            }
        },

        methods: {
            getMovieInfo(value){
                fetch("https://imdb-internet-movie-database-unofficial.p.rapidapi.com/film/" + value.title, {
                    "method": "GET",
                    "headers": {
                    "x-rapidapi-host": "imdb-internet-movie-database-unofficial.p.rapidapi.com",
                    "x-rapidapi-key": "ad0208d137msh61f916aa9e5e823p16c9aajsn1f8853ab566e"
                    }
                })

                .then(response => {
                    response.json().then(data => {
                        // window.console.log(data);
                        this.movieData = [data]; 

                    })
                })
                .catch(err => {
                    window.console.log(err);
                });
            },

            getData (value) {
                this.getMovieInfo(value);
            },

           
        } ,
    }
</script>