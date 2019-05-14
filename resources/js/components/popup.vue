
<template lang="html">

  <b-form @submit.prevent="updatepopup()" ref="alert"  v-if="show">
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



   


            <div class="col-lg-12">
              <div class="card mb-3">
                <div class="card-header">
                
                 <i class="far fa-edit"></i>
              
                <span >Upate Popup</span>
               

                </div>
                <div class="card-body">
                  <div class="form-group">
                   
       
     
            
 <b-form-group
                    label="Content:">
                                     <vue-ckeditor type="classic" v-model="form.content" :upload-adapter="UploadAdapter"></vue-ckeditor>
      </b-form-group>
      <small  class="form-text text-muted">Eg. Important notice or informations. </small>
 
  <br/>
       <div v-if="errors.content" class="alert alert-danger" role="alert">{{errors.content[0]}}</div>

 <b-form-group label="Status:">
      <b-form-radio-group v-model="form.selected"
                          :options="options"
                          name="radioInline">
      </b-form-radio-group>
    </b-form-group>

                


                  <b-button type="submit" variant="primary">Save</b-button>
                  

              <loading v-if="this.loaderactive"></loading>
                  </div>


 
                </div>
              
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

     


        flag:false,
        msg:'',
         dismissSecs:10,
    
            dismissCountDown:0,
            showDismissibleAlert:false,
        loaderactive:false,
      
      errors:{},
     
      form:{
          content:null,
         
      selected: '0',
      

      },
options: [
        { text: 'Publish', value: '0' },
        { text: 'Unpublish', value: '1' },
        
      ],


      show: true
    }
  },
  methods: {


UploadAdapter: function (loader) {
            
            let uri=window.hostname+'/api/browse';
            this.loader = loader
            const body = new FormData();
            let file = this.loader.file;
            let reader = new FileReader();
            reader.onload = (file) => {
                   this.upload = () => {
                    body.append('upload', reader.result);
                  
                        return fetch(uri, {
                            body: body,
                            method: 'POST'
                            })
                            .then(response => response.json())
                            .then(response => {
                                return {
                                default: window.hostname+"/"+response.url
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });

                   }
            this.abort = () => {
                console.log('Abort upload.')
                            }
                  }

             reader.readAsDataURL(file);
            
        },




      
                countDownChanged: function(dismissCountDown) {
                this.dismissCountDown = dismissCountDown
                },
                showAlert: function () {
                this.dismissCountDown = this.dismissSecs
                },
                updatepopup()
                {
                        this.loaderactive=true;
                        let uri=window.hostname+'/api/popup';
                        Axios.post(uri, this.form).then((response) => {
                        this.loaderactive=false;
                        this.msg=response.data.msg;
                   
                        this.showAlert()
                        }).catch((error)=> {
                        if(error.response.status==422)
                        {
                            this.loaderactive=false;
                            this.errors=error.response.data.errors;
                        }
                        });

                },

                selectpopupdata()
                {
                        let uri = window.hostname+'/api/popup/1';

                        Axios.get(uri).then((response) => {
                          if(response.data==='')
                          {
                              this.flag=false;

                          }
                          else
                        {
                            this.flag=true;
                              this.form = response.data;
                                 this.form.selected=response.data.state;
                        }
                      
                    
                        });
                }
      },

        created: function()
        {
       this.selectpopupdata();
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
