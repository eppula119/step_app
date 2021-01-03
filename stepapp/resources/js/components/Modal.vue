<template>
  <div class="c-modal" v-if="modalShow">
    <deleteModal />
  </div>
</template>

<script>
import { mapState } from "vuex";
import deleteModal from "../components/deleteModal.vue";

export default {
  components: {
    deleteModal,
  },
  data() {
    return {};
  },
  computed: {
    ...mapState({
      modalShow: (state) => state.modal.modalFlg,
    }),
  },
  methods: {
    async modalClose() {
      this.$store.dispatch("modal/setmodalVal", false);
    },
  },
};
</script>