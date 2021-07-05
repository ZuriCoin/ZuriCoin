<template>
  <div class="row bg-dark min-vh-100 align-items-center">
    <particles-bg color="#ffffff" num="5" type="cobweb" />
    <div class="container">
      <div class="row align-items-center justify-content-center">
        <div class="col-4 text-white">
          <p class="h5">Welcome</p>
        </div>
        <div class="col-6 text-white">
          <p class="h1">Zuricoin</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { ParticlesBg } from "particles-bg-vue";

export default {
  components: {
    ParticlesBg,
  },
  data() {
    return {};
  },
};
</script>
<style lang="scss">
.headlinks {
  text-align: right;
  a {
    font-size: 13px;
    margin-right: 9px;
  }
}
.min-vh-100 {
  height: 100vh;
}
.canvas {
  position: absolute;
}
</style>
