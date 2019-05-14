<template >
    <div v-if="validationErrors">
                <ul class="alert alert-danger">
                    <li v-for="(value, key, index) in validationErrors">@{{ value }}</li>
                </ul>
            </div>
</template>

<script>
export default {
    data(){
          return {

          }
      },
      props: ['errors'],

      created: {
          validationErrors: function(){
              let errors = Object.values(this.errors);
              errors = errors.flat();
              return errors;
                            }
}
}
</script>
