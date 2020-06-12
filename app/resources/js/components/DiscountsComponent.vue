<template>
  <div>
    <h5 class="card-title">Coloque seu e-mail para receber mais novidades e boa sorte!</h5>
    <form class="form-inline" v-on:submit.prevent="getDiscount()">
      <div class="form-group mx-sm-3 mb-2">
        <label for="email" class="sr-only">E-mail</label>
        <input
          v-model="email"
          type="email"
          class="form-control"
          v-bind:class="{ 'is-invalid': errors }"
          id="email"
          name="email"
          placeholder="email@email.com"
        />
        <div class="invalid-feedback" v-if="this.errors">{{mesage_error}}</div>
      </div>
      <button
        type="submit"
        class="btn btn-success mb-2"
        v-bind:disabled=" !loading ? disabled : ''"
      >
        <span
          class="spinner-border spinner-border-sm"
          v-if="this.loading"
          role="status"
          aria-hidden="true"
        ></span>
        {{text_button}}
      </button>
    </form>
    <h5 class="card-title" v-if="this.desconto != '' ">
      O resultado foi:
      <strong>{{desconto}}</strong>
      <span>Seu cupom é {{cupom}} valido até {{deadline}}</span>
    </h5>
  </div>
</template>
<script>
export default {
  data() {
    return {
      email: null,
      errors: false,
      mesage_error: "",
      loading: false,
      text_button: "Sortear",
      desconto: "",
      cupom: '',
      deadline: ''
    };
  },
  props: ["discounts"],
  methods: {
    async getDiscount() {
      //parando seleção aleatoria
      this.$store._mutations.useDiscount[0]();
      this.errors = false;
      this.loading = true;
      this.text_button = "Aguarde...";
      //requisição para gerar código de desconto
      await axios
        .post("http://localhost/api/discounts/draw", {
          email: this.email
        })
        .then(response => {
          let res = response.data;
          //removendo dysplay
          for (let index = 0; index < this.discounts.length; index++) {
            this.discounts[index].classList.remove("bg-primary", "text-white");
          }

          this.desconto = res.discount;
          this.deadline = res.deadline;
          this.cupom = res.cupom;
          for (let index = 0; index < this.discounts.length; index++) {
            if (this.discounts[index].textContent == res.discount) {
              this.discounts[index].classList.add("bg-primary", "text-white");
              return false;
            }
          }
        })
        .catch(error => {
          //exibindo erros de validação
          if (error.response.status === 422) {
            this.$store._mutations.useDiscount[0]();
            this.errors = true;
            for (let index in error.response.data.errors) {
              this.mesage_error = error.response.data.errors[index][0];
            }
          }
        })
        .finally(() => {
          this.loading = false;
          this.text_button = "Sortear";
        });
    }
  }
};
</script>