<template>
    <div class="container">
      <form @submit.prevent class="remove-record-model">
          <div class="modal-mask">
              <div class="modal-wrapper">
                  <div class="modal-container">
  
                  <div class="modal-header">
                     <h1>
                        حذف محصول
                     </h1>
                  </div>  
  
  
                  <div class="modal-body">
                      <slot name="body">
                          <h4>                      ایا از حذف این محصول اطمینان دارید؟
</h4>
                          <br>
                          اخطار: <p style="color:#ff0000;font-weight:700;">این عمل برگشت ندارد</p>
                      </slot>
                  </div>
  
                  <div class="modal-footer">
                      <slot name="footer">
                      <button class="btn mx-2 btn-secondary waves-effect waves-light" @click="$emit('close')">کنسل</button>
                      <button type="submit" class="btn btn-danger waves-effect waves-light" @click="$emit('delete')">حذف</button>
                      </slot>
                  </div>
                  </div>
              </div>
          </div>
      </form>
    </div>
  </template>
  
<script>


export default {
    name: "DeleteModal",

    data() {
        return {
            attributes: null,
            success: null,
            errors: null,
        };
    },
    methods: {

    },
    mounted() {

    }
};
</script>
  
  <style scoped>
  .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
  }
  form {
    direction: rtl;
    font-family: var(--thirdFont) !important;
  }
  .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
  }
  
  .modal-container {
    width: 600px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
  }
  
  .modal-header h3 {
    margin-top: 0;
    color: #42b983;
  }
  
  .modal-body {
    margin: 20px 0;
  }
  
  .modal-default-button {
    float: right;
  }
  
  /*
   * The following styles are auto-applied to elements with
   * transition="modal" when their visibility is toggled
   * by Vue.js.
   *
   * You can easily play with the modal transition by editing
   * these styles.
   */
  
  .modal-enter-from, .modal-leave-to {
    opacity: 0;
  }
  
  .modal-enter-active .modal-container,
  .modal-leave-active .modal-container {
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
  }
  
  </style>
  