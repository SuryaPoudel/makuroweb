<template>
    
</template>

<script>

export default {
  created () {
    this.logout();
  },
  methods: {
   
     logout()
     {

         axios.post('logout').then(response => {
                    if (response.status === 302 || 401) {
                      
                        this.$router.push({path: '/login'});
                    //  document.location.href = "/login";
                    }
                    else {
                        // throw error and go to catch block
                    }
                }).catch(error => {
                    //run this code always when status!==200
                });
     }
  }
}

</script>