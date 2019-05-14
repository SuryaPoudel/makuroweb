

  <script>
  import Vue from 'vue'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import VueCkeditor from 'vue-ckeditor5'
    Vue.use(VueCkeditor.plugin, {
      editors: {
        'classic': ClassicEditor
      }
    })
    new Vue({
      el: '#app',
      data: {
        htmlContent: '<p><strong>html</strong><i>Content</i></p>',
        UploadAdapter: function (loader) {
            
            let uri=window.hostname+'/api/browse';
            this.loader = loader
            const body = new FormData();
            let file = this.loader.file;
            let reader = new FileReader();
            reader.onload = (file) => {
                   this.upload = () => {
                    body.append('upload', reader.result);
                  
                        return fetch(uri, {
                            body: body,
                            method: 'POST'
                            })
                            .then(response => response.json())
                            .then(response => {
                                return {
                                default: response.url
                                }
                            })
                            .catch(error => {
                                console.log(error);
                            });

                   }
            this.abort = () => {
                console.log('Abort upload.')
                            }
                  }

             reader.readAsDataURL(file);
            
        }
      },
      template: `
        <div>
          <vue-ckeditor type="classic" v-model="htmlContent" :upload-adapter="UploadAdapter"></vue-ckeditor><br /><br />
          <div>{{ htmlContent }}</div>
        </div>
      `
    })
  </script>

