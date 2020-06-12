<template>
  <div>
    <h5 class="card-title text-center">Use seu cupom de desconto aqui</h5>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroupPrepend">
          <i class="fa fa-gift" aria-hidden="true"></i>
        </span>
      </div>
      <input
        type="text"
        v-model="cupom"
        name="cupom"
        class="form-control"
        v-bind:class="{ 'is-invalid': errors, 'is-valid': success }"
        id="cupom"
        placeholder="Digite seu cupom aqui"
        aria-describedby="inputGroupPrepend"
        required
      />
      <button type="button" @click="useCupom()" class="btn btn-success" v-bind:disabled=" !loading ? disabled : ''">
        <span
          class="spinner-border spinner-border-sm"
          v-if="this.loading"
          role="status"
          aria-hidden="true"
        ></span>
        {{text_button}}
      </button>
      <div class="invalid-feedback">{{mesage_error}}</div>
      <div class="valid-feedback">Cumpo Utilizado com sucesso!</div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      cupom: null,
      loading: false,
      text_button: "Usar",
      errors: false,
      success: false,
      mesage_error: ""
    };
  },
  methods: {
    async useCupom() {
      this.success = false;
      this.errors = false;
      this.loading = true;
      await axios
        .post("http://localhost/api/discounts/cupom", {
          cupom: this.cupom
        })
        .then(response => {
          this.success = true;
        })
        .catch(error => {
          //exibindo erros de validação
          if (error.response.status === 422) {
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