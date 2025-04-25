<template>
   <div class="h-screen flex flex-col items-center justify-center root">
      <h1 class="text-6xl font-semibold my-4 text-slate-700">
        <span class="block mb-2">😕</span>
     
        Ошибка 500
      </h1>
      <p class='description text-slate-700 text-xl'>
        Сервер временно недоступен. Пожалуйста, попробуйте позже.
      </p>
    </div>
</template>

<script>
export default {

}
</script>

<style lang="scss" scoped>
.root {
  padding: 100px;
  max-width: 750px;
  margin: 0 auto;
  text-align: center;

  span {
    font-size: 64px;
  }
}

.description {
  font-size: 22px;
}
</style>