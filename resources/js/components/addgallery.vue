<template lang="html">

  <b-form @submit.prevent="editmode ? updateImage() : uploadImage()"  v-if="show">
    
    <div class="row">




            <div class="col-lg-8">
              <div class="card mb-3">
                <div class="card-header">
                
                 <i v-if="this.$route.params.id" class="far fa-edit"></i>
                <i  v-else class="fas fa-plus-circle"></i>
                <span v-if="this.$route.params.id">Upate Photo</span>
                <span v-else>Add New</span>

                </div>
                <div class="card-body">
                  <div class="form-group">
                   
       
     
 <label class="btn-bs-file btn active btn-xs btn-light" autofocus="true"><i class="fas fa-cloud-upload-alt"></i>
                Add Photo
               <input type="file" @change="showFile"  name="file" class="form-input">

            </label>
            

     
                  </div>

<div class="table-responsive">






                    <table v-if="editmode" id="mytable" class="table table-bordred ">
          <tbody>

                 <tr >

            <td> <img  style="width: auto; height: 150px;" :src="editphoto" ></td>
          <td>
             <b-form-group label="Title:"><b-form-input
            type="text"
            name="caption"
            v-model="caption"
            placeholder="Enter Caption">
          </b-form-input></b-form-group ></td>
          

        <td></td>  </tr>
          </tbody>

      </table>




                    <table v-if="!editmode" id="mytable" class="table table-bordred ">
          <tbody>

                 <tr v-for="(result, index) in results.slice().reverse() ">

            <td> <img  style="width: auto; height: 80px;" :src="result.image" ></td>
          <td><b-form-input
            type="text"
            name="caption"
            v-model="result.caption"
            placeholder="Enter Caption">
          </b-form-input></td>
          

        <td> <button  class="btn btn-danger btn-sm" @click="deleteRow(index)" ><i   class="fas fa-trash-alt"></i> Delete</button>
</td>  </tr>
          </tbody>

      </table>

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
    <b-form-group label="Album:">
      <div v-if="this.album=='add'" class="txtUndoable">
   
 <i v-on:click="changeinput()" class="btnUndo fa fa-undo"></i>
 </div>
                      <b-form-input v-if="this.album=='add'" v-model="createalbum" id="album"
                                  type="text"
                                  placeholder="Enter Album">
                                  
                    </b-form-input>

      <b-form-select  v-else  v-model="album">
        <option value="null">no album</option>
        <option v-for="p in parentall" v-bind:value="p.album">
         {{ p.album }}
       </option>
       <option value="add">Add New</option>
     </b-form-select>
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
      parentall:{},
      editphoto:'',
      caption:'',
     editmode:false,
        results: [],
          album:null,
          createalbum:null,
          file:'',
          fileselectornot:false,
      show: true
    }
  },
  methods: {
changeinput()
{

  this.album=null;
},
showFile: function(e){
  this.i=this.i+1;
                    let file = e.target.files[0];
                    let reader = new FileReader();
                    let limit = 1024 * 1024 * 5;
                    if(file['size'] > limit){
                      alert('Size limit');
                        return false;
                    }
                    reader.onload = (file) => {

                      if(this.editmode==true)
                      {
                      this.fileselectornot=true;
                        this.editphoto=reader.result;
                      }
                      else
                      {  
                      this.results.push({
                            image: reader.result
                            })
                      }
                           }
                    reader.readAsDataURL(file);
                },
deleteRow(index) {
      this.results.splice(index,1)
    },
  updateImage()
    {   

      let newphoto;
         let uri = window.hostname+'/api/gallery/'+this.$route.params.id;
        if(this.createalbum!=null)
        {
          this.album=this.createalbum;
        }
      if(this.fileselectornot==false)
      {
      newphoto='';
        
      }else{
        newphoto=this.editphoto;
      }

          Axios.patch(uri, {album:this.album,caption:this.caption,image:newphoto}).then((response) => {
         this.$router.push({path: '/gallery'});
        }).catch((error)=> {

        });

    },
    uploadImage()
    {
      // alert(this.form.caption);
 let uri=window.hostname+'/api/gallery';
if(this.createalbum!=null)
{
  this.album=this.createalbum;
}

    Axios.post(uri, {results:this.results,album:this.album}).then((response) => {
  this.$router.push({path: '/gallery'});
}).catch((error)=> {

});

    },
     getAlbum: function(){
        let uri=window.hostname+'/api/album';
          axios.get(uri)
          .then(response => {
            this.parentall = response.data;

          });
                },


 selectphotobyid: function($id)
    {
    let uri = window.hostname+'/api/gallery/'+this.$route.params.id;

        Axios.get(uri).then((response) => {
         // alert(this.response.data.album);
          this.caption = response.data.caption;
          this.album=response.data.album;
        // alert(response);
          if(response.data.image)
          {
        this.editphoto=window.hostname+"/photogallery/"+response.data.image;
        }

          // if(this.response.data.album == null)
          // {
          //   this.form.parent=null;
          // }
          // else {
          // this.form.parent=this.form.cid;
          // }


        });
    }
      },
created: function()
{
this.getAlbum();
if(this.$route.params.id)
  {
    this.editmode=true;
  this.selectphotobyid();
  }
}


}
</script>
<style>
.txtUndoable {
    position: relative;
 
}

    .txtUndoable .fa {
        position: absolute;
        right: 0;
        padding: 10px;
        /*pointer-events: none;*/
        cursor: pointer;
        color:#26A8FF;
    }

.txtUndoable {
    padding-right: 30px;
}
.btn-bs-file{
    position:relative;
}
.btn-bs-file input[type="file"]{
    position: absolute;
    top: -9999999;
    filter: alpha(opacity=0);
    opacity: 0;
    width:0;
    height:0;
    outline: none;
    cursor: inherit;
    background: black;
}

</style>
