
<template lang="html">

  <b-form @submit.prevent="updateHeader()" ref="alert"  v-if="show">
   <b-alert :show="dismissCountDown"
         dismissible
         variant="info"
         @dismissed="dismissCountDown=0"
         @dismiss-count-down="countDownChanged">
  <p text-align="center">{{msg}} </p>
  <b-progress variant="info"
              :max="dismissSecs"
              :value="dismissCountDown"
              height="2px">
  </b-progress>
</b-alert>
    <div class="row">



   <div class="col-lg-4">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-eye"></i>
                  Logo preview</div>
                <div class="card-body">
          
                  <div  >
                 <div class=" mb-2"  ><img width="300" height="83" :src="photoshow" ></div>
                 </div>
                  
                       
            <label class="btn-bs-file btn active btn-xs btn-light" autofocus="true"><i class="fas fa-cloud-upload-alt"></i>
                Change Logo
               <input type="file" @change="showFile"  name="file" class="form-input">
  <!-- <loading ></loading> -->
            
            </label>

                </div>

              </div>
            </div>



            <div class="col-lg-8">
              <div class="card mb-3">
                <div class="card-header">
                
                 <i class="far fa-edit"></i>
              
                <span >Upate Header</span>
               

                </div>
                <div class="card-body">
                  <div class="form-group">
                   
       
     
            
<b-form-group
                        label="Site Title:">
                        <b-form-input
                            type="text"
                            v-model="form.title"
                            required
                            placeholder="Enter site title">
                        </b-form-input>
                        </b-form-group>
     
<div v-if="errors.title" class="alert alert-danger" role="alert">{{errors.title[0]}}</div>

<b-form-group
                        label="Tagline:">
                        <b-form-input
                            type="text"
                            v-model="form.titleabout"
                            required
                            placeholder="In a few words, explain what this site is about.">
                        </b-form-input>
                        </b-form-group>
     <div v-if="errors.titleabout" class="alert alert-danger" role="alert">{{errors.titleabout[0]}}</div>

     <b-form-group
                        label="Site Address URL:">
                        <b-form-input
                            type="text"
                            v-model="form.siteaddress"
                            required
                            placeholder="Enter the address here.">
                        </b-form-input>
                        </b-form-group>
 <div v-if="errors.siteaddress" class="alert alert-danger" role="alert">{{errors.siteaddress[0]}}</div>

<b-form-group
                        label="Site Meta Keywords:">
                        <b-form-textarea id="textarea1"
                     v-model="form.metakeywords"
                     required
                     placeholder="Enter Site Meta Keywords."
                     :rows="3"
                     :max-rows="6">
    </b-form-textarea>
 <small id="passwordHelpBlock" class="form-text text-muted">Eg. Hotels in Nepal, Hotel in Nepal, 5 Star resorts in Nepal, 5 star resort in Nepal, Luxury Hotels in Nepal, Luxury Hotel in Nepal, Luxury 5 Star resorts in Nepal, Luxury 5 Star resort in Nepal.</small>
 
                        </b-form-group>
<div v-if="errors.metakeywords" class="alert alert-danger" role="alert">{{errors.metakeywords[0]}}</div>

                  </div>

                  <b-form-group
                        label="Site Meta Description:">
                        <b-form-textarea id="textarea1"
                     v-model="form.metadescription"
                     required
                     placeholder="Enter Site Meta Description."
                     :rows="3"
                     :max-rows="6">
    </b-form-textarea>
 <small id="passwordHelpBlock" class="form-text text-muted">Eg. Hotels in Nepal – rupakot resort, resorts in Nepal, a deluxe & luxury 5 Star resort located in Kaski, Nepal. A perfect choice for holiday.</small>
 
                        </b-form-group>

    <div v-if="errors.metadescription" class="alert alert-danger" role="alert">{{errors.metadescription[0]}}</div>

                  <b-button type="submit" variant="primary">Publish</b-button>
              <loading v-if="this.loaderactive"></loading>
                  </div>


 
                </div>
                <!-- <div class="card-footer small text-muted">Start writing</div> -->
              </div>
            </div>
         
          </div>



            </b-form>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import loading from './loading.vue';
export default {

components: {

loading
},

  data () {
    return {
        msg:'',
         dismissSecs:10,
    
            dismissCountDown:0,
            showDismissibleAlert:false,
        loaderactive:false,
      parentall:{},
      errors:{},
      photoshow:window.hostname+'/logo/logo.png',
      form:{
title:'',
titleabout:'',
siteaddress:'',
metakeywords:'',
metadescription:''
 
      },
      show: true
    }
  },
  methods: {
      countDownChanged: function(dismissCountDown) {
          this.dismissCountDown = dismissCountDown
        },
        showAlert: function () {
          this.dismissCountDown = this.dismissSecs
        },
                showFile: function(e){
                    let file = e.target.files[0];
                    let reader = new FileReader();

                    let limit = 1024 * 1024 * 5;
                    if(file['size'] > limit){
                      alert('Size limit');
                        return false;
                    }
              
                    reader.onload = (file) => {
                        this.photoshow = reader.result;
               
                     this.uploadImage();
                            }
                    reader.readAsDataURL(file);
                },


                uploadImage()
                {

                     let uri=window.hostname+'/api/changelogo';
                
                        Axios.post(uri, {image:this.photoshow}).then((response) => {
                    
                    }).catch((error)=> {

                    });
                },

                updateHeader()
                {
                     this.loaderactive=true;
                     let uri=window.hostname+'/api/header';
                    Axios.post(uri, this.form).then((response) => {
                   this.loaderactive=false;
                  // this.showDismissibleAlert=true;
                  this.msg=response.data.msg;
                  this.$refs.alert.$el.focus()
                  this.showAlert()
                        }).catch((error)=> {
                        if(error.response.status==422)
                        {
                            this.loaderactive=false;
                            this.errors=error.response.data.errors;
                        }

                        });

                },

                selectheaderdata()
                {
                        let uri = window.hostname+'/api/header/1';

                        Axios.get(uri).then((response) => {
                        this.form = response.data;
                    
                        });
                },

setFocus: function()
    {
      // Note, you need to add a ref="search" attribute to your input.
      this.$refs.search.focus();
    }
      },

created: function()
{
this.selectheaderdata();
}


}
</script>
<style>
.txtUndoable {
    position: relative;
 
}

    .txtUndoable .fa {
        position: absolute;
        right: 0;
        padding: 10px;
        /*pointer-events: none;*/
        cursor: pointer;
        color:#26A8FF;
    }

.txtUndoable {
    padding-right: 30px;
}
.btn-bs-file{
    position:relative;
}
.btn-bs-file input[type="file"]{
    position: absolute;
    top: -9999999;
    filter: alpha(opacity=0);
    opacity: 0;
    width:0;
    height:0;
    outline: none;
    cursor: inherit;
    background: black;
}

</style>
