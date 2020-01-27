<template>
  <div class="container">
      <div class="row my-3">
          <h3 class="text-secondary">
              Cluster Rumah Web App - {{ title }}
          </h3>
      </div>
      <slot></slot>
  </div>
</template>

<script>
    export default {
        props:{
            title: String
        }
    }
</script>
