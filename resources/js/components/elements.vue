
<template lang="html">

  <b-form @submit.prevent="updateElements()" ref="alert"  v-if="show">
   <b-alert :show="dismissCountDown"
         dismissible
         variant="info"
         @dismissed="dismissCountDown=0"
         @dismiss-count-down="countDownChanged">
  <p text-align="center">{{msg}} </p>
  <b-progress variant="info"
              :max="dismissSecs"
              :value="dismissCountDown"
              height="2px">
  </b-progress>
</b-alert>
    <div class="row">



   


            <div class="col-lg-12">
              <div class="card mb-3">
                <div class="card-header">
                
                 <i class="far fa-edit"></i>
              
                <span >Upate Elements</span>
               

                </div>
                <div class="card-body">
                  <div class="form-group">
                   
       <h4> <span >Social Media</span></h4>
     <hr class="col-xs-12">
            
<b-form-group
                        label="Facebook:">
                        <b-form-input
                            type="text"
                            v-model="form.furl"
                            
                            placeholder="Enter facebook page url">
                        </b-form-input>
                        </b-form-group>
    
<b-form-group
                        label="Twitter:">
                        <b-form-input
                            type="text"
                            v-model="form.turl"
                            
                            placeholder="Enter twitter page url.">
                        </b-form-input>
                        </b-form-group>
  
     <b-form-group
                        label="Google:">
                        <b-form-input
                            type="text"
                            v-model="form.gurl"
                            
                            placeholder="Enter google+ page url.">
                        </b-form-input>
                        </b-form-group>


 <h4> <span >Images Sizes</span></h4>
     <hr class="col-xs-12">




  <div class="mb-1" >Thumbnail:</span></div>

    
  <div class="row">
    
    <div class="col-sm">
     
 <b-form-group
                        label="Max Width">
    
                        <b-form-input
                            type="number"
                            v-model="form.twidth"
                            required
                            placeholder="Enter width"s
                            >
                        </b-form-input>
                      </b-form-group> 
 
    </div>
    <div class="col-sm">
     <b-form-group
                        label="Max Height">
                        <b-form-input
                          type="number"
                            v-model="form.theight"
                            required
                            placeholder="Enter height"
                            >
                        </b-form-input>
                       </b-form-group> 
 

    </div>
    
 
    
</div>


<div class="mb-1 mt-2" >Medium:</span></div>
<div class="row">
    
    <div class="col-sm">
     
 <b-form-group
                        label="Max Width">
    
                        <b-form-input
                         type="number"
                            v-model="form.mwidth"
                             required
                            placeholder="Enter width"
                            >
                        </b-form-input>
                      </b-form-group> 
 
    </div>
    <div class="col-sm">
     <b-form-group
                        label="Max Height">
                        <b-form-input
                         type="number"
                            v-model="form.mheight"
                            required
                            placeholder="Enter height"
                            >
                        </b-form-input>
                       </b-form-group> 
 

    </div>
    
 
    
</div>




<div class="mb-1 mt-2" >Large:</span></div>
<div class="row">
    
    <div class="col-sm">
     
 <b-form-group
                        label="Max Width">
    
                        <b-form-input
                          type="number"
                            v-model="form.lwidth"
                             required
                            placeholder="Enter width"
                            >
                        </b-form-input>
                      </b-form-group> 
 
    </div>
    <div class="col-sm">
     <b-form-group
                        label="Max Height">
                        <b-form-input
                           type="number"
                            v-model="form.lheight"
                            required
                            placeholder="Enter height"
                            >
                        </b-form-input>
                       </b-form-group> 
 

    </div>
    
 
    
</div>



<div class="mb-1 mt-2" >Banner:</span></div>
<div class="row">
    
    <div class="col-sm">
     
 <b-form-group
                        label="Max Width">
    
                        <b-form-input
                          type="number"
                            v-model="form.bwidth"
                             required
                            placeholder="Enter width"
                            >
                        </b-form-input>
                      </b-form-group> 
 
    </div>
    <div class="col-sm">
     <b-form-group
                        label="Max Height">
                        <b-form-input
                          type="number"
                            v-model="form.bheight"
                             required
                            placeholder="Enter height"
                           
                            >
                        </b-form-input>
                       </b-form-group> 
 

    </div>
    
 
    
</div>


<h4> <span >Site Contact</span></h4>
     <hr class="col-xs-12">
  <b-form-group
                        label="Email:">
<b-form-input
                            type="email"
                            v-model="form.email"
                            required
                            placeholder="eg. info@yourwebsite.com">
                        </b-form-input>

 </b-form-group>


 <b-form-group
                        label="Google Map:">
     <b-form-textarea id=""
                     v-model="form.map"
                     
                     placeholder="Enter map link"
                     :rows="3"
                     :max-rows="6">
    </b-form-textarea>

 </b-form-group>
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
export default {

components: {

loading
},

  data () {
    return {
        msg:'',
         dismissSecs:10,
    
            dismissCountDown:0,
            showDismissibleAlert:false,
        loaderactive:false,
      
      errors:{},
     
      form:{
        furl:'',
        turl:'',
        gurl:'',
        twidth: 150,
        theight: 150,
        mwidth:300,
        mheight:300,
        lwidth:1024,
        lheight:1024,
        bwidth:1200,
        bheight:600,
        email:'',
        map:''
 
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
                updateElements()
                {
                        this.loaderactive=true;
                        let uri=window.hostname+'/api/elements';
                        Axios.post(uri, this.form).then((response) => {
                        this.loaderactive=false;
                        this.msg=response.data.msg;
                         this.showAlert()
                        }).catch((error)=> {
                        if(error.response.status==422)
                        {
                            this.loaderactive=false;
                            this.errors=error.response.data.errors;
                        }
                        });

                },

                selectElementsData()
                {
                        let uri = window.hostname+'/api/elements/1';

                        Axios.get(uri).then((response) => {
                        this.form = response.data;
                    
                        });
                }
      },

created: function()
{
this.selectElementsData();
//this.loaderactive=true;
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
