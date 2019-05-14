<template lang="html">

  <b-form @submit.prevent="editmode ? updatePost() : createPost()" @reset="onReset" v-if="show">
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
    <div class="row">

            <div class="col-lg-8">
              <div class="card mb-3">
                <div class="card-header">
                    <i v-if="this.$route.params.id" class="far fa-edit"></i>
                <i  v-else class="fas fa-plus-circle"></i>
                <span v-if="this.$route.params.id">Upate Post</span>
                <span v-else>Add New</span>
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
                  </div>
                </div>
                <!-- <div class="card-footer small text-muted">Start writing</div> -->
              </div>
            </div>
            <div class="col-lg-4">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-cog"></i>
                  Post element</div>
                <div class="card-body">
                    <div class="form-group">

  <div class="form-group">
    <b-form-group label="Categories:">
      <b-form-select   v-model="form.parent">
        <option value="null">no category</option>
        <option v-for="p in parentall" v-bind:value="p.id">
         {{ p.catname }}
       </option>
     </b-form-select>
          </b-form-group>


          <b-form-group
          label="Tag:">
          <b-form-input
            type="text"
            v-model="form.tag"
            placeholder="Enter tag">
          </b-form-input>
          </b-form-group>

          <b-form-group
          label="Featured Image:">
           <!-- <b-form-file v-model="form.file" @change="showFile"   plain></b-form-file> -->
           <input type="file" @change="showFile" name="file" class="form-input">


          </b-form-group>
          <div v-if="errors.file" class="alert alert-danger" role="alert">{{errors.file[0]}}</div>
          <div v-if="photoshow" >
            <div class="col-md-10 mb-2"  ><img  width="100%" :src="photoshow" ></div>
            
            <div v-if="form.file!=null">
 <b-form-group
          label="Resize:">
<div class="table-responsive">
  <table id="mytable" class="table table-bordred table-striped">
    <thead><th><b-form-input
            type="number"
            v-model="form.width"
            placeholder="Width">
          </b-form-input></th> <th><b-form-input
            type="number"
            v-model="form.height"
            placeholder="Height">
          </b-form-input></th> </thead>
     
     </table>
   
 <div v-if="errors.width" class="alert alert-danger" role="alert">{{errors.width[0]}}</div>
 <div v-if="errors.height" class="alert alert-danger" role="alert">{{errors.height[0]}}</div>
         
</div>


</b-form-group>
</div>
          </div>
  </div>

</div>

                  <b-button type="submit" variant="primary">Publish</b-button>
                  <b-button v-if="!this.$route.params.id" type="reset" variant="danger">Clear</b-button>
                </div>

              </div>
            </div>
          </div>

<!-- <textarea ref="yourTextarea" v-model.trim="txtContent"></textarea> -->
            </b-form>
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
      editmode: false,
      dismissSecs:10,
      txtContent:'',
            dismissCountDown:0,
            showDismissibleAlert:false,
            photoshow:'',
              error:'',
              errors:{},
      parentall:{},
      form: {
        file: null,
        height:500,
        width:650,
        title: '',
        order: 0,
        parent: null,
       editorData: ''

          },
            // editor: ClassicEditor,
            //     editorData: '',
            //     editorConfig: {
            //         // The configuration of the editor.
            //     },
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

        getCategory: function(){
        let uri=window.hostname+'/api/category';
          axios.get(uri)
          .then(response => {
            this.parentall = response.data;

          });
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
                //    this.insertSomething("hello how are");
                      this.form.file=reader.result;
                            }
                    reader.readAsDataURL(file);
                },

insertSomething: function(insert) {
  const self = this;
  var tArea = this.$refs.yourTextarea;
  // filter:
  if (0 == insert) {
    return;
  }
  if (0 == cursorPos) {
    return;
  }

  // get cursor's position:
  var startPos = tArea.selectionStart,
    endPos = tArea.selectionEnd,
    cursorPos = startPos,
    tmpStr = tArea.value;

  // insert:
  self.txtContent = tmpStr.substring(0, startPos) + insert + tmpStr.substring(endPos, tmpStr.length);

  // move cursor:
  setTimeout(() => {
    cursorPos += insert.length;
    tArea.selectionStart = tArea.selectionEnd = cursorPos;
  }, 10);
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

updatePost()
{
 // this.form.editorData=this.editorData;
  let uri = window.hostname+'/api/post/'+this.$route.params.id;
  Axios.patch(uri, this.form).then((response) => {
  this.$router.push({path: '/posts'});
  }).catch((error)=> {
  if(error.response.status==422)
  {
    this.errors=error.response.data.errors;
  }

});

},

    createPost(){
    //  this.form.editorData=this.editorData;
      let uri=window.hostname+'/api/post';
    Axios.post(uri, this.form).then((response) => {
    this.$router.push({path: '/posts'});
      // if(response.data.status===true)
      // {
      //   this.$router.push({path: '/posts'});

      // }
      // else {
      //   this.error=response.data.msg;
      //   this.showAlert();
      // }


}).catch((error)=> {
  if(error.response.status==422)
  {
    this.errors=error.response.data.errors;
  }

});

    },




    selectpostbyid: function($id)
    {
    let uri = window.hostname+'/api/post/'+this.$route.params.id;

        Axios.get(uri).then((response) => {
          this.form = response.data;
          this.form.editorData=this.form.details;
         
          if(response.data.img)
          {
         this.photoshow=window.hostname+"/featuredimage/"+response.data.img;
        }

          if(this.form.parent == 0)
          {
            this.form.parent=null;
          }
          else {
          this.form.parent=this.form.cid;
          }


        });
    },

        onReset (evt) {
          evt.preventDefault();
          /* Reset our form values */
          this.form.title = '';
          this.editorData = '';
          this.form.order = null;
          this.form.parent = null;

          /* Trick to reset/clear native browser form validation state */
          this.show = false;
          this.$nextTick(() => { this.show = true });
        }
  },
created: function()
{

  this.getCategory();
  if(this.$route.params.id)
  {
    this.editmode=true;
  this.selectpostbyid();
  }
}




}
</script>
