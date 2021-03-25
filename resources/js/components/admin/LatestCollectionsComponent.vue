<template>
<div id="component">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form @submit.prevent="">
                    <div class="card mt-2 mb-5 bg-light">
                        <div class="card-header card-head-bg text-light">
                            <h4 class="card-title"> Featured Products Setting </h4>
                        </div>
                        <div class="card-body" id="featured_main">
                            <div class="row justify-content-center" id="lcsection">
                                <div class="col-md-6">
                                    <h4 class="text-center">Left Section</h4>
                                    <hr>
                                    <div class="form-group">
                                        <label for="lctitle">Title</label>
                                        <input type="text" v-model="lcdata.title" class="form-control" id="lctitle" :class="{ 'is-invalid': lcdata.errors.has('title') }">
                                        <has-error :form="lcdata" field="title"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcdesc">Description</label>
                                        <textarea v-model="lcdata.desc" class="form-control" rows="5" id="lcdesc" :class="{ 'is-invalid': lcdata.errors.has('desc') }"></textarea>
                                        <has-error :form="lcdata" field="desc"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcbtn">Button Text</label>
                                        <input type="text" v-model="lcdata.btntext" class="form-control" id="lcbtn" :class="{ 'is-invalid': lcdata.errors.has('btntext') }">
                                        <has-error :form="lcdata" field="btntext"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcbtn">Button URL</label>
                                        <input type="text" v-model="lcdata.btnurl" class="form-control" id="lcbtn" :class="{ 'is-invalid': lcdata.errors.has('btnurl') }">
                                        <has-error :form="lcdata" field="btnurl"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcimg">Image</label>
                                        <input type="file" v-on:change="lcimg" accept="image/*" ref="lcimg" class="form-control" id="lcimg" :class="{ 'is-invalid': lcdata.errors.has('image') }">
                                        <has-error :form="lcdata" field="image"></has-error>
                                    </div>
                                    <img v-show="imgPreview" :src="lcdata.image" alt="" width="50%">
                                    <img v-show="SimgPreview" :src="'/upload/img/'+lcdata.image" alt="" width="50%">

                                </div>
                                <div class="col-md-6">
                                    <h4 class="text-center">Right Section</h4>
                                    <hr>
                                    <div class="form-group">
                                        <label for="lctitle2">Title</label>
                                        <input type="text" v-model="lcdata.title2" class="form-control" id="lctitle2" :class="{ 'is-invalid': lcdata.errors.has('title2') }">
                                        <has-error :form="lcdata" field="title2"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcdesc2">Description</label>
                                        <textarea v-model="lcdata.desc2" class="form-control" rows="5" id="lcdesc2" :class="{ 'is-invalid': lcdata.errors.has('desc2') }"></textarea>
                                        <has-error :form="lcdata" field="desc2"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcbtn">Button Text</label>
                                        <input type="text" v-model="lcdata.btntext2" class="form-control" id="lcbtn2" :class="{ 'is-invalid': lcdata.errors.has('btntext2') }">
                                        <has-error :form="lcdata" field="btntext2"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcbtn2">Button URL</label>
                                        <input type="text" v-model="lcdata.btnurl2" class="form-control" id="lcbtn2" :class="{ 'is-invalid': lcdata.errors.has('btnurl2') }">
                                        <has-error :form="lcdata" field="btnurl2"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="lcimg2">Image</label>
                                        <input type="file" v-on:change="lcimg2" accept="image/*" ref="lcimg2" class="form-control" id="lcimg2" :class="{ 'is-invalid': lcdata.errors.has('image2') }">
                                        <has-error :form="lcdata" field="image2"></has-error>
                                    </div>
                                    <img v-show="imgPreview2" :src="lcdata.image2" alt="" width="50%">
                                    <img v-show="SimgPreview2" :src="'/upload/img/'+lcdata.image2" alt="" width="50%">
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button class="btn btn-outline-success" @click="updatelc"> Save </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data(){
            return{
                lcdata: new Form({
                    //Section Left
                    id: '',
                    title: '',
                    desc: '',
                    btntext: '',
                    btnurl: '',
                    image: '',

                    //Section Right
                    id2: '',
                    title2: '',
                    desc2: '',
                    btntext2: '',
                    btnurl2: '',
                    image2: '',
                }),

                imgPreview: false,
                imgPreview2: false,
                
                SimgPreview: false,
                SimgPreview2: false,


            }
        },

        methods:{

            lcimg(){
                
                this.SimgPreview = false;
                let selectImg = this.$refs.lcimg.files[0];
                let reader = new FileReader();
                if(selectImg){
                    if(selectImg['size'] < 500000 && /\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        reader.readAsDataURL(selectImg);
                        reader.addEventListener("load", function(){
                            this.lcdata.image = reader.result;
                            this.imgPreview = true;
                        }.bind(this), false);
                    }
                    if(selectImg['size'] > 500000){
                        Notiflix.Notify.Failure('Image size must be less than 500kb');
                        this.lcdata.image = null;
                        this.imgPreview = false;
                    }
                    if(!/\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        Notiflix.Notify.Failure('File must be an image');
                        this.lcdata.image = null;
                        this.imgPreview = false;
                    }
                }
            },


            lcimg2(){

                this.SimgPreview2 = false;
                let selectImg = this.$refs.lcimg2.files[0];
                let reader = new FileReader();
                if(selectImg){
                    if(selectImg['size'] < 500000 && /\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        reader.readAsDataURL(selectImg);
                        reader.addEventListener("load", function(){
                            this.lcdata.image2 = reader.result;
                            this.imgPreview2 = true;
                        }.bind(this), false);
                    }
                    if(selectImg['size'] > 500000){
                        Notiflix.Notify.Failure('Image size must be less than 500kb');
                        this.lcdata.image2 = null;
                        this.imgPreview2 = false;
                    }
                    if(!/\.(jpe?g|png|gif)$/i.test(selectImg.name)){
                        Notiflix.Notify.Failure('File must be an image');
                        this.lcdata.image2 = null;
                        this.imgPreview2 = false;
                    }
                }
            },

            updatelc(){
                Notiflix.Block.Dots('div#lcsection', 'Please wait...')
                this.lcdata.put('/api/admin/shop/setting/latest-collections/update')
                .then(res=>{
                    Notiflix.Notify.Success('Latest Collection successfully save.');
                    this.getlatestCollection();
                    Notiflix.Block.Remove('div#lcsection', 600)
                })
                .catch(e=>{
                    console.log(e);
                    Notiflix.Block.Remove('div#lcsection', 600)
                })
            },
            getlatestCollection(){
                axios.get('/api/admin/shop/setting/latest-collections/get')
                .then(res=>{
                    this.lcdata.id = res.data[0].id;
                    this.lcdata.title = res.data[0].option1;
                    this.lcdata.desc = res.data[0].text;
                    this.lcdata.btntext = res.data[0].option2;
                    this.lcdata.btnurl = res.data[0].url;
                    this.lcdata.image = res.data[0].img;
                    this.SimgPreview = true;

                    this.lcdata.id2 = res.data[1].id;
                    this.lcdata.title2 = res.data[1].option1;
                    this.lcdata.desc2 = res.data[1].text;
                    this.lcdata.btntext2 = res.data[1].option2;
                    this.lcdata.btnurl2 = res.data[1].url;
                    this.lcdata.image2 = res.data[1].img;
                    this.SimgPreview2 = true;
                })
                .catch()
            },

        },

        mounted() {
            this.getlatestCollection();
        }
    }
</script>
