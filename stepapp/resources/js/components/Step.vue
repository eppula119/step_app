<template>
  <div class="c-step p-step">
    <img :src="item.image" class="c-step__img" />

    <div class="c-itemCover">
      <RouterLink
        class="c-itemCover__link"
        :to="`/step_list/${item.id}`"
        :title="`View the photo by ${item.id}`"
      >
        <p class="c-itemCover__outline">{{ item.title }}</p>
        <span>詳細を見る<i class="fas fa-search-plus c-coverIcon"></i></span>
      </RouterLink>
    </div>

    <div class="c-step__wrap p-step__wrap">
      <div class="c-faceicon">
        <img :src="item.user.image" class="c-faceicon__img" />
      </div>
      <span class="c-stepTitle">{{ item.title }}</span>
      <div class="c-indexContainer">
        <span class="c-indexContainer__category c-category">{{
          item.category.name
        }}</span>
        <div class="c-favContainer">
          <i class="fas fa-heart c-favContainer__icon"></i>
          <span class="c-favContainer__total">{{ item.favorites_count }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      required: true,
    },
  },
};
</script>