<template>
    <nav>
        <ul class="pagination">
            <li v-if="pagination.current_page > 1">
                <a
                    href="#"
                    @click.prevent="changePage(pagination.current_page - 1)"
                >
                    قبلی
                </a>
            </li>
            <li
                v-for="page in pages"
                :key="page"
                :class="{ active: page == pagination.current_page }"
            >
                <a href="#" @click.prevent="changePage(page)">{{ page }}</a>
            </li>
            <li v-if="pagination.current_page < pagination.last_page">
                <a
                    href="#"
                    @click.prevent="changePage(pagination.current_page + 1)"
                >
                    بعدی
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    name: "Pagination",
    props: ["pagination"],
    methods: {
        changePage(page) {
            this.pagination.current_page = page;
            this.$parent.getItems(page);
        },
    },
    computed: {
        pages() {
            let from = this.pagination.current_page - 2;
            if (from < 1) from = 1;
            let to = from + 4;
            if (to >= this.pagination.last_page) to = this.pagination.last_page;
            const pagesArray = [];
            for (let page = from; page <= to; page++) {
                pagesArray.push(page);
            }
            return pagesArray;
        },
    },
};
</script>

<style>
nav {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

.pagination li {
    margin: 0 5px;
}

.pagination li a {
    display: block;
    padding: 5px 10px;
    border: 1px solid #ccc;
    color: #333;
    text-decoration: none;
}

.pagination li.active a {
    background-color: var(--mainColor);
    color: #fff;
}

.pagination li a:hover {
    background-color: #645735;
    color: #fff;
}
</style>
