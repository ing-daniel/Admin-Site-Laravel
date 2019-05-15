<template>
  <a-form
    :form="form"
    @submit="handleSubmit"
  >
  <a-spin tip="Enviando..." :spinning="spinning" :delay="delayTime">
    <div class="row align-items-center">
      <div class="col-3 text-right content-avatar">
        <a-avatar shape="square" :size="120" icon="user" />
      </div>
      <div class="col-9">
        <a-form-item
          label="Nombre"
          :label-col="{ span: 5 }"
          :wrapper-col="{ span: 12 }"
        >
          <a-input
            v-decorator="[
              'nombre',
              {rules: [{ required: true, message: 'Es necsario un nombre!' }]}
            ]"
          />
        </a-form-item>

        <a-form-item
          label="Email"
          :label-col="{ span: 5 }"
          :wrapper-col="{ span: 12 }"
        >
          <a-input
            v-decorator="[
              'correo',
              {rules: [{ required: true, message: 'Es necesario un correo!' }]}
            ]"
          />
        </a-form-item>

        <a-form-item
          label="Fecha Nacimiento"
          :label-col="{ span: 5 }"
          :wrapper-col="{ span: 12 }"
        >
          <a-date-picker @change="onChange" 
          v-decorator="[
            'fechaNacimiento',
            {rules: [{ required: true, message: 'Es necesario una fecha!' }]}
          ]"/>
        </a-form-item>        
      </div>
    </div>
    <div class="row">
      <div class="col-12 text-center">
        <a-form-item
          :wrapper-col="{ span: 24}"
        >
          <a-button
            type="primary"
            html-type="submit"
          >
            Enviar
          </a-button>
        </a-form-item>
      </div>
    </div>
    </a-spin>
  </a-form>
</template>

<script>
export default {
    data () {
        return {
            formLayout: 'horizontal',
            form: this.$form.createForm(this),
            spinning: false,
            delayTime: 500,
        };
    },
    methods: {
        onChange(date, dateString) {
            
        },
        handleSubmit (e) {
            e.preventDefault();
            this.form.validateFields((err, values) => {
                if (!err) {
                    this.spinning = true;
                    axios.post(`/api/personas`, 
                      {
                        nombre: values.nombre,
                        correo: values.correo,
                        fechaNacimiento: values.fechaNacimiento.format("YYYY-MM-DD"),
                      }) 
                      .then(response => {
                          this.form.resetFields();
                          this.$message.success(`La persona ${response.data.nombre} fue creada de manera correcta.`);
                          this.spinning = false;
                      }) 
                      .catch(error => alert("error"));
                }
            });
        }
    }
}
</script>

<style>
  .content-avatar .anticon-user{
        vertical-align: 0 !important;
        font-size: 90px !important;
  }
</style>
