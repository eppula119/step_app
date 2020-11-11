<template>
  <div>
    <Header />
    <RouterView />
    <Footer />
  </div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from "./util";
import Footer from "./components/Footer.vue";
import Header from "./components/Header.vue";

export default {
  components: {
    Footer,
    Header
    // Message,
    // Modal
  },
  computed: {
    errorCode() {
      return this.$store.state.error.code; // エラーstateを参照
    }
  },
  watch: {
    errorCode: {
      handler(val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push("/500");
        }
      },
      immediate: true
    },
    $route() {
      this.$store.commit("error/setCode", null);
    }
  }
};
</script>