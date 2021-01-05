<template>
  <main class="l-main">
    <!--ーーーーーーーーーーーーーーーーーー プロフィール画面表示 ーーーーーーーーーーーーーーーーーー-->
    <div class="l-bg p-stepForm">
      <p class="p-stepForm__title">プロフィール</p>
      <form class="p-registerProfile" @submit.prevent="submit">
        <div class="p-fileContainer">
          <label class="p-fileContainer__airDrop"
            ><i class="fas fa-user p-userIcon"></i>ドラッグ＆ドロップ
            <input
              type="file"
              class="p-dropImg"
              name="image"
              @change="onFileChange"
            />
            <output class="p-outputImg" v-if="preview">
              <img class="p-outputImg__img" :src="preview" />
            </output>
          </label>

          <span
            class="c-invalid p-fileContainer__msg"
            role="alert"
            v-if="errors"
          >
            <ul v-if="errors.image">
              <li v-for="msg in errors.image" :key="msg">
                {{ msg }}
              </li>
            </ul>
          </span>
        </div>

        　　　　　
        <p class="p-registerProfile__heading">自己紹介</p>
        <textarea
          class="p-registerProfile__content"
          name="content"
          　cols="30"
          　rows="10"
          placeholder="内容"
          v-model="profile"
        ></textarea>

        <span class="c-invalid p-contentMsg" role="alert" v-if="errors">
          <ul v-if="errors.profile">
            1000文字以内
            <li v-for="msg in errors.profile" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </span>

        <span class="p-registerProfile__heading">メールアドレス</span>
        <input
          type="email"
          name="email"
          class="c-form__input is-invalid p-editEmail"
          value=""
          required
          autocomplete="email"
          autofocus
          placeholder="例：hogehoge@gmail.com"
          v-model="email"
        />

        <span class="c-invalid p-emaiMsg" role="alert" v-if="errors">
          <ul v-if="errors.email">
            <li v-for="msg in errors.email" :key="msg">
              {{ msg }}
            </li>
          </ul>
        </span>

        <button type="submit" class="c-btnEntry c-btn">登録</button>
      </form>
    </div>
  </main>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY, OK } from "../util";
import { mapState, mapGetters } from "vuex";

export default {
  //   props: {
  //     id: {
  //       type: String,
  //       required: true,
  //     },
  //   },
  data() {
    return {
      preview: "",
      image: "",
      profile: "",
      email: "",
      errors: {
        image: [],
        profile: [],
        email: [],
      },
    };
  },
  computed: {
    // ...mapGetters({
    //   // 現在、ログイン中かどうか参照
    //   isLogin: "auth/check",
    // }),
    // stepストアのstepsを参照
    ...mapState({
      // childs: (state) => state.step.childSteps,
      user: (state) => state.auth.user,
    }),
  },
  methods: {
    // フォームでファイルが選択されたら実行される
    onFileChange(event) {
      // 何も選択されていなかったら処理中断
      if (event.target.files.length === 0) {
        console.log("何も画像が選択されてないよ");
        this.reset();
        return false;
      }

      // ファイルが画像ではなかったら処理中断
      if (!event.target.files[0].type.match("image.*")) {
        this.errors.image = ["ファイル形式が画像タイプではありません"];
        console.log("ファイルが画像ではないよ");

        this.reset();
        return false;
      }

      // FileReaderクラスのインスタンスを取得
      const reader = new FileReader();

      // ファイルを読み込み終わったタイミングで実行する処理
      reader.onload = (e) => {
        // previewに読み込み結果（データURL）を代入する
        this.preview = e.target.result;
      };
      console.log("event.target.filesのなかみ");
      console.log(event.target.files[0]);

      // データURL形式で受け取ったファイルを読み込む
      reader.readAsDataURL(event.target.files[0]);
      this.image = event.target.files[0];
    },
    // 入力欄の値とプレビュー表示をクリアするメソッド
    reset() {
      this.preview = "";
      this.image = "";
      this.$el.querySelector('input[type="file"]').value = null;
    },
    // 更新する
    async submit() {
      console.log("送信開始");
      const formData = new FormData();

      formData.append("image", this.image);
      formData.append("profile", this.profile);
      formData.append("email", this.email);

      console.log(this.formData);
      console.log("編集API通信開始！");
      const response = await axios.post("/api/update_profile", formData);

      if (response.status === UNPROCESSABLE_ENTITY) {
        console.log("UNPROCESSABLE_ENTITYエラー");
        console.log("response.data");
        this.$store.commit("error/setCode", response.status);
        this.errors = response.data.errors;
        return false;
      }

      // this.reset();

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
        content: "プロフィールが更新されました！",
        timeout: 5000,
      });

      // stepのidをstoreへ登録
      console.log("response.dataの中身確認");
      console.log(response.data);
      console.log("user_idの中身確認");
      console.log(response.data.user_id);
      // this.$store.dispatch("step/setStepId", response.data.step_id);

      this.$emit("input", false);
      console.log(response.data);
      // this.$router.push(
      //   `/register_child/step=${response.data.step_id}/child=1`
      // );
    },
    // プロフィール情報を取得してデータを画面に表示
    async fetchProfile() {
      console.log("get通信開始");
      // const response = await axios.get("/api/profile");

      // if (response.status !== OK) {
      //   this.$store.commit("error/setCode", response.status);
      //   return false;
      // }
      // console.log("response.dataのなかみ");
      // console.log(response.data);
      this.profile = this.user.profile;
      this.preview = this.user.image;
      this.email = this.user.email;

      // 通信成功時、stepストアに子STEPを全てセット
      // this.$store.dispatch("step/setSteps", response.data.step);
      // this.$store.dispatch("step/setChildSteps", response.data.child);
    },
  },
  watch: {
    $route: {
      async handler() {
        await this.fetchProfile();
      },
      immediate: true,
    },
  },
};
</script>