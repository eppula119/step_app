<template>
  <!--ーーーーーーーーーーーーーーーーーー 子STEP投稿画面表示 ーーーーーーーーーーーーーーーーーー-->
  <main class="l-main">
    <div class="l-bg p-stepForm">
      <p class="p-stepForm__title">猿でも分かる英会話</p>

      <form class="p-registerStep" @submit.prevent="submit">
        <div class="p-childForm">
          <p class="p-childForm__heading">子STEP1:タイトル</p>
          <input
            type="text"
            name="title"
            class="p-childForm__title"
            v-model="title"
            placeholder="STEP名"
          />
          <span class="c-invalid p-titleMsg" role="alert" v-if="errors">
            <ul v-if="errors.title">
              <li v-for="msg in errors.title" :key="msg">
                {{ msg }}
              </li>
            </ul>
          </span>

          <p class="p-childForm__heading">子STEP1:内容</p>
          <textarea
            class="p-childForm__content"
            name="content"
            　cols="30"
            　rows="10"
            v-model="content"
            placeholder="内容"
          ></textarea>
          <span class="c-invalid p-contentMsg" role="alert" v-if="errors">
            <ul v-if="errors.content">
              <li v-for="msg in errors.content" :key="msg">
                {{ msg }}
              </li>
            </ul>
          </span>

          <p class="p-childForm__heading">子STEP1:画像</p>
          <div class="p-fileContainer">
            <label class="p-fileContainer__airDrop">
              ドラッグ＆ドロップ
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

          <p class="p-childForm__heading">子STEP1:目標時間(単位：時間)</p>
          <div class="p-childForm__time">
            <input
              type="number"
              name="time"
              class="p-stepTime"
              v-model="time"
              placeholder="例：120"
            />
            <span class="c-invalid p-timeMsg" role="alert" v-if="errors">
              <ul v-if="errors.time">
                <li v-for="msg in errors.time" :key="msg">
                  {{ msg }}
                </li>
              </ul>
            </span>
          </div>
        </div>
        <button type="submit" class="c-btnEntry c-btn c-btn--white">
          登録して次の子STEPへ→
        </button>
        <div class="p-btnContainer" v-show="filterChilds.length !== 0">
          <button class="p-btnContainer__back" @click.prevent="onPrev">
            ←前の子ステップへ
          </button>
          <button class="p-btnContainer__next" @click.prevent="onNext">
            次の子ステップへ→
          </button>
        </div>
        <RouterLink class="p-linkMypage" :to="`/mypage`"
          >マイページへ
        </RouterLink>
      </form>
    </div>
  </main>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY, OK } from "../util";
import { mapState } from "vuex";

export default {
  data() {
    const perPage = 1; // 表示する子STEP件数
    return {
      step_id: Number(this.$route.params.step_id),
      preview: "",
      title: "",
      image: "",
      content: "",
      time: "",
      errors: {
        title: [],
        image: [],
        content: [],
        time: [],
      },
      page: 1, //　現在の子STEP番号
      perPage, // 表示する子STEP件数
      totalPage: null, // 総ページ数
      count: null, // 子STEPの総数
    };
  },
  computed: {
    // stepストアのstepsを参照
    ...mapState({
      childs: (state) => state.step.childSteps,
    }),
    filterChilds() {
      // 閲覧画面に表示させる子STEPを表示。(次の子STEP遷移機能)
      console.log("fileterchildsが変化した");
      console.log(this.childs);
      return this.childs.filter(
        (item, i) =>
          i >= (this.page - 1) * this.perPage && i < this.page * this.perPage
      );
    },
    prevPage() {
      return Math.max(this.page - 1, 1);
    },
    nextPage() {
      return Math.min(this.page + 1, this.totalPage);
    },
  },
  methods: {
    // フォームでファイルが選択されたら実行される
    onFileChange(event) {
      // 何も選択されていなかったら処理中断
      if (event.target.files.length === 0) {
        this.preview = "";
        this.image = "";
        this.$el.querySelector('input[type="file"]').value = null;
        return false;
      }
      // ファイルが画像ではなかったら処理中断
      if (!event.target.files[0].type.match("image.*")) {
        this.errors.image = ["ファイル形式が画像タイプではありません"];
        this.preview = "";
        this.image = "";
        this.$el.querySelector('input[type="file"]').value = null;
        return false;
      }
      // FileReaderクラスのインスタンスを取得
      const reader = new FileReader();
      // ファイルを読み込み終わったタイミングで実行する処理
      reader.onload = (e) => {
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
      this.title = "";
      this.image = "";
      this.content = "";
      this.time = "";
      this.$el.querySelector('input[type="file"]').value = null;
    },
    async submit() {
      console.log("送信開始");
      const formData = new FormData();
      let response = null;

      formData.append("step_id", this.step_id);
      formData.append("title", this.title);
      formData.append("image", this.image);
      formData.append("content", this.content);
      formData.append("time", this.time);

      console.log("子STEPAPI通信開始！");
      console.log(formData);
      console.log(formData.step_id);

      if (this.filterChilds.length !== 0) {
        // 編集の場合
        console.log(this.filterChilds[0]);
        console.log("子STEP編集API通信開始！");
        response = await axios.post(
          `/api/update_child/${this.filterChilds[0].id}`,
          formData
        );
      } else {
        console.log("新規子STEP登録API通信開始！");
        response = await axios.post("/api/register_child", formData); // 新規登録の場合
      }

      if (response.status === UNPROCESSABLE_ENTITY) {
        console.log("UNPROCESSABLE_ENTITYエラー");
        this.$store.commit("error/setCode", response.status);
        this.errors = response.data.errors;
        return false;
      }
      this.reset();
      if (response.status !== OK && response.status !== CREATED) {
        console.log("OKじゃ無いエラー");
        this.$store.commit("error/setCode", response.status);
        this.errors = response.data.errors;
        console.log("response.dataのなかみ");
        console.log(response.data);
        return false;
      }
      this.reset();
      // メッセージ登録
      this.$store.commit("message/setContent", {
        content: "子STEPが投稿されました！",
        timeout: 5000,
      });
      this.reset();
      if (this.filterChilds.length !== 0) {
        // 編集の場合
        return this.onNext();
      }
    },
    onPrev() {
      this.page = this.prevPage;
      return this.changeForm();
    },
    onNext() {
      console.log("次のページへクリックされたよ");
      this.page = this.nextPage;
      return this.changeForm();
    },
    changeForm() {
      this.title = this.filterChilds[0].title;
      this.content = this.filterChilds[0].content;
      this.preview = this.filterChilds[0].image;
      this.category_id = this.filterChilds[0].category_id;
      this.time = this.filterChilds[0].time;
    },
    fetchChildStep() {
      console.log("レスポンスデータ");
      // console.log(response.data.child);
      // this.$store.commit("step/setChildSteps", response.data.child);

      console.log("初期表示画面,this.childsのなかみ");
      console.log(this.childs);
      if (this.filterChilds.length !== 0) {
        console.log("fechChildStepが変化した");
        this.count = this.childs.length;
        console.log("トータルページ");
        this.totalPage = Math.ceil(this.childs.length / this.perPage);
        console.log(this.totalPage);

        this.title = this.filterChilds[0].title;
        this.content = this.filterChilds[0].content;
        this.preview = this.filterChilds[0].image;
        this.category_id = this.filterChilds[0].category_id;
        this.time = this.filterChilds[0].time;
      } else {
        console.log("新規子STEP画面表示中");
      }
    },
  },
  watch: {
    $route: {
      async handler() {
        await this.fetchChildStep();
      },
      immediate: true,
    },
  },
};
</script>