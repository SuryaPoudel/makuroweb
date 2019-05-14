<template lang="html">

  <b-form @submit.prevent="createCategory()" @reset="onReset" v-if="show">
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
                  Add New Category</div>
                <div class="card-body">
                  <div class="form-group">
                    <b-form-group label="Name:">
        <b-form-input id="catname"
                      type="text"
                      v-model="form.catname"
                      required
                      placeholder="Enter name">
        </b-form-input>
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
                  Category element</div>
                <div class="card-body">
                    <div class="form-group">



  <div class="form-group">
    <b-form-group label="Parent Category:">
            <b-form-select id="exampleInput3" :options="parent" v-model="form.parent">
               <option v-for="parent in parentall" v-bind:value="parent.id">
                {{ parent.catname }}
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

        catname: '',
        order: 0,
        parent: null,

          },

                parent: [
                        { text: 'no parent', value: null }

                      ],
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



createCategory: function()
{
let uri=window.hostname+'/api/categories';
Axios.post(uri, this.form).then((response) => {

  if(response.data.status===true)
  {
    this.$router.push({path: 'categories'});
  }
  else {
    this.error=response.data.msg;
    this.showAlert();
  }



})
},
getCategory: function(){
let uri=window.hostname+'/api/category';
  axios.get(uri)
  .then(response => {
    this.parentall = response.data;

  });




            },

      onReset (evt) {
          evt.preventDefault();
          /* Reset our form values */
          this.form.title = '';

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
}



}
</script>
