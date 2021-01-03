<template>
  <div class="c-step p-step">
    <img :src="item.image" alt="" class="c-step__img" />

    <div class="c-itemCover">
      <p class="c-itemCover__outline">{{ item.title }}</p>
      <RouterLink
        class="c-itemCover__link"
        :to="`/step_list/${item.id}`"
        :title="`View the photo by ${item.id}`"
      >
        詳細を見る
        <i class="fas fa-search-plus c-coverIcon"></i>
      </RouterLink>
    </div>

    <div class="c-step__wrap p-step__wrap p-step__wrap--big">
      <div class="c-faceicon">
        <img :src="item.user.image" class="c-faceicon__img" />
      </div>
      <span class="c-stepTitle">{{ item.title }}</span>
      <div class="p-gaugeContainer">
        <span class="p-stepPercent"
          >{{ lengths.cleared }}個クリア済み/残り{{ lengths.left }}個</span
        >
        <div class="p-gauge">
          <span class="p-gauge__label">{{ gauge.left }}%</span>
          <span class="p-gauge__fill" :style="styles">
            <span class="p-gauge__fill--label">{{ gauge.cleared }}%</span>
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      lengths: {
        cleared: 0,
        left: "",
      },
      gauge: {
        cleared: 0,
        left: 100,
      },
    };
  },
  computed: {
    styles() {
      let childs = this.item.child_steps; // １つのSTEPに基づく全ての子STEP
      let cleared = childs.filter(function (child) {
        // クリア済みの子STEPのみ抽出
        return child.cleared.length > 0;
      });

      let width = (cleared.length / childs.length) * 100; //  子STEPの総数 ÷ クリア済み子STEP ✖️ 100
      this.lengths.cleared = cleared.length;
      this.gauge.cleared = Math.floor(width);
      this.gauge.left = 100 - this.gauge.cleared; // 未達成子STEPパーセンテージ
      this.lengths.left = childs.length - cleared.length; // 未達成子STEPの個数
      return {
        width: width + "%",
      };
    },
  },
  watch: {
    $route: {
      async handler(to, from) {
        console.log(from);
        console.log("$チャレンジステップが変わった");
        // await this.fetchSteps(); // api通信開始メソッド実行
        console.log(to);
      },
      immediate: true, // 起動時にも実行
    },
  },
};
</script>