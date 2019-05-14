<template lang="html">




  <b-form @submit.prevent="updatePage()"  v-if="show">
    <div class="spinner"></div>
    <div class="row">
            <div class="col-lg-8">
              <div class="card mb-3">
                <div class="card-header">
              <i class="far fa-edit"></i>
                  Update Page</div>
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



      <!-- <template>
        <select  v-model="form.selected">
          <option v-for="p in parentall" v-bind:value="p.id" >{{ p.id }}</option>
       </select>
      </template> -->

             <b-form-select   v-model="form.parent">
               <option value="null">no parent</option>
               <option v-for="p in parentall" v-bind:value="p.id">
                {{ p.title }}
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

      parentall:[],
      form: {
        title: '',
        order: 0,
        parent: null,
       editorData: ''

          },

            editor: ClassicEditor,
                editorData: '<p>Start writing.</p>',
                editorConfig: {
                    // The configuration of the editor.
                },
      show: true
    }
  },
  methods: {

    getParent: function(){


                       axios.get(window.hostname+"/api/parent")
                                                  .then(response => {
                                                      this.parentall = response.data;
                                                  });
          },


                selectsinglepage: function($id)
                {
                let uri = window.hostname+'/api/page/'+this.$route.params.id;

                    Axios.get(uri).then((response) => {
                      this.form = response.data;
                      this.editorData=this.form.description;
                      if(this.form.parent == 0)
                      {

                        this.form.parent=null;
                      }
                      else {
                      this.form.parent=this.form.parent;
                      }


                    });
                },


    updatePage(){
      this.form.editorData=this.editorData;
  let uri = window.hostname+'/api/page/'+this.$route.params.id;
    Axios.patch(uri, this.form).then((response) => {

  this.$router.push({path: '/allpages'});
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


          this.selectsinglepage();

}

}
</script>
