<template>
  <footer class="footer has-cards">
    <div class="row">
          <div class="col-md-6">
            <p>Zuricoin, {{ year }}</p>  
          </div>
          <div class="col-md-4">
              <h4 class="footer-heading">Connect With Us <i class="fa fa-link"></i></h4>
              <div class="flex flex-row border-0 flex-wrap">
                  <a href="#" target="_blank" class="bg-transparent border-0 px-2"><i class="fa fa-instagram shadow-sm disabled" aria-disabled="true"></i></a>
                  <a href="#" target="_blank" class="bg-transparent border-0 px-2"><i class="fa fa-twitter shadow-sm disabled" aria-disabled="true"></i></a>
                  <a href="#" target="_blank" class="bg-transparent border-0 px-2"><i class="fa fa-facebook shadow-sm disabled" aria-disabled="true"></i></a>
                  <a href="#" target="_blank" class="bg-transparent border-0 px-2"><i class="fa fa-reddit shadow-sm disabled" aria-disabled="true"></i></a>
              </div>
          </div>
      </div>
  </footer>
</template>
<script>

export default {
  name: 'my-footer',
  data() {
    return {
      year: new Date().getFullYear()
    }
  }
};
</script>
<style>
</style>
