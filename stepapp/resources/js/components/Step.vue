<template>
  <div class="c-step p-step">
    <img :src="item.image" class="c-step__img" />

    <div class="c-itemCover">
      <p class="c-itemCover__outline">{{ item.title }}</p>
      <RouterLink
        class="c-itemCover__link"
        :to="`/steps/${item.id}`"
        :title="`View the photo by ${item.id}`"
      >
        詳細を見る
        <i class="fas fa-search-plus c-coverIcon"></i>
      </RouterLink>
    </div>

    <div class="c-step__wrap">
      <div class="c-faceicon">
        <img :src="item.user.icon" class="c-faceicon__img" />
      </div>
      <span class="c-stepTitle">{{ item.title }}</span>
      <div class="c-indexContainer">
        <span class="c-indexContainer__category c-category">{{ item.category.name }}</span>
        <div class="c-favContainer">
          <i class="fas fa-star c-favContainer__icon c-star"></i>
          <span class="c-favContainer__total">{{ item.category.name }}</span>
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
      required: true
    }
  }
};
</script>