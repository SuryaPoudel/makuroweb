<template id="">

      	<div class="row">

<div id='loadingmsg' v-show="this.popuploader" >Loading...</div>
<div id='loadingover' v-show="this.popuploader"> </div>

              <div class="col-md-12">

              <router-link class="btn btn-xs btn-light" v-bind:to="{path: '/addgallery'}">
                <i class="fas fa-plus"></i>

                Add New
              </router-link>
              <br/><br/>

              <div class="card mb-3">
                          <div class="card-header">
                          <i class="fas fa-list-ul"></i>
                           Photos results</div>
                          <div class="card-body">
                            <div class="form-group col-lg-5">
    <label >Search results for <span v-if="this.searchkey">"{{this.searchkey}}"</span> </label>
    <input type="text" class="form-control" v-model="searchkey" v-on:keyup="searchPosts()"  placeholder="Search Photos">
<div v-show="this.loaderactive" class="lds-facebook"><div></div><div></div><div></div></div>
</div>
            <div class="table-responsive">
                    <table  id="mytable" class="table table-bordred table-striped">


                         <thead>


                         <th>File</th>
                          <th>Album</th>
                           <th>Caption</th>
                           <th>Created At</th>
                           <th>Action</th>


                         </thead>
          <tbody>

          <tr v-for="(p, index) in posts.data">

              <td> <img  style="width: auto; height: 80px;" :src="url+p.image" ></td>
          <td>{{p.album}}</td>
          <td>{{p.caption}}</td>
          <td>{{p.created_at}}</td>

        <td> <!--  <router-link class="btn btn-light btn-sm" v-bind:to="{path: 'updatepage', params: {id: p.id}}"><i class="far fa-eye"></i> Show</router-link> -->
          <router-link class="btn btn-light btn-sm" v-bind:to="{path: 'addgallery/'+p.id}"><i class="fas fa-pen-square"></i> </router-link>
          <button  class="btn btn-light btn-sm" @click="askfordelete(p.id,p.title,index)" ><i   class="fas fa-trash-alt"></i> </button>
</td>  </tr>








          </tbody>

      </table>
<pagination :data="posts" @pagination-change-page="getResults"></pagination>

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
        return {posts: {},
        popuploader:false,
        loaderactive:false,
       url: window.hostname+'/photogallery/',
        timer: '',
        td_id:'',
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
    //alert(this.posts);
    
  this.modalShow=true;
  this.pagetitle=$title;
  this.deleteid=$id;
  this.td_id=index;
},

handleOk: function()
{
    
//delete is done here
let uri=window.hostname+'/api/gallery/'+this.deleteid;
    Axios.delete(uri).then((response) => {
      //this.selectallpages();
      this.posts.data.splice(this.td_id,1)
    })
.catch(error => {
    console.log(error)
});
},

searchResult: function()
{
  let query = this.searchkey;
  let uri=window.hostname+'/api/searchgallery?q='+ query;
    Axios.get(uri).then((response) => {
      this.posts = response.data;
       clearInterval(this.timer);
      this.loaderactive=false;
    });
},
getResults: function(page = 1) {
  let uri="";
  if(this.searchkey==='')
  {
 uri=window.hostname+'/api/post?page=';
     }
  else
  {
       uri=window.hostname+'/api/searchpost?q='+ this.searchkey +'&page=';

  }
 //alert(uri);
			Axios.get(uri + page)
				.then(response => {
					this.posts = response.data;
				});
		},
searchPosts: function()
{
  this.loaderactive=true;
 
 clearInterval(this.timer);
this.timer=setInterval(this.searchResult, 1000);
   //clearInterval(this.timer);

},


selectallpages: function()
{   let uri=window.hostname+'/api/gallery';
    Axios.get(uri).then((response) => {
      this.posts = response.data;
      this.popuploader=false;
    });
}
  
},



      created: function() {
          //alert(this.url);
        this.popuploader=true;
          this.selectallpages();

          
      }

    }
    </script>
