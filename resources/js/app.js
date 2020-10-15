require('./bootstrap');
import PrimaryNav from "./components/primaryNav"
import Grid from "./components/Grid"
import Pagination from "./components/Pagination"
import SelectMenu from "./components/SelectMenu"
import DebounceInput from "./components/DebounceInput"
import Dropdown from "./components/Dropdown"
import Clip from "./components/Clip"
import Card from "./components/Card"
import Carousel from "./components/Carousel"
import Comments from "./components/Comments"
import Comment from "./components/Comment"
import PostComment from "./components/PostComment"
import { createApp } from 'vue'

const app = createApp({})
app.component('primary-nav', PrimaryNav)
app.component('grid', Grid)
app.component('pagination', Pagination)
app.component('select-menu', SelectMenu)
app.component('debounce-input', DebounceInput)
app.component('dropdown', Dropdown)
app.component('clip', Clip)
app.component('card', Card)
app.component('carousel', Carousel)
app.component('comments', Comments)
app.component('comment', Comment)
app.component('post-comment', PostComment)

app.directive('click-outside', {
    beforeMount(el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
            // here I check that click was outside the el and his children
            if (!(el == event.target || el.contains(event.target))) {
                binding.value(event)
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
    },
    unmounted(el) {
        document.body.removeEventListener('click', el.clickOutsideEvent)
    },
});

app.mount('#app')
