<template id="">
      	<div class="row">

              <div class="col-md-12">

              <router-link class="btn btn-xs btn-primary" v-bind:to="{path: '/addcategory'}">
                <i class="fas fa-plus"></i>
                Add New
              </router-link>
<br/><br/>
            <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">


                         <thead>


                         <th>Name</th>
                          <th>Order</th>
                           <th>Created At</th>
                           <th>Action</th>


                         </thead>
          <tbody>



<template v-for="category in categories">
          <tr v-for="cat in category">


          <td v-if="cat.parent===null">{{cat.catname.toUpperCase()}}</td>
          <td v-else>__{{cat.catname.toUpperCase()}}</td>

          <td>{{cat.order}}</td>
          <td>{{cat.created_at}}</td>

        <td>  <router-link class="btn btn-info btn-sm" v-bind:to="{path: 'showcategory/', params: {id: cat.id}}"><i class="far fa-eye"></i> Show</router-link>
          <router-link class="btn btn-warning btn-sm" v-bind:to="{path: 'updatecategory/'+cat.id}"><i class="fas fa-pen-square"></i> Edit</router-link>
          <button  class="btn btn-danger btn-sm" @click="askfordelete(cat.id,cat.catname)" ><i   class="fas fa-trash-alt"></i> Delete</button>
</td>  </tr>
</template>







          </tbody>

      </table>

<div >
  <b-modal v-model="modalShow"  @ok="handleOk">
        Do you really want to delete {{pagetitle}} ?
      </b-modal>
</div>

      <div class="clearfix"></div>
      <!-- <b-pagination size="sm" :total-rows="100" v-model="currentPage" :per-page="10">
    </b-pagination> -->
                  </div>

              </div>
      	</div>


</template>

    <script>
    export default {

      data:function(){
        return {categories: [],
           modalShow: false,
           pagetitle: '',
           deleteid: ''
        };
      },


methods:
{
askfordelete: function($id,$title)
{
  this.modalShow=true;
  this.pagetitle=$title;
  this.deleteid=$id;
},

handleOk: function()
{
// delete is done here
let uri=window.hostname+'/api/categories/'+this.deleteid;
    Axios.delete(uri).then((response) => {
      this.selectallcategories();
    })
.catch(error => {
    console.log(error)
});
},

selectallcategories: function()
{   let uri=window.hostname+'/api/categories';
    Axios.get(uri).then((response) => {
      this.categories = response.data;
    });
}
},
      created: function() {
          this.selectallcategories();
      }

    }
    </script>
