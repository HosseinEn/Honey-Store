<template>
  <button
    @click="changeFilter('all')"
    :class="{ activeFilter: currentFilter === 'all' }"
  >
    همه
  </button>
  <button
    @click="changeFilter('mostDiscounted')"
    :class="{ activeFilter: currentFilter === 'mostDiscounted' }"
  >
    بیشترین تخفیف
  </button>
  <button
    @click="changeFilter('mostExpensive')"
    :class="{ activeFilter: currentFilter === 'mostExpensive' }"
  >
    گران ترین
  </button>
  <button
    @click="changeFilter('cheapest')"
    :class="{ activeFilter: currentFilter === 'cheapest' }"
  >
    ارزان ترین
  </button>
  <button
    @click="changeFilter('mostSale')"
    :class="{ activeFilter: currentFilter === 'mostSale' }"
  >
    مرتب سازی
  </button>
  <select
    name="honeyType"
    id="honeyType"
    v-model="honeyType"
    @change="onChange()"
  >
    <option value="a">a</option>
    <option value="b">b</option>
    <option value="c">c</option>
    <option value="d">d</option>
  </select>
</template>

<script>
export default {
  emits: ["handleFilter", "honeyTypeFunction"],
  props: ["currentFilter"],
  name: "FilterNav",
  methods: {
    changeFilter(by) {
      this.$emit("handleFilter", by);
    },
    onChange() {
      this.$emit("honeyTypeFunction", this.honeyType);
    },
  },
  data() {
    return {
      honeyType: "a",
    };
  },
};
</script>
<style scoped>
button {
  margin-left: 0.5rem;
  padding: 0.5rem;
  background-color: var(--thirdColor);
  border-radius: 10px;
  transition: all 0.5s linear;
}
select {
  margin-left: 0.5rem;
  padding: 0.5rem;
  background-color: var(--thirdColor);
  border-radius: 5px 5px 0px 0px;
}
.activeFilter {
  background-color: var(--secondColor) !important;
  color: var(--mainColor) !important;
}
</style>
