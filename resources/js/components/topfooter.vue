
<template lang="html">

  <b-form @submit.prevent="editmode ? updateTopFooterdata() : saveTopFooterdata() " @reset="onReset" v-if="show">
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
                 Footer logo preview</div>
                <div class="card-body">
          
                  <div  >
                 <div class=" mb-2"  ><img width="100%"  :src="photoshow" ></div>
                 </div>
                  
                       
            <label class="btn-bs-file btn active btn-xs btn-light" autofocus="true"><i class="fas fa-cloud-upload-alt"></i>
                Change Footer Logo
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
              
                <span >Upate Top Footer</span>
               

                </div>
                <div class="card-body">
                  <div class="form-group">
                   
       
     
            
<b-form-group
                        label="Heading:">
                        <b-form-input
                            type="text"
                            v-model="form.heading"
                          required
                            placeholder="Enter heading">
                        </b-form-input>
                        </b-form-group>
     
<div v-if="errors.heading" class="alert alert-danger" role="alert">{{errors.heading[0]}}</div>


                  <div class="form-group">
                    <b-form-group
                    label="Short Content:">
                                     <vue-ckeditor type="classic" v-model="form.content" :upload-adapter="UploadAdapter"></vue-ckeditor>
      </b-form-group>
                  </div>
                  <div v-if="errors.content" class="alert alert-danger" role="alert">{{errors.content[0]}}</div>


                  <b-button type="submit" variant="primary">Publish</b-button>

                       <b-button v-if="this.editmode" type="reset" variant="danger">Clear</b-button>
            
              <loading v-if="this.loaderactive"></loading>


<br/><br/>


<!-- table -->
<div class="table-responsive">
                    <table  id="mytable" class="table table-bordred table-striped">


                         <thead>


                         <th>Heading</th>
                          <th>Content</th>
                           <th>Action</th>


                         </thead>
          <tbody>

          <tr v-for="(data, index) in alldata">
          <td>{{data.heading}}</td>
          <td>{{data.content}}</td>
         <td>           <div  class="btn btn-warning btn-sm"  @click="selectFooterDatasingleByid(data.id)" ><i class="fas fa-pen-square"></i></div>
          <div class="btn btn-danger btn-sm" @click="askfordelete(data.id,data.heading,index)" ><i   class="fas fa-trash-alt"></i></div>
</td>

       </tr>

          </tbody>

      </table>
</div >
<div >
  <b-modal v-model="modalShow"  @ok="handleOk">
        Do you really want to delete {{heading}} ?
      </b-modal>
</div>
<!-- end table -->



                  </div>


 
                </div>
               
              </div>
            </div>
         
          </div>



            </b-form>
</template>

<script>
import loading from './loading.vue';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import VueCkeditor from 'vue-ckeditor5'
    Vue.use(VueCkeditor.plugin, {
      editors: {
        'classic': ClassicEditor
      }
    })

export default {

components: {

loading
},

  data () {
    return {
          modalShow: false,
           editmode:false,
        msg:'',
        editid:'',
        alldata:{},
         dismissSecs:10,
     editorData: '',
            dismissCountDown:0,
            showDismissibleAlert:false,
        loaderactive:false,
      errors:{},
      heading:'',
      deleteid:'',
      td_id:'',

      photoshow:window.hostname+'/logo/footerlogo.png',
      form:{
          content:'',
          heading:''

      },
      show: true
    }
  },
  methods: {


handleOk: function()
{
    
//delete is done here
let uri=window.hostname+'/api/topfooter/'+this.deleteid;
    Axios.delete(uri).then((response) => {
      this.alldata.splice(this.td_id,1)
        this.msg=response.data.msg;
    })
.catch(error => {
    console.log(error)
});
},

askfordelete($id,$heading,$index){

this.modalShow=true;
  this.heading=$heading;
  this.deleteid=$id;
  this.td_id=$index;
   
},
      
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

                     let uri=window.hostname+'/api/changefooterlogo';
                
                        Axios.post(uri, {image:this.photoshow}).then((response) => {
                     this.msg='Done successfully';
                      this.showAlert();
                    }).catch((error)=> {

                    });
                },



                updateTopFooterdata()
                {

                                      
                    let uri = window.hostname+'/api/topfooter/'+this.editid;
                        Axios.patch(uri, this.form).then((response) => {

                  this.msg=response.data.msg;
                   this.showAlert();
                    this.editmode=false;
          this.form.heading='';
          this.form.content='';
          
                  this.selectTopFooterData();
                        });
                },
                saveTopFooterdata()
                {
                     this.loaderactive=true;
                     let uri=window.hostname+'/api/topfooter';
                     
                    Axios.post(uri, this.form).then((response) => {
                   this.loaderactive=false;
                  this.msg=response.data.msg;
                  this.selectTopFooterData();
                  this.form.heading='';
                  this.form.content='';
                  this.showAlert()
                        }).catch((error)=> {
                        if(error.response.status==422)
                        {
                            this.loaderactive=false;
                            this.errors=error.response.data.errors;
                        }

                        });

                },


                selectFooterDatasingleByid($id)
                {
                    this.editmode=true;
                    this.editid=$id;
                   let uri = window.hostname+'/api/topfooter/'+$id;

                    Axios.get(uri).then((response) => {
                   
                        this.form=response.data;
                    });
                },

                selectTopFooterData()
                {
                        let uri = window.hostname+'/api/topfooter';

                        Axios.get(uri).then((response) => {
                        this.alldata = response.data;
                    
                        });
                },

 onReset (evt) {
          evt.preventDefault();
          this.editmode=false;
          this.form.heading='';
          this.form.content='';

          /* Trick to reset/clear native browser form validation state */
        //   this.show = false;
        //   this.$nextTick(() => { this.show = true });
        },

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

setFocus: function()
    {
      // Note, you need to add a ref="search" attribute to your input.
      this.$refs.search.focus();
    }
      },

created: function()
{
this.selectTopFooterData();

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
