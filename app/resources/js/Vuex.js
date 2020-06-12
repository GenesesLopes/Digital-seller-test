import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const store = new Vuex.Store({
    state:{
        discount: false
    },
    mutations: {
        useDiscount: state => state.discount = !state.discount
    }
    
});

export default store;
