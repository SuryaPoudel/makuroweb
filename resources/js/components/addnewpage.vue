<template lang="html">

  <b-form @submit.prevent="createPage()" @reset="onReset" v-if="show">
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
                <i class="fas fa-plus-circle"></i>
                  Add New</div>
                <div class="card-body">
                  <div class="form-group">
                    <b-form-group label="Title:">
        <b-form-input id="title"
                      type="text"
                      v-model="form.title"
                      required
                      placeholder="Enter title">
        </b-form-input>
      </b-form-group>
                  </div>

                  <div class="form-group">
                    <b-form-group
                    label="Description:">
                    <ckeditor :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>

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
                  Page element</div>
                <div class="card-body">
                    <div class="form-group">



  <div class="form-group">
    <b-form-group label="Parent Page:">
            <b-form-select id="exampleInput3" :options="parent" v-model="form.parent">
              <option v-for="parent in parentall" v-bind:value="parent.id">
                {{ parent.title }}
              </option>
            </b-form-select>
          </b-form-group>


          <b-form-group
          label="Order:">
          <b-form-input
            type="number"
            v-model="form.order"
            required
            placeholder="0">
          </b-form-input>
          </b-form-group>

  </div>

</div>

                  <b-button type="submit" variant="primary">Publish</b-button>
                  <b-button type="reset" variant="danger">Clear</b-button>
                </div>

              </div>
            </div>
          </div>



            </b-form>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
  data () {
    return {
      dismissSecs:10,
            dismissCountDown:0,
            showDismissibleAlert:false,
              error:'',
      parentall:{},
      form: {

        title: '',
        order: 0,
        parent: null,
       editorData: ''

          },

      parent: [
              { text: 'no parent', value: null }

            ],
            editor: ClassicEditor,
                editorData: '<p>Start writing.</p>',
                editorConfig: {
                    // The configuration of the editor.
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

    getParent: function(){

let uri=window.hostname+'/api/parent';
                       axios.get(uri)
                                                  .then(response => {
                                                      this.parentall = response.data;

                                                  });



                },

    createPage(){
      this.form.editorData=this.editorData;
let uri=window.hostname+'/api/page';
    Axios.post('api/page', this.form).then((response) => {



  if(response.data.status===true)
  {
    this.$router.push({path: 'allpages'});

  }
  else {
    this.error=response.data.msg;
    this.showAlert();
  }
    })
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

  this.getParent();
}


}
</script>
