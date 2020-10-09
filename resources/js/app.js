require('./bootstrap');
import PrimaryNav from "./components/primaryNav"
import { createApp } from 'vue'

const app = createApp({})
app.component('primary-nav', PrimaryNav)

app.mount('#app')