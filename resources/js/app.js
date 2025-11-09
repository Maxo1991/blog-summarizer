import './bootstrap';
import { createApp } from 'vue'
import '../css/app.css'; 
import App from './App.vue'
import Summaries from './Pages/Summaries.vue'

const appEl = document.querySelector('#app')
if(appEl) {
    createApp(App).mount('#app')
}

const summariesEl = document.querySelector('#getSummaries')
if(summariesEl) {
    createApp(Summaries).mount('#getSummaries')
}