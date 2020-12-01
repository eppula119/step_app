<template>
  <!--ーーーーーーーーーーーーーーーーーー STEP投稿画面表示 ーーーーーーーーーーーーーーーーーー-->
  <main class="l-main">
    <div class="l-bg p-stepForm">
      <form class="p-registerStep" @submit.prevent="submit">
        <span class="p-registerStep__errors" role="alert" v-if="errors">
          <ul v-if="errors.image">
            <li v-for="msg in errors.image" :key="msg">{{ msg }}</li>
          </ul>
        </span>
        <p class="p-registerStep__heading">タイトル</p>
        <input
          type="text"
          name="title"
          class="p-registerStep__title"
          v-model="title"
          placeholder="STEP名"
        />
        <span class="c-invalid p-titleMsg" role="alert">
          <strong>30文字以内で入力して下さい</strong>
        </span>

        <p class="p-registerStep__heading">内容</p>
        <textarea
          class="p-registerStep__content"
          name="content"
          　cols="30"
          　rows="10"
          v-model="content"
          placeholder="内容"
        ></textarea>
        <span class="c-invalid p-contentMsg" role="alert">
          <strong>1万文字以内</strong>
        </span>

        <p class="p-registerStep__heading">画像</p>
        <div class="p-fileContainer c-imgContainer--backgroundWhite">
          <label class="p-fileContainer__airDrop">
            ドラッグ＆ドロップ
            <input type="file" class="p-dropImg" name="image" @change="onFileChange" />
            <output class="p-outputImg" v-if="preview">
              <img class="p-outputImg__img" :src="preview" />
            </output>
          </label>
          <span class="c-invalid p-fileContainer__msg" role="alert">
            <strong>画像の容量は10MB以内に抑えてください。</strong>
          </span>
        </div>

        <p class="p-registerStep__heading">カテゴリー</p>
        <select name="category_id" class="p-registerStep__category" v-model="category_id">
          <option value="1" class="p-selectCategory">勉強</option>
          <option value="2" class="p-selectCategory">ダイエット</option>
          <option value="3" class="p-selectCategory">筋トレ</option>
          <option value="4" class="p-selectCategory">英会話</option>
          <option value="5" class="p-selectCategory">ギター</option>
          <option value="6" class="p-selectCategory">ビジネス</option>
          <option value="7" class="p-selectCategory">弁護士</option>
          <option value="8" class="p-selectCategory">その他</option>
        </select>

        <p class="p-registerStep__heading">目標時間(単位：時間)</p>
        <div class="p-registerStep__time">
          <input type="number" name="time" class="p-stepTime" v-model="time" placeholder="例：120" />
          <span class="c-invalid p-timeMsg" role="alert">
            <strong>小数点第1位まで入力可能です。</strong>
          </span>
        </div>
        <button type="submit" class="c-btnEntry c-btn">子STEP登録へ→</button>
      </form>
    </div>
  </main>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY, OK } from "../util";

export default {
  data() {
    return {
      preview: null,
      title: null,
      image: null,
      content: null,
      category_id: null,
      time: null,
      errors: null
    };
  },
  methods: {
    // フォームでファイルが選択されたら実行される
    onFileChange(event) {
      // 何も選択されていなかったら処理中断
      if (event.target.files.length === 0) {
        this.reset();
        return false;
      }

      // ファイルが画像ではなかったら処理中断
      if (!event.target.files[0].type.match("image.*")) {
        this.reset();
        return false;
      }

      // FileReaderクラスのインスタンスを取得
      const reader = new FileReader();

      // ファイルを読み込み終わったタイミングで実行する処理
      reader.onload = e => {
        // previewに読み込み結果（データURL）を代入する
        this.preview = e.target.result;
      };

      // データURL形式で受け取ったファイルを読み込む
      reader.readAsDataURL(event.target.files[0]);
      this.image = event.target.files[0];
    },
    // 入力欄の値とプレビュー表示をクリアするメソッド
    reset() {
      this.preview = "";
      this.image = null;
      this.$el.querySelector('input[type="file"]').value = null;
    },
    async submit() {
      console.log("送信開始");
      const formData = new FormData();

      formData.append("title", this.title);
      formData.append("image", this.image);
      formData.append("content", this.content);
      formData.append("category_id", this.category_id);
      formData.append("time", this.time);
      console.log("API通信開始！");
      const response = await axios.post("/api/register_step", formData);

      if (response.status === UNPROCESSABLE_ENTITY) {
        console.log("UNPROCESSABLE_ENTITYエラー");
        this.errors = response.data.errors;
        return false;
      }

      this.reset();

      if (response.status !== OK) {
        console.log("OKじゃ無いエラー");
        this.$store.commit("error/setCode", response.status);
        return false;
      }
      this.reset();

      // メッセージ登録
      this.$store.commit("message/setContent", {
        content: "STEPが投稿されました！",
        timeout: 5000
      });

      // stepのidをstoreへ登録
      console.log("response.dataの中身確認");
      console.log(response.data);
      console.log("step_idの中身確認");
      console.log(response.data.step_id);
      // this.$store.dispatch("step/setStepId", response.data.step_id);

      this.reset();
      this.$emit("input", false);
      console.log(response.data);
      this.$router.push(
        `/register_child/step=${response.data.step_id}/child=1`
      );
    }
  }
};
</script>