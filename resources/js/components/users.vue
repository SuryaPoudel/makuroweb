<template id="">

      	<div class="row">

<div id='loadingmsg' v-show="this.popuploader" >Loading...</div>
<div id='loadingover' v-show="this.popuploader"> </div>

              <div class="col-md-12">

              <router-link class="btn btn-xs btn-light" v-bind:to="{path: '/user'}">
                <i class="fas fa-plus"></i>

                Add New
              </router-link>
              <br/><br/>

              <div class="card mb-3">
                          <div class="card-header">
                          <i class="fas fa-users"></i>
                           Users Records</div>
                          <div class="card-body">
                            <div class="form-group col-lg-5">
    <label >Search results for <span v-if="this.searchkey">"{{this.searchkey}}"</span> </label>
    <input type="text" class="form-control" v-model="searchkey" v-on:keyup="searchUsers()"  placeholder="Search Users">
<div v-show="this.loaderactive" class="lds-facebook"><div></div><div></div><div></div></div>
</div>
            <div class="table-responsive">
                    <table id="mytable" class="table table-bordred table-striped">


                         <thead>


                         <th>Name</th>
                          <th>Email</th>
                           <th>Created At</th>
                           <th>Action</th>


                         </thead>
          <tbody>

          <tr v-for="(u,index) in Users.data">

            <td>{{u.name}}</td>
          <td>{{u.email}}</td>
          <td>{{u.created_at}}</td>

        <td>  <router-link class="btn btn-light btn-sm" v-bind:to="{path: 'user/'+u.id}"><i class="fas fa-pen-square"></i> </router-link>
          <button  class="btn btn-light btn-sm" @click="askfordelete(u.id,u.name,index)" ><i   class="fas fa-trash-alt"></i> </button>
</td>  </tr>








          </tbody>

      </table>
<pagination :data="Users" @pagination-change-page="getResults"></pagination>

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
</div>
</div>

</template>

    <script>
    import loader from './loader.vue';
    
    export default {

      data:function(){
        return {Users: {},
        td_id:'',
        popuploader:false,
        loaderactive:false,
        timer: '',
          searchkey:'',
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
let uri=window.hostname+'/api/controlpanelrole/'+this.deleteid;
    Axios.delete(uri).then((response) => {
      //this.selectallpages();
       this.Users.data.splice(this.td_id,1)
    })
.catch(error => {
    console.log(error)
});
},

searchResult: function()
{
  let query = this.searchkey;
  let uri=window.hostname+'/api/searchuser?q='+ query;
    Axios.get(uri).then((response) => {
      this.Users = response.data;
       clearInterval(this.timer);
      this.loaderactive=false;
    });
},
getResults: function(page = 1) {
  let uri="";
  if(this.searchkey==='')
  {
    uri=window.hostname+'/api/controlpanelrole?page=';
     }
  else
  {
       uri=window.hostname+'/api/searchuser?q='+ this.searchkey +'&page=';

  }
 //alert(uri);
			Axios.get(uri + page)
				.then(response => {
					this.Users = response.data;
				});
		},
searchUsers: function()
{
  this.loaderactive=true;
 
 clearInterval(this.timer);
this.timer=setInterval(this.searchResult, 1000);
   //clearInterval(this.timer);

},


selectallUsers: function()
{   let uri=window.hostname+'/api/controlpanelrole';
    Axios.get(uri).then((response) => {
      this.Users = response.data;
      this.popuploader=false;
    });
}
},
      created: function() {
         this.popuploader=true;
          this.selectallUsers();
      }

    }
    </script>
