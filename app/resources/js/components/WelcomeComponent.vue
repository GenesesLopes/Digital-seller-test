<template>
  <div class="card-body">
    <div class="d-flex flex-row justify-content-center mb-3" ref="div_discounts">
      <div class="p-2" v-for="discount in discounts" :key="discount.name">{{discount.name}}</div>
    </div>
    <div class="row">
      <div class="col-md-6">
          <discounts v-bind:discounts="this.element"></discounts>
      </div>
      <div class="col-md-6">
        <cupom></cupom>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from 'vuex';
export default {
  data() {
    return {
      discounts: null,
      element: null,
    };
  },
  computed: {
    ...mapState({
          discount: state => state.discount
      })
  },
  mounted() {
    //recuperar descontos
    this.getDiscounts();
    this.element = this.$refs.div_discounts.children;
    this.randonDiscount();    
  },
  methods: {
    randonDiscount() {
      window.setInterval(() => {
        //verificando se já houve sorteio
        if (!this.$store.state.discount) {
          //Selecionar desconto
          let childrenDiscountRandom = Math.floor(
            Math.random() * this.discounts.length
          );
          //recuperar desconto na VirtualDOM e remover classes de display
          let discounts_html = this.$refs.div_discounts.children;
          for (let index = 0; index < discounts_html.length; index++) {
            discounts_html[index].classList.remove("bg-primary", "text-white");
          }
          //adicionando classes de display no desconto
          discounts_html[childrenDiscountRandom].classList.add(
            "bg-primary",
            "text-white"
          );
        }
      }, 1500);
      
    },
    getDiscounts() {
      axios
        .get("http://localhost/api/discounts")
        .then(response => {
          this.discounts = response.data;
        })
    }
  }
};
</script>
