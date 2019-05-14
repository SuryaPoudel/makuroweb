
<template lang="html">

  <b-form @submit.prevent="editmode ? updateUser() : createUser()" ref="alert"  v-if="show">
   <b-alert :show="dismissCountDown"
         dismissible
         variant="danger"
         @dismissed="dismissCountDown=0"
         @dismiss-count-down="countDownChanged">
  <p text-align="center">{{msg}} </p>
  <b-progress variant="danger"
              :max="dismissSecs"
              :value="dismissCountDown"
              height="2px">
  </b-progress>
</b-alert>
    <div class="row">



   <div class="col-lg-4">
              <div class="card mb-3">
                <div class="card-header">
                  <i class="fas fa-eye"></i>
                  Select menu</div>
                <div class="card-body">
                     
                                                <div class="form-group row">
                                                
                                                  <div class="col-sm-10 ml-5">
                                                                <input class="form-check-input" type="checkbox" value="dashboard" v-model="form.permission" ><label class="form-check-label" >
                                                                              Dashboard
                                                                              </label>            </div>
                                                </div>
                                                <div class="form-group row">
                                                
                                                                <div class="col-sm-10 ml-5">
                                                                              <input class="form-check-input" type="checkbox" value="posts" v-model="form.permission" ><label class="form-check-label" >
                                                                                             Posts
                                                                                            </label>            </div>
                                                              </div>
                                                              <div class="form-group row">
                                                
                                                                        <div class="col-sm-10 ml-5">
                                                                                      <input class="form-check-input" type="checkbox" value="pages" v-model="form.permission" ><label class="form-check-label" >
                                                                                                     Pages
                                                                                                    </label>            </div>
                                                                      </div>
                                                <div class="form-group row">
                                                
                                                                        <div class="col-sm-10 ml-5">
                                                                                      <input class="form-check-input" type="checkbox" value="gallery" v-model="form.permission" ><label class="form-check-label" >
                                                                                                     Gallery
                                                                                                    </label>            </div>
                                                                      </div>
                                                
                                                  <div class="form-group row">
                                                
                                                                        <div class="col-sm-10 ml-5">
                                                                                      <input class="form-check-input" type="checkbox" value="setings" v-model="form.permission" ><label class="form-check-label" >
                                                                                                     Settings
                                                                                                    </label>            </div>
                                                                      </div>
                                                
                                                  <div class="form-group row">
                                                
                                                                        <div class="col-sm-10 ml-5">
                                                                                      <input class="form-check-input" type="checkbox" value="layout" v-model="form.permission" ><label class="form-check-label" >
                                                                                                     Layout Management
                                                                                                    </label>            </div>
                                                                      </div>

                </div>

              </div>
            </div>



            <div class="col-lg-8">
              <div class="card mb-3">
                <div class="card-header">
                
                 <i class="far fa-edit"></i>
              
                <span >Add User</span>
          

                </div>
                <div class="card-body">
                  <div class="form-group">
                   
       
     
            
<b-form-group
                        label="Name:">
                        <b-form-input
                            type="text"
                            v-model="form.name"
                            required
                            placeholder="Enter full name">
                        </b-form-input>
                        </b-form-group>
     
<div v-if="errors.name" class="alert alert-danger" role="alert">{{errors.name[0]}}</div>

<b-form-group
                        label="Email:">
                        <b-form-input
                            type="email"
                            v-model="form.email"
                            required
                            placeholder="Enter email">
                        </b-form-input>
                        </b-form-group>
     
<div v-if="errors.email" class="alert alert-danger" role="alert">{{errors.email[0]}}</div>


<b-form-group
                        label="Password:">
                        <b-form-input
                            type="password"
                            v-model="form.password"
                            required
                            placeholder="Enter password">
                        </b-form-input>
                        </b-form-group>
     
<div v-if="errors.password" class="alert alert-danger" role="alert">{{errors.password[0]}}</div>


                  <b-button type="submit" variant="primary">Publish</b-button>
              <loading v-if="this.loaderactive"></loading>
                  </div>


 
                </div>
                <!-- <div class="card-footer small text-muted">Start writing</div> -->
              </div>
            </div>
         
          </div>



            </b-form>
</template>

<script>

import loading from './loading.vue';
///import func from './vue-temp/vue-editor-bridge';
export default {

components: {

loading
},

  data () {
    return {
        msg:'',
        info:'info',
        dismissSecs:10,
        dismissCountDown:0,
        showDismissibleAlert:false,
        loaderactive:false,
       editmode:false,
      errors:{},
     
      form:{
                name:'',
                email:'',
                password:'',
                permission:[]
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



      updateUser()
      {
  this.loaderactive=true;
  let uri = window.hostname+'/api/controlpanelrole/'+this.$route.params.id;
  Axios.patch(uri, this.form).then((response) => {
  this.$router.push({path: '/users'});
  this.loaderactive=false;
  }).catch((error)=> {
  if(error.response.status==422)
  {
    this.errors=error.response.data.errors;
  }

});


      },


        createUser: function()
        {


          if(this.form.permission.length==0)
          {
            this.info="warning";
            this.msg="Select left side menu first."
          this.showAlert();

          }
          else
          {


                     this.loaderactive=true;
                     let uri=window.hostname+'/api/controlpanelrole';
                     Axios.post(uri, this.form).then((response) => {
                     this.loaderactive=false;

if(response.data.msg)
{
  this.msg=response.data.msg;
    this.showAlert();
}
else
{
                    this.$router.push({path: '/users'});
                     }
                        }).catch((error)=> {
                          if(error.response.status==422)
                          {
                            this.errors=error.response.data.errors;
                          }

                        });


          }

        },

 selectuserById()
{

        let uri = window.hostname+'/api/controlpanelrole/'+this.$route.params.id;

        Axios.get(uri).then((response) => {
this.form = response.data;
this.form.permission=response.data.permission.split(",");
        });
},

      },

created: function()
{
  if(this.$route.params.id)
  {
    this.editmode=true;
this.selectuserById();
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
