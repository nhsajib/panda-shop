<template>
<div id="component">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-2 mb-5 bg-light">
                    <div class="card-header card-head-bg text-light">
                        <h4 class="card-title"> General Information </h4>
                    </div>

                    <div class="card-body">
                        <div class="card-header bg-dark text-light mb-2">
                            <h5 class="card-title"> Shop Logos </h5>
                        </div>
                          <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <form action="">
                                        <div class="form-group">
                                            <label for="favicon">Favicon</label><br>
                                            <span class="text-danger small">Recommended favicon size 32px X 32px</span>
                                            <input type="file" class="form-control" ref="favicon" v-on:change="faviconH" :class="{ 'is-invalid': shoplogos.errors.has('favicon') }">
                                            <has-error :form="shoplogos" field="favicon"></has-error>
                                            <img class="img-thumbnail mt-1" v-show="favshow" :src="shoplogos.favicon" alt="" style="height: 64px">
                                        </div>
                                        <div class="form-group">
                                            <label for="favicon">Shop Logo</label><br>
                                            <span class="text-danger small">Recommended shop logo size 82px X 60px</span>
                                            <input type="file" class="form-control" ref="shoplogo" v-on:change="shoplogoH" :class="{ 'is-invalid': shoplogos.errors.has('shop_logo') }">
                                            <has-error :form="shoplogos" field="shop_logo"></has-error>
                                            <img class="img-thumbnail mt-1" v-show="logoshow" :src="shoplogos.shop_logo" alt="" style="height: 160px">
                                        </div>
                                    </form>
                                    <div class="card-footer pb-5">
                                        <button class="btn btn-outline-success float-right" @click="updatelogos">Update</button>
                                    </div>
                                </div>
                          </div>

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
                shoplogos: new Form({
                    favicon: null,
                    shop_logo: null,
                }),

                favshow: false,
                logoshow: false,

            }
        },

        methods:{

            faviconH(){
                let selectImg = this.$refs.favicon.files[0];
                let reader = new FileReader();
                if(selectImg){
                    if(selectImg['size'] < 500000 && /\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        reader.readAsDataURL(selectImg);
                        reader.addEventListener("load", function(){
                            this.shoplogos.favicon = reader.result;
                            this.favshow = true;
                        }.bind(this), false);
                    }
                    if(selectImg['size'] > 500000){
                        Notiflix.Notify.Failure('Image size must be less than 500kb');
                        this.shoplogos.favicon = null;
                        this.favshow = false;
                    }
                    if(!/\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        Notiflix.Notify.Failure('File must be an image');
                        this.shoplogos.favicon = null;
                        this.favshow = false;
                    }
                }
            },

            shoplogoH(){
                let selectImg = this.$refs.shoplogo.files[0];
                let reader = new FileReader();
                if(selectImg){
                    if(selectImg['size'] < 500000 && /\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        reader.readAsDataURL(selectImg);
                        reader.addEventListener("load", function(){
                            this.shoplogos.shop_logo = reader.result;
                            this.logoshow = true;
                        }.bind(this), false);
                    }
                    if(selectImg['size'] > 500000){
                        Notiflix.Notify.Failure('Image size must be less than 500kb');
                        this.shoplogos.favicon = null;
                        this.logoshow = false;
                    }
                    if(!/\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        Notiflix.Notify.Failure('File must be an image');
                        this.shoplogos.favicon = null;
                        this.logoshow = false;
                    }
                }
            },


            updatelogos(){
                this.shoplogos.post('/api/admin/shop/setting/logos/update')
                .then(res=>{
                    Notiflix.Notify.Success('Logos successfully updated.');
                })
                .catch(e=>{
                    console.log(e);
                })
            },













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
