<template>
<div id="component">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-2 mb-5 bg-light">
                    <div class="card-header card-head-bg text-light">
                        <h4 class="card-title"> Hero Slider Settings </h4>
                    </div>

                    <div class="card-body">
                        <div class="row justify-content-flex-start">
                            <div v-for="(hslide, index) in heroImages" :kye="index" class="col-md-3 mt-2">
                                <figcaption class="figure-caption text-center">Slide {{index+1}}</figcaption>
                                <img :src="'/upload/img/'+hslide.img" alt="" width="100%">
                                <button class="btn btn-outline-danger hsliddelete" @click="deleteSlide(hslide.id)">
                                    <i aria-hidden="true" title="Delete Image" class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-2" style="background-color: rgba(0, 0, 0, 0.03)">
                            <div class="col-md-6 mt-2 p-2">
                                <form @submit.prevent="">
                                    <div class="form-group">
                                        <label for="image_url">Add Hero Slider<span class="text-danger">*</span></label>
                                        <br>
                                        <span class="text-warning">Recommended size 1110px x 580px</span>

                                        <input type="file"  class="form-control" id="image_url" ref="heroImg" accept="image/*" v-on:change="heroImgH()" :class="{ 'is-invalid': heroImg.errors.has('image') }">
                                        
                                        <has-error :form="heroImg" field="img"></has-error>
                                        <div class="mt-1" v-show="imgPreview">
                                            <img :src="heroImg.image" class="img-thumbnail" style="width: 50%" alt=""/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="herourl">Slider Image URL</label>
                                        <input type="text" v-model="heroImg.url" class="form-control" placeholder="Slider image url" :class="{ 'is-invalid': heroImg.errors.has('url') }">
                                        <has-error :form="heroImg" field="url"></has-error>
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2" @click="addHeroImg">&nbsp; Add &nbsp;</button>
                                </form>
                            </div>
                        </div>  
                    </div>
                    
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
    export default {
        data(){
            return{
                heroImages: [],
                heroImg: new Form({
                    image: null,
                    url: '',
                }),
                imgPreview: false,
            }
        },

        methods:{

            deleteSlide($id){
                Notiflix.Confirm.Show(
                    'Delete Confirm',
                    'Do you want to delete this slider image?',
                    'Yes',
                    'No',
                    function(){
                        Notiflix.Block.Dots('div#sliderimgs', 'Please wait...');
                        axios.delete('/api/admin/shop/setting/heroslider/delete/'+$id)
                        .then(res=>{
                            Notiflix.Notify.Success('Hero slider image successfully deleted.');
                            this.getHeroSlider();
                            Notiflix.Block.Remove('div#sliderimgs', 600);
                        })
                        .catch(e=>{
                            console.log(e);
                            Notiflix.Block.Remove('div#sliderimgs', 600);
                        })
                    }.bind(this),
                );
            },

            heroImgH(){
                let selectImg = this.$refs.heroImg.files[0];
                let reader = new FileReader();
                if(selectImg){
                    if(selectImg['size'] < 500000 && /\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        reader.readAsDataURL(selectImg);
                        reader.addEventListener("load", function(){
                            this.heroImg.image = reader.result;
                            this.imgPreview = true;
                        }.bind(this), false);
                    }
                    if(selectImg['size'] > 500000){
                        Notiflix.Notify.Failure('Image size must be less than 500kb');
                        this.heroImg.image = null;
                        this.imgPreview = false;
                    }
                    if(!/\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        Notiflix.Notify.Failure('File must be an image');
                        this.heroImg.image = null;
                        this.imgPreview = false;
                    }
                }
            },

            addHeroImg(){
                Notiflix.Block.Dots('div#sliderimgs', 'Please wait...');
                this.heroImg.post('/api/admin/shop/setting/heroslider/add')
                .then(res=>{
                    Notiflix.Notify.Success('Hero slider images successfully added.');
                    this.getHeroSlider();
                    Notiflix.Block.Remove('div#sliderimgs', 600);

                })
                .catch(e=>{
                    Notiflix.Block.Remove('div#sliderimgs', 600);
                })
            },

            getHeroSlider(){
                axios.get('/api/admin/shop/setting/heroslider/get')
                .then(res=>{
                    this.heroImages = res.data.data;
                })
                .catch()
            }
        },

        mounted() {
            this.getHeroSlider();
        }
    }
</script>
