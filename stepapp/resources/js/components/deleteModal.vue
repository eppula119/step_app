<template>
  <div class="c-overlay" v-show="deleteModalShow">
    <div class="c-overlay__content">
      <p class="p-modal_coment">
        本当に
        <br />
        <span class="p-modal_coment__bold">削除</span>しますか?
      </p>
      <button class="p-modal_btn" v-on:click="modalClose">キャンセル</button>
      <button class="p-modal_btn p-modal_btn_link" @click="stepDelete">
        削除
      </button>
    </div>
  </div>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY, OK } from "../util";
import { mapState } from "vuex";

export default {
  data() {
    return {};
  },
  computed: {
    ...mapState({
      step_id: (state) => state.modal.step_id,
      child_id: (state) => state.modal.child_id,
      modalShow: (state) => state.modal.modalFlg,
      deleteModalShow: (state) => state.modal.deleteModalFlg,
      user: (state) => state.auth.user,
    }),
  },
  methods: {
    async modalClose() {
      console.log("モーダル削除します");
      this.$store.dispatch("modal/setModalVal", false);
      this.$store.dispatch("modal/setDeleteModal", false);
    },
    // 入力欄の値をクリア
    reset() {
      this.errors = null;
    },
    async stepDelete() {
      console.log("STEP削除実行します");
      let response = null;
      if (this.step_id && !this.child_id) {
        console.log("STEP削除API通信開始！");
        // response = await axios.post(`/api/delete_step/${this.step_id}`);
        console.log(response.data.step_id);
      }

      if (!this.step_id && this.child_id) {
        console.log("子STEP削除API通信開始！");
        // response = await axios.post(`/api/delete_child/${this.step_id}`);
        console.log(response.data.step_id);
      }

      if (response.status === UNPROCESSABLE_ENTITY) {
        console.log("UNPROCESSABLE_ENTITYエラー");
        this.errors = response.data.errors;
        return false;
      }

      this.reset();

      if (response.status !== OK && response.status !== CREATED) {
        console.log("OKじゃじゃ無いエラー");
        console.log(response);
        console.log("response.dataのなかみ");
        console.log(response.data);
        this.$store.commit("error/setCode", response.status);
        return false;
      }
      this.reset();

      // メッセージ登録
      this.$store.commit("message/setContent", {
        content: "STEPが投稿されました！",
        timeout: 5000,
      });

      // stepのidをstoreへ登録
      console.log("response.dataの中身確認");
      console.log(response.data);
      console.log("step_idの中身確認");
      console.log(response.data.step_id);
      // this.$store.dispatch("step/setStepId", response.data.step_id);

      this.reset();
      this.modalClose();
      this.$emit("input", false);
      console.log(response.data);
      this.$router.push(
        `/register_child/step=${response.data.step_id}/child=1`
      );
    },
  },
};
</script>