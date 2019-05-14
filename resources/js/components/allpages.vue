<template id="">
      	<div class="row">




              <div class="col-md-12">

              <router-link class="btn btn-xs btn-light" v-bind:to="{path: '/addnewpage'}">
                <i class="fas fa-plus"></i>
                Add New
              </router-link>
<br/><br/>

     <div class="card mb-3">
                          <div class="card-header">
                          <i class="fas fa-list-ul"></i>
                           Post results</div>
                          <div class="card-body">
                           
            <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">
                          <thead>


                         <th>Title</th>
                          <th>Order</th>
                           <th>Created At</th>
                           <th>Action</th>


                         </thead>
          <tbody>
<template v-for="page in pages">
          <tr v-for="p in page">


          <td v-if="p.parent===null">{{p.title.toUpperCase()}}</td>
          <td v-else>__{{p.title.toUpperCase()}}</td>

          <td>{{p.order}}</td>
          <td>{{p.created_at}}</td>

         <td> <!--  <router-link class="btn btn-info btn-sm" v-bind:to="{path: 'updatepage', params: {id: p.id}}"><i class="far fa-eye"></i> Show</router-link> -->
          <router-link class="btn btn-light btn-sm" v-bind:to="{path: 'updatepage/'+p.id}"><i class="fas fa-pen-square"></i> </router-link>
          <button  class="btn btn-light btn-sm" @click="askfordelete(p.id,p.title)" ><i   class="fas fa-trash-alt"></i> </button>
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
</div></div></div>

</template>

    <script>
    import loader from './loader.vue';
    export default {

      data:function(){
        return {pages: [],
           modalShow: false,
           pagetitle: '',
           deleteid: ''
        };
      },
      components: {
  loader
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
let uri=window.hostname+'/api/page/'+this.deleteid;
    Axios.delete(uri).then((response) => {
      this.selectallpages();
    })
.catch(error => {
    console.log(error)
});
},

selectallpages: function()
{   let uri=window.hostname+'/api/page';
    Axios.get(uri).then((response) => {
      this.pages = response.data;
    });
}
},
      created: function() {
          //this.loader;
          this.selectallpages();
      }
      // computed: {
      //   selectAllrecords: function(){
      //     if(this.records.length) {
      //       return this.records;
      //     }
      //   }
      // }
    }
    </script>
