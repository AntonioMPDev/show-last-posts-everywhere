
    Vue.component('posts-comp', {
        props:['siteUrl'],
        data () {
            return {
              posts: [],
              selected: 4,
            }
        },
        mounted () {
            axios
            .get(`${this.siteUrl}/wp-json/wp/v2/posts`)
            .then(response => (this.posts = response.data))
        },
        template: `
        <div>
            <select v-model="selected">
                <option disabled value="Selcciona cuantos deseas ver">Seleccione un elemento</option>
                <option value="2">Ver 2  ultimos posts</option>
                <option value="4">Ver 4 ultimos posts</option>
                <option value="8">Ver 8 ultimos posts</option>
                <option value="10">Ver 10 ultimos posts</option>
            </select>
            <span>Seleccionado: {{ selected }}</span>
            <div class="parent">

                   
                <div v-for="post in posts.slice(0,this.selected)" class="child-post" :key="post.id">
                    <a :href="post.link" >
                        <h2>{{post.title.rendered}}</h2>
                    </a>
                    <div>
                        <a :href="post.link" ><img v-bind:src="post.the_f_img_url"></a>
                    </div>
                </div>
            </div>
        </div>`,



    })


    var app = new Vue({
        el: '#divWpVue',

    })  