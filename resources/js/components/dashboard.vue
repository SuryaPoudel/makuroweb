<template lang="html">

 
    <div class="row">

            <div class="col-lg-8">

                 <b-form @submit.prevent="editmode ? UpdateDraft() : CreateDraft()" @reset="onReset" v-if="show">
                    <b-alert :show="dismissCountDown"
                        dismissible
                        variant="warning"
                        @dismissed="dismissCountDown=0"
                        @dismiss-count-down="countDownChanged">
                <p text-align="center">{{error}} </p>
                <b-progress variant="warning"
                            :max="dismissSecs"
                            :value="dismissCountDown"
                            height="2px">
                </b-progress>
                </b-alert>
              <div class="card mb-3">
                <div class="card-header">
                    <i v-if="this.$route.params.id" class="far fa-edit"></i>
                <i  v-else class="fas fa-plus-circle"></i>
                <span v-if="this.$route.params.id">Upate Draft</span>
                <span v-else>Add Draft</span>
                  </div>
                <div class="card-body">
                  <div class="form-group">
                    <b-form-group label="Title:">
                    <b-form-input id="title"
                                  type="text"
                                  v-model="form.title"

                                  placeholder="Enter title">
                    </b-form-input>
                    </b-form-group>
                      <div v-if="errors.title" class="alert alert-danger" role="alert">{{errors.title[0]}}</div>
                  </div>

                  <div class="form-group">
                    <b-form-group
                    label="Description:">
                    <!-- <ckeditor :editor="editor" ref="yourTextarea" v-model.trim="txtContent"  :config="editorConfig"></ckeditor> -->
                    <vue-ckeditor type="classic" v-model="form.editorData" :upload-adapter="UploadAdapter"></vue-ckeditor>
                  </b-form-group>
            <div v-if="errors.editorData" class="alert alert-danger" role="alert">The description must be at least 100 characters.</div>
                 
              <b-button type="submit" variant="primary">Save</b-button>
            
                  </div>
                </div>
               
              </div>
             </b-form>
            </div>
            <div class="col-lg-4">
              <div class="card mb-3">
                <div class="card-header">
                <i class="fas fa-list-ul"></i>
                  Drafts</div>
                <div class="card-body">
                    <div class="form-group">
                                        <div class="table-responsive">
                                    <table id="mytable" class="table ">


                                      
                        <tbody>

                        <tr v-for="(draft,index) in drafts.data">

                            <td>{{draft.title}} @ {{draft.created_at}}
                                 <button class="btn btn-light btn-sm" @click="selectdraftbyid(draft.id)" ><i class="fas fa-pen-square"></i></button>
                                <button  class="btn btn-light btn-sm" @click="askfordelete(draft.id,draft.title,index)" ><i   class="fas fa-trash-alt"></i></button>

                            </td>
                        

                    <td>      </td>  </tr>








                        </tbody>

                    </table>
                <pagination :data="drafts" @pagination-change-page="getResults"></pagination>

                    <div >
                    <b-modal v-model="modalShow"  @ok="handleOk">
                            Do you really want to delete {{pagetitle}} ?
                        </b-modal>
                    </div>
  </div>

</div>

                 </div>

              </div>
            </div>
          </div>

           
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import VueCkeditor from 'vue-ckeditor5'
    Vue.use(VueCkeditor.plugin, {
      editors: {
        'classic': ClassicEditor
      }
    })
export default {
  data () {
    return {
        drafts:'',
      editmode: false,
      dismissSecs:10,
      txtContent:'',
            dismissCountDown:0,
            showDismissibleAlert:false,
          td_id:'',
        popuploader:false,
        loaderactive:false,
        timer: '',
          searchkey:'',
           modalShow: false,
           pagetitle: '',
           deleteid: '',
              error:'',
              errors:{},
      parentall:{},
      form: {
       
        title: '',
       
       editorData: ''

          },
      show: true
    }
  },
  methods: {
askfordelete: function($id,$title,index)
{
  this.td_id=index;
  this.modalShow=true;
  this.pagetitle=$title;
  this.deleteid=$id;
},

handleOk: function()
{
// delete is done here
let uri=window.hostname+'/api/draft/'+this.deleteid;
    Axios.delete(uri).then((response) => {
     
       this.drafts.data.splice(this.td_id,1)
    })
.catch(error => {
    console.log(error)
});
},


    countDownChanged: function(dismissCountDown) {
          this.dismissCountDown = dismissCountDown
        },
        showAlert: function () {
          this.dismissCountDown = this.dismissSecs
        },

     




getResults: function(page = 1) {
  let uri="";
  
 uri=window.hostname+'/api/draft?page=';
 
			Axios.get(uri + page)
				.then(response => {
					this.drafts = response.data;
				});
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

UpdateDraft()
{
  let uri = window.hostname+'/api/draft/'+this.td_id;
  Axios.patch(uri, this.form).then((response) => {
          this.editmode=false;
          this.form.title = '';
          this.form.editorData = '';
          this.SelectSavedDraftFromTable();
        

 
  }).catch((error)=> {
  if(error.response.status==422)
  {
    this.errors=error.response.data.errors;
  }

});

},


SelectSavedDraftFromTable()
{
        let uri = window.hostname+'/api/draft';
        Axios.get(uri).then((response) => {
            this.drafts=response.data;

             });
},


    CreateDraft(){
      let uri=window.hostname+'/api/draft';
    Axios.post(uri, this.form).then((response) => {
          this.form.title = '';
          this.form.editorData = '';
          this.SelectSavedDraftFromTable();
        
    }).catch((error)=> {
    if(error.response.status==422)
    {
        this.errors=error.response.data.errors;
    }

    });

    },




    selectdraftbyid: function($id)
    {
         this.editmode=true;
    let uri = window.hostname+'/api/draft/'+$id;

        Axios.get(uri).then((response) => {
          this.form = response.data;
          this.form.editorData=this.form.description;
         this.td_id=$id;

        });
    },

        onReset (evt) {
          evt.preventDefault();
          /* Reset our form values */
          this.form.title = '';
          this.form.editorData = '';
        
          /* Trick to reset/clear native browser form validation state */
          this.show = false;
          this.$nextTick(() => { this.show = true });
        }
  },
created: function()
{
this.SelectSavedDraftFromTable();

  
   
  
}




}
</script>
