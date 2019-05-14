<template lang="html">

  <b-form @submit.prevent="updateCategory()"  v-if="show">

  <router-link class="btn btn-xs btn-primary" v-bind:to="{path: '/categories'}"> <i class="fas fa-arrow-left"></i> Back </router-link>
</br></br>
    <div class="row">

            <div class="col-lg-8">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="far fa-edit"></i>
                  Update Category</div>
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
      <b-form-select   v-model="form.parent">
        <option value="null">no parent</option>
        <option v-for="p in parentall" v-bind:value="p.id">
         {{ p.catname }}
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


getCategory: function(){
let uri=window.hostname+'/api/category';
  axios.get(uri)
  .then(response => {
    this.parentall = response.data;

  });




},

updateCategory: function()
{
let uri = window.hostname+'/api/categories/'+this.$route.params.id;
Axios.patch(uri, this.form).then((response) => {

this.$router.push({path: '/categories'});
})
},

selectcategorybyid: function($id)
{
let uri = window.hostname+'/api/categories/'+this.$route.params.id;

    Axios.get(uri).then((response) => {
      this.form = response.data;

      if(this.form.parent == 0)
      {

        this.form.parent=null;
      }
      else {
      this.form.parent=this.form.parent;
      }


    });
}

  },
created: function()
{
  this.getCategory();

          this.selectcategorybyid();
}



}
</script>
