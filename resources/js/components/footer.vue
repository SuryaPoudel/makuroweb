
<template lang="html">

  <b-form @submit.prevent="updatefooter()" ref="alert"  v-if="show">
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
              
                <span >Upate Footer</span>
               

                </div>
                <div class="card-body">
                  <div class="form-group">
                   
       
     
            
<b-form-group
                        label="Copy Right:">
                        <b-form-input
                            type="text"
                            v-model="form.copyright"
                            required
                            placeholder="Enter copy right details">
                        </b-form-input>
                        </b-form-group>
     
<div v-if="errors.copyright" class="alert alert-danger" role="alert">{{errors.copyright[0]}}</div>

<b-form-group
                        label="Design & Developed By:">
                        <b-form-input
                            type="text"
                            v-model="form.designby"
                            required
                            placeholder="Enter design & developed by.">
                        </b-form-input>
                        </b-form-group>
     <div v-if="errors.designby" class="alert alert-danger" role="alert">{{errors.designby[0]}}</div>

     <b-form-group
                        label="Developer Url:">
                        <b-form-input
                            type="text"
                            v-model="form.developerurl"
                            required
                            placeholder="Enter developer url.">
                        </b-form-input>
                        </b-form-group>
 <div v-if="errors.developerurl" class="alert alert-danger" role="alert">{{errors.developerurl[0]}}</div>


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
      
      errors:{},
     
      form:{
        copyright:'',
        designby:'',
        developerurl:''
 
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
                updatefooter()
                {
                        this.loaderactive=true;
                        let uri=window.hostname+'/api/footer';
                        Axios.post(uri, this.form).then((response) => {
                        this.loaderactive=false;
                        this.msg=response.data.msg;
                        //this.$refs.alert.$el.focus()
                        this.showAlert()
                        }).catch((error)=> {
                        if(error.response.status==422)
                        {
                            this.loaderactive=false;
                            this.errors=error.response.data.errors;
                        }
                        });

                },

                selectfooterdata()
                {
                        let uri = window.hostname+'/api/footer/1';

                        Axios.get(uri).then((response) => {
                        this.form = response.data;
                    
                        });
                }
      },

created: function()
{
this.selectfooterdata();
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
